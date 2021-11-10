<?php echo Testata('<i class="fa fa-magic text-purple"></i> Operazioni'); ?>
			
			<div class="container">
				<p>Lista di operazioni che &egrave; possibile effettuare con l'App.</p>
				<p>Per maggiori informazioni, leggi la <a href="?wiki"><i class="fa fa-book fa-fw text-brown"></i>documentazione</a> in merito.</p>
				<form name="" method="post" action="" class="form_norm">
    				<input class="button_s btn_giallo" type="submit" name="host" value="Effettua backup Host" />
    				<input class="button_s btn_viola" type="submit" name="database" value="Effettua backup Database" />
    				<input class="button_s btn_verde" type="submit" name="tutto" value="Effettua backup di tutto" />
    				<label class="check_cont">Mostra Report
                    	<input type="checkbox" name="report" checked="checked">
                    	<span class="checkmark"></span>
                    </label>
				</form>
			</div>	
			<?php
    			// Richiama le funzioni
    			if (count($_POST) > 0) {
    			    
    			    $_azione = array_keys($_POST)[0];
    			    $_report = false;
    			    
    			    // Se la check report è checkata
    			    if (count($_POST) > 1) {
    			        $_report = array_values($_POST)[1];
    			        if(trim($_report) == 'on'){$_report = true;}
    			    }else{
    			        $_report = false;
    			    }
    			    
    			    // Pulizia
    			    Pulizia_Backups(BACKUP_OUT, PULIZIA);
    			    
    			    switch ($_azione) {
    			        case 'host':
    			            Crea_Pagina($_report, Backup_Host(), NULL);
                            break;
    			        case 'database':
                            Crea_Pagina($_report, NULL, Backup_Database());
    			            break;
                        case 'tutto':
                            Crea_Pagina($_report, Backup_Host(), Backup_Database());
    			            break;
    			        default:
    			         
		            echo '<div class="container">'; // Crea il container
		            
                    Messaggio('Paramentro non valido! ('.$_SERVER['QUERY_STRING'],'errore');

                            Scrivi_log('Attenzione', 'Paramentro backup non valido! ('.$_SERVER['QUERY_STRING'].')');
    			            break;
    			    }
    			}
    			
    			
    			Function Crea_Pagina($report = false, $risultati_host = NULL, $risultati_database = NULL){
    			    
                    $tempo_eff = Tempo_Impiegato();
                    
                    Scrivi_log('Info', 'Tempo impiegato: ('.$tempo_eff.')');

    			    echo '<div class="container">'; // Crea il container
    			    
    			    Messaggio('Backup completato in '.$tempo_eff,'successo');
    			    
    			    // Salta il report
    			    if ($report === false) { exit; }
    			    
    			    if ($risultati_host != NULL){
    			        echo '<table class="table striped bordered border hoverable white">
					<tr>
						<th style="width:5%">#</th>
						<th style="width:80%">File</th>
						<th style="width:15%">Esito</th>
					</tr>';
    			        
    			        $num = 1;
    			        foreach ($risultati_host as $riga) {
    			            
    			            echo '
								<tr>
									<td>'.$num.'</td>';
    			            
    			            echo '
				<td>'.$riga[0] .'</td>';
    			            
    			            switch (strtolower($riga[1])) {
    			                case 'aggiunto':
    			                    echo '<td class="green">'.ucfirst($riga[1]).'</td>';
    			                    break;
    			                case 'ignorato':
    			                    echo '<td class="purple">'.ucfirst($riga[1]).'</td>';
    			                    break;
    			                case 'negato':
    			                case 'errore':
    			                    echo '<td class="red">'.ucfirst($riga[1]).'</td>';
    			                    break;
    			                default:
    			                    echo '<td class="orange">'.ucfirst($riga[1]).'</td>';
    			                    break;
    			            }
    			            echo '
				</tr>';
    			            $num += 1;
    			        }
    			        
    			        echo '
			</table>
		</div>';
    			    }
    			}
			?>