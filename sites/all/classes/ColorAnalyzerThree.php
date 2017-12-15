<?php

/**
 * makes animations of a rotating HSL bicone "histogram"
 *
 * @author hapebe
 */
class ColorAnalyzerThree {
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
	if ($imgData != FALSE) { $this->imgData = $imgData; } else { $this->imgData = new ImgData(); }
	if ($name != FALSE) { $this->name = $name; } else { $this->name = 'colorAnalysis'; }
	
	$this->config = array(
	    'INCLUDE_PIXEL_SHARE' => 0.98, // % of pixels that will be included in the chart representation, i.e.: 1 - INCLUDE_PIXEL_SHARE will be omitted
	    'FILE_BASE_PATH' => drupal_realpath(file_default_scheme() . '://') . '/ia',
	    'THREE_JS_OUTPUT' => 'C:/xampp/htdocs/bootstrap/js/colors.js',
	    'POVRAY_OUTPUT' => 'D:/home/hapebe/POV-Ray/v3.7/scenes/hapebe-colors-generated.pov',
	    'RENDER_MODE' => -1, // -1 = quick / draft / debug; 0 = normal / production quality 
	    // '' => , // 
	);
    }
    
    function getConfig($name) {
	if (!isset($this->config[$name])) {
	    drupal_set_message(t('%file @ %line : config value %name is not set.', array('%file' => __FILE__, '%line' => __LINE__, '%name' => $name)), 'error');
	    return FALSE;
	}
	return $this->config[$name];
    }

    /**
     * generates javascript output, defining this image's color histogram
     * @return string HTML content to be shown as a result
     */
    function analyzeColors() {
    // $p = Profiler::getInstance(); $p->log_mode = -1;
	
    $retval = array();
    set_time_limit(1200);

    $gdc = $this->gdc;
    $im = $this->gdc->im;
    $width = $this->gdc->w;
    $height = $this->gdc->h; // echo $width."x".$height; exit;
    
    $color3DProjection = new Color3DProjectionHSVBicone();
    $colorSpace = new ColorSpaceHolder($color3DProjection);
    $colorSpace->setHSVResolution(90, 20, 50);
    if ($this->getConfig('RENDER_MODE') == -1) $colorSpace->setHSVResolution(90, 15, 30);

    // compute color space
    for ($x = 0; $x < $width; $x++) {
	for ($y = 0; $y < $height; $y++) {
	    $c = new Color(Color::GD2RGB(imagecolorat($im, $x, $y)));
	    $colorSpace->addPixel($c->h, $c->s, $c->v);
	}
    }

    // $txt = $colorSpace->to3DObjects($this->getConfig('INCLUDE_PIXEL_SHARE'));
    // $f = fopen($this->getConfig('THREE_JS_OUTPUT'), 'w');
    
    $txt = $colorSpace->toPOVRay3DObjects($this->getConfig('INCLUDE_PIXEL_SHARE'));
    $f = fopen($this->getConfig('POVRAY_OUTPUT'), 'w');
    
    if ($f) {
	fputs($f, $txt);
	fclose($f);
	
	$retval[] = 'Output written.';
    }
    
    // $p->log_sentinel("computed colorSpace (graphics / charts)");
    return implode("\n", $retval);
}

}
