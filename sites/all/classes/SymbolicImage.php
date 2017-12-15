<?php

/**
 * Makes "boxy" images used to show transparency or out-of-bounds values in a 2D image
 *
 * @author hapebe
 */
class SymbolicImage {
    public $width;
    public $height;
    
    public $im;
    
    function __construct($width, $height) {
        $this->width = $width;
        $this->height = $height;
    }
    
    function getIm($mode = 'low') {
        $GRID = 4;
        
        if (!isset($this->im)) {
            $this->im = imagecreatetruecolor($this->width, $this->height);
            
            $c = array(
                0 => imagecolorallocate($this->im, 0x00, 0x00, 0x00),
                1 => imagecolorallocate($this->im, 0x44, 0x44, 0x44),
            );
            if ($mode == 'high') {
                $c = array(
                    0 => imagecolorallocate($this->im, 0xbb, 0xbb, 0xbb),
                    1 => imagecolorallocate($this->im, 0xff, 0xff, 0xff),
                );
            }
            
            for ($x=0; $x < $this->width; $x+=$GRID) {
                $colorIdx = ($x / $GRID) % 2;
                $x1 = $x + $GRID - 1; if ($x1 > $this->width) $x1 = $this->width;
                for ($y=0; $y<$this->height; $y+= $GRID) {
                    $y1 = $y + $GRID - 1; if ($y1 > $this->height) $y1 = $this->height;
                    imagefilledrectangle($this->im, $x, $y, $x1, $y1, $c[$colorIdx]);
                    $colorIdx = ($colorIdx + 1) % 2;
                }
            }
        }
        
        return $this->im;
    }

}
