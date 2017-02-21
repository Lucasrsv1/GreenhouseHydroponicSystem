<div>
	<div class="page-title">
		<div class="title_left no_search">
			<h3>Gerenciar Usuários</h3>
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
								<p id="msg_acerto">Usuário excluído com sucesso!</p>
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
								<p id="msg_erro">Falha ao excluir usuário!</p>
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
									<a href="#panel-168546" data-toggle="tab" id="tab_lista_usuarios">Listagem de Usuários</a>
								</li>
								<li>
									<a href="#panel-190060" data-toggle="tab" id="tab_cadastra_usuarios">Cadastrar Novo Usuário</a>
								</li>                            
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="panel-168546">
									<br />
									<h2> Todos os usuários cadastrados </h2>
									<br />
									<table id="tblUsuarios" class="table table-striped table-bordered" cellspacing="0" width="100%" >
										<thead>
											<tr>
												<th class="hide">Id</th>
												<th>Usuário</th>
												<th>Nome</th>
												<th>Tipo</th>
												<th>Email</th>
												<th>Telefones</th>
												<th>Em Uso</th>
												<th class="action">Ação</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
									<br />
									<br />
									<b>Legenda:</b>&nbsp&nbsp;<span style="color:green;">Usuários Ativos&nbsp&nbsp;</span><span style="color:red;">&nbsp&nbsp;Usuários Inativos</span>
								</div>
								<div class="tab-pane" id="panel-190060">
									<br />
									<h2>Novo Usuário</h2>
									<br />
									<form method="post" onSubmit="$('#cadastrarUsuario').trigger('click'); return false;" id="formCadastrarUsuario">
										<input type="submit" class="hide" />
										<div class="col-xs-12">
											<div class="col-xs-4"> <label> Nome de Usuário </label> </div>
											<div class="col-xs-4"> <label> Senha </label> </div>
											<div class="col-xs-4"> <label> Confirmar Senha </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-4">
												<input class="form-control" id="usuario" name="usuario" type="text" placeholder="Nome de usuário para fazer login" required="required">                                           
											</div>
											<div class="col-xs-4">
												<input placeholder="Crie uma senha para o usuário"  id="senha" name="senha" type="password" class="form-control" required>
											</div>
											<div class="col-xs-4">
												<input placeholder="Confirme sua senha"  id="confirmaSenha" name="confirmaSenha" type="password" class="form-control" required>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-5"> <label> Tipo de Conta </label> </div>
											<div class="col-xs-7"> <label> Comprador Associado </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-5">
												<select class="form-control" id="tipo" name="tipo" title="O tipo da conta define os privilégios do usuário">
													<option value="-1" selected>Selecione um tipo de conta</option>
													<option value="0">Administrador</option>
													<option value="1">Comprador</option>
													<option value="2">Operário</option>
												</select>
											</div>
											<div class="col-xs-7">
												<select class="form-control" id="compradores_id" name="compradores_id" title="Comprador associado a essa conta">
													<option value="-1" selected>Selecione um comprador para ser associado a essa conta</option>
												</select>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-4"> <label> Nome </label> </div>
											<div class="col-xs-6"> <label> Sobrenome </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-4">
												<input class="form-control compr" id="primeiro_nome" name="primeiro_nome" type="text" placeholder="Nome real do usuário" required="required">                                           
											</div>
											<div></div>
											<div class="col-xs-6">
												<input placeholder="Sobrenome do usuário"  id="sobrenome" name="sobrenome" type="text" class="form-control compr" required>
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
												<input class="form-control compr" id="email" name="email" type="email" placeholder="Email do usuário" required>
											</div>
											<div></div>
											<div class="col-xs-4">
												<input class="form-control telefone_principal compr" id="telefone_principal" name="telefone_principal" type="phone" placeholder="Telefone principal do usuário" required>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-4"> <label> Telefone Alternativo </label> </div>
											<div class="col-xs-4"> <label> Celular </label> </div>
											<div class="col-xs-4"> <label> Em Uso </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-4">
												<input class="form-control telefone_alternativo compr" id="telefone_alternativo" name="telefone_alternativo" type="phone" placeholder="Telefone alternativo do usuário">
											</div>
											<div></div>
											<div class="col-xs-4">
												<input class="form-control celular compr" id="celular" name="celular" type="phone" placeholder="Telefone celular do usuário">
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
												<button type="button" class="btn btn-primary " id="cadastrarUsuario">
													<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Cadastrar Usuário
												</button>   
											</div> 
											<div class="col-xs-4">                                            
												<button type="reset" class="btn btn-primary" id="resetarUsuario">
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
					<div class="modal fade" id="excluirUsuario" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="post" onSubmit="return false;" id="formExcluirUsuario">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModalLabel">Excluir Usuário</h4>
									</div>
									<div class="modal-body">
										<input type="hidden" id="id" name="id" />
										Tem certeza que deseja excluir o usuário? <b><span id="spanNomeUsuario"></span></b>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal" id="btFecharExcluirUsuario">Fechar</button>
										<input type="button" id="btExcluirUsuario" class="btn btn-primary" value="Excluir" />
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				
				<div class="col-md-12 column">
					<div class="modal fade" id="alterarUsuario" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="post" onSubmit="$('#btAlterarUsuario').trigger('click'); return false;" id="formAlterarUsuario">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModalLabel">&emsp;Alterar Dados do Usuário</h4>
									</div>
									<div class="modal-body">
										<input type="hidden" name="id" id="id" />
										<div class="col-xs-12">
											<div class="col-xs-5"> <label> Nome </label> </div>
											<div class="col-xs-7"> <label> Sobrenome </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-5">
												<input class="form-control compr" id="primeiro_nome" name="primeiro_nome" type="text" placeholder="Nome do usuário" required="required">                                           
											</div>
											<div></div>
											<div class="col-xs-7">
												<input placeholder="Sobrenome do usuário"  id="sobrenome" name="sobrenome" type="text" class="form-control compr" data-mask="" required>
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
												<input class="form-control compr" id="email" name="email" type="email" placeholder="Email do usuário" required>
											</div>
											<div></div>
											<div class="col-xs-5">
												<input class="form-control telefone_principal compr" id="telefone_principal" name="telefone_principal" type="phone" placeholder="Telefone principal do usuário" required>
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
												<input class="form-control telefone_alternativo compr" id="telefone_alternativo" name="telefone_alternativo" type="phone" placeholder="Telefone alternativo do usuário">
											</div>
											<div></div>
											<div class="col-xs-6">
												<input class="form-control celular compr" id="celular" name="celular" type="phone" placeholder="Telefone celular do usuário">
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-4"> <label> Tipo de Conta </label> </div>
											<div class="col-xs-5"> <label> Comprador Associado </label> </div>
											<div class="col-xs-3"> <label> Em Uso </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-4">
												<select class="form-control" id="tipo" name="tipo" title="O tipo da conta define os privilégios do usuário">
													<option value="-1" selected>Selecione um tipo de conta</option>
													<option value="0">Administrador</option>
													<option value="1">Comprador</option>
													<option value="2">Operário</option>
												</select>
											</div>
											<div class="col-xs-5">
												<select class="form-control" id="compradores_id" name="compradores_id" title="Comprador associado a essa conta">
													<option value="-1" selected>Selecione um comprador para ser associado a essa conta</option>
												</select>
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
										<button type="button" class="btn btn-default" data-dismiss="modal" id="btFecharAlterarUsuario">Cancelar</button> 
										<input type="button" id="btAlterarUsuario" class="btn btn-primary" value="Salvar Alterações" />
									</div>
								</form>
							</div>
						</div>
					</div>
					
					<script src="<?php echo base_url("system/utils/js/usuarios.js"); ?>"></script>
				</div>
			</div>
		</div>
	</div>
</div>