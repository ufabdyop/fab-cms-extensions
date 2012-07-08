		<nav id="servicesmenu">
		    <h3>Services</h3>
		    <ul>
			<li class="current">
			    <a href="#member_services">Member Services</a>
			    <ul>         
				<li><a href="<?=site_url('index/about-us/Home/lab-members/becomeamember')?>">Become a Member</a></li>
				<li><a href="<?=site_url('need_help')?>">Need Help?</a></li>
				<li><a href="<?=site_url('trainingvideos')?>">Training Videos</a></li>
				<li><a href="<?=site_url('unlock_card/unlock_card.php')?>">Unlock Card</a></li>
				<li><a href="<?=site_url('top_monitor/')?>">Users in Lab</a></li>
				<li><a href="<?=site_url('index/about-us/lab-members/career-info')?>">Career Opportunities</a></li>
				<li><a href="<?=site_url('buddy-tools')?>">Buddy System Tools</a></li>
				<li><a href="<?=site_url('Procedures')?>">Procedures</a></li>
				<li><a href="http://coral.nanofab.utah.edu">Coral</a></li>
			    </ul>
			</li>
			<li>
			    <a href="#pi_services">PI Services</a>
			    <ul>         
				<li><a href="<?=site_url('top_monitor')?>">Users in Lab</a></li>
				<li><a href="<?=site_url('BillingRates')?>">Billing Rates and Forms</a></li>
				<li><a href="<?=site_url('FundingOpportunities')?>">Funding Opportunities</a></li>
				<li><a href="http://coral.nanofab.utah.edu/reports">Reports</a></li>
				<li><a href="<?=site_url('uploads/pdfs/Seed%20Fund%20Application.pdf')?>">Preliminary Data Seed Fund</a></li>
				<li><a href="<?=site_url('index/about-us/marketing-information')?>">Marketing Information</a></li>
				<li><a href="<?=site_url('ProposalSupport')?>">Proposal Support</a></li>
				<li><a href="<?=site_url('ci_plugins/equipment/move_status')?>">Equipment Move Dates</a></li>
				<li><a href="<?=site_url('./ci_plugins/tmp/uploads/openmsp/html/gantt.html')?>">USTAR Move Gantt Chart</a></li>
			</ul>
			</li>
			<li>
			    <a href="#staff_services">Staff Services</a>
			    <ul>         
				<li><a href="https://www.eng.utah.edu/mf/index.php">Card Manager</a></li>
				<li><a href="http://coral.nanofab.utah.edu:8080/svnwebclient">Document Manager</a></li>
				<li><a href="http://radiolab.eng.utah.edu/pwa">Task Management</a></li>
				<li><a href="http://coral.nanofab.utah.edu/reports">Reports</a></li>
				<li><a href="<?=site_url('./ci_plugins/tmp/uploads/openmsp/html/gantt.html')?>">USTAR Move Gantt Chart</a></li>
                                <?php
                                    if ( function_exists('has_role') && has_role('staff')) {
                                        echo "\n<!-- has_role exists -->\n";
                                        ?>
                                        <li><a href="http://155.98.11.21/">DVR System</a></li>
                                        <li><a href="<?=site_url('upload_gantt/')?>">Update Gantt Chart</a></li>
                                        <li><a href="http://155.98.26.124/">Gas Monitoring</a></li>
                                        <li><a href="http://155.98.11.21/">DVR System</a></li>
                                        <li><a href="https://www.nanofab.utah.edu/sv/">Password Manager</a></li>
                                        <li><a href="/gallery/zp-core">Gallery Admin</a></li>
                                        <?
                                    } else {
                                        echo "\n<!-- has_role does not exist -->\n";
                                    }
                                ?>
				<li><a href="/tool-move-checklist">Tool Move Checklist</a></li>
			    </ul>
			</li>
		    </ul>
		</nav>
