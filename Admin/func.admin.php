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

function getAllCustomer()
{
	$returnCustomer = [];
	$allCustomer = scandir('../DATA/');
	$a = 0;
	foreach ($allCustomer as $key => $value) {
		if ($value != '.' && $value != '..' && $value != '.htaccess') {
			$returnCustomer[$a] = $value;
			$a ++;
		}
	}
	return $returnCustomer;
}

function getAllProgrammFromCustomer($customer)
{
	$returnProgrammList = [];
	$allProgramm = scandir('../DATA/'.$customer.'/');
	$a = 0;
	foreach ($allProgramm as $key => $value) {
		if ($value != '.' && $value != '..' && $value != '.htaccess') {
			$returnProgrammList[$a] = $value;
			$a ++;
		}
	}
	return $returnProgrammList;
}

function dispProgrammList()
{
	$customer = getAllCustomer();
	foreach ($customer as $key => $value) {
		echo '<h3>'.$value.'</h3><table class="table table-striped">
  <thead>
    <tr>
      <th>Nom</th>
      <th>Derniere Version</th>
      <th>Type</th>
      <th></th>
      <th>Bug</th>
    </tr>
  </thead>
  <tbody>';

	  	$programm = getAllProgrammFromCustomer($value);
	  	if (count($programm)>0) {
	  		makeProgrammTableList($programm, $value);
	  	}

	  	echo '</tbody>
</table>';
	}
}

function makeProgrammTableList($programm, $customer)
{
	foreach ($programm as $key => $value) {
	  	
	  	$lastPLC = getLastVersion($value, $customer, 'PLC');
	  	$UID = $customer.'/'.$value.'/PLC/'.$lastPLC;
	  	
	  	if ($lastPLC != '') {
	  		$info = getInfo($UID);
	  		echo '
	  			<tr>
      				<td>'.$value.'</td>
      				<td>'.$lastPLC.' : '.$info->dateCurrent.'</td>
      				<td>Automate</td>
      				<td>'.
      					makeDownloadLink($value, $customer, $lastPLC, 'PLC', 2).
      					makeDispLink($value, $customer, $lastPLC, 'PLC', 2).
      					'</td>
      				<td>'.makeBugBadge($UID).'</td>
      			</tr>';
	  	}

	  	$lastHMI = getLastVersion($value, $customer, 'HMI');
	  	$UID = $customer.'/'.$value.'/HMI/'.$lastHMI;
	  	
	  	if ($lastHMI != '') {
	  		$info = getInfo($UID);
	  		echo '
	  			<tr>
      				<td>'.$value.'</td>
      				<td>'.$lastHMI.' : '.$info->dateCurrent.'</td>
      				<td>Afficheur</td>
      				<td>'.
      					makeDownloadLink($value, $customer, $lastHMI, 'HMI', 2).
      					makeDispLink($value, $customer, $lastPLC, 'HMI', 2).
      				'</td>
      				<td>'.makeBugBadge($UID).'</td>
      			</tr>';
	  	}

	  	$lastDOCS = getLastVersion($value, $customer, 'DOCS');
	  	$UID = $customer.'/'.$value.'/DOCS/'.$lastDOCS;
	  	
	  	if ($lastDOCS != '') {
	  		$info = getInfo($UID);
	  		echo '
	  			<tr>
      				<td>'.$value.'</td>
      				<td>'.$lastDOCS.' : '.$info->dateCurrent.'</td>
      				<td>Documents</td>
      				<td>'.
      					makeDownloadLink($value, $customer, $lastDOCS, 'DOCS', 2).
      					makeDispLink($value, $customer, $lastPLC, 'DOCS', 2).
      					'</td>
      				<td>'.makeBugBadge($UID).'</td>
      			</tr>';
	  	}
	}
}

