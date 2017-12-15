<?php
/**
 * generates preview and thumbnail images
 * computes and holds statistics about an image
 */
class CartrendsImageProcessor {
	public $imgid;
	
	public $filename;
	public $width;
	public $height;
	
	public $previewWidth;
	public $previewHeight;
	
	/** RGB HTML-like color code */
	public $averageColor;

	/** array of ColorCluster */
	public $baseColors;
	/** array of ColorCluster */
	public $contrastingColors;
	
	public $homogenity;
	
	/** instance of Histogramm (or false) */
	public $histValue;

	/** instance of Histogramm (or false) */
	public $histSaturation;

	/** instance of Histogramm (or false) */
	public $histHue;
	
	public function __construct($filename, $imgid = -1) {
		$this->imgid = $imgid;
		$this->filename = $filename;
		
		$this->baseColors = array();
		$this->contrastingColors = array();
	}
	
	function persist() {
		global $user;
		$retval = array();
		
		if (!isset($this->previewWidth)) {
			$basename = Img::stdName($this->filename);
			$dirname = Img::getStorageDir('preview', $basename, 'file');
			$prvfile = $dirname.$basename.".jpg";
			$info = getimagesize($prvfile);
			$this->previewWidth = $info[0];
			$this->previewHeight = $info[1];
		}


		if (isset($this->baseColors) and isset($this->contrastingColors)) {
			$colors = array();
			foreach ($this->baseColors as $c) {
				$c->marker = 0; // type 0
				$colors[] = $c;
			}
			foreach ($this->contrastingColors as $c) {
				$c->marker = 1; // type 1
				$colors[] = $c;
			}
			
			// delete existing base color records:
			db_query("DELETE FROM {cartrends_color} WHERE imgid = %d", $this->imgid);
			
			// insert records for all colors:
			foreach ($colors as $c) {
				$type = $c->marker; // is set above
				$weight = $c->pxCount / ($this->previewWidth * $this->previewHeight) * 100; // pixel portion percentage
				$r = floor($c->rgb["r"] + 0.5);
				$g = floor($c->rgb["g"] + 0.5);
				$b = floor($c->rgb["b"] + 0.5);
				$h = floor($c->h + 0.5);
				$s = floor($c->s * 255 + 0.5);
				$v = floor($c->v * 255 + 0.5);
				$x = $c->x;
				$y = $c->y;
				$z = $c->z;
				
				$sql = "INSERT INTO {cartrends_color} ".
					"(imgid, type, weight, r,  g,  b,  h,  s,  v,  x,  y,  z) VALUES ".
					"(%d,    %d,   %f,     %d, %d, %d, %d, %d, %d, %f, %f, %f)";
				$result = db_query($sql, 
				  $this->imgid, $type, $weight, $r, $g, $b, $h, $s, $v, $x, $y, $z);
				
			}
		}
		
		if (isset($this->homogenity)) {
			// delete existing record:
			db_query("DELETE FROM {cartrends_imgattr} WHERE imgid = %d AND type=4 AND subType=200", $this->imgid);
			
			// insert record:
  		db_queryd(
  			"INSERT INTO {cartrends_imgattr} "
	  		."(imgid, type, subType, value, numvalue, userid, touchdate) VALUES "
	  		."(%d, 4, 200, '%s', %d, %01.3f, '%s')", 
	  		$this->imgid, floor($this->homogenity+0.5), $this->homogenity, $user->uid, strftime("%Y-%m-%d %H:%M:%S")
	  	);
		}
		
		return implode("\n", $retval);
	}
	
