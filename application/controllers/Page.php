<?php
class Page extends CI_Controller {
	function __construct() {
		parent::__construct();
		if(!$this->session->userdata('common_user')){
			$this->session->set_userdata('common_user', md5(rand(0, 9999).'zy'.$this->input->ip_address()));
		}
		if(!$this->session->userdata('lang')){
			$this->session->set_userdata('lang', 'ru');
		}
		$this->load->model('usefulmodel');
		///$this->output->enable_profiler(TRUE);
		//print $this->config->item('api');
	}

	public function index() {
		$lang   = $this->session->userdata('lang');
		$brands = $this->config->item("brand");
		$modals = $this->config->item("modals");
		$act    = array(
			'userid'     => $this->session->userdata('common_user'),
			'brand'      => $brands[$lang],
			'comment'    => '',
			'header'     => '', //$this->load->view($lang.'/frontend/page_header', array(), true),
			'keywords'   => $this->config->item('maps_keywords'),
			'title'      => $this->config->item('site_title_start'),
			'links_heap' => $this->load->view('cache/links/links_heap', array(), true),
			'menu'       => $this->load->view('cache/menus/menu_'.$lang, array(), true).$this->usefulmodel->admin_menu(),
			'footer'     => $this->load->view('shared/page_footer', array(), true),
			'modals'     => $this->load->view("shared/modals", $modals[$lang], true),
			'content'    => $this->load->view($lang."/frontend/main_page_content", array(), true)
		);
		$this->load->view("shared/frontend_nomap2", $act);
	}