function makeDownloadLink($id, $customer, $version, $elem, $type)
{
	$urlLink = 'download.php?id='.base64_encode($customer.'/'.$id.'/'.$elem.'/'.$id.'-V'.$version);
	
	$button = '<a class="btn btn-default" href="'.$urlLink.'"><i class="fa fa-cloud-download fa-lg"></i></a>';

	if ($type == 1) {
		$returnValue = $urlLink;
	} elseif ($type == 2) {
		$returnValue = $button;
	}
	return $returnValue;
}

function makeDispLink($id, $customer, $version, $elem, $type)
{
	$urlLink = 'dispAllVersion(\''.base64_encode($customer.'/'.$id.'/'.$elem.'/'.$id.'-V'.$version.'.data').'\');';
	
	$button = '<a class="btn btn-default" href="#" onclick="'.$urlLink.'"><i class="fa fa-list fa-lg"></i></a>';

	if ($type == 1) {
		$returnValue = $urlLink;
	} elseif ($type == 2) {
		$returnValue = $button;
	}
	return $returnValue;
}

function makeBugBadge($UID)
{
	$badge = '';
	$data = explode("/", $UID);
	$bugFile = '../DATA/'.$data[0].'/'.$data[1].'/TICKET/'.$data[2].'-'.$data[3].'.json';
	if (is_file($bugFile)) {
		$bugJson = file_get_contents($bugFile);
		$allBug = json_decode($bugJson);
		$bugCount = 0;
		$errorBug = 0;
		foreach ($allBug as $key => $value) {
			if ($value->state == 0) {
				$errorBug ++;
			}
			$bugCount ++;
		}

		if ($errorBug == 0) {
			$badge = '<button type="button" onclick="dispAllBug(\''.$UID.'\');" class="btn btn-success btn-sm">'.$bugCount.'</button>';
		} else {
			$badge = '<button type="button" onclick="dispAllBug(\''.$UID.'\');" class="btn btn-danger btn-sm">'.$bugCount.'</button>';
		}
		
	} else {
		$badge = '<button type="button" onclick="dispAllBug(\''.$UID.'\');" class="btn btn-primary btn-sm">0</button>';
	}
	
	//echo $bugFile;
	return $badge;
}

