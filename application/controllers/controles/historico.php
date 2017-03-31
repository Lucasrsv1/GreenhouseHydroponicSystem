<?php

	class Historico extends CI_Controller {
		function __construct() {
			parent::__construct();
		}
	
		function index () {
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				redirect('login');
			else if ($session_data['tipo'] != "administrador")
				redirect($session_data['tipo']);
			
			$data['title'] = "Histórico de Ordens";
			$data['session_data'] = $session_data;
			$data['fullscreen'] = $this->session->userdata('fullscreen');
			$data['nav'] = $this->session->userdata('nav');
			
			$this->template->write_view('menu', $session_data['tipo'].'/menu', $data);
			$this->template->write_view('content', 'controles/historico_view');
			$this->template->render();
		}
	
		function SelecionarHistorico () {
			$ordens = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operario
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$this->load->model('ordens_model');
				$ordens = $this->ordens_model->SelecionarHistorico($session_data['empresas_id']);
				$mensagem = array('result' => 'success');
			}
			
			echo json_encode(array('data' => $ordens));
		}
	}

?>