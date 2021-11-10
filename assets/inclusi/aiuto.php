<?php

if(intval(ini_get('max_execution_time')) == 0){
    $_met = '<font color=green>0</font>';
}else{
    $_met = '<font color=orange>'.ini_get('max_execution_time').'</font>';
}

if(ini_get('memory_limit') == -1){
    $_ml = '<font color=green>senza limite</font>';
}else{
    $_ml = '<font color=orange>'.ini_get('memory_limit').'</font>';
}

if(extension_loaded('zlib') == true){
    $_zlib =  '<font color=green>presente</font>';
}else{
    $_zlib =  '<font color=red>assente</font>';
}

?>
<?php echo Testata('<i class="fa fa-life-ring text-orange"></i> Aiuto'); ?>
			
			<div class="container" style="text-align: center;">
				<img src="<?php echo RES_ASSETS; ?>immagini/safe-icon.png" alt="Logo">
    			<h2><?php echo APP;?></h2>
    			<h3><i>WCB Website Complete Backups</i></h3>
				<p>Versione 0.33 <a href="<?php echo RES_ASSETS; ?>update.php"><i class="fa fa-refresh"></i></a></p>
				<br />
				<a href="https://github.com/RallyTuning"><i class="fa fa-external-link text-blue icona_btn" aria-hidden="true"></i>RallyTuning</a>
				<br />
				<br />
				<p>Sviluppato da:</p>
				<a href="https://github.com/RallyTuning"><i class="fa fa-envelope text-red icona_btn" aria-hidden="true"></i>Gianluigi Capozzoli</a>
				<br />
				<br />
				<br />
				<hr>
				<h3><i class="fa fa-info-circle text-blue" aria-hidden="true"></i> Informazioni sull'hosting</h3>
    			<ul class="fa-ul">
    				<li>max_execution_time: <?php echo $_met; ?></li>
                	<li>memory_limit: <?php echo $_ml; ?></li>
                	<li>zlib: <?php echo $_zlib; ?></li>
    			</ul>
			</div>