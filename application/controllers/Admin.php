<?php
class Admin extends CI_Controller {
	function __construct() {
		parent::__construct();

		if(!$this->session->userdata('user_id')) {
			$this->load->helper('url');
			redirect('login/index/auth');
		}

		$this->load->model('usefulmodel');
		$this->load->model('adminmodel');
		$this->load->model('semanticsmodel');
		$this->session->set_userdata("c_l", 0);

		if(!$this->session->userdata('lang')) {
			$this->session->set_userdata('lang', 'en');
		}
	}

	public function index() {
		$this->library();
	}

	public function library($obj_group = 0, $loc_type = 0, $param = 1, $page = 1) {
		$this->usefulmodel->check_admin_status();
		$output = array(
			'menu'     => $this->load->view('admin/menu', array(), true)
						 .$this->load->view('admin/supermenu', $this->usefulmodel->semantics_supermenu(), true),
			'content'  => $this->adminmodel->getCompositeIndexes($obj_group, $loc_type, $param, $page)
		);
		$this->load->view('admin/view', $output);
	}

	public function sheets($mode, $sheet_id="0") {
		$this->usefulmodel->check_admin_status();

		$this->load->model('docmodel');
		if ($mode === 'save') {
			$this->docmodel->sheet_save($sheet_id);
			//return false;
		}
		$output = array(
			'menu'    => $this->load->view('admin/menu', array(), true)
						.$this->load->view('admin/supermenu', $this->usefulmodel->semantics_supermenu(), true),
			'content' => $this->docmodel->sheet_edit($sheet_id)
		);
		$this->load->view('admin/view', $output);
	}

	public function maps(){
		$this->usefulmodel->check_admin_status();
		$this->load->model('cachemodel');
		$this->load->model('mcmodel');
		$mapset = ($this->input->post('map_view')) ? $this->input->post('map_view') : 0;
		if($this->input->post('save')){
			$this->mcmodel->mc_save();
			$this->cachemodel->menu_build(1, 0, 'file');
			$this->cachemodel->cache_selector_content('file');
		}
		if($this->input->post('new')){
			$mapsetid = $this->mcmodel->mc_new();
			$this->cachemodel->menu_build(1, 0, 'file');
			$this->cachemodel->cache_selector_content('file');
		}
		$output = array(
			'menu'    => $this->load->view('admin/menu', array(), true)
						.$this->load->view('admin/supermenu', $this->usefulmodel->semantics_supermenu(), true),
			'content'	=> $this->load->view('admin/map_content', $this->mcmodel->mc_show($mapset), true),
		);
		$this->load->view('admin/view', $output);
	}

	public function gis($obj = 0){
		$this->load->model('gismodel');
		$this->usefulmodel->check_admin_status();
		$output = array(
			'menu'    => $this->load->view('admin/menu', array(), true)
						.$this->load->view('admin/supermenu', $this->usefulmodel->semantics_supermenu(), true),
			'content' => $this->gismodel->gis_objects_show($obj)
		);
		$this->load->view('admin/view', $output);
	}

	public function showGis() {
		$this->load->model('gismodel');
		print $this->gismodel->get_gis_property_table();
	}

	public function gisSave() {
		//$this->output->enable_profiler(TRUE);
		$this->usefulmodel->check_admin_status();
		$this->load->model('gismodel');
		$this->load->model('cachemodel');
		
		//return false;
		$this->gismodel->gisSave();
		$this->cachemodel->menu_build(1, 0, 'file');
		$this->cachemodel->cache_selector_content('file');
		$this->cachemodel->build_object_lists();
		//redirect("admin/gis");
	}
	
	/*
	public function saveGisProperty() {
		// переделать под совместимость по входным данным с gis_save()
		$this->usefulmodel->check_admin_status();
		//print $this->adminmodel->saveGisProperty();
	}
	*/

	public function addPropertiesToGroups() {
		//$this->output->enable_profiler(TRUE);
		$this->semanticsmodel->addPropertiesToGroups();
	}

	public function show_semantics() {
		print $this->semanticsmodel->show_semantics($this->input->post('objGroup'), $this->input->post('obj'));
	}

	public function semantics($obj_group = 0, $obj = 0){
		$this->usefulmodel->check_admin_status();
		$values         = $this->semanticsmodel->show_semantics_values($obj_group, $obj);
		$values['list'] = $this->semanticsmodel->show_semantics($obj_group, $obj);
		$output = array(
			'menu'    => $this->load->view('admin/menu', array(), true)
						.$this->load->view('admin/supermenu', $this->usefulmodel->semantics_supermenu(), true),
			'content' => $this->load->view('admin/prop_control_table', $values, true)
		);
		$this->load->view('admin/view', $output);
	}

	public function save_semantics(){
		$this->usefulmodel->check_admin_status();
		$this->semanticsmodel->save_semantics();
	}

	public function usermanager($id=0){
		$this->usefulmodel->check_admin_status();
		$output = array(
			'menu'    => $this->load->view('admin/menu', array(), true)
						.$this->load->view('admin/supermenu', $this->usefulmodel->semantics_supermenu(), true),
			'content' => $this->adminmodel->users_show($id)
		);
		$this->load->view('admin/view', $output);
	}

