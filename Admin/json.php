<?php

$project['Creator'] = 'Yann Challet';
$project['Contributor'] = 'Mickael Appeau';
$project['Create'] = '04/12/16';


$user[1]['Name'] = 'Challet';
$user[2]['Name'] = 'Appeau';
$user[1]['SurName'] = 'Yann';
$user[2]['SurName'] = 'Mickaël';
$user[1]['ID'] = 'ychallet';
$user[2]['ID'] = 'mappeau';
$user[1]['mail'] = 'yann@cymdev.com';
$user[2]['mail'] = 'mickael.appeau@gmail.com';


echo json_encode($user);