<?php


function getAllProgramm()
{
	global $user;
	$customer = $user['customer'];
	//echo $customer;
	$returnProgrammList = [];
	$allProgramm = scandir('../DATA/'.$customer.'/');
	$a = 0;
	//var_dump($allProgramm);
	foreach ($allProgramm as $key => $value) {
		if ($value != '.' && $value != '..') {
			$returnProgrammList[$a] = $value;
			$a ++;
		}
	}
	return $returnProgrammList;
}

function getLatestVersion($programm, $elem)
{
	global $user;
	$customer = $user['customer'];
	$latest['HMI'] = 'NONE';
	$latest['PLC'] = 'NONE';
	$latest['DOCS'] = 'NONE';
	$a = 0;
	$returnLast = '';
	$versionSort = array();
	$versionComplete = array();
	$allVersion = scandir('../DATA/'.$customer.'/'.$programm.'/'.$elem);
	foreach ($allVersion as $key => $value) {
		if ($value != '.' && $value != '..' && (substr($value, -1) != 'A')) {
			$explodeValue = explode('-V', $value);
			$versionSort[] = str_replace(".", "", str_replace("B", "", $explodeValue[1]));
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

function getVersionInfo($version)
{
	global $user;
	$customer = $user['customer'];
	$info = json_decode(file_get_contents('../DATA/'.$customer.'/'.$version.'/.plcversion'), true);
	return $info;
}

function dispProgrammBadge()
{
	global $user;
	$customer = $user['customer'];
	$allProgramm = getAllProgramm();
	if (count($allProgramm)>0) {
		foreach ($allProgramm as $key => $value) {

			$current = getLatestVersion($value, 'PLC');
			if ($current != '') {
				$info = getVersionInfo($value.'/PLC/'.$value.'-V'.$current);
				$UID = $customer.'/'.$value.'/PLC/'.$current;
				$urlLink = 'download.php?id='.base64_encode($customer.'/'.$value.'/PLC/'.$value.'-V'.$current);
				$button = '<a class="btn btn-outline-primary" href="'.$urlLink.'"><i class="fa fa-cloud-download fa-lg"></i></a>';
				$buttonInfo = '<a class="btn btn-outline-primary" href="#" style="margin-left:4px;" onclick="dispchangelog(\''.$UID.'\')"><i class="fa fa-info-circle fa-lg"></i></a>';
				echo '<div class="card">
              <div class="card-block">
                <h4 class="card-title">'.$value.'/Automate</h4>
                <p class="card-text">'.$current.' : '.$info['description'].'<br>
                Date : '.$info['dateCurrent'].' Contributeur : <b>'.$info['Contributor'].'</b></p>
                '.$button.'
                <a href="#" class="btn btn-primary" onclick="dispAllBug(\''.$UID.'\');">Bug & Corrections</a>'.$buttonInfo.'
              </div>
            </div>';
			}



		}
	}
	return 1;
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
			  <div class="row">
			  <div class="col-md-2"></div>
			  <div class="col-md-8"><input type="text" class="form-control col-md-6" id="bugTextInput" placeholder="Ajouter un bug"></div>
			  </div>
			  <div class="row">
			  <div class="col-md-2"></div>
			  <div class="col-md-8"><button style="margin-top:10px;" class="btn btn-outline-primary btn-block" type="button" onclick="addbug(\''.$_POST['UIDP'].'\');">Ajouter un Bug</button>
				</div>
			  </div>
			    <div class="input-group row" id="groupAddBug">
			      
			      <span class="input-group-btn col-md-6">
			        			      </span>
			    </div>
			  </div>
			</div>';
}

function dispChangelog($UID)
{
	$data = explode("/", $UID);
	$filechangelog = '../DATA/'.$data[0].'/'.$data[1].'/'.$data[2].'/'.$data[1].'-V'.$data[3].'/changelog';
	if (is_file($filechangelog)) {
		$changelog = file_get_contents($filechangelog);
		$changelog = htmlentities($changelog);
		$changelog = str_replace(" ", "&nbsp;", $changelog);
		$changelog = str_replace("\n", "<br>", $changelog);

		echo '<pre class="terminalStyle"><code>'.$changelog.'</code></pre>';
	}
}