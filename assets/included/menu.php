<?php $cur_pag = $_SERVER['QUERY_STRING']; ?>
<div class="bar top black large" style="z-index:4">
			<button class="bar-item button hide-large hover-none hover-text-light-grey" onclick="menu_open();"><i class="fa fa-bars"></i> &nbsp;</button>
			<span class="bar-item right">WCB <small>Powered by <a href="https://github.com/RallyTuning">RallyTuning</a></small></span>
		</div>
		<nav class="sidebar collapse white animate-left" style="z-index:3;width:300px;" id="Menu_Sidebar"><br>
			<div class="container_menu">
				<h5><b><?php echo lng("common.menu");?></b></h5>
			</div>
			<div class="bar-block">
				<a href="?dashboard" class="bar-item button padding <?php if (substr($cur_pag, 0, strlen('dashboard')) === 'dashboard'){ echo 'blue';} ?>"><i class="fa fa-tachometer fa-fw text-cyan"></i> <?php echo lng("common.dashboard");?></a>
				<a href="?backups" class="bar-item button padding <?php if (substr($cur_pag, 0, strlen('backups')) === 'backups'){ echo 'blue';} ?>"><i class="fa fa-file-archive-o fa-fw text-green"></i> <?php echo lng("common.backups");?></a>
				<a href="?operations" class="bar-item button padding <?php if (substr($cur_pag, 0, strlen('operations')) === 'operations'){ echo 'blue';} ?>"><i class="fa fa-magic fa-fw text-purple"></i> <?php echo lng("common.operations");?></a>
				<a href="?settings" class="bar-item button padding <?php if (substr($cur_pag, 0, strlen('settings')) === 'settings'){ echo 'blue';} ?>"><i class="fa fa-cogs fa-fw text-grey"></i> <?php echo lng("common.settings");?></a>
				<a href="?wiki" class="bar-item button padding <?php if (substr($cur_pag, 0, strlen('wiki')) === 'wiki'){ echo 'blue';} ?>"><i class="fa fa-book fa-fw text-brown"></i> <?php echo lng("common.wiki");?></a>
				<a href="?logs" class="bar-item button padding <?php if (substr($cur_pag, 0, strlen('logs')) === 'logs'){ echo 'blue';} ?>"><i class="fa fa-file-text-o fa-fw text-teal"></i> <?php echo lng("common.logs");?></a>
				<a href="?about" class="bar-item button padding <?php if (substr($cur_pag, 0, strlen('about')) === 'about'){ echo 'blue';} ?>"><i class="fa fa-book fa-life-ring text-orange"></i> <?php echo lng("common.about");?></a>
				<a href="?logout" class="bar-item button padding"><i class="fa fa-sign-out fa-fw text-red"></i> <?php echo lng("common.logout");?></a>
			</div>
		</nav>