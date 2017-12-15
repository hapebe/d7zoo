<?php

/**
 * linked to menu paths
 * /ia/test
 * /ia/test/%
 * /ia/test/%/%
 * @return string HTML code
 */
function hapebe_img_analytics_page_test($arg0 = FALSE, $arg1 = FALSE) {
    if ($arg0 == 'ec') return hapebe_img_analytics_page_ec($arg1);
    
    if ($arg0 == 'slider') return hapebe_img_analytics_page_slider($arg1);
    if ($arg0 == 'ajax') return hapebe_img_analytics_ajax($arg1);
    
    $retval = array();
    
    $verbs = array('maps-histos', 'colorspace-imgs', 'clusters', '3d');
    if (in_array($arg0, $verbs)) {
	$config = hapebe_img_analytics_config();
	$files = $config['files'];

	$FILE_BASE_PATH = drupal_realpath(file_default_scheme() . '://');
	$FILE_BASE_PATH .= '/ia';

	// $HTTP_ROOT = base_path();

	// return hapebe_img_analytics_page_cluster_test();

	foreach ($files as $filename) {
	    $nakedName = explode('.', basename($filename));
	    if (count($nakedName) > 1) array_pop($nakedName);
	    $nakedName = implode('.', $nakedName); // echo $nakedName;
	    // rescale the image so that it is as close to ... pixels absolute size:
	    $PIXEL_COUNT_OPT = $config['PIXEL_COUNT_OPT'];
	    $size = ImageAnalyzer::GetTargetSize($filename, $PIXEL_COUNT_OPT);

	    if (FX::endswith('.jpg', mb_strtolower($filename))) {
		$im0 = ImageCreateFromJPEG($filename);
	    } else if (FX::endswith('.png', mb_strtolower($filename))) {
		$im0 = ImageCreateFromPNG($filename);
	    } else {
		drupal_set_message(t('%file @ %line : Cannot read image format! (%s)', array('%file' => __FILE__, '%line' => __LINE__, '%s' => $filename)), 'error');
		continue;
	    }

	    $im1 = ImageCreateTrueColor($size['width'], $size['height']);
	    ImageCopyResampled($im1, $im0, 0, 0, 0, 0, ImageSX($im1), ImageSY($im1), ImageSX($im0), ImageSY($im0));

	    // rescaled orig image:
	    $retval[] = GDTools::WriteAndGetHtml($im1, $nakedName . '-' . $PIXEL_COUNT_OPT);

	    if ($arg0 == 'maps-histos') {
		// maps and histograms:
		$retval[] = hapebe_img_analytics_page_maps_and_histos($im1, $nakedName);
	    } else if ($arg0 == 'colorspace-imgs') {
		// color space animation / video:
		$retval[] = hapebe_img_analytics_page_analyze_colors1($im1, $nakedName);
	    } else if ($arg0 == 'clusters') {
		// color cluster analysis:
		$retval[] = hapebe_img_analytics_page_analyze_colors2($im1, $nakedName);
	    } else if ($arg0 == '3d') {
		// Three.js / WebGL 3D object output:
		$retval[] = hapebe_img_analytics_page_analyze_colors3($im1, $nakedName);
	    }

	}
    return implode("\n", $retval);
    }
    
    // no (or no valid) arg0 given:
    $retval[] = l('Select and display a chroma range.', 'ia/test/slider');
    $retval[] = l('Experimental charts of color gradients, commented and explained.', 'ia/test/ec');
    $retval[] = l('Show color / channel maps and histograms.', 'ia/test/maps-histos');
    $retval[] = l('Prepare a rotating color space histograms (bitmap images + animation scripts).', 'ia/test/colorspace-imgs');
    $retval[] = l('Perform a color cluster analysis.', 'ia/test/clusters');
    $retval[] = l('Generate a 3D model (Three.js) of the color space histogram.', 'ia/test/3d');

    return theme_item_list(
	array(
	    'title' => 'Features',
	    'type' => 'ul',
	    'items' => $retval,
	    'attributes' => array(),
	)
    );
}

