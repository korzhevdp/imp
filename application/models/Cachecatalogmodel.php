<?php
class Cachecatalogmodel extends CI_Model{
	function __construct(){
		parent::__construct();
		//$this->load->helper('file');
	}

	private function cacheMinimap($coords, $type, $filename) {
		$filename = "images/minimaps/".$filename.".png";
		//if (!file_exists($filename) || !filesize($filename)) {
			$maps   = array(
				1 => "http://static-maps.yandex.ru/1.x/?z=13&l=map&size=128,128&pt=".$coords.",vkbkm",
				2 => "http://static-maps.yandex.ru/1.x/?l=map&size=128,128&pl=".$coords,
				3 => "http://static-maps.yandex.ru/1.x/?l=map&size=128,128&pl=c:ec473fFF,f:FF660020,w:3,".$coords,
				4 => '',
				5 => ''
			);
			return file_put_contents($filename, file_get_contents($maps[$type]));
		//}
		//return "File exists";
	}

	/*
	private function get_category_icon($category){
		$out   = "";
		$icons = array(
			'business' => '<img src="'.$this->config->item('api').'/images/icons/briefcase.png" width="16" height="16" border="0" alt="">',
			'health'   => '<img src="'.$this->config->item('api').'/images/icons/health.png" width="16" height="16" border="0" alt="">',
			'services' => '<img src="'.$this->config->item('api').'/images/icons/service-bell.png" width="16" height="16" border="0" alt="">',
			'other'    => '<img src="'.$this->config->item('api').'/images/icons/information.png" width="16" height="16" border="0" alt="">',
			'sport'    => '<img src="'.$this->config->item('api').'/images/icons/sports.png" width="16" height="16" border="0" alt="">',
			'sights'   => '<img src="'.$this->config->item('api').'/images/icons/photo.png" width="16" height="16" border="0" alt="">'
		);
		if (isset($icons[$category])) {
			$out = $icons[$category];
		}
		return $out;
	}
	*/

