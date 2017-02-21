<?php

	class Compradores extends CI_Controller {
		function __construct() {
			parent::__construct();
		}
	
		function index () {
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				redirect('login');
			else if ($session_data['tipo'] != "administrador")
				redirect($session_data['tipo']);
			
			$data['title'] = "Compradores";
			$data['session_data'] = $session_data;
			$data['fullscreen'] = $this->session->userdata('fullscreen');
			$data['nav'] = $this->session->userdata('nav');
			
			$this->template->write_view('menu', 'administrador/menu', $data);
			$this->template->write_view('content', 'administrador/gerenciar/compradores_view');
			$this->template->render();
		}
	
		function SelecionarTudo () {
			$compradores = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$this->load->model('compradores_model');
				$compradores = $this->compradores_model->SelecionarTudo($session_data['empresas_id']);
				$mensagem = array('result' => 'success');
			}
			
			echo json_encode(array('data' => $compradores));
		}
	
		function SelecionarPorId () {
			$comprador = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$id = $this->input->post('id');
				
				$this->load->model('compradores_model');
				$comprador = $this->compradores_model->SelecionarPorId($id, $session_data['empresas_id']);
				
				if ($comprador)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Id inexistente
			}
			
			echo json_encode(array('data' => $comprador));
		}
	
		function Cadastrar () {
			$this->form_validation->set_rules('primeiro_nome', 'primeiro_nome', 'required');
			$this->form_validation->set_rules('sobrenome', 'sobrenome', 'required');
			$this->form_validation->set_rules('em_uso', 'em_uso', 'required');
			
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador
			else if (!$this->form_validation->run())
				$mensagem = array('result' => 'errorF'); // Formulário inválido
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$primeiro_nome = $this->input->post('primeiro_nome');
				$sobrenome = $this->input->post('sobrenome');
				$em_uso = $this->input->post('em_uso');
				$email = $this->input->post('email');
				$telefones = $this->input->post('telefones');
				$nome_empresa = $this->input->post('nome_empresa');
				
				$this->load->model('compradores_model');
				$insert = $this->compradores_model->Cadastrar($session_data['empresas_id'], $primeiro_nome, $sobrenome, $em_uso, $email, $telefones, $nome_empresa);
				
				if($insert)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Erro ao inserir
			}
			
			echo json_encode($mensagem);
		}
	
		function Atualizar () {
			$this->form_validation->set_rules('id', 'id', 'required');
			$this->form_validation->set_rules('primeiro_nome', 'primeiro_nome', 'required');
			$this->form_validation->set_rules('sobrenome', 'sobrenome', 'required');
			$this->form_validation->set_rules('em_uso', 'em_uso', 'required');
			
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador
			else if (!$this->form_validation->run())
				$mensagem = array('result' => 'errorF'); // Formulário inválido
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$id = $this->input->post('id');
				$primeiro_nome = $this->input->post('primeiro_nome');
				$sobrenome = $this->input->post('sobrenome');
				$em_uso = $this->input->post('em_uso');
				$email = $this->input->post('email');
				$telefones = $this->input->post('telefones');
				$nome_empresa = $this->input->post('nome_empresa');
				
				$this->load->model('compradores_model');
				$update = $this->compradores_model->Atualizar($id, $session_data['empresas_id'], $primeiro_nome, $sobrenome, $em_uso, $email, $telefones, $nome_empresa);
				
				if($update)
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
			else if ($session_data['tipo'] != "administrador")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$id = $this->input->post('id');
				
				$this->load->model('compradores_model');
				$excluir = $this->compradores_model->Excluir($id, $session_data['empresas_id']);
				
				if ($excluir)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Erro ao excluir
			}
			
			echo json_encode($mensagem);
		}
	}

?>