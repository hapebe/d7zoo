<?php
/*
Img.php

v3.00 2009-04-16 
	Migration zum Bestandteil des "cartrends" Moduls für drupal
v2.00 2006-08-31
	Img object mit Methoden zum "Selbstschreiben in die Datenbank"

enthält Objekt-Definitionen für cartrends

Abhängigkeiten:
keywords_translator.lib.php
*/

class Img {
	var $uid;
	var $touchdate;
	var $filename;
	var $filesize;
	var $sha1;
	var $width;
	var $height;
	var $tnwidth;
	var $tnheight;
	var $prvwidth;
	var $prvheight;

	var $specs;

	function Img($uid = false) {
		// all defined fields default to "false"
		$vars = array_keys(get_object_vars($this));
		foreach($vars as $var) {
			$this->$var = false;
		}
		
		// exception: specs should be an empty array
		$this->specs = array();
		
		$this->uid = $uid;
	}
	
	function toDB()	{
		global $PATH;

		// perform validity checks, generate on-the-fly data
		if (!file_exists($this->filename)) { 
			// TODO: message
			return false;
		}
		if (filesize($this->filename) == 0) { 
			// TODO: message
			return false;
		}
		if (strlen($this->sha1) == 0) {
			$this->sha1 = sha1_file($this->filename);
		}
		$this->touchdate = time();


		// delete previous version from DB, if exists
		$deleteId = false;
		if ($this->uid > 0) {
			$deleteId = $this->uid;
		} else {
			// try to find an image with the same SHA1:
			$oldUid = db_result(db_query('SELECT uid FROM {cartrends_img} WHERE sha1 LIKE %s', $this->sha1));
			if ($oldUid) {
				$this->uid = $oldUid;
				$deleteId = $this->uid;
			}
		}
		if ($deleteId) {
			db_query('DELETE FROM {cartrends_img} WHERE uid = %d', $deleteId);
			// TODO: also delete all linked table entries (specs)?
		}
		
			
	  // Dynamically compose a SQL query:
		$vars = array_keys(get_object_vars($this));
		$fields = array(); $formats = array(); $values = array();
		foreach($vars as $var) {
			
			switch ($var) {
				case 'uid': case 'filesize': case 'width': 
				case 'height': case 'tnwidth': case 'tnheight': 
				case 'prvwidth': case 'prvheight':
					// int fields:
					$fields[] = $var;
					$formats[] = '%d';
					$values[] = $this->$var;
					break;
				case 'filename': case 'sha1':
					// string fields:
					$fields[] = $var;
					$formats[] = "'%s'";
					$values[] = $this->$var; // TODO: SQL injection!
					break;
				case 'touchdate':
					// datetime fields:
					$fields[] = $var;
					$formats[] = "'%s'";
					$values[] = $this->$var;
					break;
				case 'specs':
					// transient fields: NOP.
					break;
				default:					
					// nop - TODO: log warning.
			}

		}
    $fields = implode(", ", $fields);
    $formats = implode(", ", $formats);

    $success = db_query("INSERT INTO {cartrends_img} ( $fields ) VALUES ( $formats )", $values);
    if (!$success) {
      // The query failed - better to abort the save than risk further data loss.
      return FALSE;
    } else {
    	// TODO: a bit dangerous without connection / query resource - might get mixed with parallel requests.
    	$this->uid = mysql_insert_id();
    }
		

		/*
		// specs in die DB:
		foreach ($this->specs as $userid => $userSpecs) {
			foreach ($userSpecs as $type => $specArray) {
				foreach ($specArray as $spec => $value) {
					$sql = "INSERT DELAYED INTO imgspecs (imgid,userid,type,spec,value) VALUES (".$this->uid.",".$userid.",".$type.",".$spec.",'".mysql_real_escape_string($value)."');";
					$result = @mysql_query($sql);
					if (!$result) { errlog(__FILE__."@".__LINE__.": ".mysql_error()." ( SQL = ".$sql.")"); }
				}
			}
		}
		*/

		return true;
	}
	
