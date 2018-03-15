<?php
class WebcamImage {
	var $uid;
	var $filename;
	var $sha256;
	var $year; var $month; var $day; var $hour;	var $minute; // all refering to UTC in the filename
	var $filesize;
	
	/** as in database table vars! */
	var $vars;
	
	function __construct() {
		$this->uid = FALSE;
		$this->vars = FALSE;
	}
	
	function toDB() {
		if ($this->uid === FALSE) {
			// create a new record:
			db_insert('images')->fields(
				array(
					'filename' => $this->filename,
					'sha256' => $this->sha256,
					'unixtime' => $this->unixtime,
					'year' => $this->year,
					'month' => $this->month,
					'day' => $this->day,
					'hour' => $this->hour,
					'minute' => $this->minute,
					'filesize' => $this->filesize,
				)
			)->execute();
			$this->uid = Database::getConnection()->lastInsertId(); // print_r('Inserted UID: ' . $this->uid);
		} else {
			// update existing record:
			db_update('images')->fields(
				array(
					'filename' => $this->filename,
					'sha256' => $this->sha256,
					'unixtime' => $this->unixtime,
					'year' => $this->year,
					'month' => $this->month,
					'day' => $this->day,
					'hour' => $this->hour,
					'minute' => $this->minute,
					'filesize' => $this->filesize,
				)
			)->condition(
				'uid', $this->uid
			)->execute();
		}
	}
	
	function fromDB() {
		if ($this->uid === FALSE) {
			// TODO error message
			return FALSE;
		}
		$result = db_query('SELECT * FROM images WHERE uid=:uid', array(':uid' => $this->uid));
		if ($result->rowCount() != 1) { return FALSE; }
		
		foreach ($result as $record) {
			$this->fromDBRecord($record);
		}
	}
	
	function fromDBRecord($record) {
		$this->uid = $record->uid;
		$this->filename = $record->filename;
		$this->sha256 = $record->sha256;
		$this->unixtime = $record->unixtime;
		$this->year = $record->year;
		$this->month = $record->month;
		$this->day = $record->day;
		$this->hour = $record->hour;
		$this->minute = $record->minute;
		$this->filesize = $record->filesize;
		
		// variables will not be loaded unless a call to getStats() is made!
	}
	
	/**
	 * get image (content-related) variables from the DB table vars
	 */
	function getStats() {
		if (!$this->vars) {
			$this->vars = array();
			// extended (nominal / string / any) vars:
			$result = db_query('SELECT varname, number, alpha FROM vars WHERE imageid=:uid', array(':uid' => $this->uid));
			foreach ($result as $record) {
				$varname = $record->varname;
				$value = $record->alpha; // either alphanumeric...
				if (empty($value)) { $value = $record->number; } // or pure numeric
				$this->vars[$varname] = $value;
			}
		} 
		return $this->vars;
	}
	
	/**
	 * write additional stats to the DB (table: vars); keeps existing vars that are not overridden here.
	 */
	function setStats($setVars) {
		$this->getStats(); // sets $this->vars, if not done before
		
		foreach ($setVars as $key => $value) {
			$this->vars[$key] = $value;
		}
		
		// delete existing stats from DB:
		$this->deleteStats();
		
		foreach ($this->vars as $varname => $value) {
			$number = NULL;
			$alpha = NULL;
			if (is_numeric($value)) {
				$number = $value;
			} else {
				$alpha = $value;
			}
			db_insert('vars')->fields(
				array(
					'imageid' => $this->uid,
					'varname' => $varname,
					'number' => $number,
					'alpha' => $alpha,
				)
			)->execute();
		}
	}
	
	function deleteStats() {
		db_delete('vars')->condition('imageid', $this->uid)->execute();
	}
	
	function getFullFilename() {
		$CFG = hapebe_webcam_analytics_config();
		return $CFG['STORAGE_BASE_DIR'] . '/' . sprintf('%02d', $this->month) . '/' . sprintf('%02d', $this->day) . '/' . $this->filename;
	}
	
	static function findBySHA256($sha256) {
		$result = db_query('SELECT * FROM images WHERE sha256 LIKE :sha256', array(':sha256' => $sha256));
		if ($result->rowCount() != 1) { return FALSE; }
		
		$retval = new WebcamImage();
		foreach ($result as $record) {
			$retval->fromDBRecord($record);
		}
		
		if ($retval->uid === FALSE) return FALSE;
		return $retval;
	}
	
	static function findByUnixTime($unixtime) {
		$result = db_query('SELECT * FROM images WHERE unixtime = :unixtime', array(':unixtime' => $unixtime));
		if ($result->rowCount() != 1) { return FALSE; }
		
		$retval = new WebcamImage();
		foreach ($result as $record) {
			$retval->fromDBRecord($record);
		}
		
		if ($retval->uid === FALSE) return FALSE;
		return $retval;
	}
	
	
}