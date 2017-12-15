<?php
class Color {
	public $r;
	public $g;
	public $b;
	
	public $h;
	public $s;
	public $v;
	public $l;
	public $l709;
	
	public $chroma;
        public $chroma1;
        public $chroma2;

/**
 * @static
 */
static function RGB4HSV($p1,$p2=0,$p3=0,$q=FALSE) {
	if (is_array($p1)) {
		extract($p1); //should contain "h","s","v" indizes
	} else { $h = $p1; $s = $p2; $v = $p3; }
	
	//"Plugin" of a HSVQuantizer object:
	if ($q) {
		//echo get_class($q)."<br />\n";
		if (strtolower(get_class($q)) == "hsvquantizer") {
			if (isset($q->h))	{
				$h /= 360;
				$h = floor($h*$q->h) / $q->h;	
				$h *= 360;
			}
		
			if (isset($q->s))	{
				$s = floor($s*$q->s) / $q->s;	
			}

			if (isset($q->v))	{
				$v = floor($v*$q->v) / $q->v;	
			}
		}
	}

	if ($s <= 0) {
		//achromatic...
		$r = floor($v*255);
		$g = floor($v*255);
		$b = floor($v*255);
	}	else {
		$h /= 360;
                if ($h >= 1.0) $h = 0;
		$h *= 6.0;
		$f = $h - floor($h);
		$p = floor(255 * $v * (1.0 - $s));
		$q = floor(255 * $v * (1.0 - ($s*$f)));
		$t = floor(255 * $v * (1.0 - ($s * (1.0 - $f))));
		$v = floor(255 * $v);
		switch(floor($h))	{
			case 0:
				$r = $v; $g = $t; $b = $p;
				break;
			case 1:
				$r = $q; $g = $v; $b = $p;
				break;
			case 2:
				$r = $p; $g = $v; $b = $t;
				break;
			case 3:
				$r = $p; $g = $q; $b = $v;
				break;
			case 4:
				$r = $t; $g = $p; $b = $v;
				break;
			case 5:
				$r = $v; $g = $p; $b = $q;
				break;
		}
			
	}

	return compact('r','g','b');
}

/**
 * @static
 */
static function HSV4RGB($p1,$p2=0,$p3=0) {
	if (is_array($p1)) {
		$r = $p1['r'];	$g = $p1['g'];	$b = $p1['b'];
	}	else { $r = $p1; $g = $p2; $b = $p3; }
	
	$r /= 255; $g /= 255; $b /= 255;
		
	$max = max($r,$g,$b);
	$min = min($r,$g,$b);
	
	if (($max-$min) == 0) {$f=0;} else {$f = 1/($max-$min);}
	$h = 0;
	if ($r == $max) {	$h =   0 + 60 * ($g-$b)*$f; }
	if ($g == $max) { $h = 120 + 60 * ($b-$r)*$f; }
	if ($b == $max) { $h = 240 + 60 * ($r-$g)*$f; }
	$h = ($h+360) % 360;
	
	$s = 0;
	if ($max > 0) $s = ($max-$min) / $max;
	
	$v = $max;
	
	return compact('h','s','v');
}

/**
 * @static
 */
static function GDColorAllocateCC($im, $cc) {
    $rgb = Color::CC2RGB($cc);
    return imagecolorallocate($im, $rgb['r'], $rgb['g'], $rgb['b']);
}

/**
 * @static
 */
static function GD2CC($gdRGB) {
    $r = ($gdRGB >> 16) & 0xFF;
    $g = ($gdRGB >> 8) & 0xFF;
    $b = $gdRGB & 0xFF;
    
    return Color::RGB2CC($r, $g, $b);
}

/**
 * @static
 */
static function GD2RGB($gdRGB) {
    $r = ($gdRGB >> 16) & 0xFF;
    $g = ($gdRGB >> 8) & 0xFF;
    $b = $gdRGB & 0xFF;
    
    return compact('r', 'g', 'b');
}


/**
 * @static
 */
static function RGB2CC($p1,$p2=0,$p3=0) {
	if (is_array($p1)) {
		$r = $p1['r'];	$g = $p1['g'];	$b = $p1['b'];
	} else { 
		$r = $p1; $g = $p2; $b = $p3; 
	}
	
	$cc = str_pad(dechex($r),2,0,STR_PAD_LEFT).str_pad(dechex($g),2,0,STR_PAD_LEFT).str_pad(dechex($b),2,0,STR_PAD_LEFT);	
	return $cc;
}

/**
 * @static
 */
static function CC2RGB($cc) {
	$result = array();
	$result['r'] = (hexdec($cc) & 0xff0000) / 0x010000;
	$result['g'] = (hexdec($cc) & 0x00ff00) / 0x000100;
	$result['b'] = (hexdec($cc) & 0x0000ff);
	return $result;
}

function Color($p0, $p1 = 0, $p2 = 0, $mode = 'rgb') {
	if ($mode == 'rgb') {
		if (is_array($p0)) {
		    $this->r = $p0['r'];
		    $this->g = $p0['g'];
		    $this->b = $p0['b'];
		} else {
		    $this->r = $p0;
		    $this->g = $p1;
		    $this->b = $p2;
		}
		$this->calcHSV();
	} else if ($mode == 'hsv') {
		if (is_array($p0)) {
		    $this->h = $p0['h'];
		    $this->s = $p0['s'];
		    $this->v = $p0['v'];
		} else {
		    $this->h = $p0;
		    $this->s = $p1;
		    $this->v = $p2;
		}
		
		$this->calcRGB();
	}
}

function setCC($cc) {
	$rgb = Color::CC2RGB($cc);
	$this->setRGB($rgb);
}

function setRGB($r, $g=FALSE, $b=FALSE) {
	if (is_array($r)) {
		$g=$r['g']; $b=$r['b']; $r=$r['r'];
	}
	$this->r = $r;
	$this->g = $g;
	$this->b = $b;
	
	$this->calcHSV();
}

function setHSV($h, $s=FALSE, $v=FALSE) {
	if (is_array($h)) {
		$s = $h['s']; $v = $h['v']; $h = $h['h'];
	}
	$this->h = $h;
	$this->s = $s;
	$this->v = $v;
	
	$this->calcRGB();
}

function calcHSV() {
	$hsv = Color::HSV4RGB($this->r, $this->g, $this->b);
	$this->h = $hsv['h'];
	$this->s = $hsv['s'];
	$this->v = $hsv['v'];
	
        // l(uminosity) and chroma are always calculated
        $this->calcSecondaryValues();
}

function calcRGB() {
    if (($this->h < 0) || ($this->h > 360)) {
	drupal_set_message(t('%file @ %line : hue out of range (%h).', array('%file' => __FILE__, '%line' => __LINE__, '%h' => $this->h)), 'error');
	return FALSE;
    }
    if (($this->s < 0) || ($this->s > 1)) {
	drupal_set_message(t('%file @ %line : saturation out of range (%s).', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $this->s)), 'error');
	return FALSE;
    }
    if (($this->v < 0) || ($this->v > 1)) {
	drupal_set_message(t('%file @ %line : value out of range (%v).', array('%file' => __FILE__, '%line' => __LINE__, '%v' => $this->v)), 'error');
	return FALSE;
    }

