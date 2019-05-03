<?php
/**
 * GTC Backup
 * Creato da Network GTC
 * www.networkgtc.it
 * Gianluigi Capozzoli
 */


/** Impostazioni files ini */
ini_set('max_execution_time', 0);
ini_set('memory_limit', '-1');
set_time_limit(0);


//============================
//		RICHIAMI COMUNI
//============================


/** Protezione file */
Proteggi_Pagina(basename($_SERVER['PHP_SELF']),'funzioni.php');

/** Creazione struttura cartelle */
VersionePHP('5.6.0');
Crea_Struttura(BACKUP_OUT);
Crea_Struttura(PATH_LOGS);

//============================
//		LISTA FUNZIONI
//============================


/**
 * Controlla versione PHP
 */
Function VersionePHP($php_min){
    if (version_compare(PHP_VERSION, $php_min) <= 0) {
        die('<html><head><meta charset="UTF-8" /><title>Backup App</title></head><br /><center><font color=red><h1>! Attenzione !</h1>
            <h3>Per il corretto funzionamento di quest\'App, è necessario utilizzare minimo la versione PHP '.$php_min.
            ' la tua versione è: '.PHP_VERSION.'</h3></font></center></html>');
    }
}


/**
 * Protezione file php
 */
Function Proteggi_Pagina($pag_loc, $pag_name){
    if ($pag_loc == $pag_name){http_response_code(403);die();}
}


/**
 * Protezione file php
 */
Function Check_Sito($config_str){
    $_sito = str_replace($_SERVER['REQUEST_SCHEME'].'://',"",$_SERVER['SERVER_NAME']);
    $_sito = rtrim($_sito, '/');
    $config_str = str_replace('www.',"",$config_str);
    $config_str = str_replace('http://',"",$config_str);
    $config_str = str_replace('https://',"",$config_str);
    $_cfgstr = rtrim($config_str, '/');
    if (trim(strtolower($_sito)) != trim(strtolower($_cfgstr))){
        die('<html><head><meta charset="UTF-8" /><title>Backup App</title></head><br /><center><font color=blue><h1>! Attenzione !</h1>
            <h3>File di configurazione non compatibile, perfavore effettua di nuovo l\'<a href="'.RES_ASSETS.'installa.php">installazione</a>.</h3></font></center></html>');
    }
}


/**
 * Crea struttura directory
 */
Function Crea_Struttura($path){
    if (!file_exists($path)) {
		mkdir($path, 0755, true);
	}
}


/**
 * Scrive un log delle operazioni
 */
Function Scrivi_log($tipo, $testo){
    try {
        if (LOGS == true) {error_log(date('d/m/y').' '.date('H:i:s').' | '.$tipo.' | '.$testo."\r", 3, PATH_LOGS.'log.log');}
    } catch (Exception $e) {
        //die('Errore: '.  $e->getMessage() . "\n");
    }
}


/**
 * Ritorna la testata delle pagine html
 */
Function Testata($testo){
    return '<header class="container">
				<h3><b>'.$testo.'</b></h3>
				<hr>
			</header>';
}


/**
 * Genera un messaggio di notifica
 */
Function Messaggio($testo, $tipo){
    echo '<div class="alert '.$tipo.'">
				<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span> 
				'.$testo.'
    		</div>';
}


/**
 * Conta i backups nella cartella
 */
Function Conta_Backups($path,$tipo=NULL) {
	if ($tipo != NULL) {
		$bu = new FilesystemIterator($path);
		$Regex = new RegexIterator($bu, '/^.+\.'.$tipo.'$/i', RecursiveRegexIterator::GET_MATCH);
		return iterator_count($Regex);
		
	} else {
		
		$bu = new FilesystemIterator($path, FilesystemIterator::SKIP_DOTS);
		return iterator_count($bu);
	}
}


/**
 * Converte il tempo in secondi, impegato dal codice, in tempo formattato
 */
Function Tempo_Impiegato(){
	$s = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
    $h = floor($s / 3600);
    $s -= $h * 3600;
    $m = floor($s / 60);
    $s -= $m * 60;
    return $h.'h '.sprintf('%02d', $m).'m '.sprintf('%02d', $s).'s';
}


/**
 * Formatta il peso dei file o comunque un numero in bytes,
 * in una stringa formattate
 */
Function FormattazioneSize($size, $precisione = 2){
    $base = log($size, 1024);
    $suffixes = array(' B', ' kB', ' MB', ' GB', ' TB');

    return round(pow(1024, $base - floor($base)), $precisione) .' <small>'. $suffixes[floor($base)] . '</small>';
}


/**
 * Controlla se la cartella deve essere ignorata
 */
Function Ignorante($forbiddennames, $stringtocheck){
    foreach ($forbiddennames as $name){
        $stringtocheck = str_replace("\\", "/", $stringtocheck);
        if (stripos($stringtocheck, $name) !== FALSE){
            return true;
        }
    }
}


/**
 * Cancella i backups più vecchi
 */
Function Pulizia_Backups($monnezza, $iuorn){
    if ($iuorn == 0){exit;}
    
    $fileSystemIterator = new FilesystemIterator($monnezza);
	$now = time();
	foreach ($fileSystemIterator as $file) {
		if ($now - $file->getCTime() >= 60 * 60 * 24 * intval($iuorn))
			unlink($monnezza.'/'.$file->getFilename());
	}
}


