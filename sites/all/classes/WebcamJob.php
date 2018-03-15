<?php
class WebcamJob {
	var $uid;
	var $ctime;
	var $mtime;
	var $name;
	var $action;
	var $items;
	var $totalTimeSpent;
	
	public function __construct() {
		$this->uid = FALSE;
		$this->ctime = time();
		$this->mtime = time();
		$this->items = array();
		$this->totalTimeSpent = 0;
	}
	
	function toDB() {
		if (!isset($this->name) || !isset($this->action) || empty($this->items)) {
			db_set_active('default');
			e(__FILE__, __LINE__, 'Something wrong with this WebcamJob!');
			return FALSE;
		}
		
		if ($this->uid === FALSE) {
			// find job ID
			db_insert('jobs')->fields(
				array(
					'name' => $this->name,
					'action' => $this->action,
					'ctime' => $this->ctime,
					'mtime' => $this->mtime,
					'total_time_spent' => $this->totalTimeSpent
				)
			)->execute();
			$this->uid = Database::getConnection()->lastInsertId(); // print_r('Inserted Job UID: ' . $this->uid);
			if ($this->uid == FALSE) {
				db_set_active('default');
				e(__FILE__, __LINE__, 'No valid ID for the new job found!');
				return FALSE;
			}
		} else {
			// update DB record:
			db_update('jobs')->fields(
				array(
					'name' => $this->name,
					'action' => $this->action,
					'ctime' => $this->ctime,
					'mtime' => $this->mtime,
					'total_time_spent' => $this->totalTimeSpent
				)
			)->condition(
				'uid', $this->uid
			)->execute();
		}
		
		// now, go and store job items:
		db_delete('jobitems')->condition('jid', $this->uid)->execute();
		
		$cnt = 0;
		foreach ($this->items as $sha256) {
			db_insert('jobitems')->fields(
				array(
					'jid' => $this->uid,
					'pos' => $cnt,
					'sha256' => $sha256,
				)
			)->execute();
			$cnt ++;
		}
		return TRUE;
	}
	
	function fromDB() {
		if ($this->uid === FALSE) {
			// TODO error message
			return FALSE;
		}
		
		$result = db_query('SELECT * FROM jobs WHERE uid=:uid', array(':uid' => $this->uid));
		if ($result->rowCount() != 1) { return FALSE; }
		
		foreach ($result as $record) {
			$this->fromDBRecord($record);
			// fetch items:
			$this->items = array();
			$result2 = db_query('SELECT * FROM jobitems WHERE jid=:uid ORDER BY pos ASC', array(':uid' => $this->uid));
			foreach ($result2 as $record2) {
				$this->items[] = $record2->sha256;
			}
		}
	}
	
	function fromDBRecord($record) {
		$this->uid = $record->uid;
		$this->name = $record->name;
		$this->action = $record->action;
		$this->ctime = $record->ctime;
		$this->mtime = $record->mtime;
		$this->totalTimeSpent = $record->total_time_spent;
	}
	
	function getFriendlyName() {
		return 
			'<em>#'.$this->uid.'</em> '
			.$this->name
			.' ('.strftime('%F %R', $this->ctime).'): '
			.$this->action
			.' on '.count($this->items).' items, '
			.'total time spent: '.$this->totalTimeSpent;
	}
	
}