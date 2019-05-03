<?php
/**
 * GTC Backup
 * Creato da Network GTC
 * www.networkgtc.it
 * Gianluigi Capozzoli
 */


// Tutto bello ordinato come piace a me
$imp = array();
$doc = '';

$pre = '<?php
/**
 * GTC Backup
 * Creato da Network GTC
 * www.networkgtc.it
 * Gianluigi Capozzoli
 */


//===========================================
//		IMPOSTAZIONI E PARAMETRI APP
//===========================================
';

$pos = "
//===========================================
//		NON MODIFICARE SOTTO QUESTA LINEA
//===========================================
define('PATH_BASE', ".'$_SERVER'."['DOCUMENT_ROOT']);
define('PATH_APP', PATH_BASE . '/'.ROOT.'/');
define('PATH_ASSETS', PATH_APP . 'assets/');
define('PATH_INCLUSI', PATH_ASSETS . 'inclusi/');
define('BACKUP_IN', ".'$_SERVER'."['DOCUMENT_ROOT'].'/'.BACKUP_DI);
define('BACKUP_OUT', PATH_APP .SALVA_IN);
define('PATH_LOGS', PATH_APP .'logs/');
define('RES_ASSETS', ".'$_SERVER'."['REQUEST_SCHEME'].'://'.".'$_SERVER'."['HTTP_HOST']. '/'.ROOT.'/assets/');

require_once(PATH_ASSETS . 'funzioni.php'); // A prescindere
Proteggi_Pagina(basename(".'$_SERVER'."['PHP_SELF']),'config.php');
?>"; // Occhio qua alla scritta $_SERVER

function Converti_Parametri($str){
    $str = str_replace("%acapo%", "\\n", $str);
    $str = str_replace("%data%", "'.date(\"d-m-y\").'", $str);
    $str = str_replace("%ora%", "'.date(\"His\").'", $str);
    $str = str_replace("%datacompleta%", "'.date(\"d/m/Y @H:i:s\").'", $str);
    
    return $str;
}

$_sito = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'];
$_cartella_bak = basename(__DIR__);