	public function map($mapset = 1) { /* дублируется в /map/simple */
		$result = $this->db->query("SELECT
		`map_content`.name
		FROM
		`map_content`
		where
		`map_content`.id = ?", array($mapset));
		if ($result->num_rows()) {
			$row = $result->row();
			$brands = $this->config->item("brand");
			$lang   = $this->session->userdata('lang');
			$modals = $this->config->item("modals");
			$headers   = $this->config->item('headers');
			$navigator = $this->config->item("navigator");
			$act = array(
				'map_header' => $row->name,
				'otype'      => 0,
				'brand'      => $brands[$lang],
				'headers'    => implode($headers[$lang], "','"),
				'navigator'  => $navigator[$lang],
				'content'    => "",
				'mapset'     => $mapset,
				'map_center' => $this->config->item('map_center'),
				'keywords'   => $this->config->item('maps_keywords'),
				'title'      => $this->config->item('site_title_start')." Интерактивная карта",
				'menu'       => $this->load->view('cache/menus/menu_'.$lang, array(), true).$this->usefulmodel->admin_menu(),
				'selector'   => $this->load->view('cache/selectors/selector_'.$mapset."_".$lang, array(), true),
				'switches'   => $this->load->view('cache/selectors/selector_'.$mapset."_switches_".$lang, array(), true),
				'links_heap' => $this->load->view('cache/links/links_heap', array(), true),
				'footer'     => $this->load->view('shared/page_footer', array(), true),
				'modals'     => $this->load->view("shared/modals", $modals[$lang], true)

			);
			$this->load->view('shared/frontend_map3', $act);
			return true;
		}
		$this->load->view("pagemissing");
		return false;
	}

	public function gis($location_id = 0) {
		if ( !(int) $location_id ) {
			$this->load->view("pagemissing");
			return false;
		}
		//$this->output->enable_profiler(TRUE);
		$this->load->model('frontendmodel');
		$props = $this->frontendmodel->get_properties($location_id);
		if ( !$props ) {
			$this->load->view("pagemissing");
			return false;
		}
		$brands = $this->config->item("brand");
		$lang   = $this->session->userdata('lang');
		$modals = $this->config->item("modals");
		$act    = array(
			'comment'  => ($props['comments']) ? $this->frontendmodel->comments_show($location_id) : "",
			'title'    => $this->config->item('site_title_start')." ГИС",
			'brand'    => $brands[$lang],
			'keywords' => $this->config->item('maps_keywords').','.$props['name'],
			'content'  => $this->frontendmodel->get_cached_content($location_id),
			'header'   => '', //$this->load->view('shared/page_header', array(), TRUE),
			'footer'   => '', //$this->load->view('shared/page_footer', array(), TRUE),
			'menu'     => $this->load->view('cache/menus/menu_'.$lang, array(), TRUE).$this->usefulmodel->admin_menu(),
			'modals'   => $this->load->view('shared/modals', $modals[$lang], true)
		);
		$this->load->view("shared/frontend_nomap2", $act);
	}

	public function addcomment() {
		$this->load->model('docmodel');
		$this->docmodel->addcomment();
	}

	public function testcaptcha() {
		if ( (string) $this->session->userdata("cpt") === (string) md5(strtolower($this->input->post("captcha")))) {
			print "OK";
			return true;
		}
		print "Fail";
		return false;
	}

	public function docs($docid = 1) {
		$this->load->model('frontendmodel');
		$brands = $this->config->item("brand");
		$act = array(
			'footer'		=> $this->load->view('shared/page_footer', array(), true),
			'mapset'		=> 0,
			'brand'			=> $brands[$this->session->userdata("lang")],
			'menu'			=> $this->load->view('cache/menus/menu_'.$this->session->userdata('lang'), array(), true),
			'keywords'		=> $this->config->item('map_keywords'),
			'map_header'	=> "Объекты по типам",
			'map_center'	=> $this->config->item('map_center'),
			'title'			=> $this->config->item('site_title_start')." Интерактивная карта",
			'content'		=> $this->frontendmodel->show_doc($docid)
		);
		$this->load->view("shared/frontend_nomap2", $act);
	}

	public function comment_control() {
		$result = $this->db->query("SELECT
		`locations`.owner
		FROM
		`locations`
		INNER JOIN `comments` ON (`locations`.id = `comments`.location_id)
		WHERE `comments`.`hash` = ?
		LIMIT 1", array($this->input->post('hash')));
		
		if ($result->num_rows()) {
			$row = $result->row(0);
		}
		if(
			   ((string) $row->owner === (string) $this->session->userdata("user_id")) 
			|| ($this->session->userdata('user_id') && $this->config->item('admin_can_edit_user_locations'))
		) {
			$result = $this->db->query("UPDATE
			`comments`
			SET
			`status` = IF(comments.status = 'N', 'A', 'N')
			WHERE
			comments.hash = ?", array($this->input->post('hash')));
			if($this->db->affected_rows()){
				$result = $this->db->query("SELECT 
				`comments`.`status`
				FROM
				`comments`
				WHERE `comments`.`hash` = ?", array($this->input->post('hash')));
				if ($result->num_rows()) {
					$row = $result->row(0);
					print $row->status;
				}
			}
			return true;
		}
		print "alert('An owner was forged!')";
		return false;
	}

	public function comment_delete() {
		$result = $this->db->query("SELECT
		`locations`.owner
		FROM
		`locations`
		INNER JOIN `comments` ON (`locations`.id = `comments`.location_id)
		WHERE `comments`.`hash` = ?
		LIMIT 1", array($this->input->post('hash')));
		if ($result->num_rows()) {
			$row = $result->row(0);
		}
		if(
			   ((string) $row->owner === (string) $this->session->userdata("user_id"))
			|| ($this->session->userdata('user_id') && $this->config->item('admin_can_edit_user_locations'))
		) {
			$result = $this->db->query("UPDATE
			`comments`
			SET
			`status` = 'D'
			WHERE
			comments.hash = ?", array($this->input->post('hash')));
			if($this->db->affected_rows()){
				print "D";
			}
			return true;
		}
		print "alert('An owner was forged!')";
		return false;
	}

}

/* End of file page.php */
/* Location: ./system/application/controllers/page.php */