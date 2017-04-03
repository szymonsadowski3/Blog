<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Entry creation</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" xml:lang="pl" lang="pl"/>
	<meta name="Author" lang="pl" content="Szymon Sadowski"/>
	<meta name="keywords" lang="en-us" content="homework, project"/>
	<link rel="stylesheet" type="text/css" href="vertical_menu.css" title="Vertical menu"/>
	<link rel="Alternate stylesheet" type="text/css" href="horizontal_menu.css" title="Horizontal menu"/>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<link rel="stylesheet" type="text/css" href="normalize.css">
	<link rel="stylesheet" type="text/css" href="skeleton.css">
</head>
<body>
	<?php
		include 'menu.php';
		display_menu();
	?>
	<div class="container">
		<form action="wpis.php" method="post" enctype="multipart/form-data">
			<p>Nazwa użytkownika: <input type="text" name="username" class="u-full-width"/></p>
			<p>Hasło użytkownika: <input type="password" name="passwd" class="u-full-width"/></p>
			<p>Wpis: <textarea name="entry" class="u-full-width">Post tutaj...</textarea></p>
			<p>Data: <input type="date" name="date" value="<?php echo date('Y-m-d');?>" class="u-full-width"></p>
			<p>Godzina: <input type="text" name="hour" value="<?php echo date('H:i');?>" class="u-full-width"></p>
			<hr>
			<p>Plik 1-szy: <input type="file" name="image1" id="image1"></p>
			<hr>
			<p>Plik 2-gi: <input type="file" name="image2" id="image2"></p>
			<hr>
			<p>Plik 3-ci: <input type="file" name="image3" id="image3"></p>
			<hr>
			<p><input type="submit"></p>
			<input name="reset" type="reset"></input>
		</form>
	</div>
</body>
</html>
