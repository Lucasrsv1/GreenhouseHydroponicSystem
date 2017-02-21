<?php

	class Planos_model extends CI_Model {
		const TABELA = 'planos';
		
		function __construct() {
			parent::__construct();
		}
		
		function SelecionarPorId ($empresas_id) {
			$select = $this->db->get_where(self::TABELA, array('empresas_id' => $empresas_id));
			if ($select->num_rows() == 1)
				return $select->result();
			else
				return false;
		}
		
		// Área acessível apenas aos criadores/vendedores do Greenhouse Hydroponic System,
		// por questão de segurança e garantia da funcionalidade do sistema de planos.
		
		function SelecionarTudo () {
			$select = $this->db->get(self::TABELA);
			return $select->result();
		}
		
		function Cadastrar ($empresas_id, $nome, $estatisticas, $controles, $maquinas, $data_inicio, $data_fim, $valor, $tipo) {
			$arrayInsert = array (
							'empresas_id' => $empresas_id,
							'nome' => $nome,
							'estatisticas' => $estatisticas,
							'controles' => $controles,
							'maquinas' => $maquinas,
							'data_inicio' => $data_inicio,
							'data_fim' => $data_fim,
							'valor' => $valor,
							'tipo' => $tipo
			);
			
			$this->db->insert(self::TABELA, $arrayInsert);
			return $this->db->affected_rows() > 0;
		}
		
		function Atualizar ($empresas_id, $nome, $estatisticas, $controles, $maquinas, $data_inicio, $data_fim, $valor, $tipo) {
			$arrayUpdate = array (
							'nome' => $nome,
							'estatisticas' => $estatisticas,
							'controles' => $controles,
							'maquinas' => $maquinas,
							'data_inicio' => $data_inicio,
							'data_fim' => $data_fim,
							'valor' => $valor,
							'tipo' => $tipo
			);
			
			$this->db->where('empresas_id', $empresas_id);
			$this->db->update(self::TABELA, $arrayUpdate);
			return $this->db->affected_rows() > 0;
		}
		
		function Excluir ($empresas_id) {
			$this->db->where('empresas_id', $empresas_id);
			$this->db->delete(self::TABELA);
			return $this->db->affected_rows() > 0;
		}
	}
	
?>