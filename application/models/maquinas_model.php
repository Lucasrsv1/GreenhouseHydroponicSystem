<?php

	class Maquinas_model extends CI_Model {
		const TABELA = 'maquinas';
		
		function __construct() {
			parent::__construct();
		}
		
		function VerificarServidor ($hostname, $username, $password, $return_instance = false) {
			$this->local_server = $this->load->database("local_server", true);
			$this->local_server->hostname = $hostname;
			$this->local_server->username = $username;
			$this->local_server->password = $password;
			
			if (!$this->local_server->initialize())
				return ($return_instance) ? NULL : false; // Falha ao conectar ao servidor
			else
				return ($return_instance) ? $this->local_server : true; // Conectado com sucesso
		}
		
		function SelecionarTudo ($empresas_id, $justCount = false, $em_uso_only = false) {
			if (!$em_uso_only)
				$select = $this->db->get_where(self::TABELA, array('empresas_id' => $empresas_id));
			else
				$select = $this->db->get_where(self::TABELA, array('empresas_id' => $empresas_id, 'em_uso' => true));
			
			if (!$justCount)
				return $select->result();
			else
				return $select->num_rows();
		}
		
		function SelecionarPorId ($id) {
			$select = $this->db->get_where(self::TABELA, array('id' => $id));
			if ($select->num_rows() > 0)
				return $select->result();
			else
				return false;
		}
		
		function Cadastrar ($empresas_id, $descricao, $MAC, $servidor_conexao, $servidor_usuario, $servidor_senha, $em_uso) {
			// Verificar o plano para prosseguir com o cadastro.
			$select = $this->db->get_where("planos", array('empresas_id' => $empresas_id));
			if ($select->num_rows() != 1)
				return "errorP"; // Plano não encontrado.
			
			$plano = $select->result();
			if ($plano[0]->maquinas < self::SelecionarTudo($empresas_id, true) + 1)
				return "errorM"; // Limite  de maquinas atingido.
			
			// Plano válido.
			$arrayInsert = array (
							'empresas_id' => $empresas_id,
							'descricao' => $descricao,
							'MAC' => $MAC,
							'servidor_conexao' => $servidor_conexao,
							'servidor_usuario' => $servidor_usuario,
							'servidor_senha' => $servidor_senha,
							'em_uso' => $em_uso
			);
			
			// Verificar se o nome de usuário está disponível.
			$select2 = $this->db->get_where(self::TABELA, array('MAC' => $MAC));
			if ($select2->num_rows() === 1)
				return "errorMAC"; // Nome de usuário já em uso.
			
			$this->db->insert(self::TABELA, $arrayInsert);
			return $this->db->affected_rows() > 0;
		}
		
		function Atualizar ($id, $empresas_id, $descricao, $servidor_conexao, $servidor_usuario, $servidor_senha, $em_uso) {
			$arrayUpdate = array (
							'descricao' => $descricao,
							'servidor_conexao' => $servidor_conexao,
							'servidor_usuario' => $servidor_usuario,
							'servidor_senha' => $servidor_senha,
							'em_uso' => $em_uso
			);
			
			$this->db->where(array('id' => $id, 'empresas_id' => $empresas_id));
			$this->db->update(self::TABELA, $arrayUpdate);
			return $this->db->affected_rows() > 0;
		}
		
		// Área acessível apenas aos criadores/vendedores do Greenhouse Hydroponic System,
		// por questão de segurança e garantia da funcionalidade do sistema de planos.
		
		function AtualizarMAC ($id, $MAC) {
			$this->db->where('id', $id);
			$this->db->update(self::TABELA, array('MAC', $MAC));
			return $this->db->affected_rows() > 0;
		}
		
		function Excluir ($id) {
			$this->db->where('id', $id);
			$this->db->delete(self::TABELA);
			return $this->db->affected_rows() > 0;
		}
	}
	
?>