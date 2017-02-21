<?php
 
	class Login extends CI_Controller {
		function __construct() {
			parent::__construct();
		}
	
		function index () {
			$data['title'] = "Login";
			$data['error'] = true;
			
			$acesso = $this->session->userdata('logged_in');
			if ($acesso) {
				if ($acesso['tipo'] == "administrador")
					redirect('administrador/ajuda');
				else if ($acesso['tipo'] == "comprador")
					redirect('comprador');
				else if ($acesso['tipo'] == "operario")
					redirect('operario');
			}
			
			if ($this->input->post('usuario')) {
				$this->form_validation->set_rules('usuario', 'usuario', 'required');
				$this->form_validation->set_rules('senha', 'senha', 'required');
				
				if ($this->form_validation->run()) {
					$usuario = $this->input->post('usuario');
					$senha = $this->input->post('senha');
					
					$this->load->model('login_model');
					$acesso = $this->login_model->VerificarLogin($usuario, $senha);
					
					if ($acesso) {
						$sess_array = array(
							'id' => $acesso[0]->id,
							'empresas_id' => $acesso[0]->empresas_id,
							'usuario' => $acesso[0]->usuario,
							'tipo' => str_replace("?", "a", utf8_decode(strtolower($acesso[0]->tipo))),
							'compradores_id' => $acesso[0]->compradores_id,
							'primeiro_nome' => $acesso[0]->primeiro_nome,
							'sobrenome' => $acesso[0]->sobrenome,
							'email' => ($acesso[0]->email != NULL && strlen($acesso[0]->email) > 0) ? $acesso[0]->email : "indefinido",
							'telefones' => ($acesso[0]->telefones!= NULL && strlen($acesso[0]->telefones) > 0) ? explode(";", $acesso[0]->telefones) : "indefinido",
							'local_server_descricao' => '',
							'local_server_hostname' => '',
							'local_server_username' => '',
							'local_server_password' => ''
						);
			
						$this->session->set_userdata('logged_in', $sess_array);
						$this->session->set_userdata('fullscreen', false);
						$this->session->set_userdata('nav', 'md');
						if ($sess_array['tipo'] == "administrador")
							redirect('administrador/ajuda');
						else if ($sess_array['tipo'] == "comprador")
							redirect('comprador');
						else if ($sess_array['tipo'] == "operario")
							redirect('operario');
						else
							die(str_replace("á", "a", $sess_array['tipo']));
					}
				}
			} else if (!$this->input->post('senha')) {
				$data['error'] = false;
			}
			
			$this->load->view('templates/head', $data);
			$this->load->view('login_view', $data);
			$this->load->view('templates/end');
		}
	
		function logout () {
			$user_data = $this->session->all_userdata();
			
			foreach ($user_data as $key => $value) {
				if ($key != 'session_id' && $key != 'ip_address' && $key != 'user_agent' && $key != 'last_activity') {
					$this->session->unset_userdata($key);
				}
			}
	
			$this->session->sess_destroy();
			redirect('login');
		}
		
		function preferencias () {
			$key = $this->input->post('key');
			$val = $this->input->post('val');
			
			$session = $this->session->userdata('logged_in');
			if ($session) {
				switch ($key) {
					case "fullscreen":
						$this->session->set_userdata('fullscreen', $val);
						echo json_encode(array('result' => $this->session->userdata('fullscreen')));
						break;
					case "nav":
						$this->session->set_userdata('nav', $val);
						echo json_encode(array('result' => $this->session->userdata('nav')));
						break;
				}
			} else {
				echo json_encode(array('result' => 'errorL'));
			}
		}
		
		function SelecionarPorId () { // Todos os tipos de contas tem acesso para que possam ver sua própria conta
			$conta = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$this->load->model('login_model');
				$conta = $this->login_model->SelecionarPorId($session_data['id'], $session_data['empresas_id']);
				
				if ($conta)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Id inexistente
			}
			
			echo json_encode(array('data' => $conta));
		}
	}

?>