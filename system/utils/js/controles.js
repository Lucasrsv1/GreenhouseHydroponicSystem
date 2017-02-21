var table = "";
var originalData, leituras;

function modalExcluirControle () {
	$("#tblControles tbody").on("click", ".btn-excluir", function () {
		var data = table.row($(this).parents('tr')).data();
		$("#spanNomeControle").html("<br>" + data["rele_nome"]);
		$("#id").val(data["id"]);
	});
}


function modalAlterarControle () {
	$("#tblControles tbody").on("click", ".btn-alterar", function () {
		var data = table.row($(this).parents('tr')).data();
		originalData = data;
		$('#formAlterarControle #id').val(data["id"]);
		$('#formAlterarControle #nome').val(data["rele_nome"]);
		$('#formAlterarControle #pin').val(data["rele_pin"]);
		$('#formAlterarControle #variacao').val(data["variacao"]);
		
		if (data["estado"] != 0) {
			$('#formAlterarControle .estado_toggle').addClass('usando').removeClass('nao_usando').text("LIGADO");
			$('#formAlterarControle #estado').val(1);
		} else {
			$('#formAlterarControle .estado_toggle').addClass('nao_usando').removeClass('usando').text("DESLIGADO");
			$('#formAlterarControle #estado').val(0);
		}
		
		if (data["em_uso"] != 0) {
			$('#formAlterarControle .em_uso_toggle').addClass('usando').removeClass('nao_usando').text("SIM");
			$('#formAlterarControle #em_uso').val(1);
		} else {
			$('#formAlterarControle .em_uso_toggle').addClass('nao_usando').removeClass('usando').text("NÃO");
			$('#formAlterarControle #em_uso').val(0);
		}
	});
}

