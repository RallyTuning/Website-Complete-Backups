<?php
/**
 * WCB Website Complete Backups
 * Created by https://github.com/RallyTuning
 * GNU General Public License v3.0
 */


//===========================================
//		IMPOSTAZIONI E PARAMETRI APP
//===========================================
define('APP', 'Disactive Backups');
define('SITO', 'http://localhost');
define('ROOT', 'Plugin Backup');
define('PULIZIA', '7');
define('PASSWORD', '12345');
define('COMMENTO', 'Backup del giorno '.date("d-m-y").' alle ore '.date("His").'');
define('SPAZIO', '0');
define('LOGS', 'true');
define('BACKUP_DI', '');
define('SALVA_IN', 'backups');
define('IGNORA', array(''));
define('ZIP_HOST', 'backup_'.date("d-m-y").'_'.date("His").'.zip');
define('ZIP_DB', 'backup_'.date("d-m-y").'_'.date("His").'.sql');
define('DB_HOST', '');
define('DB_USER', '');
define('DB_PASS', '');
define('DB_NAME', '');

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
Proteggi_Pagina(basename($_SERVER['PHP_SELF']),'config.php');
?>