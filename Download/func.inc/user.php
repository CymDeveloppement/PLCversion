<?php

function getPasswordFile()
{
	return realpath(NULL).'/user-data/.htpasswd';
}

function cryptPassword($password)
{
	return crypt($password, 'FDLQSKHFZEPOJD109CEQ67ZEPI3456XUFJSMSKGJPXOISGM');
}

function newUserPassword($user)
{

}

function getUserInfo($var)
{
	$username = null;
	$password = null;

	if (isset($var['PHP_AUTH_USER'])) {
	    $username = $var['PHP_AUTH_USER'];
	} elseif (isset($var['HTTP_AUTHORIZATION'])) {

	        if (strpos(strtolower($var['HTTP_AUTHORIZATION']),'basic')===0)
	          list($username,$password) = explode(':',base64_decode(substr($var['HTTP_AUTHORIZATION'], 6)));
	}

	$user = [];
	$userFile = json_decode(file_get_contents('user-data/users.json'), true);
	foreach ($userFile as $key => $value) {
		if ($value['ID'] == $username) {
			$user = $value;
		}
	}
	return $user;
}


$htpasswordPath = getPasswordFile();

$user = getUserInfo($_SERVER);

//echo 'yguiet:'.cryptPassword('test');


