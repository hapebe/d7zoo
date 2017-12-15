<?php

class StandardImageAnalyzer extends ImageAnalyzer {
    /** contains GD image used below threshold / range of maps */
    public $loImage;
    /** contains GD image used below threshold / range of maps */
    public $hiImage;
    
    /**
     * a GDContext object created by one of the make... functions
     * @var \GDContext
     */
    public $outGdContext;
    
    /**
     *
     * @var \ImgData instance of ImgData for the image in scope
     */
    public $imgData;

    function StandardImageAnalyzer($im, $imgData = FALSE) {
        $this->im = $im;
        $this->w = ImageSX($this->im);
        $this->h = ImageSY($this->im);
	
	if ($imgData == FALSE) {
	    $this->imgData = new ImgData();
	} else {
	    $this->imgData &= $imgData;
	}
	$this->imgData->w = $this->w;
	$this->imgData->h = $this->h;
    }

    /**
     * Color channel intensity map image:
     * @param string $mode
     * @param array $params
     * @return GD resource / image result
     */
    function makeRGBChannelMap($mode = FALSE, $params = FALSE) {
        $gdc = $this->outGdContext;
        
        $channel = substr($mode, 0, 1);
        $colors = array();
        if ($params['channelMode'] == 'greyscale') {
            for ($i = 0; $i < 256; $i++)
                $colors[$i] = $gdc->getSetColorRGB($i, $i, $i);
        } elseif ($params['channelMode'] == 'owncolor') {
            for ($i = 0; $i < 256; $i++) {
                if ($channel == 'r')
                    $colors[$i] = $gdc->getSetColorRGB($i, 0, 0);
                if ($channel == 'g')
                    $colors[$i] = $gdc->getSetColorRGB(0, $i, 0);
                if ($channel == 'b')
                    $colors[$i] = $gdc->getSetColorRGB(0, 0, $i);
            }
        } else {
            drupal_set_message(t('Unexpected channel mode in makeRGBChannelMap().'), 'error');
            return FALSE;
        }

        for ($x = 0; $x < $this->w; $x++) {
            for ($y = 0; $y < $this->h; $y++) {
                $rgb = ImageColorAt($this->im, $x, $y);
                $rgb = array(
                    'r' => ($rgb >> 16) & 0xFF,
                    'g' => ($rgb >> 8) & 0xFF,
                    'b' => $rgb & 0xFF,
                );
                
                $v = $rgb[$channel];
                
                // the original color of this pixel:
                $c = $colors[$v];
                
                if (isset($params['range'])) {
                    $c2 = $this->outOfRangeColor($v, $params['range'], $x, $y);
                    if ($c2 !== FALSE) $c = $gdc->getSetColorCC($c2);
                }

                ImageSetPixel($gdc->im, $x, $y, $c);
            }
        }
        return $gdc->im;
    }
    
    /**
     * if $v is out of the given range, return replacement color code
     * @param type $v
     * @param type $range
     * @return CC (HTML style hex color code)
     */
    function outOfRangeColor($v, $range, $x, $y) {
        if ($v < $range[0]) {
            $rgb = ImageColorAt($this->loImage, $x, $y);
            return Color::GD2CC($rgb);
        }
        if ($v > $range[1]) {
            $rgb = ImageColorAt($this->hiImage, $x, $y);
            return Color::GD2CC($rgb);
        }
        
        return FALSE;
    }
    

