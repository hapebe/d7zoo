<?php
class WebcamImageSet {
	var $name;
	var $entries; // SHA256 of the images; stored that way
	var $imageUids; // DB UIDs of the images; lazy loading via getImageUids()
	
	/** names of the well-known sets (they can be re-generated etc...) */
	const WELLKNOWN_SETS = array(
		'ALL', 'MINI', 'A1000S', '7DAY', 'YAD7',
	);
	
	function __construct($name) {
		$this->name = $name;
		$this->entries = array();
		$this->imageUids = FALSE;
	}
	
	function exists() {
		if ($this->name == 'ALL') return true;
		
		$result = db_query('SELECT COUNT(sha256) AS cnt FROM sets WHERE name LIKE :name', array(':name' => $this->name));
		foreach ($result as $record) {
			if ($record->cnt > 0) return TRUE;
		}
		
		return FALSE;
	}
	
	function fromDB() {
		if ($this->name == 'ALL') { // this is a special definition:
			$result = db_query('SELECT sha256 FROM images ORDER BY unixtime ASC');
		} else {
			$result = db_query('SELECT sha256 FROM sets WHERE name LIKE :name ORDER BY pos ASC', array(':name' => $this->name));
		}
		
		$this->entries = array();
		foreach ($result as $record) {
			$this->entries[] = $record->sha256;
		}
		return TRUE;
	}
	
	/** returns a (lazy loading) array of all the DB UIDs of this set's images */
	function getImageUids() {
		if (!$this->imageUids) {
			if ($this->name == 'ALL') { // this is a special definition:
				$result = db_query('SELECT uid FROM images ORDER BY unixtime ASC');
			} else {
				$sql = "SELECT uid FROM images WHERE sha256 IN ('".implode("', '",$this->entries)."') ORDER BY unixtime ASC"; // echo $sql; exit;
				$result = db_query($sql);
			}
			
			$this->imageUids = array();
			foreach ($result as $record) {
				$this->imageUids[] = $record->uid;
			}
		}
		
		return $this->imageUids;
	}
	
	function toDB() {
		if ($this->name == 'ALL') return FALSE;
		
		db_delete('sets')->condition('name', $this->name)->execute();
		$cnt = 0;
		foreach ($this->entries as $sha256) {
			db_insert('sets')->fields(
				array(
					'name' => $this->name,
					'pos' => $cnt,
					'sha256' => $sha256,
				)
			)->execute();
			
			$cnt ++;
		}
		return $cnt;
	}
	
	function delete() {
		$this->entries = array();
		$this->toDB(); // this will refuse writing for ALL...
	}
	
}