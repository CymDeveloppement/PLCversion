<?php        
header('WWW-Authenticate: Basic realm="Connection Obligatoire"');
header('HTTP/1.0 401 Unauthorized');
echo 'Texte affiche en cas d\'annulation';
exit();
?>