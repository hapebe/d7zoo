<?php

/**
 * base class / interface defining the default image analyzer features
 */
class ImageAnalyzer {

    /**
     * a valid GD Image handler (ImageCreateTrueColor()...)
     */
    public $im;
    public $w;
    public $h;

    /**
     *
     * @var \ImgData instance of ImgData for the image in scope
     */
    public $imgData;

    function ImageAnalyzer($im) {
	$this->im = $im;
	$this->w = ImageSX($this->im);
	$this->h = ImageSY($this->im);
	$this->imgData = new ImgData();
    }

    /**
     * @param params - an array containing additional parameters for map creation
     * @return either an Image resource containing the result or (if $mode === FALSE) an array containing the available processing modes
     */
    function makeMap($mode = FALSE, $params = FALSE) {
	if ($mode === FALSE)
	    return array();
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
		'chroma', // chroma map (greyscale image)
		'hue', // hue map (colored image)
	    );
	}
	return FALSE;
    }

    function makeHistogramData() {
	return FALSE;
    }

    static function GetTargetSize($filename, $pixelCount) {
	$i = getimagesize($filename);
	$w0 = $i[0];
	$h0 = $i[1];
	$factor = sqrt($pixelCount / $w0 / $h0);
	$w1 = round($factor * $w0);
	$h1 = round($factor * $h0); // echo $w1.';'.$h1;
	return array('width' => $w1, 'height' => $h1);
    }

}

?>