<?php

class ColorSpaceHolder {
    var $color3DProjection;

    var $hRes;
    var $sRes;
    var $vRes;
    
    var $spots;
    
    // chart representation:
    var $chartBorder = 0.05; // proportion of image size
    var $zFactor = 0.15; // shortening factor of z dimension

    /** list of filenames of multiple (animated) histogram charts - see toImg */
    var $chartFileList;
    var $mode;

    function __construct($color3DProjection = FALSE) {
	if ($color3DProjection == FALSE) {
	    $color3DProjection = new Color3DProjectionHSVBicone();
	}
	$this->color3DProjection = $color3DProjection;
	
	// default space - very general:
	$this->setHSVResolution(12, 3, 10);

	// $this->mode = -1; // debug / quick / draft
	$this->mode = 0; // normal
    }

    function clear() {
	$this->spots = array();
	// setup color space holder
	for ($h = 0; $h < $this->hRes; $h++) {
	    for ($s = 0; $s < $this->sRes; $s++) {
		for ($v = 0; $v < $this->vRes; $v++) {
		    $this->spots[$h . ";" . $s . ";" . $v] = 0;
		}
	    }
	}
    }

    function setHSVResolution($h, $s, $v) {
	$this->hRes = $h;
	$this->sRes = $s;
	$this->vRes = $v;

	$this->clear();
    }

    function addPixel($h, $s, $v) {
	$hIdx = floor($h / 360 * $this->hRes);
	if ($hIdx == $this->hRes)
	    $hIdx = 0;
	$sIdx = floor($s * $this->sRes);
	if ($sIdx == $this->sRes)
	    $sIdx = $this->sRes - 1;
	$vIdx = floor($v * $this->vRes);
	if ($vIdx == $this->vRes)
	    $vIdx = $this->vRes - 1;
	$this->spots[$hIdx . ";" . $sIdx . ";" . $vIdx] ++;
    }

    function toPOVRay3DObjects($cutOff = 0.98) {
	$pixelCount = array_sum($this->spots); // echo $pixelCount; exit;
	// $expectedPerSpot = $pixelCount / ($this->hRes * $this->sRes * $this->vRes);

	// include most frequented spots:
	arsort($this->spots);

	// decide which spots to include in the chart:
	$pixelSum = 0;
	$activeSpots = array();
	foreach ($this->spots as $hsv => $cnt) {
	    if ($cnt == 0) break; // break immediately if we encounter totally unused colors.

	    $activeSpots[$hsv] = $cnt;
	    
	    $pixelSum += $cnt;
	    if ($pixelSum >= $pixelCount * $cutOff) break; // max. $cutOff of the spots
	}

	$objects = array();
	foreach ($activeSpots as $hsv => $cnt) {
	    $hsv = explode(';', $hsv);
	    $h = $hsv[0] * (360.0 / $this->hRes);
	    $s = $hsv[1] / $this->sRes;
	    $v = $hsv[2] / $this->vRes; // echo $h.';'.$s.';'.$v.'@'.$cnt."<br>\n";
	    
	    $c = new Color($h, $s, $v, 'hsv');
	    $rgbFrac = $c->getRGBFractions();

	    $coords = $this->color3DProjection->getXYZ($c);
	    extract($coords);
	    
	    // transform them into a range of <-1, -1, -1> to <1, 1, 1>
	    $x *= 2;
	    $y *= 2;
	    $z = $z*2 - 1;
	    
	    $share = $cnt / $pixelCount; // means the theoretical max is 1.0
	    $radius = sqrt($share) / 2;
	    
	    $o = new stdClass();
	    $o->hsv = $c->getHSVName();
	    $o->cc = $c->getCC();
	    $o->x = $x; $o->y = $y; $o->z = $z;
	    $o->radius = $radius;
	    $o->r = $rgbFrac['r']; $o->g = $rgbFrac['g']; $o->b = $rgbFrac['b'];
	    $o->debug = array('pixelCount' => $cnt);
	    $objects[] = $o;
	}
	
	drupal_set_message(
	    t('There are !objects objects.', array('!objects' => count($objects)))
	);
	// print_r($objects); exit;
	
	$f = drupal_get_path('module', 'hapebe_img_analytics') . '/POVRay/scene.pov'; // echo $f; exit;
	$template = new TemplateUTF8(file_get_contents($f)); // print_r($template->getFields()); exit;
	
	$params = array(
	    'objects' => $this->makePOVRayObjects($objects),
	);
	$retval = $template->fill($params);
	
	return $retval;
    }
    
