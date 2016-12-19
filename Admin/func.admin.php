<?php


function getAdminUserInfo($id)
{
	$returnValue = 'Cette Utilisateur n\'existe pas';
	$content = file_get_contents('user-data/users.json');
	$users = json_decode($content);
	foreach ($users as $key => $value) {
		if ($value->ID == $id) {
			$returnValue = $users->$key;
		}
	}
	return $returnValue;
}

function getLastVersion($id, $customer, $elem)
{
	$versionSort = array();
	$versionComplete = array();
	$allVersion = scandir('../DATA/'.$customer.'/'.$id.'/'.$elem);
	foreach ($allVersion as $key => $value) {
		if ($value != '.' && $value != '..') {
			$explodeValue = explode('-V', $value);
			$withoutEnd = strrpos($explodeValue[1] , '.');
			$versionSort[] = str_replace(".", "", str_replace("B", "", substr($explodeValue[1], 0, $withoutEnd)));
			$versionComplete[] = substr($explodeValue[1], 0, $withoutEnd);
		}

	}
	if (count($versionSort)>0) {
			$maxversion = 0;
			$maxversionKey = 0;
			foreach ($versionSort as $key => $value) {
				if (intval($value)>$maxversion) {
					$maxversion = intval($value);
					$maxversionKey = $key;
				}
			}
			echo $versionComplete[$key];
		}
	//var_dump($versionSort);
}