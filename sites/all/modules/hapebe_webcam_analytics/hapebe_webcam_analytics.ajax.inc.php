<?php
/**
 * linked to menu path:
 * webcam-analytics/ajax[/%[/%]]
 * belongs to the page delivered by hapebe_webcam_analytics_view()
 */
function hapebe_webcam_analytics_ajax($arg0 = FALSE, $arg1 = FALSE) {
    // drupal_json_output(array('image' => '<img src="test.jpg" alt="text '..'">'));

    // TODO: use this as a template for AJAX-based image display and navigation
	
	$CFG = hapebe_webcam_analytics_config();
    $FILE_BASE_PATH = $CFG['FILE_BASE_PATH'];
    
    $HTTP_ROOT = base_path();
	
	if ($arg0 == 'import') return hapebe_webcam_analytics_ajax_import();
	if ($arg0 == 'job') return hapebe_webcam_analytics_ajax_run_job();
	if ($arg0 == 'missing-timestamps') return hapebe_webcam_analytics_ajax_missing_timestamps();
	if ($arg0 == 'image-info') return hapebe_webcam_analytics_ajax_image_info($arg1);
	if ($arg0 == 'image') return hapebe_webcam_analytics_ajax_image($arg1);
	if ($arg0 == 'vars') return hapebe_webcam_analytics_ajax_vars($arg1);
	
    
    if (!isset($_POST['verb'])) return drupal_not_found();

    if ($_POST['verb'] == 'chroma2map') {
		$low = 0;
		if (isset($_POST['low'])) $low = $_POST['low'];
		$high = 0;
		if (isset($_POST['high'])) $high = $_POST['high'];

		$low /= 255;
		$high /= 255;

		$im0 = ImageCreateFromJPEG($FILE_BASE_PATH . '/unterspuelungen-florida-a-967327-690612-100000.jpg');

		$sia = new StandardImageAnalyzer($im0);
		ImageJPEG(
			$sia->makeMap(
			'chroma2', 
			array(
				'channelMode' => 'originalImg',
				'range' => array($low, $high),
			)
			), 
			$FILE_BASE_PATH . '/ajax-test.jpg', 
			100
		);

		$token = dechex(mt_rand(0,65535)).dechex(mt_rand(0,65535)).dechex(mt_rand(0,65535)).dechex(mt_rand(0,65535));



		drupal_json_output(
			array(
			'info' => print_r($_POST, TRUE),
			'image' => '<img src="'.$HTTP_ROOT.'/sites/default/files/ia/ajax-test.jpg?'.$token.'" width="'.$sia->w.'" height="'.$sia->h.'" alt="">',
			)
		);
    }
}

/**
 * run predefined jobs (and their items from the database)...
 */ 
