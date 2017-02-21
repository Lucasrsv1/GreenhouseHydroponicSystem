<div>
	<div class="page-title">
		<div class="title_left no_search">
			<h3>Gerenciar Controles</h3>
		</div>
	</div>
	
	<div class="clearfix"></div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="x_panel">
				<div class="col-lg-12">
					<div id="sucesso" class="popup">  
						<div class="modal-content alert-success">
							<div class="modal-header alert-success">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title ">Sucesso</h4>
							</div>
							<div class="modal-body">
								<p id="msg_acerto">Controle excluído com sucesso!</p>
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
								<p id="msg_erro">Falha ao excluir controle!</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default fechar" data-dismiss="modal" >Fechar</button>
							</div>
						</div>
					</div>
					<div class="col-md-12 column">
						<div class="tabbable" id="tabs-442075">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#panel-168546" data-toggle="tab" id="tab_lista_controles">Listagem de Controles</a>
								</li>
								<li>
									<a href="#panel-190060" data-toggle="tab" id="tab_cadastra_controles">Cadastrar Novo Controle</a>
								</li>                            
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="panel-168546">
									<br />
									<h2> Todos os controles cadastrados </h2>
									<br />
									<table id="tblControles" class="table table-striped table-bordered" cellspacing="0" width="100%" >
										<thead>
											<tr>
												<th class="hide">Id</th>
												<th>Controle</th>
												<th>Pino</th>
												<th>Estado</th>
												<th>Última Atualização</th>
												<th>Em Uso</th>
												<th class="action">Ação</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
									<br />
									<br />
									<b>Legenda:</b>&nbsp&nbsp;<span style="color:green;">Controles Ativos&nbsp&nbsp;</span><span style="color:red;">&nbsp&nbsp;Controles Inativos</span>
								</div>
								<div class="tab-pane" id="panel-190060">
									<br />
									<h2>Novo Controle</h2>
									<br />
									<form method="post" onSubmit="$('#cadastrarControle').trigger('click'); return false;" id="formCadastrarControle">
										<div class="col-xs-12">
											<div class="col-xs-7"> <label> Nome </label> </div>
											<div class="col-xs-3"> <label> Pino </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-7">
												<input class="form-control" id="nome" name="nome" type="text" placeholder="Nome da controle" required>
											</div>
											<div class="col-xs-3">
												<input class="form-control" id="pin" name="pin" type="number" step="1" min="0" placeholder="Pino no Arduino" title="Pino ao qual o relé está conectado na placa Arduino.">
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-3"> <label> Estado </label> </div>
											<div class="col-xs-3"> <label> Em Uso </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-3">
												<input id="estado" name="estado" type="hidden" value="0" required>
												<div class="form-control nao_usando estado_toggle">DESLIGADO</div>
											</div>
											<div class="col-xs-2">
												<input id="em_uso" name="em_uso" type="hidden" value="1" required>
												<div class="form-control usando em_uso_toggle">SIM</div>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-8">
											<div class="col-xs-4">
												<input type="submit" class="hide" />
												<button type="button" class="btn btn-primary " id="cadastrarControle">
													<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Cadastrar Controle
												</button>
											</div> 
											<div class="col-xs-4">                                            
												<button type="reset" class="btn btn-primary" id="resetarControle">
													<span class="fa fa-eraser" aria-hidden="true"></span> Limpar Dados
												</button>   
											</div>
										</div>
										<br />
										<br />
									</form>
								</div>                       
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-12 column">
					<div class="modal fade" id="excluirControle" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="post" onSubmit="return false;" id="formExcluirControle">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModalLabel">Excluir Controle</h4>
									</div>
									<div class="modal-body">
										<input type="hidden" id="id" name="id" />
										Tem certeza que deseja excluir o controle? <b><span id="spanNomeControle"></span></b>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal" id="btFecharExcluirControle">Fechar</button>
										<input type="button" id="btExcluirControle" class="btn btn-primary" value="Excluir" />
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				
				<div class="col-md-12 column">
					<div class="modal fade" id="alterarControle" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="post" onSubmit="$('#btAlterarControle').trigger('click'); return false;" id="formAlterarControle">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModalLabel">&emsp;Alterar Dados do Controle</h4>
									</div>
									<div class="modal-body">
										<input type="hidden" name="id" id="id" />
										<div class="col-xs-12">
											<div class="col-xs-8"> <label> Nome </label> </div>
											<div class="col-xs-3"> <label> Pino </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-8">
												<input class="form-control" id="nome" name="nome" type="text" placeholder="Nome da controle" required>
											</div>
											<div class="col-xs-3">
												<input class="form-control" id="pin" name="pin" type="number" step="1" min="0" placeholder="Pino no Arduino" title="Pino ao qual o relé está conectado na placa Arduino.">
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-5"> <label> Estado </label> </div>
											<div class="col-xs-3"> <label> Em Uso </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-5">
												<input id="estado" name="estado" type="hidden" value="0" required>
												<div class="form-control nao_usando estado_toggle">DESLIGADO</div>
											</div>
											<div class="col-xs-3">
												<input id="em_uso" name="em_uso" type="hidden" value="1" required>
												<div class="form-control usando em_uso_toggle">SIM</div>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
									</div>
									<div class="modal-footer">
										<input type="submit" class="hide" />
										<button type="button" class="btn btn-default" data-dismiss="modal" id="btFecharAlterarControle">Cancelar</button> 
										<input type="button" id="btAlterarControle" class="btn btn-primary" value="Salvar Alterações" />
									</div>
								</form>
							</div>
						</div>
					</div>
					
					<script src="<?php echo base_url("system/utils/js/controles.js"); ?>"></script>
				</div>
			</div>
		</div>
	</div>
</div>