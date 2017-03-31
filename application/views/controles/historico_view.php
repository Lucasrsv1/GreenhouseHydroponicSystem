<div>
	<div class="page-title">
		<div class="title_left no_search">
			<h3>Histórico de Ordens</h3>
		</div>
	</div>
	
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="x_title">
					<h2>Histórico Detalhado das Ordens Enviadas</h2>
					<div class="clearfix"></div>
				</div>
				<div class="col-lg-12">
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
					<div class="col-xs-12">
						<!-- <h2> Todos os controles cadastrados </h2>
						<br /> -->
						<table id="tblHistorico" class="table table-striped table-bordered" cellspacing="0" width="100%" >
							<thead>
								<tr>
									<th>Usuário</th>
									<th>Nome</th>
									<th>Controle</th>
									<th>Ordem</th>
									<th>Cumprida</th>
									<th>Envio</th>
									<th>Execução</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
						<br />
						<br />
						<b>Legenda:</b>&nbsp&nbsp;<span style="color:green;">Ordens Executadas&nbsp&nbsp;</span><span style="color:red;">&nbsp&nbsp;Ordens Não Executadas</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script src="<?php echo base_url("system/utils/js/historico.js");?>"></script>
</div>