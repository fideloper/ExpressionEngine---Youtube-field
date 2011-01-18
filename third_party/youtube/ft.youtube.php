<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Youtube_ft extends EE_Fieldtype {
	
	var $info = array(
		'name'		=> 'Youtube',
		'version'	=> '1.0'
	);
	
	function install() {
		return array(
			'width'		=> '100',
			'height'	=> '100'
		);
	}
	
	function display_global_settings() {
		$val = array_merge($this->settings, $_POST);
	
		$form = form_label('width', 'width').NBS.form_input('width', $val['width']).NBS.NBS.NBS.' ';
		$form .= form_label('height', 'height').NBS.form_input('height', $val['height']);
	
		return $form;
	}
	
	function save_global_settings() {
		return array_merge($this->settings, $_POST);
	}
	
	function display_settings() {		
		$form = form_label('Width', 'width').NBS.form_input('width', $this->settings['width']).NBS.NBS.NBS.' ';
		$form .= form_label('Height', 'height').NBS.form_input('height', $this->settings['height']);
		
		return $form;
	}
	
	function save_settings($data) {
		return array(
			'width'		=> $this->EE->input->post('width'),
			'height'	=> $this->EE->input->post('height')
		);
	}
	
	function display_field($data) {
		return form_input($this->field_name, $data);
	}
	
	function replace_tag($data, $params = array(), $tagdata = FALSE) {
		//template system hither
	}
	
	function validate($data) {
		return true; //or error message
	}
	
	function save($data) {
		return $data;
	}
	
	/* USE IF NEEDED
	function post_save($data) {}
	function delete($ids) {}
	*/
}
// END Youtube_ft class

/* End of file ft.youtube.php */
/* Location: ./system/expressionengine/third_party/youtube/ft.youtube.php */