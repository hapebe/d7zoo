<?php

/**
 * makes animations of a rotating HSL bicone "histogram"
 *
 * @author hapebe
 */
class ColorAnalyzer1 {
    /**
     * @var \GDContext
     */
    public $gdc;
    
    /**
     * calculated stats of the image
     * @var \ImgData
     */
    public $imgData;
    
    /**
     * filename of the underlying image ("naked name")
     * @var string
     */
    public $name;
    
    /**
     * name/value pairs of analysis-related config settings
     * @var array 
     */
    public $config;

    function __construct($gdc, $imgData = FALSE, $name = FALSE) {
	$this->gdc = $gdc;
	
	if ($imgData != FALSE) {
	    $this->imgData = $imgData;
	} else {
	    $this->imgData = new ImgData();
	}
	
	if ($name != FALSE) {
	    $this->name = $name;
	} else {
	    $this->name = 'colorAnalysis';
	}
	
	$this->config = array(
	    'EXCLUDE_LIMIT' => 1 / 10, // exclude the less scored ... pixels from analysis.
	    'MIN_CLUSTER_PIXEL_PORTION' => 0.01 / 100, // minimum color space cluster portion of the image
	    'MAX_ACCEPTABLE_CLUSTER_DELTA' => 0.12, // maximum acceptable visual delta between color cluster for merging
	    'MAX_ACCEPTABLE_DELTA_WHEN_DROPPING' => 0.3, // maximum accpetable cumulated difference between clusters, when dropping colors in the end...
	    'MIN_ACCEPTABLE_CONTRASTING_DISTANCE' => 0.20, // minimum acceptable distance from a contrasting color to any base color:
	    // '' => , // 
	);
	
	$this->config['FILE_BASE_PATH'] = drupal_realpath(file_default_scheme() . '://') . '/ia';
    }
    
    function getConfig($name) {
	if (!isset($this->config[$name])) {
	    drupal_set_message(t('%file @ %line : config value %name is not set.', array('%file' => __FILE__, '%line' => __LINE__, '%name' => $name)), 'error');
	    return FALSE;
	}
	return $this->config[$name];
    }

