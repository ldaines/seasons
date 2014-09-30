<?php

/* ------------------------------------------------------------------------ *
 * Setting Registration
 * ------------------------------------------------------------------------ */

/**
 * Initializes the options page by registering the Sections, Fields, and Settings.
 *
 * This function is registered with the 'admin_init' hook.
 */

add_action('admin_init', 'axdt_initialize_options');

function axdt_initialize_options() {

    // First, we register a section. This is necessary since all future options must belong to one.  
	add_settings_section(
		'seasons_settings_section',         // ID used to identify this section and with which to register options
		'Seasons Options',                  // Title to be displayed on the administration page
		'seasons_general_options_callback', // Callback used to render the description of the section
		'general',                          // Page on which to add this section of options
	);

	// Next, we will introduce the fields.
	add_settings_field(
		'axdt_spring',                      // ID used to identify the field throughout the theme
		'Spring',                           // The label to the left of the option interface element
		'seasons_spring_callback',   		// The name of the function responsible for rendering the option interface
		'general',                          // The page on which this option will be displayed
		'seasons_settings_section',         // The name of the section to which this field belongs
		array(                              // The array of arguments to pass to the callback. In this case, just a description.
			'Set the text you want to show when season is spring.'
		),
	);
	add_settings_field(
		'axdt_summer',
		'Summer',
		'seasons_summer_callback',
		'general',
		'seasons_settings_section',
		array(
			'Set the text you want to show when season is summer.'
		),
	);
	add_settings_field(
		'axdt_fall',
		'Fall',
		'seasons_summer_callback',
		'general',
		'seasons_settings_section',
		array(
			'Set the text you want to show when season is fall.'
		),
	);
	add_settings_field(
		'axdt_winter',
		'Winter',
		'seasons_winter_callback',
		'general',
		'seasons_settings_section',
		array(
			'Set the text you want to show when season is winter.'
		),
	);

	// Finally, we register the fields with WordPress
	register_setting(
		'general',
		'axdt_spring'
	);
	register_setting(
		'general',
		'axdt_summer'
	);
	register_setting(
		'general',
		'axdt_fall'
	);
	register_setting(
		'general',
		'axdt_summer'
	);
} // end axdt_initialize_options

/* ------------------------------------------------------------------------ *
 * Section Callbacks
 * ------------------------------------------------------------------------ */

/**
 * This function provides a simple description for the General Options page.
 *
 * It is called from the 'axdt_initialize_options' function by being passed as a parameter in the add_settings_section function.
 */
 
function seasons_general_options_callback() {
	echo '<p>Define the text you wish to display according to the season.</p>';
}

/**
 * This function renders the interface elements.
 *
 * It accepts an array of arguments and expects the first element in the array to be the description.
 */

function seasons_spring_callback($args) {

    // Note the ID and the name attribute of the element should match that of the ID in the call to add_settings_field  
    $html = '<input type="textarea" id="spring" name="spring" value="1" ' . get_option('spring') . '/>';  
      
    // Here, we will take the first argument of the array and add it to a label next to the checkbox  
    $html .= '<label for="show_header"> '  . $args[0] . '</label>';  
      
    echo $html;  
      
} // end sandbox_toggle_header_callback

?>