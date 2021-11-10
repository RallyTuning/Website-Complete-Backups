<?php
/**
 * WCB Website Complete Backups
 * Created by https://github.com/RallyTuning
 * GNU General Public License v3.0
 */


require_once 'config.php';

session_start();

if (!isset($_SESSION['gtc-backup_session'])){
	$_SESSION['gtc-backup_session'] = false;
}

if (!$_SESSION['gtc-backup_session']): ?>

<html>
	<head>
		<?php include_once(PATH_INCLUSI . 'testata.php'); ?>
		
	</head>
	<body class="login-body">
		<div class="login-page">
			<form class="login-form" method="post">
                
                <div class="login-logo"><img src="<?php echo RES_ASSETS; ?>immagini/safe-icon.png" alt="Logo"><span class="login-logotxt"><?php echo APP; ?></span></div>
                <?php
					if (isset($_POST['password'])){
						if (sha1($_POST['password']) == sha1(PASSWORD)):
                            $_SESSION['gtc-backup_session'] = true;
                            Scrivi_log('Info', 'Accesso effettuato. IP: '.$_SERVER['REMOTE_ADDR']);
                            die(header("Location: " . "?dashboard"));
						else:
						Scrivi_log('Attenzione', 'Tentativo di accesso fallito. Passowrd: "'.$_POST['password'].'" IP: '.$_SERVER['REMOTE_ADDR']);
                    Messaggio('Accesso negato!','errore');
				endif;} ?>
                <input type="password" name="password" title="password" placeholder="Password" />
                <button>Login</button>
				<a class="login-forgot" href="#">Password dimenticata?</a>
			</form>
        </div>
	</body>
</html>
<?php
	exit();
else:
    if (isset($_GET['logout'])){
		$_SESSION['gtc-backup_session'] = false;
		Scrivi_log('Info', 'Disconnessione eseguita. IP: '.$_SERVER['REMOTE_ADDR']);
		die(header("Location: " . PATH_ASSETS . "accesso.php"));
	}
endif;
?>