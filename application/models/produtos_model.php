<?php

	class Produtos_model extends CI_Model {
		const TABELA = 'produtos';
		
		function __construct() {
			parent::__construct();
		}
		
		function SelecionarTudo ($empresas_id) {
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
		
		function Cadastrar ($empresas_id, $nome, $unidade_medida, $preco_unitario_padrao, $estoque, $em_uso) {
			$arrayInsert = array (
							'empresas_id' => $empresas_id,
							'nome' => $nome,
							'unidade_medida' => $unidade_medida,
							'preco_unitario_padrao' => $preco_unitario_padrao,
							'estoque' => $estoque,
							'em_uso' => $em_uso
			);
			
			$this->db->insert(self::TABELA, $arrayInsert);
			return $this->db->affected_rows() > 0;
		}
		
		function Atualizar ($id, $empresas_id, $nome, $unidade_medida, $preco_unitario_padrao, $estoque, $em_uso) {
			$arrayUpdate = array (
							'nome' => $nome,
							'unidade_medida' => $unidade_medida,
							'preco_unitario_padrao' => $preco_unitario_padrao,
							'estoque' => $estoque,
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