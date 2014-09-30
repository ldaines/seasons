<?php
/*
Plugin Name: WordPress Seasons
Plugin URI: http://www.axedit.fr/wordpress-seasons/
Description: WordPress Seasons is a simple plugin to automatically modify text depending on the season.
Version: 0.0.1
Author: Lawrence DAINES
Author URI: http://lawrence.daines.fr
License: GPL2
*/
/*  Copyright 2012  Lawrence DAINES  (email : ldaines@axedit.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

include 'settings.php';

function get_season() {

	$period = date('md');
	$spring = '0220';
	$summer = '0620';
	$fall   = '0922';
	$winter = '1221';

	if(($period > $spring) && ($period <= $summer)){
		return 'Spring';
	}elseif (($period > $summer) && ($period <= $fall)){
		return 'Summer';
	}elseif (($period > $fall) && ($period <= $winter)){
		return 'Fall';
	}else{
		return 'Winter';
	}
}

// Shortcode managment
function season_handler () {
	$curseason = get_season();
	$curseason = strtolower ($curseason);
	$textseason = get_option($curseason);
	return $textseason;
}

add_shortcode( 'season', 'season_handler' );

?>