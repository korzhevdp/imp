<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('lang')) {
			$this->session->set_userdata('lang', 'ru');
		}
	}

	public function index() {
		$headers = $this->config->item("headers");
		$this->load->view('frontend/welcome', array(
			'mapset'   => 0,
			'headers'  => implode($headers[$this->session->userdata("lang")], "', '"),
			'otype'    => 0,
			'switches' => ''
		));
	}
}
