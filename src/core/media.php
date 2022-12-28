<?php 
class Media{
	
	
	static function Upload($fieldName,$validFileExts,$chemin,$i=-1){

			if($i>=0) $fileError = $_FILES[$fieldName]['error'][$i];
			else $fileError = $_FILES[$fieldName]['error'];
			if ($fileError > 0) {return '';  }

			if($i>=0) $fileSize = $_FILES[$fieldName]['size'][$i];
			else $fileSize = $_FILES[$fieldName]['size'];
			if ($fileSize > 20000000000) {  return ''; }
			if($i>=0) $fileName = $_FILES[$fieldName]['name'][$i];
			else $fileName = $_FILES[$fieldName]['name'];
		    $uploadedFileNameParts = explode('.', $fileName);
	        $uploadedFileExtension = array_pop($uploadedFileNameParts);
	      
			$extOk = false;
	        foreach ($validFileExts as $key => $value) {
	            if (preg_match("/$value/i", $uploadedFileExtension)) {
	                $extOk = true; 
	            }
	        }
		
			if ($extOk == false) {return '';  }
			
			if($i>=0) $fileTemp = $_FILES[$fieldName]['tmp_name'][$i];
			else $fileTemp = $_FILES[$fieldName]['tmp_name'];
			$fileName = preg_replace("/[^A-Za-z0-9]/i", ".", $fileName);
			$uniqueName = strtolower(time() . '_' . $fileName);	
			$uploadPath = $chemin.'/'.$uniqueName;
	
		if(!move_uploaded_file($fileTemp, $uploadPath))return '';
				return $uniqueName;
		}
		
		
		
	function thumb($file, $save, $width, $height){
		@unlink($save);
		if (!$infos = @getimagesize($file)) {
			return false;
		}
		$iWidth = $infos[0];
		$iHeight = $infos[1];
		if(!empty($height))			$iNewH = $height;
		if(!empty($width))			$iNewW = $width;
		if(empty($height))			$iNewH = ($iHeight/$iWidth)*$iNewW;
		if(empty($width))			$iNewW = ($iWidth/$iHeight)*$iNewH;
		if ($infos[0] < $width && $infos[1] < $height) {
			$iNewW = $infos[0];
			$iNewH = $infos[1];
		}
		if($infos[2] == 1) {
			$imgA = imagecreatefromgif($file);
			$imgB = imagecreate($iNewW,$iNewH);
          	if(function_exists('imagecolorsforindex') && function_exists('imagecolortransparent')) {
            	$transcolorindex = imagecolortransparent($imgA);
            		//transparent color exists
            		if($transcolorindex >= 0 ) {
             			$transcolor = imagecolorsforindex($imgA, $transcolorindex);
              			$transcolorindex = imagecolorallocate($imgB, $transcolor['red'], $transcolor['green'], $transcolor['blue']);
              			imagefill($imgB, 0, 0, $transcolorindex);
              			imagecolortransparent($imgB, $transcolorindex);
              		//fill white
            		} else {
              			$whitecolorindex = @imagecolorallocate($imgB, 255, 255, 255);
              			imagefill($imgB, 0, 0, $whitecolorindex);
            		}
            //fill white
          	} else {
            	$whitecolorindex = imagecolorallocate($imgB, 255, 255, 255);
            	imagefill($imgB, 0, 0, $whitecolorindex);
          	}
          	imagecopyresampled($imgB, $imgA, 0, 0, 0, 0, $iNewW, $iNewH, $infos[0], $infos[1]);
			imagegif($imgB, $save);        

		} elseif($infos[2] == 2) {
			$imgA = imagecreatefromjpeg($file);
			$imgB = imagecreatetruecolor($iNewW,$iNewH);
			imagecopyresampled($imgB, $imgA, 0, 0, 0, 0, $iNewW, $iNewH, $infos[0], $infos[1]);
			imagejpeg($imgB, $save);
			

		} elseif($infos[2] == 3) {
			/*
			* Image is typ png
			*/
			$imgA = imagecreatefrompng($file);
			$imgB = imagecreatetruecolor($iNewW, $iNewH);
			imagealphablending($imgB, false);
			imagecopyresampled($imgB, $imgA, 0, 0, 0, 0, $iNewW, $iNewH, $infos[0], $infos[1]);
			imagesavealpha($imgB, true);
			imagepng($imgB, $save);
			
		} else {
			return false;
		}
		return true;
	}
}