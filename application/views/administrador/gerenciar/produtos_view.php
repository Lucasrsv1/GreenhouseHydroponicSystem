<div>
	<div class="page-title">
		<div class="title_left no_search">
			<h3>Gerenciar Produtos</h3>
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
								<p id="msg_acerto">Produto excluído com sucesso!</p>
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
								<p id="msg_erro">Falha ao excluir produto!</p>
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
									<a href="#panel-168546" data-toggle="tab" id="tab_lista_produtos">Listagem de Produtos</a>
								</li>
								<li>
									<a href="#panel-190060" data-toggle="tab" id="tab_cadastra_produtos">Cadastrar Novo Produto</a>
								</li>                            
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="panel-168546">
									<br />
									<h2> Todos os produtos cadastrados </h2>
									<br />
									<table id="tblProdutos" class="table table-striped table-bordered" cellspacing="0" width="100%" >
										<thead>
											<tr>
												<th class="hide">Id</th>
												<th>Nome</th>
												<th>Unidade de Medida</th>
												<th>Preço Padrão da Unidade</th>
												<th>Estoque</th>
												<th>Em Uso</th>
												<th class="action">Ação</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
									<br />
									<br />
									<b>Legenda:</b>&nbsp&nbsp;<span style="color:green;">Produtos Ativos&nbsp&nbsp;</span><span style="color:red;">&nbsp&nbsp;Produtos Inativos</span>
								</div>
								<div class="tab-pane" id="panel-190060">
									<br />
									<h2>Novo Produto</h2>
									<br />
									<form method="post" onSubmit="$('#cadastrarProduto').trigger('click'); return false;" id="formCadastrarProduto">
										<div class="col-xs-12">
											<div class="col-xs-7"> <label> Nome </label> </div>
											<div class="col-xs-3"> <label> Unidade de Medida </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-7">
												<input class="form-control" id="nome" name="nome" type="text" placeholder="Nome do produto" required="required">
											</div>
											<div class="col-xs-3">
												<input class="form-control" id="unidade_medida" name="unidade_medida" type="text" placeholder="Unidade de medida do produto" required="required">
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-4"> <label> Preço Padrão da Unidade </label> </div>
											<div class="col-xs-4"> <label> Estoque </label> </div>
											<div class="col-xs-4"> <label> Em Uso </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-4">
												<input placeholder="Preço padrão da unidade do produto"  id="preco_unitario_padrao" name="preco_unitario_padrao" type="number" step="any" min="0" class="form-control" required>
											</div>
											<div class="col-xs-4">
												<input class="form-control" id="estoque" name="estoque" type="number" step="any" min="0" placeholder="Estoque do produto" required>
											</div>
											<div></div>
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
												<button type="button" class="btn btn-primary " id="cadastrarProduto">
													<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Cadastrar Produto
												</button>   
											</div> 
											<div class="col-xs-4">                                            
												<button type="reset" class="btn btn-primary" id="resetarProduto">
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
					<div class="modal fade" id="excluirProduto" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="post" onSubmit="return false;" id="formExcluirProduto">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModalLabel">Excluir Produto</h4>
									</div>
									<div class="modal-body">
										<input type="hidden" id="id" name="id" />
										Tem certeza que deseja excluir o produto? <b><span id="spanNomeProduto"></span></b>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal" id="btFecharExcluirProduto">Fechar</button>
										<input type="button" id="btExcluirProduto" class="btn btn-primary" value="Excluir" />
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				
				<div class="col-md-12 column">
					<div class="modal fade" id="alterarProduto" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="post" onSubmit="$('#btAlterarProduto').trigger('click'); return false;" id="formAlterarProduto">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModalLabel">&emsp;Alterar Dados do Produto</h4>
									</div>
									<div class="modal-body">
										<input type="hidden" name="id" id="id" />
										<div class="col-xs-12">
											<div class="col-xs-8"> <label> Nome </label> </div>
											<div class="col-xs-4"> <label> Unidade de medida </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-8">
												<input class="form-control" id="nome" name="nome" type="text" placeholder="Nome do produto" required="required">                                           
											</div>
											<div></div>
											<div class="col-xs-4">
												<input class="form-control" id="unidade_medida" name="unidade_medida" type="text" placeholder="Unidade de medida do produto" required="required">
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-4"> <label> Preço Padrão da Unidade </label> </div>
											<div class="col-xs-4"> <label> Estoque </label> </div>
											<div class="col-xs-4"> <label> Em Uso </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-4">
												<input placeholder="Preço padrão da unidade do produto"  id="preco_unitario_padrao" name="preco_unitario_padrao" type="number" step="any" min="0" class="form-control" required>
											</div>
											<div class="col-xs-4">
												<input class="form-control" id="estoque" name="estoque" type="number"  step="any" min="0" placeholder="Estoque do produto" required>
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
										<button type="button" class="btn btn-default" data-dismiss="modal" id="btFecharAlterarProduto">Cancelar</button> 
										<input type="button" id="btAlterarProduto" class="btn btn-primary" value="Salvar Alterações" />
									</div>
								</form>
							</div>
						</div>
					</div>
					
					<script src="<?php echo base_url("system/utils/js/produtos.js"); ?>"></script>
				</div>
			</div>
		</div>
	</div>
</div>