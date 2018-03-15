<?php
/**
 * calculate stats for circadian and annual time-related "rhymthms" / cycles
 */
class WebcamCyclicCalc {
	static function get($year, $month, $day, $hour, $minute) {
		$retval = array();
		
		$t = mktime($hour, $minute, 0, $month, $day, $year);
		
		$hoursFromNoon = $hour + ($minute/60) + (55/60); // +(55/60) is for the "Wahre Ortszeit"
			if ($hoursFromNoon > 24) $hoursFromNoon -= 24;
			$hoursFromNoon -= 12;
		$angle = ($hoursFromNoon / 24) * (2 * pi()); // range: -PI (mignight) .. 0 .. +PI (midnight, too)
		
		$retval['hours_from_noon'] = $hoursFromNoon;
		$retval['dailyX'] = cos($angle);
		$retval['dailyY'] = sin($angle);
		
		// calculating the annual rhythm only works for 2017 and 2018 dates (excluding late December 2018)!
		$solstice2017 = mktime(4, 24, 0, 6, 21, 2017);
		$solstice2018 = mktime(10, 7, 0, 6, 21, 2018);
		
		$daysFromSolstice2017 = ($t - $solstice2017) / (60*60*24);
		$daysFromSolstice2018 = ($t - $solstice2018) / (60*60*24);
		
		$ref = $daysFromSolstice2017;
		if (abs($daysFromSolstice2018) < abs($daysFromSolstice2017)) $ref = $daysFromSolstice2018;
		$angle = ($ref / 365) * (2 * pi()); // range: range: -PI (winter solstice) .. 0 .. +PI (winter solstice, too)
		
		$retval['days_from_midsummer'] = $ref;
		$retval['annualX'] = cos($angle);
		$retval['annualY'] = sin($angle);

		return $retval;
	}
	
}