$(document).ready(function () {
	$("#erro").hide();
	$("#sucesso").hide();

	$(".close, .fechar").click(function () {
		$('.open-message').fadeOut('slow');
	});
	
	modalExcluirControle();
	modalAlterarControle();

	$('.dataTables_filter').show();

	table = $('#tblControles').DataTable({
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
			"url": "controles/SelecionarTudo/",
			"error": function() {
				$("#msg_erro").html("Falha ao recuperar os controles!<br />Problema de comunicação com o servidor local.");
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
				"targets": 6, /* número de colunas com dados */
				"data": null,
				"defaultContent": "<a href='#alterarControle' data-toggle='modal' id='modal-30777' role='button' class='btn btn-success btn-alterar'><i class='glyphicon glyphicon-pencil' title='Atualizar Informações do Controle'></i></a>&nbsp<a href='#excluirControle' data-toggle='modal' id='modal-30777' role='button' class='btn btn-success btn-excluir'><i class='glyphicon glyphicon-remove' title='Excluir o Controle'></i></a>"
			}
		],
		"columns": [{"data": "id"}, {"data": "rele_nome"}, {"data": "rele_pin"}, {"data": "estado"}, {"data": "ultima_atualizacao_formatada"}, {"data": "em_uso"}],
		"fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			$('td:nth-child(6)', nRow).addClass('action');
			var tdUso = $('td:nth-child(5)', nRow).addClass('noselect').addClass('uso-td');
			var tdEstado = $('td:nth-child(3)', nRow).addClass('noselect').addClass('uso-td');
			
			if (aData['em_uso'] == 0) {
				$('td', nRow).css('color', 'red');
				tdUso.addClass('nao_usando-td').text('NÃO');
			} else {
				$('td', nRow).css('color', 'green');
				tdUso.addClass('usando-td').text('SIM');
			}
			
			if (aData['estado'] == 0)
				tdEstado.addClass('nao_usando-td').text('DESLIGADO');
			else
				tdEstado.addClass('usando-td').text('LIGADO');
		}
	});

	if ($('#connection_status').children('i').hasClass('local_server_off')) {
		$("#msg_erro").html("Aparentemente você não está conectado a um servidor local. Dados como estatísticas e controles requerem essa conexão.");
		$('#erro').fadeIn('slow').addClass('open-message');
		$('html, body').animate({scrollTop: 0}, 'slow');
	}
	
	$("#cadastrarControle").click(function () {
		if (!document.getElementById('formCadastrarControle').checkValidity()) {
			$("#msg_erro").html("Falha ao cadastrar o controle!<br />Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		var nome = $('#formCadastrarControle #nome').val();
		var pin = $('#formCadastrarControle #pin').val();
		var estado = $('#formCadastrarControle #estado').val();
		var em_uso = $('#formCadastrarControle #em_uso').val();

		$.ajax({
			url: "controles/Cadastrar",
			type: "POST",
			data: {
				nome: nome,
				pin: pin,
				estado: estado,
				em_uso: em_uso
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharExcluirControle").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Controle cadastrado com sucesso!");
					$('#sucesso').fadeIn('slow').addClass('open-message');
					table.ajax.reload();
					$('html, body').animate({scrollTop: 0}, 'slow');
					$('#resetarControle').trigger('click');
				} else {
					var error = "";
					switch (json.result) {
						case 'errorL':
							error = "Sessão expirada! Por favor, faça login novamente.";
							break;
						case 'errorT':
							error = "Você não tem permissão para gerenciar controles.";
							break;
						case 'errorF':
							error = "Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.";
							break;
						case 'errorP':
							error = "O plano da sua empresa não foi encontrado ou está vencido.";
							break;
						case 'errorC':
							error = "O limite de controles foi atingido. Por favor, contrate um plano maior para ter controle sobre mais aparelhos.";
							break;
						default:
							error = "Problema de comunicação com o servidor local.";
							break;
					}
					
					$("#msg_erro").html("Falha ao cadastrar o controle!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao cadastrar o controle!<br />Problema de comunicação com o servidor local.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});

	$("#btExcluirControle").click(function () {
		var id = $('#formExcluirControle #id').val();
		$.ajax({
			url: "controles/Excluir",
			type: "POST",
			data: {
				id: id
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharExcluirControle").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Controle excluído com sucesso!");
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
							error = "Você não tem permissão para gerenciar controles.";
							break;
						default:
							error = "Não é possível excluir um controle que possua registros.";
							break;
					}
					$("#msg_erro").html("Falha ao excluir o controle!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function() {
				$("#msg_erro").html("Falha ao excluir o controle!<br />Problema de comunicação com o servidor local.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});

	$("#btAlterarControle").click(function () {
		if (!document.getElementById('formAlterarControle').checkValidity()) {
			$("#msg_erro").html("Falha ao alterar o controle!<br />Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		var id = $('#formAlterarControle #id').val();
		var nome = $('#formAlterarControle #nome').val();
		var pin = $('#formAlterarControle #pin').val();
		var estado = $('#formAlterarControle #estado').val();
		var em_uso = $('#formAlterarControle #em_uso').val();
		
		if (nome == originalData["nome"] && pin == originalData["pin"] && estado == originalData["estado"] && em_uso == originalData["em_uso"]) {
			$("#msg_erro").html("Falha ao cadastrar o controle!<br />Os valores informados são iguais aos já cadastrados.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		$.ajax({
			url: "controles/Atualizar",
			type: "POST",
			data: {
				id: id,
				nome: nome,
				pin: pin,
				estado: estado,
				em_uso: em_uso
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharAlterarControle").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Controle alterado com sucesso!");
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
							error = "Você não tem permissão para gerenciar controles.";
							break;
						case 'errorF':
							error = "Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.";
							break;
						default:
							error = "Problema de comunicação com o servidor local.";
							break;
					}
					
					$("#msg_erro").html("Falha ao alterar o controle!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao alterar o controle!<br />Problema de comunicação com o servidor local.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});
	
	$('#resetarControle').click(function () {
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
	
	$('.estado_toggle').click(function(e) {
		if ($(this).hasClass('usando')) {
			$(this).text("DESLIGADO");
			$(this).prev('#estado').val(0);
		} else {
			$(this).text("LIGADO");
			$(this).prev('#estado').val(1);
		}
		
		$(this).toggleClass('usando');
		$(this).toggleClass('nao_usando');
	});
});