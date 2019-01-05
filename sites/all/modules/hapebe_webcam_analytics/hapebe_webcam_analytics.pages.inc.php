<?php

/**
 * linked to menu paths
 * /webcam-analytics/process
 * /webcam-analytics/process/%
 * /webcam-analytics/process/%/%
 */
function hapebe_webcam_analytics_page_process($arg0 = FALSE, $arg1 = FALSE, $arg2 = FALSE) {
	$t0 = time();
	$CFG = hapebe_webcam_analytics_config();
	$retval = array();

	// allow special conditions for ourselves:
	ignore_user_abort(TRUE);
	set_time_limit(36000); // set_time_limit(0);

	$addTimeStats = FALSE;
	if ($arg0 == 'import') {
		// $retval[] = hapebe_webcam_analytics_page_import_images(); // old solution
		drupal_set_title(t('Import new images into DB and storage'));
		$retval[] = hapebe_webcam_analytics_page_async('import');
	} else if ($arg0 == 'missing-timestamps') {
		drupal_set_title(t('Correct missing UNIX timestamps of image DB records'));
		$retval[] = hapebe_webcam_analytics_page_async('missing-timestamps');
	} else if ($arg0 == 'export-csv') {
		drupal_set_title(t('Generate CSV file from image database'));
		$retval[] = hapebe_webcam_analytics_page_export_csv($arg1);
		$addTimeStats = TRUE;
	} else if ($arg0 == 'import-vars') {
		drupal_set_title(t('Import information from TXT file'));
		$retval[] = hapebe_webcam_analytics_page_import_vars($arg1);
		$addTimeStats = TRUE;
	} else if ($arg0 == 'rewrite-vars') {
		drupal_set_title(t('Reads and saves again all variables for all images (used for DB table migration / upgrading)'));
		$retval[] = hapebe_webcam_analytics_page_rewrite_vars($arg1);
		$addTimeStats = TRUE;
	} else if ($arg0 == 'jobs') {
		drupal_set_title(t('Jobs'));
		$retval[] = hapebe_webcam_analytics_page_jobs($arg1, $arg2);
		$addTimeStats = FALSE;
	} else if ($arg0 == 'calc-stats') {
		drupal_set_title(t('Calculate visual stats for one image'));
		$retval[] = hapebe_webcam_analytics_page_calc_stats($arg1);
		$addTimeStats = TRUE;
	} else if ($arg0 == 'show-variable-list') {
		drupal_set_title(t('Standard and custom variable names:'));
		$retval[] = hapebe_webcam_analytics_page_variable_list();
		$addTimeStats = TRUE;
	} else if ($arg0 == 'show-create-tables') {
		drupal_set_title(t('SQL for creating the database tables:'));
		$retval[] = hapebe_webcam_analytics_page_tables_sql();
	} else if ($arg0 == 'set-vars') {
		drupal_set_title(t('Set variables by placement in the file system'));
		$retval[] = hapebe_webcam_analytics_page_setvars($arg1);
		$addTimeStats = TRUE;

	} else if ($arg0 == 'create-video') {
		drupal_set_title(t('Create video scripts'));
		$retval[] = hapebe_webcam_analytics_page_video_scripts($arg1, $arg2);
		$addTimeStats = TRUE;
	} else if ($arg0 == 'maintenance') {

		drupal_set_title(t('Health Checks and Maintenance'));
		$retval[] = hapebe_webcam_analytics_page_maintenance($arg1);
		$addTimeStats = TRUE;
	} else if ($arg0 == 'erase-standard-vars') {
		drupal_set_title(t('Delete all calculated visual standard vars'));
		db_set_active('hapebe_webcam');
		$wv = new WebcamVars();
		$vars = $wv->getStandardVars();
		foreach ($vars as $varname) {
			// db_delete('vars')->condition('varname', $varname)->execute();
			db_update('vars2')->fields(array($varname => NULL))->execute();
		}
		db_set_active('default');
		$retval[] = '<p>Finished!</p>';
		$addTimeStats = TRUE;
	} else {
		// if we get here, no known action has been matched:
		drupal_set_message(t('%file @ %line : No action or an unknown action has been requested.', array('%file' => __FILE__, '%line' => __LINE__)), 'error');
	}

	if ($addTimeStats) $retval[] = '<p>Processing finished in ' . (time()-$t0) . ' seconds.</p>';

	return implode("\n", $retval);
}

/**
 * linked to menu path
 * /webcam-analytics/process/show-create-tables (via _page_process)
 */
function hapebe_webcam_analytics_page_tables_sql() {
	$retval = array();

	$retval[] = '<h3>-- Images:</h3><pre>';
	$retval[] = WebcamImage::makeTableSQL();
	$retval[] = '</pre>';

	$retval[] = '<h3>-- Variables:</h3><pre>';
	$wv = new WebcamVars();
	$retval[] = $wv->makeTableSQL();
	$retval[] = '</pre>';

	return implode("\n", $retval);
}

/**
 * linked to menu path
 * /webcam-analytics/process/maintenance (via _page_process)
 */
function hapebe_webcam_analytics_page_maintenance($step = FALSE) {
	$CFG = hapebe_webcam_analytics_config();
	$logFilename = $CFG['FILE_BASE_PATH'].'/maintenance.log';

	if ($step == FALSE || $step == 1) {
		return
			'<ul><li>Check for DB entries not (no longer?) matching an actual file.</li></ul>'
			.'<p>Results will be written to file: '.$logFilename.'</p>'
			.'<p>'.l('Continue maintenance...', '/webcam-analytics/process/maintenance/2')."</p>\n"
			;
	}

	if ($step == 2) {
		$log = fopen($logFilename, 'a');
		$retval = array();

		db_set_active('hapebe_webcam');

		// do we have "stale" DB records, i.e. images that do no longer exist as file?
		$uids = array();
		$result = db_query('SELECT uid FROM images');
		foreach ($result as $record) $uids[] = $record->uid;

		$cnt = 0; $delCnt = 0;
		foreach ($uids as $uid) {
			$img = new WebcamImage();
			$img->uid = $uid;
			$img->fromDB();

			$filename = $img->getFullFilename();

			if (!file_exists($filename)) {
				fputs($log, $filename . ' [#'.$uid.'] does not exist!'."\n");

				// remove variables:
				db_delete('vars2')->condition('imageid', $img->uid)->execute();
				// remove from sets:
				db_delete('sets')->condition('sha256', $img->sha256)->execute();
				// ... and remove the image record itself:
				db_delete('images')->condition('uid', $img->uid)->execute();

				$delCnt ++;
			}

			$cnt ++;
			if ($cnt % 1000 == 0) fputs($log, "processed " . $cnt . " DB records...\n");
		}

		$retval[] = '<p>Processed '.$cnt.' images in the DB, removed '.$delCnt.' stale records.</p>';

		fclose($log);
		db_set_active('default');
		return implode("\n", $retval);
	}

	return '<p>An unknown processing step has been requested.</p>';
}


