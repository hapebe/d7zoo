<?php
class CircularHueHistogram extends Histogram {

function CircularHueHistogram($data) {
	/**
	 * $data is expected to be an array and contain at least one subset:
	 * 'freqs' => array( (values...) )
	 * additionally possible:
	 * 'vars' => array(...)
	 */
	if (!isset($data['freqs'])) {
	    drupal_set_message(t('CircularHueHistogram: no freqs given in data!'));
	    return FALSE;
	}
	$this->data = $data;
	
	$this->font = dirname(__FILE__).'/../../../sites/all/fonts/FRADMCN.TTF'; // print_r($this->font); exit;
	
	$this->colors = array();
	
	$this->calculateColors();
}



function calculateColors() {
	$n = count($this->data['freqs']);
	$degPerSlice = 360 / $n;
	
	$this->colors = array();
	for ($i=0; $i < $n; $i++) {
		$h = ($i + 0.5) * $degPerSlice;
		$c = new Color($h, 0.6, 1, 'hsv');
		$this->colors[$i] = $c;
	} // print_r($this->colors); exit;

}


/**
 * @override
 */ 
function paint($width, $height) {
	$EXP_RANGE = 8; // 2^-4 .. 2^+4
	
	$minExp = $EXP_RANGE * -0.5;
	$maxExp = $EXP_RANGE * 0.5;

	$freqs = $this->data['freqs'];
	
	$vars = array();
	if (isset($this->data['vars'])) $vars = $this->data['vars'];

	$radius = floor( min($width, $height) / 2 ); // echo "r:".$radius."<br>\n"; exit;
	$mx = floor($width / 2); $my = floor($height / 2);

	
	$im = ImageCreate($width, $height);
	$black = ImageColorAllocate($im,0x00,0x00,0x00);
	$bg = ImageColorAllocate($im,0x77,0x77,0x77);
	$bg2 = ImageColorAllocate($im,0x99,0x99,0x99);
	$fg = ImageColorAllocate($im,0xee,0xee,0xee);
	$white = ImageColorAllocate($im,0xff,0xff,0xff);
	
	$colors = array();
	// $this->colors has been prepared in constructor / calculateColors()
	foreach ($this->colors as $i => $c) {
		$colors[$i] = ImageColorAllocate($im, $c->r, $c->g, $c->b);
	}
	
	ImageFilledRectangle($im,0,0,$width,$height,$bg);
	ImageColorTransparent($im, $bg);
	
	ImageEllipse($im, $mx, $my, $radius*2-1, $radius*2-1, $bg2);
	
	$total = array_sum($freqs);
	$n = count($freqs);
	$expected = $total / $n;
	$degPerSlice = 360 / $n;
	
	// if possible, reduce the maximum chart radius by the chromacity of the pic:
	$radiusScaling = 1;
	if (isset($vars['chromacityScore'])) {
	    $radiusScaling = sqrt($vars['chromacityScore']);
	}
	
	if ($expected != 0) {
		for ($i=0; $i<$n; $i++) {
			$alpha = $i * $degPerSlice - 0.1;
			$beta = ($i+1) * $degPerSlice + 0.1; // echo "alpha / beta: ".$alpha.", ".$beta;
			
			$ratio = $freqs[$i] / $expected;
			$exponent = $minExp;
			if ($ratio > 0) {
				$exponent = log($ratio) / log(2);
			}
			if ($exponent < $minExp) $exponent = $minExp;
			if ($exponent > $maxExp) $exponent = $maxExp; // print_r($exponent); exit;
		
			$v = ($exponent + $maxExp) / $EXP_RANGE; // print_r($v); exit;
			
			$v *= $radiusScaling;
			
			$xAlpha = floor(cos(deg2rad($alpha)) * $radius * $v + 0.5); 
			$yAlpha = floor(sin(deg2rad($alpha)) * $radius * $v + 0.5);
			
			$xBeta = floor(cos(deg2rad($beta)) * $radius * $v + 0.5);
			$yBeta = floor(sin(deg2rad($beta)) * $radius * $v + 0.5);
			// echo $xAlpha.";".$yAlpha." - ".$xBeta.";".$yBeta."<br>\n";
			
			$px = array();
			$px[] = $mx; $px[] = $my;
			$px[] = $mx + $xAlpha; $px[] = $my + $yAlpha;
			$px[] = $mx + $xBeta; $px[] = $my + $yBeta;
			
			$c = $colors[$i];
			
			ImageFilledPolygon($im,$px,3,$c);
		}
	}
	// "normal" marker line:
	ImageEllipse($im, $mx, $my, $radius * $radiusScaling, $radius * $radiusScaling, $bg2);
	
	// mark main colors:
	/*
	if ($this->imgid > 0) {
		$style = array($white, $white, $black, $black);
		imagesetstyle($im, $style);
		$result = db_query("SELECT type, h, r, g, b FROM {cartrends_color} WHERE imgid=%d", $this->imgid);
		while ($row=db_fetch_array($result)) {
			extract($row);
			$s = getAbsSforRGB($r, $g, $b);
			if ($s > 0.25) {
				$x = floor(cos(deg2rad($h)) * $radius + 0.5); 
				$y = floor(sin(deg2rad($h)) * $radius + 0.5);
				imageline($im, $mx, $my, $mx+$x, $my+$y, IMG_COLOR_STYLED);
				
				$x = floor(cos(deg2rad($h)) * $s * $radius + 0.5); 
				$y = floor(sin(deg2rad($h)) * $s * $radius + 0.5);

				$myRadius = floor($s * 12);
				
				$myColor = ImageColorAllocate($im, $r, $g, $b);
				ImageFilledEllipse($im, $mx + $x, $my + $y, $myRadius+4, $myRadius+4, $myColor);

				$c = $white;
				if ($type == 0) $c = $black;
				ImageEllipse($im, $mx + $x, $my + $y, $myRadius+4, $myRadius+4, $c);
				ImageEllipse($im, $mx + $x, $my + $y, $myRadius+6, $myRadius+4, $c);
				ImageEllipse($im, $mx + $x, $my + $y, $myRadius+4, $myRadius+6, $c);
				ImageEllipse($im, $mx + $x, $my + $y, $myRadius+6, $myRadius+6, $c);
				
			}
		}
	}
	*/
	
	return $im;
}

function circularSmooth() {
    $n = count($this->data['freqs']);
    $newData = array();
    for ($i = $n; $i < 2 * $n; $i++) {
	$l2 = ($i - 2) % $n;
	$l1 = ($i - 1) % $n;
	$v = ($i) % $n;
	$r1 = ($i + 1) % $n;
	$r2 = ($i + 2) % $n;

	$newData[$v] = $this->data['freqs'][$l2] * 0.125 +
	    $this->data['freqs'][$l1] * 0.225 +
	    $this->data['freqs'][$v] * 0.30 +
	    $this->data['freqs'][$r1] * 0.225 +
	    $this->data['freqs'][$r2] * 0.125;
    }
    $this->data['freqs'] = $newData;
    $this->normalize();
}



}
?>