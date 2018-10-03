<?php
class Nodal extends CI_Controller{
	function __construct(){
		parent::__construct();
	}

	/* UTILS */
	public function dependencycalc() { //запрос из map_calc.js / locations_container.php
		if( !$this->input->is_ajax_request() ) {
			$this->load->view('pagemissing');
			return false;
		}
		if (!$this->input->post("ids") || !is_array($this->input->post("ids")) || !sizeof($this->input->post("ids"))) {
			print '{ "error": "no data sent"}';
			return false;
		}
		$ids    = implode($this->input->post("ids"), ", "); // опробуй конструкцию IN (?) ..., array()
		//print $ids;
		$out    = array();
		$result = $this->db->query("SELECT DISTINCT 
		properties_list.id,
		locations.coord_y,
		locations.coord_array,
		locations.location_name
		FROM
		properties_list
		RIGHT OUTER JOIN properties_assigned ON (properties_list.id = properties_assigned.property_id)
		RIGHT OUTER JOIN locations ON (properties_assigned.location_id = locations.id)
		LEFT OUTER JOIN locations_types ON (locations.`type` = locations_types.id)
		WHERE
		(locations_types.pr_type = 3) AND 
		(properties_list.linked) AND 
		(properties_list.id IN (".$ids."))");
		if ($result->num_rows()) {
			foreach($result->result() as $row) {
				array_push($out, $row->id." : { ym : '".$row->coord_y."', um : ".(strlen($row->coord_array) ? $row->coord_array : "''" )." }");
			}
		}
		print "data = {\n".implode($out, ",\n")."\n}";
	}

	public function gpe($type = 0){
		$out    = array();
		$result = $this->db->query("SELECT
		`locations`.coord_y as coord,
		IF(LENGTH(`locations`.`style_override`) > 1, `locations`.`style_override`, `locations_types`.attributes) as `attributes`,
		`locations_types`.name,
		`locations`.id
		FROM
		`locations`
		INNER JOIN `locations_types` ON (`locations`.`type` = `locations_types`.id)
		WHERE
		`locations`.owner = ?
		AND `locations_types`.id = ?", array(
			$this->session->userdata('user_id'),
			$type
		));
		if($result->num_rows()) {
			foreach($result->result() as $row){
				$string = $row->id." : { attr : '".$row->attributes."' , description : '".$row->name."', ttl: ".$row->id.", contact : '".$row->name."' , coord : '".$row->coord."' , pr : 1 }";
				array_push($out, $string);
			}
		}
		//header('Content-type: text/html; charset=windows-1251');
		print "bo = { ".implode($out, ",\n")."\n}";
	}

	public function getimagelist($lid = 0) {
		$lid    = $this->input->post("picref");
		$out    = array();
		$result = $this->db->query("SELECT
		`images`.filename as img,
		`images`.full,
		`images`.`comment`
		FROM
		`images`
		WHERE
		`images`.`location_id` = ?", array($lid));
		if ($result->num_rows()) {
			foreach ($result->result() as $row) {
				$dim    = explode(",", $row->full);
				$act    = ( sizeof($out) ) ? '' : 'active';
				$string = '<div class="item '.$act.'">
				<img src="/uploads/full/'.$row->img.'" width="'.$dim[0].'" height="'.$dim[1].'" alt=""/>
				<div class="carousel_annot"><h5>'.$row->comment.'</h5></div>
				</div>';
				array_push($out, $string);
			}
			print implode($out, "\n");
			return true;
		}
		print '<div class="item"><img src="/uploads/full/nophoto.jpg" width="128" height="128" alt=""/><div class="carousel_annot"><h5>Изображения отсутствуют</h5></div></div>';
	}

	public function get_objects_by_type() {
		if (!$this->session->userdata('user_id')) {
			print "Время работы в текущей сессии истекло.<br>Завершите работу и введите имя пользователя и пароль заново";
			return false;
		}
		$this->load->model('editormodel');
		print $this->editormodel->get_objects_by_type();
	}

	public function get_object_list_by_type() {
		if (!$this->session->userdata('user_id')) {
			print "Время работы в текущей сессии истекло.<br>Завершите работу и введите имя пользователя и пароль заново";
			return false;
		}
		$this->load->model('editormodel');
		print $this->editormodel->get_object_list_by_type();
	}

	public function moraleup() { //запрос из main_page_content.js 
		$sum = (int) file_get_contents("./morale.txt") + 1;
		file_put_contents( "./morale.txt", $sum );
		print $sum;
	}
}

/* End of file Nodal.php */
/* Location: /application/controllers/Nodal.php */