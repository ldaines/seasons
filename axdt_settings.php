<?php
if(!class_exists('axdt_settings_config')) {
	
	class axdt_settings_config {
	 
		// Settings
		var $group = "Group";
		var $page_id = "axdt_display";
		var $title = "Seasons Settings";
		var $intro_text = "This allows you to configure the Seasons Plugin the way you want it";
		var $menu_title = "Seasons";
		var $sections = array(
			'seasons' => array(
				'title' => "Display options",
				'description' => "Define the text for each season",
				'fields' => array (
					'spring' => array (
						'label' => "Spring",
						'description' => "",
						'length' => "",
						'suffix' => "",
						'default_value' => "",
						),
					'summer' => array (
						'label' => "Summer",
						'description' => "",
						'length' => "",
						'suffix' => "",
						'default_value' => "",
						),
					'fall' => array (
						'label' => "Fall",
						'description' => "",
						'length' => "",
						'suffix' => "",
						'default_value' => "",
						),
					'winter' => array (
						'label' => "Winter",
						'description' => "",
						'length' => "",
						'suffix' => "",
						'default_value' => "",
						),
					),
				),
			);
	}
}

if(!class_exists('axdt_settings_config')) {

	class axdt_settings {
	 
		function axdt_settings($settings_class) {
			global $axdt_settings;
			$axdt_settings = get_class_vars($settings_class);

			if (function_exists('add_action')) :
				add_action('admin_init', array( &$this, 'plugin_admin_init'));
				add_action('admin_menu', array( &$this, 'plugin_admin_add_page'));
			endif;
		}

		function plugin_admin_add_page() {
			global $axdt_settings;
			add_options_page($axdt_settings['title'], $axdt_settings['menu_title'], 'manage_options', $axdt_settings['page_id'], array( &$this,'plugin_options_page'));
		}

		function plugin_options_page() {
			global $axdt_settings;
		printf('</pre>
		<div class="icon32" id="icon-options-general"><br></div>
		<div>
		<h2>%s</h2>
		%s
		<form action="options.php" method="post">',$axdt_settings['title'],$axdt_settings['intro_text']);
			settings_fields($axdt_settings['group']);
			do_settings_sections($axdt_settings['page_name']);
			submit_button();
		}
		 
		function plugin_admin_init(){
			global $axdt_settings;
			foreach ($axdt_settings["sections"] AS $section_key=>$section_value) :
				add_settings_section($section_key, $section_value['title'], array( &$this, 'plugin_section_text'), $axdt_settings['page_name'], $section_value);
				foreach ($section_value['fields'] AS $field_key=>$field_value) :
					$function = (!empty($field_value['dropdown'])) ? array( &$this, 'plugin_setting_dropdown' ) : array( &$this, 'plugin_setting_string' );
					$function = (!empty($field_value['function'])) ? $field_value['function'] : $function;
					$callback = (!empty($field_value['callback'])) ? $field_value['callback'] : NULL;
					add_settings_field($axdt_settings['group'].'_'.$field_key, $field_value['label'], $function, $axdt_settings['page_name'], $section_key,array_merge($field_value,array('name' => $axdt_settings['group'].'_'.$field_key)));
					register_setting($axdt_settings['group'], $axdt_settings['group'].'_'.$field_key,$callback);
				endforeach;
			endforeach;
		}

		function plugin_section_text($value = NULL) {
			global $axdt_settings;
			printf("
		%s
		 
		",$axdt_settings['sections'][$value['id']]['description']);
		}
		 
		function plugin_setting_string($value = NULL) {
			$options = get_option($value['name']);
			$default_value = (!empty ($value['default_value'])) ? $value['default_value'] : NULL;
			printf('<input id="%s" type="text" name="%1$s[text_string]" value="%2$s" size="40" /> %3$s%4$s',
				$value['name'],
				(!empty ($options['text_string'])) ? $options['text_string'] : $default_value,
				(!empty ($value['suffix'])) ? $value['suffix'] : NULL,
				(!empty ($value['description'])) ? sprintf("<em>%s</em>",$value['description']) : NULL);
		}
		 
		function plugin_setting_dropdown($value = NULL) {
			global $axdt_settings;
			$options = get_option($value['name']);
			$default_value = (!empty ($value['default_value'])) ? $value['default_value'] : NULL;
			$current_value = ($options['text_string']) ? $options['text_string'] : $default_value;
			$chooseFrom = "";
			$choices = $axdt_settings['dropdown_options'][$value['dropdown']];
			foreach($choices AS $key=>$option) :
				$chooseFrom .= sprintf('<option value="%s" %s>%s</option>',
				$key,($current_value == $key ) ? ' selected="selected"' : NULL,$option);
			endforeach;
			printf('
		<select id="%s" name="%1$s[text_string]">%2$s</select>
		%3$s',$value['name'],$chooseFrom,
			(!empty ($value['description'])) ? sprintf("<em>%s</em>",$value['description']) : NULL);
		}
	}
}

$axdt_settings_init = new axdt_settings('axdt_settings_config');
?>