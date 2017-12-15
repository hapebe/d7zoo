<?php
class GDContext {
    /**
     * @var resource GD Image resource
     */
    var $im;
    
    var $w;
    var $h;
    
    /**
     * @var array hash of (color code) => GD color
     */
    var $colors;
    
    /**
     * @var string path to TTF file 
     */
    var $font;
    
    function __construct($im) {
	if (!is_resource($im)) {
	    drupal_set_message(t('Invalid or no GD resource given in %file@%line.', array('%file' => __FILE__, '%line' => __LINE__)), 'error');
	    return FALSE;
	}
	
        $this->im = $im;
	    $this->w = ImageSX($im);
	    $this->h = ImageSY($im);
	    
        $this->colors = array();
        $this->font = dirname(__FILE__) . '/../../../sites/all/fonts/FRADMCN.TTF'; // print_r($this->font); exit;
    }
    
    function getSetColorCC($cc) {
        if (!isset($this->colors[$cc])) {
            $rgb = Color::CC2RGB($cc);
            $c = imagecolorallocate($this->im, $rgb['r'], $rgb['g'], $rgb['b']);
            $this->colors[$cc] = $c;
        }
        return $this->colors[$cc];
    }
    
    function getSetColorRGB($p0, $p1 = 0, $p2 = 0) {
        $r = $p0; $g = $p1; $b = $p2;
        if (is_array($p0)) {
            $r = $p0['r'];
            $g = $p0['g'];
            $b = $p0['b'];
        }
        $cc = Color::RGB2CC($r, $g, $b);
        
        return $this->getSetColorCC($cc);
    }
    
}