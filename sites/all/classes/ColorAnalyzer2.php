<?php
/**
 *
 * @author hapebe
 */
class ColorAnalyzer2 {
    /**
     * @var \GDContext
     */
    public $gdc;
    
    /**
     * calculated stats of the image
     * @var \ImgData
     */
    public $imgData;
    
    /**
     * filename of the underlying image ("naked name")
     * @var string
     */
    public $name;
    
    /**
     * name/value pairs of analysis-related config settings
     * @var array 
     */
    public $config;

    function __construct($gdc, $imgData = FALSE, $name = FALSE) {
	$this->gdc = $gdc;
	
	if ($imgData != FALSE) {
	    $this->imgData = $imgData;
	} else {
	    $this->imgData = new ImgData();
	}
	
	if ($name != FALSE) {
	    $this->name = $name;
	} else {
	    $this->name = 'colorAnalysis';
	}
	
	$this->config = array(
	    'EXCLUDE_LIMIT' => 1 / 10, // exclude the less scored ... pixels from analysis.
	    'MIN_CLUSTER_PIXEL_PORTION' => 0.01 / 100, // minimum color space cluster portion of the image
	    'MAX_ACCEPTABLE_CLUSTER_DELTA' => 0.10, // maximum acceptable visual delta between color cluster for merging
	    'MAX_ACCEPTABLE_DELTA_WHEN_DROPPING' => 0.3, // maximum accpetable cumulated difference between clusters, when dropping colors in the end...
	    'MIN_ACCEPTABLE_CONTRASTING_DISTANCE' => 0.12, // minimum acceptable distance from a contrasting color to any base color:
	    // '' => , // 
	);
	
	$this->config['FILE_BASE_PATH'] = drupal_realpath(file_default_scheme() . '://') . '/ia';
    }
    
    function getConfig($name) {
	if (!isset($this->config[$name])) {
	    drupal_set_message(t('%file @ %line : config value %name is not set.', array('%file' => __FILE__, '%line' => __LINE__, '%name' => $name)), 'error');
	    return FALSE;
	}
	return $this->config[$name];
    }
    
    function setConfig($name, $value) {
	$this->config[$name] = $value;
    }