    /**
     * makes chart pictures for animation / video of a rotating HSL bicone containing a "histogram" of the input image
     * @return string HTML content to be shown as a result
     */
    function analyzeColors() {
    // $p = Profiler::getInstance(); $p->log_mode = -1;
    // $path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_path() . drupal_get_path('module', 'hapebe_img_analytics') . '/';
    $retval = array();
    set_time_limit(1200);

    /*
      algorithm:
      exclude EXCLUDE_LIMIT portion of less saturated pixels,
      calculate histogramm in 72000 color space areas,
      take most populated areas down to a portion of MIN_CLUSTER_PIXEL_PORTION,
      hierarchical cluster, until MAX_ACCEPTABLE_CLUSTER_DELTA is reached,
      select N (3) largest portion color space areas, take them for "base colors",
      (or: take as many "base colors" as needed for 33% of the image, but at least enough to cover 25% of the image)
      drop clusters until MAX_ACCEPTABLE_COMMUNALITY is reached,
      take the remaining space areas as "contrasting colors",
      remove from "contrasting colors" the one with least saturation * value score,
      remove from "contrasting colors" such colors, which are too similar to any base color.
     */

    $gdc = $this->gdc;
    $im = $this->gdc->im;
    $width = $this->gdc->w;
    $height = $this->gdc->h;
    $pxCount = $width * $height; 
    { // calculate include scores and average color:
	$includeScores = array();
	for ($x = 0; $x < $width; $x++) {
	    for ($y = 0; $y < $height; $y++) {
		$c = new Color(Color::GD2RGB(ImageColorAt($im, $x, $y)));

		$includeScores[$x . ';' . $y] = $c->chroma2;
	    }
	}
	
	// this was computed by StandardImageAnalyzer::makeHistogramData():
	if (isset($this->imgData->colorData['averageColorRGB'])) {
	    $avgC = $this->imgData->colorData['averageColorRGB'];
	    $retval[] = '<p>Average RGB color: <span style="background-color:#' . $avgC->getCC() . '">' . $avgC->toString() . '</span></p>';
	}

	asort($includeScores); // $p->log_sentinel("computed includeScores");
    }

    /* @var $mode int */
    $mode = -1; // quick / draft / debug
    // $mode = 0; // normal / production quality

    $chartWidth = 640;
    $chartHeight = 400;
    if ($mode == -1) {
	$chartWidth = 320;
	$chartHeight = 200;
    }

    // scaled-to-fit version of the original image:
    $factor = $chartHeight / $this->gdc->h;
    $newX = floor($this->gdc->w * $factor + 0.5);
    // round to next multiple of 4:
    $newX = floor($newX / 4 + 0.5) * 4;
    $newY = floor($this->gdc->h * $factor + 0.5);
    $rescaled = ImageCreateTrueColor($newX, $newY);
    ImageCopyResampled($rescaled, $im, 0, 0, 0, 0, $newX, $newY, $this->gdc->w, $this->gdc->h);
    $retval[] = GDTools::WriteAndGetHtml($rescaled, 'rescaled');


    $colorSpace = new ColorSpaceHolder();
    $colorSpace->setHSVResolution(90, 20, 50);
    if ($mode == -1)$colorSpace->setHSVResolution(36, 10, 20);

    // compute color space
    $i = 0;
    $black = $gdc->getSetColorRGB(0, 0, 0);
    foreach ($includeScores as $coords => $s) {
	// regardless of includeScore, at the moment we include all pixels for the color space chart(s)
	list($x, $y) = explode(';', $coords);

	$c = new Color(Color::GD2RGB(imagecolorat($im, $x, $y)));
	$colorSpace->addPixel($c->h, $c->s, $c->v);

	$i++;
    }

    $steps = 360;
    if ($mode == -1) $steps = 60;
    $filename = $this->getConfig('FILE_BASE_PATH').'/chart.png';
    
    
    $colorSpace->toImg($filename, $chartWidth, $chartHeight, $steps);
    
    $charts = $colorSpace->chartFileList;
    sort($charts); // lowest frame numbers first

    // $retval[] = implode("<br>\n", $charts);

    $this->makeChartAnimScript($charts, $this->name, $chartWidth + $newX, $chartHeight);

    // $p->log_sentinel("computed colorSpace (graphics / charts)");
    
    return implode("\n", $retval);
}

function makeChartAnimScript($chartList, $imgFileName, $width, $height) {
    $FILE_BASE_PATH = drupal_realpath(file_default_scheme() . '://');
    $FILE_BASE_PATH .= '/ia';
    $FILE_BASE_PATH = str_replace("/", "\\", $FILE_BASE_PATH);
    
    $VIRTUAL_DUB = 'C:\\ia\\vd\\VirtualDub.exe';
    $BMP2AVI = 'C:\\ia\\bmp2avi\\EasyBMPtoAVI.exe';
    $IMAGICK = 'C:\\Program Files\\ImageMagick-6.8.9-Q16\\';


    // file list for EasyBMPtoAVI
    $f = fopen($FILE_BASE_PATH.'/filelist.txt', 'w');
    $s = implode("\r\n", $chartList);
    $s = str_replace('.png', '-comp.bmp', $s);
    fputs($f, $s);
    fclose($f);

    $f = fopen($FILE_BASE_PATH.'\process.cmd', 'w');
    fputs($f, 'C:'."\r\n");
    fputs($f, 'cd \\ia\\temp'."\r\n");
    fputs($f, 'copy '.$FILE_BASE_PATH.'\\rescaled.jpg . /y'."\r\n");
    fputs($f, 'copy '.$FILE_BASE_PATH.'\\chart-*.png . /y >nul'."\r\n");
    fputs($f, 'del '.$FILE_BASE_PATH.'\\chart-*.png'."\r\n");
    fputs($f, ''."\r\n");
    foreach($chartList as $name) {
	$pngName = basename($name);
	$bmpName = str_replace('png', 'bmp', $pngName);
	$compName = str_replace('.png', '-comp.bmp', $pngName);
	// fputs($f, '"C:\Program Files\ImageMagick-6.7.0-Q16\convert" '.$pngName.' '.$bmpName."\r\n");
	// fputs($f, '"C:\Program Files\ImageMagick-6.7.0-Q16\montage" '.$bmpName.' rescaled.jpg '.$compName."\r\n");

	fputs($f, '"'.$IMAGICK.'mogrify" +append -extent '.$width.'x'.$height.' -format bmp '.$pngName."\r\n");
	fputs($f, '"'.$IMAGICK.'composite" -gravity East rescaled.jpg '.$bmpName.' '.$compName."\r\n");
    }
    fputs($f, 'del *.png'."\r\n");
    fputs($f, 'del rescaled.jpg'."\r\n");
    fputs($f, "\r\n");
    fputs($f, 'copy '.$FILE_BASE_PATH.'\\filelist.txt . /y'."\r\n");
    fputs($f, $BMP2AVI.' -filelist filelist.txt -framerate 25 -output out.avi'."\r\n");
    fputs($f, 'del *.bmp'."\r\n");
    fputs($f, 'del filelist.txt'."\r\n");
    fputs($f, $VIRTUAL_DUB.' /s colorspace-convert.vcf /p out.avi '.basename($imgFileName).'.avi /r /x'."\r\n");
    fputs($f, 'del out.avi'."\r\n");

    fputs($f, "\r\n");
    fputs($f, 'REM animated GIF output:'."\r\n");
    fputs($f, 'REM "'.$IMAGICK.'convert" -delay 4 chart-???.png -fuzz 40% -map colormap_332.png anim.miff'."\r\n");
    fputs($f, 'REM "'.$IMAGICK.'convert" anim.miff -delay 4 -coalesce +dither -layers OptimizeTransparency anim-opt.gif'."\r\n");

    fclose($f);
}


}