    function makePOVRayObjects($objects) {
	static $template;
	
	if (!isset($template)) {
	    $f = drupal_get_path('module', 'hapebe_img_analytics') . '/POVRay/sphere.pov'; // echo $f; exit;
	    $template = new TemplateUTF8(file_get_contents($f)); // print_r($template->getFields()); exit;
	}
	
	$retval = array();
	
	foreach ($objects as $o) {
	    $params = get_object_vars($o);
	    foreach ($params as $k => $v) {
		if (is_array($v)) {
		    $params[$k] = str_replace("\n", " ", print_r($v, true));
		}
	    }
	    $retval[] = $template->fill($params);
	} // print_r($retval); exit;
	
	return implode("\n", $retval);
    }
    
    
    function to3DObjects($cutOff = 0.98) {
	$pixelCount = array_sum($this->spots); // echo $pixelCount; exit;
	// $expectedPerSpot = $pixelCount / ($this->hRes * $this->sRes * $this->vRes);

	// include most frequented spots:
	arsort($this->spots);

	// decide which spots to include in the chart:
	$pixelSum = 0;
	$activeSpots = array();
	foreach ($this->spots as $hsv => $cnt) {
	    if ($cnt == 0) break; // break immediately if we encounter totally unused colors.

	    $activeSpots[$hsv] = $cnt;
	    
	    $pixelSum += $cnt;
	    if ($pixelSum >= $pixelCount * $cutOff) break; // max. $cutOff of the spots
	}

	$materials = array();
	$objects = array();
	foreach ($activeSpots as $hsv => $cnt) {
	    $hsv = explode(';', $hsv);
	    $h = $hsv[0] * (360.0 / $this->hRes);
	    $s = $hsv[1] / $this->sRes;
	    $v = $hsv[2] / $this->vRes; // echo $h.';'.$s.';'.$v.'@'.$cnt."<br>\n";
	    
	    $c = new Color($h, $s, $v, 'hsv');
	    $materials[$c->getCC()] = $c->getCC();

	    // $coords = $this->getXYZforHSV($h, $s, $v);
	    // $x = $coords[0];
	    // $y = $coords[1];
	    // $z = $coords[2];
	    // $coords = Color::XYZ4HSV($h, $s, $v);
	    $coords = $this->color3DProjection->getXYZ($c);
	    extract($coords);
	    
	    $share = $cnt / $pixelCount; // means the theoretical max is 1.0
	    $radius = sqrt($share) / 2;
	    
	    $o = new stdClass();
	    $o->x = $x; $o->y = $y; $o->z = $z;
	    $o->radius = $radius;
	    $o->material = $c->getCC();
	    $o->debug = array('pixelCount' => $cnt);
	    $objects[] = $o;
	}
	
	drupal_set_message(t(
	    'There are !materials materials and !objects objects.', 
	    array(
		'!materials' => count($materials),
		'!objects' => count($objects),
	)));
	// print_r($objects); exit;
	
	$f = drupal_get_path('module', 'hapebe_img_analytics') . '/js/three-page.tpl.js'; // echo $f; exit;
	$template = new TemplateUTF8(file_get_contents($f)); // print_r($template->getFields()); exit;
	
	$params = array(
	    // 'controls' => file_get_contents(drupal_get_path('module', 'hapebe_img_analytics') . '/js/controls-first-person.js'),
	    'controls' => file_get_contents(drupal_get_path('module', 'hapebe_img_analytics') . '/js/controls-orbit.js'),
	    'materials' => $this->makeThreeJSMaterials($materials),
	    'objects' => $this->makeThreeJSObjects($objects),
	);
	$js = $template->fill($params);
	
	// $outName = $filename.'.js'; // echo $outName; exit;
	// $f = fopen($outName, 'w'); fputs($f, $js); fclose($f);
	
	return $js;
    }
    
    function makeThreeJSMaterials($materials) {
	static $template;
	
	if (!isset($template)) {
	    $f = drupal_get_path('module', 'hapebe_img_analytics') . '/js/material-basic.tpl.js'; // echo $f; exit;
	    $template = new TemplateUTF8(file_get_contents($f)); // print_r($template->getFields()); exit;
	}
	
	$retval = array();
	
	foreach ($materials as $m) {
	    $retval[] = $template->fill(array('cc' => $m));
	} // print_r($retval); exit;
	
	return implode("\n", $retval);
    }
    
