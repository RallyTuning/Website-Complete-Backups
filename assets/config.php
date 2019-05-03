<?php
/**
 * GTC Backup
 * Creato da Network GTC
 * www.networkgtc.it
 * Gianluigi Capozzoli
 */


//===========================================
//		IMPOSTAZIONI E PARAMETRI APP
//===========================================
define('APP', 'GTC Backup');
define('SITO', 'http://localhost');
define('ROOT', 'gtc-backup');
define('PULIZIA', '7');
define('PASSWORD', 'test123');
define('COMMENTO', 'Backup del '.date("d/m/Y @ H:i:s"));
define('SPAZIO', '10737418240');
define('LOGS', 'true');
define('BACKUP_DI', '');
define('SALVA_IN', 'backups');
define('IGNORA', array('sito_restore','wordpress'));
define('ZIP_HOST', 'backup_'.date("d-m-y").'_'.date("His").'.zip');
define('ZIP_DB', 'backup_'.date("d-m-y").'_'.date("His").'.sql');
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'cao');

//===========================================
//		NON MODIFICARE SOTTO QUESTA LINEA
//===========================================
define('PATH_BASE', $_SERVER['DOCUMENT_ROOT']);
define('PATH_APP', PATH_BASE . '/'.ROOT.'/');
define('PATH_ASSETS', PATH_APP . 'assets/');
define('PATH_INCLUSI', PATH_ASSETS . 'inclusi/');
define('BACKUP_IN', $_SERVER['DOCUMENT_ROOT'].'/'.BACKUP_DI);
define('BACKUP_OUT', PATH_APP .SALVA_IN);
define('PATH_LOGS', PATH_APP .'logs/');
define('RES_ASSETS', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']. '/'.ROOT.'/assets/');

require_once(PATH_ASSETS . 'funzioni.php'); // A prescindere
Check_Sito(SITO);
Proteggi_Pagina(basename($_SERVER['PHP_SELF']),'config.php');
?>