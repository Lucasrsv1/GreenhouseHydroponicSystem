<?php

	class Controles_model extends CI_Model {
		const TABELA = 'reles';
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
			
			self::$local_server->select("*, DATE_FORMAT(ultima_atualizacao, '%d/%m/%Y %h:%i:%s') AS 'ultima_atualizacao_formatada'", FALSE);
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
		
		function Cadastrar ($empresas_id, $rele_pin, $rele_nome, $em_uso, $estado) {
			if (!self::$local_server)
				return 'errorS';
			
			// Verificar o plano para prosseguir com o cadastro.
			$select = $this->db->get_where("planos", array('empresas_id' => $empresas_id));
			if ($select->num_rows() != 1)
				return "errorP"; // Plano não encontrado.
			
			$plano = $select->result();
			if ($plano[0]->controles < self::SelecionarTudo($empresas_id, true) + 1)
				return "errorC"; // Limite  de controles atingido.
			
			// Plano válido.
			$arrayInsert = array (
							'empresas_id' => $empresas_id,
							'rele_pin' => $rele_pin,
							'rele_nome' => $rele_nome,
							'em_uso' => $em_uso,
							'estado' => $estado
			);
			
			self::$local_server->insert(self::TABELA, $arrayInsert);
			return self::$local_server->affected_rows() > 0;
		}
		
		function Atualizar ($id, $empresas_id, $rele_pin, $rele_nome, $em_uso, $estado) {
			if (!self::$local_server)
				return 'errorS';
			
			$arrayUpdate = array (
							'rele_pin' => $rele_pin,
							'rele_nome' => $rele_nome,
							'em_uso' => $em_uso,
							'estado' => $estado
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