	public function user_save(){
		$this->usefulmodel->check_admin_status();
		$this->adminmodel->users_save($this->session->userdata("user_id"));
		$this->load->helper('url');
		redirect("/admin/usermanager/".$this->input->post('id'));
	}
	####################################################
	public function groupmanager( $id = 0 ) {
		$this->usefulmodel->check_admin_status();
		$this->load->model('gismodel');
		$output = array(
			'content'      => $this->gismodel->groups_show($id),
			'menu'         => $this->load->view('admin/menu', array(), true)
						     .$this->load->view('admin/supermenu', $this->usefulmodel->semantics_supermenu(), true)
		);
		$this->load->view('admin/view', $output);
	}

	public function group_save(){
		$this->usefulmodel->check_admin_status();
		$this->load->model('gismodel');
		$group_id = $this->gismodel->group_save();
		$this->load->helper('url');
		redirect('admin/groupmanager/'.$group_id);
	}
	####################################################
	/*
	public function swpropsearch($group = 1, $type = 0, $prop = 0, $page){
		$result = $this->db->query("UPDATE
		`properties_bindings`
		SET
		`properties_bindings`.searchable = IF(`properties_bindings`.searchable = 1, 0, 1)
		WHERE 
		`properties_bindings`.property_id = ?
		AND `properties_bindings`.groups  = ?", array($prop, $group));
		redirect('admin/library/'.$group."/".$type."/".$prop."/".$page);
	}

	public function swpropactive($group = 1, $type = 0, $prop = 0, $page){
		$result = $this->db->query("UPDATE properties_list 
		SET properties_list.active = IF(properties_list.active = 1, 0, 1) 
		WHERE 
		properties_list.id = ?", array($prop));
		redirect('admin/library/'.$group."/".$type."/".$prop."/".$page);
	}
	*/
	public function translations($mode = "groups"){
		$this->usefulmodel->check_admin_status();
		$this->config->load('translations_g', FALSE);
		$this->config->load('translations_c', FALSE);
		$this->config->load('translations_p', FALSE);
		$this->config->load('translations_l', FALSE);
		$this->config->load('translations_m', FALSE);
		$this->config->load('translations_a', FALSE);
		$this->config->load('translations_t', FALSE);
		$this->load->model('transmodel');
		$output = array(
			'menu'     => $this->load->view('admin/menu', array(), true)
						 .$this->load->view('admin/supermenu', $this->usefulmodel->semantics_supermenu(), true),
			'content'  => $this->transmodel->translations($mode)
		);
		$this->load->view('admin/view', $output);
	}

	public function trans_save(){
		$this->load->model('transmodel');
		$this->transmodel->trans_save();
		$this->load->model('cachemodel');
		$this->config->load('translations_g');
		$this->config->load('translations_c');
		$this->config->load('translations_p');
		$this->config->load('translations_l');
		$this->config->load('translations_m');
		$this->config->load('translations_a');
		$this->config->load('translations_t');
		$this->cachemodel->menu_build(1, 0, 'file');
		$this->cachemodel->cache_selector_content('file');
		$this->load->helper('url');
		redirect("/admin/translations/".$this->input->post('type'));
	}

	public function aggregatePropertyFields() {
		$mode = $this->input->post('mode');
		$queries = array(
			'labels'  => 'SELECT DISTINCT `properties_list`.`label` AS `value`          FROM `properties_list`',
			'groups'  => 'SELECT DISTINCT `properties_list`.`property_group` AS `value` FROM `properties_list`',
			'subcats' => 'SELECT DISTINCT `properties_list`.`cat` AS `value`            FROM `properties_list`'
		);
		if ( !$mode || !strlen($mode) || !in_array($mode, array_keys($queries)) ) {
			print "";
			return false;
		}
		$result = $this->db->query($queries[$mode]);
		if ($result->num_rows()) {
			$output = array('<option value="0">Выберите значение</option>');
			foreach($result->result() as $row) {
				if (strlen($row->value)) {
					$string = '<option value="'.$row->value.'">'.$row->value.'</option>';
					array_push($output, $string);
				}
			}
			print implode($output, "\n");
			return true;
		}
		print "";
		return false;
	}

	public function savePropertyFields() {
		$mode = $this->input->post('mode');
		//$this->output->enable_profiler(TRUE);
		//return true;
		$queries = array(
			'labels'  => 'UPDATE `properties_list` SET `properties_list`.`label` = ? WHERE `properties_list`.id IN ?',
			'groups'  => 'UPDATE `properties_list` SET `properties_list`.`property_group` = ? WHERE `properties_list`.id IN ?',
			'subcats' => 'UPDATE `properties_list` SET `properties_list`.`cat` = ? WHERE `properties_list`.id IN ?',
			'onoff'   => 'UPDATE `properties_list` SET `properties_list`.`active` = ? WHERE `properties_list`.id IN ?',
			'search'  => 'UPDATE `properties_bindings` SET `properties_bindings`.searchable = ? WHERE `properties_bindings`.groups  = ? AND `properties_bindings`.property_id IN ? '
		);
		if ( !$mode || !strlen($mode) || !in_array($mode, array_keys($queries)) ) {
			print "";
			return false;
		}
		if ($mode !== 'search') {
			$this->db->query($queries[$mode], array($this->input->post('value'), $this->input->post('ids')) );
			return true;
		}
		$this->db->query($queries[$mode], array($this->input->post('value'), $this->input->post('ids'), $this->input->post('og')) );
	}

	public function cacheLocation() {
		$this->load->model('cachecatalogmodel');
		print $this->cachecatalogmodel->cache_location(3, 1, 'screen');
	}

}
/* End of file admin.php */
/* Location: ./system/application/controllers/admin.php */