<?php
class Notfound extends CI_Controller {
	function __construct() {
		parent::__construct();
	}

	public function index() {
		$this->load->view("pagemissing");
		return false;
	}
}

/* End of file Notfound.php */
/* Location: ./application/controllers/notfound.php */