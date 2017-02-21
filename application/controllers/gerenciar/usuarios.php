<?php

	class Usuarios extends CI_Controller {
		function __construct() {
			parent::__construct();
		}
	
		function index () {
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				redirect('login');
			else if ($session_data['tipo'] != "administrador")
				redirect($session_data['tipo']);
			
			$data['title'] = "Usuários";
			$data['session_data'] = $session_data;
			$data['fullscreen'] = $this->session->userdata('fullscreen');
			$data['nav'] = $this->session->userdata('nav');
			
			$this->template->write_view('menu', 'administrador/menu', $data);
			$this->template->write_view('content', 'administrador/gerenciar/usuarios_view');
			$this->template->render();
		}
	
		function SelecionarTudo () {
			$usuarios = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$this->load->model('login_model');
				$usuarios = $this->login_model->SelecionarTudo($session_data['empresas_id']);
				$mensagem = array('result' => 'success');
			}
			
			echo json_encode(array('data' => $usuarios));
		}
	
		function Cadastrar () {
			$this->form_validation->set_rules('usuario', 'usuario', 'required');
			$this->form_validation->set_rules('senha', 'senha', 'required');
			$this->form_validation->set_rules('tipo', 'tipo', 'required');
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
				$usuario = $this->input->post('usuario');
				$senha = $this->input->post('senha');
				$tipoCod = $this->input->post('tipo');
				$primeiro_nome = $this->input->post('primeiro_nome');
				$sobrenome = $this->input->post('sobrenome');
				$em_uso = $this->input->post('em_uso');
				$email = $this->input->post('email');
				$telefones = $this->input->post('telefones');
				$compradores_id = $this->input->post('compradores_id');
				
				$this->load->model('login_model');
				$insert = $this->login_model->Cadastrar($session_data['empresas_id'], $usuario, $senha, $tipoCod, $primeiro_nome, $sobrenome, $em_uso, $email, $telefones, $compradores_id);
				
				if ($insert === "errorU")
					$mensagem = array('result' => 'errorU'); // Nome de usuário já em uso
				else if($insert)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Erro ao inserir
			}
			
			echo json_encode($mensagem);
		}
	
		function Atualizar () {
			$this->form_validation->set_rules('id', 'id', 'required');
			$this->form_validation->set_rules('tipo', 'tipo', 'required');
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
				if ($id == $session_data['id']) {
					$mensagem = array('result' => 'errorU'); // O usuário não pode excluir sua própria conta.
				} else {
					$tipoCod = $this->input->post('tipo');
					$primeiro_nome = $this->input->post('primeiro_nome');
					$sobrenome = $this->input->post('sobrenome');
					$em_uso = $this->input->post('em_uso');
					$email = $this->input->post('email');
					$telefones = $this->input->post('telefones');
					$compradores_id = $this->input->post('compradores_id');
					
					$this->load->model('login_model');
					$update = $this->login_model->Atualizar_Admin($id, $session_data['empresas_id'], $tipoCod, $primeiro_nome, $sobrenome, $em_uso, $email, $telefones, $compradores_id);
					
					if($update)
						$mensagem = array('result' => 'success');
					else
						$mensagem = array('result' => 'error'); // Erro ao atualizar
				}
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
				if ($id == $session_data['id']) {
					$mensagem = array('result' => 'errorU'); // O usuário não pode excluir sua própria conta.
				} else {
					$this->load->model('login_model');
					$excluir = $this->login_model->Excluir($id, $session_data['empresas_id']);
					
					if ($excluir)
						$mensagem = array('result' => 'success');
					else
						$mensagem = array('result' => 'error'); // Erro ao excluir
				}
			}
			
			echo json_encode($mensagem);
		}
	}

?>