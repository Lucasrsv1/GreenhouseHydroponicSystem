<div>
	<div class="page-title">
		<div class="title_left no_search">
			<h3>Gerenciar Servidores Locais</h3>
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
								<p id="msg_acerto">Servidor local excluído com sucesso!</p>
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
								<p id="msg_erro">Falha ao excluir servidor local!</p>
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
									<a href="#panel-168546" data-toggle="tab" id="tab_lista_servidores_locais">Listagem de Servidores Locais</a>
								</li>
								<li>
									<a href="#panel-190060" data-toggle="tab" id="tab_cadastra_servidores_locais">Cadastrar Novo Servidor Local</a>
								</li>                            
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="panel-168546">
									<br />
									<h2> Todos os servidores locais cadastrados </h2>
									<br />
									<table id="tblServidores_Locais" class="table table-striped table-bordered" cellspacing="0" width="100%" >
										<thead>
											<tr>
												<th class="hide">Id</th>
												<th>Descrição</th>
												<th>MAC</th>
												<th>Conexão (IP/DNS)</th>
												<th>Usuário</th>
												<th>Em Uso</th>
												<th class="action">Ação</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
									<br />
									<br />
									<b>Legenda:</b>&nbsp&nbsp;<span style="color:green;">Servidores Locais Ativos&nbsp&nbsp;</span><span style="color:red;">&nbsp&nbsp;Servidores Locais Inativos</span>
								</div>
								<div class="tab-pane" id="panel-190060">
									<br />
									<h2>Novo Servidor Local</h2>
									<br />
									<form method="post" onSubmit="$('#cadastrarServidor_Local').trigger('click'); return false;" id="formCadastrarServidor_Local">
										<div class="col-xs-12">
											<div class="col-xs-6"> <label> Descrição </label> </div>
											<div class="col-xs-4"> <label> MAC </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-6">
												<input class="form-control" id="descricao" name="descricao" type="text" placeholder="Descrição do servidor local (ex.: Chácara Imperiais)" required>
											</div>
											<div class="col-xs-4">
												<input placeholder="MAC do servidor local"  id="MAC" name="MAC" type="text" class="form-control MAC" required>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-6"> <label> Conexão (IP/DNS) </label> </div>
											<div class="col-xs-4"> <label> Nome de Usuário </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-6">
												<input class="form-control" id="servidor_conexao" name="servidor_conexao" type="text" placeholder="Link de conexão (IP ou endereço DNS) com o servidor local" required>
											</div>
											<div class="col-xs-4">
												<input class="form-control" id="servidor_usuario" name="servidor_usuario" type="text" placeholder="Nome de usuario do banco de dados local" required>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-4"> <label> Senha </label> </div>
											<div class="col-xs-4"> <label> Confirmar Senha </label> </div>
											<div class="col-xs-4"> <label> Em Uso </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-4">
												<input placeholder="Senha do usuário no banco de dados local"  id="servidor_senha" name="servidor_senha" type="password" class="form-control">
											</div>
											<div class="col-xs-4">
												<input placeholder="Confirme a senha"  id="confirmaSenha" name="confirmaSenha" type="password" class="form-control">
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
												<button type="button" class="btn btn-primary " id="cadastrarServidor_Local">
													<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Cadastrar Servidor Local
												</button>   
											</div> 
											<div class="col-xs-4">                                            
												<button type="reset" class="btn btn-primary" id="resetarServidor_Local">
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
					<div class="modal fade" id="alterarServidor_Local" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="post" onSubmit="$('#btAlterarServidor_Local').trigger('click'); return false;" id="formAlterarServidor_Local">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModalLabel">&emsp;Alterar Dados do Servidor Local</h4>
									</div>
									<div class="modal-body">
										<input type="hidden" name="id" id="id" />
										<div class="col-xs-12">
											<div class="col-xs-12"> <label> Descrição </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-12">
												<input class="form-control" id="descricao" name="descricao" type="text" placeholder="Descrição do servidor local (ex.: Chácara Imperiais)" required="required">
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-7"> <label> Conexão (IP/DNS) </label> </div>
											<div class="col-xs-5"> <label> Nome de Usuário </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-7">
												<input class="form-control" id="servidor_conexao" name="servidor_conexao" type="text" placeholder="Link de conexão (IP ou endereço DNS) com o servidor local" required>
											</div>
											<div class="col-xs-5">
												<input class="form-control" id="servidor_usuario" name="servidor_usuario" type="text" placeholder="Nome de usuario do banco de dados local" required>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-4"> <label> Senha </label> </div>
											<div class="col-xs-4"> <label> Confirmar Senha </label> </div>
											<div class="col-xs-3"> <label> Em Uso </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-4">
												<input placeholder="Senha do usuário no banco de dados local"  id="servidor_senha" name="servidor_senha" type="password" class="form-control">
											</div>
											<div class="col-xs-4">
												<input placeholder="Confirme a senha"  id="confirmaSenha" name="confirmaSenha" type="password" class="form-control">
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
										<button type="button" class="btn btn-default" data-dismiss="modal" id="btFecharAlterarServidor_Local">Cancelar</button> 
										<input type="button" id="btAlterarServidor_Local" class="btn btn-primary" value="Salvar Alterações" />
									</div>
								</form>
							</div>
						</div>
					</div>
					
					<script src="<?php echo base_url("system/utils/js/servidores_locais.js"); ?>"></script>
				</div>
			</div>
		</div>
	</div>
</div>