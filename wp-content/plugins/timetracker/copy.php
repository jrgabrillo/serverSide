<?php
$srcfile='C:\wamp64\www\dist\New folder.zip';
$dstfile='C:\Users\New folder.zip';
mkdir(dirname($dstfile), 0777, true);
copy($srcfile, $dstfile);
?>