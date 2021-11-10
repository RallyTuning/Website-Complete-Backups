<?php
/**
 * WCB Website Complete Backups
 * Created by https://github.com/RallyTuning
 * GNU General Public License v3.0
 */


 /** Installazione */
if (!file_exists("./assets/config.php")){
    die(header("Location: ./assets/install.php"));
}

/** File Config */
require_once('./assets/functions.php');


/** API & Accesso */
if (isset($_GET["api"])){
    
    /** Token */
    if (isset($_GET["token"])){
        if(strtolower(htmlspecialchars($_GET["token"])) != hash('md5', ROOT.SITO.PASSWORD)){
            http_response_code(403);
            die();
        }
    } else {
        http_response_code(403);
        die();
    }

    /** Parametri */
    if (isset($_GET["backup"])){
        
        switch (strtolower($_GET["backup"])) {
            case 'host':
                Backup_Host();
                break;
                
            case 'database':
                Backup_Database();
                break;
                
            case 'tutto':
                Backup_Host();
                Backup_Database();
                break;
                
            default:
                http_response_code(404);
                die();
                break;
        }

    }elseif (isset($_GET["pulizia"])){
        
        switch (strtolower($_GET["pulizia"])) {
            case 'si':
                Pulizia_Backups(BACKUP_OUT, PULIZIA);
                break;
                
            default:
                http_response_code(404);
                die();
                break;
        }

    //}elseif (isset($_GET["report"])){
        //include(PATH_INCLUDED . 'operations.php');
    }

    /** Risposta positiva */
    http_response_code(200);
    die();

} else {
    
    /** Accesso */
    require(PATH_ASSETS . 'login.php');
    
}?>
<!DOCTYPE html>
<!-- 
    WCB Website Complete Backups
    Created by https://github.com/RallyTuning
    GNU General Public License v3.0
-->
<html>
	<head>
		<?php include_once(PATH_INCLUDED . 'header.php'); ?>
		
	</head>
	<body class="light-grey">

		<!-- Menu -->
		<?php include(PATH_INCLUDED . 'menu.php'); ?>
		
		<div class="overlay hide-large animate-opacity" onclick="menu_close()" style="cursor:pointer" title="close side menu" id="menuOverlay"></div>

		<!-- Contenitore -->
		<div class="main il_centrale" style="margin-left:300px;">
			<?php if (file_exists(PATH_ASSETS . "install.php")){
			    Messaggio('Si consiglia di rimuovere o rinominare il file ".../assets/install.php"','attenzione');
			}?>

			<!-- Pagina -->
			<?php
                if (isset($_GET["backups"])){
    				include(PATH_INCLUDED . 'backups.php');
    					
				}elseif (isset($_GET["operations"])){
					include(PATH_INCLUDED . 'operations.php');
					
				}elseif (isset($_GET["settings"])){
				    include(PATH_INCLUDED . 'settings.php');
				
				}elseif (isset($_GET["wiki"])){
					include(PATH_INCLUDED . 'wiki.php');
					
				}elseif (isset($_GET["about"])){
				    include(PATH_INCLUDED . 'about.php');
					
				}elseif (isset($_GET["logs"])){
				    include(PATH_INCLUDED . 'logs.php');
					
				}elseif (isset($_GET["logout"])){
                    $_SESSION['gtc-backup_session'] = false;
				    die(header("Location: " . PATH_APP));
					
				}else{
					include(PATH_INCLUDED . 'dashboard.php');
				}
			?>

		</div>

		<!-- Scripts -->
		<script type="text/javascript" src="<?php echo RES_ASSETS;?>styles/scripts.js"></script>
	</body>
</html>