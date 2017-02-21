<?php

	class VendasDetalhes_model extends CI_Model {
		const TABELA = 'vendas_detalhes';
		
		function __construct() {
			parent::__construct();
		}
		
		function SelecionarDetalhesEmpresa ($vendas_id, $empresas_id) {
			$select = $this->db->query("SELECT * FROM ".self::TABELA." VD INNER JOIN vendas V ON V.id = VD.vendas_id WHERE VD.vendas_id = $vendas_id AND V.empresas_id = $empresas_id");
			return $select->result();
		}
		
		function SelecionarDetalhesComprador ($vendas_id, $compradores_id) {
			$select = $this->db->query("SELECT * FROM ".self::TABELA." VD INNER JOIN vendas V ON V.id = VD.vendas_id WHERE VD.vendas_id = $vendas_id AND V.compradores_id = $compradores_id");
			return $select->result();
		}
		
		function Cadastrar ($empresas_id, $vendas_id, $produtos_id, $vendidos, $perdidos, $receita) {
			// Verificar se a venda e o produto são da empresa antes de prosseguir.
			$select = $this->db->query("SELECT * FROM vendas V INNER JOIN produtos P ON P.empresas_id = V.empresas_id WHERE V.empresas_id = $empresas_id AND V.id = $vendas_id AND P.id = $produtos_id");
			if ($select->num_rows() == 0)
				return false; // Venda ou produto não encontrado dentre aqueles que fazem parte da empresa.
			
			$arrayInsert = array (
							'vendas_id' => $vendas_id,
							'produtos_id' => $produtos_id,
							'vendidos' => $vendidos,
							'perdidos' => $perdidos,
							'receita' => $receita
			);
			
			$this->db->insert(self::TABELA, $arrayInsert);
			return $this->db->affected_rows() > 0;
		}
		
		function Atualizar ($id, $empresas_id, $vendas_id, $vendidos, $perdidos, $receita) {
			// Verificar se a venda é da empresa antes de prosseguir.
			$select = $this->db->get_where("vendas", array('id' => $vendas_id, 'empresas_id' => $empresas_id));
			if ($select->num_rows() == 0)
				return false; // Venda não encontrada dentre aquelas que fazem parte da empresa.
			
			$arrayUpdate = array (
							'vendidos' => $vendidos,
							'perdidos' => $perdidos,
							'receita' => $receita
			);
			
			$this->db->where(array('id' => $id, 'vendas_id' => $vendas_id));
			$this->db->update(self::TABELA, $arrayUpdate);
			return $this->db->affected_rows() > 0;
		}
		
		function Excluir ($id, $empresas_id, $vendas_id) {
			// Verificar se a venda é da empresa antes de prosseguir.
			$select = $this->db->get_where("vendas", array('id' => $vendas_id, 'empresas_id' => $empresas_id));
			if ($select->num_rows() == 0)
				return false; // Venda não encontrada dentre aquelas que fazem parte da empresa.
			
			$this->db->where(array('id' => $id, 'vendas_id' => $vendas_id));
			$this->db->delete(self::TABELA);
			return $this->db->affected_rows() > 0;
		}
	}
	
?>