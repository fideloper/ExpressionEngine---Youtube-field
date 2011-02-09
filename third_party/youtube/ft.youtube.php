<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Youtube_ft extends EE_Fieldtype {
	
	var $info = array(
		'name'		=> 'Youtube',
		'version'	=> '1.0'
	);
	
	function install() {
		return array(
			'youtube_width'		=> '100',
			'youtube_height'	=> '100'
		);
	}
	
	function display_global_settings() {
		$val = array_merge($this->settings, $_POST);
		
		$form = '<p>'.form_label('Default Width', 'width').'<br >'.form_input('width', $this->settings['youtube_width'], 'style="width:100px;"').'</p>';
		$form .= '<p>'.form_label('Default Height', 'height').'<br >'.form_input('height', $this->settings['youtube_height'], 'style="width:100px;"').'</p>';
	
		return $form;
	}
	
	function save_global_settings() {
		return array_merge($this->settings, $_POST);
	}
	
	function display_settings($data) {		
		if(isset($data['youtube_width']) && isset($data['youtube_height'])) {
			$_width = $data['youtube_width'];
			$_height = $data['youtube_height'];
		} else {
			$_width = $this->settings['youtube_width'];
			$_height = $this->settings['youtube_height'];
		}
		
		$this->EE->table->add_row(
			lang('Width', 'width'),
			form_input(array('id'=>'youtube_width', 'name'=>'youtube_width', 'size'=>4,'value'=>$_width))
		);
		
		$this->EE->table->add_row(
			lang('Height', 'height'),
			form_input(array('id'=>'youtube_height', 'name'=>'youtube_height', 'size'=>4,'value'=>$_height))
		);
	}
	
	function save_settings($data) {
		return array(
			'youtube_width'		=> $this->EE->input->post('youtube_width'),
			'youtube_height'	=> $this->EE->input->post('youtube_height')
		);
	}
	
	function display_field($data) {
		return form_input($this->field_name, $data);
	}
	
	function replace_tag($data, $params = array(), $tagdata = false) {
		//tagdata not working without an extension - see Pixel and Tonic's implementation of Matrix
		/*
		if($tagdata !== false) {
			$return_data = array();
			$return_data[] = array(
				'embed_id' => $data,
				'embed_width' => (isset($params['width'])) ? $params['width'] : $this->settings['youtube_width'],
				'embed_height' => (isset($params['height'])) ? $params['height'] : $this->settings['youtube_height']
			);
			return $this->EE->TMPL->parse_variables($this->EE->TMPL->tagdata, $return_data);
		}
		*/
		
		if(empty($params)) {
			return 'http://www.youtube.com/watch?v='.$data;
		}
		
		if(isset($params['id_only']) && (strtolower($params['id_only']) == 'yes' || strtolower($params['id_only']) == 'true')) {
			return $data;
		}
		
		if(isset($params['embed']) && (strtolower($params['embed']) == 'yes' || strtolower($params['embed']) == 'true')) {
			$_width = (isset($params['width'])) ? $params['width'] : $this->settings['youtube_width'];
			$_height = (isset($params['height'])) ? $params['height'] : $this->settings['youtube_height'];
			/* Older Embed Code
			return '<object width="'.$_width.'" height="'.$_height.'><param name="movie" value="http://www.youtube.com/v/'.$data.'"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'.$data.'" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="'.$_width.'" height="'.$_height.'"></embed></object>';
			*/
			//Newer Embed Code
			return '<iframe title="YouTube video player" width="'.$_width.'" height="'.$_height.'" src="http://www.youtube.com/embed/'.$data.'" frameborder="0" allowfullscreen></iframe>';
			
		}
		
		return $data;
	}
	
	function validate($data) {
		return true; //or error message
	}
	
	function save($data) {
		//We only want to save the youtube ID
		//Get a URL from input entered
		preg_match('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', $data, $matches);
		if(count($matches) > 0) {
			$fixcount = strpos($matches[0], '"');
			if($fixcount > 0) {
				$url = substr($matches[0], 0, $fixcount);
			} else {
				$url = $matches[0];
			}
			
			//Grab 'v' parameter from URL
			$parsed = parse_url($url);
			if(isset($parsed['query'])) {
				parse_str($parsed['query'], $parse_s);
				
				// '?v=VIDEOID' is present in URL
				if(isset($parse_s['v'])) {
					return $parse_s['v'];
				}
			}
			
			// '/v/VIDEOID' is present in URL
			$parampos = strpos($url, '/v/');
			if($parampos > 0) {
				$endpos = strpos($url, '?');
				$video_id = substr($url, ($parampos+3), ($endpos - ($parampos+3)));
				return $video_id;
			}
			
			// '/embed/VIDEOID' is present in URL
			$paramembedpos = strpos($url, '/embed/');
			if($paramembedpos > 0) {
				$embed_video_id = substr($url, ($paramembedpos+7), (strlen($url)-1));
				return $embed_video_id;
			}
		}
		
		//If no match, assume they entered a valid youtube ID (better solution?)
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