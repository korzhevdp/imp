<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lodging extends CI_Controller {

	function __construct(){
		parent::__construct();
		if (!$this->session->userdata('lang')) {
			$this->session->set_userdata('lang', 'ru');
		}
	}

	public function _remap($hash = "") {
		$this->lodge($hash);
	}

	public function lodge($locationHash = 0) {
		$fileName = "./application/views/cache/locations/location_".$locationHash."_".$this->session->userdata('lang').".src";
		if ( file_exists($fileName) ) {
			print file_get_contents($fileName);
			return true;
		}
		$this->load->helper("url");
		redirect('notfound');
	}
}