if (count($_POST) > 0) {

    $doc = $pre;
    
    foreach($_POST as $x => $x_value) {
        
        switch (strtoupper($x)){
            case 'IGNORA':
                
                $x_value = str_replace("; ", ";", $x_value);
                $x_value_clear = str_replace(";", "','", $x_value);
                $doc .= "define('" . strtoupper($x) . "', array('".$x_value_clear."'));\n";
                break;
                
            case 'ZIP_HOST':
            case 'ZIP_DB':
            case 'COMMENTO':

                $doc .= "define('" . strtoupper($x) . "', '".Converti_Parametri($x_value)."');\n";
                break;
                
            case 'SITO':
                
                $doc .= "define('" . strtoupper($x) . "', '".rtrim($x_value, '/')."');\n";
                break;
                
            default:
                
                $doc .= "define('" . strtoupper($x) . "', '".$x_value."');\n";
                break;
        }
    }
    
    $doc .= $pos;
    
    $cf = fopen('config.php', 'w');
    fwrite($cf, $doc);
    fclose($cf);
    
    die(header("Location: ../"));
}
?>
<!DOCTYPE html>
<html>
    <head>
    	<title>Installazione</title>
    	<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/png" href="immagini/favicon.png"/>
        <style>
            * {
                box-sizing: border-box;
            }
            
            h2, h4 {
                text-align: center;
            }
            
            .titolo {
                color: white;
                background-color: green;
            }
            
            input[type=text], input[type=number], select, textarea {
                width: 100%;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 4px;
                resize: vertical;
            }
            
            label {
                padding: 12px 12px 12px 0;
                display: inline-block;
            }
            
            input[type=submit] {
                background-color: #4CAF50;
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                float: right;
            }
            
            input[type=submit]:hover {
                background-color: #45a049;
            }
            
            .container {
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 20px;
            }
            
            .col-25 {
                float: left;
                width: 25%;
                margin-top: 6px;
            }
            
            .col-75 {
                float: left;
                width: 75%;
                margin-top: 6px;
            }
            
            .row:after {
                content: "";
                display: table;
                clear: both;
            }
            
            @media screen and (max-width: 600px) {
                .col-25, .col-75, input[type=submit] {
                    width: 100%;
                    margin-top: 0;
                }
                
                .row {
                    margin-bottom: 15px;
                }
            }
        </style>
	</head>
	<body>
    
        <h2 class="titolo">INSTALLAZIONE</h2>
        <h4>Compila tutti i campi seguendo le linee guida e poi premi salva. Ricorda: sono case sensitive.</h4>
        
        <div class="container">
        	<h3>Variabili</h3>
            <div class="row">
                <div class="col-75">
                	<label><b>%acapo%</b> = Permette di andare a capo con il testo. (nuova linea)</label><br />
                	<label><b>%data%</b> = Mostra la data dell'operazione (<?php echo date("d-m-y"); ?>)</label><br />
                	<label><b>%ora%</b> = Mostra l'ora dell'operazione (<?php echo date("Hms"); ?>)</label><br />
                	<label><b>%datacompleta%</b> = Mostra data e ora formattata dell'operazione (<?php echo date("d/m/Y @ H:i:s"); ?>)</label>
                </div>
            </div>
            <hr>
            <form name="" method="post" action="">
            	<h3>Impostazioni generali App</h3>
            	<div class="row">
                    <div class="col-25">
                    	<label for="app">Nome App</label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="app" required placeholder="GTC Backup" value="My Backup App">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="sito">Indirizzo base del sitoweb</label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="sito" required placeholder="<?php echo $_sito; ?>" value="<?php echo $_sito; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="root">Nome della cartella principale dell'App</label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="root" required placeholder="<?php echo $_cartella_bak; ?>" value="<?php echo $_cartella_bak; ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="pulizia">Tempo massimo di permenenza dei file di backup sul server (in giorni)</label>
                    </div>
                    <div class="col-75">
                    	<input type="number" name="pulizia" required value="7">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="password">Password di accesso all'App</label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="password" required placeholder="***">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="commento">Commento del file ZIP<br />%acapo% = nuova riga, %data% = <?php echo date("d-m-y"); ?>, %ora% = <?php echo date("Hms"); ?>, %datacompleta% = <?php echo date("d/m/y H:i:s"); ?></label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="commento" placeholder="Creato da... il giorno..." value="Backup del giorno %data% alle ore %ora%">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="spazio">Spazio totale dell'hosting. "0" per spazio illimitato.<br />Usa un qualiasi <a href="https://convertlive.com/u/convert/gigabytes/to/bytes" target="_blank">converter online</a></label>
                    </div>
                    <div class="col-75">
                    	<input type="number" name="spazio" required value="0">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="logs">Abilitare i logs</label>
                    </div>
                    <div class="col-75">
                    	<input type="radio" name="logs" value="true" checked> Si<br>
                    	<input type="radio" name="logs" value="false"> No<br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="backup_di">Directory da backuppare. Escluso lo slash iniziale.<br />Lascia vuoto per effettuare il backup della root principale del sito</label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="backup_di" placeholder="cartella/sotto_cartella">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="salva_in">Directory dove salvare i backups. Escluso lo slash iniziale</label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="salva_in" placeholder="cartella/sotto_cartella" value="backups">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="ignora">Directories da ignorare. Separate da ";".<br />La cartella dell'App viene ignorata automaticamente</label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="ignora" placeholder="cartella1; cartella2/sottocartella1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="zip_host">Nome del file di backup dell'host.<br />%data% = <?php echo date("d-m-y"); ?>, %ora% = <?php echo date("Hms"); ?>, %datacompleta% = <?php echo date("d/m/y H:i:s"); ?></label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="zip_host" required placeholder="backup_%data%_%ora%.zip" value="backup_%data%_%ora%.zip">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="zip_db">Nome del file di backup del database.<br />%data% = <?php echo date("d-m-y"); ?>, %ora% = <?php echo date("Hms"); ?>, %datacompleta% = <?php echo date("d/m/y H:i:s"); ?></label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="zip_db" required placeholder="backup_%data%_%ora%.sql" value="backup_%data%_%ora%.sql">
                    </div>
                </div>
                <hr>
                <h3>Impostazioni Database</h3>
                <div class="row">
                    <div class="col-25">
                    	<label for="db_host">Indirizzo del server SQL</label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="db_host" placeholder="127.0.0.1">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="db_user">Utente per il login all'SQL</label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="db_user" placeholder="user">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="db_pass">Password per il login all'SQL</label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="db_pass" placeholder="***">
                    </div>
                </div>
                <div class="row">
                    <div class="col-25">
                    	<label for="db_name">Nome del databse di cui effettuare il backup</label>
                    </div>
                    <div class="col-75">
                    	<input type="text" name="db_name" placeholder="db_sito">
                    </div>
                </div>
                <br />
                <div class="row">
                	<input type="submit" value="Installa">
                </div>
            </form>
        </div>
    </body>
</html>
