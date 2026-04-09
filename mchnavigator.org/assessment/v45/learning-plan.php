<?php
include("../account/cookie.php");
require_once __DIR__ . '/../../filemaker/data-api.php';
$section = 'assessment';
$page = 'personal';
$page_title = "Self-Assessment";
include ('../../incl/header.html');

// display past results function
$priorities = array();
$understandings = array();
function getPlan($section){
	global $uID, $priorities, $understandings;
	$plan = true;

	$request = array(
		'database' => 'MCH-Navigator',
		'layout' => 'SA_Responses_v45',
		'action' => 'find',
		'parameters' => array(
			'query' => array(
				array(
					'uID' => '=' . (int) $uID,
					'section' => '=' . (int) $section,
				),
			),
			'sort' => array(
				array(
					'fieldName' => 'date',
					'sortOrder' => 'descend',
				),
			),
			'limit' => 1,
		),
	);
	$result = do_filemaker_request($request, 'array');

	if ((int) ($result['messages'][0]['code'] ?? 500) !== 0 || empty($result['response']['data'][0])) {
		#echo $result->getMessage();
		echo '<p>You have not yet completed this Competency.</p>';
		$priorities[$section] = "null";
		$understandings[$section] = "null";
	} else {
		$record = $result['response']['data'][0];
		$rID = $record['fieldData']['rID'] ?? '';
		#echo '<div class="accordion" id="competency'.sprintf('%02d', $section).'"><p class="aHead">click to see detailed results</p><div class="toggleContent">';
		include("competency_past.php");
		#echo '</div></div>';
	}
}
?>
<link rel="stylesheet" href="../styles.css">
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
	<?php include('../../incl/leftnav.html'); ?>
	<div class="nine columns">
		<?php include('../../incl/title.html'); ?>

		<div id="printarea">

			<h2>MCH Navigator Personalized Learning Plan</h2>

			<p><strong>Thank you for taking the self-assessment; please scroll down the page to view your results.</strong></p>
			<p>We present a graphical summary of you strengths are needed areas of grown below. For each competency, a short summary of the relative importance of that topic and your knowledge and skills is presented; you can access details for each competency under that summary.</p>
			<p>For each competency, the learning plan outlines next steps in a<strong> Ready-Set-Go</strong> approach.</p>
			<ul>
				<li><strong>Ready.</strong> Access a peer-reviewed or field-generated article to gain a grounding in the science behind the competency.</li>
				<li><strong>Set.</strong> Dig into a detailed summary of your knowledge and skills. Click on each sub-competency to dig deeper with trainings chosen to match your knowledge or skill level.</li>
				<li><strong>Go.</strong> Learn about and download an implementation-based tool to move you from knowledge to action. </li>
			</ul>
			<div class="row">
				<div class="six columns">
					<p>Your results have been saved, so you can return to this plan to track your progress and access your learning opportunities at any time. You can also <a href="#" onClick="javascript:window.print();">print your results</a>. Note: if you would like a PDF of your results, use the &quot;print&quot; option and then save the file as a PDF (see Adobe's <a href="https://helpx.adobe.com/acrobat/using/print-to-pdf.html">general instructions</a> on how to do this).</p>
					<p>You can also take the self-assessment (in whole or in part) again to track your progress over time. You can also see <a href="past-results.php">past results for each competency</a> that you have taken to track your progress over time.</p>
				</div>
				<div class="six columns">
					<div class="blk">
						<img src="../../images/print.jpg" alt="5min MCH" class="i_blk">
						<a href="#" onClick="javascript:window.print();" class="l_blk" style="background: #2075bc;">Print</a>
					</div>
					<!-- <div class="blk">
                    <img src="../../images/download.jpg" alt="5min MCH" class="i_blk">
                    <a href="#" onClick="javascript:getpage('pdf');" class="l_blk" style="background: #faa937;">Download PDF</a>
                </div> -->
					<div class="blk">
						<img src="../../images/save.jpg" alt="5min MCH" class="i_blk">
						<a href="csv4.php" target="_blank" class="l_blk" style="background: #8dc641;">Save as CSV</a>
					</div>
					<!-- <div class="blk">
                    <img src="../images/headers/comments.jpg" alt="5min MCH" class="i_blk">
                    <a href="#" onClick="javascript:getpage('email');" class="l_blk" style="background: #d91f5d;">Email</a>
                </div> -->
				</div>
			</div>


			<p><strong>We are collecting feedback! </strong>Please take a moment to fill out <a href="../feedback.php" target="_blank"><strong>feedback</strong></a> on this MCH Navigator product.</p>


			<button class="accordion"> <strong><i class="icon mch-check-square-o" aria-hidden="true"></i> Tips.</strong> Follow these quick tips to learn more</button>
			<div class="panel">
				<p>In thinking about how to improve your knowledge and skills, here are some tips to help you: </p>
				<ul>
					<li><strong>Recognize your strengths</strong> as well as areas where you need to grow. You bring substantial knowledge and skills to MCH. This plan is designed to give suggestions on how to strengthen what you already know.</li>
					<li><strong>Don't be overwhelmed</strong> by the list of learning opportunities we have selected for you. What you have received is a listing of all the trainings that match your knowledge or skill level for each competency. To begin learning more, you can choose the most interesting training and then go from there. </li>
					<li><strong>Return to this plan</strong> over time to continually expand your knowledge and skills, track your learning over time, and to stay motivated.</li>
				</ul>
			</div>

			<button class="accordion"> <strong><i class="icon mch-bubble" aria-hidden="true"></i> Questions.</strong> Ask yourself these questions before beginning</button>
			<div class="panel">
				<p>As you think about what you want to accomplish with this personalized learning plan, you may want to ask yourself:</p>
				<ul>
					<li><strong>Who</strong>: Who can help me in growing my knowledge and skills? Who are your potential mentors and guides?</li>
					<li><strong>What: </strong>What knowledge or skills do I need to learn or to improve? What are my markers for success?</li>
					<li><strong>Where: </strong>Where can I test my newly acquired knowledge? Where can I find additional opportunities to learn?</li>
					<li><strong>When: </strong>When can I find time - and how much time do I need - to devote to these areas of professional development?</li>
					<li><strong>Why: </strong>Why do I lose motivation in learning, and what resources can I find to maintain momentum?</li>
					<li><strong>How</strong>: How can I further enhance my competence as an MCH professional? How can I share this information with others?</li>
				</ul>
			</div>

			<button class="accordion"> <strong><i class="icon mch-trophy" aria-hidden="true"></i> Stay Motivated.</strong> Try these tricks to keep momentum going</button>
			<div class="panel">
				<p>Staying motivated to learn more can be difficult as a public health professional. Competing demands, tight deadlines, and lack of time are issues that we all deal with. To use this personalized learning plan successfully, we have identified some quick tips and tricks for maintaining your motivation and momentum as you advance your knowledge and skills:</p>
				<ul>
					<li><a href="https://www.youtube.com/watch?v=u6XAPnuFjJc">Drive: The Surprising Truth About What Motivates Us</a> from RSA Action and Research Centre (video).</li>
					<li><a href="http://www.ted.com/search?q=motivation">Staying Motivated</a> from TED Talks (videos).</li>
					<li><a href="http://www.lifehack.org/articles/productivity/how-to-stay-motivated.html">How to Stay Motivated</a> 5 Tips from LifeHack (web page).</li>
					<li><a href="http://www.forbes.com/sites/nextavenue/2013/07/19/how-to-stay-motivated-and-accomplish-anything/">How To Stay Motivated and Accomplish Anything</a> from Forbes (web page).</li>
				</ul>
			</div>


			<div id="container" style="height: 400px; margin: 2rem 0" class="noprint"></div>

			<section class="well">
				<h2 class="superheader"><i class="icon mch-user" aria-hidden="true"></i> SELF</h2>
				<h2 class="superheader">Competency 1: MCH Knowledge Base/Context</h2>
				<?php getPlan(1); ?>
				<hr>
				<h2 class="superheader">Competency 2: Self-Reflection</h2>
				<?php getPlan(2); ?>
				<hr>
				<h2 class="superheader">Competency 3: Ethics</h2>
				<?php getPlan(3); ?>
				<hr>
				<h2 class="superheader">Competency 4: Critical Thinking</h2>
				<?php getPlan(4); ?>
			</section>

			<section class="well">
				<h2 class="superheader"><i class="icon mch-users" aria-hidden="true"></i> OTHERS</h2>
				<h2 class="superheader">Competency 5: Communication</h2>
				<?php getPlan(5); ?>
				<hr>
				<h2 class="superheader">Competency 6: Negotiation and Conflict Resolution</h2>
				<?php getPlan(6); ?>
				<hr>
				<h2 class="superheader">Competency 7: Community Health Factors</h2>
				<?php getPlan(7); ?>
				<hr>
				<h2 class="superheader">Competency 8: Lived Experience in MCH</h2>
				<?php getPlan(8); ?>
				<hr>
				<h2 class="superheader">Competency 9: Teaching Coaching, and Mentoring</h2>
				<?php getPlan(9); ?>
				<hr>
				<h2 class="superheader">Competency 10: Interdisciplinary/Interprofessional Team Building</h2>
				<?php getPlan(10); ?>
			</section>

			<section class="well">
				<h2 class="superheader"><i class="icon mch-globe" aria-hidden="true"></i> WIDER COMMUNITY</h2>
				<h2 class="superheader">Competency 11: Systems Thinking</h2>
				<?php getPlan(11); ?>
				<hr>
				<h2 class="superheader">Competency 12: Policy</h2>
				<?php getPlan(12); ?>
			</section>


			<script src="https://cdn.ncemch.org/js/jquery/jquery.min.js"></script>
			<script src="/js/common.min.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/highcharts/4.0.4/highcharts.js"></script>
			<script src="//cdnjs.cloudflare.com/ajax/libs/highcharts/4.0.4/modules/exporting.js"></script>
			<script>
			$(function() {
				$('#container').highcharts({
					chart: {
						type: 'line',
						inverted: true
					},
					title: {
						text: null
					},
					subtitle: {
						text: null
					},
					xAxis: [{
						categories: ['1: MCH Knowledge Base/Context', '2: Self-Reflection', '3: Ethics', '4: Critical Thinking', '5: Communication', '6: Negotiation and Conflict Resolution', '7: Community Health Factors', '8: Lived Experience in MCH', '9: Teaching, Coaching and Mentoring', '10: Interdisciplinary/Interprofessional Team Building', '11: Systems Thinking', '12: Policy'],
						type: 'linear',
						tickmarkPlacement: "on",
						min: 0,
						max: 11
					}],
					yAxis: [{ // Primary yAxis
						categories: ["None", "Low", "Medium", "High"],
						type: 'linear',
						max: 3,
						tickmarkPlacement: "on",
						tickColor: "#eeeeee",
						labels: {
							rotation: -45
						},
						title: {
							text: null
						}
					}],
					tooltip: {
						enabled: true,
						crosshairs: [true, true],
						followPointer: true,
						formatter: function() {
							var Number2Text = ["No", "Low", "Medium", "High"];
							return Number2Text[Math.floor(this.y)] + ' ' + this.series.name + ' for Competency ' + this.x;
						}
					},
					legend: {
						verticalAlign: 'top',
						backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
					},
					series: [{
						name: 'Understanding',
						type: 'column',
						marker: {
							radius: 10
						},
						data: [<?php echo implode(",", $understandings); ?>]

					}, {
						name: 'Priority',
						type: 'scatter',
						marker: {
							radius: 6,
							symbol: 'diamond'
						},
						data: [<?php echo implode(",", $priorities); ?>]
					}]
				});
			});
			</script>
			<!--<p align="center">
    <button onClick="javascript:getpage('print');" class="btnesque">Print Results</button>
    <button onClick="javascript:getpage('email');" class="btnesque">Email Results</button>
    <button onClick="javascript:getpage('pdf');" class="btnesque">Download PDF of Results</button>
    <button onClick="javascript:window.location.assign('csv.php');" class="btnesque">Download CSV of Results</button>
    </strong><br>
    <small><em>*note: the graph will not be included using these options</em></small></p>-->


			<form method="post" action="save.php" id="savepage" target="_blank">
				<input type="hidden" name="action" id="action" />
				<input type="hidden" name="html" id="html" />
			</form>
			<script>
			$(document).ready(function() {
				//$(".toggleContent").hide();
			});
			// accorions
			$(".aHead").click(function() {
				if ($(this).html() == "Hide Assessment Details") {
					$(this).html("View Assessment Details");
				} else {
					$(this).html("Hide Assessment Details");
				}
				$(this).parent().children(".toggleContent").toggle();
			});
			// final output
			function getpage(a) {
				$("#action").val(a);
				$("#html").val($("#printarea").html());
				$("#savepage").submit();
			}
			</script>
		</div>
	</div>
</div>


<footer class="noprint">
	<div class="container">
		<div class="spotlight">
			<div class="fcell">
				<span>
					<h3 style="color: #fff; margin-bottom: 1rem;">MCH Navigator</h3>
					<p style="color: #ccc;">National Center for Education in Maternal and Child Health<br />
						Georgetown University<br />
						mchnavigator@ncemch.org</p>
				</span>
			</div>
			<div class="fcell">
				<ul class="fsocial">
					<li><a href="https://www.facebook.com/mchnavigator" target="_blank" class="facebook"><i class="mch-facebook"></i></a></li>
					<li><a href="https://twitter.com/mchnavigator" target="_blank" class="twitter"><i class="mch-twitter"></i></a></li>
					<li><a href="https://www.linkedin.com/company/mch-navigator" target="_blank" class="linkedin"><i class="mch-linkedin"></i></a></li>
					<li><a href="https://vimeo.com/channels/5min" target="_blank" class="vimeo"><i class="mch-vimeo"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
</footer>
<span class="btmtxt noprint">This project is supported by the Health Resources and Services Administration (HRSA) of the U.S. Department of Health and Human Services (HHS) under grant number UE8MC25742; MCH Navigator for $180,000/year. This information or content and conclusions are those of the author and should not be construed as the official position or policy of, nor should any endorsements be inferred by HRSA, HHS or the U.S. Government.</span>
<!-- End Document -->

</body>
</html>
