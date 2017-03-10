<?php

	class Ordens_model extends CI_Model {
		const TABELA = 'ordens';
		static $local_server;
		
		function __construct() {
			parent::__construct();
			$session_data = $this->session->userdata('logged_in');
			
			$this->load->model('maquinas_model');
			self::$local_server = $this->maquinas_model->VerificarServidor($session_data['local_server_hostname'], $session_data['local_server_username'], $session_data['local_server_password'], true);
		}
		
		function SelecionarTudo ($empresas_id) {
			if (!self::$local_server)
				return array();
			
			$select = self::$local_server->query("SELECT R.id AS 'reles_id', R.rele_pin, R.rele_nome, R.estado, OP.id AS 'ordens_id', OP.ordem, C.usuario, CONCAT(C.primeiro_nome, ' ', C.sobrenome) AS 'nome', IF(OP.id > 0, MIN(DATE_FORMAT(IF (OP.cumprida = FALSE, OP.envio, R.ultima_atualizacao), '%d/%m/%Y %H:%i:%s')), MAX(DATE_FORMAT(IF (OP.cumprida = FALSE, OP.envio, R.ultima_atualizacao), '%d/%m/%Y %H:%i:%s'))) AS 'ultima_atualizacao_formatada' FROM reles R LEFT JOIN ordens_pendentes OP ON OP.reles_id = R.id LEFT JOIN contas C ON OP.contas_id = C.id WHERE R.empresas_id = $empresas_id AND R.em_uso GROUP BY 1 ORDER BY R.rele_nome ASC, 9 DESC");
			return $select->result();
		}
		
		function Enviar ($empresas_id, $contas_id, $reles_id, $ordem) {
			if (!self::$local_server)
				return 'errorS';
			
			$arrayInsert = array (
							'empresas_id' => $empresas_id,
							'contas_id' => $contas_id,
							'reles_id' => $reles_id,
							'ordem' => ($ordem === 'true') ? 1 : 0
			);
			
			self::$local_server->insert(self::TABELA, $arrayInsert);
			return self::$local_server->affected_rows() > 0;
		}
		
		function Cancelar ($empresas_id, $id, $reles_id) {
			if (!self::$local_server)
				return 'errorS';
			
			self::$local_server->where(array('id' => $id, 'empresas_id' => $empresas_id, 'reles_id' => $reles_id, 'cumprida' => false, 'processada' => false));
			self::$local_server->delete(self::TABELA);
			return self::$local_server->affected_rows() > 0;
		}
	}
	
?>