function hapebe_img_analytics_page_analyze_colors2($im, $name) {
    $gdc = new GDContext($im);
    
    $sia = new StandardImageAnalyzer($gdc->im);
    $sia->makeHistogramData();
    
    $ca = new ColorAnalyzer2($gdc, $sia->imgData, $name);
    
    return $ca->analyzeColors();
}

function hapebe_img_analytics_page_analyze_colors3($im, $name) {
    $retval = array();
    // $retval[] = GDTools::WriteAndGetHtml($im, $name); // already done in the page procedure
    
    // test XYZ algorithm for color space:
    if (FALSE) {
	$retval = array();
	$patches = array(
	    new Color(0, 0, 0),
	    new Color(0, 1, 1, 'hsv'),
	    new Color(60, 1, 1, 'hsv'),
	    new Color(120, 1, 1, 'hsv'),
	    new Color(180, 1, 1, 'hsv'),
	    new Color(240, 1, 1, 'hsv'),
	    new Color(300, 1, 1, 'hsv'),
	    new Color(255, 255, 255),
	);
	foreach ($patches as $c) {
	    $retval[] = '<div style="background-color:#'.$c->getCC().';">&nbsp;</div>';
	    $retval[] = $c->getHSVName();

	    $xyz = $c->getHSLXYZ();
	    extract($xyz);
	    $retval[] = '('.$x.';'.$y.';'.$z.')';

	    $retval[] = '<br>';
	}
	return implode("\n", $retval);
    }
    
    
    $gdc = new GDContext($im);
    
    $sia = new StandardImageAnalyzer($gdc->im);
    $sia->makeHistogramData();
    
    $ca = new ColorAnalyzerThree($gdc, $sia->imgData, $name);
    
    
    $retval[] = $ca->analyzeColors();
	
	$retval[] = '<p><a href="http://localhost/bootstrap/colors.html" target="_blank">Open output HTML / Three.JS model</a></p>';
    
    return implode("\n", $retval);
}



function hapebe_img_analytics_page_cluster_test() {
    $clusters = array();
    $clusters[] = new ColorCluster(new Color(0, 0, 0, 'hsv'));
    $clusters[] = new ColorCluster(new Color(0, 0, 1, 'hsv'));
    $clusters[] = new ColorCluster(new Color(0, 0.5, 1, 'hsv'));
    
    $hues = array(0, 30, 60, 90, 120, 150, 180, 210, 240, 270, 300, 330);
    foreach ($hues as $h) {
	$clusters[] = new ColorCluster(new Color($h, 1, 1, 'hsv'));
    }
    
    $csv = new UTF8Spreadsheet();
    
    $x = 0;
    foreach ($clusters as $c0) {
	$csv->setColName($x, $c0->toHTML(FALSE, FALSE));
	
	$y = 0;
	foreach ($clusters as $c1) {
	    if ($x==0) $csv->setRowName($y, $c1->toHTML(FALSE, FALSE));
	    
	    $d = Color::HSLDistance($c0->color, $c1->color);
	    $csv->setValue($x, $y, sprintf("%01.2f", $d));
	    
	    $y++;
	}
	
	$x++;
    }
    
    return $csv->toHTMLTable();    
}

function hapebe_img_analytics_page_analyze_colors1($im, $name) {
    $gdc = new GDContext($im);
    
    $sia = new StandardImageAnalyzer($gdc->im);
    $sia->makeHistogramData();
    
    $ca = new ColorAnalyzer1($gdc, $sia->imgData, $name);
    
    return $ca->analyzeColors();
}

