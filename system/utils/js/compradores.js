var table = "";
var originalData;

function CheckPhones () {
	$(".telefones, .telefone_principal, .telefone_alternativo, .celular").each(function(index, element) {
		if ($(element).val().indexOf("_", 0) !== -1)
			$(element).val("");
	});
}

function modalExcluirComprador () {
	$("#tblCompradores tbody").on("click", ".btn-excluir", function () {
		var data = table.row($(this).parents('tr')).data();
		$("#spanNomeComprador").html("<br>" + data["nome_completo"]);
		$("#id").val(data["id"]);
	});
}


function modalAlterarComprador () {
	$("#tblCompradores tbody").on("click", ".btn-alterar", function () {
		var data = table.row($(this).parents('tr')).data();
		originalData = data;
		$('#formAlterarComprador #id').val(data["id"]);
		$('#formAlterarComprador #primeiro_nome').val(data["primeiro_nome"]);
		$('#formAlterarComprador #sobrenome').val(data["sobrenome"]);
		$('#formAlterarComprador #email').val(data["email"]);
		$('#formAlterarComprador #nome_empresa').val(data["nome_empresa"]);
		
		if (data["em_uso"] != 0) {
			$('#formAlterarComprador .em_uso_toggle').addClass('usando').removeClass('nao_usando').text("SIM");
			$('#formAlterarComprador #em_uso').val(1);
		} else {
			$('#formAlterarComprador .em_uso_toggle').addClass('nao_usando').removeClass('usando').text("NÃO");
			$('#formAlterarComprador #em_uso').val(0);
		}
		
		var telefone_principal = '', telefone_alternativo = '', celular = '';
		var telefones = [];
		if (data["telefones"] !== null) {
			telefones = (data["telefones"]).toString();
			if (telefones.indexOf("; ", 0) !== -1)
				telefones = telefones.split("; ");
			else if (telefones.indexOf(";", 0) !== -1)
				telefones = telefones.split(";");
			else
				telefones = [ telefones ];
		}
		
		for (var i = 0; i < telefones.length; i++) {
			if (telefones[i].length === 15)
				celular = telefones[i];
			else if (i === 0)
				telefone_principal = telefones[i];
			else
				telefone_alternativo = telefones[i];
		}
		
		$('#formAlterarComprador #telefone_principal').val(telefone_principal);
		$('#formAlterarComprador #telefone_alternativo').val(telefone_alternativo);
		$('#formAlterarComprador #celular').val(celular);       
	});
}