/**
 * linked to menu path
 * /webcam-analytics/process/show-variable-list
 */
function hapebe_webcam_analytics_page_variable_list() {
	$retval = array();
	$wv = new WebcamVars();
	db_set_active('hapebe_webcam');
	$retval[] = '<h3>Standard Vars</h3>' . implode("<br>\n", $wv->getStandardVars());
	$retval[] = '<h3>Custom Vars</h3>' . implode("<br>\n", $wv->getNonStandardVars());
	db_set_active('default');
	return implode("\n", $retval);
}

/**
 * linked to menu path
 * /webcam-analytics/process/rewrite-vars
 */
function hapebe_webcam_analytics_page_rewrite_vars($arg0 = FALSE) {
	$CFG = hapebe_webcam_analytics_config();
	$retval = array();
	db_set_active('hapebe_webcam');

	$cnt = 0;
	// $result = db_query('SELECT DISTINCT(imageid) AS uid FROM vars');
	$result = db_query('SELECT imageid AS uid FROM vars2');
	foreach ($result as $record) {
		$img = new WebcamImage();
		$img->uid = $record->uid;
		$img->fromDB();
		$dummy = $img->getStats();
		$img->setStats(array()); // don't set any new variables...
		$cnt ++;

		// if ($cnt > 1000) break;
	}

	db_set_active('default');

	$retval[] = '<p>Rewrote '.$cnt.' images.</p>';
	return implode("\n", $retval);
}

/**
 * linked to menu path
 * /webcam-analytics/process/import-vars
 */
function hapebe_webcam_analytics_page_import_vars($arg0 = FALSE) {
	$CFG = hapebe_webcam_analytics_config();

	$retval = array();

	$BASE = $CFG['STORAGE_BASE_DIR'];
	if (!file_exists($BASE)) {
		drupal_set_message(t('%file @ %line : STORAGE_BASE_DIR is not accessible! (%s)', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $BASE)), 'error');
		return FALSE;
	}

	// looks for a TXT file to import:
	$importFilename = FALSE;
	$d = dir($BASE);
	while (FALSE !== ($entry = $d->read())) {
		if ($entry == '.' || $entry == '..') continue;
		if (is_file($BASE . '/' . $entry) && (substr($entry, -4) == '.txt')) {
			$importFilename = $entry;
		}
	}
	$d->close();
	if ($importFilename == FALSE) {
		e(__FILE__, __LINE__, 'No suitable variable import TXT file was found in ' . $BASE . ' !');
		return FALSE;
	}

	// open and examine file:
	$lines = file($BASE . '/' . $importFilename);
	// first line: column / variable names:
	$line = array_shift($lines);
	$varnames = explode("\t", $line);
	for ($i=0; $i<count($varnames); $i++) {
		$varnames[$i] = trim(str_replace('"', '', $varnames[$i]));
	}
	$idvar = array_shift($varnames);

	// only if step == 1:
	if (($arg0 == FALSE) || ($arg0 == 1)) {
		if (count($varnames) == 1) {
			$retval[] = '<p>Objects are identified by '.$idvar.', the variable name is &quot;<em>'.$varnames[0].'</em>&quot;.</p>';
			$retval[] = '<p>There are <em>'.count($lines).' lines / records</em> in the file.</p>';
			$retval[] = l('Import as variables...', '/webcam-analytics/process/import-vars/2')."<br />\n";
			$retval[] = l('Import as sets per value...', '/webcam-analytics/process/import-vars/3')."<br />\n";
		} else {
			$retval[] = '<p>Objects are identified by '.$idvar.', '.count($varnames).' variables: <em>'.implode(', ',$varnames).'</em>.</p>';
			$retval[] = '<p>There are <em>'.count($lines).' lines / records</em> in the file.</p>';
			$retval[] = l('Import as variables...', '/webcam-analytics/process/import-vars/2')."<br />\n";
		}

		$retval[] = '<p>&nbsp;</p>';
	}


	// only if step == 2 or 3:
	$createSets = array();
	if (($arg0 == 2) || ($arg0 == 3)) {
		db_set_active('hapebe_webcam');
		$nNotFound = 0;
		$nKeep = 0; // variable was already set, kept old value!
		$nOverwritten = 0; // variable was already set, wrote new value anyway!
		$nSet = 0; // variable successfully set!
		foreach ($lines as $line) {
			$tokens = explode("\t", $line);
			for ($i=0; $i<count($tokens); $i++) {
				$tokens[$i] = trim(str_replace('"', '', $tokens[$i]));
			}
			$id = array_shift($tokens);

			$img = FALSE;
			if ($idvar == 'unixtime') {
				$img = WebcamImage::findByUnixTime($id);
			} else if ($idvar == 'sha256') {
				$img = WebcamImage::findBySHA256($id);
			}
			if ($img == FALSE) {
				$nNotFound ++;
				continue;
			}

			$existingVars = $img->getStats();
			$setVars = array();
			for ($i=0; $i<count($tokens); $i++) {
				$varname = $varnames[$i];
				$value = $tokens[$i];

				if ($arg0 == 2) {
					// set variable?
					if (in_array($varname, array_keys($img->vars))) {
						// echo $varname .': existing '.$img->vars[$varname].', new '.$value."<br>\n";
						if (TRUE) { // CHANGEME, if needed!
							$nKeep ++;
							continue;
						} else {
							$nOverwritten ++;
						}
					}

					$setVars[$varname] = $value;
					$nSet ++;
				}

				if ($arg0 == 3) {
					// add to set:
					$setName = $varname.'_'.$value;
					if (!isset($createSets[$setName])) {
						$createSets[$setName] = new WebcamImageSet($setName);
					}
					$createSets[$setName]->entries[] = $img->sha256;
				}
			} // next column (variable)

			if ($arg0 == 2) {
				if (count($setVars) > 0) {
					// echo 'Setting variables for ' .$img->sha256. ': ' . print_r($setVars, true) . "<br>\n";	exit;
					$img->setStats($setVars);
				}
			}
		}

		if ($arg0 == 3) {
			// create sets:
			foreach ($createSets as $set) {
				$set->toDB();
			}
		}

		db_set_active('default');

		// print stats
		if ($arg0 == 2) {
			// set vars:
			$retval[] =
			'<p>'
			.t('Set %nSet variable values, kept %nKeep pre-existing values, overwrote %nOverwritten values, encountered %nNotFound unknown IDs.',
				array('%nSet' => $nSet, '%nKeep' => $nKeep, '%nOverwritten' => $nOverwritten, '%nNotFound' => $nNotFound)
			)
			.'</p>';
		}
		if ($arg0 == 3) {
			// create sets:
			$setStats = array();
			foreach ($createSets as $set) {
				$setStats[] = $set->name.' ('.count($set->entries).' entries)';
			}
			$retval[] = '<p>Created sets: '.implode(", \n", $setStats).'</p>';
		}

		$retval[] = '<p>&nbsp;</p>';
	}

	return implode("\n", $retval);
}



