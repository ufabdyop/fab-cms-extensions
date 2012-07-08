<?
/**
 *For use with preg_replace_callback.  Used the matches in the reg expression to replace & with &amp; for xml validation
 * @param type $array
 * @return string 
 */
function skel_clean_urls($array) {
    $index_of_slash = strripos($array[1], '/') ;
    if ($index_of_slash !== false)  {
        $substr = substr($array[1], $index_of_slash + 1);
        $substr = str_replace('&', '&amp;', $substr);
        $return = substr($array[1],0,$index_of_slash + 1) . $substr;
    } else {
        $return = urlencode($array[1]);
    }
    $return = 'href="' . $return . '"';
    return $return;
}

/**
 *Takes a number from 1 to 16 and returns the english spelling of that number (for use in classes in skeleton framework)
 * @param type $num 
 */
function number_to_english($num) {
    $retval = "";
    if ($num == 1) $retval.="one";
    else if ($num == 2) $retval.="two";
    else if ($num == 3) $retval.="three";
    else if ($num == 4) $retval.="four";
    else if ($num == 5) $retval.="five";
    else if ($num == 6) $retval.="six";
    else if ($num == 7) $retval.="seven";
    else if ($num == 8) $retval.="eight";
    else if ($num == 9) $retval.="nine";
    else if ($num == 10) $retval.="ten";
    else if ($num == 11) $retval.="eleven";
    else if ($num == 12) $retval.="twelve";
    else if ($num == 13) $retval.="thirteen";
    else if ($num == 14) $retval.="fourteen";
    else if ($num == 15) $retval.="fifteen";
    else if ($num == 16) $retval.="sixteen";

    return $retval;
}



/**
 * Wrapper for the fuel_helper method fuel_nav.  This calls fuel nav with the options parameter that is passed.
 * It then does some post processing on the returned nav to add skeleton css classes.
 * 
 * @param type $options 
 */
function skeleton_nav($options) {
        $total_columns = 16;
        
        $nav = fuel_nav($options); 
        $nav = preg_replace_callback('#href="([^"]*)"#si', 'skel_clean_urls', $nav);
        $nav = str_replace('&', '&amp;', $nav);

	if ($nav == "") {
		return;
	}

        $nav_xml = new SimpleXMLElement($nav);
        $columns_per_nav_item = floor( $total_columns / $nav_xml->count() );
        $remainder = $total_columns % $nav_xml->count();
        $class = number_to_english($columns_per_nav_item) . ' ' . ($columns_per_nav_item > 1 ? ("columns") : "column");
        
        //slurp up the rest of the columns for the last nav item
        $columns = $columns_per_nav_item + $remainder;
        $last_class = number_to_english($columns) . ' ' . ($columns > 1 ? ("columns") : "column");
        
        //$columns_per_nav_item = 
        foreach($nav_xml as $li) {
            
            $attr = $li->attributes();
            if (isset($li->attributes()->class)) {
                if ($li->attributes()->class == "last") {
                    $attr['class'] .= " $last_class omega";
                } else {
                    $attr['class'] .= " $class";
                }
            } else {
                $li->addAttribute('class', $class);
            }
        }
        echo str_replace('<?xml version="1.0"?>', '', $nav_xml->asXML());
        //echo "nav is $nav\n";
}
?>