$(document).ready(function () {
	$("#erro").hide();
	$("#sucesso").hide();

	$(".close, .fechar").click(function () {
		$('.open-message').fadeOut('slow');
	});
	
	modalExcluirComprador();
	modalAlterarComprador();

	$('.dataTables_filter').show();

	table = $('#tblCompradores').DataTable({
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
			"url": "compradores/SelecionarTudo/",
			"error": function() {
				$("#msg_erro").html("Falha ao recuperar os compradores!<br />Problema de comunicação com o banco de dados.");
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
				"defaultContent": "<a href='#alterarComprador' data-toggle='modal' id='modal-30777' role='button' class='btn btn-success btn-alterar'><i class='glyphicon glyphicon-pencil' title='Atualizar Informações do Comprador(a)'></i></a>&nbsp<a href='#excluirComprador' data-toggle='modal' id='modal-30777' role='button' class='btn btn-success btn-excluir'><i class='glyphicon glyphicon-remove' title='Excluir o Comprador(a)'></i></a>"
			}
		],
		"columns": [{"data": "id"}, {"data": "nome_completo"}, {"data": "email"}, {"data": "telefones"}, {"data": "nome_empresa"}, {"data": "em_uso"}],
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


	$("#cadastrarComprador").click(function () {
		CheckPhones();
		if (!document.getElementById('formCadastrarComprador').checkValidity()) {
			$("#msg_erro").html("Falha ao cadastrar o comprador(a)!<br />Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		var primeiro_nome = $('#formCadastrarComprador #primeiro_nome').val();
		var sobrenome = $('#formCadastrarComprador #sobrenome').val();
		var email = $('#formCadastrarComprador #email').val();
		var telefones = $('#formCadastrarComprador #telefone_principal').val();
		var telefone_alternativo = $('#formCadastrarComprador #telefone_alternativo').val();
		var celular = $('#formCadastrarComprador #celular').val();
		var nome_empresa = $('#formCadastrarComprador #nome_empresa').val();
		var em_uso = $('#formCadastrarComprador #em_uso').val();
		
		if (telefone_alternativo.length > 0)
			telefones += "; " + telefone_alternativo;
		
		if (celular.length > 0)
			telefones += "; " + celular;

		$.ajax({
			url: "compradores/Cadastrar",
			type: "POST",
			data: {
				primeiro_nome: primeiro_nome,
				sobrenome: sobrenome,
				email: email,
				telefones: telefones,
				nome_empresa: nome_empresa,
				em_uso: em_uso
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharExcluirComprador").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Comprador(a) cadastrado com sucesso!");
					$('#sucesso').fadeIn('slow').addClass('open-message');
					table.ajax.reload();
					$('html, body').animate({scrollTop: 0}, 'slow');
					$('#resetarComprador').trigger('click');
				} else {
					var error = "";
					switch (json.result) {
						case 'errorL':
							error = "Sessão expirada! Por favor, faça login novamente.";
							break;
						case 'errorT':
							error = "Você não tem permissão para gerenciar compradores.";
							break;
						case 'errorF':
							error = "Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.";
							break;
						default:
							error = "Problema de comunicação com o banco de dados.";
							break;
					}
					
					$("#msg_erro").html("Falha ao cadastrar o comprador(a)!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao cadastrar o comprador(a)!<br />Problema de comunicação com o banco de dados.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});

	$("#btExcluirComprador").click(function () {
		var id = $('#formExcluirComprador #id').val();
		$.ajax({
			url: "compradores/Excluir",
			type: "POST",
			data: {
				id: id
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharExcluirComprador").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Comprador(a) excluído com sucesso!");
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
							error = "Você não tem permissão para gerenciar compradores.";
							break;
						default:
							error = "Não é possível excluir um comprador que possua pedidos, vendas ou contas associadas.";
							break;
					}
					$("#msg_erro").html("Falha ao excluir o comprador(a)!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao excluir o comprador(a)!<br />Problema de comunicação com o banco de dados.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});

	$("#btAlterarComprador").click(function () {
		CheckPhones();
		
		if (!document.getElementById('formAlterarComprador').checkValidity()) {
			$("#msg_erro").html("Falha ao alterar o comprador(a)!<br />Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		var id = $('#formAlterarComprador #id').val();
		var primeiro_nome = $('#formAlterarComprador #primeiro_nome').val();
		var sobrenome = $('#formAlterarComprador #sobrenome').val();
		var email = $('#formAlterarComprador #email').val();
		var telefones = $('#formAlterarComprador #telefone_principal').val();
		var telefone_alternativo = $('#formAlterarComprador #telefone_alternativo').val();
		var celular = $('#formAlterarComprador #celular').val();
		var nome_empresa = $('#formAlterarComprador #nome_empresa').val();
		var em_uso = $('#formAlterarComprador #em_uso').val();
		
		if (telefone_alternativo.length > 0)
			telefones += "; " + telefone_alternativo;
		
		if (celular.length > 0)
			telefones += "; " + celular;
		
		if (primeiro_nome == originalData["primeiro_nome"] && sobrenome == originalData["sobrenome"] && email == originalData["email"] && telefones == originalData["telefones"] && nome_empresa == originalData["nome_empresa"] && em_uso == originalData["em_uso"]) {
			$("#msg_erro").html("Falha ao alterar o comprador(a)!<br />Os valores informados são iguais aos já cadastrados.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		$.ajax({
			url: "compradores/Atualizar",
			type: "POST",
			data: {
				id: id,
				primeiro_nome: primeiro_nome,
				sobrenome: sobrenome,
				email: email,
				telefones: telefones,
				nome_empresa: nome_empresa,
				em_uso: em_uso
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharAlterarComprador").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Comprador(a) alterado com sucesso!");
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
							error = "Você não tem permissão para gerenciar compradores.";
							break;
						case 'errorF':
							error = "Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.";
							break;
						default:
							error = "Problema de comunicação com o banco de dados.";
							break;
					}
					
					$("#msg_erro").html("Falha ao alterar o comprador(a)!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao alterar o comprador(a)!<br />Problema de comunicação com o banco de dados.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});
	
	$('#resetarComprador').click(function () {
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