/**
 * Calcola il peso di una cartella
 */
Function Dimensioni_Cartella($cartella){
    $peso = 0;
    foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($cartella)) as $file){
        try {
            $peso += $file->getSize();
        } catch (Exception $e) {
            continue;
        }   
    }
    return $peso;
}


/**
 * Backup Webhost
 */
Function Backup_Host(){
	try {
	    Scrivi_log('Inizio', 'Inizio creazione backup Host');
	    
		$zip = new ZipArchive();
		$zip->open(BACKUP_OUT.'/'.ZIP_HOST, ZipArchive::CREATE);
		$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(
			BACKUP_IN, FilesystemIterator::SKIP_DOTS | FilesystemIterator::KEY_AS_PATHNAME),
			RecursiveIteratorIterator::SELF_FIRST,RecursiveIteratorIterator::CATCH_GET_CHILD);
		$risultati = array();
		$arr_ignorati = array();

		if (trim(COMMENTO) != '') {$zip->setArchiveComment(COMMENTO);}

		// Prepara gli ignora...ti
		$arr_ignorati[] = str_replace('\\', '/', rtrim(PATH_APP, '/'));

		foreach (IGNORA as $ignoranti){
			if ($ignoranti == '') continue; // Evita di ignorate tutto l'ambaradan se l'array è vuoto
			$arr_ignorati[] = BACKUP_IN.$ignoranti;
		}
		
		foreach ($files as $file) {
		    
			$path = $file->getRealPath();
			
			if(Ignorante($arr_ignorati, $path)) {
			    if (is_dir($path) === true){
				    $risultati[] = array($path, 'Ignorato');
			    }
			}else{
				try {
					//Scrivi_log('Info', 'Elaborazione: '.$file);
					
					if (is_dir($path) === true){
						$zip->addEmptyDir(str_replace($path.'/', '', $path));
						$risultati[] = array($path, 'Aggiunto');
						//Scrivi_log('Info', 'Aggiunta cartella: '.$path);
					}elseif (is_file($path) === true){
					    $zip->addFile(str_replace($path.'/', '', $path));
					    $zip->setCompressionName($file, ZipArchive::CM_STORE); // CM_DEFAULT, CM_STORE, CM_DEFLATE
						//Scrivi_log('Info', 'Aggiunto file: '.$file);
					}
				} catch (Exception $e) {
				    Scrivi_log('Errore', 'Errore backup host [1]: '.$e->getMessage());
					$risultati[] = array($path.' | '.$e->getMessage(), 'Errore');
				}
			}
		}

		$zip->close();

		Scrivi_log('Successo', 'Backup Host completato!');
		
		return $risultati;
	} catch (Exception $e) {
	    Scrivi_log('Errore', 'Errore backup host [2]: '.$e->getMessage());
        die('Errore:<br />'.$e->getMessage());
    }
}


/**
 * Backup Database
 */
Function Backup_Database($tables = '*') {
    Scrivi_log('Inizio', 'Inizio creazione backup Database');
    
    $link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Controlla la connessione
    if (mysqli_connect_errno()){
        echo "Impossibile connettersi: " . mysqli_connect_error();
        Scrivi_log('Attenzione', 'Impossibile connettersi al database: '.mysqli_connect_error());
        exit;
    }
    
    mysqli_query($link, "SET NAMES 'utf8'");
    
    // Ottiene tutte le tabelle
    if($tables == '*'){
        $tables = array();
        $result = mysqli_query($link, 'SHOW TABLES');
        while($row = mysqli_fetch_row($result))
        {
            $tables[] = $row[0];
        }
    }else{
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }
    
    $return = '';
    
    // Ciclo tra le tabelle
    foreach($tables as $table){
        $result = mysqli_query($link, 'SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);
        $num_rows = mysqli_num_rows($result);
        
        $return.= 'DROP TABLE IF EXISTS '.$table.';';
        $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";
        $counter = 1;
        
        // Ciclo tabella
        for ($i = 0; $i < $num_fields; $i++){
            
            // Ciclo riga
            while($row = mysqli_fetch_row($result)){
                if($counter == 1){
                    $return.= 'INSERT INTO '.$table.' VALUES(';
                } else{
                    $return.= '(';
                }
                
                // Ciclo campi
                for($j=0; $j<$num_fields; $j++)
                {
                    $row[$j] = addslashes($row[$j]);
                    $row[$j] = str_replace("\n","\\n",$row[$j]);
                    if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                    if ($j<($num_fields-1)) { $return.= ','; }
                }
                
                if($num_rows == $counter){
                    $return.= ");\n";
                } else{
                    $return.= "),\n";
                }
                ++$counter;
            }
        }
        
        //Scrivi_log('Info', 'Aggiunta tabella: '.$table);
        
        $return.="\n\n\n";
    }
    
    $handle = fopen(BACKUP_OUT .'/'. ZIP_DB,'w+');
    fwrite($handle,$return);
    fclose($handle);
    
    Scrivi_log('Successo', 'Backup Database completato!');
    
    return true;
}
?>