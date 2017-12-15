<?php
/**
 * abstract base class for:
 * mathematical projection of a Color into an arbitrary 3D space (containing 
 * methods for the inverse projection as well, so has to be bidirectional)
 *
 * @author hapebe
 */
class Color3DProjection {

    public $xScale;
    public $yScale;
    public $zScale;
    
    static function GetInstance() {
	return NULL; // abstract!
    }
    
    function RGB2XYZ($p0, $p1 = FALSE, $p2 = FALSE) {
	drupal_set_message(t('%file @ %line : Color3DProjection is abstract and should not be used directly.', array('%file' => __FILE__, '%line' => __LINE__)), 'error', FALSE);
	return array('x' => 0, 'y' => 0, 'z' => 0);
    }
    
    function HSV2XYZ($p0, $p1 = FALSE, $p2 = FALSE) {
	drupal_set_message(t('%file @ %line : Color3DProjection is abstract and should not be used directly.', array('%file' => __FILE__, '%line' => __LINE__)), 'error', FALSE);
	return array('x' => 0, 'y' => 0, 'z' => 0);
    }
    
    function getXYZ($c) {
	drupal_set_message(t('%file @ %line : Color3DProjection is abstract and should not be used directly.', array('%file' => __FILE__, '%line' => __LINE__)), 'error', FALSE);
	return array('x' => 0, 'y' => 0, 'z' => 0);
    }
    
    function getColor($p0, $p1 = FALSE, $p2 = FALSE) {
	drupal_set_message(t('%file @ %line : Color3DProjection is abstract and should not be used directly.', array('%file' => __FILE__, '%line' => __LINE__)), 'error', FALSE);
	return new Color(0, 0, 0);
    }
}
