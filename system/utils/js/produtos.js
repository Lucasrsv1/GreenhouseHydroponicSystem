var table = "";
var originalData;

function modalExcluirProduto () {
	$("#tblProdutos tbody").on("click", ".btn-excluir", function () {
		var data = table.row($(this).parents('tr')).data();
		$("#spanNomeProduto").html("<br>" + data["nome"]);
		$("#id").val(data["id"]);
	});
}


function modalAlterarProduto () {
	$("#tblProdutos tbody").on("click", ".btn-alterar", function () {
		var data = table.row($(this).parents('tr')).data();
		originalData = data;
		$('#formAlterarProduto #id').val(data["id"]);
		$('#formAlterarProduto #nome').val(data["nome"]);
		$('#formAlterarProduto #unidade_medida').val(data["unidade_medida"]);
		$('#formAlterarProduto #preco_unitario_padrao').val(data["preco_unitario_padrao"]);
		$('#formAlterarProduto #estoque').val(data["estoque"]);
		
		if (data["em_uso"] != 0) {
			$('#formAlterarProduto .em_uso_toggle').addClass('usando').removeClass('nao_usando').text("SIM");
			$('#formAlterarProduto #em_uso').val(1);
		} else {
			$('#formAlterarProduto .em_uso_toggle').addClass('nao_usando').removeClass('usando').text("NÃO");
			$('#formAlterarProduto #em_uso').val(0);
		}
	});
}

$(document).ready(function () {
	$("#erro").hide();
	$("#sucesso").hide();

	$(".close, .fechar").click(function () {
		$('.open-message').fadeOut('slow');
	});
	
	modalExcluirProduto();
	modalAlterarProduto();

	$('.dataTables_filter').show();

	table = $('#tblProdutos').DataTable({
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
			"url": "produtos/SelecionarTudo/",
			"error": function() {
				$("#msg_erro").html("Falha ao recuperar os produtos!<br />Problema de comunicação com o banco de dados.");
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
				"defaultContent": "<a href='#alterarProduto' data-toggle='modal' id='modal-30777' role='button' class='btn btn-success btn-alterar'><i class='glyphicon glyphicon-pencil' title='Atualizar Informações do Produto'></i></a>&nbsp<a href='#excluirProduto' data-toggle='modal' id='modal-30777' role='button' class='btn btn-success btn-excluir'><i class='glyphicon glyphicon-remove' title='Excluir o Produto'></i></a>"
			}
		],
		"columns": [{"data": "id"}, {"data": "nome"}, {"data": "unidade_medida"}, {"data": "preco_unitario_padrao"}, {"data": "estoque"}, {"data": "em_uso"}],
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


	$("#cadastrarProduto").click(function () {
		if (!document.getElementById('formCadastrarProduto').checkValidity()) {
			$("#msg_erro").html("Falha ao cadastrar o produto!<br />Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		var nome = $('#formCadastrarProduto #nome').val();
		var unidade_medida = $('#formCadastrarProduto #unidade_medida').val();
		var preco_unitario_padrao = $('#formCadastrarProduto #preco_unitario_padrao').val();
		var estoque = $('#formCadastrarProduto #estoque').val();
		var em_uso = $('#formCadastrarProduto #em_uso').val();
		
		$.ajax({
			url: "produtos/Cadastrar",
			type: "POST",
			data: {
				nome: nome,
				unidade_medida: unidade_medida,
				preco_unitario_padrao: preco_unitario_padrao,
				estoque: estoque,
				em_uso: em_uso
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharExcluirProduto").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Produto cadastrado com sucesso!");
					$('#sucesso').fadeIn('slow').addClass('open-message');
					table.ajax.reload();
					$('html, body').animate({scrollTop: 0}, 'slow');
					$('#resetarProduto').trigger('click');
				} else {
					var error = "";
					switch (json.result) {
						case 'errorL':
							error = "Sessão expirada! Por favor, faça login novamente.";
							break;
						case 'errorT':
							error = "Você não tem permissão para gerenciar produtos.";
							break;
						case 'errorF':
							error = "Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.";
							break;
						default:
							error = "Problema de comunicação com o banco de dados.";
							break;
					}
					
					$("#msg_erro").html("Falha ao cadastrar o produto!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao cadastrar o produto!<br />Problema de comunicação com o banco de dados.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});

	$("#btExcluirProduto").click(function () {
		var id = $('#formExcluirProduto #id').val();
		$.ajax({
			url: "produtos/Excluir",
			type: "POST",
			data: {
				id: id
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharExcluirProduto").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Produto excluído com sucesso!");
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
							error = "Você não tem permissão para gerenciar produtos.";
							break;
						default:
							error = "Não é possível excluir um produto que possua registro em pedidos ou vendas.";
							break;
					}
					$("#msg_erro").html("Falha ao excluir o produto!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao excluir o produto!<br />Problema de comunicação com o banco de dados.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});

	$("#btAlterarProduto").click(function () {
		if (!document.getElementById('formAlterarProduto').checkValidity()) {
			$("#msg_erro").html("Falha ao alterar o produto!<br />Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		var id = $('#formAlterarProduto #id').val();
		var nome = $('#formAlterarProduto #nome').val();
		var unidade_medida = $('#formAlterarProduto #unidade_medida').val();
		var preco_unitario_padrao = $('#formAlterarProduto #preco_unitario_padrao').val();
		var estoque = $('#formAlterarProduto #estoque').val();
		var em_uso = $('#formAlterarProduto #em_uso').val();
		
		if (nome == originalData["nome"] && unidade_medida == originalData["unidade_medida"] && preco_unitario_padrao == originalData["preco_unitario_padrao"] && estoque == originalData["estoque"] && em_uso == originalData["em_uso"]) {
			$("#msg_erro").html("Falha ao alterar o produto!<br />Os valores informados são iguais aos já cadastrados.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		$.ajax({
			url: "produtos/Atualizar",
			type: "POST",
			data: {
				id: id,
				nome: nome,
				unidade_medida: unidade_medida,
				preco_unitario_padrao: preco_unitario_padrao,
				estoque: estoque,
				em_uso: em_uso
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharAlterarProduto").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Produto alterado com sucesso!");
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
							error = "Você não tem permissão para gerenciar produtos.";
							break;
						case 'errorF':
							error = "Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.";
							break;
						default:
							error = "Problema de comunicação com o banco de dados.";
							break;
					}
					
					$("#msg_erro").html("Falha ao alterar o produto!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao alterar o produto!<br />Problema de comunicação com o banco de dados.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});
	
	$('#resetarProduto').click(function () {
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