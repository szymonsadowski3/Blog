<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Comment creation</title>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8" xml:lang="pl" lang="pl"/>
	<meta name="Author" lang="pl" content="Szymon Sadowski"/>
	<meta name="keywords" lang="en-us" content="homework, project"/>
	<link rel="stylesheet" type="text/css" href="vertical_menu.css" title="Vertical menu"/>
	<link rel="Alternate stylesheet" type="text/css" href="horizontal_menu.css" title="Horizontal menu"/>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<link rel="stylesheet" type="text/css" href="normalize.css">
	<link rel="stylesheet" type="text/css" href="skeleton.css">
</head>
<body>
	<?php
		include 'menu.php';
		display_menu();
	?>
	<div class="container">
		<form action="koment.php" method="post">
			<p>Rodzaj komentarza: 
				<select name="comment_opinion" class="u-full-width">
					<option value="positive">Pozytywny</option>
					<option value="negative">Negatywny</option>
					<option value="neutral">Neutralny</option>
				</select>
			</p>
			<p>Nazwa użytkownika: <input type="text" name="username" class="u-full-width"/></p>
			<p>Komentarz: <textarea name="comment" class="u-full-width">Komentarz tutaj...</textarea></p>
			<p><input type="submit" /></p>
			<input name="reset" type="reset"></input>
		</form>
	</div>
</body>
</html>