/**
 * linked to menu path
 * /webcam-analytics/process/set-vars
 */
function hapebe_webcam_analytics_page_setvars($arg0 = FALSE) {
	$CFG = hapebe_webcam_analytics_config();

	$retval = array();

	$BASE = $CFG['STORAGE_BASE_DIR'];
	if (!file_exists($BASE)) {
		drupal_set_message(t('%file @ %line : STORAGE_BASE_DIR is not accessible! (%s)', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $BASE)), 'error');
		return FALSE;
	}

	// explore first level of ~/set-var : variable name(s)
	$varnames = array();
	$d = dir($BASE . '/set-var');
	while (FALSE !== ($entry = $d->read())) {
		if ($entry == '.' || $entry == '..') continue;
		if (!is_dir($BASE . '/set-var/' . $entry)) continue; // do something about it?
		$varnames[] = $entry;
	}
	$d->close();

	// explore second level: variable values
	$values = array();
	foreach ($varnames as $varname) {
		$values[$varname] = array();
		$d = dir($BASE . '/set-var/'.$varname);
		while (FALSE !== ($entry = $d->read())) {
			if ($entry == '.' || $entry == '..' || $entry == 'Thumbs.db') continue;
			if (!is_dir($BASE . '/set-var/' . $varname . '/' .$entry)) continue; // do something about it?
			$values[$varname][] = $entry;
		}
		$d->close();
	}

	// explore third level: actual images
	$files = array();
	foreach ($varnames as $varname) {
		$files[$varname] = array();
		foreach ($values[$varname] as $value) {
			$files[$varname][$value] = array();
			$d = dir($BASE . '/set-var/'.$varname.'/'.$value);
			while (FALSE !== ($entry = $d->read())) {
				if ($entry == '.' || $entry == '..' || $entry == 'Thumbs.db') continue;
				if (!is_file($BASE . '/set-var/'.$varname.'/'.$value.'/'.$entry)) continue; // do something about it?
				$files[$varname][$value][] = $entry;
			}
			$d->close();
		}
	}

	// only if step == 1:
	if (($arg0 == FALSE) || ($arg0 == 1)) {
		// nothing works?
		$err = true;
		foreach ($varnames as $varname) {
			foreach ($values[$varname] as $value) {
				if (count($files[$varname][$value]) > 0) {
					$err = false;
				}
			}
		}
		if ($err) {
			$retval[] = '<p>Please create a sub-folder structure containing images in the storage dir: ~/set-var/[VARIABLE_NAME]/[VALUE]/*.jpg</p>';
			return implode("\n", $retval);
		}

		// okay, we have something / anything:
		$outVars = array();
		foreach ($varnames as $varname) {
			$outValues = array();
			foreach ($values[$varname] as $value) {
				$outValues[] = $value . ': ' . count($files[$varname][$value]) . ' files';
			}
			$outVars[] = '<strong>'.$varname . '</strong><ul><li>'.implode("</li>\n<li>", $outValues) . '</li></ul>' . "\n";
		}
		$retval[] = '<p>Found the following variable/value/file structure:</p>';

		$retval[] = '<ul><li>' . implode("</li>\n<li>", $outVars) . '</li></ul>' . "\n";

		$retval[] = l('Continue variable import...', '/webcam-analytics/process/set-vars/2');
		$retval[] = '<p>&nbsp;</p>';
	}


	// only if step == 2:
	if ($arg0 == 2) {
		db_set_active('hapebe_webcam');
		$nNotFound = 0;
		$nSuccess = 0;
		foreach ($varnames as $varname) {
			foreach ($values[$varname] as $value) {
				foreach ($files[$varname][$value] as $f) {
					$fullname = $BASE . '/set-var/'.$varname.'/'.$value.'/'.$f;

					// find by SHA-256
					$img = WebcamImage::findBySHA256(hash_file('sha256', $fullname));
					if($img === FALSE) {
						drupal_set_message(t('Found no database record for %s...', array('%s' => $f)), 'warn');
						$nNotFound ++;
						continue;
					}

					// set var!
					$img->setStats(array($varname => $value));
					$nSuccess ++;

					// if found, delete...
					// unlink($fullname);
				}
			}
		}
		db_set_active('default');

		// print stats
		$retval[] = '<p>'.t('Set %nSuccess variable values, encountered %nNotFound unknown files.', array('%nSuccess' => $nSuccess, '%nNotFound' => $nNotFound)).'</p>';
		$retval[] = '<p>&nbsp;</p>';
	}

	return implode("\n", $retval);
}

/**
 * linked to menu path
 * /webcam-analytics/sets
 * /webcam-analytics/sets/%[/%]
 */
