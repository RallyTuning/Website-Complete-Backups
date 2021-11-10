<?php
/**
 * WCB Website Complete Backups
 * Created by https://github.com/RallyTuning
 * GNU General Public License v3.0
 */


echo Testata('<i class="fa fa-file-archive-o text-green"></i> Lista Backups'); ?>

			<div class="container">
				<?php 
    				/** Download & Elimina */
    				if (count($_POST) > 0) {
    				    
    				    $file = array_values($_POST)[0];
    				    $_azione = array_keys($_POST)[1];
    				    
    				    switch (strtolower(trim($_azione))){
    				        case 'btn_bak_download':
    				            
    				            $ext = explode('.',$file);
    				            $path_file = BACKUP_OUT . '/'.$file;

    				            if(file_exists($path_file)){
    				                header("Pragma: no-cache");
    				                header('Cache-Control: no-cache, must-revalidate');
    				                header('Content-Description: File Transfer');
    				                header('Content-Disposition: attachment; filename="'.$file.'"');
    				                header('Content-Type: application/'.$ext[count($ext)-1]);
    				                header('Content-Transfer-Encoding: binary');
    				                header("Content-Length: ".filesize($path_file));

    				                // Invia il buffer al client
    				                ob_clean();
    				                flush();
    				                
    				                // Invia l'output stream al client
    				                readfile($path_file);
    				                exit;
    				            }else{
    				                Messaggio('Impossibile <b>scaricare</b> il file! Non valido o permessi insufficienti! ('.$file.')','attenzione');
    				            }
    				            
    				            break;
    				        case 'btn_bak_elimina':
    				            $file_elim = BACKUP_OUT . '/'.$file;
    				            if (file_exists($file_elim)){
    				                unlink($file_elim);
    				                Messaggio('File "'.$file.'" rimosso con successo!','successo');
    				            }else{
    				                Messaggio('Impossibile <b>eliminare</b> il file! Non valido o permessi insufficienti! ('.$file.')','attenzione');
    				            }
    				            
    				            break;
    				        default:
    				            break;
    				    }
    				}		
				?>
			
				<table class="table striped bordered border hoverable white">
					<tr>
						<!-- <th style="width:5%">#</th> -->
						<th style="width:70%">File</th>
						<th style="width:auto">Creato il</th>
						<th style="width:auto">Peso</th> 
						<th style="width:3%"></th>
					</tr>
					<?php

						/** Ordinamento array */
						$sorted_keys = array();
						$dir_iterator = new DirectoryIterator(BACKUP_OUT);
						$num = 1;

						foreach ($dir_iterator as $fileinfo){
							if($fileinfo->isDot()) continue; // Puntini del c****
							$sorted_keys[$fileinfo->getFilename()] = $fileinfo->key();
						}

						// ksort != krsort
						krsort($sorted_keys);

						foreach ($sorted_keys as $key) {

							$dir_iterator->seek($key);
							$fileinfo = $dir_iterator->current();
							
							$file_form = str_replace("_", " ", $fileinfo->getFilename()); // Non credo serva, però boh
							
							echo '
								<tr>
									<!--<td>'.$num.'</td>-->';
							
							switch (strtolower($fileinfo->getExtension())) {
							case 'zip':
								echo '
									<td><i class="fa fa-file-zip-o text-orange" aria-hidden="true"></i> '.$file_form.'</td>';
								break;
							case 'sql':
								echo '
									<td><i class="fa fa-database text-purple" aria-hidden="true"></i> '.$file_form.'</td>';
								break;
							default:
								echo '
									<td><i class="fa fa-file text-red" aria-hidden="true"></i> '.$file_form.'</td>';
								break;
							}
							
							echo '
									<td>'.date("d/m/Y H:i:s", $fileinfo->getCTime()).'</td>';

							echo '
									<td>'.FormattazioneSize($fileinfo->getSize()).'</td>';
							
							echo '<td><form name="form_bak" method="post" action="" class="form_bak">
                    <input type="hidden" name="_file_" readonly value="'.$fileinfo->getFilename().'">
    				<input class="button_t download" type="submit" name="btn_bak_download" value="&#xf019" />
    				<input class="button_t elimina" type="submit" name="btn_bak_elimina" value="&#xf1f8" />
				</form></td>';
							//echo '
									//<td><a href="?backups&download='.$file_form.'"><i class="fa fa-download text-blue" aria-hidden="true"></i></a>  <a href="?backups&elimina='.$file_form.'"><i class="fa fa-trash text-red" aria-hidden="true"></i></td>';

							echo '
								</tr>';
							
							$num += 1;
						}
					?>
				</table>
			</div>