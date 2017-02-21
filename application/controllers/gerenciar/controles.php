<?php

	class Controles extends CI_Controller {
		function __construct() {
			parent::__construct();
		}
	
		function index () {
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				redirect('login');
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				redirect($session_data['tipo']);
			
			$data['title'] = "Controles";
			$data['session_data'] = $session_data;
			$data['fullscreen'] = $this->session->userdata('fullscreen');
			$data['nav'] = $this->session->userdata('nav');
			
			$this->template->write_view('menu', $session_data['tipo'].'/menu', $data);
			$this->template->write_view('content', 'gerenciar/controles_view');
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
				$this->load->model('controles_model');
				$controles = $this->controles_model->SelecionarTudo($session_data['empresas_id']);
				$mensagem = array('result' => 'success');
			}
			
			echo json_encode(array('data' => $controles));
		}
	
		function SelecionarPorId () {
			$controle = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operario
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$id = $this->input->post('id');
				
				$this->load->model('controles_model');
				$controle = $this->controles_model->SelecionarPorId($id, $session_data['empresas_id']);
				
				if ($controle)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Id inexistente
			}
			
			echo json_encode(array('data' => $controle));
		}
	
		function Cadastrar () {
			$this->form_validation->set_rules('nome', 'nome', 'required');
			$this->form_validation->set_rules('pin', 'pin', 'required');
			$this->form_validation->set_rules('estado', 'estado', 'required');
			$this->form_validation->set_rules('em_uso', 'em_uso', 'required');
			
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operario
			else if (!$this->form_validation->run())
				$mensagem = array('result' => 'errorF'); // Formulário inválido
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$rele_nome = $this->input->post('nome');
				$rele_pin = $this->input->post('pin');
				$estado = $this->input->post('estado');
				$em_uso = $this->input->post('em_uso');
				
				$this->load->model('controles_model');
				$insert = $this->controles_model->Cadastrar($session_data['empresas_id'], $rele_pin, $rele_nome, $em_uso, $estado);
				
				if ($insert === "errorC")
					$mensagem = array('result' => 'errorC'); // Limite de controles atingido
				else if ($insert === "errorP")
					$mensagem = array('result' => 'errorP'); // Plano não encontrado
				else if ($insert === "errorS")
					$mensagem = array('result' => 'errorS'); // Error de conexão com o servidor local
				else if ($insert)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Erro ao inserir
			}
			
			echo json_encode($mensagem);
		}
	
		function Atualizar () {
			$this->form_validation->set_rules('id', 'id', 'required');
			$this->form_validation->set_rules('nome', 'nome', 'required');
			$this->form_validation->set_rules('pin', 'pin', 'required');
			$this->form_validation->set_rules('estado', 'estado', 'required');
			$this->form_validation->set_rules('em_uso', 'em_uso', 'required');
			
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operario
			else if (!$this->form_validation->run())
				$mensagem = array('result' => 'errorF'); // Formulário inválido
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$id = $this->input->post('id');
				$rele_nome = $this->input->post('nome');
				$rele_pin = $this->input->post('pin');
				$estado = $this->input->post('estado');
				$em_uso = $this->input->post('em_uso');
				
				$this->load->model('controles_model');
				$update = $this->controles_model->Atualizar($id, $session_data['empresas_id'], $rele_pin, $rele_nome, $em_uso, $estado);
				if ($update === "errorS")
					$mensagem = array('result' => 'errorS'); // Não foi possível conectar ao servidor local
				else if($update)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Erro ao atualizar
			}
			
			echo json_encode($mensagem);
		}
	
		function Excluir () {
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operario
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$id = $this->input->post('id');
				
				$this->load->model('controles_model');
				$excluir = $this->controles_model->Excluir($id, $session_data['empresas_id']);
				
				if ($excluir === "errorS")
					$mensagem = array('result' => 'errorS'); // Error de conexão com o servidor local
				else if ($excluir)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Erro ao excluir
			}
			
			echo json_encode($mensagem);
		}
	}

?>