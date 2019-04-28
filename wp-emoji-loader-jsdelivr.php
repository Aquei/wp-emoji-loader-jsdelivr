<?php

/**
 * emojiのコードをjsdelivrから読み込む
 *
 * @link https://github.com/Aquei/wp-emoji-loader-jsdelivr
 * @since 1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:       wp-emoji-loader-jsdelivr
 * Plugin URI:        https://github.com/Aquei/wp-emoji-loader-jsdelivr
 * Description:       emojiのコードをjsdelivrから読み込む
 * Version:           1.0.0
 * Author:            Aquei
 * Author URI:        https://blog.srytk.com/aquei/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       emoji
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

//current ver
define('WP_EMOJI_LOADER_JSDELIVR', '1.0.0');

function enqueue_emoji_detection_script(){
	wp_enqueue_script('external-emoji-loader-script', "https://cdn.jsdelivr.net/combine/gh/Aquei/wp-emoji-loader-jsdelivr@1.0.0/wpemojisettings-jsdelivr.js,gh/WordPress/WordPress@{$wp_version}/wp-includes/js/wp-emoji-loader.min.js", [], null);

	add_filter("script_loader_tag", "nonblocking_emoji_detection_script", 10, 2); 
}

function nonblocking_emoji_detection_script($tag, $handle){
	if($handle === "external-emoji-loader-script" && strpos($tag, " async") === false){
		return str_replace(" src=", " async defer src=", $tag);
	}else{
		return $tag;
	}
}

function enqueue_emoji_style(){
	wp_enqueue_style('external-emoji-style', "https://cdn.jsdelivr.net/combine/gh/Aquei/wp-emoji-loader-jsdelivr@1.0.0/wp-emoji-style.min.css", [], null);
}



function wp_emoji_loader_jsdelivr(){

	$s_action = "print_emoji_styles";
	$s_hooks = ["wp_print_styles", "admin_print_styles"];
	$s_flag = false;

	foreach($s_hooks as $s_hook){
		if(has_action($s_hook, $s_action)){
			$result = remove_action($s_hook, $s_action);
		}

		if($result && !$s_flag){
			$s_flag = true;
		}
	}

	if($s_flag){
		add_action("wp_enqueue_scripts", "enqueue_emoji_style");
	}else{
		throw new Exception("no flag");
	}

	$action = "print_emoji_detection_script";
	$hooks = ["wp_head", "admin_print_scripts", "embed_head"];
	$prio = ["wp_head" => 7];
	
	$flag = false;

	foreach($hooks as $hook){
		if(has_action($hook, $action)){
			if(array_key_exists($hook, $prio)){
				$priority = $prio[$hook];
			}else{
				$priority = 10;
			}

			$result = remove_action($hook, $action, $priority);
			if($result && !$flag){
				$flag = true;
			}
		}
	}
	
	if($flag){
		add_action("wp_enqueue_scripts", "enqueue_emoji_detection_script");
	}
}

add_action("init", "wp_emoji_loader_jsdelivr");