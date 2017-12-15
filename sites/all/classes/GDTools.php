<?php
/**
 * Utility routines for handlings of GD images in the context of a drupal module
 *
 * @author hapebe
 */
class GDTools {
    
    /**
     * writes a GD image to the file storage and returns an HTML img tag suitable for display on a page
     * 
     * @param type $im GD image resource
     * @param type $basename filename without extension
     * @param type $mode must be 'jpg'
     * @param type $quality 0..100
     * @return boolean success?
     */
    static function WriteAndGetHtml($im, $basename, $mode = 'jpg', $quality = 100) {
	$FILE_BASE_PATH = drupal_realpath(file_default_scheme() . '://');
	$FILE_BASE_PATH .= '/ia';
	$HTTP_ROOT = base_path();
	
	if ($mode == 'jpg') {
	    imagejpeg($im, $FILE_BASE_PATH . '/' . $basename . '.jpg', $quality);
	    return '<img src="'.$HTTP_ROOT.'sites/default/files/ia/'.$basename.'.jpg" alt="'.$basename.'" width="'.ImageSX($im).'" height="'.ImageSY($im).'">';
	}
	
	return FALSE;
    }
    
}