function hapebe_webcam_analytics_page_sets($setId = FALSE, $verb = FALSE) {
	$retval = array();

	if ($setId == FALSE) {
		// prompt to choose a set:
		$setNames = WebcamImageSet::WELLKNOWN_SETS;
		$links = array();
		foreach ($setNames as $name) {
			$links[] = l($name . ' ***built-in***', 'webcam-analytics/sets/'.$name);
		}

		// TODO: retrieve other sets from DB
		db_set_active('hapebe_webcam');
		$result = db_query('SELECT DISTINCT(name) FROM sets');
		$customSets = array();
		foreach ($result as $record) {
			$setName = $record->name;
			if (in_array($setName, $setNames)) continue; // skip well-known setStats
			$customSets[] = $setName;
		}
		db_set_active('default');
		foreach ($customSets as $name) {
			$links[] = l($name, 'webcam-analytics/sets/'.$name);
		}


		$retval[] = theme_item_list(
		array(
			'title' => 'Please choose a set to operate on:',
			'type' => 'ul',
			'items' => $links,
			'attributes' => array(),
		)
		);

		$retval[] = '<h3>... or choose a different option:</h3>';
		$retval[] = l('Create set from missing visual stats in 7DAY', 'webcam-analytics/sets/7DAY-missing-stats/generate');

		return implode("\n", $retval);
	}

	// we have a set ID:
	if ($verb == FALSE) {
		drupal_set_title('Set: '.$setId);
		db_set_active('hapebe_webcam');

		$set = new WebcamImageSet($setId);
		$links = array();
		if (!$set->exists()) {
			db_set_active('default');
			$retval[] = '<p>This set does not exist yet.</p>';
			if (in_array($setId, WebcamImageSet::WELLKNOWN_SETS)) {
				$links[] = l('Create set '.$setId, 'webcam-analytics/sets/'.$setId.'/create');
			}
		} else {
			// the set exists:
			$set->fromDB();
			db_set_active('default');

			$retval[] = '<p><em>This set has '.count($set->entries).' entries.</em></p>';

			$links[] = l('View set '.$setId. ' (warning: not a good idea with large sets)', 'webcam-analytics/sets/'.$setId.'/view');
			$links[] =
				l('Copy files of set '.$setId.' to set-var', 'webcam-analytics/sets/'.$setId.'/copy')
				.' | '.l('... by variable (see in code!)', 'webcam-analytics/sets/'.$setId.'/copy-x');
			$links[] = l('Show variable status of set '.$setId, 'webcam-analytics/sets/'.$setId.'/var-status');
			$links[] = l('Export CSV (data for R) of set '.$setId, 'webcam-analytics/process/export-csv/'.$setId);
			$links[] = l('Delete the set (CAUTION!)', 'webcam-analytics/sets/'.$setId.'/delete');
		}

		if (count($links) > 0) {
			$retval[] = theme_item_list(
			array(
				'title' => 'Please choose an action:',
				'type' => 'ul',
				'items' => $links,
				'attributes' => array(),
			)
			);
		}

		// render menu
		return implode("\n", $retval);
	}

	// we have a verb:
	if ($verb == 'create') {
		drupal_set_title(t('Create image set'));
		$retval[] = hapebe_webcam_analytics_page_create_set($setId);
		$addTimeStats = TRUE;
	} else if ($verb == 'generate') {
		// use a custom algorithm to generate a set, e.g. the set of images with missing stats in 7DAY...
		drupal_set_title(t('Generate image set'));
		$retval[] = hapebe_webcam_analytics_page_generate_set($setId);
		$addTimeStats = TRUE;
	} else {
		// but do we have a valid set?
		db_set_active('hapebe_webcam');
		$set = new WebcamImageSet($setId);
		if (!$set->exists()) {
			db_set_active('default');
			drupal_set_message(t('%file @ %line : %setId is not a valid image set.', array('%file' => __FILE__, '%line' => __LINE__, '%setId' => $setId)), 'error');
			return FALSE;
		}
		db_set_active('default');

		if ($verb == 'view') {
			drupal_set_title(t('View image set !name', array('!name' => $setId)));
			$retval[] = hapebe_webcam_analytics_page_view_set($setId);
			$addTimeStats = TRUE;
		} else if (($verb == 'copy') || ($verb == 'copy-x')) {
			drupal_set_title(t('Copy (export) images of set !name', array('!name' => $setId)));
			$byVariable = FALSE;
			if ($verb == 'copy-x') $byVariable = TRUE;
			$retval[] = hapebe_webcam_analytics_page_copy_set($setId, $byVariable);
			$addTimeStats = TRUE;
		} else if ($verb == 'var-status') {
			// TODO
			drupal_set_title(t('Variable status of set !name', array('!name' => $setId)));
			$retval[] = hapebe_webcam_analytics_page_varstatus($setId);
			$addTimeStats = TRUE;
		} else if ($verb == 'export-csv') {
			drupal_set_title(t('Export CSV for set !name', array('!name' => $setId)));
			$retval[] = hapebe_webcam_analytics_page_export_csv($setId);
			$addTimeStats = TRUE;
		} else if ($verb == 'delete') {
			db_set_active('hapebe_webcam');
			$set->delete();
			db_set_active('default');
			drupal_set_message(t('%file @ %line : %setId has been deleted.', array('%file' => __FILE__, '%line' => __LINE__, '%setId' => $setId)), 'status');
			drupal_goto('webcam-analytics/sets');
			return;
		}
	} // end if (advanced verb)

	// return the output of the verb functions:
	return implode("\n", $retval);
}


/**
 * linked to menu paths:
 * /webcam-analytics/process/create-video[/ * / *]
 */
function hapebe_webcam_analytics_page_video_scripts($arg1 = FALSE, $arg2 = FALSE) {
	$CFG = hapebe_webcam_analytics_config();
	$outFileName = $CFG['FILE_BASE_PATH'].'/video-image-list.txt';

	$retval = array();

	// config:
	$t0 = strtotime('2017-07-31 22:00');
	$t1 = strtotime('2018-07-31 21:59');
	// filter by slice of day:
	$h0 = 0; $m0 = 0;
	$h1 = 23; $m1 = 59;

	if ($arg1 == FALSE) {
		// sub-menu:
		$retval[] = '<p>Timeframe: '.$t0.' to '.$t1.'</p>';

		$retval[] = theme_item_list(
			array(
		    'title' => 'Action options',
		    'type' => 'ul',
		    'items' => array(
					l('Create full timelapse creation script', 'webcam-analytics/process/create-video/full-script'),
					l('Identify daylight blocks', 'webcam-analytics/process/create-video/daylight-blocks'),
				),
		    'attributes' => array(),
			)
    );
		return implode("\n", $retval);
	}

	// payloads:
	$imgs = array();
	db_set_active('hapebe_webcam');
	$result = db_query(
		'SELECT uid FROM images WHERE '
		.'unixtime>=:t0 AND unixtime<=:t1 '
		.'AND hour>=:h0 AND minute>=:m0 '
		.'AND hour<=:h1 AND minute<=:m1 '
		.'ORDER BY unixtime ASC',
		array(':t0' => $t0, ':t1' => $t1, ':h0' => $h0, ':h1' => $h1, ':m0' => $m0, ':m1' => $m1)
	);
	$retval[] = '<p>' . $result->rowCount() . ' images found.</p>';
	foreach ($result as $record) {
		$img = new WebcamImage(); $img->uid = $record->uid;	$img->fromDB();
		$imgs[] = $img;
	}
	db_set_active('default');

	if (count($imgs) == 0) {
		drupal_set_message(t('%file @ %line : No images to be processed.', array('%file' => __FILE__, '%line' => __LINE__)), 'error');
		return implode("\n", $retval);
	}


	$filenames = array(); // list of image files to be included in video creation
	if ($arg1 == 'daylight-blocks') {
		// loop over days,
		// mark each minute: does it have 20 (?) consecutive daylight neighbors
		// (or missing values; or allow for 1/2 exceptions?),
		$imgTypes = array(); for ($i=0; $i<count($imgs); $i++) $imgTypes[$i] = 0; // assume not day
		for ($i = 10; $i < count($imgs)-10; $i++) {
			$img = $imgs[$i];

			$neighbors = 0;
			for ($j = $i - 10; $j < $i + 10; $j++) {
				if ($j==$i) continue; // ignore the pic itself
				if ($imgs[$j]->filesize > 36541) $neighbors++;
			}
			if ($neighbors >= 17) $imgTypes[$i] = 1; // at least twilight
		}

		// where are switching points?
		$retval[] = '<p>';
		for ($i=0; $i<count($imgs); $i++) {
			if ($i >= 1) {
				if ($imgTypes[$i-1] == 0 && $imgTypes[$i] == 1) {
					$retval[] = 'night to day at: '.$imgs[$i]->getFormattedDate()."<br>\n";
				}
				if ($imgTypes[$i-1] == 1 && $imgTypes[$i] == 0) {
					$retval[] = '&nbsp;&nbsp;day to night at: '.$imgs[$i]->getFormattedDate()."<br>\n";
				}
			}
		}
		$retval[] = '</p>';

		// extend daylight spans by > 15 minutes before and after,
		$newImgTypes = array(); for($i=0; $i<count($imgTypes); $i++) $newImgTypes[$i] = $imgTypes[$i];
		for ($i = 15; $i < count($imgs)-15; $i++) {
			for ($j = $i - 15; $j < $i + 15; $j++) {
				if ($j==$i) continue; // ignore the pic itself
				if ($imgTypes[$j] != 0) {
					$newImgTypes[$i] = 1;
					break;
				}
			}
		}
		$imgTypes = $newImgTypes;

		// create results...
		$dayImgs = array();
		for ($i=0; $i<count($imgTypes); $i++) {
			if ($imgTypes[$i] != 0) $dayImgs[] = $imgs[$i];
		}
		$imgs = $dayImgs;

	} else if ($arg1 == 'full-script') {
		// NOP?
	}

	// for all sub-commands:
	if (count($imgs) > 0) {
		$f = fopen($outFileName, 'w');
		foreach($imgs as $img) {
			$fullname = $img->getFullFilename();
			// replace the path on XENIA (web server) with the path on Ubuntu Desktop (virtual-lea):
			$fullname = str_replace('/media/sf_webcam-storage/feodora/', '/mnt/feodora/', $fullname);
			fputs($f, $fullname . "\n");
		}
		fclose($f);
		$retval[] = '<p>Image filename list ('.count($imgs).' pcs) written to <em>'.$outFileName.'</em>.</p>';
	}

	return implode("\n", $retval);
}