function hapebe_webcam_analytics_ajax_run_job() {
	$BATCH_SIZE = 100;
	$MAX_TIME = 30;

    if (!isset($_POST['jid'])) return drupal_not_found();
	$jid = $_POST['jid'];
	
	// is there a job definition for this id?
	db_set_active('hapebe_webcam');
	
	$result = db_query('SELECT * FROM jobs WHERE uid=:jid', array(':jid' => $jid));
	if ($result->rowCount() == 0) {
		db_set_active('default');
		return drupal_not_found();
	} 
	foreach ($result as $record) {
		$jobName = $record->name;
		$jobAction = $record->action;
		$jobTime = $record->total_time_spent;
		break;
	}
	
	// okay, lets fetch job items:
	$result = db_query('SELECT * FROM jobitems WHERE jid=:jid ORDER BY pos ASC LIMIT 0,' . ($BATCH_SIZE), array(':jid' => $jid));
	$rowCount = $result->rowCount();
	$candidates = array();
	foreach ($result as $record) {
		$candidates[] = $record->sha256;
		if (count($candidates) >= $BATCH_SIZE) break;
	}
		
	if (count($candidates) == 0) {
		db_set_active('default');
		drupal_json_output(array(
			'finishedCount' => 0,
			'status' => 'Nothing more to do.',
		));
		return;
	}
	
	// now, execute the job
	$t0 = microtime(TRUE); // as plain float
	$done = array();
	foreach($candidates as $sha256) {
		$obj = WebcamImage::findBySHA256($sha256);
		if ($obj === FALSE) continue; // error message?
		
		// TODO: execute
		if ($jobAction == 'calc-stats') {
			$retval[] = hapebe_webcam_calc_stats($obj, FALSE); // don't write output files (CSV, image maps)
		}

		// delete the finished job items:
		db_delete('jobitems')->condition('jid', $jid)->condition('sha256', $sha256)->execute();
		$done[] = $sha256;
		
		$t1 = microtime(TRUE);
		if ($t1 - $t0 > $MAX_TIME) break;
	}
	
	// report the added processing time to DB:
	$jobTime += ($t1 - $t0);
	db_update('jobs')->fields(
		array('total_time_spent' => $jobTime)
	)->condition(
		'uid', $jid
	)->execute();
	
	// how many are still to do?
	$result = db_query('SELECT COUNT(*) AS cnt FROM jobitems WHERE jid=:jid', array(':jid' => $jid));
	foreach ($result as $record) {
		$remaining = $record->cnt; break;
	}
	
	db_set_active('default');
	
	drupal_json_output(array(
		'finishedCount' => count($done),
		'status' => strftime('%F %T') . ' - job: ' . $jobName . ' ('.$jobAction.'): ' . count($done) . ' job items finished, ' . $remaining . ' still need work...<br>'
		. $jobTime . ' total seconds spent on the job.',
		'log' => count($done) . ' items done...'
	));
	return;
}



/**
 * finds image info for a given UNIX time; also searches in the proximity and hints to available image file, if necessary.
 * linked to menu path:
 * webcam-analytics/ajax/image-info
 * expects a POST parameter:
 * 		unixtime
 */ 
function hapebe_webcam_analytics_ajax_image_info() {
    if (!isset($_POST['unixtime'])) return drupal_not_found();
    $unixtime = floor($_POST['unixtime']);

	$CFG = hapebe_webcam_analytics_config();
	db_set_active('hapebe_webcam');
	
	$retval = array();
	$retval['deltaT'] = 0; // time mismatch; negative value means earlier image.
	
	// first attempt: direct hit?
	$obj = WebcamImage::findByUnixTime($unixtime);
	if ($obj != FALSE) {
		$retval['status'] = 'hit';
		$retval['imageTime'] = $obj->unixtime;
		drupal_json_output($retval);
		db_set_active('default');
		return;
	} 
	
	// okay, no direct hit, let's look for nearby images:
	$result = db_query('SELECT sha256,unixtime FROM images WHERE (unixtime > :t0) AND (unixtime < :t1)', array(':t0' => $unixtime - 601, ':t1' => $unixtime + 601));
	if ($result->rowCount() == 0) {
		// okay, we cannot recommend an image...
		$retval['status'] = 'miss';
		unset($retval['deltaT']);
		drupal_json_output($retval);
		db_set_active('default');
		return;
	}
	
	// okay, we have some images:
	$candidatesDelta = array(); $candidatesTime = array();
	foreach ($result as $record) {
		$candidatesDelta[$record->sha256] = abs($record->unixtime - $unixtime + 1); // +1: give earlier images a headstart
		$candidatesTime[$record->sha256] = $record->unixtime;
	}
	db_set_active('default');
	
	asort($candidatesDelta); // lowest difference to desired timestamp first...
	
	foreach ($candidatesDelta as $sha256 => $deltaT) {
		$origUnixtime = $candidatesTime[$sha256];
		
		$retval['status'] = 'near miss';
		$retval['imageTime'] = $origUnixtime;
		$retval['deltaT'] = $origUnixtime - $unixtime;
		drupal_json_output($retval);
		
		break;
	}
	return;
}



/**
 * return JSON-encoded variables stored for an image
 * linked to menu path:
 * webcam-analytics/ajax/vars/{$unixtime} OR {$sha256}
 */ 
