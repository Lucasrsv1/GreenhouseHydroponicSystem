function GetReles () {
	$.ajax({
		url: "painel/SelecionarTudo",
		success: function (data) {
			$('#erro, #sucesso').hide();
			var json = $.parseJSON(data);
			var controles = json.data;
			console.log(controles);

			if (controles.length === 0) {
				$("#msg_erro").html("Falha ao recuperar os dados dos controles!<br />Problema de comunicação com o servidor local.");
				$('#erro').fadeIn('slow').addClass('open-message');
				//$('html, body').animate({ scrollTop: 0 }, 'slow');
			}
			
			for (var c = 0; c < controles.length; c++) {
				// Create controllers
				
			}
		},
		error: function (data) {
			$("#msg_erro").html("Falha ao recuperar os dados dos controles!<br />Problema de comunicação com o servidor local.");
			$('#erro').fadeIn('slow').addClass('open-message');
			//$('html, body').animate({ scrollTop: 0 }, 'slow');
		}
	});
}

function AddTriggerEvent (elements) {
	elements.click(function () {
		var id = null;
		var estado = null;
		var id_ordem = (estado === "ordem") ? null : null;
		var data;

		if (estado !== "ordem") {
			data = {
				id: id,
				estado: (estado === "ligado") ? false : true
			};
		} else {
			data = {
				id: id_ordem,
				rele_id: id
			};
		}

		$.ajax({
			url: "painel/" + (estado !== "ordem") ? "EnviarOrdem" : "CancelarOrdem",
			type: "POST",
			data: data,
			success: function (data) {
				$('#erro, #sucesso').hide();
				var json = $.parseJSON(data);
				if (json.result === 'success') {
					if (estado !== "ordem")
						$("#msg_acerto").html("Ordem de " + ((estado === "desligado") ? "ligamento" : "desligamento") + " enviada com sucesso!");
					else
						$("#msg_acerto").html("Ordem cancelada com sucesso!");
					
					$('#sucesso').fadeIn('slow').addClass('open-message');
				} else {
					var error = "";
					switch (json.result) {
						case 'errorL':
							error = "Sessão expirada! Por favor, faça login novamente.";
							break;
						case 'errorT':
							error = "Você não tem permissão para enviar ordens.";
							break;
						default:
							error = "Problema de comunicação com o servidor local.";
							break;
					}
					$("#msg_erro").html("Falha ao enviar a ordem!<br />" + error);
					$('#erro').fadeIn('slow').addClass('open-message');
					//$('html, body').animate({ scrollTop: 0 }, 'slow');
				}
			},
			error: function () {
				$("#msg_erro").html("Falha ao " + ((estado !== "ordem") ? "enviar" : "cancelar") + " a ordem!<br />Problema de comunicação com o servidor local.");
				$('#erro').fadeIn('slow').addClass('open-message');
				//$('html, body').animate({ scrollTop: 0 }, 'slow');
			}
		});
	});
}

var loader;
$(document).ready(function () {
	$("#erro").hide();
	$("#sucesso").hide();

	$(".close, .fechar").click(function () {
		$('.open-message').fadeOut('slow');
	});
	
	loader = setInterval(GetReles, 5000);

	if ($('#connection_status').children('i').hasClass('local_server_off')) {
		$("#msg_erro").html("Aparentemente você não está conectado a um servidor local. Páginas de estatísticas e controles requerem essa conexão.");
		$('#erro').fadeIn('slow').addClass('open-message');
		$('html, body').animate({scrollTop: 0}, 'slow');
	}
});