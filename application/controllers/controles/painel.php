<?php

	class Painel extends CI_Controller {
		function __construct() {
			parent::__construct();
		}
	
		function index () {
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				redirect('login');
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				redirect($session_data['tipo']);
			
			$data['title'] = "Painel de Controles";
			$data['session_data'] = $session_data;
			$data['fullscreen'] = $this->session->userdata('fullscreen');
			$data['nav'] = $this->session->userdata('nav');
			
			$this->template->write_view('menu', $session_data['tipo'].'/menu', $data);
			$this->template->write_view('content', 'painel_controles_view');
			$this->template->render();
		}
	
		function SelecionarTudo () {
			$controles = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operario
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$this->load->model('ordens_model');
				$controles = $this->ordens_model->SelecionarTudo($session_data['empresas_id']);
				$mensagem = array('result' => 'success');
			}
			
			echo json_encode(array('data' => $controles));
		}
	
		
		function EnviarOrdem () {
			
		}

		function CancelarOrdem () {

		}
	}

?>