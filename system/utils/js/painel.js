var locked = {};

function GetReles() {
	$.ajax({
		url: "painel/SelecionarTudo",
		success: function (data) {
			var json = $.parseJSON(data);
			var controles = json.data;

			if (controles.length === 0) {
				clearInterval(loader);
				$("#msg_erro").html("Falha ao recuperar os dados dos controles!<br />Problema de comunicação com o servidor local.");
				$('#erro').fadeIn('slow').addClass('open-message');
			}

			for (var c = 0; c < controles.length; c++) {
				var state, ctrl, controller_class;
				var control = $("#rele_" + controles[c].reles_id);
				var estado = (controles[c].estado == 0) ? "DESLIGADO" : "LIGADO";
				var ctrl_class = (controles[c].ordens_id > 0) ? "ordem" : ((controles[c].estado == 0) ? "off" : "on");
				if (control.length === 0) {
					// Create controllers
					var controller = $("<div class='col-md-4 col-sm-6 col-xs-12 rele' id='rele_" + controles[c].reles_id + "'><div class='x_panel noselect'><div class='x_title x_title_original'><h2 class='rele_header' style='width: 83%;' title='" + controles[c].rele_nome + " [" + estado + "]'> <span class='rele_nome'>" + controles[c].rele_nome + "</span> <span class='state'>" + estado + "</span></h2><ul class='nav navbar-right panel_toolbox'><li><a class='collapse-link controller-link'><i class='fa fa-chevron-up'></i></a></li></ul><div class='clearfix'></div></div><div class='x_content fixed_height_200' style='text-align: center;'><i class='glyphicon glyphicon-off controller " + ctrl_class + "' title='" + ((controles[c].ordens_id > 0) ? "ORDEM PARA " + ((controles[c].ordem == 0) ? "DESLIGAR" : "LIGAR") : estado) + "' id='" + ((controles[c].ordens_id > 0) ? "ordem_" + controles[c].ordens_id : "") + "'></i></div><div class='date date-border'><h2> " + controles[c].ultima_atualizacao_formatada + " </h2></div></div ></div >");

					// Add functionality to hide controller
					controller.find('.controller-link').on('click', function () {
						var $BOX_PANEL = $(this).closest('.x_panel'),
							$ICON = $(this).find('i'),
							$BOX_CONTENT = $BOX_PANEL.find('.x_content');

						// fix for some div with hardcoded fix class
						if ($BOX_PANEL.attr('style')) {
							$BOX_CONTENT.slideToggle(200, function () {
								$BOX_PANEL.removeAttr('style');
							});
						} else {
							$BOX_CONTENT.slideToggle(200);
							$BOX_PANEL.css('height', 'auto');
						}

						$ICON.toggleClass('fa-chevron-up fa-chevron-down');
						$BOX_PANEL.find('.date').toggleClass("date-border");

						state = $(this).parents('.x_title').find('.state');
						ctrl = $(this).parents('.x_panel').eq(0).find('.controller');
						if (ctrl.hasClass('ordem'))
							controller_class = 'ordem';
						else if (ctrl.hasClass('on'))
							controller_class = 'on';
						else
							controller_class = 'off';

						state.removeClass('ordem-bgr').removeClass('on-bgr').removeClass('off-bgr');
						if (!$ICON.hasClass('fa-chevron-up')) // Closing controller block
							state.addClass(controller_class + "-bgr");
					});

					// Add functionality to send/cancel orders
					controller.find('.controller').on('click', function () {
						var id = $(this).parents('.rele').attr('id').substr(5);
						if (!locked[id]) {
							if ($(this).hasClass('ordem'))
								controller_class = 'ordem';
							else if ($(this).hasClass('on'))
								controller_class = 'on';
							else
								controller_class = 'off';
						
							var id_ordem = $(this).attr('id').substr(6);
							locked[id] = true;
							AddTriggerEvent(id, controller_class, id_ordem);
						}	
					});

					$('#controllers').append(controller);
				} else {
					// Update controllers
					ctrl = control.find('.controller');
					state = control.find('.state');

					control.find('.rele_nome').text(controles[c].rele_nome);
					control.find('.date h2').text(controles[c].ultima_atualizacao_formatada);
					control.find('.rele_header').attr('title', controles[c].rele_nome + " [" + estado + "]");
					state.text(estado);
					ctrl.attr('title', (controles[c].ordens_id > 0) ? "ORDEM PARA " + ((controles[c].ordem == 0) ? "DESLIGAR" : "LIGAR") : estado);
					ctrl.attr('id', ((controles[c].ordens_id > 0) ? "ordem_" + controles[c].ordens_id : ""));

					if (!ctrl.hasClass(ctrl_class)) {
						ctrl.removeClass('ordem').removeClass('on').removeClass('off');
						ctrl.addClass(ctrl_class);
						if (!control.find('.controller-link i').hasClass('fa-chevron-up')) {
							state.removeClass('ordem-bgr').removeClass('on-bgr').removeClass('off-bgr');
							state.addClass(ctrl_class + "-bgr");
						}	
					}
				}
			}

			if (!loader)
				loader = setInterval(GetReles, 6000);
		},
		error: function (data) {
			clearInterval(loader);
			$("#msg_erro").html("Falha ao recuperar os dados dos controles!<br />Problema de comunicação com o servidor local.");
			$('#erro').fadeIn('slow').addClass('open-message');
		}
	});
}

function AddTriggerEvent (id, estado, id_ordem) {
	var data;
	if (estado !== "ordem") {
		data = {
			reles_id: id,
			estado: (estado === "on") ? false : true
		};
	} else {
		data = {
			id: id_ordem,
			reles_id: id
		};
	}

	$.ajax({
		url: "painel/" + ((estado !== "ordem") ? "EnviarOrdem" : "CancelarOrdem"),
		type: "POST",
		data: data,
		success: function (data) {
			$('#erro, #sucesso').hide();
			var json = $.parseJSON(data);
			if (json.result === 'success') {
				if (estado !== "ordem")
					$("#msg_acerto").html("Ordem para " + ((estado === "off") ? "ligar" : "desligar") + " enviada com sucesso!");
				else
					$("#msg_acerto").html("Ordem cancelada com sucesso!");

				$('#sucesso').fadeIn('slow').addClass('open-message');
				GetReles();
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
				$("#msg_erro").html("Falha ao " + ((estado !== "ordem") ? "enviar" : "cancelar") + " a ordem!<br />" + error);
				$('#erro').fadeIn('slow').addClass('open-message');
				//$('html, body').animate({ scrollTop: 0 }, 'slow');
			}
			setTimeout(() => { locked[id] = false; }, 500);
		},
		error: function () {
			$("#msg_erro").html("Falha ao " + ((estado !== "ordem") ? "enviar" : "cancelar") + " a ordem!<br />Problema de comunicação com o servidor local.");
			$('#erro').fadeIn('slow').addClass('open-message');
			//$('html, body').animate({ scrollTop: 0 }, 'slow');
			setTimeout(() => { locked[id] = false; }, 500);
		}
	});
}

var loader = null;
$(document).ready(function () {
	$('#erro, #sucesso').hide();

	$(".close, .fechar").click(function () {
		$('.open-message').fadeOut('slow');
	});

	if ($('#connection_status').children('i').hasClass('local_server_off')) {
		$("#msg_erro").html("Aparentemente você não está conectado a um servidor local. Páginas de estatísticas e controles requerem essa conexão.");
		$('#erro').fadeIn('slow').addClass('open-message');
		$('html, body').animate({ scrollTop: 0 }, 'slow');
	}

	GetReles();
});