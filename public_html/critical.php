<?php

function make_dir_without_race($filepath) {
// is_dir is more appropriate than file_exists here
	if (!is_dir($filepath)) {
		if (true !== @mkdir($filepath, 0777, TRUE)) {
			if (is_dir($filepath)) {
            // The directory was created by a concurrent process, so do nothing, keep calm and carry on
			} else {
            // There is another problem, we manage it (you could manage it with exceptions as well)
				$error = error_get_last();
				trigger_error($error['message'], E_USER_WARNING);
			}
		} else {
			echo 'Folder succesfully created! <br>';
			echo '<a href="javascript:history.back()" class="button button-primary">Go Back</a>';
		}
	} else {
		echo "The directory $filepath already exists <br>";
		echo '<a href="javascript:history.back()" class="button button-primary">Go Back</a>';
	}
}

function write_to_file_locking($out_path, $content) {
	$file = fopen($out_path,'w+');

	// exclusive lock
	if (flock($file,LOCK_EX))
	{
		fwrite($file,$content);
  		// release lock
		flock($file,LOCK_UN);
	} else {
		echo 'Error locking file!<br>';
	}

	fclose($file);
}

?>