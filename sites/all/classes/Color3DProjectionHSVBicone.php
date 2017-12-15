<?php

/**
 * Description of Color3DProjectionHSVBicone
 *
 * @author hapebe
 */
class Color3DProjectionHSVBicone extends Color3DProjection {
    public $xScale;
    public $yScale;
    public $zScale;

    public function __construct() {
	$this->xScale = 1.0; // radius (!) of the hue color circle
	$this->yScale = $this->xScale; // radius (!) of the hue color circle
	$this->zScale = 1.0; // full range between black and white
    }
    
    public static function GetInstance() {
	static $inst;
	
	if (!isset($inst)) $inst = new Color3DProjectionHSVBicone();
	
	return $inst;
    }
    

    
    public function HSV2XYZ($p0, $p1 = FALSE, $p2 = FALSE) {
	$h=0; $s=0; $v=0;
	if (is_array($p0)) {
	    extract($p0);
	} else {
	    $h = $p0; $s = $p1; $v = $p2;
	}
	
	$c = new Color($h, $s, $v, 'hsv');
	return Color3DProjectionHSVBicone::Color2XYZ($c);
    }

    public function RGB2XYZ($p0, $p1 = FALSE, $p2 = FALSE) {
	$r=0; $g=0; $b=0;
	if (is_array($p0)) {
	    extract($p0);
	} else {
	    $r = $p0; $g = $p1; $b = $p2;
	}
	
	$c = new Color($r, $g, $b, 'rgb');
	return Color3DProjectionHSVBicone::Color2XYZ($c);
    }

    public function getXYZ($c) {
	if (!is_a($c, 'Color')) {
	    drupal_set_message(t('%file @ %line : argument is not a Color object.', array('%file' => __FILE__, '%line' => __LINE__)), 'error', FALSE);
	    return array('x' => 0, 'y' => 0, 'z' => 0);
	}

	$radius = $c->chroma; // 0 .. 1.0

	$h = deg2rad($c->h);
	return array(
	    'x' => cos($h) * $radius * $this->xScale,
	    'y' => sin($h) * $radius * $this->yScale,
	    'z' => $c->l * $this->zScale, // 0 .. 1.0 * zScale
	    // 'z' => $c->l709 * $this->zScale, // 0 .. 1.0 * zScale
	);
    }
    
    

    public function getColor($p0, $p1 = FALSE, $p2 = FALSE) {
	$x=0; $y=0; $z=0;
	if (is_array($p0)) {
	    extract($p0);
	} else {
	    $x = $p0; $y = $p1; $z = $p2;
	}
	
	return parent::XYZtoColor($p0, $p1, $p2);
    }
    

}
