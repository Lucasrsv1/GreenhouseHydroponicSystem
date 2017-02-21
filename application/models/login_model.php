<?php
	
	class Login_model extends CI_Model{
		function __construct(){
			parent::__construct();
			$this->load->database();
		}
		  
		function VerificarLogin ($usuario, $senha) {
			$select = $this->db->get_where("contas", array("usuario" => $usuario, "senha" => md5($senha), "em_uso" => true));
			if ($select->num_rows() == 1)
				return $select->result(); // Current user
			else
				return false;
		}
		
		function SelecionarTudo ($empresas_id) {
			$this->db->select("*, CONCAT(primeiro_nome, ' ', sobrenome) AS 'nome_completo'", FALSE);
			$select = $this->db->get_where("contas", array('empresas_id' => $empresas_id));
			return $select->result(); // Usuários da empresa
		}
		
		function SelecionarPorId ($id, $empresas_id) {
			$select = $this->db->get_where("contas", array('id' => $id, 'empresas_id' => $empresas_id));
			if ($select->num_rows() > 0)
				return $select->result();
			else
				return false;
		}
		
		function Cadastrar ($empresas_id, $usuario, $senha, $tipoCod, $primeiro_nome, $sobrenome, $em_uso, $email = NULL, $telefones = NULL, $compradores_id = NULL) {
			if ($tipoCod == 0)
				$tipo = "Administrador";
			else if ($tipoCod == 1)
				$tipo = "Comprador";
			else if ($tipoCod == 2)
				$tipo = "Operário";
			
			if ($tipo == "Comprador") {
				// Virificar se o comprador é da empresa antes de prosseguir.
				$select = $this->db->get_where("compradores", array('id' => $compradores_id, 'empresas_id' => $empresas_id));
				if ($select->num_rows() != 1)
					return false; // Comprador não encontrado dentre aqueles que fazem parte da empresa.
			} else {
				$compradores_id = NULL;
			}
			
			// Verificar se o nome de usuário está disponível.
			$select2 = $this->db->get_where("contas", array('usuario' => $usuario));
			if ($select2->num_rows() === 1)
				return "errorU"; // Nome de usuário já em uso.
			
			$data = array(
					'empresas_id' => $empresas_id,
					'usuario' => $usuario,
					'senha' => md5($senha),
					'tipo' => $tipo,
					'primeiro_nome' => $primeiro_nome,
					'sobrenome' => $sobrenome,
					'email' => $email,
					'telefones' => $telefones,
					'compradores_id' => $compradores_id,
					'em_uso' => $em_uso
			);
			
			$this->db->insert('contas', $data);
			return $this->db->affected_rows() > 0;
		}
		  
		// Atualização feita pelo dono da conta na página de perfil.
		function Atualizar ($id, $empresas_id, $usuario, $senha, $primeiro_nome, $sobrenome, $em_uso, $email = NULL, $telefones = NULL) {
			// Verificar se o nome de usuário está disponível.
			$select = $this->db->get_where("contas", array('usuario' => $usuario));
			if ($select->num_rows() === 1)
				return "errorU"; // Nome de usuário já em uso.
			
			$arrayUpdate = array (
							'usuario' => $usuario,
							'senha' => md5($senha),
							'primeiro_nome' => $primeiro_nome,
							'sobrenome' => $sobrenome,
							'email' => $email,
							'telefones' => $telefones,
							'em_uso' => $em_uso
			);
			
			$this->db->where(array('id' => $id, 'empresas_id' => $empresas_id));
			$this->db->update('contas', $arrayUpdate);
			return $this->db->affected_rows() > 0;
		}
		
		// Atualização feita por um administrador.
		function Atualizar_Admin ($id, $empresas_id, $tipoCod, $primeiro_nome, $sobrenome, $em_uso, $email = NULL, $telefones = NULL, $compradores_id = NULL) {
			if ($tipoCod == 0)
				$tipo = "Administrador";
			else if ($tipoCod == 1)
				$tipo = "Comprador";
			else if ($tipoCod == 2)
				$tipo = "Operário";
			
			if ($tipo == "Comprador") {
				// Virificar se o comprador é da empresa antes de prosseguir.
				$select = $this->db->get_where("compradores", array('id' => $compradores_id, 'empresas_id' => $empresas_id));
				if ($select->num_rows() != 1)
					return false; // Comprador não encontrado dentre aqueles que fazem parte da empresa.
			} else {
				$compradores_id = NULL;
			}
			
			$arrayUpdate = array (
							'tipo' => $tipo,
							'primeiro_nome' => $primeiro_nome,
							'sobrenome' => $sobrenome,
							'em_uso' => $em_uso,
							'email' => $email,
							'telefones' => $telefones,
							'compradores_id' => $compradores_id
			);
			
			$this->db->where(array('id' => $id, 'empresas_id' => $empresas_id));
			$this->db->update('contas', $arrayUpdate);
			return $this->db->affected_rows() > 0;
		}
		
		function Excluir ($id, $empresas_id) {
			$this->db->where(array('id' => $id, 'empresas_id' => $empresas_id));
			$this->db->delete("contas");
			return $this->db->affected_rows() > 0;
		}
	}
?>
