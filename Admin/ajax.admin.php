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

if (isset($_POST['GETBUGS'])) {
	getAllBug($_POST['UIDP']);	
}

if (isset($_POST['ADDBUG'])) {
	global $user;
	$data = explode("/", $_POST['UIDP']);
	$fileBugs = '../DATA/'.$data[0].'/'.$data[1].'/TICKET/'.$data[2].'-'.$data[3].'.json';

	$bugObject['creator'] = $user->ID;
	$bugObject['state'] = 0;
	$bugObject['text'] = $_POST['BUG'];
	$bugObject['date'] = date('d/m/y');

	if (is_file($fileBugs)) {
		$allBugs = json_decode(file_get_contents($fileBugs), true);
		array_push ($allBugs , $bugObject);
		file_put_contents($fileBugs, json_encode($allBugs));
	} else {
		$allBugs[0] = $bugObject;
		file_put_contents($fileBugs, json_encode($allBugs));
	}
	
	
	
	getAllBug($_POST['UIDP']);
}

if (isset($_POST['GETALLVERSION'])) {
	$UID = base64_decode($_POST['UIDP']);
	
	$data = explode("/", $UID);
	$folder = '../DATA/'.$data[0].'/'.$data[1].'/'.$data[2];

	//echo $folder;
	//exit;
	$programm = [];

	$allVersion = scandir($folder, SCANDIR_SORT_DESCENDING);
	if (count($allVersion)>0) {
		foreach ($allVersion as $key => $value) {
			if ($value != '.' && $value != '..') {
				$programm[] = $data[0].'/'.$data[1].'/'.$data[2].'/'.$value;
				
				
			}
		}
		$id = $data[1];
		dispAllVersion($programm, $id);
	}

}

if (isset($_POST['SAVE'])) {
	$data = explode("/", $_POST['UIDV']);

	if (!$_POST['INIT']) {
		$prev = $data[0].'/'.$data[1].'/'.$data[2].'/'.getLastVersion($data[1], $data[0], $data[2]);
	} else {
		$prev = "";
	}
	$stable = getLastStableVersion($data[1], $data[0], $data[2]);
	$foldername = '../DATA/'.$_POST['UIDV'];
	mkdir ($foldername);
	$end = substr($_POST['SOURCE'], strrpos($_POST['SOURCE'] , "."));
	copy('files/'.$_POST['SOURCE'], $foldername.'/'.$_POST['NEWNAME'].$end);
	generateChangelog($prev, $stable, $_POST['NEWNAME']);
}

if (isset($_POST['REFRESHPROGRAMMLIST'])) {
	dispProgrammList();
}



