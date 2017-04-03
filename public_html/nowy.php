<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Nowy_php</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="menu.css">
	<link rel="stylesheet" type="text/css" href="normalize.css">
	<link rel="stylesheet" type="text/css" href="skeleton.css">
</head>
<body>
<div class="container">

<?php
function display_go_back_button() {
	echo '<a href="javascript:history.back()" class="button button-primary">Go Back</a>';
}

$name = $_POST['name'];

include 'critical.php';

/*if (file_exists($name)) {
	echo "The directory $name already exists <br>";
	display_go_back_button();
	exit();
} else {
	if (!mkdir($name, 0777, true)) {
		echo "Failed to create folder $name... <br>";
		display_go_back_button();
		exit();
	} else {
		echo 'Folder succesfully created! <br>';
		display_go_back_button();
	}
}*/

make_dir_without_race($name);

$info_file = '';
$info_file .= $name;
$info_file .= '/';
$info_file .= 'info.txt';

// --WRITING TO FILE
if(!file_exists($info_file)) {
	$content = '';
	$content .= $_POST['username'].PHP_EOL.'';
	$content .= md5($_POST['passwd']).PHP_EOL.'';
	$content .= $_POST['description'];
	write_to_file_locking($info_file, $content);
} else {
	echo "Error, file $info_file already exists!";
}
// -----------------

?>

</div>
</body>
</html>