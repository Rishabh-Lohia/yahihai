<?php

$directory= 'Movies';
if($handle=opendir($directory.'/')){
	echo 'Files shared here.<br>';
	
	while ($file = readdir($handle)){
		if($file!='.' && $file!='..'){
			echo '<a class="icon file" draggable="true" href="/'.$directory.'/'.$file.'">'.$file.'</a><br>';
		}	
	}
}