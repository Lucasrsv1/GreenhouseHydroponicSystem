<?php

	class Estatisticas extends CI_Controller {
		function __construct() {
			parent::__construct();
		}
	
		function index () {
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				redirect('login');
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				redirect($session_data['tipo']);
			
			$data['title'] = "Estatísticas";
			$data['session_data'] = $session_data;
			$data['fullscreen'] = $this->session->userdata('fullscreen');
			$data['nav'] = $this->session->userdata('nav');
			
			$this->template->write_view('menu', $session_data['tipo'].'/menu', $data);
			$this->template->write_view('content', 'gerenciar/estatisticas_view');
			$this->template->render();
		}
	
		function SelecionarTudo () {
			$estatisticas = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operario
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$this->load->model('estatisticas_model');
				$estatisticas = $this->estatisticas_model->SelecionarTudo($session_data['empresas_id']);
				$mensagem = array('result' => 'success');
			}
			
			echo json_encode(array('data' => $estatisticas));
		}
	
		function SelecionarPorId () {
			$estatistica = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operario
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$id = $this->input->post('id');
				
				$this->load->model('estatisticas_model');
				$estatistica = $this->estatisticas_model->SelecionarPorId($id, $session_data['empresas_id']);
				
				if ($estatistica)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Id inexistente
			}
			
			echo json_encode(array('data' => $estatistica));
		}
	
		function Cadastrar () {
			$this->form_validation->set_rules('nome', 'nome', 'required');
			$this->form_validation->set_rules('valor_padrao_min', 'valor_padrao_min', 'required');
			$this->form_validation->set_rules('valor_padrao_max', 'valor_padrao_max', 'required');
			$this->form_validation->set_rules('unidade_de_medida', 'unidade_de_medida', 'required');
			$this->form_validation->set_rules('em_uso', 'em_uso', 'required');
			$this->form_validation->set_rules('pin', 'pin', 'required');
			$this->form_validation->set_rules('variacao', 'variacao', 'required');
			$this->form_validation->set_rules('leitura_codigo', 'leitura_codigo', 'required');
			
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
				$nome = $this->input->post('nome');
				$valor_padrao_min = $this->input->post('valor_padrao_min');
				$valor_padrao_max = $this->input->post('valor_padrao_max');
				$unidade_de_medida = $this->input->post('unidade_de_medida');
				$em_uso = $this->input->post('em_uso');
				$pin = $this->input->post('pin');
				$variacao = $this->input->post('variacao');
				$leitura_codigo = $this->input->post('leitura_codigo');
				$leitura_expressao = $this->input->post('leitura_expressao');
				
				$this->load->model('estatisticas_model');
				$insert = $this->estatisticas_model->Cadastrar($session_data['empresas_id'], $nome, $valor_padrao_min, $valor_padrao_max, $unidade_de_medida, $em_uso, $pin, $variacao, $leitura_codigo, $leitura_expressao);
				
				if ($insert === "errorE")
					$mensagem = array('result' => 'errorE'); // Limite de estatísticas atingido
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
			$this->form_validation->set_rules('valor_padrao_min', 'valor_padrao_min', 'required');
			$this->form_validation->set_rules('valor_padrao_max', 'valor_padrao_max', 'required');
			$this->form_validation->set_rules('unidade_de_medida', 'unidade_de_medida', 'required');
			$this->form_validation->set_rules('em_uso', 'em_uso', 'required');
			$this->form_validation->set_rules('pin', 'pin', 'required');
			$this->form_validation->set_rules('variacao', 'variacao', 'required');
			$this->form_validation->set_rules('leitura_codigo', 'leitura_codigo', 'required');
			
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
				$nome = $this->input->post('nome');
				$valor_padrao_min = $this->input->post('valor_padrao_min');
				$valor_padrao_max = $this->input->post('valor_padrao_max');
				$unidade_de_medida = $this->input->post('unidade_de_medida');
				$em_uso = $this->input->post('em_uso');
				$pin = $this->input->post('pin');
				$variacao = $this->input->post('variacao');
				$leitura_codigo = $this->input->post('leitura_codigo');
				$leitura_expressao = $this->input->post('leitura_expressao');
				
				$this->load->model('estatisticas_model');
				$update = $this->estatisticas_model->Atualizar($id, $session_data['empresas_id'], $nome, $valor_padrao_min, $valor_padrao_max, $unidade_de_medida, $em_uso, $pin, $variacao, $leitura_codigo, $leitura_expressao);
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
				
				$this->load->model('estatisticas_model');
				$excluir = $this->estatisticas_model->Excluir($id, $session_data['empresas_id']);
				
				if ($excluir === "errorS")
					$mensagem = array('result' => 'errorS'); // Error de conexão com o servidor local
				else if ($excluir)
					$mensagem = array('result' => 'success');
				else
					$mensagem = array('result' => 'error'); // Erro ao excluir
			}
			
			echo json_encode($mensagem);
		}
		
		function SelecionarLeituras () {
			$leituras = NULL;
			$session_data = $this->session->userdata('logged_in');
			if (!$session_data)
				$mensagem = array('result' => 'errorL'); // Login inválido
			else if ($session_data['tipo'] != "administrador" && $session_data['tipo'] != "operario")
				$mensagem = array('result' => 'errorT'); // O usuário não é administrador ou operario
			else
				$mensagem = NULL;
			
			if ($mensagem == NULL) {
				$this->load->model('leituras_model');
				$leituras = $this->leituras_model->SelecionarTudo();
				$mensagem = array('result' => 'success');
			}
			
			echo json_encode(array('data' => $leituras));
		}
	}

?>