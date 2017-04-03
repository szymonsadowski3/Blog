<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Blog main</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" />
	<link rel="stylesheet" type="text/css" href="menu.css">
	<link rel="stylesheet" type="text/css" href="normalize.css">
	<link rel="stylesheet" type="text/css" href="skeleton.css">
</head>
<body>
<div class="container">

<?php
//TODO ATTACHMENTS
include 'menu.php';
display_menu();

function display_comment($comment) {
	$handle = fopen($comment, "r");
	if ($handle) {
		while (($line = fgets($handle)) !== false) {
        	echo "$line <br>";
		}
		fclose($handle);
	} else {
    	echo "Error whiledisplaying comment!";
    	return;
	} 
}

function display_comment_pretty($comment) {
	$handle = fopen($comment, "r");
	if ($handle) {
		if (($line = fgets($handle)) !== false) {
			echo '<span class="com-header">Comment type: </span>';
        	echo "$line <br>";
		}

		if (($line = fgets($handle)) !== false) {
			echo '<span class="com-header">Date & Hour: </span>';
        	echo "$line <br>";
		}

		if (($line = fgets($handle)) !== false) {
			echo '<span class="com-header">Username: </span>';
        	echo "$line <br>";
		}

		if (($line = fgets($handle)) !== false) {
			echo '<span class="com-header">Content: </span>';
        	echo "$line <br>";
		}

		while (($line = fgets($handle)) !== false) {
        	echo "$line <br>";
		}

		fclose($handle);
	} else {
    	echo "Error whiledisplaying comment!";
    	return;
	} 
}

function get_blog_description($blog_name) {
	$to_return = '';
	$handle = fopen($blog_name."/info.txt", "r");
	if ($handle) {
		fgets($handle);
		fgets($handle);
		while (($line = fgets($handle)) !== false) {
        	$to_return .= $line;
        	$to_return .= '<br>';
		}

		fclose($handle);
	} else {
    	return;
	}
	return $to_return;
}

function display_header($blog_name) {
	echo "<h1>Blog title: ".$blog_name."</h1>";
	echo "<h2>Description:</h2>";
	echo '<div class="post-container">';
	echo get_blog_description($blog_name);
	echo '</div>';
}

function display_post_info($nr, $year, $month, $day, $hour, $min, $sec) {
	echo '<span class="header">Post info:</span>';
	echo '<p class="container">';
	echo "Entry ID: $nr <br>";
	echo "Date: $year - $month - $day <br>";
	echo "Hour: $hour:$min:$sec <br>";
	echo '</p>';
}

function display_content($file) {
	echo '<span class="header">Entry content:</span>';
	echo '<p class="container">';
	$file_content = file_get_contents($file);
	echo $file_content;
	echo '</p>';
}

function display_comments($blog_name, $name_without_ext) {
	echo '<span class="header">Comments:</span>';
	echo '<div class="container">';
	$comments = glob("$blog_name/$name_without_ext.k/[0-9]*.txt");

	foreach ($comments as $comment) { 
		display_comment_pretty($comment);
		echo '<hr>';
	}

	echo '</div>';
}

function display_add_your_comment($blog_name, $name_without_ext) {
	echo '<span class="header">Add your comment:</span>';
	$href = 'create_comment.php?blog='.$blog_name.'&entry='.$name_without_ext;
	echo '<p class="container">';
	echo '<a href="'.$href.'" class="button button-primary">Click here</a>';
	echo '</p>';
}

function display_attachments($blog_name, $name_without_ext) {
	echo '<span class="header">Attachments:</span>';
	$images_pattern = $blog_name.'/'.$name_without_ext;
	$images_pattern .= '[0-9]*.*';
	$images = glob($images_pattern);

	echo '<ul>';
	foreach ($images as $image) { 
		echo '<li><a href="' .$image. '">'.$image.'</a></li>';
	}
	echo '</ul>';
}

function display_single_post($file, $blog_name) {
	$splitted = explode("/", $file); 
	$name = $splitted[1];
	$year = substr($name, 0, 4);
	$month = substr($name, 4, 2);
	$day = substr($name, 6, 2);
	$hour = substr($name, 8, 2);
	$min = substr($name, 10, 2);
	$sec = substr($name, 12, 2);
	$nr = substr($name, 14, 2);

	$name_without_ext = explode(".", $name);
	$name_without_ext = $name_without_ext[0];

	echo '<div class="post-container">';
	display_post_info($nr, $year, $month, $day, $hour, $min, $sec);
	echo '<hr>';

	display_content($file);
	echo '<hr>';

	display_comments($blog_name, $name_without_ext);

	display_attachments($blog_name, $name_without_ext);

	display_add_your_comment($blog_name, $name_without_ext);

	echo '</div>';
}

function display_posts($blog_name) {
	echo '<h2>Posts:</h2>';

	$text_files = glob("$blog_name/[0-9]*.txt");

	foreach ($text_files as $file) {
		display_single_post($file, $blog_name);
	}
}

function display_blog_exists($blog_name) {
	display_header($blog_name);
	
	display_posts($blog_name);
}

function display_blog_does_not_exists($blog_name) {
	echo "<h1>Nie znaleziono blogu o nazwie $blog_name!</h1>";
}

function display_blog($blog_name) {
	if(file_exists($blog_name)) {
		display_blog_exists($blog_name);
	} else {
		display_blog_does_not_exists($blog_name);
	}
}

function display_blog_list($blogs) {
	echo '<h2>Blogs list:</h2>';

	echo '<ul>';
	foreach ($blogs as $blog) {
		$blog_urlencode = urlencode($blog);
		echo "<li><a href=blog.php?nazwa=$blog_urlencode>$blog</a></li>";
	}
	echo '</ul>';
}

if(isset($_GET['nazwa'])){
	display_blog($_GET['nazwa']);
} else {
	$blogs = glob('*', GLOB_ONLYDIR);

	echo '<h1>Wybór bloga do wyświetlenia</h1>';
	echo '<div class="post-container">';

	display_blog_list($blogs);

	echo '</div>';
}

?>

</div>
</body>
</html>