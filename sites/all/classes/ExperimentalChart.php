<?php

class ExperimentalChart {

    var $width;
    var $height;

    /**
     * @var GDContext containing info about the related GD image
     */
    var $gd;
    var $gradient;

    function ExperimentalChart() {
        $this->width = 640;
        $this->height = 320;

        $this->gradient = NULL;
    }

    function setGradient($g) {
        $this->gradient = $g;
    }

    function paint() {
        if ($this->gd == NULL) {
	    $im = ImageCreateTrueColor($this->width, $this->height);
	    $this->gd = new GDContext($im);
        }

	// $bgc = $this->gd->getSetColor('555555');

        if ($this->gradient == NULL) {
            // a default gradient:
            $this->gradient = new Gradient(new Color(0x00, 0xdd, 0xcc), new Color(0xff, 0xdd, 0xcc));
            $this->gradient->addColor('0500', new Color(0xff, 0xdd, 0x00));
        }

        $im = $this->gd->im;

        // y grid:
        for ($y = 1; $y < 10; $y++) {
            $py = floor(256 * ($y / 10) + 0.5);
            imageline($im, 0, $py, $this->width, $py, $this->gd->getSetColorCC('333333'));
        }

        // gradient bar AND calculate descriptive stats:
        $stats = array(
            'r' => array(),
            'g' => array(),
            'b' => array(),
            's' => array(),
            'c' => array(),
            'c1' => array(),
            'c2' => array(),
            'l' => array(),
        );
        for ($x = 0; $x < $this->width; $x++) {
            $frac = $x / $this->width;

            $color = $this->gradient->getColorAt($frac);
            ImageLine($im, $x, 256, $x, 320, $this->gd->getSetColorCC($color->getCC()));

            $stats['r'][$x] = 256 - $color->r;
            $stats['g'][$x] = 256 - $color->g;
            $stats['b'][$x] = 256 - $color->b;

            $stats['l'][$x] = 256 - floor($color->l * 255 + 0.5);
            $stats['s'][$x] = 256 - floor($color->s * 255 + 0.5);

            $stats['c'][$x] = 256 - floor($color->chroma * 255 + 0.5);
            $stats['c1'][$x] = 256 - floor($color->chroma1 * 255 + 0.5);
            $stats['c2'][$x] = 256 - floor($color->chroma2 * 255 + 0.5);
        }

        
        // descriptive stats:
        $ccs = array(
            'r' => 'ff0000',
            'g' => '00ff00',
            'b' => '0000ff',
            's' => 'ff0000',
            'c' => 'ff00ff',
            'c1' => 'aa00aa',
            'c2' => '00aaaa',
            'l' => '777777',
        );
        $sequence = array_keys($stats);
        for ($x = 1; $x < $this->width; $x++) {
            foreach ($sequence as $stat) {
                $y0 = $stats[$stat][$x - 1];
                $y1 = $stats[$stat][$x];
                $c = $this->gd->getSetColorCC($ccs[$stat]);
                ImageLine($im, $x - 1, $y0, $x, $y1, $c);
                ImageLine($im, $x - 1, $y0 - 1, $x, $y1 - 1, $c);
            }
            // rotate the stats by one element:
            if ($x % 2 == 0) {
                $move = array_shift($sequence);
                $sequence[] = $move;
            }
        }

        return $this->gd->im;
    }

}

?>