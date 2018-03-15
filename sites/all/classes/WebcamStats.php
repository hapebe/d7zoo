<?php
class WebcamStats {
	var $data;
	
	function __construct($data) {
		$this->data = $data;
		sort($this->data); // we need this for the quantile() function...
	}
	
	function getStats() {
		return array(
			'mean' => $this->mean(),
			'sd' => $this->sd(),
			'q01' => $this->quantile(0.01),
			'q05' => $this->quantile(0.05),
			'q25' => $this->quantile(0.25),
			'median' => $this->median(),
			'q75' => $this->quantile(0.75),
			'q95' => $this->quantile(0.95),
			'q99' => $this->quantile(0.99),
		);
	}
	
	function mean() {
		return array_sum($this->data) / count($this->data);
	}
	
	function sd() {
		$mean = $this->mean();
		
		$sse = 0;
		foreach ($this->data as $value) {
			$e = $value - $mean;
			$sse += ($e * $e);
		}
		
		return sqrt($sse / count($this->data));
	}
	
	function median() {
		return $this->quantile(0.5);
	}
	
	function quantile($fraction) {
		if ($fraction < 0 || $fraction > 1) {
			drupal_set_message(t('%file @ %line : quantile value out of range (%fraction).', array('%file' => __FILE__, '%line' => __LINE__, '%v' => $fraction)), 'error');
			return FALSE;
		}
		
		// sample case: q(10%); q(5%) of a 5-element array(0,1,2,3,4):
		$trueIndex = (count($this->data)-1) * $fraction; // = 0.4 ; = 0.2
		$i0 = floor($trueIndex); // = 0 
		$i1 = ceil($trueIndex); // = 1
		
		if ($i0 == $i1) return $this->data[$i0];
		
		$weigth0 = 1 - ($trueIndex - $i0); // = 0.6 ; = 0.8
		$weigth1 = 1 - ($i1 - $trueIndex); // = 0.4 ; = 0.2
		
		return $this->data[$i0] * $weigth0 + $this->data[$i1] * $weigth1;
		// = 0 * 0.6 + 1 * 0.4 --> 0.4
		// = 0 * 0.8 + 1 * 0.2 --> 0.2
	}
}