    /**
     * @return either an Image resource containing the result or (if $mode === FALSE) an array containing the available processing modes
     */
    function makeMap($mode = FALSE, $params = FALSE) {
        if ($mode === FALSE) {
            return array(
                'ri', 'gi', 'bi', // separate color intensity (greyscale image)
                'rc', 'gc', 'bc', // separate color channels (monochrome image)
                'chroma', 'chroma1', 'chroma2', // chroma map (greyscale image)
                'hue', // hue map (colored image)
            );
        }
        
        $im2 = ImageCreateTrueColor($this->w, $this->h);
        $this->outGdContext = new GDContext($im2);
        
        if (!is_array($params)) $params = array();

	if (isset($params['range'])) {
	    $silo = new SymbolicImage($this->w, $this->h);
	    $this->loImage = $silo->getIm('low'); // header('Content-Type: image/png'); ImagePNG($this->loImage); exit;
	    $sihi = new SymbolicImage($this->w, $this->h);
	    $this->hiImage = $sihi->getIm('high'); // header('Content-Type: image/png'); ImagePNG($this->hiImage); exit;
	}
	
	
        if (($mode == 'ri') or ( $mode == 'gi') or ( $mode == 'bi')) {
            // greyscale color channel map:
            $params['channelMode'] = 'greyscale';
            return $this->makeRGBChannelMap($mode, $params);
        }

        if (($mode == 'rc') or ( $mode == 'gc') or ( $mode == 'bc')) {
            // separated color channel map:
            $params['channelMode'] = 'owncolor';
            return $this->makeRGBChannelMap($mode, $params);
        }

        if (($mode == 'chroma') or ( $mode == 'chroma1') or ( $mode == 'chroma2')) {
            // chroma intensity map:
            $gdc = $this->outGdContext;
            
            for ($x = 0; $x < $this->w; $x++) {
                for ($y = 0; $y < $this->h; $y++) {
                    $rgb = Color::GD2RGB(ImageColorAt($this->im, $x, $y));
                    $c = new Color($rgb['r'], $rgb['g'], $rgb['b']);
                    
                    $v = $c->chroma;
                    if ($mode == 'chroma1') $v = $c->chroma1;
                    if ($mode == 'chroma2') $v = $c->chroma2;
                    
                    $idx = floor($v * 255 + 0.5);
                    $c = $gdc->getSetColorRGB($idx, $idx, $idx);
		    if (isset($params['channelMode'])) {
			if ($params['channelMode'] == 'originalImg') $c = $gdc->getSetColorRGB ($rgb);
		    }
                    
                    if (isset($params['range'])) {
			$c2 = $this->outOfRangeColor($v, $params['range'], $x, $y);
			if ($c2 !== FALSE) {
			    $c = $gdc->getSetColorCC($c2);
			}
		    }

                    ImageSetPixel($im2, $x, $y, $c);
                }
            }
            return $gdc->im;
        }

        if ($mode == 'hue') {
            // hue map:
            $chromaCutOff = -0.01; // paint a pixel as greyscale, if chroma is less than this value
            if (is_array($params)) {
                if (isset($params['chromaCutOff']))
                    $chromaCutOff = $params['chromaCutOff'];
            }

            $im2 = ImageCreateTrueColor($this->w, $this->h);
            $colors = array();
            for ($i = 0; $i < 360; $i++) {
                $rgb = Color::RGB4HSV($i, 0.8, 1);
                $colors[$i] = ImageColorAllocate($im2, $rgb['r'], $rgb['g'], $rgb['b']);
            }
            for ($i = 0; $i < 256; $i++)
                $colors[1000 + $i] = ImageColorAllocate($im2, $i, $i, $i);

            for ($x = 0; $x < $this->w; $x++) {
                for ($y = 0; $y < $this->h; $y++) {
                    $gdRGB = ImageColorAt($this->im, $x, $y);
		    $rgb = Color::GD2RGB($gdRGB);
                    $c = new Color($rgb['r'], $rgb['g'], $rgb['b']);

                    if ($c->chroma2 > $chromaCutOff) {
                        $idx = floor($c->h);
                        ImageSetPixel($im2, $x, $y, $colors[$idx]);
                    } else {
                        $idx = floor($c->v * 255 + 0.5);
                        ImageSetPixel($im2, $x, $y, $colors[1000 + $idx]);
                    }
                }
            }
            return $im2;
        }


        return FALSE;

    }

