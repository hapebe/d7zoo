<?php

class Gradient {

    var $colors;

    function Gradient($c0, $c1) {
        $this->colors = array(
            '0000' => $c0,
            '1000' => $c1,
        ); // print_r($this->colors); exit;
    }

    function addColor($p, $c) {
        $this->colors[$p] = $c; // print_r($this->colors); exit;
        ksort($this->colors); // print_r($this->colors); exit;
    }

    function getColorAt($q) {
        $left = NULL;
        $right = NULL;

        foreach ($this->colors as $pos => $c) {
            $pos /= 1000;
            if ($left === NULL) {
                $leftP = $pos;
                $left = $c;
            }
            if ($pos <= $q) {
                // result: the last color at a position left of $q
                $leftP = $pos;
                $left = $c;
            } else {
                if ($right == NULL) {
                    // the first color after $qdom_error
                    $rightP = $pos;
                    $right = $c;
                }
            }
        }
        if ($right == NULL) {
            $rightP = 1;
            $right = $this->colors[$rightP];
        }
        // print_r($q.': '.$leftP.'/'.$left->getCC().';'.$rightP.'/'.$right->getCC()."\n");

        $span = $rightP - $leftP;
        $q -= $leftP;

        $leftShare = 1 - ($q / $span);
        $rightShare = 1 - $leftShare;

        $leftH = $left->h;
        $rightH = $right->h;
        if ($rightH - $leftH > 180) {
            $leftH += 360;
        }
        if ($leftH - $rightH > 180) {
            $rightH += 360;
        }

        // print($leftH.'--'.$rightH);

        $h = $leftH * $leftShare + $rightH * $rightShare;
        $s = $left->s * $leftShare + $right->s * $rightShare;
        $v = $left->v * $leftShare + $right->v * $rightShare;

        $h = ($h + 360) % 360; // print(': '.$h);
        // print("<br>\n");

        $retval = new Color($h, $s, $v, 'hsv');
        return $retval;
    }

}

?>