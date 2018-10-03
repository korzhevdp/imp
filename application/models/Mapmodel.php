<?php
class Mapmodel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	public function mapDataGet($mapset) {
		$result = $this->db->query("SELECT
		`map_content`.name
		FROM
		`map_content`
		where
		`map_content`.id = ?", array($mapset));
		if ($result->num_rows()) {
			$row = $result->row();
			$this->load->config('translations_m');
			$maps      = $this->config->item('maps');
			$brands    = $this->config->item("brand");
			$navigator = $this->config->item("navigator");
			$modals    = $this->config->item("modals");
			$headers   = $this->config->item('headers');
			$lang      = $this->session->userdata('lang');

			return array(
				'content'    => "",
				'otype'      => 0,
				'mapset'     => $mapset,
				'brand'      => $brands[$lang],
				'headers'    => implode($headers[$lang], "','"),
				'navigator'  => $navigator[$lang],
				'map_center' => $this->config->item('map_center'),
				'map_header' => (strlen($maps[$mapset][$lang])) ? $maps[$mapset][$lang] : $row->name,
				'keywords'   => $this->config->item('maps_keywords'),
				'title'      => $this->config->item('site_title_start')." Интерактивная карта",
				'footer'     => $this->load->view('shared/page_footer', array(), true),
				'modals'     => $this->load->view('shared/modals', $modals[$lang], true),
				'menu'       => $this->load->view('cache/menus/menu_'.$lang, array(), true).$this->usefulmodel->admin_menu(),
				'selector'   => $this->load->view('cache/selectors/selector_'.$mapset."_".$lang, array(), true),
				'switches'   => $this->load->view('cache/selectors/selector_'.$mapset."_switches_".$lang, array(), true)
			);
		}
		return false;
	}
}

/* End of file mapmodel.php */
/* Location: ./system/application/controllers/mapmodel.php */