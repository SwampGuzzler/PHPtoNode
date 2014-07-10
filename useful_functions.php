<?php

function makeCategoryList($item_list) {
	$myrow = array();
	for ($i = 1; $i <= 10; $i++) {
		$result = mysql_query("SELECT contents_list	
				FROM categories
				WHERE idCategory = $i");			
		$myrow = mysql_fetch_array($result);
		$j = $i-1;
		$item_list[$j] = $myrow[0];
	}
	return($item_list);
}
function makeLocationList($item_list) {
	$myrow = array();
	for ($i = 1; $i <= 8; $i++) {
		$result = mysql_query("SELECT location_list	
				FROM categories
				WHERE idCategory = $i");			
		$myrow = mysql_fetch_array($result);
		$j = $i-1;
		$item_list[$j] = $myrow[0];
	}
	return($item_list);
}
function createNewFileName($old_name) {
	$str_array = explode(".",$old_name);
	$new_name = $str_array[0] . '_new.' . $str_array[1];
	return($new_name);
}
function checkAndChangeImageSize($path_animal, $new_path) {
			$image_info = getimagesize($path_animal);
			$image_width = $image_info[0];
			$image_height = $image_info[1];
			$image_type = $image_info[2];
			
// now resize image - want width ~600 or height ~500
		$aspect_ratio = $image_width/$image_height;
		$gain = 0;
	
		if ($aspect_ratio >= 1.2 && ($image_width < 580 || $image_width > 602)) {
			$gain = 600/$image_width;
		} elseif ($aspect_ratio < 1.2 &&($image_height < 490 || $image_height > 502)) {
			$gain = 500/$image_height;
			}
		if ($gain != 0) {
			if ($gain > 1.9) {
				$gain = 1.9;
			}
			$new_w = round($gain * $image_width);
			$new_h = round($gain * $image_height);
			resizeImage($path_animal, $new_path, $new_w, $new_h);
		}
		return($gain);
	}
function replaceSpaces($myStr) {
	$my_array = array();
	$my_array = explode(" ",$myStr);
	$myStr = implode("_", $my_array);
	return($myStr);
}
function replaceUnderscores($myStr) {
	$my_array = array();
	$my_array = explode("_",$myStr);
	$myStr = implode(" ", $my_array);
	return($myStr);
}	
function resizeImage($old_image_path, $new_image_path, $new_width, $new_height) {
    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];

    // Set up the function names
    switch($image_type) {
        case IMAGETYPE_JPEG:
            $image_from_file = 'imagecreatefromjpeg';
            $image_to_file = 'imagejpeg';
            break;
        case IMAGETYPE_GIF:
            $image_from_file = 'imagecreatefromgif';
            $image_to_file = 'imagegif';
            break;
        case IMAGETYPE_PNG:
            $image_from_file = 'imagecreatefrompng';
            $image_to_file = 'imagepng';
            break;
        default:
            echo 'File must be a JPEG, GIF, or PNG image.';
            exit;
    }
    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
	
// create a new image
        $new_image = imagecreatetruecolor($new_width, $new_height);

     // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }
        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }
       // Copy old image to new image - this resizes the image
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image,
                           $new_x, $new_y, $old_x, $old_y,
                           $new_width, $new_height, $old_width, $old_height);

        // Write the new image to a new file
        $image_to_file($new_image, $new_image_path);

     // Free any memory associated with the new image
        imagedestroy($new_image);
	// Free any memory associated with the old image
		imagedestroy($old_image);
		return;
}
// returns array containing list of directories in $path
function get_dir_list($path) {
	$dir_files = array();
	if (!is_dir($path)) return $dir_files; //check that $path is really a dir
	$myList = scandir($path);	
	foreach ($myList as $item) {
		if ($item == '.') { continue; }
		if ($item == '..') { continue; }
		$item_path = $path . DIRECTORY_SEPARATOR . $item;	// check that new path is dir
		if (is_dir($item_path)) {
			$dir_files[] = $item;	// save name of directory
		}
	}
	return $dir_files;
}

// returns array $image_files, ea file in directory is an array item
function get_file_list($path) {
    $image_files = array();
    if (!is_dir($path)) return $image_files;

    $items = scandir($path);
    foreach ($items as $item) {
         $item_path = $path . DIRECTORY_SEPARATOR . $item;
         if (is_file($item_path)) {
             $image_files[] = $item;
         }
    }
    return $image_files;
}
function upload_file($name) {
    global $image_dir_path;
    if (isset($_FILES[$name])) {
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
            return;
        }
        $source = $_FILES[$name]['tmp_name'];
        $target = $image_dir_path . DIRECTORY_SEPARATOR . $filename;
        move_uploaded_file($source, $target);
    }
}
function connecti_to_database($which_db) {
	$myHost = 'fail';
	$serverIP = $_SERVER['SERVER_ADDR'];

	if (strcmp($serverIP, "127.0.0.1") == 0) {
		$myHost = 'localhost';
		$username = 'root';
		$password = 'p3ony';
//		echo "host is ". $myHost ."<br />";
	} else {
		$myHost = 'esame.biostr.washington.edu';
		$username = 'has';
		$password = 'CatsAreGood';
	}			
	if (strcmp($myHost, "fail") == 0) {
		echo "Can't identify server!!";
		return;
	}
	$con = mysqli_connect($myHost, $username, $password, $which_db);
	if (!$con) {
		echo "Failed to connect to ". $which_db. "!<br />";
	}
	return $con;
}

function connect_to_database($which_db) {
	$myHost = 'fail';
	$serverIP = $_SERVER['SERVER_ADDR'];

	if (strcmp($serverIP, "127.0.0.1") == 0) {
		$myHost = 'localhost';
		$username = 'root';
		$password = 'p3ony';
//		echo "host is ". $myHost ."<br />";
	} else {
		$myHost = 'esame.biostr.washington.edu';
		$username = 'has';
		$password = 'CatsAreGood';
	}			
	if (strcmp($myHost, "fail") == 0) {
		echo "Can't identify server!!";
		return;
	}
	$con = mysql_connect($myHost, $username, $password);
	$targ_db = mysql_select_db($which_db, $con);
	if (!$targ_db) {
		echo "Failed to connect to ". $which_db. "!<br />";
	}
	return ;
}
?>

