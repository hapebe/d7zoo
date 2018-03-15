<?php
class WebcamAnalyzer {
	/** special visual regions in the images, as array($x, $y, $w, $h) */
	var $regions;
	
	/** GD image resource (source image) */
	var $im;
	
	/** value (lightness) - [$x][$y] = 0..1 */
	var $v;
	
	/** luminosity according to rec. 709 - [$x][$y] = 0..1 */
	var $l709;

	/** chromaticity - [$x][$y] = 0..1 */
	var $c2;
	
	/** local contrasts - [$x][$y] = 0..1 */
	var $lc;
	
	/** local contrasts boosted - [$x][$y] = 0..1 */
	var $lcb;
	
	
	function __construct($im) {
		$this->im = $im;
		$this->regions = array(
			'CAPTIONLEFT' => array(0, 0, 240, 34),
			'CAPTIONRIGHT' => array(975, 0, 304, 34),
			'SKYCENTRAL' => array(286, 1, 195, 104),
			'SEALEFT' => array(33, 219, 146, 146),
			'SEACENTRAL' => array(574, 112, 622, 58), // old: array(644, 114, 129, 129),
			'HORIZON' => array(534, 80, 630, 28),
			'TREETOP' => array(382, 180, 149, 149),
			'GARDENBOAT' => array(511, 363, 106, 106),
			'LAWN' => array(697, 466, 77, 77),
			'ROOFTOP' => array(330, 516, 54, 54),
		);
		
		if ($this->im !== FALSE) {
			$this->readSource();
		}
	}
	
	/**
	 * this list reflects the variables generated by hapebe_webcam_calc_stats(),
	 * it is used for generating CSV export data
	 */
	static function exportVarList() {
		static $vars;
		if (!isset($vars)) {
			$vars = array(
				'v_mean', 'v_sd', 'v_q01', 'v_q05', 'v_q25', 'v_med', 'v_q75', 'v_q95', 'v_q99',
				'c2_mean', 'c2_sd', 'c2_med',
				'lcb_mean', 'lcb_sd', 'lcb_med',
			);
			
			$a = new WebcamAnalyzer(FALSE); // no image
			foreach ($a->regions as $region => $xywh) {
				if ($region == 'CAPTIONLEFT') continue;
				if ($region == 'CAPTIONRIGHT') continue;
				
				$vars[] = 'v_'. $region . '_mean';
				$vars[] = 'v_'. $region . '_sd';
				$vars[] = 'v_'. $region . '_med';

				// .. and some special additions:
				if ($region == 'GARDENBOAT') {
					$vars[] = 'v_'. $region . '_q95';
					$vars[] = 'v_'. $region . '_q99';
				}
				
				$vars[] = 'c2_'. $region . '_mean';
				$vars[] = 'c2_'. $region . '_sd';
				$vars[] = 'c2_'. $region . '_med';
				
				$vars[] = 'lcb_'. $region . '_mean';
				$vars[] = 'lcb_'. $region . '_sd';
				$vars[] = 'lcb_'. $region . '_med';
			}
		}
		return $vars;
	}
	
	function isInRegion($region, $x, $y) {
		if (!isset($this->regions[$region])) return FALSE;
		
		$r = $this->regions[$region];
		$x0 = $r[0]; $y0 = $r[1];
		$x1 = $x0 + $r[2]; $y1 = $y0 + $r[3];
		
		if (($x < $x0) || ($x > $x1)) return FALSE;
		if (($y < $y0) || ($y > $y1)) return FALSE;
		return TRUE;
	}
	
