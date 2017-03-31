<div class="">
	<div class="page-title">
		<div class="title_left no_search">
			<h3>Conectar ao um Servidor Local</h3>
		</div>
	</div>
	
	<div class="clearfix"></div>
	
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Selecione um de seus servidores locais</h2>
					<div class="clearfix"></div>
				</div>
				<div class="x_content">
					<br />
					<div class="col-lg-12">
						<div id="sucesso" class="popup">  
							<div class="modal-content alert-success">
								<div class="modal-header alert-success">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title ">Sucesso</h4>
								</div>
								<div class="modal-body">
									<p id="msg_acerto">Conexão estabelecida com sucesso!</p>
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
									<p id="msg_erro">Falha ao excluir comprador(a)!</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default fechar" data-dismiss="modal" >Fechar</button>
								</div>
							</div>
						</div>
						<form method="post" onSubmit="$('#conectar').trigger('click'); return false;">
							<div class="bold-label"> Servidor: </div>
							<div style="display: inline-block; width: 300px;">
								<select class="form-control" id="servidor" name="servidor" title="Descrição do servidor">
									<option value="-1" selected>Selecione um servidor para se conectar</option>
								</select>
							</div>
							<br />
							<br />
							<div class="bold-label">Endereço MAC:</div>
							<div class="normal-label" id="MAC"></div>
							<br />
							<div class="bold-label">Conexão (IP/DNS):</div>
							<div class="normal-label" id="servidor_conexao"></div>
							<br />
							<div class="bold-label">Nome de Usuário:</div>
							<div class="normal-label" id="servidor_usuario"></div>
							<br />
							<br />
							<div class="col-xs-4">
								<input type="submit" class="hide" />
								<button type="button" class="btn btn-primary " id="conectar" style="width: 128px;">
									<span class="fa fa-spinner" aria-hidden="true"></span> <span id="status">Conectar</span>
								</button>   
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script src="<?php echo base_url("system/utils/js/conectar_servidor_local.js"); ?>"></script>
</div>