	function generatePreviews($prvQuality = 100, $tnQuality = 75) {
		// maximum size of preview images - width for landscape, height for portrait orientation.
		$MAX_SIZE_PRV = 362;
		
		// maximum size of thumbnail images - width for landscape, height for portrait orientation.
		$MAX_SIZE_TN = 112;

		$retval = array();
		
		$im = ImageCreateFromJPEG($this->filename);
		$colorHolder =& new ColorHolder();
		$colorHolder->im = &$im;
		
		$this->width = ImageSX($im);
		$this->height = ImageSY($im);
		$pxCount = $this->width * $this->height;
		
		{ // preview
			if ($this->width >= $this->height) {
				// landscape or square image:
				$scale = $MAX_SIZE_PRV / $this->width;
				$newWidth = $MAX_SIZE_PRV;
				$newHeight = floor($this->height * $scale + 0.5);
			} else {
				// portrait image:
				$scale = $MAX_SIZE_PRV / $this->height;
				$newWidth = floor($this->width * $scale + 0.5);
				$newHeight = $MAX_SIZE_PRV;
			}
			
			$im2 = ImageCreateTrueColor($newWidth, $newHeight);
			ImageCopyResized(
				$im2, $im, 
				0, 0,
				0, 0,
				$newWidth, $newHeight,
				$this->width, $this->height
			);
	
			$basename = Img::stdName($this->filename);
			$dirname = Img::getStorageDir('preview', $basename, 'file');
			$outfile = $dirname.$basename.".jpg";
			ImageJPEG($im2, $outfile, $prvQuality);
			$retval[] = "<p>Written to ".$outfile."</p>";
			ImageDestroy($im2);
			
			$dirname = Img::getStorageDir('preview', $basename, 'url');
			$outfile = $dirname.$basename.".jpg";
			$retval[] = '<img src="'.$outfile.'">';
		}
		
		{ // thumbnail
			if ($this->width >= $this->height) {
				// landscape or square image:
				$scale = $MAX_SIZE_TN / $this->width;
				$newWidth = $MAX_SIZE_TN;
				$newHeight = floor($this->height * $scale + 0.5);
			} else {
				// portrait image:
				$scale = $MAX_SIZE_TN / $this->height;
				$newWidth = floor($this->width * $scale + 0.5);
				$newHeight = $MAX_SIZE_TN;
			}
			
			$im2 = ImageCreateTrueColor($newWidth, $newHeight);
			ImageCopyResized(
				$im2, $im, 
				0, 0,
				0, 0,
				$newWidth, $newHeight,
				$this->width, $this->height
			);
	
			$basename = Img::stdName($this->filename);
			$dirname = Img::getStorageDir('thumbnail', $basename, 'file');
			$outfile = $dirname.$basename.".jpg";
			ImageJPEG($im2, $outfile, $tnQuality);
			$retval[] = "<p>Written to ".$outfile."</p>";
			ImageDestroy($im2);
			
			$dirname = Img::getStorageDir('thumbnail', $basename, 'url');
			$outfile = $dirname.$basename.".jpg";
			$retval[] = '<img src="'.$outfile.'">';
		}


		return implode("\n", $retval);
	}
	
	
	function analyzeColors() {
		$p = Profiler::getInstance();
		$p->log_mode = -1;
		
		$path = $_SERVER['DOCUMENT_ROOT'].'/'.base_path().drupal_get_path('module', 'cartrends').'/';
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
		
		$retval = array();
		
		set_time_limit(1200);
		
		// exclude the less scored ... pixels from analysis.
		$EXCLUDE_LIMIT = 1/10;
		
		// minimum color space cluster portion of the image:
		$MIN_CLUSTER_PIXEL_PORTION = 0.01 / 100; 
	
		// maximum acceptable visual delta between color cluster for merging:
		$MAX_ACCEPTABLE_CLUSTER_DELTA = 0.12;
		
		// maximum accpetable cumulated difference between clusters, when dropping colors in the end...
		// $MAX_ACCEPTABLE_COMMUNALITY = 0.15;
		$MAX_ACCEPTABLE_DELTA_WHEN_DROPPING = 0.3;
		
		// minimum acceptable distance from a contrasting color to any base color:
		$MIN_ACCEPTABLE_CONTRASTING_DISTANCE = 0.20;
	
		// this is based on the preview file:
		$f = Img::stdName($this->filename);
		$f = Img::getStorageDir('preview', $f, 'file').$f.".jpg";
		if (!file_exists($f)) {
			// or, on the file itself:
			$f = $this->filename;
			if (!file_exists($f)) {
				drupal_set_message(t('File does not exist: @f', array('@f' => $f)), 'error');
				return false;
			}
			drupal_set_message(t('Using file itself (preview does not exist): @f', array('@f' => $f)), 'info');
		}
		$im = ImageCreateFromJPEG($f);
		$p->log_sentinel("created GD image");

		$colorHolder =& new ColorHolder();
		$colorHolder->im = &$im;
		
		$width = ImageSX($im);
		$height = ImageSY($im);
		$pxCount = $width * $height;
		
		{	// calculate include scores and average color:
			$includeScores = array();
			$sumR = 0; $sumG = 0; $subB = 0;
			for ($x = 0; $x < $width; $x++) {
				for ($y = 0; $y < $height; $y++)	{
					
					$rgb = imagecolorat($im, $x, $y);
					$r = ($rgb >> 16) & 0xFF;
					$g = ($rgb >> 8) & 0xFF;
					$b = $rgb & 0xFF;		
					
					// $hsv = getHSVforRGB($r, $g, $b);
					$s = getAbsSforRGB($r,$g,$b);
					
					$includeScores[$x.';'.$y] = $s;
					/*
					$v = $hsv["v"];
					if ($v < 0.2) $v = 0.2;
					if ($v > 0.7) $v = 0.7;
					$v -= 0.2;
					$includeScores[$x.";".$y] = $hsv["s"]*$v;*/
					
					$sumR += $r; $sumG += $g; $sumB += $b;
				}
			}
			$this->averageColor = RGBtoCC(
				floor($sumR / $pxCount + 0.5),
				floor($sumG / $pxCount + 0.5),
				floor($sumB / $pxCount + 0.5)
			);
			$retval[] = '<p>Average color: <span style="background-color:#'.$this->averageColor.'">'.$this->averageColor.'</span></p>';
			
			asort($includeScores);
			$p->log_sentinel("computed includeScores");
		}
		
		if (true) { // color space charts (graphics / animation)
			$mode = -1; // quick / draft / debug
			$mode = 0; // normal / production quality

			$chartWidth = 640;
			$chartHeight = 400;
			
			// scaled-to-fit version of the original image:
			$factor = $chartHeight / ImageSY($im);
			$newX = floor(ImageSX($im) * $factor + 0.5);
			// round to next multiple of 4:
			$newX = floor($newX / 4 +0.5) * 4;
			$newY = floor(ImageSY($im) * $factor + 0.5);
			$rescaled = ImageCreateTrueColor($newX, $newY);
			ImageCopyResampled($rescaled, $im, 0, 0, 0, 0, $newX, $newY, ImageSX($im), ImageSY($im));
			ImageJPEG($rescaled, $path.'rescaled.jpg', 100);
			
			
			$colorSpace = new ColorSpaceHolder();
			$colorSpace->setHSVResolution(90, 20, 50);
			
			// compute color space
			$i = 0;
			$black = $colorHolder->getColorRBG(0,0,0);
			foreach ($includeScores as $coords => $s) {
				// regardless of includeScore, at the moment we include all pixels for the color space chart(s)
				list($x,$y) = explode(';', $coords);
				
				$rgb = imagecolorat($im, $x, $y);
				$r = ($rgb >> 16) & 0xFF;	$g = ($rgb >> 8) & 0xFF;	$b = $rgb & 0xFF;
				
				$hsv = getHSVforRGB($r, $g, $b);
				extract($hsv);
				$colorSpace->addPixel($h, $s, $v);
				
				$i++;
				// if (($i % 1000) == 0) { echo $i . ' pixels in ColorSpace (for charts)...'."<br>\n"; ob_end_flush(); }
			}
			$steps = 360;
			if ($mode == -1) $steps = 60;
			$colorSpace->toImg($path.'chart.png', $chartWidth, $chartHeight, $steps);
			$charts = $colorSpace->chartFileList;
			sort($charts); // lowest frame numbers first
			
			$this->makeChartAnimScript($charts, $this->filename, $chartWidth + $newX, $chartHeight);
			
			
			
			$p->log_sentinel("computed colorSpace (graphics / charts)");
		} // endif color space graphics.
		exit;
		
		
		// show most populated color areas, generate clusters:
		$colorSpace = new ColorSpaceHolder();
		$colorSpace->setHSVResolution(72, 10, 20);
		
		// compute color space
		$i = 0;
		$black = $colorHolder->getColorRBG(0,0,0);
		foreach ($includeScores as $coords => $s) {
			list($x,$y) = explode(";", $coords);
			if ($i<($pxCount*$EXCLUDE_LIMIT)) {
				// is below inclusion limit
				ImageSetPixel($im,$x,$y,$black);
			} else {
				// is interesting:
				$rgb = imagecolorat($im, $x, $y);
				$r = ($rgb >> 16) & 0xFF;	$g = ($rgb >> 8) & 0xFF;	$b = $rgb & 0xFF;
				
				// $rgbS = getAbsSforRGB($r, $g, $b);
				$hsv = getHSVforRGB($r, $g, $b);
				extract($hsv);
				// $s = getAbsSforRGB($r, $g, $b);
				$colorSpace->addPixel($h, $s, $v);
			}
			$i++;
		}
		$spots = $colorSpace->spots;
		arsort($spots);
		$colorSpace = $spots;

		do {
			$p->log_sentinel("entering loop of cluster generation");

			$clusters = array();
			$i = 0;
			foreach ($colorSpace as $color => $cnt) {
				if ($cnt == 0) break;
				
				$pixelPortion = $cnt/$pxCount;
				if ($pixelPortion < $MIN_CLUSTER_PIXEL_PORTION) break;
		
				list($h, $s, $v) = explode(";", $color);
				$h = $h*5+5;
				$v = $v/20+(1/40);
				// undo the perceptive transformation of $s above:
				$s = $s/10+(1/20);
				$sxv = $s * $s;
				$s = $sxv / $v;
				if ($s>1) $s=1;
				
				$cluster = new ColorCluster($h, $s, $v);
				$cluster->pxCount = $cnt;
				$clusters[] = $cluster;
				
				$retval[] = $cluster->toHtml($pxCount)."\n";
				
				
				$i++;
				// if ($i > 300) break;	
			}
			
			if (!isset($this->homogenity)) {
				$this->homogenity = $pxCount / count($clusters);
				$retval[] = '<h3>Image diversity measure: '.count($clusters).'/'.$pxCount.'</h3>';
				$retval[] = '<h3>Homogenity measure: '.$this->homogenity.'</h3>';
			}
			
			if (count($clusters) > 2000) {
				$retval[] = '<h3>Doubling $MIN_CLUSTER_PIXEL_PORTION because of '.count($clusters).' clusters...</h3>';
				$MIN_CLUSTER_PIXEL_PORTION *= 2;
			} else {
				break;
			}
		} while (true); // MUST fulfill break condition above!
		
		$retval[] = 'Starting with '.count($clusters).' clusters...'."<br>\n";
		$retval[] = '<br clear="all">';
		// return implode($retval);
		
		$mergeCnt = 0;
		$clusterCount = count($clusters);
		do {
			$p->log_function_entry("cluster_merging");
			// $retval[] = "<h1>".($mergeCnt+1).". merger</h1>";
			$sortDistances = array();
			
			// $minDelta = 99999999; $min1 = -1; $min2 = -1;
			foreach ($clusters as $idx1 => $c1) {
				// $distances[$x] = array();
				foreach ($clusters as $idx2 => $c2) {
					if ($idx2 <= $idx1) continue;
					
					$dx = $c1->x - $c2->x;
					$dy = $c1->y - $c2->y;
					$dz = $c1->z - $c2->z;
					
					$delta = sqrt($dx*$dx + $dy*$dy + $dz*$dz);
					// if ($delta < $minDelta) {	$minDelta = $delta;	$min1 = $idx1; $min2 = $idx2; }
					$sortDistances[$idx1.";".$idx2] = $delta;
				}
			}
			asort($sortDistances);
			// $retval[] = "<h2>Least distances between:</h2>\n";
			$mergeInOne = ((count($clusters)-200) / 20); 
			/* 
			90@2000
			65@1500 (~10s)
			40@1000
			30@800 (~ 2.7s)
			10@400 (0.5 ~ 0.6s)
			1@200 (0.13s)
			(and below (pairs!!!))
			*/
			$i=0;
			foreach ($sortDistances as $coords => $delta) {
				if ($i==0) $minDelta = $delta;

				list($x, $y) = explode(";", $coords);
				if (!isset($clusters[$x])) continue;
				if (!isset($clusters[$y])) continue;
			
				$c1 = $clusters[$x];
				$c2 = $clusters[$y];

				if (false) { // debug output:
					$dx = $c1->x - $c2->x;
					$dy = $c1->y - $c2->y;
					$dz = $c1->z - $c2->z;
					$delta = sqrt($dx*$dx + $dy*$dy + $dz*$dz);
					$retval[] = $c1->toHTML();
					$retval[] = $c2->toHTML();
					$retval[] = "Delta: ".$delta."\n";
				}
				
				//form a new cluster from the 2 original ones:
				$totalPxCount = $c1->pxCount + $c2->pxCount;
				$weight1 = $c1->pxCount / $totalPxCount;
				$weight2 = $c2->pxCount / $totalPxCount;
				
				$h1 = $c1->h;
				$h2 = $c2->h;
				if ($h2-$h1 > 180) $h1 += 360;
				if ($h1-$h2 > 180) $h2 += 360;
				
				$nc = new ColorCluster(
					($h1*$weight1 + $h2*$weight2) % 360,
					$c1->s * $weight1 + $c2->s * $weight2,
					$c1->v * $weight1 + $c2->v * $weight2
				);
				$nc->pxCount = $totalPxCount;
				
				// $retval[] = " --- Combined cluster:".$nc->toHTML()."<br>\n";
			
				// drop the two old clusters, add the new one:
				unset($clusters[$x]);
				unset($clusters[$y]);
				$clusters[$clusterCount] = $nc;
				$clusterCount ++;

				if ($i >= $mergeInOne) {
					$p->log_sentinel("merged ".$i." additional clusters in one step, now there are ".count($clusters)." clusters.");
					break;
				}
				$i++;
			}

			$p->log_function_exit("cluster_merging");

			if ($minDelta > $MAX_ACCEPTABLE_CLUSTER_DELTA) break;
			
			// $c1 = $clusters[$min1]; $c2 = $clusters[$min2];
			
			/*
			$retval[] = "<h2>Current clusters:</h2>";
			foreach ($clusters as $c) $retval[] = $c->toHTML()."<br>\n";
			*/
			
			$mergeCnt++;
		} while (count($clusters) > 2);
		$p->log_sentinel("merging finished");
		
		$retval[] = "<h1>Final clusters after ".$mergeCnt." mergers:</h1>";
		foreach ($clusters as $c) $retval[] = $c->toHTML($pxCount)."<br>\n";
		
		// find main colors:
		$baseColors = array();
		$sortClusters = array();
		foreach ($clusters as $idx => $c) $sortClusters[$idx] = $c->pxCount;
		arsort($sortClusters);
		$i=0; $pxCountSum = 0;
		foreach ($sortClusters as $idx => $cnt) {
			$baseColors[] = $clusters[$idx];
			$pxCountSum += $clusters[$idx]->pxCount;
	
			// remove base color from further analysis:
			unset($clusters[$idx]);
			
			if ($pxCountSum > ($pxCount * 1/3)) break;
			
			$i++;	
			
			// allow short break only after 25% of pixels have been accounted for!
			if ($pxCountSum > ($pxCount * 0.25)) {
				if ($i>2) break;
			}
		}
		$newClusters = array();
		foreach ($clusters as $c) $newClusters[] = $c;
		$clusters = $newClusters;
		
		
		// check and remove colors, which are too close to any base color:
		$retval[] = "<h1>Dropping colors, which are too similar to a base color:</h1>";
		$dropList = array();
		for ($i=0; $i<count($baseColors); $i++) {
			for ($j=0; $j<count($clusters); $j++) {
				$dx = $baseColors[$i]->x - $clusters[$j]->x;
				$dy = $baseColors[$i]->y - $clusters[$j]->y;
				$dz = $baseColors[$i]->z - $clusters[$j]->z;
				
				$delta = sqrt($dx*$dx + $dy*$dy + $dz*$dz);
				
				if ($delta < $MIN_ACCEPTABLE_CONTRASTING_DISTANCE) {
					$retval[] = "Distance between ".$baseColors[$i]->toHtml()." and ".$clusters[$j]->toHtml()." is only ".$delta.".<br>\n";
					$dropList[] = $j;
				}
			}
		}
		$newClusters = array();
		for ($i=0; $i<count($clusters); $i++) {
			if (!in_array($i, $dropList))	$newClusters[] = $clusters[$i];
		}
		$clusters = $newClusters;
		$p->log_sentinel("base colors finished");
		
	
		
		
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
					if ($x == $y) continue;
		
					$dx = $clusters[$x]->x - $clusters[$y]->x;
					$dy = $clusters[$x]->y - $clusters[$y]->y;
					$dz = $clusters[$x]->z - $clusters[$y]->z;
					
					$delta = sqrt($dx*$dx + $dy*$dy + $dz*$dz);
					
					// mark differences between non-considered clusters as uninteresting
					/*
					if ( (mb_strlen($clusters[$x]->marker) == 0) and (mb_strlen($clusters[$y]->marker) == 0) ) {
						$delta = 0;
					} */
					
					$distances[$x][$y] = $delta;
					$sortDistances[$x.";".$y] = $delta;
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
						if ($x == $y) continue;
						$score = 0;
						for ($c = 0; $c < count($clusters); $c++) {
							if ($x == $c) continue;
							if ($y == $c) continue;
							
							$deltaX = $distances[$x][$c];
							$deltaY = $distances[$y][$c];
							$score += abs($deltaX - $deltaY);
						}
						$score /= count($clusters)-2;
						
						$communalities[$x][$y] = $score;
						$sortComm[$x.";".$y] = $score;
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
				
			if ($leastDistance > $MAX_ACCEPTABLE_DELTA_WHEN_DROPPING) break;
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
			foreach($clusters as $c) $newClusters[] = $c;
			$clusters = $newClusters;
	
			$dropCnt ++;
		} while(count($clusters) > 3);
		$p->log_sentinel("dropping finished");
	
