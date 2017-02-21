<?php

	class Vendas_model extends CI_Model {
		const TABELA = 'vendas';
		
		function __construct() {
			parent::__construct();
		}
		
		function SelecionarTudoEmpresa ($empresas_id) {
			$select = $this->db->get_where(self::TABELA, array('empresas_id' => $empresas_id));
			return $select->result();
		}
		
		function SelecionarTudoComprador ($compradores_id) {
			$select = $this->db->get_where(self::TABELA, array('compradores_id' => $empresas_id));
			return $select->result();
		}
		
		function SelecionarPorIdEmpresa ($id, $empresas_id) {
			$select = $this->db->get_where(self::TABELA, array('id' => $id, 'empresas_id' => $empresas_id));
			if ($select->num_rows() > 0)
				return $select->result();
			else
				return false;
		}
		
		function SelecionarPorIdComprador ($id, $compradores_id) {
			$select = $this->db->get_where(self::TABELA, array('id' => $id, 'compradores_id' => $empresas_id));
			if ($select->num_rows() > 0)
				return $select->result();
			else
				return false;
		}
		
		function Cadastrar ($empresas_id, $compradores_id, $data, $total_de_produtos, $total_de_perdas, $receita, $pago = 0, $pagamento_data = NULL) {
			// Virificar se o comprador é da empresa antes de prosseguir.
			$select = $this->db->get_where("compradores", array('id' => $compradores_id, 'empresas_id' => $empresas_id));
			if ($select->num_rows() != 1)
				return false; // Comprador não encontrado dentre aqueles que fazem parte da empresa.
			
			$arrayInsert = array (
							'empresas_id' => $empresas_id,
							'compradores_id' => $compradores_id,
							'data' => $data,
							'total_de_produtos' => $total_de_produtos,
							'total_de_perdas' => $total_de_perdas,
							'receita' => $receita,
							'pago' => $pago,
							'pagamento_data' => $pagamento_data
			);
			
			$this->db->insert(self::TABELA, $arrayInsert);
			return $this->db->affected_rows() > 0;
		}
		
		function Atualizar ($id, $empresas_id, $compradores_id, $data, $total_de_produtos, $total_de_perdas, $receita, $pago = 0, $pagamento_data = NULL) {
			// Virificar se o comprador é da empresa antes de prosseguir.
			$select = $this->db->get_where("compradores", array('id' => $compradores_id, 'empresas_id' => $empresas_id));
			if ($select->num_rows() != 1)
				return false; // Comprador não encontrado dentre aqueles que fazem parte da empresa.
			
			$arrayUpdate = array (
							'compradores_id' => $compradores_id,
							'data' => $data,
							'total_de_produtos' => $total_de_produtos,
							'total_de_perdas' => $total_de_perdas,
							'receita' => $receita,
							'pago' => $pago,
							'pagamento_data' => $pagamento_data
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