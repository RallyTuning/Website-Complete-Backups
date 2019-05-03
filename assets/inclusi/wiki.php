<?php 
    $_sito = SITO.'/'.ROOT.'/?api';
    $_token = hash('md5', ROOT.SITO.PASSWORD);
    $_sito = SITO.'/'.ROOT.'/?api';
?>
<?php echo Testata('<i class="fa fa-book text-brown"></i> Documentazione'); ?>
			
			<div class="container">
    			<h3><i class="fa fa-file-text-o text-blue" aria-hidden="true"></i> Pagine</h3>
    			<ul class="fa-ul">
    				<li><i class="fa-li fa fa-file-text-o"></i><b>Dashboard</b> Pagina principale con varie statistiche generali.</li>
                	<li><i class="fa-li fa fa-file-text-o"></i><b>Backups</b> Lista di tutti i backup esistenti.</li>
                	<li><i class="fa-li fa fa-file-text-o"></i><b>Operazioni</b> Pagina dove si possono effettuare le operazioni di backups.</li>
                	<li><i class="fa-li fa fa-file-text-o"></i><b>Impostazioni</b> Settaggi dell'App.</li>
                	<li><i class="fa-li fa fa-file-text-o"></i><b>Documentazione</b> Documentazione e "How to use" questa App.</li>
                	<li><i class="fa-li fa fa-file-text-o"></i><b>Logs</b> Pagina di consultazione Logs.</li>
                	<li><i class="fa-li fa fa-file-text-o"></i><b>Aiuto</b> Informazioni riguardo l'App.</li>
                	<li><i class="fa-li fa fa-file-text-o"></i><b>Logout</b> Disconnessione dell'account in uso.</li>
    			</ul>
            	
            	<h3><i class="fa fa-bolt text-orange" aria-hidden="true"></i> API</h3>
            	<p>Tutti i comandi devono essere preceduti da <b>?api</b> e seguiti da <b>&</b>. Ad esempio: ...<font color="red">?api</font><font color="blue">&comando</font></p>
            	<br />
            	
            	<b><i class="fa fa-dot-circle-o text-purple" aria-hidden="true"></i> Generali e obbligatori</b>
            	<p><?php echo $_sito; ?><font color="blue">&token</font>=*****</p>
            	<p>Il comando token è necessario per accedere all'App. Il toke attuale è:<input style="margin-left:5px; width:310px" type="text" value="<?php echo $_token ?>" readonly/></p>
            	<br />
            	
            	<b><i class="fa fa-dot-circle-o text-purple" aria-hidden="true"></i> Backup</b>
            	<p>...<font color="blue">&backup</font>=<font color="purple">parametro</font></p>
            	<ul class="fa-ul">
    				<li><i class="fa-li fa fa-bolt"></i><b>host</b> Effettua il backup dei soli file dell'host</li>
                	<li><i class="fa-li fa fa-bolt"></i><b>database</b> Effettua solo il backup del database (se presente)</li>
                	<li><i class="fa-li fa fa-bolt"></i><b>tutto</b> Effettua il backup dell'host e del databse</li>
    			</ul>
            	<br />
            	
            	<b><i class="fa fa-dot-circle-o text-purple" aria-hidden="true"></i> Pulizia</b>
                <p>...<font color="blue">&pulizia</font>=<font color="purple">parametro</font></p>
            	<ul class="fa-ul">
    				<li><i class="fa-li fa fa-bolt"></i><b>si</b> Effettua la pulizia dei backups più vecchi di <i>n</i> giorni, settati durante l'installazione (attiva di default)</li>
                	<li><i class="fa-li fa fa-bolt"></i><b>no</b> Salta la pulizia dei backups (se attiva)</li>
    			</ul>
    			<br />
    			
    			<b><i class="fa fa-dot-circle-o text-purple" aria-hidden="true"></i> Esempio</b>
    			<p><?php echo $_sito; ?>&token=<?php echo $_token; ?>&backup=tutto</p>
    			<br />
			</div>