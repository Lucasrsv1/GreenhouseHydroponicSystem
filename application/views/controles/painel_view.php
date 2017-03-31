<div>
	<div class="page-title">
		<div class="title_left no_search">
			<h3>Painel de Controles</h3>
		</div>
	</div>
	
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Enviar Ordens para Ligar/Desligar Controladores</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<div id="sucesso" class="popup">  
						<div class="modal-content alert-success">
							<div class="modal-header alert-success">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title ">Sucesso</h4>
							</div>
							<div class="modal-body">
								<p id="msg_acerto">Ordem enviada com sucesso!</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default fechar" data-dismiss="modal" >Fechar</button>
							</div>
						</div>
					</div>
					<div id="erro" class="popup">
						<div class="modal-content alert-danger">
							<div class="modal-header alert-danger">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title ">Falha</h4>
							</div>
							<div class="modal-body">
								<p id="msg_erro">Falha!</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default fechar" data-dismiss="modal" >Fechar</button>
							</div>
						</div>
					</div>
					<br />
					<div class="col-xs-12" id="controllers">
						<!-- Generated Content -->
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script src="<?php echo base_url("system/utils/js/painel.js");?>"></script>
</div>