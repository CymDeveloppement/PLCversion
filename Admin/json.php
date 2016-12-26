<?php

$project['Creator'] = 'Yann Challet';
$project['Contributor'] = 'Mickael Appeau';
$project['Create'] = '04/12/16';
$project['dateCurrent'] = '20/12/16';

$user[1]['Name'] = 'Challet';
$user[2]['Name'] = 'Appeau';
$user[1]['SurName'] = 'Yann';
$user[2]['SurName'] = 'Mickaël';
$user[1]['ID'] = 'ychallet';
$user[2]['ID'] = 'mappeau';
$user[1]['mail'] = 'yann@cymdev.com';
$user[2]['mail'] = 'mickael.appeau@gmail.com';


$ticket[1]['creator'] = 'yguiet';
$ticket[1]['state'] = 0;
$ticket[1]['text'] = 'Gros bug sur la page d\'accueil';

$ticket[2]['creator'] = 'ychallet';
$ticket[2]['state'] = 0;
$ticket[2]['text'] = 'Tempo grafcet non fonctionnelle';




echo json_encode($project);