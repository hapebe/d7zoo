<?php

class ColorCluster {

    /**
     * the centroid Color of this cluster
     * @var \Color
     */
    public $color;
    
    // coordinate in 3-D perceptive color space
    public $x;
    public $y;
    public $z;
    
    public $pxCount;
    public $marker;

    public function __construct($c) {
	if (!is_a($c, 'Color')) {
	    drupal_set_message(t('%file @ %line : need a Color object.', array('%file' => __FILE__, '%line' => __LINE__)), 'error');
	    return FALSE;
	}

	$this->color = $c;

	$xyz = $this->color->getHSLXYZ();
	$this->x = $xyz['x'];
	$this->y = $xyz['y'];
	$this->z = $xyz['z'];

	$this->marker = '';
    }

    public function getName() {
	return $this->color->getHSVName();
    }

    public function getCC() {
	return $this->color->getCC();
    }

    public function toHTML($totalPxCount = FALSE, $includeXYZ = FALSE) {
	$pxPart = '';
	if ($totalPxCount) {
	    $pxPart = sprintf("%01.2f %%", $this->pxCount / $totalPxCount * 100);
	} else {
	    $pxPart = $this->pxCount;
	}

	$fcolor = ($this->color->l < 0.5)?'fff':'000';

	$retval = '<span style="background-color:#' . $this->getCC() . '; color:#' . $fcolor . ';">'
	    . $this->getName() . " * " . $pxPart;
	if ($includeXYZ) {
	    $retval .=
		" x:" . sprintf("%01.3f", $this->x)
		. " y:" . sprintf("%01.3f", $this->y)
		. " z:" . sprintf("%01.3f", $this->z);
	}
	$retval .= "</span>\n";

	return $retval;
    }

}

?>