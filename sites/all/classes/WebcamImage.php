<?php
class WebcamImage {
	var $uid;
	var $filename;
	var $sha256;
	var $year; var $month; var $day; var $hour;	var $minute; // all refering to UTC in the filename
	var $filesize;

	/** as in database table vars(1/2)! */
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
			$result = db_query('SELECT * FROM vars2 WHERE imageid=:uid', array(':uid' => $this->uid));
			$record = $result->fetchAssoc();
			if (!$record) return $this->vars; // there are no variables for this image!
			foreach ($record as $varname => $value) {
				if ($varname == 'imageid') continue;
				if (is_null($value)) {
					// echo 'We encountered a NULL value for '.$this->sha256.', var '.$varname; exit;
					continue; // skip NULL values
				}
				$this->vars[$varname] = $value;
			} // print_r($this->vars); exit;
		}
		return $this->vars;
	}

	/**
	 * write additional stats to the DB (table: vars); keeps existing vars (not overridden here).
	 */
	function setStats($setVars) {
		$this->getStats(); // sets $this->vars, if not done before

		foreach ($setVars as $key => $value) {
			$this->vars[$key] = $value;
		}

		// delete existing stats from DB:
		$this->deleteStats();

		// insert into vars2:
		$fields = array('imageid' => $this->uid);
		foreach ($this->vars as $varname => $value) {
			$fields[$varname] = $value;
		}
		db_insert('vars2')->fields($fields)->execute();
	}

	function deleteStats() {
		db_delete('vars2')->condition('imageid', $this->uid)->execute();
	}

	function getFormattedDate() {
		return strftime('%Y-%m-%d %H:%M', $this->unixtime);
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

	static function makeTableSQL() {
		$TABLE = 'images';

		$lines = array();
		$lines[] = 'DROP TABLE IF EXISTS '.$TABLE.';';
		$lines[] = '';
		$lines[] = 'CREATE TABLE '.$TABLE.' (';
		$lines[] = 'uid int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,';
		$lines[] = 'filename varchar(255) NOT NULL,';
		$lines[] = 'sha256 char(64) NOT NULL,';
		$lines[] = 'unixtime int(11) NOT NULL DEFAULT -1,';
		$lines[] = 'year int(11) NOT NULL,';
		$lines[] = 'month int(11) NOT NULL,';
		$lines[] = 'day int(11) NOT NULL,';
		$lines[] = 'hour int(11) NOT NULL,';
		$lines[] = 'minute int(11) NOT NULL,';
		$lines[] = 'filesize int(11) NOT NULL';
		$lines[] = ') ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT=\'webcam images\';';
		$lines[] = '';

		$lines[] = 'ALTER TABLE images';
		$lines[] = '  ADD UNIQUE KEY sha256unique (sha256),';
		$lines[] = '  ADD UNIQUE KEY filename (filename),';
		$lines[] = '  ADD KEY idx_unixtime (unixtime);';
		$lines[] = '';

		return implode("\n", $lines);
	}


}
