<?php
/**
  RangedHistogram.php

  v1.00 2014-05-03 *new* from Histogram
 */
class RangedHistogram extends Histogram {

    var $data;
    var $colors;
    var $width;
    var $height;
    var $font;

    function RangedHistogram($data) {
        /**
         * $data is expected to be an array and contain at least one subset:
         * 'freqs' => array( (values...) )
         * additionally possible:
         * 'vars' => array(...)
         */
	if (!isset($data['freqs'])) {
	    drupal_set_message(t('RangedHistogram: no freqs given in data!'), 'error');
	    return FALSE;
	}
	if (!isset($data['vars'])) {
	    drupal_set_message(t('RangedHistogram: no vars given in data!'), 'error');
	    return FALSE;
	}
	if (!isset($data['vars']['range'])) {
	    drupal_set_message(t('RangedHistogram: no range given in data!'), 'error');
	    return FALSE;
	}
	
        $this->data = $data;

        $this->font = dirname(__FILE__) . '/../../../sites/all/fonts/FRADMCN.TTF'; // print_r($this->font); exit;

        $this->colors = array();
    }

    /**
     * @param int $width
     * @param int $height
     * @return \GDContext
     */
    function paint($width, $height) {
        $EXP_RANGE = 12; // 2^-6 .. 2^+6

        $minExp = $EXP_RANGE * -0.5;
        $maxExp = $EXP_RANGE * 0.5;

        $im = ImageCreate($width, $height);
	$gdc = new GDContext($im);
        $bg = $gdc->getSetColorCC('444444');
        $bg2 = $gdc->getSetColorCC('666666');
        $fg = $gdc->getSetColorCC('eeeeee');

        // ImageColorTransparent($im, $bg);
        ImageFilledRectangle($im, 0, 0, $width, $height, $bg);

        $freqs = $this->data['freqs'];
        $vars = $this->data['vars'];
	
	// $range is expected to be an array of 1..n limits/thresholds
	$range = $vars['range'];
	if (!is_array($range)) {
	    drupal_set_message(t('RangedHistogram: range is not an array!'), 'error');
	    return FALSE;
	}

        // does not support more than 5 range points yet!
	$rangeColors = array(
            0 => array(
                $gdc->getSetColorCC('555555'),
                $gdc->getSetColorCC('777777'),
            ),
            1 => array(
                $gdc->getSetColorCC('888888'),
                $gdc->getSetColorCC('aaaaaa'),
            ),
            2 => array(
                $gdc->getSetColorCC('bbbbbb'),
                $gdc->getSetColorCC('eeeeee'),
            ),
            3 => array(
                $gdc->getSetColorCC('555555'),
                $gdc->getSetColorCC('777777'),
            ),
            4 => array(
                $gdc->getSetColorCC('888888'),
                $gdc->getSetColorCC('aaaaaa'),
            ),
            5 => array(
                $gdc->getSetColorCC('bbbbbb'),
                $gdc->getSetColorCC('eeeeee'),
            ),
        );
	
        $total = array_sum($freqs);
        $bins = count($freqs);
        $expected = $total / $bins;

        $sx = $width / $bins;
	
	$perRange = array();
	for ($i=0; $i< count($range) + 1; $i++) { $perRange[$i] = 0; }

        for ($i = 0; $i < $bins; $i++) {
	    $progress = $i / $bins;
	    // which range are we in?
	    $blockIdx = 0;
	    while ($progress > $range[$blockIdx]) {
		$blockIdx++;
		if ($blockIdx == count($range)) break;
	    }
	    
	    $v = $freqs[$i];
	    $perRange[$blockIdx] += $v;

            $ratio = $v / $expected;

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

            $c = $rangeColors[$blockIdx][0];
            ImageFilledRectangle($im, $px1, $py1, $px2, $py2, $c);

            // highlight if a value has more than expected occurrences
            if ($exponent > 0) {
                $c = $rangeColors[$blockIdx][1];
                ImageFilledRectangle($im, $px1, $half, $px2, $py2, $c);
            }
        }

        ImageSetStyle($im, array($bg2, $bg2, $bg2, $bg2, $bg2, $bg2, $bg, $bg, $bg, $bg, $bg, $bg,));
        for ($i = $minExp + 1; $i < $maxExp; $i += 1) {
            $py = floor($height * (($i + $maxExp) / $EXP_RANGE));
            if ($i == 0) {
		ImageLine($im, 0, $py, $width - 1, $py, $bg2);
	    } else {
		ImageLine($im, 0, $py, $width - 1, $py, IMG_COLOR_STYLED);
	    }
        }
	
	for ($i=0; $i < count($perRange); $i++) {
	    $pct = $perRange[$i] / $total * 100;
	    imagettftext($gdc->im, 10, 0, $width-60, $i * 12 + 12, $fg, $gdc->font, sprintf("%01.2f%%", $pct));
	}

        return $gdc;
    }

}
