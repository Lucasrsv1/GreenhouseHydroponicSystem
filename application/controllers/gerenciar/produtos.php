<?php

	class Produtos extends CI_Controller {
		function __construct() {
			parent::__construct();
		}
	
		function index () {
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				redirect('login');
			else if ($session_data['tipo'] != "administrador")
				redirect($session_data['tipo']);
			
			$data['title'] = "Produtos";
			$data['session_data'] = $session_data;
			$data['fullscreen'] = $this->session->userdata('fullscreen');
			$data['nav'] = $this->session->userdata('nav');
			
			$this->template->write_view('menu', 'administrador/menu', $data);
			$this->template->write_view('content', 'administrador/gerenciar/produtos_view');
			$this->template->render();
		}
	
		function SelecionarTudo () {
			$produtos = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$this->load->model('produtos_model');
				$produtos = $this->produtos_model->SelecionarTudo($session_data['empresas_id']);
				$mensagem = array('result' => 'success');
			}
			
			echo json_encode(array('data' => $produtos));
		}
	
		function SelecionarPorId () {
			$produto = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$id = $this->input->post('id');
				
				$this->load->model('produtos_model');
				$produto = $this->produtos_model->SelecionarPorId($id, $session_data['empresas_id']);
				
				if ($produto)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Id inexistente
			}
			
			echo json_encode(array('data' => $produto));
		}
	
		function Cadastrar () {
			$this->form_validation->set_rules('nome', 'nome', 'required');
			$this->form_validation->set_rules('unidade_medida', 'unidade_medida', 'required');
			$this->form_validation->set_rules('preco_unitario_padrao', 'preco_unitario_padrao', 'required');
			$this->form_validation->set_rules('estoque', 'estoque', 'required');
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
				$nome = $this->input->post('nome');
				$unidade_medida = $this->input->post('unidade_medida');
				$preco_unitario_padrao = $this->input->post('preco_unitario_padrao');
				$estoque = $this->input->post('estoque');
				$em_uso = $this->input->post('em_uso');
				
				$this->load->model('produtos_model');
				$insert = $this->produtos_model->Cadastrar($session_data['empresas_id'], $nome, $unidade_medida, $preco_unitario_padrao, $estoque, $em_uso);
				
				if($insert)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Erro ao inserir
			}
			
			echo json_encode($mensagem);
		}
	
		function Atualizar () {
			$this->form_validation->set_rules('id', 'id', 'required');
			$this->form_validation->set_rules('nome', 'nome', 'required');
			$this->form_validation->set_rules('unidade_medida', 'unidade_medida', 'required');
			$this->form_validation->set_rules('preco_unitario_padrao', 'preco_unitario_padrao', 'required');
			$this->form_validation->set_rules('estoque', 'estoque', 'required');
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
				$nome = $this->input->post('nome');
				$unidade_medida = $this->input->post('unidade_medida');
				$preco_unitario_padrao = $this->input->post('preco_unitario_padrao');
				$estoque = $this->input->post('estoque');
				$em_uso = $this->input->post('em_uso');
				
				$this->load->model('produtos_model');
				$update = $this->produtos_model->Atualizar($id, $session_data['empresas_id'], $nome, $unidade_medida, $preco_unitario_padrao, $estoque, $em_uso);
				
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
				
				$this->load->model('produtos_model');
				$excluir = $this->produtos_model->Excluir($id, $session_data['empresas_id']);
				
				if ($excluir)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Erro ao excluir
			}
			
			echo json_encode($mensagem);
		}
	}

?>