		$retval[] = "<h1>Final clusters after ".$dropCnt." drops:</h1>";
		foreach ($clusters as $c) $retval[] = $c->toHTML($pxCount)."(s*v = ".($c->s * $c->v).")<br>\n";
	
		// drop the one with least s*v score:
		$sortScores = array();
		for ($i=0; $i<count($clusters); $i++) {
			$sortScores[$i] = $clusters[$i]->s * $clusters[$i]->v;
		}
		asort($sortScores);
		foreach($sortScores as $idx => $score) {
			if (($clusters[$idx]->v > 0.8) or ($clusters[$idx]->v < 0.2)) {
				; // keep it, if it's very dark or very light.
			} else {
				$retval[] = "<p>Dropping ".$clusters[$idx]->toHtml()." with least s*v score ".$score."</p>\n";
				unset($clusters[$idx]);
			}
			break;
		}
		$newClusters = array();
		foreach ($clusters as $c) $newClusters[] = $c;
		$contrastingColors = $newClusters;
		
		
	
	
		$retval[] = "<h1>Final base colors:</h1>";
		foreach ($baseColors as $c) $retval[] = $c->toHTML($pxCount).")<br>\n";
	
		$retval[] = "<h1>Final contrasting colors:</h1>";
		foreach ($contrastingColors as $c) $retval[] = $c->toHTML($pxCount).")<br>\n";
		
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
		
