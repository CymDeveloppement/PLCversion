<?php
	ini_set('display_errors', true);
	ini_set('html_errors', false);
	ini_set('display_startup_errors',true);		  
    ini_set('log_errors', false);
	ini_set('error_prepend_string','<span style="color: red;">');
	ini_set('error_append_string','<br /></span>');
	ini_set('ignore_repeated_errors', false);

include('func.admin.php');


if (isset($_POST['ADDCUSTOMER'])) {
	echo 'MKDIR';
	$foldername = '../DATA/'.str_replace("/", "_", str_replace(".", "", str_replace(" ", "_", strtoupper($_POST['ADDCUSTOMER']))));
	mkdir ($foldername);
	//mkdir ($foldername.'/PLC');
	//mkdir ($foldername.'/TICKET');
}

if (isset($_POST['ADDFOLDER'])) {
	echo 'MKDIR';

	$foldername = '../DATA/'.$_POST['CUSTOMER'].'/'.
		str_replace("-", "_", str_replace("/", "_", str_replace(".", "", str_replace(" ", "_", strtoupper($_POST['ADDFOLDER'])))));
	mkdir ($foldername);

	mkdir ($foldername.'/PLC');
	mkdir ($foldername.'/TICKET');
	mkdir ($foldername.'/HMI');
	mkdir ($foldername.'/DOCS');

	/*
	$foldernamePLC = '../DATA/'.$_POST['CUSTOMER'].'/PLC/'.
		str_replace("-", "_", str_replace("/", "_", str_replace(".", "", str_replace(" ", "_", strtoupper($_POST['ADDFOLDER'])))));
	$foldernameTICKET = '../DATA/'.$_POST['CUSTOMER'].'/TICKET/'.
		str_replace("-", "_", str_replace("/", "_", str_replace(".", "", str_replace(" ", "_", strtoupper($_POST['ADDFOLDER'])))));
	$foldernameHMI = '../DATA/'.$_POST['CUSTOMER'].'/HMI/'.
		str_replace("-", "_", str_replace("/", "_", str_replace(".", "", str_replace(" ", "_", strtoupper($_POST['ADDFOLDER'])))));
	$foldernameDOC = '../DATA/'.$_POST['CUSTOMER'].'/DOCS/'.
		str_replace("-", "_", str_replace("/", "_", str_replace(".", "", str_replace(" ", "_", strtoupper($_POST['ADDFOLDER'])))));

	mkdir ($foldernamePLC);
	mkdir ($foldernameTICKET);
	mkdir ($foldernameHMI);
	mkdir ($foldernameDOC);

	*/
}

if (isset($_POST['LISTCUSTOMER'])) {
	$allCustomer = scandir('../DATA');
	if (count($allCustomer)>0) {
		foreach ($allCustomer as $key => $value) {
			if ($value != '.' && $value != '..') {
				echo '<a class="dropdown-item" href="#" onclick="selectCustomer(\''.$value.'\', \''.$_POST['LISTCUSTOMER'].'\');">'.$value.'</a>';
			}
		}
	}
}

if (isset($_POST['LISTFOLDER'])) {
	$allFolder = scandir('../DATA/'.$_POST['LISTFOLDER'].'/');
	if (count($allFolder)>0) {
		foreach ($allFolder as $key => $value) {
			if ($value != '.' && $value != '..') {
				echo '<a class="dropdown-item" href="#" onclick="selectFolder(\''.$value.'\');">'.$value.'</a>';
			}
		}
	}
}

if (isset($_POST['CURRENT'])) {
	echo getLastVersion($_POST['CURRENT'], $_POST['CUSTOMERV'], $_POST['ELEMENT']);
}

if (isset($_POST['GETINFO'])) {
	
}