    /**
     * @return either an Image resource containing the result or (if $mode === FALSE) an array containing the available processing modes
     */
    function makeHistogram($mode = FALSE, $params = FALSE) {
        if ($mode === FALSE) {
            return array(
                'r', 'g', 'b', // separate color intensity
                'l', // luminance
                's', // HSV saturation
                'chroma', 'chroma1', 'chroma2', // chroma map (greyscale image)
                'hue', // hue map (colored image)
            );
        }
        if (!isset($this->imgData->histData[$mode]['freqs'])) {
            drupal_set_message(t('Histogram data for mode %mode is not available.', array('%mode' => $mode)), 'error');
            return FALSE;
        }
	
	$histData = $this->imgData->histData[$mode];


        if (($mode == 'l') or ( $mode == 's') or ( $mode == 'chroma') or ( $mode == 'chroma1')) {
            $h = new Histogram($histData);
            $im2 = $h->paint(512, 256);
        }

        if ($mode == 'chroma2') {
	    $histData['vars'] = array(
		'range' => array(0.2, 0.5, 0.8),
	    );
            $h = new RangedHistogram($histData);
            $gdc = $h->paint(512, 256);
	    if (!is_object($gdc)) {
		drupal_set_message(t('%file @ %line : RangedHistogram (%mode) failed...', array('%file' => __FILE__, '%line' => __LINE__, '%mode' => $mode)), 'error');
		return FALSE;
	    }
	    
	    $txt = 'chroma';
	    $bb = imagettfbbox(12, 0, $gdc->font, $txt);
	    $txtH = $bb[3] - $bb[7];
	    $txtW = $bb[4] - $bb[0];
	    $c = $gdc->getSetColorCC('eeeeee');
	    imagettftext($gdc->im, 12, 0, 10, 10 + $txtH/2, $c, $gdc->font, $txt);
	    imagettftext($gdc->im, 8, 0, 10 + $txtW + 2, 10 + $txtH - 2, $c, $gdc->font, '2');
	    $im2 = $gdc->im;
        }

        if (($mode == 'r') or ( $mode == 'g') or ( $mode == 'b')) {
            $h = new Histogram($histData);
            $im2 = $h->paint(512, 256);
        }

        if ($mode == 'hue') {
            $h = new CircularHueHistogram($histData);
            $im2 = $h->paint(512, 512);
        }



        return $im2;
    }

