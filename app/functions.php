<?php

/**
 * link with active route state
 */
HTML::macro('smartRoute_link', function($route, $text, $icon = '') {
    if(Request::is($route) || Request::is($route.'/*')) {
        $active = " class='active'";
    }
    else {
        $active = "";
    }
    return '<li'.$active.'><a href="'.url($route).'">'.$icon.' '.$text.'</a></li>';
});

/**
 * @param $string
 * @return string
 * safe name, no croatian letters
 */
function safe_name($string) {
    $string = preg_replace('/&scaron;/', 's', $string);   //'š' letter fix
    $trans = array("š" => "s", "æ" => "c", "è" => "c", "ð" => "d", "ž" => "z", " " => "_", ">" => "", "<" => "");

    return strtr(mb_strtolower($string, "UTF-8"), $trans);
}

/**
 * @param $string
 * @return string
 * string like slug URL, uses @safe_name() function
 */
function string_like_slug($string){
    $trans = array("_" => "-");

    return strtr(safe_name($string), $trans);
}

/**
 * @param $image_name
 * @return string
 * return image name without extension for alt attribute of HTML <img> tag
 */
function imageAlt($image_name){
    return substr($image_name, 0, -4);
}