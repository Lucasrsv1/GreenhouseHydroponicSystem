var table = "";
var originalData;

function modalExcluirServidor_Local () {
	$("#tblServidores_Locais tbody").on("click", ".btn-excluir", function () {
		var data = table.row($(this).parents('tr')).data();
		$("#spanNomeServidor_Local").html("<br>" + data["descricao"]);
		$("#id").val(data["id"]);
	});
}


function modalAlterarServidor_Local () {
	$("#tblServidores_Locais tbody").on("click", ".btn-alterar", function () {
		var data = table.row($(this).parents('tr')).data();
		originalData = data;
		$('#formAlterarServidor_Local #id').val(data["id"]);
		$('#formAlterarServidor_Local #descricao').val(data["descricao"]);
		$('#formAlterarServidor_Local #servidor_conexao').val(data["servidor_conexao"]);
		$('#formAlterarServidor_Local #servidor_usuario').val(data["servidor_usuario"]);
		$('#formAlterarServidor_Local #servidor_senha').val(data["servidor_senha"]);
		$('#formAlterarServidor_Local #confirmaSenha').val(data["servidor_senha"]);
		
		if (data["em_uso"] != 0) {
			$('#formAlterarServidor_Local .em_uso_toggle').addClass('usando').removeClass('nao_usando').text("SIM");
			$('#formAlterarServidor_Local #em_uso').val(1);
		} else {
			$('#formAlterarServidor_Local .em_uso_toggle').addClass('nao_usando').removeClass('usando').text("NÃO");
			$('#formAlterarServidor_Local #em_uso').val(0);
		}  
	});
}

