<?php
class Profiler {

	var $start_mt;
	/**
	 * $logmode -1: no logging.
	 * $logmode 1: log to file.
	 */
	var $logmode;
	var $logfile;
	var $function_holder;
	var $logholder;
	var $instance;

	function &getInstance($initArg = false)	{
		static $p;
		if (!isset($p)) $p = new Profiler($initArg); //may not work with a reference!
		return $p;
	}
	
	function Profiler($initArg = false)	{
		$this->start_mt = microtime();
		$this->logmode = 1; //to file;
		$this->logfile = "./profile.log";
		$this->function_holder = array();
		$this->logholder = array();
		if ($initArg !== false) $this->logholder[] = $initArg;
	}
	
	function log_sentinel($name) {
		$mt = microtime();
		static $_last_sentinel;
		if (isset($_last_sentinel))	{
			$rel_time = "\t".sprintf("%01.6f",Profiler::microtime_diff($mt,$_last_sentinel))."s";
		} else { $rel_time = ""; }
		$name = str_pad($name,50);
		$logline = $name."\t+".sprintf("%01.6f",Profiler::microtime_diff($mt,$this->start_mt))."s".$rel_time;
		$this->logholder[] = $logline;
		$_last_sentinel = $mt;
	}
		
	function log_function_entry($name) {
		if (!isset($this->function_holder[$name])) {
			$this->function_holder[$name] = new ProfilerFunction();
		}
		$this->function_holder[$name]->log_entry(microtime());
	}
		
	function log_function_exit($name) {
		$this->function_holder[$name]->log_exit(microtime());
	}
		
	function terminate() {
		if ($this->logmode == -1) return; //no logging! 
		$this->logholder[] = "";
		$this->log_sentinel("Profile dump called:");

		//function stats:
		$this->logholder[] = "";
		foreach ($this->function_holder as $function_name => $pf) {
			$logline = str_pad($function_name,50)."\t";
			$logline .= str_pad($pf->function_cnt,8," ",STR_PAD_LEFT)."*\t";
			$logline .= sprintf("%01.6f",$pf->get_avg_time())."avg\t";
			$logline .= sprintf("%01.6f",$pf->function_min_time)."min\t";
			$logline .= sprintf("%01.6f",$pf->function_max_time)."max\t";
			$logline .= sprintf("%01.6f",$pf->function_time)."total\t";
			$this->logholder[] = $logline;
		}
		
		
		if ($this->logmode == 1) { //File dump.
			//indent single loglines:
			for ($i=0; $i<count($this->logholder); $i++) {
				$this->logholder[$i] = "\t".$this->logholder[$i];
			}
			$h = fopen ($this->logfile,"a");
			fputs ($h,"\r\nProfiler started at: ".Profiler::strf_microtime($this->start_mt)."\r\n");
			foreach ($this->logholder as $logline) {
				fputs ($h,$logline."\r\n");
			}
			fclose ($h);
		}
	}

	static function microtime_diff($m1,$m2) {
		$tmp1 = explode(" ",$m1);
		$tmp2 = explode(" ",$m2);
		$s_diff = $tmp1[1] - $tmp2[1];
		$ms_diff = $tmp1[0] - $tmp2[0];
		if ($ms_diff < 0)	{
			$s_diff --;
			$ms_diff += 1;
		}
		$ms_str = $ms_diff."";
		return $s_diff.substr(($ms_str),1);
	}
	
	static function strf_microtime($mt) {
		$mt = explode(" ",$mt);
		$hms = strftime("%H:%M:%S",$mt[1]);
		return $hms.substr(($mt[0]),1);
	}
	
} //end class Profiler

class ProfilerFunction {
	var $function_name;
	var $function_time;
	var $function_min_time;
	var $function_max_time;
	var $function_cnt;
	var $entry_time;
	
	function ProfilerFunction() {
		$this->function_name = "";
		$this->function_time = 0;
		$this->function_min_time = 99999999;
		$this->function_max_time = 0;
		$this->function_cnt = 0;
		$this->entry_time = 0;
	}
	
	function log_entry($time) {
		$this->entry_time = $time;
	}
	
	function log_exit($time) {
		$duration = Profiler::microtime_diff($time,$this->entry_time);
		
		$this->function_time += $duration;
		if ($duration < $this->function_min_time) $this->function_min_time = $duration;
		if ($duration > $this->function_max_time) $this->function_max_time = $duration;
		$this->function_cnt ++;
	}
	
	function get_avg_time() {
		if ($this->function_cnt > 0) {
			return $this->function_time / $this->function_cnt;
		}
		return "-E!-";
	}
	
}
?>