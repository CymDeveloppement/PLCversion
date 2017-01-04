<?php
  ini_set('display_errors', true);
  ini_set('html_errors', false);
  ini_set('display_startup_errors',true);     
    ini_set('log_errors', false);
  ini_set('error_prepend_string','<span style="color: red;">');
  ini_set('error_append_string','<br /></span>');
  ini_set('ignore_repeated_errors', false);
require('func.inc/zip.func.php');

$idDecode = base64_decode($_GET['id']);

$explodeName = explode('/', $idDecode);
$downloadTarget = '../DATA/'.$idDecode;
$zipname = $explodeName[(count($explodeName)-1)].'.zip';
$zippath = 'tmp/'.$zipname;
//echo $zipname;
//exit;
HZip::zipDir($downloadTarget, $zippath);
header('Content-Type: application/zip');
header('Content-disposition: attachment; filename='.$zipname);
header('Content-Length: ' . filesize($zippath));
readfile($zippath);
