<?php

	class Estatisticas_model extends CI_Model {
		const TABELA = 'estatisticas';
		static $local_server;
		
		function __construct() {
			parent::__construct();
			$session_data = $this->session->userdata('logged_in');
			
			$this->load->model('maquinas_model');
			self::$local_server = $this->maquinas_model->VerificarServidor($session_data['local_server_hostname'], $session_data['local_server_username'], $session_data['local_server_password'], true);
		}
		
		function SelecionarTudo ($empresas_id, $justCount = false) {
			if (!self::$local_server)
				return array();
			
			self::$local_server->select("id, empresas_id, nome, CAST(valor_padrao_min AS CHAR) + 0 AS 'valor_padrao_min', CAST(valor_padrao_max AS CHAR) + 0 AS 'valor_padrao_max', unidade_de_medida, CAST(variacao AS CHAR) + 0 AS 'variacao', em_uso, pin, leitura_codigo, leitura_expressao, CONCAT(CAST(valor_padrao_min AS CHAR) + 0, unidade_de_medida) AS 'valor_padrao_min_und', CONCAT(CAST(valor_padrao_max AS CHAR) + 0, unidade_de_medida) AS 'valor_padrao_max_und', CONCAT(CAST(variacao AS CHAR) + 0, unidade_de_medida) AS 'variacao_und'", FALSE);
			$select = self::$local_server->get_where(self::TABELA, array('empresas_id' => $empresas_id));
			if (!$justCount)
				return $select->result();
			else
				return $select->num_rows();
		}
		
		function SelecionarPorId ($id, $empresas_id) {
			if (!self::$local_server)
				return 'errorS';
			
			$select = self::$local_server->get_where(self::TABELA, array('id' => $id, 'empresas_id' => $empresas_id));
			if ($select->num_rows() > 0)
				return $select->result();
			else
				return false;
		}
		
		function Cadastrar ($empresas_id, $nome, $valor_padrao_min, $valor_padrao_max, $unidade_de_medida, $em_uso, $pin, $variacao, $leitura_codigo, $leitura_expressao = NULL) {
			if (!self::$local_server)
				return 'errorS';
			
			// Verificar o plano para prosseguir com o cadastro.
			$select = $this->db->get_where("planos", array('empresas_id' => $empresas_id));
			if ($select->num_rows() != 1)
				return "errorP"; // Plano não encontrado.
			
			$plano = $select->result();
			if ($plano[0]->estatisticas < self::SelecionarTudo($empresas_id, true) + 1)
				return "errorE"; // Limite  de estatisticas atingido.
			
			// Plano válido.
			$arrayInsert = array (
							'empresas_id' => $empresas_id,
							'nome' => $nome,
							'valor_padrao_min' => $valor_padrao_min,
							'valor_padrao_max' => $valor_padrao_max,
							'unidade_de_medida' => $unidade_de_medida,
							'em_uso' => $em_uso,
							'pin' => $pin,
							'variacao' => $variacao,
							'leitura_codigo' => $leitura_codigo,
							'leitura_expressao' => $leitura_expressao
			);
			
			self::$local_server->insert(self::TABELA, $arrayInsert);
			return self::$local_server->affected_rows() > 0;
		}
		
		function Atualizar ($id, $empresas_id, $nome, $valor_padrao_min, $valor_padrao_max, $unidade_de_medida, $em_uso, $pin, $variacao, $leitura_codigo, $leitura_expressao = NULL) {
			if (!self::$local_server)
				return 'errorS';
			
			$arrayUpdate = array (
							'nome' => $nome,
							'valor_padrao_min' => $valor_padrao_min,
							'valor_padrao_max' => $valor_padrao_max,
							'unidade_de_medida' => $unidade_de_medida,
							'em_uso' => $em_uso,
							'pin' => $pin,
							'variacao' => $variacao,
							'leitura_codigo' => $leitura_codigo,
							'leitura_expressao' => $leitura_expressao
			);
			
			self::$local_server->where(array('id' => $id, 'empresas_id' => $empresas_id));
			self::$local_server->update(self::TABELA, $arrayUpdate);
			return self::$local_server->affected_rows() > 0;
		}
		
		function Excluir ($id, $empresas_id) {
			if (!self::$local_server)
				return 'errorS';
			
			self::$local_server->where(array('id' => $id, 'empresas_id' => $empresas_id));
			self::$local_server->delete(self::TABELA);
			return self::$local_server->affected_rows() > 0;
		}
	}
	
?>