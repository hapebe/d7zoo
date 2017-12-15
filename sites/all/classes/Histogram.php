<?php

/*
  Histogram.php

  v3.00 2014-04-17 refactoring as part of hapebe image analysis package
  v2.00 2009-04-28 refactoring as part of the "cartrends" drupal Module
  v1.01 2007-01-02 normalize(), string serialization now with 2^12 bits precision per value
  v1.00 2006-11-15 *new*
 */

class Histogram {

    var $data;
    var $colors;
    var $width;
    var $height;
    var $font;

    function Histogram($data) {
        /**
         * $data is expected to be an array and contain at least one subset:
         * 'freqs' => array( (values...) )
         * additionally possible:
         * 'vars' => array(...)
         */
	if (!isset($data['freqs'])) {
	    drupal_set_message(t('Histogram: no freqs given in data!'));
	    return FALSE;
	}
        $this->data = $data;

        $this->font = dirname(__FILE__) . '/../../../sites/all/fonts/FRADMCN.TTF'; // print_r($this->font); exit;

        $this->colors = array();
    }

    /**
     * after a call to this method, the sum of all data entries will be 1.0
     */
    function normalize() {
        $f = $this->data['freqs'];
        $sum = array_sum($f);
        for ($i = 0; $i < count($f); $i++)
            $f[$i] /= $sum;
        $this->data['freqs'] = $f;
    }

    function paint($width, $height) {
        $EXP_RANGE = 12; // 2^-6 .. 2^+6

        $minExp = $EXP_RANGE * -0.5;
        $maxExp = $EXP_RANGE * 0.5;

        $im = ImageCreate($width, $height);
        $bg = ImageColorAllocate($im, 0x44, 0x44, 0x44);
        $bg2 = ImageColorAllocate($im, 0x99, 0x99, 0x99);
        $fg = ImageColorAllocate($im, 0xee, 0xee, 0xee);

        $colors = array(
            0 => array(
                ImageColorAllocate($im, 0x55, 0x55, 0x55),
                ImageColorAllocate($im, 0x77, 0x77, 0x77),
            ),
            1 => array(
                ImageColorAllocate($im, 0x88, 0x88, 0x88),
                ImageColorAllocate($im, 0xaa, 0xaa, 0xaa),
            ),
            2 => array(
                ImageColorAllocate($im, 0xbb, 0xbb, 0xbb),
                ImageColorAllocate($im, 0xdd, 0xdd, 0xdd),
            ),
        );

        // ImageColorTransparent($im, $bg);
        ImageFilledRectangle($im, 0, 0, $width, $height, $bg);

        $freqs = $this->data['freqs'];
        $vars = array();
        if (isset($this->data['vars']))
            $vars = $this->data['vars'];

        $total = array_sum($freqs);
        $bins = count($freqs);
        $expected = $total / $bins;

        // calculate threshold values for thirds:
        $thr1 = -1;
        $thr2 = -1;
        $sum = 0;
        for ($i = 0; $i < $bins; $i++) {
            $sum += $freqs[$i];
            if (($thr1 == -1) and ( $sum > ($total * 1 / 3)))
                $thr1 = $i;
            if (($thr2 == -1) and ( $sum > ($total * 2 / 3)))
                $thr2 = $i;
        }

        $sx = $width / $bins;
        // $maxV = $this->getDataSum();
        // order of potency to "scale" the normal portion to 0.25:
        // $order = log(1/count($this->data)) / log (0.25);

        for ($i = 0; $i < $bins; $i++) {
            $colorFamily = 0;
            if ($i >= $thr1)
                $colorFamily = 1;
            if ($i >= $thr2)
                $colorFamily = 2;

            $ratio = $freqs[$i] / $expected;

            $exponent = $minExp;
            if ($ratio > 0) {
                $exponent = log($ratio) / log(2);
            }
            if ($exponent < $minExp)
                $exponent = $minExp;
            if ($exponent > $maxExp)
                $exponent = $maxExp;

            $px1 = floor($i * $sx);
            $px2 = floor(($i + 1) * $sx);

            $py1 = $height; // bottom
            $half = floor($height / 2);
            $py2 = $height - floor(($exponent + $maxExp) / $EXP_RANGE * $height);

            $c = $colors[$colorFamily][0];
            ImageFilledRectangle($im, $px1, $py1, $px2, $py2, $c);

            // highlight if a value has more than expected occurrences
            if ($exponent > 0) {
                $c = $colors[$colorFamily][1];
                ImageFilledRectangle($im, $px1, $half, $px2, $py2, $c);
            }
            /*
              if (isset($this->colors)) {
              $rgb = Color::CC2RGB($this->colors[$i]);
              extract($rgb);
              $c = ImageColorAllocate($im,$r,$g,$b);
              }
             */
        }

        ImageSetStyle($im, array($bg2, $bg2, $bg2, $bg2, $bg2, $bg2, $bg, $bg, $bg, $bg, $bg, $bg,));
        for ($i = $minExp + 1; $i < $maxExp; $i += 1) {
            $py = floor($height * (($i + $maxExp) / $EXP_RANGE));
            ImageLine($im, 0, $py, $width - 1, $py, IMG_COLOR_STYLED);
            if ($i == 0)
                ImageLine($im, 0, $py, $width - 1, $py, $bg2);
        }

        // scale thirds:
        $pixelsInThirds = $vars['pixelsInThirds'];
        for ($i = 0; $i < 3; $i++) {
            $percentage = sprintf("%01.1f%%", $pixelsInThirds[$i] * 100);
            $bb = ImageTTFBBox(9, 0, $this->font, $percentage);
            $x = floor($i * ($width / 3) - $bb[4] / 2 + ($width / 6) + 0.5);
            ImageTTFText($im, 9, 0, $x, 20, $fg, $this->font, $percentage);
        }

        // quantiles:
        if (isset($vars['quantiles'])) {
            $q = $vars['quantiles']->q;

            $y = $height * 0.4;
            foreach ($q as $code => $position) {
                $px = floor($position * $width + 0.5);

                $percentage = sprintf("%01.1f%%", $position * 100);
                $bb = ImageTTFBBox(9, 0, $this->font, $percentage);
                $x = floor($position * $width - $bb[4] / 2 + 0.5);
                ImageTTFText($im, 9, 0, $x, $y, $fg, $this->font, $percentage);
                $y += $height * 0.05;

                ImageLine($im, $px, 0, $px, $height - 1, $fg);
            }
        }

        return $im;
    }

    function toString() {
	/*
        $retval = "";
        $this->normalize();
        for ($i = 0; $i < count($this->data); $i++) {
            $idx = floor($this->data[$i] * 4096);
            if ($idx == 4096)
                $idx--;
            $retval .= str_pad(dechex($idx), 3, "0", STR_PAD_LEFT);
        }
        return $retval;
	*/
    }

    function fromString($s) {
        /*
	$this->data = array();
        for ($i = 0; $i < strlen($s); $i+=3) {
            $v = substr($s, $i, 3);
            $this->data[] = hexdec($v);
        }
        $this->normalize();
        return true; */
    }

    function toHTML() {
	/*
        $s = $this->toString();
        $retval = "";
        for ($i = 0; $i < count($this->data); $i++) {
            $retval .= '<span style="border:1px solid #777777; margin-right:2px;">' . substr($s, $i * 3, 3) . '</span>' . "\n";
        }
        return $retval; */
    }
}