/**
 * linked to menu path
 * /webcam-analytics/process/[missing-timestamps]
 * /webcam-analytics/process/[import]
 * /webcam-analytics/process/[run-job]
 */
function hapebe_webcam_analytics_page_async($arg0, $arg1 = FALSE) {
	$retval = array();

    drupal_add_js('sites/all/modules/hapebe_webcam_analytics/js/page-'.$arg0.'.js', array('type' => 'file', 'scope' => 'footer', 'weight' => 0));

	drupal_add_css('#logDiv p {margin:0;}', array('type' => 'inline')); // remove margins from log messages...

	$retval[] = '<div id="statusDiv">Starting...</div>';
	$retval[] = '<div id="logDiv"></div>';

	return implode("\n", $retval);
}

/**
 * linked to menu paths:
 * /webcam-analytics/process/jobs/index
 * /webcam-analytics/process/jobs/create
 * /webcam-analytics/process/jobs/run
 */
function hapebe_webcam_analytics_page_jobs($arg1, $arg2 = FALSE) {
	$retval = array();
	if ($arg1 == 'index') {
		// menu of possible actions:
		return theme_item_list(
		array(
			'title' => 'Features',
			'type' => 'ul',
			'items' => array(
				l('Create new job', 'webcam-analytics/process/jobs/create'),
				l('Run job (sample)', 'webcam-analytics/process/jobs/run'),
			),
			'attributes' => array(),
		)
		);
	}
	if ($arg1 == 'create') {
		// TODO: let set and action be select via form
		$setName = '7DAY';
		$name = 'Calculate stats for '.$setName.' images';
		$action = 'calc-stats';

		// retrieve set:
		db_set_active('hapebe_webcam');
		$set = new WebcamImageSet($setName);
		if (!$set->exists()) {
			db_set_active('default');
			e(__FILE__, __LINE__, 'Set '.$setName.' does not exist or is empty!');
			return FALSE;
		}
		$set->fromDB();

		$job = new WebcamJob();
		$job->name = $name;	$job->action = $action;	$job->items = $set->entries;
		if (!$job->toDB()) {
			db_set_active('default');
			e(__FILE__, __LINE__, 'Failed to store the job!');
			return FALSE;
		}

		db_set_active('default');
		drupal_set_message(
			t('Job created: %job', array('%job' => $job->getFriendlyName())),
			'status'
		);

		return implode("\n", $retval);
	}

	if ($arg1 == 'run') {
		$jid = $arg2;
		if ($jid == FALSE) {
			e(__FILE__, __LINE__, 'You need to specify a job ID!');
			return FALSE;
		}

		// set jobId in javascript
		drupal_add_js('document.jid = '.$jid.';', array('type' => 'inline', 'scope' => 'footer', 'weight' => -1));
		// forward to page_async('run-job')
		return hapebe_webcam_analytics_page_async('run-job');
	}
}

/**
 * linked to menu path
 * /webcam-analytics/sets/{$name}/var-status (via _page_sets)
 */
function hapebe_webcam_analytics_page_varstatus($setId) {
	$retval = array();

	db_set_active('hapebe_webcam');
	$set = new WebcamImageSet($setId);
	if (!$set->exists()) {
		db_set_active('default');
		drupal_set_message(t('%file @ %line : Unknown set %setId ...', array('%file' => __FILE__, '%line' => __LINE__, '%setId' => $setId)), 'error');
		return;
	}
	$set->fromDB();
	$setCnt = count($set->entries);
	$retval[] = '<p><em>There are '.$setCnt.' entries in the set.</em></p>';

	$wv = new WebcamVars();

	// standard (image-based, calculated) variables:
	$retval[] = '<h3>Standard Vars</h3><pre>';
	$varnames = WebcamAnalyzer::exportVarList();
	$pristine = TRUE;
	foreach($varnames as $varname) {
		$status = $wv->getVarStatus($set, $varname);
		$missingCnt = $setCnt - $status['found'];
		if ($missingCnt > 0) {
			$pristine = FALSE;
			$retval[] = $varname.': '.$missingCnt.' values missing.';
			// $retval[] = '<p>Missing image UIDs: '.implode(", ", $status['missing']).'</p>';
		}
	}
	$retval[] = '</pre>';
	if ($pristine) {
		$retval[] = '<p><em>Vars &amp; values are pristine!</em></p>';
	}

	// custom variables:
	$retval[] = '<h3>Custom Vars</h3><pre>';
	$varnames = $wv->getNonStandardVars();
	$pristine = TRUE;
	foreach($varnames as $varname) {
		$status = $wv->getVarStatus($set, $varname);
		$missingCnt = $setCnt - $status['found'];
		$missingCnt = $status['missing'];
		//if ($missingCnt > 0) {
			$pristine = FALSE;
			$retval[] = $varname.': '.$missingCnt.' values missing.';
			// $retval[] = '<p>Missing image UIDs: '.implode(", ", $status['missing']).'</p>';
		// }
	}
	$retval[] = '</pre>';
	if ($pristine) {
		$retval[] = '<p><em>Vars &amp; values are pristine!</em></p>';
	}

	db_set_active('default');

	return implode("\n", $retval);
}