	function readSource() {
		$this->l709 = array();
		$this->v = array();
		$this->c2 = array();
		$this->lc = array();
		$this->lcb = array();
		
		$x0 = 0; $x1 = ImageSX($this->im);
		$y0 = 0; $y1 = ImageSY($this->im);

		// fetch the pixels as data arrays:
		for ($x=$x0; $x<$x1; $x++) {
			$this->l709[$x] = array();
			$this->v[$x] = array();
			$this->c2[$x] = array();
			for ($y=$y0; $y<$y1; $y++) {
				// skip, if it's in the caption regions:
				if ($this->isInRegion('CAPTIONLEFT', $x, $y)) continue;
				if ($this->isInRegion('CAPTIONRIGHT', $x, $y)) continue;
				
				$rgb = Color::GD2RGB(ImageColorAt($this->im, $x, $y));
				$hsv = Color::HSV4RGB($rgb);
				extract($rgb);
				extract($hsv);

				// Rec. 709 lightness
				$this->l709[$x][$y] = ($r*0.2126 + $g*0.7152 + $b*0.0722) / 255.0; // according to "Rec. 709"
				
				// RGB lightness:
				$this->v[$x][$y] = ($r + $g + $b) / (3 * 255.0);
				
				// chroma:
				$this->c2[$x][$y] = sqrt($s * $s * $v);
			}
		}
		
		// calculate local contrasts:
		for ($x=$x0; $x<$x1; $x++) {
			$this->lc[$x] = array();
			for ($y=$y0; $y<$y1; $y++) {
				// skip, if it's in the caption regions:
				if ($this->isInRegion('CAPTIONLEFT', $x, $y)) continue;
				if ($this->isInRegion('CAPTIONRIGHT', $x, $y)) continue;
				
				// search for min and max in a 3x3 matrix of neighbors:
				$min = 1; $max = 0;
				for ($dx = -1; $dx <= 1; $dx ++) {
					for ($dy = -1; $dy <= 1; $dy ++) {
						if (!isset($this->l709[$x+$dx][$y+$dy])) continue;
						
						$pixel = $this->l709[$x+$dx][$y+$dy];
						if ($pixel < $min) $min = $pixel;
						if ($pixel > $max) $max = $pixel;
					}
				}
				
				$c = $max - $min;
				$this->lc[$x][$y] = $c;
			}
		}
		
		// "boosted" contrasts - set to their maximum in a 3x3 matrix
		for ($x=$x0; $x<$x1; $x++) {
			$this->lcb[$x] = array();
			for ($y=$y0; $y<$y1; $y++) {
				// skip, if it's in the caption regions:
				if ($this->isInRegion('CAPTIONLEFT', $x, $y)) continue;
				if ($this->isInRegion('CAPTIONRIGHT', $x, $y)) continue;

				// search for min and max in a 3x3 matrix of neighbors:
				$max = 0;
				for ($dx = -1; $dx <= 1; $dx ++) {
					for ($dy = -1; $dy <= 1; $dy ++) {
						if (!isset($this->lc[$x+$dx][$y+$dy])) continue;
						
						$pixel = $this->lc[$x+$dx][$y+$dy];
						if ($pixel > $max) $max = $pixel;
					}
				}
				
				$this->lcb[$x][$y] = $max;
			}
		}
	}
	
	/**
	 * writes value maps for the image:
	 * l709
	 * v(alue - lightness)
	 * c2 (chromaticity)
	 * lc (local contrast)
	 * lcb (local contrast, boosted)
	 */
	function writeStatImages($showRegions = FALSE) {
		static $CFG;
		if (!isset($CFG)) $CFG = hapebe_webcam_analytics_config();
		
		$x0 = 0; $x1 = ImageSX($this->im);
		$y0 = 0; $y1 = ImageSY($this->im);
		
		$l709 = ImageCreateTrueColor($x1, $y1);
		ImageFilledRectangle($l709, 0, 0, $x1, $y1, ImageColorAllocate($l709, 32, 32, 128));
		$v = ImageCreateTrueColor($x1, $y1);
		ImageFilledRectangle($v, 0, 0, $x1, $y1, ImageColorAllocate($v, 32, 32, 128));
		$c2 = ImageCreateTrueColor($x1, $y1);
		ImageFilledRectangle($c2, 0, 0, $x1, $y1, ImageColorAllocate($c2, 32, 32, 128));
		$lc = ImageCreateTrueColor($x1, $y1);
		ImageFilledRectangle($lc, 0, 0, $x1, $y1, ImageColorAllocate($lc, 32, 32, 128));
		$lcb = ImageCreateTrueColor($x1, $y1);
		ImageFilledRectangle($lcb, 0, 0, $x1, $y1, ImageColorAllocate($lcb, 32, 32, 128));
		
		for ($x=$x0; $x<$x1; $x++) {
			for ($y=$y0; $y<$y1; $y++) {
				// skip, if it's in the caption regions:
				if ($this->isInRegion('CAPTIONLEFT', $x, $y)) continue;
				if ($this->isInRegion('CAPTIONRIGHT', $x, $y)) continue;
				
				$pixel = floor($this->l709[$x][$y] * 255 + 0.5);
				ImageSetPixel($l709, $x, $y, ImageColorAllocate($l709, $pixel, $pixel, $pixel));
				
				$pixel = floor($this->v[$x][$y] * 255 + 0.5);
				ImageSetPixel($v, $x, $y, ImageColorAllocate($v, $pixel, $pixel, $pixel));
				
				$pixel = floor($this->c2[$x][$y] * 255 + 0.5);
				ImageSetPixel($c2, $x, $y, ImageColorAllocate($c2, $pixel, $pixel, $pixel));
				
				$pixel = floor($this->lc[$x][$y] * 255 + 0.5);
				ImageSetPixel($lc, $x, $y, ImageColorAllocate($lc, $pixel, $pixel, $pixel));
				
				$pixel = floor($this->lcb[$x][$y] * 255 + 0.5);
				ImageSetPixel($lcb, $x, $y, ImageColorAllocate($lcb, $pixel, $pixel, $pixel));
			}
		}
		
		if ($showRegions) {
			$this->testPaintRegionsToImage($l709);
			$this->testPaintRegionsToImage($v);
			$this->testPaintRegionsToImage($c2);
			$this->testPaintRegionsToImage($lc);
			$this->testPaintRegionsToImage($lcb);
		}
		
		// actually output image files:
		ImageJPEG($l709, $CFG['FILE_BASE_PATH'].'/WebcamAnalyzer-L709.jpg', 100);
		ImageJPEG($v, $CFG['FILE_BASE_PATH'].'/WebcamAnalyzer-V.jpg', 100);
		ImageJPEG($c2, $CFG['FILE_BASE_PATH'].'/WebcamAnalyzer-C2.jpg', 100);
		ImageJPEG($lc, $CFG['FILE_BASE_PATH'].'/WebcamAnalyzer-LC.jpg', 100);
		ImageJPEG($lcb, $CFG['FILE_BASE_PATH'].'/WebcamAnalyzer-LCB.jpg', 100);
			
		ImageDestroy($l709);
		ImageDestroy($v);
		ImageDestroy($c2);
		ImageDestroy($lc);
		ImageDestroy($lcb);
	}
	