	function fromDB() {
		if (!isset($this->uid)) {
			drupal_set_message(t('No UID set when trying to read an image from database.'), 'error');
			return false;
		}

		$result = db_query("SELECT * FROM {cartrends_img} WHERE uid= %d", array($this->uid));
		if (!$result) {
			drupal_set_message(t('Database error.'), 'error');
			return false;
		}
		$row = db_fetch_array($result);
		if (!$row) {
			drupal_set_message(t('Image @uid not found.', array("@uid" => $this->uid)), 'error');
			return false;
		}
		
		$vars = array_keys(get_object_vars($this));
		// $fields = array(); $formats = array(); $values = array();
		foreach($vars as $var) {
			if (isset($row[$var])) {
				$this->$var = $row[$var];
			}
		}
		
		/*
		$this->specs = array();
		$sql = "SELECT * FROM imgspecs WHERE imgid=".$this->uid.";";
		$result = @mysql_query($sql);
		if (!$result) { dbErrorPage(__FILE__."@".__LINE__.": ".mysql_error()." ( SQL = ".$sql.")"); return false; }
		while ($row = mysql_fetch_array($result)) {
			extract($row);
			if (!isset($this->specs[$userid])) $this->specs[$userid] = array();
			if (!isset($this->specs[$userid][$type])) $this->specs[$userid][$type] = array();
			$this->specs[$userid][$type][$spec] = $value;
		}
		*/

		return true;
	}
	
	static function getStorageDir($type, $basename, $mode) {
		if ($type == 'preview') {
			$d = $_SERVER["DOCUMENT_ROOT"].base_path()."res/ct/prv/".mb_substr($basename, 0, 2);
			if ($mode == 'file' and (!file_exists($d))) mkdir($d);
			$d .= "/".mb_substr($basename, -2);
			if ($mode == 'file' and (!file_exists($d))) mkdir($d);
		}
		if ($type == 'thumbnail') {
			$d = $_SERVER["DOCUMENT_ROOT"].base_path()."res/ct/tn/".mb_substr($basename, 0, 2);
			if ($mode == 'file' and (!file_exists($d))) mkdir($d);
			$d .= "/".mb_substr($basename, -2);
			if ($mode == 'file' and (!file_exists($d))) mkdir($d);
		}
		if ($type == 'histogram') {
			$d = $_SERVER["DOCUMENT_ROOT"].base_path()."res/ct/hist/".mb_substr($basename, 0, 2);
			if ($mode == 'file' and (!file_exists($d))) mkdir($d);
			$d .= "/".mb_substr($basename, -2);
			if ($mode == 'file' and (!file_exists($d))) mkdir($d);
		}

		// unexpected type:
		if (!isset($d)) {
			$d = $_SERVER["DOCUMENT_ROOT"].base_path()."res/ct/misc/".mb_substr($basename, 0, 2);
			if ($mode == 'file' and (!file_exists($d))) mkdir($d);
			$d .= "/".mb_substr($basename, -2);
			if ($mode == 'file' and (!file_exists($d))) mkdir($d);
		}
		
		if ($mode == "file") return $d."/";
		if ($mode == "url") return str_replace($_SERVER["DOCUMENT_ROOT"],"",$d)."/";

		debug("No way! Illegal mode in getStorageDir!"); exit;
	}
	
	static function stdName($name) {
		$n = basename($name);
		$n = str_replace(" ","-",$n);
		$parts = explode(".", $n);
		array_pop($parts);
		$n = implode($parts);
		
		return $n;
	}
	
	function getStdName() {
		return Img::stdName($this->filename);
	}
	
	function getSpecCount() {
		$retval = 0;
		foreach ($this->specs as $userid => $userSpecs) {
			foreach ($userSpecs as $type => $specArray) {
				foreach ($specArray as $spec => $value) {
					$retval ++;
				}
			}
		}
		return $retval;
	}
	
	function isValid() {
		$result = true;
		if (!$this->uid) { $result = false; }
		if (!$this->fileName) { $result = false; }
		return $result;
	}
	
