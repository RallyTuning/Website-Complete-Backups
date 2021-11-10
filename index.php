<?php
/**
 * WCB Website Complete Backups
 * Created by https://github.com/RallyTuning
 * GNU General Public License v3.0
 */


/** Installazione */
if (!file_exists("./assets/config.php")){
    die(header("Location: ./assets/installa.php"));
}

/** File Config */
require_once('./assets/config.php');

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
        //include(PATH_INCLUSI . 'operazioni.php');
    }

    /** Risposta positiva */
    http_response_code(200);
    die();

} else {
    
    /** Accesso */
    require(PATH_ASSETS . 'accesso.php');
    
}?>
<!DOCTYPE html>
<!-- 
    WCB Website Complete Backups
    Created by https://github.com/RallyTuning
    GNU General Public License v3.0
-->
<html>
	<head>
		<?php include_once(PATH_INCLUSI . 'testata.php'); ?>
		
	</head>
	<body class="light-grey">

		<!-- Menu -->
		<?php include(PATH_INCLUSI . 'menu.php'); ?>
		
		<div class="overlay hide-large animate-opacity" onclick="menu_close()" style="cursor:pointer" title="close side menu" id="menuOverlay"></div>

		<!-- Contenitore -->
		<div class="main il_centrale" style="margin-left:300px;">
			<?php if (file_exists(PATH_ASSETS . "installa.php")){
			    Messaggio('Si consiglia di rimuovere o rinominare il file ".../assets/installa.php"','attenzione');
			}?>

			<!-- Pagina -->
			<?php
                if (isset($_GET["backups"])){
    				include(PATH_INCLUSI . 'backups.php');
    					
				}elseif (isset($_GET["operazioni"])){
					include(PATH_INCLUSI . 'operazioni.php');
					
				}elseif (isset($_GET["impostazioni"])){
				    include(PATH_INCLUSI . 'impostazioni.php');
				
				}elseif (isset($_GET["wiki"])){
					include(PATH_INCLUSI . 'wiki.php');
					
				}elseif (isset($_GET["aiuto"])){
				    include(PATH_INCLUSI . 'aiuto.php');
					
				}elseif (isset($_GET["logs"])){
				    include(PATH_INCLUSI . 'logs.php');
					
				}elseif (isset($_GET["logout"])){
                    $_SESSION['gtc-backup_session'] = false;
				    die(header("Location: " . PATH_APP));
					
				}else{
					include(PATH_INCLUSI . 'dashboard.php');
				}
			?>

		</div>

		<!-- Scripts -->
		<script type="text/javascript" src="<?php echo RES_ASSETS;?>altro/scripts.js"></script>
	</body>
</html>