<div>
	<div class="page-title">
		<div class="title_left no_search">
			<h3>Gerenciar Compradores</h3>
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
								<p id="msg_acerto">Comprador(a) excluído com sucesso!</p>
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
					<div class="col-md-12 column">
						<div class="tabbable" id="tabs-442075">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#panel-168546" data-toggle="tab" id="tab_lista_compradores">Listagem de Compradores</a>
								</li>
								<li>
									<a href="#panel-190060" data-toggle="tab" id="tab_cadastra_compradores">Cadastrar Novo Comprador(a)</a>
								</li>                            
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="panel-168546">
									<br />
									<h2> Todos os compradores cadastrados </h2>
									<br />
									<table id="tblCompradores" class="table table-striped table-bordered" cellspacing="0" width="100%" >
										<thead>
											<tr>
												<th class="hide">Id</th>
												<th>Nome</th>
												<th>Email</th>
												<th>Telefones</th>
												<th>Nome Empresa</th>
												<th>Em Uso</th>
												<th class="action">Ação</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
									<br />
									<br />
									<b>Legenda:</b>&nbsp&nbsp;<span style="color:green;">Compradores Ativos&nbsp&nbsp;</span><span style="color:red;">&nbsp&nbsp;Compradores Inativos</span>
								</div>
								<div class="tab-pane" id="panel-190060">
									<br />
									<h2>Novo Comprador(a)</h2>
									<br />
									<form method="post" onSubmit="$('#cadastrarComprador').trigger('click'); return false;" id="formCadastrarComprador">
										<div class="col-xs-12">
											<div class="col-xs-4"> <label> Nome </label> </div>
											<div class="col-xs-6"> <label> Sobrenome </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-4">
												<input class="form-control" id="primeiro_nome" name="primeiro_nome" type="text" placeholder="Nome do comprador(a)" required="required">                                           
											</div>
											<div></div>
											<div class="col-xs-6">
												<input placeholder="Sobrenome do comprador(a)"  id="sobrenome" name="sobrenome" type="text" class="form-control" data-mask="" required>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-6"> <label> Email </label> </div>
											<div class="col-xs-4"> <label> Telefone Principal </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-6">
												<input class="form-control" id="email" name="email" type="email" placeholder="Email do comprador(a)" required>
											</div>
											<div></div>
											<div class="col-xs-4">
												<input class="form-control telefone_principal" id="telefone_principal" name="telefone_principal" type="phone" placeholder="Telefone principal do comprador(a)" required>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-4"> <label> Telefone Alternativo </label> </div>
											<div class="col-xs-4"> <label> Celular </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-4">
												<input class="form-control telefone_alternativo" id="telefone_alternativo" name="telefone_alternativo" type="phone" placeholder="Telefone alternativo do comprador(a)">
											</div>
											<div></div>
											<div class="col-xs-4">
												<input class="form-control celular" id="celular" name="celular" type="phone" placeholder="Telefone celular do comprador(a)">
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-8"> <label> Nome da Empresa </label> </div>
											<div class="col-xs-4"> <label> Em Uso </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-8">
												<input class="form-control" id="nome_empresa" name="nome_empresa" type="text" placeholder="Nome da empresa do comprador(a)">
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
												<button type="button" class="btn btn-primary " id="cadastrarComprador">
													<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Cadastrar Comprador
												</button>   
											</div> 
											<div class="col-xs-4">                                            
												<button type="reset" class="btn btn-primary" id="resetarComprador">
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
					<div class="modal fade" id="excluirComprador" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="post" onSubmit="return false;" id="formExcluirComprador">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModalLabel">Excluir Comprador(a)</h4>
									</div>
									<div class="modal-body">
										<input type="hidden" id="id" name="id" />
										Tem certeza que deseja excluir o comprador(a)? <b><span id="spanNomeComprador"></span></b>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal" id="btFecharExcluirComprador">Fechar</button>
										<input type="button" id="btExcluirComprador" class="btn btn-primary" value="Excluir" />
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				
				<div class="col-md-12 column">
					<div class="modal fade" id="alterarComprador" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="post" onSubmit="$('#btAlterarComprador').trigger('click'); return false;" id="formAlterarComprador">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModalLabel">&emsp;Alterar Dados do Comprador(a)</h4>
									</div>
									<div class="modal-body">
										<input type="hidden" name="id" id="id" />
										<div class="col-xs-12">
											<div class="col-xs-5"> <label> Nome </label> </div>
											<div class="col-xs-7"> <label> Sobrenome </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-5">
												<input class="form-control" id="primeiro_nome" name="primeiro_nome" type="text" placeholder="Nome do comprador(a)" required="required">                                           
											</div>
											<div></div>
											<div class="col-xs-7">
												<input placeholder="Sobrenome do comprador(a)"  id="sobrenome" name="sobrenome" type="text" class="form-control" data-mask="" required>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-7"> <label> Email </label> </div>
											<div class="col-xs-5"> <label> Telefone Principal </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-7">
												<input class="form-control" id="email" name="email" type="email" placeholder="Email do comprador(a)" required>
											</div>
											<div></div>
											<div class="col-xs-5">
												<input class="form-control telefone_principal" id="telefone_principal" name="telefone_principal" type="phone" placeholder="Telefone principal do comprador(a)" required>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-6"> <label> Telefone Alternativo </label> </div>
											<div class="col-xs-6"> <label> Celular </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-6">
												<input class="form-control telefone_alternativo" id="telefone_alternativo" name="telefone_alternativo" type="phone" placeholder="Telefone alternativo do comprador(a)">
											</div>
											<div></div>
											<div class="col-xs-6">
												<input class="form-control celular" id="celular" name="celular" type="phone" placeholder="Telefone celular do comprador(a)">
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-9"> <label> Nome da Empresa </label> </div>
											<div class="col-xs-3"> <label> Em Uso </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-9">
												<input class="form-control" id="nome_empresa" name="nome_empresa" type="text" placeholder="Nome da empresa do comprador(a)">
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
										<button type="button" class="btn btn-default" data-dismiss="modal" id="btFecharAlterarComprador">Cancelar</button> 
										<input type="button" id="btAlterarComprador" class="btn btn-primary" value="Salvar Alterações" />
									</div>
								</form>
							</div>
						</div>
					</div>
					
					<script src="<?php echo base_url("system/utils/js/compradores.js"); ?>"></script>
				</div>
			</div>
		</div>
	</div>
</div>