    $rgb = Color::RGB4HSV($this->h, $this->s, $this->v);
    $this->r = $rgb['r'];
    $this->g = $rgb['g'];
    $this->b = $rgb['b'];

    // l(uminosity) and chroma are always calculated
    $this->calcSecondaryValues();
}

function calcSecondaryValues() {
	$this->l = ($this->r + $this->g + $this->b) / 255 / 3;
	$this->l709 = $this->pct('r')*0.2126 + $this->pct('g')*0.7152 + $this->pct('b')*0.0722; // according to "Rec. 709"
	$this->chroma = $this->s * $this->v;
	$this->chroma1 = $this->s * $this->s * $this->v;
	$this->chroma2 = sqrt($this->s * $this->s * $this->v);
}

function getCC() {
	return Color::RGB2CC($this->r, $this->g, $this->b);
}

function pct($channel) {
    if ($channel == 'r') return $this->r / 255;
    if ($channel == 'g') return $this->g / 255;
    if ($channel == 'b') return $this->b / 255;
    drupal_set_message(t('%file @ %line : illegal channel (%v).', array('%file' => __FILE__, '%line' => __LINE__, '%v' => $channel)), 'error');
    return FALSE;
}

function getRGBFractions() {
    return array(
	'r' => $this->pct('r'),
	'g' => $this->pct('g'),
	'b' => $this->pct('b'),
    );
}

function getHSVName() {
    return
	sprintf("%01d", $this->h) . '° ' .
	sprintf("%01.1f%%", $this->s * 100) . ' ' .
	sprintf("%01.1f%%", $this->v * 100);
}

function toString() {
	return
		'rgb('.$this->r.','.$this->g.','.$this->b.'); '
		.'hsv('.$this->getHSVName().'); '
		.'l('.sprintf('%01.4f',$this->l).'); '
		.'chroma('.sprintf('%01.4f',$this->chroma).'; '.sprintf('%01.4f',$this->chroma1).'; '.sprintf('%01.4f',$this->chroma2).')';
}

/**
 * @return array the 3D coordinate of this color in HSL space
 */
function getHSLXYZ() {
    $retval = Color3DProjectionHSVBicone::GetInstance()->Color2XYZ($this);
    $retval['x'] /= 2;
    $retval['y'] /= 2;
    $retval['z'] = ($retval['z'] - 0.5) * 0.75;
    return $retval;
}

static function XYZ4HSV($h, $s, $v) {
    $retval = Color3DProjectionHSVBicone::GetInstance()->HSV2XYZ($h, $s, $v);
    $retval['x'] /= 2;
    $retval['y'] /= 2;
    $retval['z'] = ($retval['z'] - 0.5) * 0.75;
    return $retval;
}

/**
 * @param \Color $c0
 * @param \Color $c1
 */
static function HSLDistance($c0, $c1) {
    $xyz0 = $c0->getHSLXYZ();
    $xyz1 = $c1->getHSLXYZ();
    
    $dx = $xyz1['x'] - $xyz0['x'];
    $dy = $xyz1['y'] - $xyz0['y'];
    $dz = $xyz1['z'] - $xyz0['z'];
    
    return sqrt($dx * $dx + $dy * $dy + $dz * $dz);
}

}
?>