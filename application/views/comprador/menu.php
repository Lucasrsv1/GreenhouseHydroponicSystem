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
					<li <?php echo linkUrl("comprador/ajuda"); ?>Ajuda</a></li>
				</ul>
			</li>
			<li><a><i class="fa fa-shopping-cart"></i> Pedidos <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li <?php echo linkUrl("pedidos"); ?>Meus Pedidos</a></li>
					<li <?php echo linkUrl("pedidos/registrar"); ?>Registrar Novo Pedido</a></li>
				</ul>
			</li>
			<li><a><i class="fa fa-dollar"></i> Compras <span class="fa fa-chevron-down"></span></a>
				<ul class="nav child_menu">
					<li <?php echo linkUrl("vendas"); ?>Minhas Compras</a></li>
					<li <?php echo linkUrl("vendas/registrar"); ?>Registrar Nova Compra</a></li>
				</ul>
			</li>
		</ul>
	</div>
</div>