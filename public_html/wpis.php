<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Wpis_php</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="menu.css">
	<link rel="stylesheet" type="text/css" href="normalize.css">
	<link rel="stylesheet" type="text/css" href="skeleton.css">
</head>
<body>
<div class="container">

<?php
include 'critical.php';

function display_go_back_button() {
	echo '<a href="javascript:history.back()" class="button button-primary">Go Back</a>';
}

function verify_login($input_username, $expected_username, $input_passwd, $expected_passwd) {
	return (trim($input_username)==trim($expected_username) and trim(md5($input_passwd))==trim($expected_passwd));
}

function get_full_date($date_id, $hour_id) {
	$date_cleared  = str_replace('-', "", $_POST[$date_id]);
	$hour_cleared  = str_replace('-', "", $_POST[$hour_id]);
	$hour_cleared  = str_replace(':', "", $_POST[$hour_id]);

	$nowtime = time();
	$seconds = time()%60;

	$full_date = '';
	$full_date .= $date_cleared;
	$full_date .= $hour_cleared;
	$full_date .= sprintf("%02d", $seconds);

	return $full_date;
}

function create_entry_return_identifier($dir) {
	echo 'Writing entry to file...<br>';

	$full_date = get_full_date('date', 'hour');

	$output_path = '';
	$output_path .= $dir;
	$output_path .= $full_date;

	for ($x = 0; $x < 1000; $x++) {
		// --WRITING TO FILE
		if(!file_exists($output_path.sprintf("%02d", $x))) {
			write_to_file_locking($output_path.sprintf("%02d", $x).'.txt', nl2br($_POST['entry']));
			break;
		} else {
			$output_file_name = $output_path.sprintf("%02d", $x).'.txt';
			echo "Error! File $output_file_name already exists...";
		}
	}

	echo 'Succes! <br>';

	display_go_back_button();

	echo '<br>';

	return $x;
}

function upload_file($id, $out_dir, $out_name) {
	// --UPLOADING FILE
	if(isset($_FILES[$id])){
		$errors= array();
		$file_name = $_FILES[$id]['name'];
		$file_size = $_FILES[$id]['size'];
		$file_tmp = $_FILES[$id]['tmp_name'];
		$file_type = $_FILES[$id]['type'];
		$file_ext = strtolower(end(explode('.',$_FILES[$id]['name'])));

		$forbidden_exts = array('txt', 'php');

		if(in_array($file_ext,$forbidden_exts)){
			$errors[]='extensions txt and php are not allowed';
		}

		if($file_size > 2097){ //152
			$errors[]='File size must be less than 2097';
		}

		if(empty($errors)==true) {
			$output_file_path = $out_dir.$out_name.'.'.$file_ext;
			if(!file_exists($output_file_path)) {
				move_uploaded_file($file_tmp,$out_dir.$out_name.'.'.$file_ext);
				echo 'Success<br>';
			} else {
				echo "File $output_file_path already exists!";
			}
		} else{
			print_r($errors);
			echo '<br>';
		}
	}
	// -----------------
}

function is_file_input_empty($id) {
	return (($_FILES[$id]['size'] == 0 && $_FILES[$id]['error'] == 0) || ($_FILES[$id]["error"] == 4));
}

function find_user($username, $passwd, $dirs) {
	$found = false;
	$blog_dir = false;

	foreach ($dirs as $single_dir) {
		$info_file_path='';
		$info_file_path .= $single_dir;
		$info_file_path .= '/info.txt';

		// --READING FILE
		if(file_exists($info_file_path)) {
			$info_file = fopen($info_file_path, 'r+');

			if (flock($info_file, LOCK_SH)) {  // acquire an exclusive lock
				$username_in_file = fgets($info_file);
				$passwd_in_file = fgets($info_file);
			    flock($info_file, LOCK_UN);    // release the lock
			} else {
				echo "Couldn't get the lock!";
			}

			fclose($info_file);

			if(verify_login($username, $username_in_file, $passwd, $passwd_in_file)) {
				$found = true;
				$blog_dir = $single_dir;
				break;
			}
		}
		// -------------
	}

	return $blog_dir;
}

$username = $_POST['username'];
$passwd = $_POST['passwd'];
$dirs = array_filter(glob('*'), 'is_dir');

$blog_dir = find_user($username, $passwd, $dirs);

if($blog_dir==false) {
	echo 'Incorrect login or password! <br>';
	display_go_back_button();
	exit();
}

echo 'Succesfully logged in! <br>';
$output_path = get_full_date('date', 'hour'); 
$identifier = create_entry_return_identifier($blog_dir.'/');

$counter = 1;

//  --File upload-----------------------
echo 'File upload...<br>';
if(!is_file_input_empty('image1')) {
	upload_file('image1', $blog_dir.'/', $output_path.sprintf("%02d", $identifier).strval($counter));
	$counter++;
}
if(!is_file_input_empty('image2')) {
	upload_file('image2', $blog_dir.'/', $output_path.sprintf("%02d", $identifier).strval($counter));
	$counter++;
}
if(!is_file_input_empty('image3')) {
	upload_file('image3', $blog_dir.'/', $output_path.sprintf("%02d", $identifier).strval($counter));
	$counter++;
}
//--------------------------------


?>

</div>
</body>
</html>