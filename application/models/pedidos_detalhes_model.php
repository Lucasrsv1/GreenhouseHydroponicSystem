<?php

	class PedidosDetalhes_model extends CI_Model {
		const TABELA = 'pedidos_detalhes';
		
		function __construct() {
			parent::__construct();
		}
		
		function SelecionarDetalhesEmpresa ($pedidos_id, $empresas_id) {
			$select = $this->db->query("SELECT * FROM ".self::TABELA." PD INNER JOIN pedidos P ON P.id = PD.pedidos_id WHERE PD.pedidos_id = $pedidos_id AND P.empresas_id = $empresas_id");
			return $select->result();
		}
		
		function SelecionarDetalhesComprador ($pedidos_id, $compradores_id) {
			$select = $this->db->query("SELECT * FROM ".self::TABELA." PD INNER JOIN pedido P ON P.id = PD.pedidos_id WHERE PD.pedidos_id = $pedidos_id AND P.compradores_id = $compradores_id");
			return $select->result();
		}
		
		function Cadastrar ($empresas_id, $pedidos_id, $produtos_id, $quantidade, $receita) {
			// Verificar se o pedido e o produto são da empresa antes de prosseguir.
			$select = $this->db->query("SELECT * FROM pedidos P INNER JOIN produtos PR ON PR.empresas_id = P.empresas_id WHERE P.empresas_id = $empresas_id AND P.id = $pedidos_id AND PR.id = $produtos_id");
			if ($select->num_rows() == 0)
				return false; // Pedido ou produto não encontrado dentre aqueles que fazem parte da empresa.
			
			$arrayInsert = array (
							'pedidos_id' => $pedidos_id,
							'produtos_id' => $produtos_id,
							'quantidade' => $quantidade,
							'receita' => $receita
			);
			
			$this->db->insert(self::TABELA, $arrayInsert);
			return $this->db->affected_rows() > 0;
		}
		
		function Atualizar ($id, $empresas_id, $pedidos_id, $vendidos, $perdidos, $receita) {
			// Verificar se o pedido é da empresa antes de prosseguir.
			$select = $this->db->get_where("pedidos", array('id' => $pedidos_id, 'empresas_id' => $empresas_id));
			if ($select->num_rows() == 0)
				return false; // Pedido não encontrado dentre aqueles que fazem parte da empresa.
			
			$arrayUpdate = array (
							'pedidos' => $pedidos,
							'receita' => $receita
			);
			
			$this->db->where(array('id' => $id, 'pedidos_id' => $pedidos_id));
			$this->db->update(self::TABELA, $arrayUpdate);
			return $this->db->affected_rows() > 0;
		}
		
		function Excluir ($id, $empresas_id, $pedidos_id) {
			// Verificar se a venda é da empresa antes de prosseguir.
			$select = $this->db->get_where("pedidos", array('id' => $pedidos_id, 'empresas_id' => $empresas_id));
			if ($select->num_rows() == 0)
				return false; // Venda não encontrada dentre aquelas que fazem parte da empresa.
			
			$this->db->where(array('id' => $id, 'pedidos_id' => $pedidos_id));
			$this->db->delete(self::TABELA);
			return $this->db->affected_rows() > 0;
		}
	}
	
?>