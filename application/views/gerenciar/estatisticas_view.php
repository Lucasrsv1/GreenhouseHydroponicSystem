<div>
	<div class="page-title">
		<div class="title_left no_search">
			<h3>Gerenciar Estatísticas</h3>
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
								<p id="msg_acerto">Estatística excluída com sucesso!</p>
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
								<p id="msg_erro">Falha ao excluir estatística!</p>
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
									<a href="#panel-168546" data-toggle="tab" id="tab_lista_estatisticas">Listagem de Estatísticas</a>
								</li>
								<li>
									<a href="#panel-190060" data-toggle="tab" id="tab_cadastra_estatisticas">Cadastrar Nova Estatística</a>
								</li>                            
							</ul>
							<div class="tab-content">
								<div class="tab-pane active" id="panel-168546">
									<br />
									<h2> Todas as estatísticas cadastradas </h2>
									<br />
									<table id="tblEstatisticas" class="table table-striped table-bordered" cellspacing="0" width="100%" >
										<thead>
											<tr>
												<th class="hide">Id</th>
												<th>Estatística</th>
												<th>Valor Ideal Min.</th>
												<th>Valor Ideal Max.</th>
												<th>Variação</th>
												<th>Pino</th>
												<th>Tipo de Leitura</th>
												<th>Em Uso</th>
												<th class="action">Ação</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
									<br />
									<br />
									<b>Legenda:</b>&nbsp&nbsp;<span style="color:green;">Estatísticas Ativos&nbsp&nbsp;</span><span style="color:red;">&nbsp&nbsp;Estatísticas Inativos</span>
								</div>
								<div class="tab-pane" id="panel-190060">
									<br />
									<h2>Novo Estatística</h2>
									<br />
									<form method="post" onSubmit="$('#cadastrarEstatistica').trigger('click'); return false;" id="formCadastrarEstatistica">
										<div class="col-xs-12">
											<div class="col-xs-7"> <label> Nome </label> </div>
											<div class="col-xs-4"> <label> Unidade de Medida </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-7">
												<input class="form-control" id="nome" name="nome" type="text" placeholder="Nome da estatística" required>
											</div>
											<div class="col-xs-4">
												<input class="form-control" id="unidade_de_medida" name="unidade_de_medida" type="text" placeholder="Unidade de medida da estatística" required>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-3"> <label> Valor Ideal Min. </label> </div>
											<div class="col-xs-3"> <label> Valor Ideal Max. </label> </div>
											<div class="col-xs-3"> <label> Variação Mínima </label> </div>
											<div class="col-xs-2"> <label> Pino </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-3">
												<input class="form-control" id="valor_padrao_min" name="valor_padrao_min" type="number" step="any" placeholder="Menor valor ideal">
											</div>
											<div class="col-xs-3">
												<input class="form-control" id="valor_padrao_max" name="valor_padrao_max" type="number" step="any" placeholder="Maior valor ideal">
											</div>
											<div class="col-xs-3">
												<input class="form-control" id="variacao" name="variacao" type="number" min="0" step="any" placeholder="Variação mínima" title="Variação mínima necessária para registrar a mudança na estatística">
											</div>
											<div class="col-xs-2">
												<input class="form-control" id="pin" name="pin" type="number" step="1" min="0" placeholder="Pino no Arduino" title="Pino ao qual o sensor está conectado na placa Arduino (OBS.: Não inclua o A dos analógicos)">
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-4"> <label> Tipo de Leitura </label> </div>
											<div class="col-xs-5"> <label> Expressão de Conversão </label> </div>
											<div class="col-xs-3"> <label> Em Uso </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-4">
												<select class="form-control" id="leitura_codigo" name="leitura_codigo" title="Tipo de leitura do sensor">
													<option value="-1" selected>Selecione um tipo de leitura</option>
												</select>
											</div>
											<div class="col-xs-5">
												<input class="form-control" id="leitura_expressao" name="leitura_expressao" type="text" placeholder="Expressão utilizada para converter leituras analógicas" title="Leituras analógicas retornam um valor inteiro de 0 a 1023 representado por R. Ao fazer a leitura, o valor atribuido a estatistica será o resultado dessa expressão. Para um sensor LM35, por exemplo, para uma estatística de temperatura na escala celsius, o valor desse campo deve ser: R / 1024.0 * 500">
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
												<button type="button" class="btn btn-primary " id="cadastrarEstatistica">
													<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Cadastrar Estatística
												</button>   
											</div> 
											<div class="col-xs-4">                                            
												<button type="reset" class="btn btn-primary" id="resetarEstatistica">
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
					<div class="modal fade" id="excluirEstatistica" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="post" onSubmit="return false;" id="formExcluirEstatistica">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModalLabel">Excluir Estatística</h4>
									</div>
									<div class="modal-body">
										<input type="hidden" id="id" name="id" />
										Tem certeza que deseja excluir a estatística? <b><span id="spanNomeEstatistica"></span></b>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal" id="btFecharExcluirEstatistica">Fechar</button>
										<input type="button" id="btExcluirEstatistica" class="btn btn-primary" value="Excluir" />
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				
				<div class="col-md-12 column">
					<div class="modal fade" id="alterarEstatistica" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<form method="post" onSubmit="$('#btAlterarEstatistica').trigger('click'); return false;" id="formAlterarEstatistica">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
										<h4 class="modal-title" id="myModalLabel">&emsp;Alterar Dados da Estatística</h4>
									</div>
									<div class="modal-body">
										<input type="hidden" name="id" id="id" />
										<div class="col-xs-12">
											<div class="col-xs-7"> <label> Nome </label> </div>
											<div class="col-xs-5"> <label> Unidade de Medida </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-7">
												<input class="form-control" id="nome" name="nome" type="text" placeholder="Nome da estatística" required>
											</div>
											<div class="col-xs-5">
												<input class="form-control" id="unidade_de_medida" name="unidade_de_medida" type="text" placeholder="Unidade de medida da estatística" required>
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-3"> <label> Valor Ideal Min. </label> </div>
											<div class="col-xs-3"> <label> Valor Ideal Max. </label> </div>
											<div class="col-xs-3"> <label> Variação Mínima </label> </div>
											<div class="col-xs-3"> <label> Pino </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-3">
												<input class="form-control" id="valor_padrao_min" name="valor_padrao_min" type="number" step="any" placeholder="Menor valor ideal">
											</div>
											<div class="col-xs-3">
												<input class="form-control" id="valor_padrao_max" name="valor_padrao_max" type="number" step="any" placeholder="Maior valor ideal">
											</div>
											<div class="col-xs-3">
												<input class="form-control" id="variacao" name="variacao" type="number" min="0" step="any" placeholder="Variação mínima" title="Variação mínima necessária para registrar a mudança na estatística">
											</div>
											<div class="col-xs-3">
												<input class="form-control" id="pin" name="pin" type="number" step="1" min="0" placeholder="Pino no Arduino" title="Pino ao qual o sensor está conectado na placa Arduino (OBS.: Não inclua o A dos analógicos)">
											</div>
										</div>
										<br />
										<br />
										<br />
										<br />
										<div class="col-xs-12">
											<div class="col-xs-4"> <label> Tipo de Leitura </label> </div>
											<div class="col-xs-5"> <label> Expressão de Conversão </label> </div>
											<div class="col-xs-3"> <label> Em Uso </label> </div>
										</div>
										<div class="col-xs-12">
											<div class="col-xs-4">
												<select class="form-control" id="leitura_codigo" name="leitura_codigo" title="Tipo de leitura do sensor">
													<option value="-1" selected>Selecione um tipo de leitura</option>
												</select>
											</div>
											<div class="col-xs-5">
												<input class="form-control" id="leitura_expressao" name="leitura_expressao" type="text" placeholder="Expressão utilizada para converter leituras analógicas" title="Leituras analógicas retornam um valor inteiro de 0 a 1023 representado por R. Ao fazer a leitura, o valor atribuido a estatistica será o resultado dessa expressão. Para um sensor LM35, por exemplo, para uma estatística de temperatura na escala celsius, o valor desse campo deve ser: R / 1024.0 * 500">
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
										<button type="button" class="btn btn-default" data-dismiss="modal" id="btFecharAlterarEstatistica">Cancelar</button> 
										<input type="button" id="btAlterarEstatistica" class="btn btn-primary" value="Salvar Alterações" />
									</div>
								</form>
							</div>
						</div>
					</div>
					
					<script src="<?php echo base_url("system/utils/js/estatisticas.js"); ?>"></script>
				</div>
			</div>
		</div>
	</div>
</div>