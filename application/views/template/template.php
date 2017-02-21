<?php
	
	$this->local_server = $this->load->database("local_server", true);
	$this->local_server->hostname = $session_data['local_server_hostname'];
	$this->local_server->username = $session_data['local_server_username'];
	$this->local_server->password = $session_data['local_server_password'];
	
	if (!$this->local_server->initialize())
		$this->local_server = NULL;
	
	$onLoad = "base_url = '".base_url()."'; ";
	if ($fullscreen == true)
		$onLoad .= "fullscreen = true; ";
	else
		$onLoad .= "fullscreen = false; ";
	
	if ($nav === "sm")
		$onLoad .= "navStatus = 'sm'; ";
	else
		$onLoad .= "navStatus = 'md'; ";
	
	$onLoad .= "ApplyPreferences();";
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta http-equiv="content-language" content="pt-br" />
	    <meta http-equiv="pragma" content="no-cache" />
	    <link rel="shortcut icon" href="<?php echo base_url("system/utils/Imagens/alface_mimosa_g.ico"); ?>" type="image/x-icon" />
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <meta name="description" content="Sistema de automação para estufas hidropônicas.">
	    <meta name="author" content="Lucas Rassilan Vilanova && Paulo Henrique Rodrigues">
	    <meta name="keywords" content="sistema de automação,hidroponia,agricultura, produção" />
	    <meta name="copyright" content="© 2017 Greenhouse Hydroponic System" />
		
		<title><?php echo $title; ?> | Greenhouse Hydroponic System</title>
		
		<!-- Bootstrap -->
		<link href="<?php echo base_url("system/vendors/bootstrap/dist/css/bootstrap.min.css"); ?>" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="<?php echo base_url("system/vendors/fontawesome/css/font-awesome.min.css"); ?>" rel="stylesheet">
		<!-- NProgress -->
		<link href="<?php echo base_url("system/vendors/nprogress/nprogress.css"); ?>" rel="stylesheet">
		<!-- jQuery custom content scroller -->
		<link href="<?php echo base_url("system/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css"); ?>" rel="stylesheet">
		<!-- Datatables -->
		<link href="<?php echo base_url("system/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css"); ?>" rel="stylesheet">
		
		<!-- Custom Theme Style -->
		<link href="<?php echo base_url("system/theme/css/custom.css"); ?>" rel="stylesheet">
		
		<!-- Custom Style -->
		<link href="<?php echo base_url("system/utils/css/default.css"); ?>" rel="stylesheet">
        
        <!-- jQuery -->
		<script src="<?php echo base_url("system/vendors/jquery/dist/jquery.min.js"); ?>"></script>
	</head>
    <body class="nav-md" onLoad="<?php echo $onLoad; ?>">
		<div class="container body">
			<div class="main_container">
				<div class="col-md-3 left_col menu_fixed">
					<div style="max-height: none;" tabindex="0">
						<div style="position: relative; top: 0px; left: 0px;" dir="ltr">
							<div class="left_col scroll-view">
								<span class="nav_title_span">
									<div class="navbar nav_title" style="border: 0;">
										<a href="<?php echo base_url(); ?>" class="site_title">Greenhouse Hydroponic System</a>
									</div>
								</span>
								<div class="clearfix"></div>
								
								<!-- menu profile quick info -->
								<div class="profile clearfix">
									<div class="profile_pic">
										<a href="<?php echo base_url("perfil"); ?>"><img src="<?php echo base_url("system/utils/Imagens/".$session_data['tipo'].".png"); ?>" class="img-circle profile_img"></a>
									</div>
									<div class="profile_info">
										<span>Bem Vindo,</span>
										<h2><?php echo $session_data['primeiro_nome']; ?></h2>
									</div>
									<div class="clearfix"></div>
								</div>
								<!-- /menu profile quick info -->
								<br />
								
								<!-- sidebar menu -->
								<?php echo $menu; ?>
								<!-- /sidebar menu -->
    							
								<!-- /menu footer buttons -->
								<div class="sidebar-footer hidden-small">
									<a id="fullscreen" data-toggle="tooltip" data-placement="top" title="Tela Cheia">
										<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
									</a>
									<a href="<?php echo base_url($session_data['tipo']."/ajuda"); ?>" data-toggle="tooltip" data-placement="top" title="Ajuda">
										<span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>
									</a>
									<a href="<?php echo base_url("login/logout"); ?>" data-toggle="tooltip" data-placement="top" title="Logout">
										<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
									</a>
								</div>
								<!-- /menu footer buttons -->
							</div>
						</div>
    				</div>
				</div>
				<!-- top navigation -->
				<div class="top_nav">
					<div class="nav_menu">
						<nav>
							<div class="nav toggle">
								<a id="menu_toggle"><i class="fa fa-bars"></i></a>
							</div>
    						
							<ul class="nav navbar-nav navbar-right">
                                <li>
									<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<img src="<?php echo base_url("system/utils/Imagens/".$session_data['tipo'].".png"); ?>" alt=""><?php echo $session_data['usuario']; ?>
										<span class=" fa fa-angle-down"></span>
									</a>
									<ul class="dropdown-menu dropdown-usermenu pull-right">
										<li><a href="<?php echo base_url("perfil"); ?>">Perfil</a></li>
										<li><a href="<?php echo base_url("servidor_local"); ?>">Servidor Local</a></li>
										<li><a href="<?php echo base_url($session_data['tipo']."/ajuda"); ?>">Ajuda</a></li>
										<li><a href="<?php echo base_url("login/logout"); ?>"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
									</ul>
								</li>
								<li title="<?php echo ($this->local_server) ? "Conectado" : "Não conectado"; ?>">
                                	<span id="connection_status" style="line-height: 57px; margin-right: 5px;">
                                    	<?php
											if ($this->local_server)
												echo "<i class=\"fa fa-circle local_server_on\"></i>".$session_data['local_server_descricao'];
											else
												echo "<i class=\"fa fa-circle local_server_off\"></i>Servidor local desconectado";
										?>
                                    </span>
                                </li>
							</ul>
						</nav>
					</div>
				</div>
				<!-- /top navigation -->
    			
				<!-- page content -->
				<div class="right_col" role="main">
					<?php echo $content; ?>
				</div>
				<!-- /page content -->
				
				<!-- footer content -->
				<footer>
					<div class="pull-right">
						Greenhouse Hydroponic System - Criado por Lucas Rassilan Vilanova &amp;&amp; Paulo Henrique Rodrigues
					</div>
					<div class="clearfix"></div>
				</footer>
				<!-- /footer content -->
			</div>
		</div>
        
        <!-- jQuery UI -->
		<script src="<?php echo base_url("system/vendors/jquery/dist/jquery-ui.min.js"); ?>"></script>
        <!-- jQuery Mask -->
		<script src="<?php echo base_url("system/vendors/jquery/dist/jquery.maskedinput.js"); ?>"></script>
		<!-- Data Table -->
		<script src="<?php echo base_url("system/vendors/jquery/dist/jquery.data.Tables.js"); ?>"></script>
		<script src="<?php echo base_url("system/vendors/jquery/dist/dataTables.tableTools.js"); ?>"></script>
        <!-- jQuery custom content scroller -->
		<script src="<?php echo base_url("system/vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js"); ?>"></script>
		<!-- Bootstrap -->
		<script src="<?php echo base_url("system/vendors/bootstrap/dist/js/bootstrap.min.js"); ?>"></script>
		<!-- FastClick -->
		<script src="<?php echo base_url("system/vendors/fastclick/lib/fastclick.js"); ?>"></script>
		<!-- NProgress -->
		<script src="<?php echo base_url("system/vendors/nprogress/nprogress.js"); ?>"></script>
    	
		<!-- Custom Theme Scripts -->
		<script src="<?php echo base_url("system/theme/js/custom.js"); ?>"></script>
	</body>
</html>