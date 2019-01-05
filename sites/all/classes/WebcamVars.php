<?php
class WebcamVars {
	public $knownCustomVars;
	
	public function __construct() {
		$this->knownCustomVars = array(
			'chain_of_lights',
			'x_lens_flare',
			'x_phase_of_day',
			'x_sunny' 
		);
	}
	
	function getStandardVars() {
		return WebcamAnalyzer::exportVarList();
	}
	
	function getNonStandardVars() {
		static $standardVars, $vars;
		
		if (!isset($standardVars)) {
			$standardVars = $this->getStandardVars();
			
			$vars = array();
			$result = db_query('SHOW FIELDS FROM vars2');
			foreach ($result as $record) {
				$varname = $record->Field;
				if ($varname == 'imageid') continue;
				if (!in_array($varname, $standardVars)) {
					$vars[] = $varname;
				}
			}
			
			sort($vars);
		}
		
		return $vars;
	}
	
	function getVarStatus($set, $varname = FALSE) {
		if (!$varname) {
			// global mode:
			// TODO
			return;
		}
		
		// single variable mode:
		$imageUids = $set->getImageUids();
		// existing values; using table vars2:
		$sql = 'SELECT COUNT(imageid) AS found FROM vars2 WHERE ('.$varname.' IS NOT NULL)';
		if ($set->name != 'ALL') {
			$sql .= " AND (imageid IN (" . implode(", ", $imageUids) . "))";
		}
		$result = db_query($sql);
		$row = $result->fetchObject();
		$found = $row->found;
		
		// missing values; using table vars2:
		$sql = 'SELECT COUNT(imageid) AS missing FROM vars2 WHERE ('.$varname.' IS NULL)';
		if ($set->name != 'ALL') {
			$sql .= " AND (imageid IN (" . implode(", ", $imageUids) . "))";
		}
		// echo $sql; exit;
		$result = db_query($sql);
		$row = $result->fetchObject();
		$missing = $row->missing;
		
		// print_r(compact('found', 'missing')); exit;
		return compact('found', 'missing');
	}
	
	function makeTableSQL() {
		$TABLE = 'vars2';
		
		$lines = array();
		$lines[] = 'DROP TABLE IF EXISTS '.$TABLE.';';
		$lines[] = '';
		$lines[] = 'CREATE TABLE '.$TABLE.' (';
		$lines[] = 'imageid INT NOT NULL PRIMARY KEY,';
		
		$n = count($this->getStandardVars());
		$i = 0;
		foreach ($this->getStandardVars() as $varname) {
			$lines[] = $varname . ' FLOAT' . ($i<($n-1)?',':'');
			$i++;
		}
		
		$lines[] = ');';
		$lines[] = '';
		
		// add known custom vars:
		foreach ($this->knownCustomVars as $varname) {
			$lines[] = 'ALTER TABLE '.$TABLE.' ADD COLUMN '.$varname.' CHAR(16) NULL;';
		}
		
		return implode("\n", $lines);
	}
}