function hapebe_img_analytics_page_maps_and_histos($im, $name) {
    $sia = new StandardImageAnalyzer($im);
    
    
    $s = array();
    $s[] = '<figure style="margin:0;">';
    $s[] = GDTools::WriteAndGetHtml($sia->makeMap('ri'), $name.'-ri');
    $s[] = '<figcaption>';
    $s[] = 'red channel (as greyscale)';
    $s[] = '</figcaption></figure>';
    $retval[] = implode("\n", $s);
    
    $s = array();
    $s[] = '<figure style="margin:0;">';
    $s[] = GDTools::WriteAndGetHtml($sia->makeMap('gi'), $name.'-gi');
    $s[] = '<figcaption>';
    $s[] = 'green channel (as greyscale)';
    $s[] = '</figcaption></figure>';
    $retval[] = implode("\n", $s);
    
    $s = array();
    $s[] = '<figure style="margin:0;">';
    $s[] = GDTools::WriteAndGetHtml($sia->makeMap('bi'), $name.'-bi');
    $s[] = '<figcaption>';
    $s[] = 'blue channel (as greyscale)';
    $s[] = '</figcaption></figure>';
    $retval[] = implode("\n", $s);
    

    $s = array();
    $s[] = '<figure style="margin:0;">';
    $s[] = GDTools::WriteAndGetHtml($sia->makeMap('rc'), $name.'-rc');
    $s[] = '<figcaption>';
    $s[] = 'red channel';
    $s[] = '</figcaption></figure>';
    $retval[] = implode("\n", $s);
    
    $s = array();
    $s[] = '<figure style="margin:0;">';
    $s[] = GDTools::WriteAndGetHtml($sia->makeMap('gc'), $name.'-gc');
    $s[] = '<figcaption>';
    $s[] = 'green channel';
    $s[] = '</figcaption></figure>';
    $retval[] = implode("\n", $s);
    
    $s = array();
    $s[] = '<figure style="margin:0;">';
    $s[] = GDTools::WriteAndGetHtml($sia->makeMap('bc'), $name.'-bc');
    $s[] = '<figcaption>';
    $s[] = 'blue channel';
    $s[] = '</figcaption></figure>';
    $retval[] = implode("\n", $s);
    
    $retval[] = '<hr>';
    

    $s = array();
    $s[] = '<figure style="margin:0;">';
    $s[] = GDTools::WriteAndGetHtml($sia->makeMap('chroma'), $name.'-chromamap');
    $s[] = '<figcaption>';
    $s[] = 'chroma';
    $s[] = '</figcaption></figure>';
    $retval[] = implode("\n", $s);
    
    $s = array();
    $s[] = '<figure style="margin:0;">';
    $s[] = GDTools::WriteAndGetHtml(
	$sia->makeMap(
	    'chroma2', array(
	    'range' => array(0.2, 0.7),
	    )
	), 
	$name . '-c2map-20-70'
    );
    $s[] = '<figcaption>';
    $s[] = 'chroma2 (within range .2 .. .7)';
    $s[] = '</figcaption></figure>';
    $retval[] = implode("\n", $s);
    
    
    $s = array();
    $s[] = '<figure style="margin:0;">';
    $s[] = GDTools::WriteAndGetHtml($sia->makeMap('hue', array('chromaCutOff' => 0.2)), $name.'-huemap');
    $s[] = '<figcaption>';
    $s[] = 'hue (chroma cut-off: 0.2)';
    $s[] = '</figcaption></figure>';
    $retval[] = implode("\n", $s);
    
    
    
    $retval[] = '<hr>';
    
    
    
    $sia->makeHistogramData();
    // $retval[] = '<p>Chromacity: ' . $sia->imgData->chromacityScore . '</p>';
    $retval[] = GDTools::WriteAndGetHtml($sia->makeHistogram('r'), $name.'-r');
    $retval[] = GDTools::WriteAndGetHtml($sia->makeHistogram('g'), $name.'-g');
    $retval[] = GDTools::WriteAndGetHtml($sia->makeHistogram('b'), $name.'-b');
    $retval[] = GDTools::WriteAndGetHtml($sia->makeHistogram('l'), $name.'-l');
    $retval[] = GDTools::WriteAndGetHtml($sia->makeHistogram('s'), $name.'-s');
    $retval[] = GDTools::WriteAndGetHtml($sia->makeHistogram('chroma'), $name.'-chroma');
    $retval[] = GDTools::WriteAndGetHtml($sia->makeHistogram('chroma1'), $name.'-c1');
    $retval[] = GDTools::WriteAndGetHtml($sia->makeHistogram('chroma2'), $name.'-c2');
    $retval[] = GDTools::WriteAndGetHtml($sia->makeHistogram('hue'), $name.'-hue');
    
    return implode("\n", $retval);
}



