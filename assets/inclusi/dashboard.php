<?php
/**
 * GTC Backup
 * Creato da Network GTC
 * www.networkgtc.it
 * Gianluigi Capozzoli
 */


$tot_zip = Conta_Backups(BACKUP_OUT,'zip');
$tot_sql = Conta_Backups(BACKUP_OUT,'sql');
$tot_tot = intval($tot_zip) + intval($tot_sql);
if (SPAZIO != 0){ $dim_web = Dimensioni_Cartella($_SERVER['DOCUMENT_ROOT']); }
$dim_app = Dimensioni_Cartella(BACKUP_OUT);


/** Ordinamento array */
$sorted_keys = array();
$dir_iterator = new DirectoryIterator(BACKUP_OUT);
$num = 0;

foreach ($dir_iterator as $fileinfo){
    if($fileinfo->isDot()) continue; // Puntini del c****
    $sorted_keys[$fileinfo->getFilename()] = $fileinfo->key();
}

// ksort != krsort
krsort($sorted_keys);

$last_back = 'Nessun backup';
foreach ($sorted_keys as $key) {
    $dir_iterator->seek($key);
    $fileinfo = $dir_iterator->current();
    $last_back = date("d/m/Y H:i:s", $fileinfo->getCTime());
    break;
}

/** Numero ultimi backups (+1) */
$ultimi_bak = 7;

?>
<?php echo Testata('<i class="fa fa-tachometer text-blue"></i> Dashboard'); ?>

			<!-- Tabs sopra -->
			<div class="row-padding margin-bottom">
				<div class="quarter">
					<div class="container teal padding-16">
						<div class="left"><i class="fa fa-hashtag xxxlarge"></i></div>
						<div class="right">
							<h3><?php echo $tot_tot; ?></h3>
						</div>
						<div class="clear"></div>
						<h4>Backups Totali</h4>
					</div>
				</div>
				<div class="quarter">
					<div class="container orange text-white padding-16">
						<div class="left"><i class="fa fa-file-archive-o xxxlarge"></i></div>
						<div class="right">
							<h3><?php echo $tot_zip; ?></h3>
						</div>
						<div class="clear"></div>
						<h4>Nr. Backups Host</h4>
					</div>
				</div>
				<div class="quarter">
					<div class="container purple padding-16">
						<div class="left"><i class="fa fa-database xxxlarge"></i></div>
						<div class="right">
							<h3><?php echo $tot_sql; ?></h3>
						</div>
						<div class="clear"></div>
						<h4>Nr. Backups Database</h4>
					</div>
				</div>
				<div class="quarter">
					<div class="container blue padding-16">
						<div class="left"><i class="fa fa-calendar xxxlarge"></i></div>
						<div class="right">
							<h3><?php echo $last_back; ?></h3>
						</div>
						<div class="clear"></div>
						<h4>Data ultimo backup</h4>
					</div>
				</div>
			</div>

			<div class="container">
				<h4>Ultimi <?php echo $ultimi_bak; ?> backups</h4>
				<table class="table striped bordered border hoverable white">
					<tr>
						<!-- <th style="width:5%">#</th> -->
						<th style="width:70%">File</th>
						<th style="width:15%">Creato il</th>
						<!-- <th style="width:10%">Peso</th> --> 
					</tr>
					<?php
						/** Ciclo array */
						foreach ($sorted_keys as $key) {

							$dir_iterator->seek($key);
							$fileinfo = $dir_iterator->current();
							
							$file_form = $fileinfo->getFilename();
							
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

							//echo '
									//<td>'.FormattazioneSize($fileinfo->getSize()).'</td>';

							echo '
								</tr>';
							
							$num += 1;
							
							if ($num == $ultimi_bak){break;} // Più 1, che parte da 0
						}
						
						
						/** Calcolo peso */
						$perc_web = 0;
						$perc_app = 0;
						
						if (SPAZIO != 0){
						    $du = SPAZIO - $dim_web;
						    $da = SPAZIO - $dim_app;
						    
						    $perc_web =  100 - (sprintf('%.2g',($du / SPAZIO) * 100));
						    $perc_app =  100 - (sprintf('%.2g',($da / SPAZIO) * 100));
						}
					?>
				</table>
				<br />
				<h4>Spazio utlizzato</h4>
				<?php if (SPAZIO != 0): ?>
				<div class="grey multibar">
					<div class="container center padding red" style="width:<?php echo $perc_web ?>%"><p style="margin: 0 0 0 -12px;"><?php echo $perc_web ?>%</p></div>
					<div class="container center padding blue" style="width:<?php echo $perc_app ?>%"><p style="margin: 0 0 0 -12px;"><?php echo $perc_app ?>%</p></div>
				</div>
				<br />
				<?php endif;?>
			</div> <!-- !Container -->
			
			<!-- Tabs sotto -->
			<div class="row-padding margin-bottom">
				<?php if (SPAZIO != 0): ?>
				<div class="quarter">
					<div class="container red padding-16">
						<div class="left"><i class="fa fa-hdd-o xxxlarge"></i></div>
						<div class="right">
							<h3><?php echo FormattazioneSize(intval($dim_web) + intval($dim_app)). ' / '. FormattazioneSize(SPAZIO); ?></h3>
						</div>
						<div class="clear"></div>
						<h4>Dimensioni totali Host</h4>
					</div>
				</div>
				<?php endif;?>
				<div class="quarter">
					<div class="container blue padding-16">
						<div class="left"><i class="fa fa-folder-o xxxlarge"></i></div>
						<div class="right">
							<h3><?php echo FormattazioneSize($dim_app); ?></h3>
						</div>
						<div class="clear"></div>
						<h4>Dimensioni totali Backups</h4>
					</div>
				</div>
			</div>
    		