    function makeHistogramData($params = FALSE) {
        $res1 = 256;
        $rd = array();
        $gd = array();
        $bd = array();
        $ld = array();
        $sd = array();
        $cd = array();
        $c1d = array();
        $c2d = array();
        for ($i = 0; $i < $res1; $i++) {
            $rd[$i] = 0;
            $gd[$i] = 0;
            $bd[$i] = 0;
            $ld[$i] = 0;
            $sd[$i] = 0;
            $cd[$i] = 0;
            $c1d[$i] = 0;
            $c2d[$i] = 0;
        }

        // hue data with a resolution of 360 bins:
        $res1 = 360;
        $hd = array();
        for ($i = 0; $i < $res1; $i++)
            $hd[$i] = 0;

        $chromaSum = 0;
	
	$rSum = 0;
	$gSum = 0;
	$bSum = 0;

        for ($x = 0; $x < $this->w; $x++) {
            for ($y = 0; $y < $this->h; $y++) {
                $rgb = ImageColorAt($this->im, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $c = new Color($r, $g, $b);

                // results in a value of 0..255
                $l = floor($c->l * 255 + 0.5);
                $s = floor($c->s * 255 + 0.5);
                $chroma = floor($c->chroma * 255 + 0.5);
                $chroma1 = floor($c->chroma1 * 255 + 0.5);
                $chroma2 = floor($c->chroma2 * 255 + 0.5);

                // value of 0..359
                $h = $c->h;
                $hueImpact = $c->chroma1; // echo $hueImpact."\n"; exit;
                $chromaSum += $c->chroma1;
		
		$rSum += $r;
		$gSum += $g;
		$bSum += $b;

                $rd[$r] ++;
                $gd[$g] ++;
                $bd[$b] ++;
                $ld[$l] ++;
                $sd[$s] ++;
                $cd[$chroma] ++;
                $c1d[$chroma1] ++;
                $c2d[$chroma2] ++;
                $hd[$h] += $hueImpact;
            }
        }
	
	$px = $this->w * $this->h;
	$this->imgData->colorData['averageColorRGB'] = new Color(round($rSum / $px), round($gSum / $px), round($bSum / $px));


        $this->imgData->addHistData('r', 
	    array('freqs' => $rd,)
	);
        $this->imgData->addHistData('g', 
	    array('freqs' => $gd,)
	);
        $this->imgData->addHistData('b', 
	    array('freqs' => $bd,)
	);
        $this->imgData->addHistData('l', 
	    array('freqs' => $ld,)
	);
        $this->imgData->addHistData('s', 
	    array('freqs' => $sd,)
	);
	
        $this->imgData->addHistData('chroma', 
	    array('freqs' => $cd,)
	);
        $this->imgData->addHistData('chroma1', 
	    array('freqs' => $c1d,)
	);
        $this->imgData->addHistData('chroma2', 
	    array('freqs' => $c2d,)
	);
	
        $this->imgData->addHistData('hue', 
	    array(
		'freqs' => $hd,
		'vars' => array(
		    'chromaAvg' => $chromaSum / ($this->w * $this->h),
		),
	    )
        );
	
	$set = array('r', 'g', 'b', 'l', 's', 'chroma', 'chroma1', 'chroma2');
        foreach ($set as $dimension) {
            if (!isset($this->imgData->histData[$dimension]['vars'])) $this->imgData->histData[$dimension]['vars'] = array();

            $freqs = $this->imgData->histData[$dimension]['freqs']; // print_r($freqs); exit;

            $total = array_sum($freqs);
            $n = count($freqs);

            $pixelsInThirds = array();
            $sum = 0;
            for ($i = 0; $i < $n; $i++) {
                $sum += $freqs[$i];
                if ($i > ($n / 3)) {
                    if (!isset($pixelsInThirds[0])) {
                        $pixelsInThirds[0] = $sum / $total;
                        $sum = 0;
                    }
                }
                if ($i > ($n * 2 / 3)) {
                    if (!isset($pixelsInThirds[1])) {
                        $pixelsInThirds[1] = $sum / $total;
                        $sum = 0;
                    }
                }
            }
            $pixelsInThirds[2] = $sum / $total;

            $this->imgData->histData[$dimension]['vars']['pixelsInThirds'] = $pixelsInThirds;

            $this->imgData->histData[$dimension]['vars']['quantiles'] = new Quantiles($freqs); // print_r($this->histData[$dimension]['vars']['quantiles']); exit;
        }

        // binning for hue - 72 bins out of 360:
        $slices = 72;
        $newHue = array();
	$freqs = $this->imgData->histData['hue']['freqs'];
        $a = count($freqs) / $slices;
        for ($i = 0; $i < $slices; $i++) {
            $newHue[$i] = 0;
            for ($j = $i * $a; $j < ($i + 1) * $a; $j++) {
                $newHue[$i] += $freqs[$j];
            }
        } // print_r($newHue); exit;
        $this->imgData->histData['hue']['freqs'] = $newHue;

	
	$this->calcChromacityScore();
    }

    /**
     * calculates a rating value about how colorful or not the image is
     */
    function calcChromacityScore() {
	if (!isset($this->imgData->histData['chroma2'])) {
	    drupal_set_message(t('%file @ %line : Histogram data for mode chroma2 is not available.', array('%file' => __FILE__, '%line' => __LINE__)), 'error');
	    return FALSE;
	}
	if (!isset($this->imgData->histData['chroma2']['freqs'])) {
	    drupal_set_message(t('%file @ %line : Histogram data for mode chroma2 is not available.', array('%file' => __FILE__, '%line' => __LINE__)), 'error');
	    return FALSE;
	}
	$freqs = $this->imgData->histData['chroma2']['freqs'];
	
	// this divides a range for (near-)monochrome; slightly chromatic; strongly chromatic; colorful
	$range = array(0.2, 0.5, 0.8);
	
        $total = array_sum($freqs);
        $bins = count($freqs);

	$perRange = array();
	for ($i=0; $i< count($range) + 1; $i++) { $perRange[$i] = 0; }

        for ($i = 0; $i < $bins; $i++) {
	    $progress = $i / $bins;
	    
	    // which range are we in?
	    $blockIdx = 0;
	    while ($progress > $range[$blockIdx]) {
		$blockIdx++;
		if ($blockIdx == count($range)) break;
	    }
	    
	    $v = $freqs[$i];
	    
	    $perRange[$blockIdx] += $v;
        }

	// normalize $perRange values:
	for ($i=0; $i < count($perRange); $i++) {
	    $perRange[$i] = $perRange[$i] / $total;
	}
	
	// assumption: monochromatic:
	$score = 0;
	
	// if less than 90% are near-monochrome, there is a certain score:
	if ($perRange[0] < 0.9) $score += 0.9 - $perRange[0];
	
	if ($perRange[1] > 0.01) $score += sqrt($perRange[1] - 0.01) * 0.5;
	
	$score += sqrt($perRange[2]);
	
	if ($perRange[3] > 0.005) $score += sqrt(($perRange[3] - 0.005) * 10);
	
	if ($score > 1) $score = 1;
	
	$score = sqrt($score);
	
	$this->imgData->chromacityScore = $score;
	
	if (isset($this->imgData->histData['hue'])) {
	    if (!isset($this->imgData->histData['hue']['vars'])) $this->imgData->histData['hue']['vars'] = array();
	    $this->imgData->histData['hue']['vars']['chromacityScore'] = $score;
	}
	
    }

}
?>