	private function getLocationPropertiesResult($location){
		return $this->db->query("SELECT DISTINCT
		if (properties_list.fieldtype = 'select', properties_assigned.value, properties_assigned.property_id) AS property_id,
		properties_assigned.location_id,
		properties_assigned.value,
		if (properties_list.fieldtype = 'select',
			(SELECT
			properties_list.selfname
			FROM
			properties_list
			WHERE 
			properties_list.id = properties_assigned.value
			LIMIT 1),
			properties_list.selfname) AS selfname,
		properties_list.property_group,
		properties_list.cat,
		properties_list.fieldtype,
		properties_list.multiplier,
		properties_list.divider,
		properties_list.coef,
		properties_list.algoritm,
		properties_list.label
		FROM
		properties_assigned
		INNER JOIN properties_list ON (properties_assigned.property_id = properties_list.id)
		WHERE
		properties_assigned.location_id = ?
		AND properties_list.page > 1
		AND properties_list.active
		GROUP BY properties_assigned.property_id
		ORDER BY properties_list.page, properties_list.row, properties_list.element, properties_list.selfname", array($location));
	}

	private function getLocationProperties($location, $lang="ru"){

		$input  = array();
		$output = array();
		
		$result = $this->getLocationPropertiesResult($location);
		if ($result->num_rows()) {
			$this->config->load('translations_p');
			$properties = $this->config->item('properties');
			$this->config->load('translations_c');
			$categories = $this->config->item('categories');
			$this->config->load('translations_l');
			$labels     = $this->config->item('labels');
			foreach ($result->result() as $row) {
				
				$labelD    = ( isset($labels[$row->label]) && strlen(isset($labels[$row->label][$lang])) )
					? $labels[$row->label][$lang]
					: $row->label;
				
				// 'property_group' - устарелое название сущности категории
				$propertyD = ( isset($categories[$row->property_group]) && strlen($categories[$row->property_group][$lang])) 
					? $categories[$row->property_group][$lang]
					: $row->property_group; 
				
				$selfname  = ( isset($properties[$row->property_id]) && strlen($properties[$row->property_id][$lang]) )
					? $properties[$row->property_id][$lang]
					: $row->selfname;

				if (!isset($input[$propertyD])) {
					$input[$propertyD] = array();
				}
				/* Select is a self-labeled element */
				if ($row->fieldtype === "select") {
					$labelD = $labelD.': '.$properties[$row->property_id][$lang];
				}
				/* Otherwise Set A Label First */
				if (!isset($input[$propertyD][$labelD])) {
					$input[$propertyD][$labelD] = array();
				}
				if ($row->fieldtype === "checkbox") {
					$value = '<div class="checkboxLine">'.$selfname.'</div>';
					array_push($input[$propertyD][$labelD], $value);
				}
				if ($row->fieldtype === "textarea") {
					$value = '<p class="textareaLine">'.str_replace("\n", '</p><p class="textareaLine">', $row->value).'</p>';
					array_push($input[$propertyD][$labelD], $value);
				}
				if ($row->fieldtype === "text") {
					$value = $row->value;
					if ($row->algoritm === "me" || $row->algoritm === "le") {
						$value = ($row->coef != 1) ? $value : $value * $row->multiplier / $row-> divider;
					}
					if ($row->algoritm === "pr") {
						$currency = $this->config->item("currency");
						$value .= " &#8381 (".$currency[$lang].")";
					}
					$value = (strlen($value))
						? '<div class="textLine"><span class="propertyName">'.$selfname.'</span>: <span class="propertyValue">'.$value.'</span></div>'
						: '' ;
					array_push($input[$propertyD][$labelD], $value);
				}

			}
		}
		foreach ($input as $propertyGroup => $data) {
			array_push($output, '<div class="higherGroup"><!-- Category:: -->'.$propertyGroup.'</div>');
			foreach ($data as $label => $val) {
				array_push($output, '<div class="groupLabel"><!-- Label:: -->'.$label.'</div><div class="values">'.implode($val, "\n").'</div>');
			}
		}
		return implode($output, "\n");
	}

	public function cacheLocationImages($lid) {
		$output = array();
		$result = $this->db->query("SELECT
		`images`.filename,
		`images`.`mid`
		FROM
		`images`
		WHERE
		`images`.`location_id` = ?
		AND `images`.`active`
		ORDER BY `images`.`order` ASC", array($lid));
		if ( $result->num_rows() ) {
			foreach ($result->result() as $row) {
				$dims   = explode(",", $row->mid);
				$string = '<img src="/uploads/mid/'.$lid.'/'.$row->filename.'" width="'.$dims['0'].'" height="'.$dims['1'].'" class="locationImage">';
				array_push($output, $string);
			}
		}
		return implode($output, "");

	}

	public function cache_location($location = 0, $with_output = 0, $mode = 'file'){
		$act      = array();
		$result = $this->db->query("SELECT
		`locations`.`id`,
		`locations`.`address`,
		`locations`.`contact_info` as contact,
		`locations`.`coord_y`,
		`locations`.`coord_obj`,
		`locations`.`coord_array`,
		`locations`.`parent`,
		`locations`.`location_name`,
		`locations`.`friendly_id`,
		IF(`locations_types`.`pl_num` = 0, '', `locations_types`.`name`) AS `name`,
		`locations_types`.`object_group`,
		`locations_types`.pr_type,
		`locations_types`.id as typeid
		FROM
		`locations`
		INNER JOIN `locations_types` ON (`locations`.`type` = `locations_types`.`id`)
		WHERE locations.id = ?
		OR locations.friendly_id = ?
		LIMIT 1", array($location, $location));
		if ( $result->num_rows() ) {
			$act = $result->row_array(0);
			if ( !in_array($act['pr_type'], array(2, 3)) ) {
				$coords = explode(",", $act['coord_y']);
				$act['lat'] = $coords[0];
				$act['lon'] = $coords[1];
			}
			if ( in_array($act['pr_type'], array(2, 3)) ) {
				$act['lat'] = $act['coord_array'];
				$act['lon'] = $act['coord_y'];
			}
			$act['all_images'] = $this->cacheLocationImages($act['id']);

			$this->cacheMinimap($act['coord_y'], $act['pr_type'], $act['friendly_id']);


			$langs    = $this->config->item('lang');

			foreach($langs as $lang=>$langName) {
				$act['content'] = $this->getLocationProperties($act['id'], $lang);
				$srcFile = $this->load->view('shared/std_view', $act, true);
				if ($mode === 'file') {
					file_put_contents('application/views/cache/locations/location_'.$act['friendly_id']."_".$lang.".src", $srcFile);
				}
			}

			if ($with_output) {
				return file_get_contents('application/views/cache/locations/location_'.$act['friendly_id']."_".$lang.".src");
			}
			return true;
		}
		return "Location ID: ".$location.".&nbsp;&nbsp;&nbsp;&nbsp;Error: Caching Fault: no cache built, no file written. Reason: No data to cache.";

	}
}
#
/* End of file cachecatalogmodel.php */
/* Location: ./application/models/cachecatalogmodel.php */