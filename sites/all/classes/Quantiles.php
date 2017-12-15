<?php
class Quantiles {

var $q;

function Quantiles($data, $mode = 'binned') {
	$this->q = array();

	// in standard mode, we calculate the quantiles from binned data (histogram)
	$intervalWidth = 1 / count($data);
	$total = array_sum($data);
	
	// forwards...
	$accum = 0;
	for ($i=0; $i < count($data); $i++) {
		$accum += $data[$i];
		
		if ( ($accum >= $total / 1000) and (!isset($this->q['q001'])) ) $this->q['q001'] = $i * $intervalWidth;
		if ( ($accum >= $total / 100) and (!isset($this->q['q01'])) ) $this->q['q01'] = $i * $intervalWidth;
		if ( ($accum >= $total / 10) and (!isset($this->q['q1'])) ) $this->q['q1'] = $i * $intervalWidth;
		if ( ($accum >= $total / 2) and (!isset($this->q['q5'])) ) $this->q['q5'] = $i * $intervalWidth;
	}
	
	// and backwards:
	$accum = 0;
	for ($i=count($data)-1; $i >= 0; $i--) {
		$accum += $data[$i];
		
		if ( ($accum >= $total / 1000) and (!isset($this->q['q999'])) ) $this->q['q999'] = ($i+1) * $intervalWidth;
		if ( ($accum >= $total / 100) and (!isset($this->q['q99'])) ) $this->q['q99'] = ($i+1) * $intervalWidth;
		if ( ($accum >= $total / 10) and (!isset($this->q['q9'])) ) $this->q['q9'] = ($i+1) * $intervalWidth;
	}
}

}
?>