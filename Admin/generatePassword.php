<?php

function newPassword($nb, $type)
{

	$password = '';
	// Récupère les paramètres pour adapter selon les besoins de l'utilisateur
	$SaisieNbrCaract    = $nb;
	$SaisieTypePasswd     = $type;

	// Type de caractères à prendre en compte pour générer les mots de passe (change selon paramètre utilisateur) :
	if ($SaisieTypePasswd == '1')
	{
		$caract = "0123456789";
	}
	else if ($SaisieTypePasswd == '2')
	{
		$caract = "abcdefghijklmnopqrstuvwyxz";
	}
	else if ($SaisieTypePasswd == '3')
	{
		$caract = "abcdefghijklmnopqrstuvwyxzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	}
	else if ($SaisieTypePasswd == '4')
	{
		$caract = "abcdefghijklmnopqrstuvwyxz0123456789@!:;,§/?*µ$=+";
	}

	// Nombre de caractères que le mot de passe doit contenir (= saisie utilisateur) :
	$nb_caract = $SaisieNbrCaract;

	// On fait un première boucle pour générer des mots de passe jusqu'au nombre indiqué par l'utilisateur
	// Puis une seconde boucle pour générer le mot de passe caractère par caractère jusqu'au nombre indiqué par l'utilisateur

		for($i = 1; $i <= $nb_caract; $i++) {

			// On compte le nombre de caractères
			$Nbr = strlen($caract);

			// On choisit un caractère au hasard dans la chaine sélectionnée :
			$Nbr = mt_rand(0,($Nbr-1));

			// Pour finir, on écrit le résultat :
			$password .= $caract[$Nbr];

		}
	return $password;
}

function cryptPassword($password)
{
	return crypt($password, 'AZOEIUQMDFLKJSHL4QKJ68SDHFMQSJMH78658745562JSMSKGJPXOISGM');
}

$htpasswd = '';
$passwordResult = '';
$users = json_decode(file_get_contents('user-data/users.json'), true);
foreach ($users as $key => $value) {
	$NEWPASSWORD = newPassword(8, 3);

	$htpasswd .= $value['ID'].':'.cryptPassword($NEWPASSWORD).'
';
	$passwordResult .= $value['ID'].':'.$NEWPASSWORD.'
';

}
echo $passwordResult;
//echo newPassword(8, 3);