		$p->terminate();
		
		return implode("\n", $retval);
			
	}

	function makeMoodChart() {
		$retval = array();
		
		if (!isset($this->previewWidth)) {
			$basename = Img::stdName($this->filename);
			$dirname = Img::getStorageDir('preview', $basename, 'file');
			$prvfile = $dirname.$basename.".jpg";
			$info = getimagesize($prvfile);
			$this->previewWidth = $info[0];
			$this->previewHeight = $info[1];
			$pxCount = $this->previewWidth * $this->previewHeight;
		}

		$im = ImageCreate($this->previewWidth, $this->previewHeight);

		if (isset($this->averageColor)) {
			$rgb = CCtoRGB($this->averageColor);
			extract($rgb);
			$c = ImageColorAllocate($im, $r, $g, $b);
			ImageFilledRectangle($im, 0, 0, $this->previewWidth, $this->previewHeight, $c);
		}
		
		if (isset($this->baseColors) and isset($this->contrastingColors)) {
			
			
			// first: stripes of base colors:
			$basePx = 0;
			foreach($this->baseColors as $c) $basePx += $c->pxCount;
			$areaWidth = $this->previewWidth; // * sqrt($basePx / $pxCount);
			$areaHeight = $this->previewHeight; // * sqrt($basePx / $pxCount);
			$xOffset = ($this->previewWidth - $areaWidth) / 2;
			$yOffset = ($this->previewHeight - $areaHeight) / 2;
			
			$yStart = 0;
			for ($i=0; $i<count($this->baseColors); $i++) {
				$rowHeight = $areaHeight * ($this->baseColors[$i]->pxCount / $basePx);
				$y0 = $yStart;
				$y1 = floor($yStart + $rowHeight + 0.5);
				$rgb = $this->baseColors[$i]->rgb;
				extract($rgb);
				$c = ImageColorAllocate($im, $r, $g, $b);
				ImageFilledRectangle(
					$im, 
					$xOffset, 
					$yOffset + $y0, 
					$xOffset + $areaWidth, 
					$yOffset + $y1,
					$c
				);
				$yStart = $y1 + 1;
			}
			
			// second: contrasting colors according to their weight:
			$cx = $this->previewWidth / 2;
			$cy = $this->previewHeight / 2;
			$rCycle = min($this->previewWidth, $this->previewHeight) * 0.45;

			$maxIdx = -1; $maxPx = -1;
			foreach ($this->contrastingColors as $idx => $c) {
				if ($c->pxCount > $maxPx) {
					$maxIdx = $idx;
					$maxPx = $c->pxCount;
				}
			}
			$degPerSegment = 360 / count($this->contrastingColors);
			for ($i=0; $i<count($this->contrastingColors); $i++) {
				$myAngle = $i * $degPerSegment + 90 + 15;
				$weight = $this->contrastingColors[$i]->pxCount;
				$myDiameter = floor(pow($weight, 1/2) + 0.5) + 8;
				// if ($myDiameter < 8) $myDiameter = 8;

				// $retval[] = $myAngle;
				$myAngle = deg2rad($myAngle);
				$x = floor($cx + cos($myAngle) * ($rCycle - $myDiameter/2) + 0.5);
				$y = floor($cy + sin($myAngle) * ($rCycle - $myDiameter/2) + 0.5);
				
				// show the most present contrasting color in the center
				if ($i == $maxIdx) { $x = $cx; $y = $cy; }
				
				$rgb = $this->contrastingColors[$i]->rgb;
				extract($rgb);
				$c = ImageColorAllocate($im, $r, $g, $b);
				
				$success = ImageFilledEllipse($im, $x, $y, $myDiameter, $myDiameter, $c);
				// if (!$success) $retval[] = "Ellipse failed.";
			}
			
			{ // debug output:
				$basename = Img::stdName($this->filename);
				$dirname = Img::getStorageDir('histogram', $basename, 'url');
				$outfile = $dirname.$basename."-mood.jpg";
				$retval[] = '<img src="'.$outfile.'">';
			}

		} else {
			drupal_set_message('base colors and/or contrasting colors not set in makeMoodChart', 'error');
		}
		
		$basename = Img::stdName($this->filename);
		$dirname = Img::getStorageDir('histogram', $basename, 'file');
		$outfile = $dirname.$basename."-mood.jpg";
		
		ImagePNG($im, $outfile);

		return implode("\n", $retval);
	}
	
	function makeChartAnimScript($chartList, $imgFileName, $width, $height) {
		$path = $_SERVER['DOCUMENT_ROOT'].'/'.base_path().drupal_get_path('module', 'cartrends').'/';
		// echo $path;
		
		// file list for EasyBMPtoAVI
		$f = fopen($path.'filelist.txt', 'w');
		$s = implode("\r\n", $chartList);
		$s = str_replace('.png', '-comp.bmp', $s);
		fputs($f, $s);
		fclose($f);
		
		$f = fopen($path.'process.cmd', 'w');
		fputs($f, 'C:'."\r\n");
		fputs($f, 'cd \\vd\\temp'."\r\n");
		fputs($f, 'copy Q:\agora2\sites\all\modules\cartrends\rescaled.jpg . /y'."\r\n");
		fputs($f, 'copy Q:\agora2\sites\all\modules\cartrends\chart-*.png . /y >nul'."\r\n");
		fputs($f, 'REM del Q:\agora2\sites\all\modules\cartrends\chart-*.png'."\r\n");
		fputs($f, ''."\r\n");
		foreach($chartList as $name) {
			$pngName = basename($name);
			$bmpName = str_replace('png', 'bmp', $pngName);
			$compName = str_replace('.png', '-comp.bmp', $pngName);
			// fputs($f, '"C:\Program Files\ImageMagick-6.7.0-Q16\convert" '.$pngName.' '.$bmpName."\r\n");
			// fputs($f, '"C:\Program Files\ImageMagick-6.7.0-Q16\montage" '.$bmpName.' rescaled.jpg '.$compName."\r\n");

			fputs($f, '"C:\Program Files\ImageMagick-6.7.0-Q16\mogrify" +append -extent '.$width.'x'.$height.' -format bmp '.$pngName."\r\n");
			fputs($f, '"C:\Program Files\ImageMagick-6.7.0-Q16\composite" -gravity East rescaled.jpg '.$bmpName.' '.$compName."\r\n");
		}
		fputs($f, 'del *.png'."\r\n");
		fputs($f, ''."\r\n");
		fputs($f, 'copy Q:\agora2\sites\all\modules\cartrends\filelist.txt . /y'."\r\n");
		fputs($f, 'c:\easybmptoavi\EasyBMPtoAVI.exe -filelist filelist.txt -framerate 25 -output out.avi'."\r\n");
		fputs($f, 'del *.bmp'."\r\n");
		fputs($f, 'c:\vd\virtualdub.exe /s colorspace-convert.vcf /p out.avi '.basename($imgFileName).'.avi /r /x'."\r\n");
		fputs($f, 'del out.avi'."\r\n");

		fputs($f, ''."\r\n");
		fputs($f, 'REM animated GIF output:'."\r\n");
		fputs($f, 'REM "C:\Program Files\ImageMagick-6.7.0-Q16\convert" -delay 4 chart-???.png -fuzz 40% -map colormap_332.png anim.miff'."\r\n");
		fputs($f, 'REM "C:\Program Files\ImageMagick-6.7.0-Q16\convert" anim.miff -delay 4 -coalesce +dither -layers OptimizeTransparency anim-opt.gif'."\r\n");

		fclose($f);
	}
			

	
	function generateHistograms() {
		$retval[] = array();

		// global $PATH;
		
		$basename = Img::stdName($this->filename);
		$dirname = Img::getStorageDir('preview', $basename, 'file');
		$prvfile = $dirname.$basename.".jpg";

		$info = getimagesize($prvfile);
		$gd = ImageCreateFromJPEG($prvfile);
			$w = $info[0]; $h = $info[1];
			$gdh = ImageCreate($w,$h); $gds = ImageCreate($w,$h); $gdv = ImageCreate($w,$h); $gdsv = ImageCreate($w,$h);
			$gdhcolors = array();	$gdscolors = array();	$gdvcolors = array();	$gdsvcolors = array();
			for ($v = 0; $v<256; $v++) {
				$rgb = getRGBforHSV($v/255*360, 0.8, 1);
				$gdhcolors[$v] = ImageColorAllocate($gdh,$rgb["r"],$rgb["g"],$rgb["b"]);
				$gdscolors[$v] = ImageColorAllocate($gds,$v,$v,$v);
				$gdvcolors[$v] = ImageColorAllocate($gdv,$v,$v,$v);
				$gdsvcolors[$v] = ImageColorAllocate($gdsv,$v,$v,$v);
			}
		$rSum = 0; $gSum = 0;	$bSum = 0;
		$hHist = array(); $sHist = array(); $vHist = array();
		for ($i=0; $i<72; $i++) {	$hHist[$i] = 0; $sHist[$i] = 0; $vHist[$i] = 0;	}

		for ($x = 0; $x < $info[0]; $x++) {
			for ($y = 0; $y < $info[1]; $y++) {
				$ccInt = ImageColorAt($gd, $x, $y);
				$r = ($ccInt & 0xff0000) >> 16;
				$g = ($ccInt & 0x00ff00) >> 8;
				$b = ($ccInt & 0x0000ff);
				$rgbV = ($r + $g + $b) / (3*255);
				
				$hsv = getHSVforRGB($r,$g,$b);
				$s = getAbsSforRGB($r,$g,$b);
				$hHist[floor($hsv["h"]/5)] += $s;
					$idx = floor($s*72); if ($idx == 72) $idx = 71;
				$sHist[$idx] ++;
					// $idx = floor($hsv["v"]*72); if ($idx == 72) $idx = 71; // based on HSV["v"];
					$idx = floor($rgbV*72); if ($idx == 72) $idx = 71; // based on v(RGB)
				$vHist[$idx] ++;
	
				$rSum += $r; $gSum += $g;	$bSum += $b;
				
				ImageSetPixel($gdh, $x, $y, $gdhcolors[floor($hsv["h"]/360*255)]);
				ImageSetPixel($gds, $x, $y, $gdscolors[floor($s*255)]);
				// ImageSetPixel($gdv, $x, $y, $gdvcolors[floor($hsv["v"]*255)]);
				ImageSetPixel($gdv, $x, $y, $gdvcolors[floor($rgbV*255)]);
				ImageSetPixel($gdsv, $x, $y, $gdsvcolors[floor($s*$rgbV*255)]);
			}
		}
		
		ImageDestroy($gd);
		
		$outdir = Img::getStorageDir('histogram', $basename, 'file');
		ImagePNG($gdh, $outdir.$basename."-Hmap.png");
		ImagePNG($gds, $outdir.$basename."-Smap.png");
		ImagePNG($gdv, $outdir.$basename."-Vmap.png");
		ImagePNG($gdsv, $outdir.$basename."-SxVmap.png");
		ImageDestroy($gdh);
		ImageDestroy($gds);
		ImageDestroy($gdv);
		ImageDestroy($gdsv);
	
		$rSum = floor($rSum / ($x*$y));
		$gSum = floor($gSum / ($x*$y));
		$bSum = floor($bSum / ($x*$y));
		$cc = RGBtoCC($r,$g,$b);
			// echo '<span style="border: 1px solid #000000; background-color:#'.$cc.';">&nbsp;&nbsp;&nbsp;</span>';
	
		$hst = new Histogram($hHist);
		$hst->imgid = $this->imgid;
		$hst->width = 150; $hst->height = 150;
		$colors = array();
		for ($i=0; $i<72; $i++) {
			$rgb = getRGBforHSV(5*$i+2.5, 0.6, 1);
			$colors[$i] = RGBtoCC($rgb);
		}
		$hst->colors = $colors;
		$im = $hst->getCircularGD();
		$this->persistHistogram($hst, 102);
		ImagePNG($im, $outdir.$basename."-H.png");
		// echo "H: ".$hst->toHTML()."<br />\n";
		
		$hst = new Histogram($sHist);
		// $hst->data = $sHist;
		$hst->width = 150; $hst->height = 75;
		$colors = array();
		for ($i=0; $i<72; $i++) {
			$rgb = getRGBforHSV(240, $i/71, 1);
			$colors[$i] = RGBtoCC($rgb);
		}
		$hst->colors = $colors;

		// calculate third portions of the histogram (low / medium / high percentage)
		$thirds = array(0, 0, 0);
		$sum = 0;
		$oneThird = count($sHist)/3;
		for ($i=0; $i<count($sHist); $i++) {
			$thirds[floor($i / $oneThird)] += $sHist[$i];
			$sum += $sHist[$i];
		}
		for ($i=0; $i<3; $i++) $hst->thirdPortions[$i] = $thirds[$i] / $sum * 100;

		$im = $hst->getGD();
		ImagePNG($im, $outdir.$basename."-S.png");
		$this->persistHistogram($hst, 103);
		// echo "S: ".$hst->toHTML()."<br />\n";
		



		$hst->data = $vHist;
		$hst->width = 150; $hst->height = 75;
		$colors = array();
		for ($i=0; $i<72; $i++) {
			$rgb = getRGBforHSV(240, 0, $i/71);
			$colors[$i] = RGBtoCC($rgb);
		}
		$hst->colors = $colors;

		// calculate third portions of the histogram (low / medium / high percentage)
		$thirds = array(0, 0, 0);
		$sum = 0;
		$oneThird = count($vHist)/3;
		for ($i=0; $i<count($vHist); $i++) {
			$thirds[floor($i / $oneThird)] += $vHist[$i];
			$sum += $vHist[$i];
		}
		for ($i=0; $i<3; $i++) $hst->thirdPortions[$i] = $thirds[$i] / $sum * 100;

		$im = $hst->getGD();
		ImagePNG($im, $outdir.$basename."-V.png");
		$this->persistHistogram($hst, 104);
		// echo "V: ".$hst->toHTML()."<br />\n";
	
		
		return implode("\n", $retval);
	}
	
	function persistHistogram($hst, $subType) {
		global $user;
		
		db_query("DELETE FROM {cartrends_imgattr} WHERE imgid = %d AND type=4 AND subType=%d", $this->imgid, $subType);
		
		// insert record:
		db_query(
			"INSERT INTO {cartrends_imgattr} "
  		."(imgid, type, subType, value, userid, touchdate) VALUES "
  		."(%d, 4, %d, '%s', %d, '%s')", 
  		$this->imgid, $subType, $hst->toString(), $user->uid, strftime("%Y-%m-%d %H:%M:%S")
  	);
  	
  	if (count($hst->thirdPortions) > 0) {
	  	//insert third portions:
	  	for ($i=0; $i<count($hst->thirdPortions); $i++) {
	  		$mySubType = $subType + ($i+1) * 10;
				db_query("DELETE FROM {cartrends_imgattr} WHERE imgid = %d AND type=4 AND subType=%d", $this->imgid, $mySubType);
				db_query(
					"INSERT INTO {cartrends_imgattr} "
		  		."(imgid, type, subType, value, numvalue, userid, touchdate) VALUES "
		  		."(%d, 4, %d, '%s', %f, %d, '%s')", 
		  		$this->imgid, $mySubType, '', $hst->thirdPortions[$i], $user->uid, strftime("%Y-%m-%d %H:%M:%S")
		  	);
	    }
  	}
	}
	
	function extractEXIF() {
		$retval = array();

		$extPath = 		
			$_SERVER["DOCUMENT_ROOT"].
			base_path().
			drupal_get_path('module','cartrends').
			'/metadata_tk/';
		require_once($extPath.'Toolkit_Version.php');
		require_once($extPath.'JPEG.php');
		require_once($extPath.'JFIF.php');
		require_once($extPath.'PictureInfo.php');
		require_once($extPath.'XMP.php');
		require_once($extPath.'Photoshop_IRB.php');
		require_once($extPath.'EXIF.php');
		// require_once('metadata_tk/.php');

    // Retrieve the header information
    $jpegHeaderData = get_jpeg_header_data( $this->filename ); // in JPEG.php
    	//$retval[] = FX::toHtmlTable($jpegHeaderData);

		$appSegments = $this->extractJPEGAppSegments($jpegHeaderData);
    	// $retval[] = FX::toHtmlTable($appSegments);
    	
    $exif = get_EXIF_JPEG($this->filename); // in EXIF.php
    	$retval[] = FX::toHtmlTable($exif);
    	
    $exifContainer = $this->interpretEXIF($exif);
    	$retval[] = FX::toHtmlTable($exifContainer);
		
		
		return implode("\n", $retval);
	}
	
	
	/** based on Generate_JPEG_APP_Segment_HTML / JPEG.php */
	function extractJPEGAppSegments( $jpegHeaderData ) {
		$retval = array();
		
		if ( $jpegHeaderData == FALSE )	return false;
	
		// Cycle through each segment in the array
		foreach( $jpegHeaderData as $jpegHeader ) {
	
			// Check if the segment is a APP segment
			if ( ( $jpegHeader['SegType'] >= 0xE0 ) && ( $jpegHeader['SegType'] <= 0xEF ) )	{
				// This is an APP segment
	
				// Read APP Segment Name - a Null terminated string at the start of the segment
				$segName = strtok($jpegHeader['SegData'], "\x00");
	
				// Some Segment names are either too long or not meaningfull, so
				// we should clean them up
	
				if ( $segName == "http://ns.adobe.com/xap/1.0/" ) {
					$segName = "XAP/RDF (\"http://ns.adobe.com/xap/1.0/\")";
				}	elseif ( $segName == "Photoshop 3.0" )	{
					$segName = "Photoshop IRB (\"Photoshop 3.0\")";
				}	elseif 
					( ( strncmp ( $segName, "[picture info]", 14) == 0 ) ||
					( strncmp ( $segName, "\x0a\x09\x09\x09\x09[picture info]", 19) == 0 ) )
				{
					$segName = "[picture info]";
				}	elseif (  strncmp ( $segName, "Type=", 5) == 0 )	{
					$segName = "Epson Info";
				}	elseif 
					( ( strncmp ( $segName, "HHHHHHHHHHHHHHH", 15) == 0 ) ||
					( strncmp ( $segName, "@s33", 5) == 0 ) )
				{
					$segName = "HP segment full of \"HHHHH\"";
				}
	
				// Clean the segment name so it doesn't cause problems with HTML
				// $segName = FX:html_encode($segName);

				$segment = new stdClass();
				$segment->name = $segName;
				$segment->type = $jpegHeader['SegName'];
				$segment->length = strlen( $jpegHeader['SegData']);

				$retval[] = $segment;
			}
		}
	
		return $retval;
	}
	
	/******************************************************************************
	*
	* Function:     Interpret_EXIF_to_HTML (from EXIF.php)
	*
	* Description:  Generates html detailing the contents an APP1 EXIF array
	*               which was retrieved with a get_EXIF_.... function.
	*               Can also be used for APP3 Meta arrays.
	*
	* Parameters:   Exif_array - the EXIF array,as read from get_EXIF_....
	*               filename - the name of the Image file being processed ( used
	*                          by scripts which displays EXIF thumbnails)
	*
	* Returns:      output_str - A string containing the HTML
	*
	******************************************************************************/
	
	function interpretEXIF($exifArray) {
		$exif = new EXIFContainer();
	
		if ( $exifArray === false ) return false;
		if ( !is_array($exifArray) ) return false;
	
		// Ouput the heading according to what type of tags were used in processing
		/*
		if ( $exifArray[ 'Tags Name' ] == "TIFF" ) {
			$output_str .= "<h2 class=\"EXIF_Main_Heading\">Contains Exchangeable Image File Format (EXIF) Information</h2>\n";
		}	else if ( $exifArray[ 'Tags Name' ] == "Meta" )	{
			$output_str .= "<h2 class=\"EXIF_Main_Heading\">Contains META Information (APP3)</h2>\n";
		}	else {
			$output_str .= "<h2 class=\"EXIF_Main_Heading\">Contains " . $exifArray[ 'Tags Name' ] . " Information</h2>\n";
		}*/
	
		// Check that there are actually items to process in the array
		if ( count( $exifArray ) < 1 ) return false;
	
		$exif->interpretIFD( $exifArray[0], $filename, $exifArray['Byte_Align'] );
	
		// Check if there is a first IFD to process
		if ( isset($exifArray[1]) ) {
			// There is a first IFD for a thumbnail
			
			// TODO
			// $output_str .= "<h3 class=\"EXIF_Secondary_Heading\">Thumbnail Information</h2>\n";
			// Interpret the IFD to html and add it to the output
			// $output_str .= interpret_IFD( $exifArray[1], $filename, $exifArray['Byte_Align'] );
		}
	
		// Cycle through any other IFD's
		$i = 2;
		while (isset($exifArray[$i])) {
			// Add a heading for the IFD
			// $output_str .= "<h3  class=\"EXIF_Secondary_Heading\">Image File Directory (IFD) $i Information</h2>\n";
	
			$exif->interpretIFD( $exifArray[$i], $exifArray['Byte_Align'] );
			$i++;
		}

		return $exif;	
	}
	
	/******************************************************************************
	* End of Function:     Interpret_EXIF_to_HTML
	******************************************************************************/



	
}
?>