	function getThumbnailHtml(&$template = false) {
		global $PATH;

		$retval = "";
		
		if ($template === false) $template = file_get_contents($PATH."templates/browse-thumbnail.html");
		
		$fields = array();
		$fields["imgid"] = $this->uid;
		$fields["img"] = /* $HTTP_ROOT. */ "img/thumbnails/".$this->tnfile;
		$fields["imgname"] = $this->fileName;
		$fields["imgwidth"] = $this->tnwidth;
		$fields["imgheight"] = $this->tnheight;
		$fields["title"] = "(".$this->getSpecCount()." Attribute)";
		if (strlen($this->getSpec(1,2,1)) > 0) $fields["title"] = htmlentities($this->getSpec(1,2,1)) . "<br>" . $fields["title"];
		$retval = fillTemplateString($template, $fields);

		return $retval;
	}
	
	function getPreviewTabs() {
		$retval = array();
		
		$tabs = array('prv','mood','hst','smap','hmap','vmap','sxvmap');
		// top bar: tab selectors:
		$retval[] = '<div id="tabsG">';
		$tabHtml = array('<ul>');
		$first = true;
		foreach ($tabs as $id) {
			$tabHtml[] = 
				'<li>'
				.'<a id="tab_'.$id.'" '
				.($first?'class="activeTab" ':'')
				.'href="javascript:showPreviewTab(\''.$id.'\')" '
				.'onfocus="this.blur()">'
				.'<span>'.$id.'</span>'
				.'</a>'
				.'</li>';
			$first = false;
		}
		$tabHtml[] = '</ul>';
		$retval[] = implode("\n", $tabHtml);
		$retval[] = '</div>';
		
		
		foreach ($tabs as $id) {
			$display = "none";
			if ($id=='prv') $display = "block";
			$retval[] = '<div id="panel_'.$id.'" style="display:'.$display.'">';
			
			if ($id == 'prv') {
				$retval[] = '<a href="'.base_path().'cartrends/view/'.$this->uid.'/edit">'
				.'<img src="'
				.Img::getStorageDir('preview', $this->getStdName(), 'url')
				.$this->getStdName().'.jpg" '
				.'width="'.$this->prvwidth.'" '
				.'height="'.$this->prvheight.'" '
				.'alt=""></a>';
			}
		
			if ($id == 'mood') {
				$retval[] = '<img src="'
				.Img::getStorageDir('histogram', $this->getStdName(), 'url')
				.$this->getStdName().'-mood.jpg" '
				.'width="'.$this->prvwidth.'" '
				.'height="'.$this->prvheight.'" '
				.'alt="">';
			}

			if ($id == 'hmap') {
				$retval[] = '<img src="'
				.Img::getStorageDir('histogram', $this->getStdName(), 'url')
				.$this->getStdName().'-Hmap.png" '
				.'width="'.$this->prvwidth.'" '
				.'height="'.$this->prvheight.'" '
				.'alt="">';
			}

			if ($id == 'smap') {
				$retval[] = '<img src="'
				.Img::getStorageDir('histogram', $this->getStdName(), 'url')
				.$this->getStdName().'-Smap.png" '
				.'width="'.$this->prvwidth.'" '
				.'height="'.$this->prvheight.'" '
				.'alt="">';
			}

			if ($id == 'vmap') {
				$retval[] = '<img src="'
				.Img::getStorageDir('histogram', $this->getStdName(), 'url')
				.$this->getStdName().'-Vmap.png" '
				.'width="'.$this->prvwidth.'" '
				.'height="'.$this->prvheight.'" '
				.'alt="">';
			}

			if ($id == 'sxvmap') {
				$retval[] = '<img src="'
				.Img::getStorageDir('histogram', $this->getStdName(), 'url')
				.$this->getStdName().'-SxVmap.png" '
				.'width="'.$this->prvwidth.'" '
				.'height="'.$this->prvheight.'" '
				.'alt="">';
			}

			if ($id == 'hst') {
				$retval[] = '<img src="'
				.Img::getStorageDir('histogram', $this->getStdName(), 'url')
				.$this->getStdName().'-H.png" '
				.'alt="">'
		
				.'<img src="'
				.Img::getStorageDir('histogram', $this->getStdName(), 'url')
				.$this->getStdName().'-S.png" '
				.'alt="">'
		
				.'<img src="'
				.Img::getStorageDir('histogram', $this->getStdName(), 'url')
				.$this->getStdName().'-V.png" '
				.'alt="">';
			}
			
			$retval[] = '</div>';
		}

		return implode("\n", $retval);
	}
	
} //end class Img

?>