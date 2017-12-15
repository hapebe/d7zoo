<?php
class WebcamImage {
	var $uid;
	var $filename;
	var $sha256;
	var $year; var $month; var $day; var $hour;	var $minute; // all refering to UTC in the filename
	var $filesize;
	
	function __construct() {
		$this->uid = FALSE;
	}
	
	function toDB() {
		if ($this->uid === FALSE) {
			// create a new record:
			db_insert('images')->fields(
				array(
					'filename' => $this->filename,
					'sha256' => $this->sha256,
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
		$this->year = $record->year;
		$this->month = $record->month;
		$this->day = $record->day;
		$this->hour = $record->hour;
		$this->minute = $record->minute;
		$this->filesize = $record->filesize;
	}
	
	function getFullFilename() {
		$CFG = hapebe_webcam_analytics_config();
		return $CFG['STORAGE_BASE_DIR'] . '/' . $this->month . '/' . $this->day . '/' . $this->filename;
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
}