    function makeThreeJSObjects($objects) {
	static $template;
	
	if (!isset($template)) {
	    $f = drupal_get_path('module', 'hapebe_img_analytics') . '/js/object.tpl.js'; // echo $f; exit;
	    $template = new TemplateUTF8(file_get_contents($f)); // print_r($template->getFields()); exit;
	}
	
	$retval = array();
	
	foreach ($objects as $o) {
	    $params = get_object_vars($o);
	    $retval[] = $template->fill($params);
	} // print_r($retval); exit;
	
	return implode("\n", $retval);
    }
    
    function toImg($filename, $width, $height, $steps = 360) {
	$this->chartFileList = array();

	$filenameParts = explode(".", $filename);
	$suffix = array_pop($filenameParts);
	$filename = implode(".", $filenameParts);

	$pixelCount = array_sum($this->spots);
	$expectedPerSpot = $pixelCount / ($this->hRes * $this->sRes * $this->vRes);

	// paint most frequented spots.
	arsort($this->spots);


	// decide which spots to include in the chart:
	$i = 0;
	$activeSpots = array();
	foreach ($this->spots as $hsv => $cnt) {
	    if ($cnt == 0)
		break; // break immediately if we encounter totally unused colors.

	    $activeSpots[$hsv] = $cnt;

	    $i++;
	    if ($i >= count($this->spots) / 10)
		break; // max. 10% of the spots
	}


	$rounds = array('full', 'sliced');

	$rotationIncrement = 360 / $steps;

	$sliceMovePerFrame = 0.003 * $rotationIncrement;
	$sliceIntv = 0.08;
	$slicePos = 0.0 + $sliceIntv;

	foreach ($rounds as $round) {
	    $maxRotation = 360;
	    if ($round == 'full')
		$maxRotation = 360;
	    if ($round == 'sliced')
		$maxRotation = 720;

	    for ($rotation = 0; $rotation < $maxRotation; $rotation += $rotationIncrement) {
		$im = ImageCreateTruecolor($width, $height);
		$bg = ImageColorAllocate($im, 0xcc, 0xcc, 0xcc);
		$fg = ImageColorAllocate($im, 0x77, 0x77, 0x77);
		ImageFilledRectangle($im, 0, 0, $width, $height, $bg);

		$paintZs = array();
		$paintTasks = array(); { // draw helper lines:
		    $prevCoords = false;
		    $prevCords2 = false;
		    $prevCords3 = false;
		    for ($hIdx = 0; $hIdx < $this->hRes + 1; $hIdx++) {
			$h = $hIdx * (360 / $this->hRes);

			$coords = $this->getXYZforHSV($h, 1, 1, $rotation); // full brightness
			$coords2 = $this->getXYZforHSV($h, 1, 0.5, $rotation); // half brightness
			$coords3 = $this->getXYZforHSV($h, 0.5, 1, $rotation); // full brightness, half saturation

			if ($prevCoords) {
			    $entry = array(
				'type' => 0, // grid line
				'x0' => $prevCoords[0], 'y0' => $prevCoords[1], 'z0' => $prevCoords[2],
				'x1' => $coords[0], 'y1' => $coords[1], 'z1' => $coords[2],
			    );
			    // add task:
			    $id = count($paintZs);
			    $paintZs[$id] = min($prevCoords[2], $coords[2]);
			    $paintTasks[$id] = $entry;

			    // half-bright:
			    $entry = array(
				'type' => 0, // grid line
				'x0' => $prevCoords2[0], 'y0' => $prevCoords2[1], 'z0' => $prevCoords2[2],
				'x1' => $coords2[0], 'y1' => $coords2[1], 'z1' => $coords2[2],
			    );
			    // add task:
			    $id = count($paintZs);
			    $paintZs[$id] = min($prevCoords2[2], $coords2[2]);
			    $paintTasks[$id] = $entry;

			    // bright, half sat.:
			    $entry = array(
				'type' => 0, // grid line
				'x0' => $prevCoords3[0], 'y0' => $prevCoords3[1], 'z0' => $prevCoords3[2],
				'x1' => $coords3[0], 'y1' => $coords3[1], 'z1' => $coords3[2],
			    );
			    // add task:
			    $id = count($paintZs);
			    $paintZs[$id] = min($prevCoords3[2], $coords3[2]);
			    $paintTasks[$id] = $entry;
			}
			$prevCoords = $coords;
			$prevCoords2 = $coords2;
			$prevCoords3 = $coords3;
		    }


		    // six "corners" connected to white and to black:
		    // $corners = array(0, 90, 180, 270);
		    $corners = array(0, 60, 120, 180, 240, 300);
		    $black = $this->getXYZforHSV($h, 0, 0, $rotation);
		    $white = $this->getXYZforHSV($h, 0, 1, $rotation);
		    foreach ($corners as $h) {
			$corner = $this->getXYZforHSV($h, 1, 1, $rotation);
			// corner to white
			$steps = 20;
			for ($i = 0; $i < $steps; $i++) {
			    $from = $this->getXYZforHSV($h, $i / 20, 1, $rotation);
			    $to = $this->getXYZforHSV($h, ($i + 1) / 20, 1, $rotation);

			    $entry = array(
				'type' => 0, // grid line
				'x0' => $from[0], 'y0' => $from[1], 'z0' => $from[2],
				'x1' => $to[0], 'y1' => $to[1], 'z1' => $to[2],
			    );
			    $id = count($paintZs);
			    $paintZs[$id] = min($from[2], $to[2]);
			    $paintTasks[$id] = $entry;
			}

			// corner to black
			$steps = 20;
			for ($i = 0; $i < $steps; $i++) {
			    $from = $this->getXYZforHSV($h, 1, $i / 20, $rotation);
			    $to = $this->getXYZforHSV($h, 1, ($i + 1) / 20, $rotation);

			    $entry = array(
				'type' => 0, // grid line
				'x0' => $from[0], 'y0' => $from[1], 'z0' => $from[2],
				'x1' => $to[0], 'y1' => $to[1], 'z1' => $to[2],
			    );
			    $id = count($paintZs);
			    $paintZs[$id] = min($from[2], $to[2]);
			    $paintTasks[$id] = $entry;
			}
		    }

		    // white to black:
		    $black = $this->getXYZforHSV($h, 0, 0, $rotation);
		    $white = $this->getXYZforHSV($h, 0, 1, $rotation);
		    // task:
		    $entry = array(
			'type' => 0, // grid line
			'x0' => $black[0], 'y0' => $black[1], 'z0' => $black[2],
			'x1' => $white[0], 'y1' => $white[1], 'z1' => $white[2],
		    );
		    $id = count($paintZs);
		    $paintZs[$id] = min($black[2], $white[2]);
		    $paintTasks[$id] = $entry;
		} // end draw helper lines
		// for 'slice' round:
		$minV = $slicePos - ($sliceIntv / 2);
		$maxV = $slicePos + ($sliceIntv / 2);
		$inverted = false;
		if ($minV < 0) {
		    $minV += 1;
		    $inverted = true;
		}
		if ($maxV > 1) {
		    $maxV -= 1;
		    $inverted = true;
		}
		// move slice position for the next frame:
		$slicePos += $sliceMovePerFrame;
		if ($slicePos > 1)
		    $slicePos -= 1;
		if ($slicePos < 0)
		    $slicePos += 1;

		// color spots and their z coords:
		foreach ($activeSpots as $hsv => $cnt) {
		    // echo $hsv.'@'.$cnt."<br>";
		    $hsv = explode(';', $hsv);
		    $h = $hsv[0] * (360 / $this->hRes);
		    $s = $hsv[1] / $this->sRes;
		    $v = $hsv[2] / $this->vRes;
		    // echo $h.';'.$s.';'.$v.'@'.$cnt."<br>\n";

		    $coords = $this->getXYZforHSV($h, $s, $v, $rotation);
		    $x = $coords[0];
		    $y = $coords[1];
		    $z = $coords[2];

		    if ($round == 'sliced') {
			// include only certain v values
			// echo ($inverted?'I ':'').'minV='.$minV.'; maxV='.$maxV.'; y='.$y."<br>\n";
			if ($inverted) {
			    // v must be EITHER greater than min OR less than max
			    if (!(($y > $minV) or ( $y < $maxV)))
				continue;
			} else {
			    // normal - must be greater than min AND less than max
			    if (!(($y > $minV) and ( $y < $maxV)))
				continue;
			}
		    }

		    // $radius = floor(sqrt( ($cnt/$pixelCount*50000) ) + 0.5) + 2;
		    $relFreq = $cnt / $expectedPerSpot;
		    $radius = floor(sqrt(2 * $relFreq) + 0.5);
		    if ($radius < 1)
			continue;

		    $entry = array(
			'type' => 1,
			'h' => $h,
			's' => $s,
			'v' => $v,
			'x' => $x,
			'y' => $y,
			'z' => $z,
			'radius' => $radius
		    );

		    $id = count($paintZs);
		    $paintZs[$id] = $coords[2];
		    $paintTasks[$id] = $entry;
		}

		// painter's algorithm - execute paint tasks:
		arsort($paintZs);
		foreach ($paintZs as $id => $z) {
		    $entry = $paintTasks[$id];
		    // echo 'z: '.$z;

		    extract($entry);

		    if ($type == 0) { // grid line
			$px0 = $this->getPixelXYforXYZ($x0, $y0, $z0, $width, $height);
			$px1 = $this->getPixelXYforXYZ($x1, $y1, $z1, $width, $height);
			ImageLine($im, $px0[0], $px0[1], $px1[0], $px1[1], $fg);
		    }

		    if ($type == 1) { // color "balloon"
			$coords = $this->getPixelXYforXYZ($x, $y, $z, $width, $height);

			$rgb = Color::RGB4HSV($h, $s, $v); // echo ', RGB '; print_r($rgb); exit;
			extract($rgb);
			$c = ImageColorAllocate($im, $r, $g, $b);
			ImageFilledEllipse($im, $coords[0], $coords[1], $radius, $radius, $c);
		    }

		    // echo "<br>";
		}

		$frameOffset = 0;
		if ($round == 'sliced')
		    $frameOffset = 720;

		$outName = $filename . "-" . str_pad($rotation + $frameOffset, 4, "0", STR_PAD_LEFT) . "." . $suffix;
		ImagePNG($im, $outName);
		$this->chartFileList[] = basename($outName);

		if ($round == 'full') {
		    $outName = $filename . "-" . str_pad($rotation + 360 + $frameOffset, 4, "0", STR_PAD_LEFT) . "." . $suffix;
		    ImagePNG($im, $outName);
		    $this->chartFileList[] = basename($outName);
		}

		ImageDestroy($im);


		// exit;
	    } // next image / next rotation step
	} // next round
    }