/**
 * use a custom algorithm to generate a set, e.g. the set of images with missing stats in 7DAY...
 * linked to menu path
 * /webcam-analytics/sets/{$name}/generate (via _page_sets)
 */
function hapebe_webcam_analytics_page_generate_set($name) {
	$retval = array();

	db_set_active('hapebe_webcam');

	if ($name == '7DAY-missing-stats') {

		$set = new WebcamImageSet('7DAY');
		$set->fromDB();

		$entries = array();
		foreach($set->entries as $sha256) {
			$obj = WebcamImage::findBySHA256($sha256);
			if ($obj == FALSE) {
				$retval[] = '<p>Could not find image for sha256 ' . $sha256 . '...</p>';
				continue;
			}

			$stats = $obj->getStats();
			if (!isset($stats['v_mean'])) {
				$entries[] = $sha256;
			}
		}
		if (!empty($entries)) {
			$set = new WebcamImageSet($name);
			$set->entries = $entries;
			$set->toDB();
		}

		$retval[] = '<p>Found <em>'.count($set->entries).' images</em> with missing visual stats in set 7DAY.</p>';

		db_set_active('default');
	} else {
		db_set_active('default');
		e(__FILE__, __LINE__, t('Cannot generate set %name - no procedure defined for this task.', array('%name' => $name)));
	}

	return implode("\n", $retval);
}


/**
 * linked to menu path
 * /webcam-analytics/sets/{$name}/create (via _page_sets)
 */
function hapebe_webcam_analytics_page_create_set($name) {
	$retval = array();

	$CFG = hapebe_webcam_analytics_config();
	db_set_active('hapebe_webcam');

	$entries = array();

	$targetCount = 1;

	if ($name == 'MINI') $targetCount = 10;

	if ($name == 'A1000S') $targetCount = 1000;
	if ($name == 'B1k') $targetCount = 1000;

	if ($name == '7DAY') $targetCount = 10080;
	if ($name == 'YAD7') $targetCount = 10080;

	if ($name == 'B20k') $targetCount = 20000;

	if (
		($name == 'MINI')
		|| ($name == 'A1000S')
		|| ($name == '7DAY')
		|| ($name == 'YAD7')
		|| ($name == 'B1k')
		|| ($name == 'B20k')
	) {
		$dateCondition = FALSE;
		// A1000S uses all available images!
		if (($name == 'MINI') || ($name == '7DAY') || ($name == 'YAD7') || ($name == 'B1k') || ($name == 'B20k')) {
			$dateCondition = ' WHERE (unixtime>='.$CFG['YEAR_START'].') AND (unixtime<='.$CFG['YEAR_END'].') ';
		}

		$sortOrder = 'ASC';
		if ($name == 'YAD7') $sortOrder = 'DESC';

		$sql = 'SELECT sha256, unixtime FROM images '.$dateCondition.' ORDER BY sha256 '.$sortOrder.' LIMIT 0,'.$targetCount;

		$result = db_query($sql);

		$entries = array();
		foreach ($result as $record) {
			$entries[$record->sha256] = $record->unixtime;
		}

		// sort by timestamp, ascending:
		asort($entries);
	}

	if (count($entries) > 0) {
		// store in DB:
		$set = new WebcamImageSet($name);
		foreach ($entries as $sha256 => $unixtime) {
			$set->entries[] = $sha256;
		}
		$cnt = $set->toDB();

		db_set_active('default');
		drupal_set_message(t('Created set %setId with %cnt entries.', array('%setId' => $name, '%cnt' => $cnt)), 'status');
	}

	db_set_active('default');
	drupal_goto('webcam-analytics/sets/'.$name);
}

/**
 * linked to menu path
 * /webcam-analytics/process/view-set/{$name} (via _page_process)
 */
function hapebe_webcam_analytics_page_view_set($name) {
	$retval = array();

	db_set_active('hapebe_webcam');
	$set = new WebcamImageSet($name);
	$set->fromDB();
	db_set_active('default');

	$retval[] = '<p>The set has <em>'.count($set->entries).' entries</em>.</p>';

	$line = array();
	$cnt = 0;
	foreach ($set->entries as $entry) {
		if (count($line) == 0) $line[] = '<div class="row">';

		$line[] = "\t".'<div class="col-md-3" style="display:inline-block; float:left; max-width: 24%;">'
		.'<a href="/webcam-analytics/view/'.$entry.'"><img src="/webcam-analytics/ajax/image/'.$entry.'" alt="" title="'.$entry.'" style="max-width: 100%; height: auto;"></a>'
		.'</div>';

		if (count($line) == 5) { // 4 images + opening tag...
			$line[] = '</div>';
			$retval[] = implode("\n", $line);
			$line = array();
		}

		$cnt ++;
		// if ($cnt >= 100) break;
	}
	// and the remainder, if exists:
	if (count($line) > 1) { // opening tag counts as 1...
		$line[] = '</div>';
		$retval[] = implode("\n", $line);
		$line = array();
	}

	// $retval[] = '<p>Generated set page for '.$name.'.</p>';

	return implode("\n", $retval);
}


/**
 * linked to menu path
 * /webcam-analytics/sets/{$name}/copy
 * /webcam-analytics/sets/{$name}/copy-x (use a variable to create sub-dirs!)
 */
