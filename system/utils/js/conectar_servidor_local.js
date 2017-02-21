var servidores;

$(document).ready(function () {
	$("#erro").hide();
	$("#sucesso").hide();

	$(".close, .fechar").click(function () {
		$('.open-message').fadeOut('slow');
	});
	
	$.ajax({
			url: "gerenciar/servidores_locais/SelecionarTudo/",
			type: "POST",
			data: {
				em_uso_only: true
			},
			success: function (data) {
				var json = $.parseJSON(data);
				servidores = json.data;
				if (servidores.length === 0) {
					$("#msg_erro").html("Nenhum servidor local cadastrado!");
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
				
				for (var i = 0; i < servidores.length; i++)
					$('#servidor').append($("<option value=" + i + ">" + servidores[i]["descricao"] + "</option>"));
				
			},
			error: function(data) {
				$("#msg_erro").html("Falha ao recuperar os servidores locais cadastrados!<br />Problema de comunicação com o banco de dados.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
	});


	
	$("#conectar").click(async function () {
		$(this).children('.fa-spinner').addClass('fa-spin');
		$('#status').text("Conectando...");
		await Sleep(1000);
		
		var descricao, conexao, usuario, senha;
		var i = $('#servidor').val();
		
		if (i >= 0 && i < servidores.length) {
			descricao = servidores[i]['descricao'];
			conexao = servidores[i]['servidor_conexao'];
			usuario = servidores[i]['servidor_usuario'];
			senha = servidores[i]['servidor_senha'];
		} else {
			$("#msg_erro").html("Falha ao estabelecer a conexão!<br />Por favor, escolha um servidor da lista.");
			$('#erro').fadeIn('slow').addClass('open-message');
			$('html, body').animate({scrollTop: 0}, 'slow');
			
			$(this).children('.fa-spinner').removeClass('fa-spin');
			$('#status').text("Conectar");
			return;
		}
		
		$.ajax({
			url: "servidor_local/Conectar",
			type: "POST",
			data: {
				descricao: descricao,
				hostname: conexao,
				username: usuario,
				password: senha
			},
			success: function (data) {
				$('#erro, #sucesso').hide();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					$("#msg_acerto").html("Conexão estabelecida com sucesso!");
					$('#sucesso').fadeIn('slow').addClass('open-message');
					$('#connection_status').html("<i class=\"fa fa-circle local_server_on\"></i>" + servidores[i]['descricao']).parent('li:first').attr("title", "Conectado");
					$('html, body').animate({scrollTop: 0}, 'slow');
				} else {
					var error = "";
					switch (json.result) {
						case 'errorL':
							error = "Sessão expirada! Por favor, faça login novamente.";
							break;
						case 'errorT':
							error = "Você não tem permissão se conectar a um servidor local.";
							break;
						default:
							error = "Verifique se o servidor está online e devidamente configurado.";
							break;
					}
					
					$("#msg_erro").html("Falha ao estabelecer a conexão!<br />" + error);
					$('#connection_status').html("<i class=\"fa fa-circle local_server_off\"></i>Servidor local desconectado").parent('li:first').attr("title", "Não conectado");
					$('#erro').fadeIn('slow').addClass('open-message');
					$('html, body').animate({scrollTop: 0}, 'slow');
				}
		
				$('#conectar').children('.fa-spinner').removeClass('fa-spin');
				$('#status').text("Conectar");
			},
			error: function (data) {
				$("#msg_erro").html("Falha ao estabelecer a conexão!<br />Erro interno na execução da requisição.");
				$('#connection_status').html("<i class=\"fa fa-circle local_server_off\"></i>Servidor local desconectado");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		});
	});
	
	$('#servidor').change(function () {
		var i = $(this).val();
		if (i >= 0 && i < servidores.length) {
			$('#MAC').text(servidores[i]['MAC']);
			$('#servidor_conexao').text(servidores[i]['servidor_conexao']);
			$('#servidor_usuario').text(servidores[i]['servidor_usuario']);
		} else {
			$('#MAC').text("");
			$('#servidor_conexao').text("");
			$('#servidor_usuario').text("");
		}
	});
});