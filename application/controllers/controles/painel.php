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
			$this->template->write_view('content', 'controles/painel_view');
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
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operario
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$reles_id = $this->input->post('reles_id');
				$estado = $this->input->post('estado');

				$this->load->model('ordens_model');
				$ordem = $this->ordens_model->Enviar($session_data['empresas_id'], $session_data['id'], $reles_id, $estado);

				if ($ordem !== 'errorS' && $ordem)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error');
			}

			echo json_encode($mensagem);
		}

		function CancelarOrdem () {
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operario
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$id = $this->input->post('id');
				$reles_id = $this->input->post('reles_id');

				$this->load->model('ordens_model');
				$ordem = $this->ordens_model->Cancelar($session_data['empresas_id'], $id, $reles_id);

				if ($ordem !== 'errorS' && $ordem)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error');
			}

			echo json_encode($mensagem);
		}
	}

?>