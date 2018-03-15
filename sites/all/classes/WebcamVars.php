<?php
class WebcamVars {
	public function __construct() {
		
	}
	
	function getStandardVars() {
		return WebcamAnalyzer::exportVarList();
	}
	
	function getNonStandardVars() {
		$standardVars = $this->getStandardVars();
		
		$vars = array();
		$result = db_query('SELECT DISTINCT(varname) FROM vars');
		foreach ($result as $record) {
			$varname = $record->varname;
			if (!in_array($varname, $standardVars)) {
				$vars[] = $varname;
			}
		}
		
		sort($vars);
		return $vars;
	}
	
	function getVarStatus($set, $varname = FALSE) {
		if (!$varname) {
			// global mode:
			
			return;
		}
		
		// single variable mode:
		$imageUids = $set->getImageUids();
		$sql = 'SELECT imageid,	varname, number, alpha FROM vars WHERE varname LIKE :varname';
		if ($set->name != 'ALL') {
			$sql .= " AND imageid IN (" . implode(", ", $imageUids) . ")";
		}
		
		$found = array();
		$missing = array(); foreach ($imageUids as $uid) { $missing[$uid] = TRUE; }
		$result = db_query($sql, array(':varname' => $varname));
		foreach ($result as $record) {
			$found[$record->imageid] = TRUE;
			unset($missing[$record->imageid]);
		}
		
		return array(
			'foundCount' => count($found),
			'missing' => array_keys($missing),
		);
	}
}