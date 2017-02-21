<?php

	class Servidores_Locais extends CI_Controller {
		function __construct() {
			parent::__construct();
		}
	
		function index () {
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				redirect('login');
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				redirect($session_data['tipo']);
			
			$data['title'] = "Servidores Locais";
			$data['session_data'] = $session_data;
			$data['fullscreen'] = $this->session->userdata('fullscreen');
			$data['nav'] = $this->session->userdata('nav');
			
			$this->template->write_view('menu', $session_data['tipo'].'/menu', $data);
			$this->template->write_view('content', 'gerenciar/servidores_locais_view');
			$this->template->render();
		}
	
		function SelecionarTudo () {
			$servidores_locais = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operário
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$em_uso_only = $this->input->post('em_uso_only');
				
				$this->load->model('maquinas_model');
				$servidores_locais = $this->maquinas_model->SelecionarTudo($session_data['empresas_id'], false, $em_uso_only);
				$mensagem = array('result' => 'success');
			}
			
			echo json_encode(array('data' => $servidores_locais));
		}
	
		function SelecionarPorId () {
			$servidor_local = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operário
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$id = $this->input->post('id');
				
				$this->load->model('maquinas_model');
				$servidor_local = $this->maquinas_model->SelecionarPorId($id, $session_data['empresas_id']);
				
				if ($servidor_local)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Id inexistente
			}
			
			echo json_encode(array('data' => $servidor_local));
		}
	
		function Cadastrar () {
			$this->form_validation->set_rules('descricao', 'descricao', 'required');
			$this->form_validation->set_rules('MAC', 'MAC', 'required');
			$this->form_validation->set_rules('servidor_conexao', 'servidor_conexao', 'required');
			$this->form_validation->set_rules('servidor_usuario', 'servidor_usuario', 'required');
			$this->form_validation->set_rules('em_uso', 'em_uso', 'required');
			
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operário
			else if (!$this->form_validation->run())
				$mensagem = array('result' => 'errorF'); // Formulário inválido
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$descricao = $this->input->post('descricao');
				$MAC = $this->input->post('MAC');
				$servidor_conexao = $this->input->post('servidor_conexao');
				$servidor_usuario = $this->input->post('servidor_usuario');
				$servidor_senha = $this->input->post('servidor_senha');
				$em_uso = $this->input->post('em_uso');
				
				$this->load->model('maquinas_model');
				$insert = $this->maquinas_model->Cadastrar($session_data['empresas_id'], $descricao, $MAC, $servidor_conexao, $servidor_usuario, $servidor_senha, $em_uso);
				
				if ($insert === "errorM")
					$mensagem = array('result' => 'errorM'); // Limite de máquinas atingido
				else if ($insert === "errorP")
					$mensagem = array('result' => 'errorP'); // Plano não encontrado
				else if ($insert === "errorMAC")
					$mensagem = array('result' => 'errorMAC'); // MAC já cadastrado
				else if($insert)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Erro ao inserir
			}
			
			echo json_encode($mensagem);
		}
	
		function Atualizar () {
			$this->form_validation->set_rules('id', 'id', 'required');
			$this->form_validation->set_rules('descricao', 'descricao', 'required');
			$this->form_validation->set_rules('servidor_conexao', 'servidor_conexao', 'required');
			$this->form_validation->set_rules('servidor_usuario', 'servidor_usuario', 'required');
			$this->form_validation->set_rules('em_uso', 'em_uso', 'required');
			
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operário
			else if (!$this->form_validation->run())
				$mensagem = array('result' => 'errorF'); // Formulário inválido
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$id = $this->input->post('id');
				$descricao = $this->input->post('descricao');
				$servidor_conexao = $this->input->post('servidor_conexao');
				$servidor_usuario = $this->input->post('servidor_usuario');
				$servidor_senha = $this->input->post('servidor_senha');
				$em_uso = $this->input->post('em_uso');
				
				$this->load->model('maquinas_model');
				$update = $this->maquinas_model->Atualizar($id, $session_data['empresas_id'], $descricao, $servidor_conexao, $servidor_usuario, $servidor_senha, $em_uso);
				
				if($update)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Erro ao atualizar
			}
			
			echo json_encode($mensagem);
		}
	}

?>