    function getXYZforHSV($h, $s, $v, $rotation = 0) {
	// update 2015-01-10: use a pluggable color space model instead:
	$c = new Color($h, $s, $v, 'hsv');
	return $this->color3DProjection->getXYZ($c);
	
	$cx = (cos(deg2rad($h + $rotation)) * $s * $v) / 2 + 0.5; // 0 .. 1
	// classic (cone)
	// $cy = $v * (1 - $this->zFactor); // 0 .. 1-zFactor
	// fancy (double cone)
	// $cy = ( (sqrt((1-$s)*$v) + $v) / 2 ); //  * (1 - $this->zFactor); // 0 .. 1-zFactor
	// $cy = ( (((1-$s)*$v) + $v) / 2 ); //  * (1 - $this->zFactor); // 0 .. 1-zFactor

	$sFactor = (1 - $s) * $v;
	$cy = ( ($sFactor + $v) / 2 ); //  * (1 - $this->zFactor); // 0 .. 1-zFactor

	$cz = (sin(deg2rad($h + $rotation)) * $s * $v); // -1 .. +1

	return array($cx, $cy, $cz);
    }

    function getPixelXYforXYZ($x, $y = 0, $z = 0, $width = 100, $height = 100) {
	if (is_array($x)) {
	    $width = $y;
	    $height = $z;

	    $y = $x[1];
	    $z = $x[2];
	    $x = $x[0];
	}

	$px = (
	    $x + $z * $this->zFactor * 0.3
	    ) * (1 - 2 * $this->chartBorder) + $this->chartBorder
	;
	$py = (
	    $y + $z * $this->zFactor
	    ) * (1 - 2 * $this->chartBorder) + $this->chartBorder
	;

	$x0 = floor($px * $width + 0.5);
	$y0 = $height - floor($py * $height + 0.5);

	return array($x0, $y0);
    }

}

?>