	/**
	 * expects:
	 * $region: name of the region to be analyzed, or FALSE for the whole image
	 * $fileid: suffix of a CSV file with the pixel stats to be written; or FALSE (if CSV is not required)
	 */
	function getStats($region = FALSE, $fileid = FALSE) {
		static $CFG;
		if (!isset($CFG)) $CFG = hapebe_webcam_analytics_config();
		
		$retval = array();
		
		$x0 = 0; $x1 = ImageSX($this->im);
		$y0 = 0; $y1 = ImageSY($this->im);
		
		if ($region != FALSE) {
			if (!isset($this->regions[$region])) {
				drupal_set_message(t('%file @ %line : Unknown region %region requested.', array('%file' => __FILE__, '%line' => __LINE__, '%region' => $region)), 'error');
				return FALSE;
			}
			$xywh = $this->regions[$region];
			$x0 = $xywh[0]; $x1 = $x0 + $xywh[2];
			$y0 = $xywh[1]; $y1 = $y0 + $xywh[3];
		}
		
		$csv = FALSE; $csvLines = array();
		if ($fileid != FALSE) {
			// write a CSV file (for import to R)
			$csv = fopen($CFG['FILE_BASE_PATH'].'/pixels-'.$fileid.($region?'-'.$region:'').'.csv', 'w');
			fputs($csv, "x,y,h,s,v,chroma2,lcb\n");
		}
		
		$cnt = 0;
		$vValues = array(); $c2Values = array(); $lcbValues = array();
		for ($x=$x0; $x<$x1; $x++) {
			for ($y=$y0; $y<$y1; $y++) {
				if ($region == FALSE) {
					// skip, if it's in the caption regions:
					if ($this->isInRegion('CAPTIONLEFT', $x, $y)) continue;
					if ($this->isInRegion('CAPTIONRIGHT', $x, $y)) continue;
				}
				
				$vValues[] = $this->l709[$x][$y]; // use l709 for v
				$c2Values[] = $this->c2[$x][$y];
				$lcbValues[] = $this->lcb[$x][$y];
				
				if ($fileid != FALSE) {
					$rgb = Color::GD2RGB(ImageColorAt($this->im, $x, $y));
					$hsv = Color::HSV4RGB($rgb);
					extract($rgb);
					extract($hsv);
					
					$csvLines[] = $x.','.$y.','.$h.','.$s.','.$v.','.$this->c2[$x][$y].','.$this->lcb[$x][$y];
					if (count($csvLines) == 1000) {
						fputs($csv, implode("\n", $csvLines) . "\n");
						$csvLines = array();
					} 
				}
				
				$cnt ++;
			}
			
			// if ($x > 10) break; // for debugging only!
		}
		
		if ($fileid != FALSE) {
			fputs($csv, implode("\n", $csvLines)); // no \n after the last record...
			fclose($csv);
		}
		
		$vStats = new WebcamStats($vValues);
		$retval['v'] = $vStats->getStats();
	
		$c2Stats = new WebcamStats($c2Values);
		$retval['c2'] = $c2Stats->getStats();
		
		$lcbStats = new WebcamStats($lcbValues);
		$retval['lcb'] = $lcbStats->getStats();
		
		return $retval;
	}
	
	function testPaintRegionsToImage($im) {
		$c = ImageColorAllocate($im, 0xff, 0xff, 0x33);
		foreach ($this->regions as $r) {
			ImageRectangle($im, $r[0], $r[1], $r[0]+$r[2], $r[1]+$r[3], $c);
		}
	}
	
}
