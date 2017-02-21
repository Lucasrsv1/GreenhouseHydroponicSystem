<?php

	class Leituras_model extends CI_Model {
		const TABELA = 'leituras';
		
		function __construct() {
			parent::__construct();
		}
		
		function SelecionarTudo () {
			$select = $this->db->get(self::TABELA);
			return $select->result();
		}
		
		// Área acessível apenas aos criadores/vendedores do Greenhouse Hydroponic System,
		// por questão de funcionalidade do sistema de leitura de sensores da aplicação .NET
		
		function SelecionarPorId ($id) {
			$select = $this->db->get_where(self::TABELA, array('id' => $id));
			if ($select->num_rows() > 0)
				return $select->result();
			else
				return false;
		}
		
		function Cadastrar ($codigo, $descricao, $expressao) {
			$arrayInsert = array (
							'codigo' => $codigo,
							'descricao' => $descricao,
							'expressao' => $expressao
			);
			
			$this->db->insert(self::TABELA, $arrayInsert);
			return $this->db->affected_rows() > 0;
		}
		
		function Atualizar ($id, $codigo, $descricao, $expressao) {
			$arrayUpdate = array (
							'codigo' => $codigo,
							'descricao' => $descricao,
							'expressao' => $expressao
			);
			
			$this->db->where('id', $id);
			$this->db->update(self::TABELA, $arrayUpdate);
			return $this->db->affected_rows() > 0;
		}
		
		function Excluir ($id) {
			$this->db->where('id', $id);
			$this->db->delete(self::TABELA);
			return $this->db->affected_rows() > 0;
		}
	}
	
?>