function hapebe_webcam_analytics_page_copy_set($name, $byVariable = FALSE) {
	$CFG = hapebe_webcam_analytics_config();
	$targetDir = $CFG['STORAGE_BASE_DIR'] . '/set-var/';
	$varname = FALSE;

	if ($byVariable) {
		$varname = 'x_phase_of_day'; // TODO make this accessible from UI
		$targetDir .= $varname;
		if (!file_exists($targetDir)) mkdir($targetDir);
		$targetDir .= '/';
	}

	$retval = array();

	db_set_active('hapebe_webcam');
	$set = new WebcamImageSet($name);
	$set->fromDB();

	$cnt = 0;
	foreach ($set->entries as $entry) {
		$img = WebcamImage::findBySHA256($entry);
		$src = $img->getFullFilename();

		$currentDir = $targetDir;
		if ($byVariable) {
			$vars = $img->getStats();
			if (isset($vars[$varname])) {
				$value = $vars[$varname];
				// replace forbidden characters in variable value:
				$value = str_replace('*', '#', $value);

				$currentDir .= $value;
				if (!file_exists($currentDir)) mkdir($currentDir);
				$currentDir .= '/';
			}
		}
		copy($src, $currentDir . $img->filename);

		$cnt ++;
		// if ($cnt >= 100) break;
	}
	db_set_active('default');

	$retval[] = '<p>Copied ' . $cnt . ' files of ' . $name . ' to ' . $targetDir . '</p>';
	return implode("\n", $retval);
}


/**
 * linked to menu path
 * /webcam-analytics/process/export-csv (via _page_process)
 * /webcam-analytics/process/export-csv[/set name]
 */
function hapebe_webcam_analytics_page_export_csv($mode = FALSE) {
	$CFG = hapebe_webcam_analytics_config();
	$retval = array();

	db_set_active('hapebe_webcam');

	$outFile = 'images.csv';
	if ($mode != FALSE) {
		// is it a valid set?
		$set = new WebcamImageSet($mode);
		if (!$set->exists()) {
			drupal_set_message(t('%file @ %line : %mode is not a valid image set.', array('%file' => __FILE__, '%line' => __LINE__, '%mode' => $mode)), 'error');
			return FALSE;
		}

		// yes, it is:
		$set->fromDB();
		$outFile = 'images-'.$mode.'.csv';
	} else {
		// we include everything, using a specially defined Set:
		$set = new WebcamImageSet('ALL'); $set->fromDB();
	}

	$wv = new WebcamVars();
	$varList = $wv->getStandardVars();
	$varList = array_merge($varList, $wv->getNonStandardVars()); // print_r($varList); exit;

	// write header: variable names
	$filename = $CFG['FILE_BASE_PATH'] . '/' . $outFile;
	$f = fopen($filename, 'w');
	fputs(
		$f,
		'filename,unixtime,year,month,day,hour,minute,day_of_year,filesize,'
		.'hours_from_noon,daily_cycle_x,daily_cycle_y,days_from_midsummer,annual_cycle_x,annual_cycle_y'
		.','
		.implode(',', $varList)
		."\n"
	);

	// now cycle through the set:
	$lines = array();
	$cnt = 0;
	foreach ($set->entries as $sha256) {
		$img = WebcamImage::findBySHA256($sha256); // echo $img->uid."<br>\n";

		if ($mode == FALSE) {
			// ALL images: limit by year in scope:
			if ($img->unixtime < $CFG['YEAR_START']) continue;
			if ($img->unixtime > $CFG['YEAR_END']) continue;
		}
		$cnt ++;

		$cyclic = WebcamCyclicCalc::get($img->year, $img->month, $img->day, $img->hour, $img->minute);

		// start with the basic fields, directly from image table:
		$line = array(
			'"'.$img->filename.'"',
			$img->unixtime,
			$img->year,
			$img->month,
			$img->day,
			$img->hour,
			$img->minute,
			(date('z', $img->unixtime) + 1),
			$img->filesize,
			$cyclic['hours_from_noon'],
			sprintf('%.6f', $cyclic['dailyX']),
			sprintf('%.6f', $cyclic['dailyY']),
			$cyclic['days_from_midsummer'],
			sprintf('%.6f', $cyclic['annualX']),
			sprintf('%.6f', $cyclic['annualY']),
		);

		// okay, let's fetch the variables:
		$values = array();
		foreach ($varList as $varname) $values[$varname] = ''; // default values

		$stats = $img->getStats();
		foreach ($stats as $varname => $value) {
			if (in_array($varname, $varList)) {
				$values[$varname] = (is_numeric($value) ? $value : '"'.$value.'"');
			} else {
				$retval[] = 'Not in var list: '.$varname;
			}
		}

		// ... and write them:
		foreach ($varList as $varname) {
			$line[] = $values[$varname];
		}

		// add the record to the list:
		$lines[] = implode(',', $line);

		// once in a while, empty the buffer:
		if (count($lines) == 1000) {
			$lines[] = ''; // end with a newline...
			fputs($f, implode("\n", $lines));
			$lines = array();
			// break;
		}

	}

	// write the final batch of lines
	fputs($f, implode("\n", $lines));
	fclose($f);
	m($cnt . ' image records written to file ' . $filename . ' .');

	db_set_active('default');

	// return report
	return implode("\n", $retval);
}


/**
 * linked to menu paths
 * /webcam-analytics/process/calc-stats
 */
function hapebe_webcam_analytics_page_calc_stats($unixtime) {
	$retval = array();

	db_set_active('hapebe_webcam');
	$obj = WebcamImage::findByUnixTime($unixtime);
	if ($obj == FALSE) {
		$retval[] = 'Could not find image for unixtime ' . $unixtime;
		db_set_active('default');
		return implode("\n", $retval);
	}

	$writeFiles = TRUE;
	$retval[] = hapebe_webcam_calc_stats($obj, $writeFiles);

	db_set_active('default');

	array_unshift($retval, '<p><img src="/webcam-analytics/ajax/image/'.$unixtime.'" alt="" style="max-width: 100%; height: auto;"></p>');

	return implode("\n", $retval);
}


/**
 * OBSOLETE
 * linked to menu paths
 * /webcam-analytics/process/import (via _page_process)
 */
function hapebe_webcam_analytics_page_import_images() {
	$CFG = hapebe_webcam_analytics_config();

	$retval = array();

	// check: are import and storage dirs accessible?
	$BASE = $CFG['STORAGE_BASE_DIR'];
	if (!file_exists($BASE)) {
		drupal_set_message(t('%file @ %line : STORAGE_BASE_DIR is not accessible! (%s)', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $BASE)), 'error');
		return FALSE;
	}

	// list contents of import dir
	$candidates = array();
	$d = dir($BASE . '/import');
	while (FALSE !== ($entry = $d->read())) {
		if ($entry == '.' || $entry == '..') continue;
		$candidates[] = $entry;

		if (count($candidates) >= 1500) break;
	}
	$d->close();
	$retval[] =
		'We have '.count($candidates).' candidates for import.'
		. (count($candidates)>0 ? ' E.g. '.$candidates[0] : '');


	db_set_active('hapebe_webcam');

	$cnt = 0;
	foreach($candidates as $filename) {
		$fullname = $BASE . '/import/' . $filename;

		$parts = explode('-', $filename); // print_r($parts);
		if (count($parts) != 6) {
			drupal_set_message(t('%file @ %line : Problem with import candidate filename %s - does not have the expected name parts.', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $filename)), 'error');
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
			drupal_set_message(t('%file @ %line : Database record for %s already exists.', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $filename)), 'error');
			continue;
		}

		// move files to storage dir (with month and day)
		if (!file_exists($BASE . '/' . $obj->month)) mkdir($BASE . '/' . $obj->month);
		if (!file_exists($BASE . '/' . $obj->month . '/' . $obj->day)) mkdir($BASE . '/' . $obj->month . '/' . $obj->day);
		if (!copy($fullname, $BASE . '/' . $obj->month . '/' . $obj->day . '/' . $filename)) {
			drupal_set_message(t('%file @ %line : Could not copy %s to its storage dir.', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $BASE)), 'error');
			continue;
		}

		// create database record
		$obj->toDB();

		// finally: delete the original (to-be-imported) file
		unlink($fullname);

		$cnt ++;
	}

	$retval[] = '<p>' . $cnt . ' files added to the database and file storage.</p>';

	db_set_active('default');


	// return report
	return implode("\n", $retval);
}

