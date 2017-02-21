var table = "";
var originalData, leituras;

function modalExcluirEstatistica () {
	$("#tblEstatisticas tbody").on("click", ".btn-excluir", function () {
		var data = table.row($(this).parents('tr')).data();
		$("#spanNomeEstatistica").html("<br>" + data["nome"]);
		$("#id").val(data["id"]);
	});
}


function modalAlterarEstatistica () {
	$("#tblEstatisticas tbody").on("click", ".btn-alterar", function () {
		var data = table.row($(this).parents('tr')).data();
		originalData = data;
		$('#formAlterarEstatistica #id').val(data["id"]);
		$('#formAlterarEstatistica #nome').val(data["nome"]);
		$('#formAlterarEstatistica #valor_padrao_min').val(data["valor_padrao_min"]);
		$('#formAlterarEstatistica #valor_padrao_max').val(data["valor_padrao_max"]);
		$('#formAlterarEstatistica #unidade_de_medida').val(data["unidade_de_medida"]);
		$('#formAlterarEstatistica #pin').val(data["pin"]);
		$('#formAlterarEstatistica #variacao').val(data["variacao"]);
		
		for (var i = 0; i < leituras.length; i++) {
			if (leituras[i]['codigo'] === data["leitura_codigo"]) {
				$('#formAlterarEstatistica #leitura_codigo').val(i).trigger('change');
				break;
			}
		}
		
		$('#formAlterarEstatistica #leitura_expressao').val(data["leitura_expressao"]);
		
		if (data["em_uso"] != 0) {
			$('#formAlterarEstatistica .em_uso_toggle').addClass('usando').removeClass('nao_usando').text("SIM");
			$('#formAlterarEstatistica #em_uso').val(1);
		} else {
			$('#formAlterarEstatistica .em_uso_toggle').addClass('nao_usando').removeClass('usando').text("NÃO");
			$('#formAlterarEstatistica #em_uso').val(0);
		}
	});
}

