<?php
	
	function linkUrl ($link) {
		$result = base_url($link);
		$class = "";
		
		if (substr(current_url(), 0, strlen($result)) === $result)
			$class = " class=\"current-page\"";
		
		echo $class."><a href=\"".$result."\">";
	}
	
?>

<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
	<div class="menu_section">
		<h3>Geral</h3>
		<ul class="nav side-menu">
			<li><a><i class="fa fa-home"></i> Início <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li <?php echo linkUrl("perfil"); ?>Perfil</a></li>
					<li <?php echo linkUrl("servidor_local"); ?>Conectar a um Servidor Local</a></li>
					<li <?php echo linkUrl("operario/ajuda"); ?>Ajuda</a></li>
				</ul>
			</li>
			<li><a><i class="fa fa-wrench"></i> Controles <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li <?php echo linkUrl("controles/painel"); ?>Painel de Controles</a></li>
					<li <?php echo linkUrl("controles/alternadores"); ?>Alternadores</a></li>
					<li <?php echo linkUrl("controles/temporizadores"); ?>Temporizadores</a></li>
				</ul>
			</li>
			<li><a><i class="fa fa-bar-chart-o"></i> Estatísticas <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li <?php echo linkUrl("estatisticas"); ?>Dados Mais Atuais</a></li>
				</ul>
			</li>
			<li><a><i class="fa fa-cogs"></i>Gerenciar <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li <?php echo linkUrl("gerenciar/controles"); ?>Gerenciar Controles</a></li>
					<li <?php echo linkUrl("gerenciar/estatisticas"); ?>Gerenciar Estatísticas</a></li>
					<li <?php echo linkUrl("gerenciar/servidores_locais"); ?>Gerenciar Servidores Locais</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>