    /**
     * 
     * @return string HTML content to be shown as a result
     */
    function analyzeColors() {
    // $p = Profiler::getInstance(); $p->log_mode = -1;
    // $path = $_SERVER['DOCUMENT_ROOT'] . '/' . base_path() . drupal_get_path('module', 'hapebe_img_analytics') . '/';
    $retval = array();
    set_time_limit(1200);

    /*
      algorithm:
      exclude EXCLUDE_LIMIT portion of less saturated pixels,
      calculate histogramm in 72000 color space areas,
      take most populated areas down to a portion of MIN_CLUSTER_PIXEL_PORTION,
      hierarchical cluster, until MAX_ACCEPTABLE_CLUSTER_DELTA is reached,
      select N (3) largest portion color space areas, take them for "base colors",
      (or: take as many "base colors" as needed for 33% of the image, but at least enough to cover 25% of the image)
      drop clusters until MAX_ACCEPTABLE_COMMUNALITY is reached,
      take the remaining space areas as "contrasting colors",
      remove from "contrasting colors" the one with least saturation * value score,
      remove from "contrasting colors" such colors, which are too similar to any base color.
     */

    $gdc = $this->gdc;
    $im = $this->gdc->im;
    $width = $this->gdc->w;
    $height = $this->gdc->h;
    $pxCount = $width * $height; 
    
    { // calculate include scores and average color:
	$includeScores = array();
	for ($x = 0; $x < $width; $x++) {
	    for ($y = 0; $y < $height; $y++) {
		$c = new Color(Color::GD2RGB(ImageColorAt($im, $x, $y)));

		$includeScores[$x . ';' . $y] = $c->chroma2;
	    }
	}
	
	// this was computed by StandardImageAnalyzer::makeHistogramData():
	if (isset($this->imgData->colorData['averageColorRGB'])) {
	    $avgC = $this->imgData->colorData['averageColorRGB'];
	    $retval[] = '<p>Average RGB color: <span style="background-color:#' . $avgC->getCC() . '">' . $avgC->toString() . '</span></p>';
	}

	asort($includeScores); // $p->log_sentinel("computed includeScores");
    }


    // show most populated color areas, generate clusters:
    $colorSpace = new ColorSpaceHolder();
    $hRes = 72;
    $sRes = 10;
    $vRes = 20;
    $colorSpace->setHSVResolution($hRes, $sRes, $vRes);
    $hIncr = 360 / $hRes;
    $sIncr = 1 / $sRes;
    $vIncr = 1 / $vRes;

    // compute color space
    $i = 0;
    $black = $this->gdc->getSetColorRGB(0, 0, 0);
    foreach ($includeScores as $coords => $s) {
	list($x, $y) = explode(";", $coords);
	if ( $i < ($pxCount * $this->getConfig('EXCLUDE_LIMIT')) ) {
	    // is below inclusion limit
	    ImageSetPixel($im, $x, $y, $black);
	} else {
	    // is interesting:
	    $c = new Color(Color::GD2RGB(imagecolorat($im, $x, $y)));

	    $colorSpace->addPixel($c->h, $c->s, $c->v);
	}
	$i++;
    }
    $spots = $colorSpace->spots;
    arsort($spots);
    
    
    $colorSpace = $spots;

    // merge / reduce clusters:
    $fname = $this->getConfig('FILE_BASE_PATH').'/'.$this->name.'-clustersAfterMerging.serialized';
    if (file_exists($fname)) {
	$clusters = unserialize(file_get_contents($fname));
    } else {
	// calculate:
	$nextClusterIdx = 0;
	do {
	    // $p->log_sentinel("entering loop of cluster generation");

	    $clusters = array();
	    $i = 0;
	    foreach ($colorSpace as $hsv => $cnt) {
		if ($cnt == 0) break;

		$pixelPortion = $cnt / $pxCount;
		if ($pixelPortion < $this->getConfig('MIN_CLUSTER_PIXEL_PORTION')) break;

		list($h, $s, $v) = explode(';', $hsv);
		$h = ($h + 0.5) * $hIncr;
		$s = ($s + 0.5) * $sIncr;
		$v = ($v + 0.5) * $vIncr;
		$c = new Color($h, $s, $v, 'hsv');

		$cluster = new ColorCluster($c);
		$cluster->pxCount = $cnt;
		$clusters[$nextClusterIdx++] = $cluster;

		// $retval[] = $cluster->toHtml($pxCount) . "\n";

		$i++;
		// if ($i > 300) break; // for debugging
	    }

	    $this->imgData->setGeneralData('homogenity', $pxCount / count($clusters));
	    $retval[] = '<h3>Image diversity measure: ' . count($clusters) . ' cluster /' . $pxCount . ' pixels</h3>';
	    $retval[] = '<h3>Homogenity measure: ' . $this->imgData->getGeneralData('homogenity') . '</h3>';

	    if (count($clusters) > 2000) {
		$retval[] = '<h3>Doubling $MIN_CLUSTER_PIXEL_PORTION because of ' . count($clusters) . ' clusters...</h3>';
		$v = $this->getConfig('MIN_CLUSTER_PIXEL_PORTION');
		$this->setConfig('MIN_CLUSTER_PIXEL_PORTION', $v * 2);
	    } else {
		break;
	    }
	} while (true); // MUST fulfill break condition above!

	$retval[] = 'Starting with ' . count($clusters) . ' clusters...' . "<br>\n";
	$retval[] = '<br clear="all">';
	// return implode($retval);



	$mergeCnt = 0;
	do {
	    // $p->log_function_entry("cluster_merging");

	    /*
	      90@2000
	      65@1500 (~10s)
	      40@1000
	      30@800 (~ 2.7s)
	      10@400 (0.5 ~ 0.6s)
	      1@200 (0.13s)
	      (and below (pairs!!!))
	     */
	    $mergeInOne = ((count($clusters) - 200) / 20);
	    if ($mergeInOne < 1) $mergeInOne = 1;

	    $retval[] = "<h2>".($mergeCnt+1).". round of mergers, max. $mergeInOne in one batch</h2>";

	    $sortDistances = array();
	    foreach ($clusters as $idx1 => $c1) {
		foreach ($clusters as $idx2 => $c2) {
		    if ($idx2 <= $idx1) continue;

		    $sortDistances[$idx1 . ";" . $idx2] = Color::HSLDistance($c1->color, $c2->color);
		}
	    }
	    asort($sortDistances);

	    $i = 0;
	    foreach ($sortDistances as $coords => $delta) {
		if ($i == 0) {
		    $minDelta = $delta;
		    if ($minDelta > $this->getConfig('MAX_ACCEPTABLE_CLUSTER_DELTA')) break;
		}

		list($x, $y) = explode(';', $coords);
		// if either of them is not set it means they have been merged before:
		if (!isset($clusters[$x])) continue;
		if (!isset($clusters[$y])) continue;

		$c1 = $clusters[$x];
		$c2 = $clusters[$y];

		if (TRUE) { // debug output:
		    $retval[] = $c1->toHTML() . ' + ' . $c2->toHTML() . " = Delta: " . Color::HSLDistance($c1->color, $c2->color) . "\n";
		} // return implode("\n", $retval);

		//form a new cluster from the 2 original ones:
		$nc = $this->combineClusters($c1, $c2);
		$retval[] = " --- Combined cluster:".$nc->toHTML()."<br>\n";

		// drop the two old clusters, add the new one:
		unset($clusters[$x]);
		unset($clusters[$y]);
		$clusters[$nextClusterIdx++] = $nc;
		$mergeCnt++;

		$i++;
		if ($i >= $mergeInOne) {
		    // $p->log_sentinel("merged " . $i . " additional clusters in one step, now there are " . count($clusters) . " clusters.");
		    break;
		}
	    } 

	    // $retval[] = print_r(array_keys($clusters), true);
	    // return implode("\n", $retval);
	    // $p->log_function_exit("cluster_merging");

	    if ($minDelta > $this->getConfig('MAX_ACCEPTABLE_CLUSTER_DELTA')) break;

	    // $retval[] = "<h2>Current clusters:</h2>";
	    // foreach ($clusters as $c) $retval[] = $c->toHTML()."<br>\n";

	} while (count($clusters) > 2);
	// $p->log_sentinel("merging finished");


	// store for re-using next time:
	$ser = serialize($clusters);
	$f = fopen($this->getConfig('FILE_BASE_PATH').'/'.$this->name.'-clustersAfterMerging.serialized', 'w');
	fputs($f, $ser);
	fclose($f);
    } // end calculate clusters.
    $retval[] = "<h1>Final clusters after mergers:</h1>";
    foreach ($clusters as $c) $retval[] = $c->toHTML($pxCount) . "<br>\n";
    
    
    // return implode("\n", $retval);

    // find main colors:
    $baseColors = array();
    $sortClusters = array();
    foreach ($clusters as $idx => $c) $sortClusters[$idx] = $c->pxCount;
    arsort($sortClusters);
    $i = 0;
    $pxCountSum = 0;
    foreach ($sortClusters as $idx => $cnt) {
	$baseColors[] = $clusters[$idx];
	$pxCountSum += $clusters[$idx]->pxCount;

	// remove base color from further analysis:
	unset($clusters[$idx]);

	if (($pxCountSum > ($pxCount * 1 / 2)) || ($i>4)) break;

	$i++;
    }
    $retval[] = '<h2>Base colors:</h2>';
    foreach ($baseColors as $bc) $retval[] = $bc->toHTML($pxCount, TRUE);
    
    $newClusters = array();
    foreach ($clusters as $c) $newClusters[] = $c;
    $clusters = $newClusters;


    // check and remove colors, which are too close to any base color:
    $retval[] = "<h2>Dropping colors, which are too similar to a base color:</h2>";
    $dropList = array();
    for ($i = 0; $i < count($baseColors); $i++) {
	for ($j = 0; $j < count($clusters); $j++) {
	    $delta = Color::HSLDistance($baseColors[$i]->color, $clusters[$j]->color);

	    if ($delta < $this->getConfig('MIN_ACCEPTABLE_CONTRASTING_DISTANCE')) {
		$retval[] = "Distance between " . $baseColors[$i]->toHtml($pxCount) . " and " . $clusters[$j]->toHtml($pxCount) . " is only " . $delta . ".<br>\n";
		$dropList[] = $j;
	    }
	}
    }
    $newClusters = array();
    for ($i = 0; $i < count($clusters); $i++) {
	if (!in_array($i, $dropList))
	    $newClusters[] = $clusters[$i];
    }
    $clusters = $newClusters;
    // $p->log_sentinel("base colors finished");
    $retval[] = '<h2>Remaining spot colors:</h2>';
    foreach ($clusters as $c) $retval[] = $c->toHTML($pxCount, TRUE);
    
    
    
    return implode("\n", $retval);



    // now: drop clusters!
    $dropCnt = 0;
    do {
	$p->log_sentinel("entering loop of cluster dropping");
	// $retval[] = "<h1>".($dropCnt+1).". cluster drop</h1>";
	// generate delta matrix:
	$distances = array();
	$sortDistances = array();
	for ($x = 0; $x < count($clusters); $x++) {
	    $distances[$x] = array();
	    for ($y = 0; $y < count($clusters); $y++) {
		if ($x == $y)
		    continue;

		$dx = $clusters[$x]->x - $clusters[$y]->x;
		$dy = $clusters[$x]->y - $clusters[$y]->y;
		$dz = $clusters[$x]->z - $clusters[$y]->z;

		$delta = sqrt($dx * $dx + $dy * $dy + $dz * $dz);

		// mark differences between non-considered clusters as uninteresting
		/*
		  if ( (mb_strlen($clusters[$x]->marker) == 0) and (mb_strlen($clusters[$y]->marker) == 0) ) {
		  $delta = 0;
		  } */

		$distances[$x][$y] = $delta;
		$sortDistances[$x . ";" . $y] = $delta;
	    }
	}
	asort($sortDistances);
	// find the least distance:
	foreach ($sortDistances as $coords => $score) {
	    list($minA, $minB) = explode(";", $coords);
	    $leastDistance = $score;
	    break;
	}

	// display:
	/*
	  $retval[] = '<h3>Distance Matrix</h3>'."\n";
	  $retval[] = '<table cellspacing="0" cellpadding="3" border="0">';

	  $retval[] = '<tr>';
	  $retval[] = '<td>&nbsp;</td>'."\n";
	  for ($x = 0; $x < count($clusters); $x++) {
	  $retval[] = '<th style="background-color:#'.$clusters[$x]->getCC().'">&nbsp;'.$clusters[$x]->marker.'</th>'."\n";
	  }
	  $retval[] = '<th style="background-color:#fff">&Sigma;</th>'."\n";
	  $retval[] = '</tr>';

	  // table:
	  for ($y = 0; $y < count($clusters); $y++) {
	  $retval[] = '<tr>'."\n";
	  $retval[] = '<th style="background-color:#'.$clusters[$y]->getCC().'">&nbsp;'.$clusters[$y]->marker.'</th>'."\n";
	  $rowSum = 0;
	  for ($x = 0; $x < count($clusters); $x++) {
	  if ($x == $y) {
	  $retval[] = '<td><small>&nbsp;</small></td>';
	  continue;
	  }

	  $rowSum += $distances[$x][$y];

	  $style = '';
	  if (($x == $minA) and ($y == $minB)) $style=' style="background-color:red;"';
	  if (($x == $minB) and ($y == $minA)) $style=' style="background-color:red;"';

	  $retval[] = '<td'.$style.'><small>'.sprintf("%01.2f", $distances[$x][$y]).'</small></td>';
	  }
	  $retval[] = '<td><small>'.sprintf("%02.1f", $rowSum).'</small></td>';
	  $retval[] = '</tr>'."\n";
	  }

	  $retval[] = '</table>';
	 */




	// generate communality matrix:
	$communalities = array();
	$sortComm = array();
	for ($x = 0; $x < count($clusters); $x++) {
	    $communalities[$x] = array();
	    for ($y = 0; $y < count($clusters); $y++) {
		if ($x == $y)
		    continue;
		$score = 0;
		for ($c = 0; $c < count($clusters); $c++) {
		    if ($x == $c)
			continue;
		    if ($y == $c)
			continue;

		    $deltaX = $distances[$x][$c];
		    $deltaY = $distances[$y][$c];
		    $score += abs($deltaX - $deltaY);
		}
		$score /= count($clusters) - 2;

		$communalities[$x][$y] = $score;
		$sortComm[$x . ";" . $y] = $score;
	    }
	}
	asort($sortComm);
	// find the least communality score:
	foreach ($sortComm as $coords => $score) {
	    list($minCommA, $minCommB) = explode(";", $coords);
	    $leastComm = $score;
	    break;
	}

	//display:
	/*
	  $retval[] = '<h3>Communalities</h3>'."\n";
	  $retval[] = '<table cellspacing="0" cellpadding="3" border="0">';

	  $retval[] = '<tr>';
	  $retval[] = '<td>&nbsp;</td>'."\n";
	  for ($x = 0; $x < count($clusters); $x++) {
	  $retval[] = '<th style="background-color:#'.$clusters[$x]->getCC().'">&nbsp;'.$clusters[$x]->marker.'</th>'."\n";
	  }
	  $retval[] = '<th style="background-color:#fff">&Sigma;</th>'."\n";
	  $retval[] = '</tr>';

	  for ($y = 0; $y < count($clusters); $y++) {
	  $retval[] = '<tr>'."\n";
	  $retval[] = '<th style="background-color:#'.$clusters[$y]->getCC().'">&nbsp;'.$clusters[$y]->marker.'</th>'."\n";
	  $rowSum = 0;
	  for ($x = 0; $x < count($clusters); $x++) {
	  if ($x == $y) {
	  $retval[] = '<td><small>&nbsp;</small></td>';
	  continue;
	  }

	  $style = '';
	  if (($x == $minCommA) and ($y == $minCommB)) $style=' style="background-color:red;"';
	  if (($x == $minCommB) and ($y == $minCommA)) $style=' style="background-color:red;"';

	  $retval[] = '<td'.$style.'><small>'.sprintf("%01.2f", $communalities[$x][$y]).'</small></td>';
	  $rowSum += $communalities[$x][$y];
	  }
	  $retval[] = '<td><small>'.sprintf("%02.1f", $rowSum).'</small></td>';
	  $retval[] = '</tr>'."\n";
	  }

	  $retval[] = '</table>';
	 */

	if ($leastDistance > $MAX_ACCEPTABLE_DELTA_WHEN_DROPPING)
	    break;
	// if ($leastComm > $MAX_ACCEPTABLE_COMMUNALITY) break;
	// the bigger clusters wins:
	/*
	  if ($clusters[$minA]->pxCount < $clusters[$minB]->pxCount) {
	  unset($clusters[$minA]);
	  } else {
	  unset($clusters[$minB]);
	  } */
	// higher s*v wins:
	$svA = $clusters[$minA]->s * $clusters[$minA]->v;
	$svB = $clusters[$minB]->s * $clusters[$minB]->v;
	if ($svA < $svB) {
	    unset($clusters[$minA]);
	} else {
	    unset($clusters[$minB]);
	}

	$newClusters = array();
	foreach ($clusters as $c)
	    $newClusters[] = $c;
	$clusters = $newClusters;

	$dropCnt ++;
    } while (count($clusters) > 3);
    $p->log_sentinel("dropping finished");

    $retval[] = "<h1>Final clusters after " . $dropCnt . " drops:</h1>";
    foreach ($clusters as $c)
	$retval[] = $c->toHTML($pxCount) . "(s*v = " . ($c->s * $c->v) . ")<br>\n";

    // drop the one with least s*v score:
    $sortScores = array();
    for ($i = 0; $i < count($clusters); $i++) {
	$sortScores[$i] = $clusters[$i]->s * $clusters[$i]->v;
    }
    asort($sortScores);
    foreach ($sortScores as $idx => $score) {
	if (($clusters[$idx]->v > 0.8) or ( $clusters[$idx]->v < 0.2)) {
	    ; // keep it, if it's very dark or very light.
	} else {
	    $retval[] = "<p>Dropping " . $clusters[$idx]->toHtml($pxCount) . " with least s*v score " . $score . "</p>\n";
	    unset($clusters[$idx]);
	}
	break;
    }
    $newClusters = array();
    foreach ($clusters as $c)
	$newClusters[] = $c;
    $contrastingColors = $newClusters;




    $retval[] = "<h1>Final base colors:</h1>";
    foreach ($baseColors as $c)
	$retval[] = $c->toHTML($pxCount) . ")<br>\n";

    $retval[] = "<h1>Final contrasting colors:</h1>";
    foreach ($contrastingColors as $c)
	$retval[] = $c->toHTML($pxCount) . ")<br>\n";

    $this->baseColors = $baseColors;
    $this->contrastingColors = $contrastingColors;

    /*
      $csv = new CSVObject();
      $y = 0;
      foreach ($rows as $row) {
      $csv->setRowName($y, str_replace(";","!",$row));

      list($h, $s, $v) = explode(";", $row);
      $h *= 10 + 5;
      $h = deg2rad($h);
      $s /= 10 + 0.05;
      $v /= 10 + 0.05;
      $radius = $s * $v / 2; // only with full saturation AND value the radius is 1.

      $y1 = sin($h) * $radius;
      $x1 = cos($h) * $radius;
      $z1 = 1 - $v;

      $x = 0;
      foreach ($cols as $col) {
      if ($y==0) $csv->setColName($x, str_replace(";","!",$col));

      list($h, $s, $v) = explode(";", $col);
      $h *= 10 + 5;
      $h = deg2rad($h);
      $s /= 10 + 0.05;
      $v /= 10 + 0.05;
      $radius = $s * $v / 2;
      // only with full saturation AND value the radius is 0.5, so the diameter is 1.0

      $y2 = sin($h) * $radius;
      $x2 = cos($h) * $radius;
      $z2 = 1 - $v;

      $delta =
      sqrt(
      ($x1 - $x2) * ($x1 - $x2) +
      ($y1 - $y2) * ($y1 - $y2) +
      ($z1 - $z2) * ($z1 - $z2)
      );


      $csv->setValue($y, $x, $delta);

      $x++;
      }
      $y++;
      }
      $csv->writeFile("out.csv");
     */



    /*
      $outFile = explode(".", $this->filename);
      array_pop($outFile);
      $outFile = implode(".", $outFile)."-out.jpg";

      ImageJPEG($im, $outFile, 100);
      $retval[] = '<img src="'.base_path().drupal_get_path('module','cartrends').'/'.basename($outFile).'">';
     */

    // $p->terminate();

    return implode("\n", $retval);
}

/**
 * @param \ColorCluster $c1
 * @param \ColorCluster $c2
 * @return \ColorCluster
 */
function combineClusters($c1, $c2) {
    $totalPxCount = $c1->pxCount + $c2->pxCount;
    $weight1 = $c1->pxCount / $totalPxCount;
    $weight2 = $c2->pxCount / $totalPxCount;

    $h1 = $c1->color->h;
    $h2 = $c2->color->h;
    if ($h2 - $h1 > 180) $h1 += 360;
    if ($h1 - $h2 > 180) $h2 += 360;
    
    $ch = ($h1 * $weight1 + $h2 * $weight2) % 360;
    $cs = $c1->color->s * $weight1 + $c2->color->s * $weight2;
    $cv = $c1->color->v * $weight1 + $c2->color->v * $weight2;

    $nc = new ColorCluster(new Color($ch, $cs, $cv, 'hsv'));
    $nc->pxCount = $totalPxCount;
    
    return $nc;
}

function makeChartAnimScript($chartList, $imgFileName, $width, $height) {
    $FILE_BASE_PATH = drupal_realpath(file_default_scheme() . '://');
    $FILE_BASE_PATH .= '/ia';
    $FILE_BASE_PATH = str_replace("/", "\\", $FILE_BASE_PATH);
    
    $VIRTUAL_DUB = 'C:\\ia\\vd\\VirtualDub.exe';
    $BMP2AVI = 'C:\\ia\\bmp2avi\\EasyBMPtoAVI.exe';
    $IMAGICK = 'C:\\Program Files\\ImageMagick-6.8.9-Q16\\';


    // file list for EasyBMPtoAVI
    $f = fopen($FILE_BASE_PATH.'/filelist.txt', 'w');
    $s = implode("\r\n", $chartList);
    $s = str_replace('.png', '-comp.bmp', $s);
    fputs($f, $s);
    fclose($f);

    $f = fopen($FILE_BASE_PATH.'\process.cmd', 'w');
    fputs($f, 'C:'."\r\n");
    fputs($f, 'cd \\ia\\temp'."\r\n");
    fputs($f, 'copy '.$FILE_BASE_PATH.'\\rescaled.jpg . /y'."\r\n");
    fputs($f, 'copy '.$FILE_BASE_PATH.'\\chart-*.png . /y >nul'."\r\n");
    fputs($f, 'del '.$FILE_BASE_PATH.'\\chart-*.png'."\r\n");
    fputs($f, ''."\r\n");
    foreach($chartList as $name) {
	$pngName = basename($name);
	$bmpName = str_replace('png', 'bmp', $pngName);
	$compName = str_replace('.png', '-comp.bmp', $pngName);
	// fputs($f, '"C:\Program Files\ImageMagick-6.7.0-Q16\convert" '.$pngName.' '.$bmpName."\r\n");
	// fputs($f, '"C:\Program Files\ImageMagick-6.7.0-Q16\montage" '.$bmpName.' rescaled.jpg '.$compName."\r\n");

	fputs($f, '"'.$IMAGICK.'mogrify" +append -extent '.$width.'x'.$height.' -format bmp '.$pngName."\r\n");
	fputs($f, '"'.$IMAGICK.'composite" -gravity East rescaled.jpg '.$bmpName.' '.$compName."\r\n");
    }
    fputs($f, 'del *.png'."\r\n");
    fputs($f, 'del rescaled.jpg'."\r\n");
    fputs($f, "\r\n");
    fputs($f, 'copy '.$FILE_BASE_PATH.'\\filelist.txt . /y'."\r\n");
    fputs($f, $BMP2AVI.' -filelist filelist.txt -framerate 25 -output out.avi'."\r\n");
    fputs($f, 'del *.bmp'."\r\n");
    fputs($f, 'del filelist.txt'."\r\n");
    fputs($f, $VIRTUAL_DUB.' /s colorspace-convert.vcf /p out.avi '.basename($imgFileName).'.avi /r /x'."\r\n");
    fputs($f, 'del out.avi'."\r\n");

    fputs($f, "\r\n");
    fputs($f, 'REM animated GIF output:'."\r\n");
    fputs($f, 'REM "'.$IMAGICK.'convert" -delay 4 chart-???.png -fuzz 40% -map colormap_332.png anim.miff'."\r\n");
    fputs($f, 'REM "'.$IMAGICK.'convert" anim.miff -delay 4 -coalesce +dither -layers OptimizeTransparency anim-opt.gif'."\r\n");

    fclose($f);
}


}