/**
 * linked to menu paths
 * /webcam-analytics
 * @return string HTML code
 */
function hapebe_webcam_analytics_page_test($arg0 = FALSE, $arg1 = FALSE) {
    // if ($arg0 == '') return asdfasdf($arg1);

	$CFG = hapebe_webcam_analytics_config();
    $retval = array();

	// add some basic status info:
	db_set_active('hapebe_webcam');
	$cnt = 0; $unixtimeMin = -1; $unixtimeMax = -1;
	$result = db_query('SELECT COUNT(uid) AS cnt, MIN(unixtime) AS t0, MAX(unixtime) AS t1 FROM images');
	foreach ($result as $record) {
		$cnt = $record->cnt;
		$t0 = $record->t0;
		$t1 = $record->t1;
		break;
	}
	$retval[] = '<p>There are ' . $cnt . ' images in the database, the oldest is of ' . strftime('%F %T', $t0) . ', the newest is of ' . strftime('%F %T', $t1) . '.</p>';
	$retval[] = '<p>Whenever images from a complete year should be considered, the timeframe will range from '.strftime('%F %T', $CFG['YEAR_START']).' to '.strftime('%F %T', $CFG['YEAR_END']).'.</p>';
	db_set_active('default');

    // no (or no valid) arg0 given:
    // $retval[] = l('', '');

    $retval[] = theme_item_list(
	array(
	    'title' => 'Features',
	    'type' => 'ul',
	    'items' => array(
			l('Import new files.', 'webcam-analytics/process/import'),
			l('Health check and maintenance.', 'webcam-analytics/process/maintenance')
			. ' | ' . l('Re-write variables.', 'webcam-analytics/process/rewrite-vars'),
			l('Set variables by file system placement.', 'webcam-analytics/process/set-vars'),
			l('Import information from TXT file', 'webcam-analytics/process/import-vars'),
			l('Set operations', 'webcam-analytics/sets'),
			l('Create, manage and run batch jobs.', 'webcam-analytics/process/jobs/index'),
			l('Create video creation script(s)', 'webcam-analytics/process/create-video'),
			l('Export *COMPLETE* CSV (data for R).', 'webcam-analytics/process/export-csv')
			. ' | ' . l('(show variable list)', 'webcam-analytics/process/show-variable-list')
			. ' | ' . l('(show create tables)', 'webcam-analytics/process/show-create-tables'),
			l('Review images [IN PROGRESS]', 'webcam-analytics/view'),
			t('Analyze (calculate stats) for image file:') . ' ' . l('(sample 1)', 'webcam-analytics/process/calc-stats/1512895800')
			. ' ' . l('(2)', 'webcam-analytics/process/calc-stats/1516192920'),
			t('Deliver image file: ') . ' ' . l('(sample 1)', 'webcam-analytics/ajax/image/1512895800') . ' ' . l('(2)', 'webcam-analytics/ajax/image/1516192920'),
		),
	    'attributes' => array(),
	)
    );

    return implode("\n", $retval);
}

/**
 * linked to menu path webcam-analytics/view[/image SHA-256 or unixtime]
 * @return string HTML code
 */
function hapebe_webcam_analytics_page_view($arg0 = FALSE) {
    // TODO: use this as a template for AJAX-based image display and navigation

	$retval = array();

    drupal_set_title(t('View and navigate webcam images'));

    drupal_add_library('system', 'ui');
    drupal_add_library('system', 'ui.slider');

    drupal_add_js('sites/all/modules/hapebe_webcam_analytics/js/page-view.js', array('type' => 'file', 'scope' => 'footer'));

	db_set_active('hapebe_webcam');
	$img = FALSE;
	if ($arg0 !== FALSE) {
		if (mb_strlen($arg0) == 64) {
			$img = WebcamImage::findBySHA256($arg0);
		} else {
			$img = WebcamImage::findByUnixTime($arg0);
		}
	}

	if ($img == FALSE) {
		// find the latest image we actually have:
		$result = db_query('SELECT sha256 FROM images WHERE unixtime = (SELECT MAX(unixtime) FROM images)'); // print_r($result); exit;
		foreach ($result as $record) { // print_r($record); exit;
			$img = WebcamImage::findBySHA256($record->sha256);
			break;
		}
	}
	db_set_active('default');


	$retval[] = '<div id="dateControls">
	<form name="dateForm" id="dateForm" action="/" method="post">
		<span id="yearPrv">&lt;</span><input type="text" name="year" id="year" value="'.$img->year.'" size="4"><span id="yearNxt">&gt;</span> &nbsp;
		<span id="monthPrv">&lt;</span><input type="text" name="month" id="month" value="'.$img->month.'" size="2"><span id="monthNxt">&gt;</span>
		<span id="dayPrv">&lt;</span><input type="text" name="day" id="day" value="'.$img->day.'" size="2"><span id="dayNxt">&gt;</span>
		<span id="hourPrv">&lt;</span><input type="text" name="hour" id="hour" value="'.$img->hour.'" size="2"><span id="hourNxt">&gt;</span>
		<span id="minutePrv">&lt;</span><input type="text" name="minute" id="minute" value="'.$img->minute.'" size="2"><span id="minuteNxt">&gt;</span>
	</form>
	<span>Unix Time: </span><span id="unixtimeDiv"></span>
</div>';

	$retval[] = '<img id="mainCam" alt="" src="" style="max-width: 100%; height: auto;">';

	$retval[] = '<div id="statusDiv"></div>';


	// $retval[] = checkdate(6, 30, 2017)?'valid':'invalid' . "<br>";
	// $retval[] = checkdate(6, 31, 2017)?'valid':'invalid' . "<br>";

    return implode("\n", $retval);
}
?>