function getLastVersion($id, $customer, $elem)
{
	$returnLast = '';
	$versionSort = array();
	$versionComplete = array();
	$allVersion = scandir('../DATA/'.$customer.'/'.$id.'/'.$elem);
	foreach ($allVersion as $key => $value) {
		if ($value != '.' && $value != '..') {
			$explodeValue = explode('-V', $value);
			//$withoutEnd = strrpos($explodeValue[1] , '.');
			$versionSort[] = str_replace(".", "", str_replace("B", "", $explodeValue[1]));
			//$versionComplete[] = $explodeValue[1];
			$versionComplete[] = $explodeValue[1];
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
			$returnLast =  $versionComplete[$key];
		}

	return $returnLast;
}

function getLastStableVersion($id, $customer, $elem)
{
	$returnLast = '';
	$versionSort = array();
	$versionComplete = array();
	$allVersion = scandir('../DATA/'.$customer.'/'.$id.'/'.$elem);
	foreach ($allVersion as $key => $value) {
		if ($value != '.' && $value != '..' && substr($value, -1) == 'F' ) {
			$explodeValue = explode('-V', $value);
			//$withoutEnd = strrpos($explodeValue[1] , '.');
			$versionSort[] = str_replace(".", "", str_replace("B", "", $explodeValue[1]));
			//$versionComplete[] = $explodeValue[1];
			$versionComplete[] = $explodeValue[1];
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
			$returnLast =  $versionComplete[$key];
		} else {
			$returnLast = 'aucune';
		}

	return $returnLast;
}

function getAllBug($path)
{
	$data = explode("/", $path);
	$fileBugs = '../DATA/'.$data[0].'/'.$data[1].'/TICKET/'.$data[2].'-'.$data[3].'.json';

	if (is_file($fileBugs)) {
		$allBugs = json_decode(file_get_contents($fileBugs));
		foreach ($allBugs as $key => $value) {
			if ($value->state == 0) {
				$alertType = 'danger';
				$statut = 'Non résolu';
			} else {
				$alertType = 'success';
				$statut = 'Résolu';
			}
			echo '
					<div class="alert alert-'.$alertType.'" role="alert">
	  					<strong><i class="fa fa-user-circle fa-lg"></i> : '.$value->creator.' - '.$value->date.' - <i>'.$statut.'</i></strong><br>'.$value->text.'
					</div>';
		}
	} else {
		echo '<b>Actuellement aucun Bug sur cette version</b><br>';
	}
	
	echo '<div class="row">
			  <div class="col-lg-12">
			    <div class="input-group" id="groupAddBug">
			      <input type="text" class="form-control" id="bugTextInput" placeholder="Ajouter un bug">
			      <span class="input-group-btn">
			        <button class="btn btn-secondary" type="button" onclick="addbug(\''.$_POST['UIDP'].'\');">Ajouter un Bug</button>
			      </span>
			    </div>
			  </div>
			</div>';
}

function getAllPreviousBug($path)
{
	$bugstr = '';
	$part = explode("|", $path);
	$allBugs = scandir('../DATA/'.$part[0]);
	$allJsonDetBugs = [];
	$a = 0;
	foreach ($allBugs as $key => $value) {
		if ($value != '.' && $value != '..' && $value != '.htaccess' && substr($value, 0, strlen($part[1])) == $part[1]) {
			$allJsonDetBugs[$value] = json_decode(file_get_contents('../DATA/'.$part[0].$value), true);
			foreach ($allJsonDetBugs[$value] as $bugNumber => $BugDet) {
				if ($BugDet['state'] == 0) {
					$a++;
					$version = substr(explode($part[1], explode(".json", $value)[0])[1], 1);
					$button = '<a href="#" onclick="resolvbug(\''.$part[0].$value.'|'.$bugNumber.'\', '.$a.');" class="btn btn-primary" id="resolvbugbutton-'.$a.'">Ce bug est résolu</a>';
					$bugstr .= '<tr>
                                  <th scope="row">'.$version.'</th>
                                  <td>'.$BugDet['creator'].'</td>
                                  <td>'.$BugDet['text'].'</td>
                                  <td>'.$button.'</td>
                                </tr>';
				}
			}
		}
	}
	
	echo '                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>Auteur</th>
                                  <th>Bug</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                              '.$bugstr.'
                              </tbody>
                            </table>';
	//var_dump($allJsonDetBugs);
}

function getInfo($UID)
{
	$data = explode("/", $UID);
	$infoFile = '../DATA/'.$data[0].'/'.$data[1].'/'.$data[2].'/'.$data[1].'-V'.$data[3].'/.plcversion';
	$info = [];
	if (is_file($infoFile)) {
		$info = json_decode(file_get_contents($infoFile));
	}
	//var_dump($info);
	return $info;
}

function dispAllVersion($programm, $id)
{
		echo '<table class="table table-striped">
  <thead>
    <tr>
      <th>Version</th>
      <th>Type</th>
      <th></th>
      <th>Bug</th>
    </tr>
  </thead>
  <tbody>';

  		foreach ($programm as $key => $value) {
  			//echo $value;
  			makeVersionTableList($value);
  		}

	  	echo '</tbody>
</table>';
	
}


function makeVersionTableList($programm)
{

	  	$data = explode("/", $programm);
	  	
	  	$version = str_replace(".data", "", $data[3]);
	  	$version = str_replace($data[1]."-V", "", $version);
	  	$UID = $data[0].'/'.$data[1].'/'.$data[2].'/'.$version;

	  	$state = substr($version, -1);
	  	if ($data[2] == 'PLC') {
	  		$type = 'Automate';
	  	} elseif ($data[2] == 'HMI') {
	  		$type = 'Afficheur';
	  	} elseif ($data[2] == 'DOCS') {
	  		$type = 'Documents';
	  	}

	  	if ($state == 'A') {
	  		$colorTr = 'danger';
	  	} elseif ($state == 'B') {
	  		$colorTr = 'warning';
	  	} elseif ($state == 'F') {
	  		$colorTr = 'info';
	  	}
	  		$info = getInfo($UID);
	  		echo '
	  			<tr class="table-'.$colorTr.'">
      				<td>'.$version.' : '.$info->dateCurrent.'</td>
      				<td>'.$type.'</td>
      				<td>'.
      					makeDownloadLink($data[1], $data[0], $version, $data[2], 2).
      					'</td>
      				<td>'.makeBugBadge($UID).'</td>
      			</tr>';

}

function bugsSetResolv($UID)
{
	$part = explode("|", $UID);
	$bugDet = json_decode(file_get_contents('../DATA/'.$part[0]), true);
	$bugDet[$part[1]]['state'] = 1;
	file_put_contents('../DATA/'.$part[0], json_encode($bugDet));
	return "Résolution du bug : ".$bugDet[$part[1]]['text'];
}

function generateChangelog($prev, $stable, $new)
{
	global $user;
	
	if ($_POST['INIT'] == 1) {
		$project['Creator'] = $user->SurName . ' ' . $user->Name;
		$project['Contributor'] = $user->SurName . ' ' . $user->Name;
		$project['Create'] = date('d/m/y');
		$project['dateCurrent'] = date('d/m/y');
		$project['Description'] = $_POST['DESCRIPTION'];
		$fileplc = '../DATA/'.$_POST['UIDV'].'/.plcversion';
		file_put_contents($fileplc, json_encode($project));
	} else {
		$filePrev = '../DATA/'.$prev.'/.plcversion';
		$projectFile = file_get_contents($filePrev);
		$project = json_decode($projectFile, true);
		$project['dateCurrent'] = date('d/m/y');
		$project['description'] = $_POST['DESCRIPTION'];
		$allContrib = explode(",", $project['Contributor']);
		$contribIgnore = 0;
		foreach ($allContrib as $key => $value) {
			echo $value;
			if ($value == (' '.$user->SurName . ' ' . $user->Name)) {
				$contribIgnore = 1;
			}
		}

		if ($contribIgnore == 0) {
			$project['Contributor'] = $project['Contributor'] . ', ' . $user->SurName . ' ' . $user->Name;
		}
		$fileplc = '../DATA/'.$_POST['UIDV'].'/.plcversion';
		file_put_contents($fileplc, json_encode($project));
	}

	$currentV = explode('-V', $new);
	echo $_POST['NEWNAME'];
	$bugsList = "";
	if (is_array($_POST['BUGS']) && count($_POST['BUGS'])>0) {
		foreach ($_POST['BUGS'] as $key => $value) {
			$bugsList .= bugsSetResolv($value)."\n";
		}
	}
	

	$entete = "*   ".str_pad("Nom du projet : ".$currentV[0], 85, " ")."*\n";
	$entete .= "*   ".str_pad("Createur : ".$project['Creator'], 85, " ")."*\n";
	$entete .= "*   ".str_pad("Contributeur : ".$project['Contributor'], 85, " ")."*\n";
	$entete .= "*   ".str_pad("Date de création : ".$project['Create'], 86, " ")."*\n";
	$entete .= "*   ".str_pad("Derniére version stable : ".$stable, 86, " ")."*\n";
	$entete .= "*   ".str_pad("Derniére version : ".$currentV[1].' '.date('d/m/y'), 86, " ")."*";

	$changelogFileGet = file_get_contents("changelog.template");
	$changelogFileGet = str_replace("{PROJECTDATA}", $entete, $changelogFileGet);
	$changelogFileGet = str_replace("{NEWFEATURELIST}", $_POST['DESCRIPTION'], $changelogFileGet);
	$changelogFileGet = str_replace("{BUGLIST}", $bugsList, $changelogFileGet);

	file_put_contents('../DATA/'.$_POST['UIDV'].'/changelog', $changelogFileGet);


	
}

$user = getAdminUserInfo('ychallet');