/**
 * linked to menu path /ia/test/slider
 * @return string HTML code
 */
function hapebe_img_analytics_page_slider($arg0 = FALSE) {
    $retval = array();

    drupal_set_title(t('Chroma range map'));

    drupal_add_library('system', 'ui');
    drupal_add_library('system', 'ui.slider');

    drupal_add_js('sites/all/modules/hapebe_img_analytics/js/page-slider.js', array('type' => 'file', 'scope' => 'footer'));

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
 * linked to menu path /ia/test/ec
 * @return string HTML code
 */
function hapebe_img_analytics_page_ec($arg0 = FALSE) {
    $FILE_BASE_PATH = drupal_realpath(file_default_scheme() . '://') . '/ia';
    $HTTP_ROOT = base_path(); // print($HTTP_ROOT); exit;

    $retval = array();

    $h = 135;
    $s = 1;
    $lowV = 0;
    $highV = 1;

    $retval[] = '<p>'
        . 'Current plan: Consider color with chroma2 lt 0.2 as monochrome, gt 0.8 as max colorful. '
        . 'lt 0.3 means clearly colored, gt 0.7 means fully colored.'
        . '</p>';



    $ec = new ExperimentalChart();

    $text = 'Gradient 1 has maximum saturation on both ends - left at 0% value, right at 100% value. Two color points in the middle have both zero saturation and a range from 100% to 0% value.';
    $caption = 'Gradient 1 - starts left with (zero value ; max. saturation), showing why saturation alone is not a good measure to judge visual chromaticity.';

    $g = new Gradient(new Color($h, 1, 0, 'hsv'), new Color($h, 1, 1, 'hsv'));
    $g->addColor('0333', new Color($h, 0, $highV, 'hsv'));
    $g->addColor('0667', new Color($h, 0, $lowV, 'hsv'));
    $ec->setGradient($g);

    $im = $ec->paint();
    ImageJPEG($im, $FILE_BASE_PATH . '/ec1.jpg', 100);
    $retval[] = '<p>' . $text;
    $retval[] = '<figure style="margin:0;"><img src="' . $HTTP_ROOT . 'sites/default/files/ia/ec1.jpg" alt="experimental chart"><figcaption>' . $caption . '</figcaption></figure>';
    $retval[] = '</p>';


    $ec = new ExperimentalChart();
    $caption = 'Gradient 2 - ';

    $g = new Gradient(new Color($h, 1, $lowV, 'hsv'), new Color($h, 0, $highV, 'hsv'));
    $g->addColor('0333', new Color($h, 0, (($lowV + $highV) / 2), 'hsv'));
    $g->addColor('0667', new Color($h, 1, (($lowV + $highV) / 2), 'hsv'));
    $ec->setGradient($g);

    $im = $ec->paint();
    ImageJPEG($im, $FILE_BASE_PATH . '/ec2.jpg', 100);
    $retval[] = '<figure style="margin:0;"><img src="' . $HTTP_ROOT . 'sites/default/files/ia/ec2.jpg" alt="experimental chart"><figcaption>' . $caption . '</figcaption></figure>';


    $ec = new ExperimentalChart();
    $caption = 'Gradient 3 - ';

    $g = new Gradient(new Color($h, 1, $lowV, 'hsv'), new Color($h, 1, $highV, 'hsv'));
    $g->addColor('0500', new Color($h, 0.5, (($lowV + $highV) / 2), 'hsv'));
    $ec->setGradient($g);

    $im = $ec->paint();
    ImageJPEG($im, $FILE_BASE_PATH . '/ec3.jpg', 100);
    $retval[] = '<figure style="margin:0;"><img src="' . $HTTP_ROOT . 'sites/default/files/ia/ec3.jpg" alt="experimental chart"><figcaption>' . $caption . '</figcaption></figure>';

    $ec = new ExperimentalChart();
    $caption = 'Gradient 4 - ';

    $g = new Gradient(new Color($h, 0, $lowV, 'hsv'), new Color($h, 0, $highV, 'hsv'));
    $g->addColor('0500', new Color($h, 1, $highV, 'hsv'));
    $ec->setGradient($g);

    $im = $ec->paint();
    ImageJPEG($im, $FILE_BASE_PATH . '/ec4.jpg', 100);
    $retval[] = '<figure style="margin:0;"><img src="' . $HTTP_ROOT . 'sites/default/files/ia/ec4.jpg" alt="experimental chart"><figcaption>' . $caption . '</figcaption></figure>';


    $ec = new ExperimentalChart();
    $caption = 'Gradient 5 - ';

    $g = new Gradient(new Color($h, 1, $highV, 'hsv'), new Color($h + 180, 0, $highV, 'hsv'));
    $ec->setGradient($g);

    $im = $ec->paint();
    ImageJPEG($im, $FILE_BASE_PATH . '/ec5.jpg', 100);
    $retval[] = '<figure style="margin:0;"><img src="' . $HTTP_ROOT . 'sites/default/files/ia/ec5.jpg" alt="experimental chart"><figcaption>' . $caption . '</figcaption></figure>';

    return implode("\n", $retval);
}

/**
 * belongs to the page delivered by hapebe_img_analytics_page_slider()
 */
function hapebe_img_analytics_ajax($arg0 = FALSE) {
    // drupal_json_output(array('image' => '<img src="test.jpg" alt="text '..'">'));
    $FILE_BASE_PATH = drupal_realpath(file_default_scheme() . '://');
    $FILE_BASE_PATH .= '/ia';
    
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

/* Color tests
  $c = new Color(255, 255, 255); $retval[] = '<div style="background-color:#'.$c->getCC().';">'.$c->toString().'</div>';
  $c = new Color(255, 0, 0); $retval[] = '<div style="background-color:#'.$c->getCC().';">'.$c->toString().'</div>';
  $c = new Color(255, 255, 0); $retval[] = '<div style="background-color:#'.$c->getCC().';">'.$c->toString().'</div>';
  $c = new Color(0, 255, 0); $retval[] = '<div style="background-color:#'.$c->getCC().';">'.$c->toString().'</div>';
  $c = new Color(0, 255, 255); $retval[] = '<div style="background-color:#'.$c->getCC().';">'.$c->toString().'</div>';
  $c = new Color(0, 0, 255); $retval[] = '<div style="background-color:#'.$c->getCC().';">'.$c->toString().'</div>';
  $c = new Color(255, 0, 255); $retval[] = '<div style="background-color:#'.$c->getCC().';">'.$c->toString().'</div>';
  $retval[] = "<br>\n";
  $c = new Color(255, 64, 64); $retval[] = '<div style="background-color:#'.$c->getCC().';">'.$c->toString().'</div>';
  $c = new Color(255, 128, 128); $retval[] = '<div style="background-color:#'.$c->getCC().';">'.$c->toString().'</div>';
  $retval[] = "<br>\n";
  $c = new Color(128, 0, 64); $retval[] = '<div style="background-color:#'.$c->getCC().';">'.$c->toString().'</div>';
  $c = new Color(192, 64, 128); $retval[] = '<div style="background-color:#'.$c->getCC().';">'.$c->toString().'</div>';
  $retval[] = "<br>\n";
  $c = new Color(64, 0, 0); $retval[] = '<div style="background-color:#'.$c->getCC().';">'.$c->toString().'</div>';
  $c = new Color(255, 192, 192); $retval[] = '<div style="background-color:#'.$c->getCC().';">'.$c->toString().'</div>';
 */
?>