<?php $this->load->view('_blocks/header')?>
    <?
        $blog_lib = $this->load->module_library(BLOG_FOLDER, 'Fuel_blog');  
        $news=$blog_lib->get_category_posts('News',"date_added desc");
        $events=$blog_lib->get_category_posts('Events',"date_added desc");
    ?>


    <div class="row">
	<div class="twelve columns">
		<div id="slider" class="row">
			<?php $this->load->view('_blocks/banner')?>
		</div>
		<div class="twelve columns">
			<ul id="news_tabs" class="tabs">
				<li><a class="active" href="#about">About Us</a></li>
				<li><a href="#news">News</a></li>
				<li><a href="#events">Events</a></li>
				</ul>

				<!-- Standard <ul> with class of "tabs-content" -->
				<ul class="tabs-content" id="frontpage_news">
				<!-- Give ID that matches HREF of above anchors -->
				<li class="active" id="about">
					<h4>Mission Statement</h4>
					<p>&quot;The Utah Nanofab advances leading edge research, and facilitates economic growth by providing world-class nanofabrication facilities, infrastructure, and staff to academia and industry.&quot;</p>
					<h4>Vision Statement</h4>
					<p>&quot;The Utah Nanofab will become a recognized leader in innovation and a premier nanotechnology center with an interface to biomedical sciences. Through the efforts of the Utah Nanofab, the frontiers of research will be expanded, the next generation of engineers and leaders will be educated, and economic growth will be supported by the sustainable transfer of technology into meaningful commercialization outcomes.&quot;</p>
					<h4>Core Values</h4>
					<p>Empowering, Serving and Safeguarding the Nanofab Community</p>
					<h5>Empower</h5>
					<p>We believe exceptional quality and accessibility reinforce our commitment to serve as a core facility. We support collaboration by building partnerships across academic disciplines, business and industry. We create an environment that is conducive to learning, innovation, and success. We serve as a catalyst for economic development in Utah and beyond. We enable the academic and local industrial community with a strong commitment to excellence in research and innovation.</p>
					<h5>Serve</h5>
					<p>We seek effective and efficient ways to better serve our lab members. We strive to provide quality tools, technologies, processes, and facilities for learning, understanding, and developing new technology. We anticipate the needs of those we serve and offer proactive and flexible solutions. We are motivated to initiate and adapt to change for improving our work and community.</p>
					<h5>Safeguard</h5>
					<p>We instill a discipline of safety throughout our facility and in all aspects of our work. We are committed to providing a safe work environment through training, communication, and quality resources.</p>
				</li>
				<li id="news">
					<a href="/blog/categories/news/feed" id="news_feed" class="rss_link">Subscribe</a>
                                    <?
                                        foreach($news as $story) {
                                            echo "<div class=\"news_story\">\n";
                                            echo "<h4>$story->title</h4>\n";
                                            echo "<i>" . $story->get_date_formatted() . "</i>\n";
                                            echo "<p>" . $story->get_content_formatted() . "</p>\n";
                                            echo "</div>\n";
                                        }
                                    ?>
                                </li>
				<li id="events">
					<a href="/blog/categories/events/feed" id="events_feed" class="rss_link">Subscribe</a>
                                    <?
                                        foreach($events as $story) {
                                            echo "<div class=\"news_story\">\n";
                                            echo "<h4>$story->title</h4>\n";
                                            echo "<i>" . $story->get_date_formatted() . "</i>\n";
                                            echo "<p>" . $story->get_content_formatted() . "</p>\n";
                                            echo "</div>\n";
                                        }
                                    ?>
                                </li>
			</ul>
		</div>
	</div>
        <div class="four columns" >
            <?php $this->load->view('_blocks/servicesmenu')?>

            <div id="affiliations">
                <h3>Affiliated With:</h3>
                <ul>
                <li id="nanoinstitute"><a href="http://nanoinstitute.utah.edu/"><img width="160" alt="Nano Institute of Utah" src="assets/images/affiliations/Nano_Institute_stacked.png" /></a></li>
                <li><a href="http://mrsec.org/"><img width="160" alt="MRSEC" src="assets/images/affiliations/mrsec_logo_1.png" /></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="row clearfix sixteen columns" id="homepage_content">

    
<? $this->load->module_helper(FUEL_FOLDER,'fuel');
echo fuel_var('body');
?>
    
<?php $this->load->view('_blocks/footer')?>
