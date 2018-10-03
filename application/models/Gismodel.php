<?php
class Gismodel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	#######################################################################
	### объекты ГИС VERIFIED
	#######################################################################
	private function get_object_groups_list($object_group){
		$output = array('<option value="0">Выберите группу объектов</option>');
		$result = $this->db->query("SELECT 
		`objects_groups`.id,
		`objects_groups`.name
		FROM
		`objects_groups`
		WHERE
		`objects_groups`.`active`");
		if($result->num_rows()){
			foreach($result->result() as $row){
				array_push($output, '<option value="'.$row->id.'"'.(($row->id == $object_group) ? ' selected="selected"' : '').'>'.$row->name.'</option>');
			}
		}
		return implode($output,"\n");
	}

	private function getImage($type) {
		$pics = array(
			1 => '<img src="'.$this->config->item('api').'/images/marker.png" title="Точечная метка" style="width:16px;height:16px;border:none;" alt="Точечная метка">',
			2 => '<img src="'.$this->config->item('api').'/images/layer-shape-polyline.png" title="Ломаная" style="width:16px;height:16px;border:none;" alt="Ломаная">',
			3 => '<img src="'.$this->config->item('api').'/images/layer-shape-polygon.png" title="Полигон" style="width:16px;height:16px;border:none;" alt="Полигон">',
			4 => '<img src="'.$this->config->item('api').'/images/layer-shape-ellipse.png" title="Круг" style="width:16px;height:16px;border:none;" alt="Круг">',
			5 => '<img src="'.$this->config->item('api').'/images/layer-select.png" title="Прямоугольник" style="width:16px;height:16px;border:none;" alt="Прямоугольник">'
		);
		return $pics[$type];
	}

	public function get_gis_property_table() {
		$output = array();
		$js     = array();
		$result = $this->db->query("SELECT
		locations_types.id,
		locations_types.has_child,
		locations_types.name,
		locations_types.attributes,
		locations_types.object_group,
		locations_types.pl_num,
		locations_types.pr_type,
		objects_groups.name AS object_group_name
		FROM
		objects_groups
		RIGHT OUTER JOIN locations_types ON (objects_groups.id = locations_types.object_group)
		WHERE
		objects_groups.active
		ORDER BY
		object_group_name,
		locations_types.name");
		if ($result->num_rows()) {
			foreach ($result->result_array() as $row){
				//$row = array_merge($row, $this->getImage($row['pr_type']));
				//array_push($output, $this->load->view('admin/parameterline2', $row, true));
				array_push($js, $row['id'].": { name: '".$row['name']."', has_child: ".$row['has_child'].", og: ".$row['object_group'].", attr: '".$row['attributes']."', pr_type: ".$row['pr_type'].", pl_num: ".$row['pl_num'].", img: '".$this->getImage($row['pr_type'])."'}");
			}
		}
		return "data = {\n\t".implode($js, ",\n\t")."\n}";
	}

	public function gis_objects_show($obj = 0) {
		$object = array(
			'id'			=> 0,
			'has_child'		=> 0,
			'name'			=> '',
			'attributes'	=> '',
			'table2'		=> '',
			'object_group'	=> 0,
			'obj'			=> 0,
			'pr_type'		=> 0,
			'pl_num'		=> 0
		);
		if ($obj) {
			$result = $this->db->query("SELECT 
			locations_types.id,
			locations_types.has_child,
			locations_types.name,
			locations_types.attributes,
			locations_types.object_group,
			locations_types.object_group AS `obj`,
			locations_types.pl_num,
			locations_types.pr_type
			FROM
			locations_types
			WHERE 
			locations_types.id = ?", array($obj));
			if($result->num_rows()){
				$object = $result->row_array();
			}
		}
		// дополнительные поля
		$object['obj_group']   = $this->get_object_groups_list($object['object_group']);
		$object['listOfTypes'] = $this->get_gis_property_table();
		return $this->load->view('admin/object_types_control_table', $object, true);
	}

	private function insertObjectMainProperty() {
		$this->db->query("INSERT INTO
		`properties_list` (
			`properties_list`.`row`,
			`properties_list`.element,
			`properties_list`.label,
			`properties_list`.algoritm,
			`properties_list`.selfname,
			`properties_list`.page,
			`properties_list`.property_group,
			`properties_list`.fieldtype,
			`properties_list`.cat,
			`properties_list`.object_group,
			`properties_list`.parameters,
			`properties_list`.active,
			`properties_list`.searchable,
			`properties_list`.coef
		) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )", array(
			1,
			1,
			"Укажите метку",
			'ud',
			$this->input->post('name', true),
			1,
			"",
			"checkbox",
			"",
			$this->input->post('obj_group', true),
			"",
			0,
			1,
			1
		));
		return $this->db->insert_id();
	}

	private function insertObjectType() {
		$insert_id = $this->insertObjectMainProperty();
		$this->db->query("INSERT INTO
		`properties_bindings`(
			`properties_bindings`.property_id,
			`properties_bindings`.groups,
			`properties_bindings`.searchable
		) VALUES( ?, ?, ? )", array(
			$insert_id,
			$this->input->post('obj_group', true),
			0
		));

		$this->db->query("INSERT INTO
		locations_types(
			locations_types.has_child,
			locations_types.name,
			locations_types.attributes,
			locations_types.object_group,
			locations_types.pl_num,
			locations_types.pr_type
		) VALUES ( ?, ?, ?, ?, ?, ? )", array(
			$this->input->post('has_child',  true),
			$this->input->post('name',       true),
			$this->input->post('attributes', true),
			$this->input->post('obj_group',  true),
			$insert_id,
			$this->input->post('pr_type',    true)
		));
		$text = "Администратором ".$this->session->userdata("user_name")." создан тип объекта #".$this->db->insert_id()." - ".$this->input->post('name');
		$this->usefulmodel->insert_audit($text);
	}

	public function gisSave() {
		if (strtolower($this->input->post('obj')) === "false") {
			$this->insertObjectType();
			return true;
		}
		$this->db->query("UPDATE
		locations_types
		SET
		locations_types.has_child    = ?,
		locations_types.name         = ?,
		locations_types.attributes   = ?,
		locations_types.object_group = ?,
		locations_types.pl_num       = ?,
		locations_types.pr_type      = ?
		WHERE
		locations_types.id           = ?", array(
			$this->input->post('has_child',  true),
			$this->input->post('name',       true),
			$this->input->post('attributes', true),
			$this->input->post('obj_group',  true),
			$this->input->post('pl_num',     true),
			$this->input->post('pr_type',    true),
			$this->input->post('obj',        true)
		));
		$this->db->query("UPDATE
		properties_list
		SET
		properties_list.selfname     = ?,
		properties_list.object_group = ?
		WHERE
		properties_list.id           = ?", array(
			$this->input->post('name',      true),
			$this->input->post('obj_group', true),
			$this->input->post('pl_num',    true)
		));
		$text = "Администратором ".$this->session->userdata("user_name")." сохранены параметры типа объекта #".$this->input->post('obj')." - ".$this->input->post('name');
		$this->usefulmodel->insert_audit($text);
	}

	function groups_show($group = 0) {
		$groups = array();
		$output = array(
			'coord'  => $this->session->userdata("map_center"),
			'zoom'   => $this->session->userdata("map_zoom"),
			'icon'   => '',
			'name'   => '',
			'id'     => 0,
			'active' => '<input type="checkbox" value="1" name="active">',
			'schedule' => '<input type="checkbox" value="1" name="hasSchedule">',
		);
		$result = $this->db->query("SELECT 
		`objects_groups`.id,
		`objects_groups`.name,
		`objects_groups`.active,
		`objects_groups`.icon,
		`objects_groups`.hasSchedule,
		`objects_groups`.refcoord,
		`objects_groups`.refzoom
		FROM
		`objects_groups`
		ORDER BY `objects_groups`.active DESC, `objects_groups`.name ASC");
		if($result->num_rows()){
			foreach($result->result() as $row){
				$checked      = ($row->active)      ? 'checked="checked"' : '';
				$hasSchedule  = ($row->hasSchedule) ? 'checked="checked"' : '';
				$checkbox     = ($row->active)      ? "Да"                : "Нет";
				$class        = ($row->active)      ? ' class="success"'  : '';
				$string       = '<tr'.$class.'>
					<td>'.$row->name.'</td>
					<td>'.$row->icon.'</td>
					<td>'.$row->refcoord.'</td>
					<td>'.$row->refzoom.'</td>
					<td>'.$checkbox.'</td>
					<td><a href="/admin/groupmanager/'.$row->id.'" class="btn btn-small btn-primary">Редактировать</a></td>
				</tr>';
				array_push($groups, $string);
				if ($row->id == $group) {
					$output = array(
						'coord'  => (strlen($row->refcoord)) ? $row->refcoord : $this->session->userdata("map_center"),
						'zoom'   => (strlen($row->refzoom))  ? $row->refzoom  : $this->session->userdata("map_zoom"),
						'icon'   => $row->icon,
						'name'   => $row->name,
						'id'     => $row->id,
						'schedule' => '<input type="checkbox" value="1" name="hasSchedule" '.$hasSchedule.'>',
						'active' => '<input type="checkbox" value="1" name="active" '.$checked.'>'
					);
				}
			}
		}
		//print $output['schedule'];
		//exit;
		$output['table'] = implode($groups, "\n");
		return $this->load->view("admin/groupmanager", $output, true);
	}

	function group_save() {
		//$this->output->enable_profiler(TRUE);
		//return false;
		$groupid = $this->input->post('id', true);
		if($this->input->post('mode', true) === 'save') {
			$result = $this->db->query("UPDATE
				`objects_groups`
				SET
				`objects_groups`.refzoom     = ?,
				`objects_groups`.refcoord    = ?,
				`objects_groups`.icon        = ?,
				`objects_groups`.name        = ?,
				`objects_groups`.active      = ?,
				`objects_groups`.hasSchedule = ?
				WHERE
				`objects_groups`.id = ?", array(
				$this->input->post('map_zoom',    true),
				$this->input->post('map_center',  true),
				$this->input->post('icon',        true),
				$this->input->post('name',        true),
				$this->input->post('active',      true),
				$this->input->post('hasSchedule', true),
				$this->input->post('id',          true)
			));
			$text = "Администратором ".$this->session->userdata("user_name")." обновлены параметры группы #".$this->input->post('id', true)." - ".$this->input->post('name', true);
			$this->usefulmodel->insert_audit($text);
		}
		if($this->input->post('mode', true) === 'add') {
			$result = $this->db->query("INSERT INTO
			`objects_groups`(
				`objects_groups`.refzoom,
				`objects_groups`.refcoord,
				`objects_groups`.icon,
				`objects_groups`.name,
				`objects_groups`.active,
				`objects_groups`.hasSchedule
			) VALUES( ?, ?, ?, ?, ?, ?)", array(
				$this->input->post('map_zoom',    true),
				$this->input->post('map_center',  true),
				$this->input->post('icon',        true),
				$this->input->post('name'  ,      true),
				$this->input->post('active',      true),
				$this->input->post('hasSchedule', true)
			));
			$groupid = $this->db->insert_id();
			$text = "Администратором ".$this->session->userdata("user_name")." создана группа #".$groupid." - ".$this->input->post('name', true);
			$this->usefulmodel->insert_audit($text);
		}
		return $groupid;
	}
}

/* End of file gismodel.php */
/* Location: ./system/application/models/gismodel.php */
