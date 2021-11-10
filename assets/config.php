<?php
/**
 * WCB Website Complete Backups
 * Created by https://github.com/RallyTuning
 * GNU General Public License v3.0
 */


//===========================================
//		IMPOSTAZIONI E PARAMETRI APP
//===========================================
define('SITO', 'http://localhost');
define('ROOT', '');
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
define('language', 'it-IT');

//===========================================
//		NON MODIFICARE SOTTO QUESTA LINEA
//===========================================
define('PATH_BASE', __DIR__ . '/../');
define('PATH_APP', PATH_BASE);
define('PATH_ASSETS', PATH_APP . 'assets/');
define('path_languages', PATH_ASSETS . 'i18n/');
define('selected_lang', path_languages . language . '.php');
define('PATH_INCLUDED', PATH_ASSETS . 'included/');
define('BACKUP_IN', PATH_BASE . BACKUP_DI);
define('BACKUP_OUT', PATH_APP . SALVA_IN);
define('PATH_LOGS', PATH_APP . 'logs/');
define('RES_ASSETS', './assets/');

Proteggi_Pagina(basename($_SERVER['PHP_SELF']),'config.php');
?>