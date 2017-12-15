<?php
/**
 * Contains derivative *data* for an image
 *
 * @author hapebe
 */
class ImgData {
    /**
     * width of the image 
     * @var int 
     */
    public $w;
    /**
     * height of the image 
     * @var int 
     */
    public $h;
    
    
    /**
     * associative array containing freqs and (optional) vars
     * @var array
     */
    public $histData;
    
    /**
     * associative array containing misc. values about color analysis
     * @var array
     */
    public $colorData;
    
    
    /**
     * associative array containing misc. values
     * @var array
     */
    public $generalData;
    
    /**
     * a score describing the monochromous (0.0) or colorful (1.0) nature of the image
     * @var float
     */
    public $chromacityScore;
    
    function __construct() {
	$this->w = -1; $this->h = -1;
	
	$this->histData = array();
	$this->colorData = array();
	$this->generalData = array();
	
	$this->chromacityScore = -1;
    }
    
    function addHistData($name, $data) {
	if (isset($this->histData[$name])) {
	    drupal_set_message(t('%file @ %line : histData for %name is already set!', array('%file' => __FILE__, '%line' => __LINE__, '%name' => $name)), 'error');
	    return FALSE;
	}
	if (!isset($data['freqs'])) {
	    drupal_set_message(t('%file @ %line : histData must contain an array named freqs.', array('%file' => __FILE__, '%line' => __LINE__, '%name' => $name)), 'error');
	    return FALSE;
	}
	
	$this->histData[$name] = $data;
    }
    
    /**
     * @param string $name
     * @param mixed $value
     */
    function setGeneralData($name, $value) {
	$this->generalData[$name] = $value;
    }
    
    /**
     * @param string $name
     * @return mixed
     */
    function getGeneralData($name) {
	if (!isset($this->generalData[$name] )) {
	    drupal_set_message(t('%file @ %line : generalData %name is not set.', array('%file' => __FILE__, '%line' => __LINE__, '%name' => $name)), 'error');
	    return FALSE;
	}
	return $this->generalData[$name];
    }

}
