<?php

	class Compradores_model extends CI_Model {
		const TABELA = 'compradores';
		
		function __construct() {
			parent::__construct();
		}
		
		function SelecionarTudo ($empresas_id) {
			$this->db->select("*, CONCAT(primeiro_nome, ' ', sobrenome) AS 'nome_completo'", FALSE);
			$select = $this->db->get_where(self::TABELA, array('empresas_id' => $empresas_id));
			return $select->result();
		}
		
		function SelecionarPorId ($id, $empresas_id) {
			$select = $this->db->get_where(self::TABELA, array('id' => $id, 'empresas_id' => $empresas_id));
			if ($select->num_rows() > 0)
				return $select->result();
			else
				return false;
		}
		
		function Cadastrar ($empresas_id, $primeiro_nome, $sobrenome, $em_uso, $email = NULL, $telefones = NULL, $nome_empresa = NULL) {
			$arrayInsert = array (
							'empresas_id' => $empresas_id,
							'primeiro_nome' => $primeiro_nome,
							'sobrenome' => $sobrenome,
							'email' => $email,
							'telefones' => $telefones,
							'nome_empresa' => $nome_empresa,
							'em_uso' => $em_uso
			);
			
			$this->db->insert(self::TABELA, $arrayInsert);
			return $this->db->affected_rows() > 0;
		}
		
		function Atualizar ($id, $empresas_id, $primeiro_nome, $sobrenome, $em_uso, $email = NULL, $telefones = NULL, $nome_empresa = NULL) {
			$arrayUpdate = array (
							'primeiro_nome' => $primeiro_nome,
							'sobrenome' => $sobrenome,
							'email' => $email,
							'telefones' => $telefones,
							'nome_empresa' => $nome_empresa,
							'em_uso' => $em_uso
			);
			
			$this->db->where(array('id' => $id, 'empresas_id' => $empresas_id));
			$this->db->update(self::TABELA, $arrayUpdate);
			return $this->db->affected_rows() > 0;
		}
		
		function Excluir ($id, $empresas_id) {
			$this->db->where(array('id' => $id, 'empresas_id' => $empresas_id));
			$this->db->delete(self::TABELA);
			return $this->db->affected_rows() > 0;
		}
	}
	
?>