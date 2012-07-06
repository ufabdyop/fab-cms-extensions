<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8" />
    <?php
        $base_title = 'Utah Nanofab';
        $title = trim(preg_replace('/<!--__FUEL_MARKER__\d*-->/', '', fuel_var('title')));
        if ($title) {
            $title = $base_title . ' : ' . $title;
        } else {
            $title = $base_title;
        }
	$page_title = fuel_var('page_title');
	if ($page_title) {
		$title .= " : $page_title";
	}
    ?>
    <title><?php echo $title;?></title>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
<?php
include(APPPATH.'views/_blocks/skeleton_header.php');
?>
    <link rel="stylesheet" href="<?=site_url() . '/' ?>assets/css/header.css" />
    <link rel="stylesheet" href="<?=site_url() . '/' ?>assets/css/main.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?=site_url() . '/' ?>assets/js/slider/css/style.css" />
    <?php
        if (isset($custom_css)) {
            foreach($custom_css as $css) {
                echo "\t" . '<link rel="stylesheet" href="' . $css . '" />' . "\n";
            }
        }
    ?>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.js"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.14/jquery-ui.min.js"></script>
     <script type="text/javascript" src="<?=site_url() . '/' ?>assets/js/slider/js/script.js"></script> 
     <script type="text/javascript" src="<?=site_url() . '/' ?>assets/js/tabs.js"></script> 
     <script type="text/javascript" src="<?=site_url() . '/' ?>assets/js/homepage.js"></script> 
     <script type="text/javascript" src="<?=site_url() . '/' ?>assets/js/navigation_flyover.js"></script> 
    <?php
        if (isset($custom_js)) {
            foreach($custom_js as $js) {
                echo "\t" . '<script type="text/javascript" src="' . $js . '"></script>' . "\n";
            }
        }
    ?>
    <?php
        if (isset($custom_head)) {
            foreach($custom_head as $head) {
                echo "\t" . $head . "\n";
            }
        }
    ?>

</head>
<body>
    <div id="shadow">
	<div id="decorative_header">
            <div id="login_holder" class="container">
                <?php
		$forward = uri_safe_encode(uri_string());
                if (is_logged_in()) {
                    echo '<a href="' . site_url('fuel/logout' . "/$forward") . '" id="login_link">Logout</a>' . "\n";
                } else {
                    echo '<a href="' . site_url('fuel/login/' . $forward ) . '" id="login_link">Login</a>' . "\n";
                }
                ?>
            </div>
        </div>
    <div class="container<?=(isset($content_class) ? ' ' . $content_class : '')?>">
        <header class="row">
            <div id="campus_elements" class="row eight columns">
		<ul id="campus_links">
		    <li class="decorative" id="rounded_corner">&nbsp;</li>
		    <li><a href="http://www.utah.edu/a-z/">A-Z Index</a></li>
		    <li><a href="http://people.utah.edu/uWho/basic.hml">Directory</a></li>
		    <li><a href="http://www.map.utah.edu/?WT.svl=map_topnav">Map</a></li>
		    <li><a href="http://www.events.utah.edu/?WT.svl=events_topnav">Events</a></li>
		    <li><a href="http://www.employment.utah.edu/">Employment</a></li>
		</ul>
                <form id="search_form" class="clearfix" action="http://www.utah.edu/scripts/searchpage.php" method="get" name="search">
			<input name="qpurl" value="site:www.nanofab.utah.edu" type="hidden"></input>
			<input name="qpname" value="Utah Nanofab" type="hidden"></input>
                        <label class="" id="search_label" for="s">Search</label>
			<div id="search_inner"> <? // I don't like adding divs for styling purposes, but this seems the only way here.?>
				<input id="s" class="searchbox" name="s" type="text" placeholder="Enter Keyword(s)" />
				<select name="searchSelect" id="searchSelect">
				    <option selected="selected" value="web">Choose</option>
				    <option value="website">Website</option>
				    <option value="employee">Faculty/Staff</option>
				    <option value="students">Students</option>
				    <option value="department">Departments</option>
				</select>
				<input id="search_button" class=""  alt="search" src="<?=site_url() . '/' ?>assets/images/header/searchBtn.gif" type="image" />
			</div>
                </form>
            </div>
		<div id="links_container" class="eight columns">
			<a id="u_of_u_home" href="http://www.utah.edu">University of Utah</a>
			<a id="home_link" href="<?=site_url()?>">Utah Nanofab</a>
			<a id="coe_link" href="http://www.coe.utah.edu"> College&nbsp;of&nbsp;Engineering&nbsp;|&nbsp;The&nbsp;University&nbsp;of&nbsp;Utah</a>
		</div>
            <div id="debug_window">
            </div>
		<nav>	
		<?php 
                    $nav = skeleton_nav(array('container_tag_id' => 'navmenu',
                                        'container_tag_class' => 'row', 
                                        'item_id_prefix' => 'navmenu_',
                                        'exclude' => array('/pi_services', '/member_services', '/staff_services')
                                        ));
                    echo $nav;
                    
                ?>
		</nav>
        </header>
