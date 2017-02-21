var table = "";
var originalData;
var compradores;

function CheckPhones () {
	$(".telefones, .telefone_principal, .telefone_alternativo, .celular").each(function(index, element) {
		if ($(element).val().indexOf("_", 0) !== -1)
			$(element).val("");
	});
}

function modalExcluirUsuario () {
	$("#tblUsuarios tbody").on("click", ".btn-excluir", function () {
		var data = table.row($(this).parents('tr')).data();
		$("#spanNomeUsuario").html("<br>" + data["nome_completo"]);
		$("#id").val(data["id"]);
	});
}


function modalAlterarUsuario () {
	$("#tblUsuarios tbody").on("click", ".btn-alterar", function () {
		var data = table.row($(this).parents('tr')).data();
		originalData = data;
		$('#formAlterarUsuario #id').val(data["id"]);
		$('#formAlterarUsuario #primeiro_nome').val(data["primeiro_nome"]);
		$('#formAlterarUsuario #sobrenome').val(data["sobrenome"]);
		$('#formAlterarUsuario #email').val(data["email"]);
		
		var tipo = -1;
		if (data["tipo"] == "Administrador")
			tipo = 0;
		if (data["tipo"] == "Comprador")
			tipo = 1;
		if (data["tipo"] == "Operário")
			tipo = 2;
		
		
		$('#formAlterarUsuario #tipo').val(tipo).trigger('change');
		if (tipo === 1) {
			for (var c = 0; c < compradores.length; c++) {
				if (compradores[c]["nome_completo"] == data["nome_completo"]) {
					$('#formAlterarUsuario #compradores_id').val(c).trigger('change');
					break;
				}
			}
		} else {
			$('#formAlterarUsuario #compradores_id').val(-1).trigger('change');
		}
		
		if (data["em_uso"] != 0) {
			$('#formAlterarUsuario .em_uso_toggle').addClass('usando').removeClass('nao_usando').text("SIM");
			$('#formAlterarUsuario #em_uso').val(1);
		} else {
			$('#formAlterarUsuario .em_uso_toggle').addClass('nao_usando').removeClass('usando').text("NÃO");
			$('#formAlterarUsuario #em_uso').val(0);
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
		
		$('#formAlterarUsuario #telefone_principal').val(telefone_principal);
		$('#formAlterarUsuario #telefone_alternativo').val(telefone_alternativo);
		$('#formAlterarUsuario #celular').val(celular);       
	});
}

$(document).ready(function () {
	$("#erro").hide();
	$("#sucesso").hide();

	$(".close, .fechar").click(function () {
		$('.open-message').fadeOut('slow');
	});
	
	modalExcluirUsuario();
	modalAlterarUsuario();

	$('.dataTables_filter').show();

	table = $('#tblUsuarios').DataTable({
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
			"url": "usuarios/SelecionarTudo/",
			error: function(data) {
				$("#msg_erro").html("Falha ao recuperar os usuários!<br />Problema de comunicação com o banco de dados.");
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
				"targets": 7, /* número de colunas com dados */
				"data": null,
				"defaultContent": "<a href='#alterarUsuario' data-toggle='modal' id='modal-30777' role='button' class='btn btn-success btn-alterar'><i class='glyphicon glyphicon-pencil' title='Atualizar Informações do Usuário'></i></a>&nbsp<a href='#excluirUsuario' data-toggle='modal' id='modal-30777' role='button' class='btn btn-success btn-excluir'><i class='glyphicon glyphicon-remove' title='Excluir o Usuário'></i></a>"
			}
		],
		"columns": [{"data": "id"}, {"data": "usuario"}, {"data": "nome_completo"}, {"data": "tipo"}, {"data": "email"}, {"data": "telefones"}, {"data": "em_uso"}],
		"fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			$('td:nth-child(7)', nRow).addClass('action');
			var tdUso = $('td:nth-child(6)', nRow).addClass('noselect').addClass('uso-td');
			if (aData['em_uso'] == 0) {
				$('td', nRow).css('color', 'red');
				tdUso.addClass('nao_usando-td').text('NÃO');
			} else {
				$('td', nRow).css('color', 'green');
				tdUso.addClass('usando-td').text('SIM');
			}
		}
	});
	
	$.ajax({
			url: "compradores/SelecionarTudo/",
			type: "POST",
			success: function (data) {
				var json = $.parseJSON(data);
				compradores = json.data;
				for (var i = 0; i < compradores.length; i++) {
					$('#formCadastrarUsuario #compradores_id').append($("<option value=" + i + ">" + compradores[i]["nome_completo"] + "</option>"));
					$('#formAlterarUsuario #compradores_id').append($("<option value=" + i + ">" + compradores[i]["nome_completo"] + "</option>"));
				}
			}
	});


	$("#cadastrarUsuario").click(function () {
		CheckPhones();
		if (!document.getElementById('formCadastrarUsuario').checkValidity()) {
			$("#msg_erro").html("Falha ao cadastrar o usuário!<br />Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		var usuario = $('#formCadastrarUsuario #usuario').val();
		var senha = $('#formCadastrarUsuario #senha').val();
		var confirmaSenha = $('#formCadastrarUsuario #confirmaSenha').val();
		var tipoCod = $('#formCadastrarUsuario #tipo').val();
		var comp = $('#formCadastrarUsuario #compradores_id').val();
		var primeiro_nome = $('#formCadastrarUsuario #primeiro_nome').val();
		var sobrenome = $('#formCadastrarUsuario #sobrenome').val();
		var email = $('#formCadastrarUsuario #email').val();
		var telefones = $('#formCadastrarUsuario #telefone_principal').val();
		var telefone_alternativo = $('#formCadastrarUsuario #telefone_alternativo').val();
		var celular = $('#formCadastrarUsuario #celular').val();
		var em_uso = $('#formCadastrarUsuario #em_uso').val();
		
		var compradores_id = null;
		if (tipoCod == 1) {
			if (comp >= 0 && comp < compradores.length) {
				compradores_id = compradores[comp]["id"];
			} else {
				$("#msg_erro").html("Falha ao cadastrar o usuário!<br />Por favor, selecione um comprador para associar a conta.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
				return;
			}
		} else if (tipoCod != 2 && tipoCod != 0) {
			$("#msg_erro").html("Falha ao cadastrar o usuário!<br />O tipo de conta informado é inválido. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		if (senha != confirmaSenha || senha.length < 4) {
			if (senha.length < 4)
				$("#msg_erro").html("Falha ao cadastrar o usuário!<br />A senha deve conter ao menos 4 dígitos.");
			else
				$("#msg_erro").html("Falha ao cadastrar o usuário!<br />As senhas digitadas não conferem.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		if (telefone_alternativo.length > 0)
			telefones += "; " + telefone_alternativo;
		
		if (celular.length > 0)
			telefones += "; " + celular;

		$.ajax({
			url: "usuarios/Cadastrar",
			type: "POST",
			data: {
				usuario: usuario,
				senha: senha,
				tipo: tipoCod,
				primeiro_nome: primeiro_nome,
				sobrenome: sobrenome,
				email: email,
				telefones: telefones,
				em_uso: em_uso,
				compradores_id: compradores_id
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharExcluirUsuario").click();
				console.log(data);
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Usuário cadastrado com sucesso!");
					$('#sucesso').fadeIn('slow').addClass('open-message');
					table.ajax.reload();
					$('html, body').animate({scrollTop: 0}, 'slow');
					$('#resetarUsuario').trigger('click');
				} else {
					var error = "";
					switch (json.result) {
						case 'errorL':
							error = "Sessão expirada! Por favor, faça login novamente.";
							break;
						case 'errorT':
							error = "Você não tem permissão para gerenciar usuarios.";
							break;
						case 'errorF':
							error = "Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.";
							break;
						case 'errorU':
							error = "Nome de usuário indisponível. Por favor, escolha outro.";
							break;
						default:
							error = "Problema de comunicação com o banco de dados.";
							break;
					}
					
					$("#msg_erro").html("Falha ao cadastrar o usuário!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao cadastrar o usuário!<br />Problema de comunicação com o banco de dados.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});

	$("#btExcluirUsuario").click(function () {
		var id = $('#formExcluirUsuario #id').val();
		$.ajax({
			url: "usuarios/Excluir",
			type: "POST",
			data: {
				id: id
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharExcluirUsuario").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Usuário excluído com sucesso!");
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
							error = "Você não tem permissão para gerenciar usuários.";
							break;
						case 'errorU':
							error = "Você não pode excluir sua própria conta.";
							break;
						default:
							error = "Problema de comunicação com o banco de dados.";
							break;
					}
					$("#msg_erro").html("Falha ao excluir o usuário!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao excluir o usuário!<br />Problema de comunicação com o banco de dados.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});

	$("#btAlterarUsuario").click(function () {
		CheckPhones();
		
		if (!document.getElementById('formAlterarUsuario').checkValidity()) {
			$("#msg_erro").html("Falha ao alterar o usuário!<br />Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		var id = $('#formAlterarUsuario #id').val();
		var tipoCod = $('#formAlterarUsuario #tipo').val();
		var comp = $('#formAlterarUsuario #compradores_id').val();
		var primeiro_nome = $('#formAlterarUsuario #primeiro_nome').val();
		var sobrenome = $('#formAlterarUsuario #sobrenome').val();
		var email = $('#formAlterarUsuario #email').val();
		var telefones = $('#formAlterarUsuario #telefone_principal').val();
		var telefone_alternativo = $('#formAlterarUsuario #telefone_alternativo').val();
		var celular = $('#formAlterarUsuario #celular').val();
		var em_uso = $('#formAlterarUsuario #em_uso').val();
		
		var compradores_id = null;
		if (tipoCod == 1) {
			if (comp >= 0 && comp < compradores.length) {
				compradores_id = compradores[comp]["id"];
			} else {
				$("#msg_erro").html("Falha ao alterar o usuário!<br />Por favor, selecione um comprador para associar a conta.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
				return;
			}
		} else if (tipoCod != 2 && tipoCod != 0) {
			$("#msg_erro").html("Falha ao alterar o usuário!<br />O tipo de conta informado é inválido. Por favor, confira o preenchimento do formulário.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		if (telefone_alternativo.length > 0)
			telefones += "; " + telefone_alternativo;
		
		if (celular.length > 0)
			telefones += "; " + celular;
		
		var tipoOriginal = -1;
		if (originalData["tipo"] == "Administrador")
			tipoOriginal = 0;
		if (originalData["tipo"] == "Comprador")
			tipoOriginal = 1;
		if (originalData["tipo"] == "Operário")
			tipoOriginal = 2;
		
		if (tipoCod == tipoOriginal && primeiro_nome == originalData["primeiro_nome"] && sobrenome == originalData["sobrenome"] && email == originalData["email"] && telefones == originalData["telefones"] && compradores_id == originalData["compradores_id"] && em_uso == originalData["em_uso"]) {
			$("#msg_erro").html("Falha ao alterar o usuário!<br />Os valores informados são iguais aos já cadastrados.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			return;
		}
		
		$.ajax({
			url: "usuarios/Atualizar",
			type: "POST",
			data: {
				id: id,
				tipo: tipoCod,
				primeiro_nome: primeiro_nome,
				sobrenome: sobrenome,
				email: email,
				telefones: telefones,
				em_uso: em_uso,
				compradores_id: compradores_id
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				$("#btFecharAlterarUsuario").click();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Usuário alterado com sucesso!");
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
							error = "Você não tem permissão para gerenciar usuarios.";
							break;
						case 'errorF':
							error = "Os valores informados são inválidos. Por favor, confira o preenchimento do formulário.";
							break;
						case 'errorU':
							error = "Você não pode editar sua própria conta por aqui. Por favor vá para a página do seu perfil.";
							break;
						default:
							error = "Problema de comunicação com o banco de dados.";
							break;
					}
					
					$("#msg_erro").html("Falha ao alterar o usuário!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao alterar o usuário!<br />Problema de comunicação com o banco de dados.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});
	
	$('#resetarUsuario').on('click', function () {
		$('.em_uso_toggle').each(function(index, element) {
			if (!$(this).hasClass('usando'))
				$(this).trigger('click');
		});
		
		setTimeout(function () {
			$('#formCadastrarUsuario #compradores_id').trigger('change');
			$('#formCadastrarUsuario #tipo').trigger('change');
			$('#formAlterarUsuario #compradores_id').trigger('change');
			$('#formAlterarUsuario #tipo').trigger('change');
		}, 100);
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
	
	$('#formCadastrarUsuario #tipo').change(function(e) {
		if ($(this).val() == 1) {
			$('#formCadastrarUsuario .compr').attr('disabled', '');
			$('#formCadastrarUsuario #compradores_id').removeAttr('disabled');
		} else {
			$('#formCadastrarUsuario .compr').removeAttr('disabled');
			$('#formCadastrarUsuario #compradores_id').val(-1);
			$('#formCadastrarUsuario #compradores_id').attr('disabled', '');
		}
	}).trigger('change');
	
	$('#formCadastrarUsuario #compradores_id').change(function(e) {
		var pos = $(this).val();
		if (pos <= -1)
			return;
		
		var telefone_principal = '', telefone_alternativo = '', celular = '';
		var telefones = [];
		if (compradores[pos]["telefones"] !== null) {
			telefones = (compradores[pos]["telefones"]).toString();
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
		
		$('#formCadastrarUsuario #primeiro_nome').val(compradores[pos]["primeiro_nome"]);
		$('#formCadastrarUsuario #sobrenome').val(compradores[pos]["sobrenome"]);
		$('#formCadastrarUsuario #email').val(compradores[pos]["email"]);
		$('#formCadastrarUsuario #telefone_principal').val(telefone_principal);
		$('#formCadastrarUsuario #telefone_alternativo').val(telefone_alternativo);
		$('#formCadastrarUsuario #celular').val(celular);
	});
	
	$('#formAlterarUsuario #tipo').change(function(e) {
		if ($(this).val() == 1) {
			$('#formAlterarUsuario .compr').attr('disabled', '');
			$('#formAlterarUsuario #compradores_id').removeAttr('disabled');
		} else {
			$('#formAlterarUsuario .compr').removeAttr('disabled');
			$('#formAlterarUsuario #compradores_id').val(-1);
			$('#formAlterarUsuario #compradores_id').attr('disabled', '');
		}
	}).trigger('change');
	
	$('#formAlterarUsuario #compradores_id').change(function(e) {
		var pos = $(this).val();
		if (pos <= -1)
			return;
		
		var telefone_principal = '', telefone_alternativo = '', celular = '';
		var telefones = [];
		if (compradores[pos]["telefones"] !== null) {
			telefones = (compradores[pos]["telefones"]).toString();
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
		
		$('#formAlterarUsuario #primeiro_nome').val(compradores[pos]["primeiro_nome"]);
		$('#formAlterarUsuario #sobrenome').val(compradores[pos]["sobrenome"]);
		$('#formAlterarUsuario #email').val(compradores[pos]["email"]);
		$('#formAlterarUsuario #telefone_principal').val(telefone_principal);
		$('#formAlterarUsuario #telefone_alternativo').val(telefone_alternativo);
		$('#formAlterarUsuario #celular').val(celular);
	});
});