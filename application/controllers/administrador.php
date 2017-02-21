<?php

class Administrador extends CI_Controller{
	function __construct() {
	    parent::__construct();
	}
	
	// Acesso liberado temporariamente a todos os tipos de contas.
	function ajuda () {
		$session_data = $this->session->userdata('logged_in');
		if (!$session_data)
	        redirect('login');
		/*else if ($session_data['tipo'] != "administrador")
			redirect($session_data['tipo']);*/
	    
		$data['title'] = "Ajuda";
		$data['session_data'] = $session_data;
		$data['fullscreen'] = $this->session->userdata('fullscreen');
		$data['nav'] = $this->session->userdata('nav');
		
		$this->template->write_view('menu', $session_data['tipo'].'/menu', $data);
		$this->template->write_view('content', 'administrador/ajuda');
		$this->template->render();
	}
}

?>
