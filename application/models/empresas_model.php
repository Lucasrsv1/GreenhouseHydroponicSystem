<?php

	class Empresas_model extends CI_Model {
		const TABELA = 'empresas';
		
		function __construct() {
			parent::__construct();
		}
		
		function SelecionarPorId ($id) {
			$select = $this->db->get_where(self::TABELA, array('id' => $id));
			if ($select->num_rows() == 1)
				return $select->result();
			else
				return false;
		}
		
		function Atualizar ($id, $nome, $cnpj, $inscricao_estadual, $endereco, $bairro, $cidade, $estado, $cep, $email, $telefones, $responsavel, $razao_social = NULL) {
			$arrayUpdate = array (
							'nome' => $nome,
							'razao_social' => $razao_social,
							'cnpj' => $cnpj,
							'inscricao_estadual' => $inscricao_estadual,
							'endereco' => $endereco,
							'bairro' => $bairro,
							'cidade' => $cidade,
							'estado' => $estado,
							'cep' => $cep,
							'email' => $email,
							'telefones' => $telefones,
							'responsavel' => $responsavel
			);
			
			$this->db->where('id', $id);
			$this->db->update(self::TABELA, $arrayUpdate);
			return $this->db->affected_rows() > 0;
		}
		
		// Área acessível apenas aos criadores/vendedores do Greenhouse Hydroponic System,
		// por questão de segurança e garantia da funcionalidade do sistema de planos.
		
		function SelecionarTudo () {
			$select = $this->db->get(self::TABELA);
			return $select->result();
		}
		
		function Cadastrar ($nome, $cnpj, $inscricao_estadual, $endereco, $bairro, $cidade, $estado, $cep, $email, $telefones, $responsavel, $razao_social = NULL) {
			$arrayInsert = array (
							'nome' => $nome,
							'razao_social' => $razao_social,
							'cnpj' => $cnpj,
							'inscricao_estadual' => $inscricao_estadual,
							'endereco' => $endereco,
							'bairro' => $bairro,
							'cidade' => $cidade,
							'estado' => $estado,
							'cep' => $cep,
							'email' => $email,
							'telefones' => $telefones,
							'responsavel' => $responsavel
			);
			
			$this->db->insert(self::TABELA, $arrayInsert);
			return $this->db->affected_rows() > 0;
		}
		
		function Excluir ($id) {
			$this->db->where('id', $id);
			$this->db->delete(self::TABELA);
			return $this->db->affected_rows() > 0;
		}
	}
	
?>