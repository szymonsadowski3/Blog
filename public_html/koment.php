<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Koment_php</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="menu.css">
	<link rel="stylesheet" type="text/css" href="normalize.css">
	<link rel="stylesheet" type="text/css" href="skeleton.css">
</head>
<body>
<div class="container">

<?php
function get_server_time() {
	return date('Y-m-d H:i:s');
}

$http_referer = urldecode($_SERVER['HTTP_REFERER']);
$urlparts = explode("?", $http_referer); 
$querystring = urldecode($urlparts[1]); 
$qsparts = explode("&", $querystring); 
$qsparts = array_map(create_function('$data', 'return explode(\'=\', $data);'), $qsparts); 
array_map('extract', $qsparts); 

$blog_dir = $qsparts[0][1];
$entry = $qsparts[1][1];

$directory = $blog_dir.'/'.$entry.'.k';

include 'critical.php';

// --CREATING DIRECTORY FILE
make_dir_without_race($directory);
/*if (!file_exists($directory)) {
	if (!mkdir($directory, 0777, true)) {
		exit('Failed to create folder...');
	} else {
		echo 'Folder succesfully created! <br>';
	}
}*/
// --------------------

$selected_option = $_POST['comment_opinion'];
$username = $_POST['username'];
$comment_content = $_POST['comment'];

$file_content = '';

$file_content .= $selected_option;
$file_content .= PHP_EOL.'';

$file_content .= get_server_time();
$file_content .= PHP_EOL.'';

$file_content .= $username;
$file_content .= PHP_EOL.'';

$file_content .= $comment_content;
$file_content .= PHP_EOL.'';

for ($x = 0; $x < 10000; $x++) {
	$output_name = "$x.txt";
	$output_path = $directory.'/'.$output_name;
	if(!file_exists($output_path)) {
		break;
	}
}

echo '<br>';
echo 'Creating... '.$output_path;

// --WRITING TO FILE
if (!file_exists($output_path)) {
	write_to_file_locking($output_path, $file_content);
} else {
	echo "Error! File $filename already exists";
}
// -----------------


echo '<br>Comment succesfully created';

?>

</div>
</body>
</html>