function hapebe_webcam_analytics_ajax_vars($param) {
	db_set_active('hapebe_webcam');

	$img = FALSE;
	if (mb_strlen($param) == 64) {
		$img = WebcamImage::findBySHA256($param);
	} else {
		$img = WebcamImage::findByUnixTime($param);
	}
	
	if ($img == FALSE) {
		drupal_add_http_header('Status', '404 Not Found');
		drupal_json_output(array(
			'status' => t('%file @ %line : no image file for key %p!', array('%file' => __FILE__, '%line' => __LINE__, '%p' => $param))
		));
		return;
	}
	
	// we have an image:
	$vars = $img->getStats();
	drupal_json_output($vars);
}

/**
 * return an actual image (file) for a given time...
 * linked to menu path:
 * webcam-analytics/ajax/image/{$unixtime} OR {$sha256}
 */ 
function hapebe_webcam_analytics_ajax_image($param) {
	$CFG = hapebe_webcam_analytics_config();
	db_set_active('hapebe_webcam');
	
	$obj = FALSE;
	if (mb_strlen($param) == 64) {
		$obj = WebcamImage::findBySHA256($param);
	} else {
		$obj = WebcamImage::findByUnixTime($param);
	}
	
	if ($obj == FALSE) {
		// TODO: more refined handling (find images in proximity...)
		
		drupal_add_http_header('Status', '404 Not Found');
		drupal_json_output(array(
			'status' => t('%file @ %line : no image file for time %t!', array('%file' => __FILE__, '%line' => __LINE__, '%t' => $param))
		));
	} else {
		$cachedFilename = $CFG['FILE_BASE_PATH'].'/image-cache/'.$obj->filename;
		$uri = 'public://webcam/image-cache/'.$obj->filename;
		// do we already have a cached version of the image?
		if (!file_exists($cachedFilename)) {
			// print_r($obj->getFullFilename()); exit;
			copy($obj->getFullFilename(), $cachedFilename);
		}
	}
	
	db_set_active('default');
	
	if ($obj != FALSE) {
		// print_r($cachedFilename); exit;
		// $scheme = file_uri_scheme('file://' . $cachedFilename); print_r($scheme); exit;
		// print_r(file_stream_wrapper_valid_scheme('file')); exit;
		file_transfer($uri, array(
			'Status' => '200 OK',
			'Content-Type'  => 'image/jpeg',
			'Content-Length' => filesize($cachedFilename)
		));
	}
	
	return;
}


/**
 * search for missing unixtime fields, update images accordingly...
 */ 
function hapebe_webcam_analytics_ajax_missing_timestamps() {
	$BATCH_SIZE = 100;
	
	// are there any image records without unixtime?
	db_set_active('hapebe_webcam');
	
	$result = db_query('SELECT sha256 FROM images WHERE unixtime=-1 LIMIT 0,' . ($BATCH_SIZE + 1000));
	$rowCount = $result->rowCount();
	$candidates = array();
	foreach ($result as $record) {
		$candidates[] = $record->sha256;
		if (count($candidates) >= $BATCH_SIZE) break;
	}
		
	if (count($candidates) == 0) {
		db_set_active('default');
		drupal_json_output(array(
			'finishedCount' => 0,
			'status' => 'Nothing more to do.',
		));
		return;
	}
	
	foreach($candidates as $sha256) {
		$obj = WebcamImage::findBySHA256($sha256);
		$obj->unixtime = mktime($obj->hour, $obj->minute, 0, $obj->month, $obj->day, $obj->year);
		$obj->toDB();
	}
	
	db_set_active('default');
	$n = count($candidates);
	drupal_json_output(array(
		'finishedCount' => $n,
		'status' => strftime('%F %T') . ': ' . $n . ' unix timestamps updated, at least '.($rowCount - $n).' still need work...',
		'log' => $n . ' unix timestamps updated...'
	));
	return;
}

/**
 * linked to menu path:
 * webcam-analytics/ajax/import via webcam-analytics/process/import
 * import new images from directory into DB, move them to their mon-day storage folders
 */ 
