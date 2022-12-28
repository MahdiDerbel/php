<?php
//phpinfo();

session_set_cookie_params (7200);
ini_set('session.gc_maxlifetime', 900);
ini_set("session.use_only_cookies", true);
session_start();


ini_set('display_errors', 0);
// Enregistrer les erreurs dans un fichier de log
ini_set('log_errors', 1);
// Nom du fichier qui enregistre les logs (attention aux droits à l'écriture)
ini_set('error_log', dirname(__file__) . '/log_error_php.txt');


define('WEMDEV_PHP_VERSION', '5.3.10');
if (version_compare(PHP_VERSION, WEMDEV_PHP_VERSION, '<'))
{
	die('Your host needs to use PHP ' . WEMDEV_PHP_VERSION . ' or higher to run !');
}
//date_default_timezone_set ('Africa/Tunis');
define('_WEMDEV', 1);

define('JPATH_BASE', __DIR__);
if (file_exists(__DIR__ . '/inc/defines.php'))
{
	include_once __DIR__ . '/inc/defines.php';
}
require_once JPATH_CORE . '/lang.php';
require_once JPATH_CORE . '/config.php';
require_once JPATH_CORE . '/bd.php';
require_once JPATH_CORE . '/table.php';
/**  tous les table**/
$directory = JPATH_TABLE;
if( is_dir($directory) ){ 
	$dossier = opendir($directory);
	while($fichier = readdir($dossier)){
		if(is_file($directory.'/'.$fichier) && $fichier !='/' && $fichier !='.' && $fichier != '..' && strtolower(substr($fichier,-4))==".php"){
			require_once($directory.'/'.$fichier);
		}
	}
	closedir($dossier);
}
	/** en include table**/
require_once JPATH_CORE . '/session.php';
require_once JPATH_BASE . '/inc/router.php';
require_once JPATH_VIEWS . '/view.php';

$app = new Router();
$app->display();