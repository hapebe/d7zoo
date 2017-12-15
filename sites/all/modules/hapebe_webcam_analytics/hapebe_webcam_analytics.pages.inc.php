<?php

/**
 * linked to menu paths
 * /webcam-analytics/import
 * /webcam-analytics/import/%
 */
function hapebe_webcam_analytics_page_import_images() {
	$t0 = time();
	
	$CFG = hapebe_webcam_analytics_config();
	
	// allow special conditions for ourselves:
	ignore_user_abort(TRUE);
	// set_time_limit(36000); // set_time_limit(0);
	
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
	
	$retval[] = '<p>' . $cnt . ' files added to the database and file storage in ' . (time()-$t0) . ' seconds.</p>';
	
	db_set_active('default');
	
	
	// return report
	return implode("\n", $retval);
}

/**
 * linked to menu paths
 * /webcam-analytics/test
 * /webcam-analytics/test/%
 * /webcam-analytics/test/%/%
 * @return string HTML code
 */
function hapebe_webcam_analytics_page_test($arg0 = FALSE, $arg1 = FALSE) {
    // if ($arg0 == '') return asdfasdf($arg1);
    
    $retval = array();
    
	$FILE_BASE_PATH = drupal_realpath(file_default_scheme() . '://');
	$FILE_BASE_PATH .= '/webcam';

	$HTTP_ROOT = base_path();

    // return implode("\n", $retval);
    
    // no (or no valid) arg0 given:
    $retval[] = l('Import new files.', 'webcam-analytics/import');
    $retval[] = l('Review images', 'webcam-analytics/view');
    // $retval[] = l('', '');

    return theme_item_list(
	array(
	    'title' => 'Features',
	    'type' => 'ul',
	    'items' => $retval,
	    'attributes' => array(),
	)
    );
}

/**
 * linked to menu path ***
 * @return string HTML code
 */
function hapebe_webcam_analytics_page_view($arg0 = FALSE) {
    // TODO: use this as a template for AJAX-based image display and navigation
	
	$retval = array();

    drupal_set_title(t('View and navigate webcam images'));

    drupal_add_library('system', 'ui');
    drupal_add_library('system', 'ui.slider');

    drupal_add_js('sites/all/modules/hapebe_webcam_analytics/js/page-slider.js', array('type' => 'file', 'scope' => 'footer'));

    $retval[] = '
<p>
<label for="amount">Chroma range:</label>
<input type="text" id="amount" style="border:0; /* color:#f6931f; */ font-weight:bold;">
</p>
<div id="slider-range"></div>
<div id="image1" style="margin-top:12px;"></div>';

    return implode("\n", $retval);
}

/**
 * belongs to the page delivered by hapebe_webcam_analytics_view()
 */
function hapebe_webcam_analytics_ajax($arg0 = FALSE) {
    // drupal_json_output(array('image' => '<img src="test.jpg" alt="text '..'">'));

    // TODO: use this as a template for AJAX-based image display and navigation
	
	$CFG = hapebe_webcam_analytics_config();
    $FILE_BASE_PATH = $CFG['FILE_BASE_PATH'];
    
    $HTTP_ROOT = base_path();
    
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
?>