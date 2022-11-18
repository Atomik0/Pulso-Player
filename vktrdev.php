<?php
    /*
    Plugin Name: Radio Pulso Player
    Plugin URI: https://www.vktrdev.cl/
    Description: Shoutcast de RadioPulso.fm
    Version: 1.0
    Author: VKTRDev.cL
    Author URI: https://www.vktrdev.cl/
    License: GPL2
    */
    
    function addPlayerToSite() {
    	include("player.php");
    }
    
    add_action('wp_footer', 'addPlayerToSite');
?>