function hapebe_webcam_analytics_ajax_import() {
	$t0 = time();
	$CFG = hapebe_webcam_analytics_config();
	
	$status = array();
	$log = array();
	
	// check: are import and storage dirs accessible?
	$BASE = $CFG['STORAGE_BASE_DIR'];
	if (!file_exists($BASE)) {
		drupal_json_output(array(
			'finishedCount' => 0,
			'status' => t('%file @ %line : STORAGE_BASE_DIR is not accessible! (%s)', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $BASE))
		));
		return;
	}
	
	// list contents of import dir
	$candidates = array();
	$d = dir($BASE . '/import');
	while (FALSE !== ($entry = $d->read())) {
		if ($entry == '.' || $entry == '..') continue;
		$candidates[] = $entry;
		
		if (count($candidates) >= 500) break;
	}
	$d->close();
	
	if (count($candidates) == 0) {
		drupal_json_output(array(
			'finishedCount' => 0,
			'status' => t('Nothing to be imported.'),
		));
		return;
	}
	
	$status[] = '<p>We have '.count($candidates).' candidates for import; e.g. '.$candidates[0].'</p>';
	
	
	db_set_active('hapebe_webcam');
	
	$cnt = 0;
	foreach($candidates as $filename) {
		$fullname = $BASE . '/import/' . $filename;
		
		$parts = explode('-', $filename); // print_r($parts);
		if (count($parts) != 6) {
			$log[] = t('%file @ %line: Problem with import candidate filename %s - does not have the expected name parts.', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $filename));
			continue;
		}
		
		$obj = new WebcamImage();
		$obj->filename = $filename;
		$obj->year = $parts[1];
		$obj->month = $parts[2];
		$obj->day = $parts[3];
		$obj->hour = $parts[4];
		$obj->minute = str_replace('.jpg', '', strtolower($parts[5]));
		$obj->unixtime = mktime($obj->hour, $obj->minute, 0, $obj->month, $obj->day, $obj->year);
		$obj->filesize = filesize($fullname);
		$obj->sha256 = hash_file ('sha256', $fullname); // print_r($obj);

		
		// do we already have this file (SHA-256)?
		if(WebcamImage::findBySHA256($obj->sha256) !== FALSE) {
			$log[] = t('%file @ %line: Database record for %s already exists.', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $filename));
			
			// move to duplicates folder:
			if (!file_exists($BASE . '/duplicates')) mkdir($BASE . '/duplicates');
			if (copy($fullname, $BASE . '/duplicates/' . $filename)) {
				if (!unlink($fullname)) {
					$log[] = t('%file @ %line: Could not unlink *duplicate* %s', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $fullname));
				}
			}
			
			continue;
		}
		
		// move files to storage dir (with month and day)
		if (!file_exists($BASE . '/' . $obj->month)) mkdir($BASE . '/' . $obj->month);
		if (!file_exists($BASE . '/' . $obj->month . '/' . $obj->day)) mkdir($BASE . '/' . $obj->month . '/' . $obj->day);
		$targetFullname = $BASE . '/' . $obj->month . '/' . $obj->day . '/' . $filename;
		if (!copy($fullname, $targetFullname)) {
			$log[] = t('%file @ %line: Could not copy %s to its storage: %target', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $fullname, '%target' => $targetFullname));
			continue;
		}

		// create database record
		$obj->toDB();
		$log[] = t('Successfully imported %f .', array('%f' => $filename));
		
		// finally: delete the original (to-be-imported) file
		if (!unlink($fullname)) {
			$log[] = t('%file @ %line: Could not unlink %s', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $fullname));
		}
		
		$cnt ++;
		
		if (time() - $t0 > 30) break; // take a break every 30 seconds at least...
	}
	
	$status[] = '<p>' . $cnt . ' files added to the database and file storage in '.(time() - $t0).' seconds.</p>';
	
	db_set_active('default');
	
	// return report:
	drupal_json_output(array(
		'finishedCount' => $cnt,
		'status' => implode("<br>\n", $status),
		'log' => implode("<br>\n", $log)
	));
	return;
	
}