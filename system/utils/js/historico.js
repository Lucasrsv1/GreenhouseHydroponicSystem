var table = "";
var originalData, leituras;

$(document).ready(function () {
	$("#erro").hide();
	$(".close, .fechar").click(function () {
		$('.open-message').fadeOut('slow');
	});
	
	$('.dataTables_filter').show();
	table = $('#tblHistorico').DataTable({
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
			"url": "historico/SelecionarHistorico/",
			"error": function() {
				$("#msg_erro").html("Falha ao recuperar o histórico de ordens!<br />Problema de comunicação com o servidor local.");
				$('#erro').fadeIn('slow').addClass('open-message');
				$('html, body').animate({scrollTop: 0}, 'slow');
			}
		},
		"columns": [{ "data": "usuario" }, { "data": "nome_completo" }, { "data": "rele_nome" }, { "data": "ordem" }, { "data": "cumprida" }, { "data": "envio" }, { "data": "executada" }],
		"fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
			var tdCumprida = $('td:nth-child(5)', nRow).addClass('noselect').addClass('uso-td');
			var tdOrdem = $('td:nth-child(4)', nRow).addClass('noselect').addClass('uso-td');
			
			if (aData['cumprida'] == 0) {
				$('td', nRow).css('color', 'red');
				tdCumprida.addClass('nao_usando-td').text('NÃO');
			} else {
				$('td', nRow).css('color', 'green');
				tdCumprida.addClass('usando-td').text('SIM');
			}
			
			if (aData['ordem'] == 0)
				tdOrdem.addClass('nao_usando-td').text('DESLIGAR');
			else
				tdOrdem.addClass('usando-td').text('LIGAR');
		}
	});

	if ($('#connection_status').children('i').hasClass('local_server_off')) {
		$("#msg_erro").html("Aparentemente você não está conectado a um servidor local. Dados como estatísticas e controles requerem essa conexão.");
		$('#erro').fadeIn('slow').addClass('open-message');
		$('html, body').animate({scrollTop: 0}, 'slow');
	}
});