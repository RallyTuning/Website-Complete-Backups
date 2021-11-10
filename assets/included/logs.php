<?php
/**
 * WCB Website Complete Backups
 * Created by https://github.com/RallyTuning
 * GNU General Public License v3.0
 */


if (count($_POST) > 0) {
    $_azione = array_keys($_POST)[0];

    switch (strtolower(trim($_azione))){
        case 'btn_logs_elimina':
            $fp = fopen(PATH_LOGS . "log.log", "r+");
            ftruncate($fp, 0);
            fclose($fp);
            
            break;
        case 'btn_logs_archivia':
            rename(PATH_LOGS . "log.log", PATH_LOGS . "log_" . date('d-m-y')."_".date('His').".log");
            break;
        default:
            break;
    }
}

?>
<?php echo Testata('<i class="fa fa-file-text-o text-teal"></i> Logs'); ?>
			
			<div class="container">
				<?php
				    if (LOGS == 'false'):
                        Messaggio('Logs disabilitati!','notifica');
					elseif(!file_exists(PATH_LOGS . "log.log")):
                        Messaggio('Nessun file di logs trovato!','notifica');
				    else: ?>
				
				<form name="form_logs" method="post" action="" class="form_norm">
    				<input class="button_s btn_verde" type="submit" name="btn_logs_archivia" value="Archivia logs corrente" />
    				<input class="button_s btn_rosso" type="submit" name="btn_logs_elimina" value="Elimina logs corrente" />
				</form>
				<table class="table striped white">
					<tr>
						<th style="width:auto">Data</th>
						<th style="width:80%">Oggetto</th>
					</tr>
					<?php
    					/** Lettura Log */
    					$file = new SplFileObject(PATH_LOGS . "log.log");
    				    $arra = array();
    				    $arra = explode("\r",$file->fgets());
    				    $arra = array_reverse($arra);
    				    
    				    foreach ($arra as $linea){
    				        if (trim($linea) == '') {continue;}
    				        
    				        $esplosa = explode("|",$linea);			        
    				        $tipo_log = '';
    				        
    				        switch (strtolower(trim($esplosa[1]))){
    				            case 'info':
    				                $tipo_log = '<i class="fa fa-info-circle text-blue large icona_btn"></i>';
    				            break;
    				            case 'errore':
    				                $tipo_log = '<i class="fa fa-times-circle text-red large icona_btn"></i>';
    				            break;
    				            case 'successo':
    				                $tipo_log = '<i class="fa fa-check-circle text-green large icona_btn"></i>';
    				            break;
    				            case 'attenzione':
    				                $tipo_log = '<i class="fa fa-exclamation-circle text-orange large icona_btn"></i>';
    				                break;
    				            case 'inizio':
    				                $tipo_log = '<i class="fa fa-play-circle text-orange large icona_btn"></i>';
    				                break;
    				            default:
    				                $tipo_log = '<i class="fa fa-question-circle text-purple large icona_btn"></i>';
    				            break;
    				        }
    				        
                echo '<tr>
                        <td>'.trim($esplosa[0]).'</td>
                        <td>'.$tipo_log.trim($esplosa[2]).'</td>
                    </tr>
                    ';
    				    }
        					    
    					// Svuota
    					$file = null;
    					
    		echo '</table>';
					endif;
					?>
					
			</div>
			