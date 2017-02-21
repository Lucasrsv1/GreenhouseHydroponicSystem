<?php
	
	class Servidor_Local extends CI_Controller{
		function __construct() {
			parent::__construct();
		}
		
		function index () {
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				redirect('login');
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				redirect($session_data['tipo']);
			
			$data['title'] = "Conectar a um Servidor Local";
			$data['session_data'] = $session_data;
			$data['fullscreen'] = $this->session->userdata('fullscreen');
			$data['nav'] = $this->session->userdata('nav');
			
			$this->template->write_view('menu', $session_data['tipo'].'/menu', $data);
			$this->template->write_view('content', 'servidor_local_view');
			$this->template->render();
		}
		
		function Conectar () {
			$this->form_validation->set_rules('descricao', 'descricao', 'required');
			$this->form_validation->set_rules('hostname', 'hostname', 'required');
			$this->form_validation->set_rules('username', 'username', 'required');
			
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
				$hostname = $this->input->post('hostname');
				$username = $this->input->post('username');
				$password = $this->input->post('password');
				
				$this->load->model('maquinas_model');
				$connected = $this->maquinas_model->VerificarServidor($hostname, $username, $password);
				
				if ($connected)
					$mensagem = array('result' => 'success'); // Conectado com sucesso
				else
					$mensagem = array('result' => 'error'); // Falha ao conectar ao servidor
				
				$session_data['local_server_descricao'] = $descricao;
				$session_data['local_server_hostname'] = $hostname;
				$session_data['local_server_username'] = $username;
				$session_data['local_server_password'] = $password;
				
				$this->session->set_userdata('logged_in', $session_data);
			}
			
			echo json_encode($mensagem);
		}
	}
	
?>