$(document).ready(function () {
	$("#erro").hide();
	$("#sucesso").hide();

	$(".close, .fechar").click(function () {
		$('.open-message').fadeOut('slow');
	});
	
	modalExcluirEstatistica();
	modalAlterarEstatistica();
	
	$.ajax({
		url: "estatisticas/SelecionarLeituras/",
		type: "POST",
		success: function (data) {
			var json = $.parseJSON(data);
			leituras = json.data;
			if (leituras.length === 0) {
				$("#msg_erro").html("Nenhuma leitura cadastrada!");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
			
			for (var i = 0; i < leituras.length; i++) {
				$('#formCadastrarEstatistica #leitura_codigo').append($("<option value=" + i + ">" + leituras[i]["descricao"] + "</option>"));
				$('#formAlterarEstatistica #leitura_codigo').append($("<option value=" + i + ">" + leituras[i]["descricao"] + "</option>"));
			}
			
		},
		error: function(data) {
			$("#msg_erro").html("Falha ao recuperar os servidores locais cadastrados!<br />Problema de comunicação com o banco de dados.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
		}
	});

	$('.dataTables_filter').show();

	table = $('#tblEstatisticas').DataTable({
		"oLanguage": {
			"sEmptyTable": "Nenhum registro encontrado.",
			"sInfo": "_TOTAL_ registros",
			"sInfoEmpty": "0 Registros",
			"sInfoFiltered": "(De _MAX_ registros)",
			"sInfoPostFix": "",
			"sInfoThousands": ".",
			"sLengthMenu": "Mostrar _MENU_ registros por página",
			"sLoadingRecords": "Carregando...",
			"sProcessing": "Processando...",
			"sZeroRecords": "Nenhum registro encontrado.",
			"sSearch": "Pesquisar:",
			"oPaginate": {
				"sNext": "Próximo",
				"sPrevious": "Anterior",
				"sFirst": "Primeiro",
				"sLast": "Último"
			}
		},
		"ajax": {
			"url": "estatisticas/SelecionarTudo/",
			"error": function() {
				$("#msg_erro").html("Falha ao recuperar as estatisticas!<br />Problema de comunicação com o servidor local.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		},
		"columnDefs": [
			{
				"targets": [0], /* Campo para esconder as colunas pelo índice */
				"visible": false,
				"searchable": false
			},
			{
				"targets": 8, /* número de colunas com dados */
				"data": null,
				"defaultContent": "<a href='#alterarEstatistica' data-toggle='modal' id='modal-30777' role='button' class='btn btn-success btn-alterar'><i class='glyphicon glyphicon-pencil' title='Atualizar Informações da Estatística'></i></a>&nbsp<a href='#excluirEstatistica' data-toggle='modal' id='modal-30777' role='button' class='btn btn-success btn-excluir'><i class='glyphicon glyphicon-remove' title='Excluir a Estatística'></i></a>"
			}
		],
		"columns": [{"data": "id"}, {"data": "nome"}, {"data": "valor_padrao_min_und"}, {"data": "valor_padrao_max_und"}, {"data": "variacao_und"}, {"data": "pin"}, {"data": "leitura_codigo"}, {"data": "em_uso"}],
		"fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			$('td:nth-child(8)', nRow).addClass('action');
			var tdUso = $('td:nth-child(7)', nRow).addClass('noselect').addClass('uso-td');
			if (aData['em_uso'] == 0) {
				$('td', nRow).css('color', 'red');
				tdUso.addClass('nao_usando-td').text('NÃO');
			} else {
				$('td', nRow).css('color', 'green');
				tdUso.addClass('usando-td').text('SIM');
			}
		}
	});

	if ($('#connection_status').children('i').hasClass('local_server_off')) {
		$("#msg_erro").html("Aparentemente você não está conectado a um servidor local. Dados como estatísticas e controles requerem essa conexão.");
		$('#erro').fadeIn('slow').addClass('open-message');
		$('html, body').animate({scrollTop: 0}, 'slow');
	}
	
	$("#cadastrarEstatistica").click(function () {
		if (!document.getElementById('formCadastrarEstatistica').checkValidity()) {
			$("#msg_erro").html("Falha ao cadastrar a estatística!<br />Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		var nome = $('#formCadastrarEstatistica #nome').val();
		var valor_padrao_min = $('#formCadastrarEstatistica #valor_padrao_min').val();
		var valor_padrao_max = $('#formCadastrarEstatistica #valor_padrao_max').val();
		var unidade_de_medida = $('#formCadastrarEstatistica #unidade_de_medida').val();
		var em_uso = $('#formCadastrarEstatistica #em_uso').val();
		var pin = $('#formCadastrarEstatistica #pin').val();
		var variacao = $('#formCadastrarEstatistica #variacao').val();
		var leitura_codigoIndex = $('#formCadastrarEstatistica #leitura_codigo').val();
		var leitura_expressao = $('#formCadastrarEstatistica #leitura_expressao').val();
		var leitura_codigo;
		
		if (valor_padrao_min > valor_padrao_max) {
			$("#msg_erro").html("Falha ao cadastrar a estatística!<br />O valor padrão mínimo deve ser menor que o máximo.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		if (variacao <= 0) {
			$("#msg_erro").html("Falha ao cadastrar a estatística!<br />A variação mínima deve ser maior que 0.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		if (leitura_codigoIndex >= 0 && leitura_codigoIndex < leituras.length) {
			leitura_codigo = leituras[leitura_codigoIndex]['codigo'];
			if (leitura_codigo != "ANALOG_READ")
				leitura_expressao = "";
		} else {
			$("#msg_erro").html("Falha ao cadastrar a estatística!<br />Por favor, escolha um tipo de leitura.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}

		$.ajax({
			url: "estatisticas/Cadastrar",
			type: "POST",
			data: {
				nome: nome,
				valor_padrao_min: valor_padrao_min,
				valor_padrao_max: valor_padrao_max,
				unidade_de_medida: unidade_de_medida,
				em_uso: em_uso,
				pin: pin,
				variacao: variacao,
				leitura_codigo: leitura_codigo,
				leitura_expressao: leitura_expressao
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharExcluirEstatistica").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Estatística cadastrada com sucesso!");
					$('#sucesso').fadeIn('slow').addClass('open-message');
					table.ajax.reload();
					$('html, body').animate({scrollTop: 0}, 'slow');
					$('#resetarEstatistica').trigger('click');
				} else {
					var error = "";
					switch (json.result) {
						case 'errorL':
							error = "Sessão expirada! Por favor, faça login novamente.";
							break;
						case 'errorT':
							error = "Você não tem permissão para gerenciar estatisticas.";
							break;
						case 'errorF':
							error = "Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.";
							break;
						case 'errorP':
							error = "O plano da sua empresa não foi encontrado ou está vencido.";
							break;
						case 'errorE':
							error = "O limite de estatísticas foi atingido. Por favor, contrate um plano maior para ter controle sobre mais estatísticas.";
							break;
						default:
							error = "Problema de comunicação com o servidor local.";
							break;
					}
					
					$("#msg_erro").html("Falha ao cadastrar a estatística!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao cadastrar a estatística!<br />Problema de comunicação com o servidor local.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});

	$("#btExcluirEstatistica").click(function () {
		var id = $('#formExcluirEstatistica #id').val();
		$.ajax({
			url: "estatisticas/Excluir",
			type: "POST",
			data: {
				id: id
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharExcluirEstatistica").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Estatística excluída com sucesso!");
					$('#sucesso').fadeIn('slow').addClass('open-message');
					table.ajax.reload();
					$('html, body').animate({scrollTop: 0}, 'slow');
				} else {
					var error = "";
					switch (json.result) {
						case 'errorL':
							error = "Sessão expirada! Por favor, faça login novamente.";
							break;
						case 'errorT':
							error = "Você não tem permissão para gerenciar estatisticas.";
							break;
						default:
							error = "Não é possível excluir uma estatística que possua registros.";
							break;
					}
					$("#msg_erro").html("Falha ao excluir a estatística!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao excluir a estatística!<br />Problema de comunicação com o servidor local.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});

	$("#btAlterarEstatistica").click(function () {
		if (!document.getElementById('formAlterarEstatistica').checkValidity()) {
			$("#msg_erro").html("Falha ao alterar a estatística!<br />Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		var id = $('#formAlterarEstatistica #id').val();
		var nome = $('#formAlterarEstatistica #nome').val();
		var valor_padrao_min = $('#formAlterarEstatistica #valor_padrao_min').val();
		var valor_padrao_max = $('#formAlterarEstatistica #valor_padrao_max').val();
		var unidade_de_medida = $('#formAlterarEstatistica #unidade_de_medida').val();
		var em_uso = $('#formAlterarEstatistica #em_uso').val();
		var pin = $('#formAlterarEstatistica #pin').val();
		var variacao = $('#formAlterarEstatistica #variacao').val();
		var leitura_codigoIndex = $('#formAlterarEstatistica #leitura_codigo').val();
		var leitura_expressao = $('#formAlterarEstatistica #leitura_expressao').val();
		var leitura_codigo;
		
		if (valor_padrao_min > valor_padrao_max) {
			$("#msg_erro").html("Falha ao alterar a estatística!<br />O valor padrão mínimo deve ser menor que o máximo.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		if (variacao <= 0) {
			$("#msg_erro").html("Falha ao alterar a estatística!<br />A variação mínima deve ser maior que 0.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		if (leitura_codigoIndex >= 0 && leitura_codigoIndex < leituras.length) {
			leitura_codigo = leituras[leitura_codigoIndex]['codigo'];
			if (leitura_codigo != "ANALOG_READ")
				leitura_expressao = "";
		} else {
			$("#msg_erro").html("Falha ao alterar a estatística!<br />Por favor, escolha um tipo de leitura.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		if (nome == originalData["nome"] && valor_padrao_min == originalData["valor_padrao_min"] && valor_padrao_max == originalData["valor_padrao_max"] && unidade_de_medida == originalData["unidade_de_medida"] && pin == originalData["pin"] && em_uso == originalData["em_uso"] && variacao == originalData["variacao"] && leitura_codigo == originalData["leitura_codigo"] && leitura_expressao == originalData["leitura_expressao"]) {
			$("#msg_erro").html("Falha ao alterar a estatística!<br />Os valores informados são iguais aos já cadastrados.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		$.ajax({
			url: "estatisticas/Atualizar",
			type: "POST",
			data: {
				id: id,
				nome: nome,
				valor_padrao_min: valor_padrao_min,
				valor_padrao_max: valor_padrao_max,
				unidade_de_medida: unidade_de_medida,
				em_uso: em_uso,
				pin: pin,
				variacao: variacao,
				leitura_codigo: leitura_codigo,
				leitura_expressao: leitura_expressao
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharAlterarEstatistica").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Estatística alterada com sucesso!");
					$('#sucesso').fadeIn('slow').addClass('open-message');
					table.ajax.reload();
					$('html, body').animate({scrollTop: 0}, 'slow');
				} else {
					var error = "";
					switch (json.result) {
						case 'errorL':
							error = "Sessão expirada! Por favor, faça login novamente.";
							break;
						case 'errorT':
							error = "Você não tem permissão para gerenciar estatisticas.";
							break;
						case 'errorF':
							error = "Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.";
							break;
						default:
							error = "Problema de comunicação com o servidor local.";
							break;
					}
					
					$("#msg_erro").html("Falha ao alterar a estatística!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao alterar a estatística!<br />Problema de comunicação com o servidor local.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});
	
	$('#resetarEstatistica').click(function () {
		$('.em_uso_toggle').each(function(index, element) {
			if (!$(this).hasClass('usando'))
				$(this).trigger('click');
		});
	});
	
	$('.em_uso_toggle').click(function(e) {
		if ($(this).hasClass('usando')) {
			$(this).text("NÃO");
			$(this).prev('#em_uso').val(0);
		} else {
			$(this).text("SIM");
			$(this).prev('#em_uso').val(1);
		}
		
		$(this).toggleClass('usando');
		$(this).toggleClass('nao_usando');
	});
	
	$('#formCadastrarEstatistica #leitura_codigo').change(function () {
		var i = $(this).val();
		if (i >= 0 && i < leituras.length) {
			var leitura_codigo = leituras[i]['codigo'];
			if (leitura_codigo == "ANALOG_READ") {
				$('#formCadastrarEstatistica #leitura_expressao').removeAttr('disabled', '');
				$('#formCadastrarEstatistica #leitura_expressao').val(leituras[i]['expressao']);
			} else {
				$('#formCadastrarEstatistica #leitura_expressao').val('');
				$('#formCadastrarEstatistica #leitura_expressao').attr('disabled', '');
			}
		} else {
			$('#formCadastrarEstatistica #leitura_expressao').attr('disabled', '');
		}
	}).trigger('change');
	
	$('#formAlterarEstatistica #leitura_codigo').change(function () {
		var i = $(this).val();
		if (i >= 0 && i < leituras.length) {
			var leitura_codigo = leituras[i]['codigo'];
			if (leitura_codigo == "ANALOG_READ") {
				$('#formAlterarEstatistica #leitura_expressao').removeAttr('disabled', '');
				$('#formAlterarEstatistica #leitura_expressao').val(leituras[i]['expressao']);
			} else {
				$('#formAlterarEstatistica #leitura_expressao').val('');
				$('#formAlterarEstatistica #leitura_expressao').attr('disabled', '');
			}
		} else {
			$('#formAlterarEstatistica #leitura_expressao').attr('disabled', '');
		}
	}).trigger('change');
});