<?php

/**
*
* @param $list is key value array: keys are urls, values are titles
*
*/
function breadcrumb($list = array()) {
	$separator = "&nbsp;:&nbsp;";
	$tag_id = "breadcrumb";
	$homelink = site_url();
	$homelink_title = "Utah Nanofab";
	$buf = "<ul id=\"$tag_id\">\n";
	$buf .= "\t<li><a href=\"$homelink\">$homelink_title</a></li>\n";
	$count = 1;
	foreach($list as $url => $title) {
		$link = "\t<a href=\"$url\">$title</a>\n";	
		if ($count == count($list) ) {
			$link = "\t<span>$title</span>\n";	
		}
		$buf .= "<li>$separator$link</li>\n";
		$count++;
	}
	$buf .= "</ul>\n";
	return $buf;
}
?>