$(document).ready(function () {
	$("#erro").hide();
	$("#sucesso").hide();

	$(".close, .fechar").click(function () {
		$('.open-message').fadeOut('slow');
	});
	
	modalExcluirServidor_Local();
	modalAlterarServidor_Local();

	$('.dataTables_filter').show();

	table = $('#tblServidores_Locais').DataTable({
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
			"url": "servidores_locais/SelecionarTudo/",
			error: function(data) {
				$("#msg_erro").html("Falha ao recuperar os servidores locais cadastrados!<br />Problema de comunicação com o banco de dados.");
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
				"defaultContent": "<a href='#alterarServidor_Local' data-toggle='modal' id='modal-30777' role='button' class='btn btn-success btn-alterar'><i class='glyphicon glyphicon-pencil' title='Atualizar Informações do Servidor Local'></i></a>"
			}
		],
		"columns": [{"data": "id"}, {"data": "descricao"}, {"data": "MAC"}, {"data": "servidor_conexao"}, {"data": "servidor_usuario"}, {"data": "em_uso"}],
		"fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			$('td:nth-child(6)', nRow).addClass('action');
			var tdUso = $('td:nth-child(5)', nRow).addClass('noselect').addClass('uso-td');
			if (aData['em_uso'] == 0) {
				$('td', nRow).css('color', 'red');
				tdUso.addClass('nao_usando-td').text('NÃO');
			} else {
				$('td', nRow).css('color', 'green');
				tdUso.addClass('usando-td').text('SIM');
			}
		}
	});


	$("#cadastrarServidor_Local").click(function () {
		if (!document.getElementById('formCadastrarServidor_Local').checkValidity()) {
			$("#msg_erro").html("Falha ao cadastrar o servidor local!<br />Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		var descricao = $('#formCadastrarServidor_Local #descricao').val();
		var MAC = $('#formCadastrarServidor_Local #MAC').val();
		var servidor_conexao = $('#formCadastrarServidor_Local #servidor_conexao').val();
		var servidor_usuario = $('#formCadastrarServidor_Local #servidor_usuario').val();
		var servidor_senha = $('#formCadastrarServidor_Local #servidor_senha').val();
		var confirmaSenha = $('#formCadastrarServidor_Local #confirmaSenha').val();
		var em_uso = $('#formCadastrarServidor_Local #em_uso').val();
		
		if (servidor_senha != confirmaSenha) {
			$("#msg_erro").html("Falha ao cadastrar o servidor local!<br />As senhas digitadas não conferem.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}

		$.ajax({
			url: "servidores_locais/Cadastrar",
			type: "POST",
			data: {
				descricao: descricao,
				MAC: MAC,
				servidor_conexao: servidor_conexao,
				servidor_usuario: servidor_usuario,
				servidor_senha: servidor_senha,
				em_uso: em_uso
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharExcluirServidor_Local").click();
				console.log(data);
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Servidor Local cadastrado com sucesso!");
					$('#sucesso').fadeIn('slow').addClass('open-message');
					table.ajax.reload();
					$('html, body').animate({scrollTop: 0}, 'slow');
					$('#resetarServidor_Local').trigger('click');
				} else {
					var error = "";
					switch (json.result) {
						case 'errorL':
							error = "Sessão expirada! Por favor, faça login novamente.";
							break;
						case 'errorT':
							error = "Você não tem permissão para gerenciar servidores locais.";
							break;
						case 'errorF':
							error = "Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.";
							break;
						case 'errorP':
							error = "O plano da sua empresa não foi encontrado ou está vencido.";
							break;
						case 'errorM':
							error = "O limite de servidores locais foi atingido. Por favor, contrate um plano maior para ter controle sobre mais estufas.";
							break;
						case 'errorMAC':
							error = "Um servidor com esse endereço MAC já foi registrado.";
							break;
						default:
							error = "Problema de comunicação com o banco de dados.";
							break;
					}
					
					$("#msg_erro").html("Falha ao cadastrar o servidor local!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao cadastrar o servidor local!<br />Problema de comunicação com o banco de dados.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});

	$("#btAlterarServidor_Local").click(function () {
		if (!document.getElementById('formAlterarServidor_Local').checkValidity()) {
			$("#msg_erro").html("Falha ao alterar o servidor local!<br />Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		var id = $('#formAlterarServidor_Local #id').val();
		var descricao = $('#formAlterarServidor_Local #descricao').val();
		var servidor_conexao = $('#formAlterarServidor_Local #servidor_conexao').val();
		var servidor_usuario = $('#formAlterarServidor_Local #servidor_usuario').val();
		var servidor_senha = $('#formAlterarServidor_Local #servidor_senha').val();
		var confirmaSenha = $('#formAlterarServidor_Local #confirmaSenha').val();
		var em_uso = $('#formAlterarServidor_Local #em_uso').val();
		
		if (servidor_senha != confirmaSenha) {
			$("#msg_erro").html("Falha ao cadastrar o servidor local!<br />As senhas digitadas não conferem.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		if (descricao == originalData["descricao"] && servidor_conexao == originalData["servidor_conexao"] && servidor_usuario == originalData["servidor_usuario"] && servidor_senha == originalData["servidor_senha"] && em_uso == originalData["em_uso"]) {
			$("#msg_erro").html("Falha ao alterar o servidor local!<br />Os valores informados são iguais aos já cadastrados.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		$.ajax({
			url: "servidores_locais/Atualizar",
			type: "POST",
			data: {
				id: id,
				descricao: descricao,
				servidor_conexao: servidor_conexao,
				servidor_usuario: servidor_usuario,
				servidor_senha: servidor_senha,
				em_uso: em_uso
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharAlterarServidor_Local").click();
				console.log(data);
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Servidor Local alterado com sucesso!");
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
							error = "Você não tem permissão para gerenciar servidores locais.";
							break;
						case 'errorF':
							error = "Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.";
							break;
						default:
							error = "Problema de comunicação com o banco de dados.";
							break;
					}
					
					$("#msg_erro").html("Falha ao alterar o servidor local!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao alterar o servidor Local!<br />Problema de comunicação com o banco de dados.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});
	
	$('#resetarServidor_Local').click(function () {
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
});