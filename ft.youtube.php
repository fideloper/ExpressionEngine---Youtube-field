<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Youtube_ft extends EE_Fieldtype {

	var $info = array(
		'name'		=> 'Youtube',
		'version'	=> '1.2'
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

		// Look for url_params to add to the url, construct the full embed url.
		$url_params = (isset($params['url_params'])) ? $params['url_params'] : false ;
		$url = 'http://www.youtube.com/embed/'.$data.(($url_params !== false) ? '?'.$url_params : '' );

		if(empty($params) || !isset($params['display'])) {
			return $url;
		}

		switch(strtolower($params['display'])) {
			case 'id':
			case 'id_only':
				return $data;
				break;
			case 'embed':
				$_width = (isset($params['width'])) ? $params['width'] : $this->settings['youtube_width'];
				$_height = (isset($params['height'])) ? $params['height'] : $this->settings['youtube_height'];
				return '<iframe title="YouTube video player" width="'.$_width.'" height="'.$_height.'" src="'.$url.'" frameborder="0" allowfullscreen></iframe>';
				break;
			case 'url':
			default:
				return $url;
				break;
		}

		return $data;
	}

	function validate($data) {
		return true; //or error message
	}

	function save($data) {
		//We only want to save the youtube ID
		//Get a URL from input entered (User might enter in iframe code, a standard url, a share url, etc)
		preg_match('@((https?://)?([-\w]+\.[-\w\.]+)+\w(:\d+)?(/([-\w/_\.]*(\?\S+)?)?)*)@', $data, $matches);
		if(count($matches) > 0) {
			$fixcount = strpos($matches[0], '"');
			if($fixcount > 0) {
				$url = substr($matches[0], 0, $fixcount);
			} else {
				$url = $matches[0];
			}


			$parsed = parse_url($url);

			//youtu.be/VIDEOID is used:
			if($parsed['host'] == 'youtu.be' && $parsed['path'] != '') {
				return str_replace('/', '', $parsed['path']);

			//else Grab 'v' parameter from URL
			} elseif(isset($parsed['query'])) {
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
				return substr($url, ($parampos+3), ($endpos - ($parampos+3)));
			}

			// '/embed/VIDEOID' is present in URL
			$paramembedpos = strpos($url, '/embed/');
			if($paramembedpos > 0) {
				return substr($url, ($paramembedpos+7), (strlen($url)-1));
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
