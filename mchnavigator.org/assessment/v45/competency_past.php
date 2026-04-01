<?php

	include_once("all-trainings-array.php");

	// NEXT SECTION
	$values = array("Not a","Low","Medium","High");
	$levels = array("Introductory","Introductory","Intermediate","Advanced");

	if ( ! function_exists('average_to_word')) {


	function average_to_word( $avg ){
		switch ( true ) {
		  case $avg >= 2.6:
		    $word = "High";
		    break;
		  case $avg >= 1.6:
		    $word = "Medium";
		    break;
		  default:
		    $word = "Low";
		}
		return $word;
	}}

	if ( ! function_exists('fm_repeat_value')) {
	function fm_repeat_value( $row, $field, $index ) {
		$value = $row['fieldData'][$field] ?? '';
		if ( is_array( $value ) ) {
			return $value[$index] ?? '';
		}
		return $index === 0 ? $value : '';
	}}

	// get responses
	$request = array(
		'database' => 'MCH-Navigator',
		'layout' => 'SA_Responses_v45',
		'action' => 'find',
		'parameters' => array(
			'query' => array(
				array(
					'rID' => '=' . scrubber($rID, 'string'),
				),
			),
			'limit' => 10,
		),
	);
	$result = do_filemaker_request($request, 'array');
	$responses = array();
	if ((int) ($result['messages'][0]['code'] ?? 500) !== 0) {
		echo $result['messages'][0]['message'] ?? 'Error loading responses.';
	} else {
		$responses = $result['response']['data'];
	}
	$userResponses = array();
	// print_r($responses);
	foreach ($responses as $response) {
		$sub_i = 0;
		$sub_ks = 0;
		$sub_c = 0;
		for($i = 0; $i <= 30; $i++){
			if(fm_repeat_value($response, 'responseID', $i) != ""){
				$responseId = fm_repeat_value($response, 'responseID', $i);
				$responseType = fm_repeat_value($response, 'responseType', $i);
				$responseValue = fm_repeat_value($response, 'response', $i);
				$userResponses[$responseId] = $responseValue;
				if($responseType == "I"){
					$sub_i += $responseValue;
				} else {
					$sub_ks += $responseValue;
					$sub_c++;
				}
			}
		}
		// print_r($userResponses);
	}
	// get previous responses
	$avg = round($sub_ks/$sub_c, 1);
	?>
<p class="user_results"><strong>Overall Summary of this Competency:</strong> You indicated that this competency had <strong class="<?php echo $values[$sub_i]; ?>"><?php echo $values[$sub_i]; ?> Priority
		<!-- (<?php echo $sub_i; ?> out of 3)-->
	</strong> for you now and you appear to have <strong class="<?php echo average_to_word( $avg ); ?>"><?php echo average_to_word( $avg ); ?> Understanding (<?php echo $avg; ?> out of 3)</strong> of the knowledge and skills. <em>Note: this is an average summary for each competency</em>.</p>


<?php

// this is for the chart
if($plan){
	$priorities[$section] = ($sub_i);
	$understandings[$section] = $avg;
}
?>

<?php
# make it all hidden if on the learning plan page
if($sub_i == 0){
	echo '<p>Since you marked this competency as no importance to you, we are not recommending specific learning opportunities. However, if you later decide that you want to pursue training in this area, you can browse our collection of <a href="/trainings/results.php?Competencies='.$section.'.">trainings on this competency</a>.</p>';
} else {
	if(isset($plan) && $plan){ ?>
<button class="accordion"> <strong><i class="icon mch-search" aria-hidden="true"></i> View Assessment Details</strong></button>

<div class="panel">
	<p><strong class="red-text"><i class="icon mch-compass-2" aria-hidden="true"></i> READY: Start with the Science.</strong> Here’s an article to ground you in the science of the competency:</p>

	<section class="resources">

		<?php
switch ( $section ) {
  case 1:
    ?>
		<ul>
			<li>
				<a href="https://link.springer.com/article/10.1007/s10995-023-03629-0">Over a Century of Leadership for Maternal and Child Health in the United States: An Updated History of the Maternal and Child Health Bureau (2023).</a> This report describes the marked growth of the Bureau’s legislative authorities since the Title V reforms of the 1980s, along with a description of the response to emerging issues for MCH populations.
			</li>
		</ul>
		<?php
    break;
  case 2:
    ?>
		<ul>
			<li>
				<a href="https://link.springer.com/article/10.1007/s10995-014-1549-1">Use of Competency-Based Self-Assessments and the MCH Navigator for MCH Workforce Development: Three States’ Experiences (2014).</a> This report documents three state-level approaches to using the Navigator’s tools, including the online self-assessment.
			</li>
		</ul>
		<?php
    break;
  case 3:
    ?>
		<ul>
			<li>
				<a href="https://link.springer.com/article/10.1007/s10995-022-03457-8">Shifting Power in Practice: The Importance of Contextual and Experiential Evidence in Guiding MCH Decision Making.</a> This article discusses how evidence co-creation is key to establishing and sustaining transformative relationships between community members and Title V programs, shifting power structures to build upon existing community leadership and assets.
			</li>
		</ul>
		<?php
    break;
  case 4:
    ?>
		<ul>
			<li>
				<a href="https://www.forbes.com/sites/forbesbusinesscouncil/2024/04/01/the-indispensable-role-of-critical-thinking-in-healthcare-leadership/">The Indispensable Role Of Critical Thinking In Healthcare Leadership.</a> This article describes the need for critical thinking, provides tips for putting critical thinking into practice, and ways to build critical thinking skills.
			</li>
		</ul>
		<?php
    break;
  case 5:
    ?>
		<ul>
			<li>
				<a href="https://www.ncbi.nlm.nih.gov/pmc/articles/PMC2672574/">Why Health Communication is Important in Public Health (2009).</a> This article provides an introduction to communication in public health and presents intervention considerations and challenges in providing effective outreach.
			</li>
		</ul>
		<?php
    break;
  case 6:
    ?>
		<ul>
			<li>
				<a href="https://www.healthknowledge.org.uk/public-health-textbook/organisation-management/5a-understanding-itd/negotiating-influencing">Principles of Negotiation and Influencing.</a> This learning module, part of a larger resource for faculty of public health, identifies the four principles of negotiation and presents strategies to engage the process in a professional setting.
			</li>
		</ul>
		<?php
    break;
  case 7:
    ?>
		<ul>
			<li>
			  <a href="https://www.ncbi.nlm.nih.gov/books/NBK568218/">Strategies and Actions: Improving Maternal Health and Reducing Maternal Mortality and Morbidity. </a>
			This chapter of <em>The Surgeon General's Call to Action to Improve Maternal Health</em> outlines comprehensive strategies and specific actions for addressing maternal health conditions and risk factors, highlighting opportunities for intervention across multiple sectors including healthcare providers, systems, payors, employers, and communities.</li>
			<li>
				<a href="https://www.aha.org/news/blog/2023-01-23-improving-maternal-outcomes-starts-knowing-why">Improving Maternal Outcomes Starts with Knowing Why.
			  </a>
			This article emphasizes the importance of understanding the underlying causes of maternal mortality, focusing on the leading factors such as mental health conditions and cardiac issues. It highlights strategies hospitals and healthcare organizations are implementing to identify risk factors, offer preventive measures, and provide coordinated care.</li>
		</ul>
		<?php
    break;
  case 8:
    ?>
		<ul>
			<li>
			<a href="https://publichealthcollaborative.org/resources/the-5-stages-of-community-engagement-for-public-health/">The 5 Stages of Community Engagement for Public Health.</a> This resource presents the Spectrum of Community Engagement to Ownership framework, which breaks down community engagement into five developmental stages: inform, consult, involve, collaborate, and defer to. It provides practical guidance for public health professionals on how to build capacity and relationships with communities, emphasizing the importance of community-driven decision-making for effective public health communications and interventions.</li>
		</ul>
		<?php
    break;
  case 9:
    ?>
		<ul>
			<li>
			<a href="https://pmc.ncbi.nlm.nih.gov/articles/PMC9055367/">Developing State Leadership in Maternal and Child Health: Process Evaluation Findings from a Work-Based Learning Model for Leadership Development.</a> This article presents findings from an evaluation of a leadership development program that uses a work-based learning approach. It highlights how combining classroom instruction, team projects, and coaching helps professionals develop skills to address complex MCH challenges at the state level.</li>
		</ul>
		<?php
    break;
  case 10:
    ?>
		<ul>
			<li>
				<a href="https://link.springer.com/article/10.1007/s10995-016-2129-3">Advancing MCH Interdisciplinary/Interprofessional Leadership Training and Practice Through a Learning Collaborative.</a> This article describes how learning collaboratives are an effective method for increasing interdisciplinary/interprofessional team building. Tools and strategies are presented.
			</li>
		</ul>
		<?php
    break;
  case 11:
    ?>
		<ul>
			<li>
				<a href="https://link.springer.com/article/10.1007/s10995-022-03376-8">Tools for Supporting the MCH Workforce in Addressing Complex Challenges: A Scoping Review of System Dynamics Modeling in Maternal and Child Health.</a> This article summarizes the state of the field in using system dynamics and presents suggestions for increased use of this approach in the future.
			</li>
		</ul>
		<?php
    break;
  case 12:
    ?>
		<ul>
			<li>
				<a href="https://link.springer.com/article/10.1007/s10995-022-03377-7">Building the MCH Public Health Workforce of the Future: A Call to Action from the MCHB Strategic Plan.</a> This article takes a high-level policy perspective to summarize 13 recommendations to strengthen public health capacity and workforce for MCH.
			</li>
		</ul>
		<?php
    break;
  default:
    echo "<!-- something went wrong -->";
}

?>
	</section>
	<p style="margin-top:2.5rem;"><strong class="red-text"><i class="icon mch-anchor" aria-hidden="true"></i> SET: Dig Deeper.</strong> Based on your results, below are your knowledge levels by sub-competency. <strong>Click on the sub-competencies below to view curated trainings that match your reported learning needs.</strong></p>
	<?php } ?>

	<p><small>The results below were recorded on <?php echo date('l F jS, Y \a\t g:ia',strtotime($responses[0]['fieldData']['date'] ?? '')); ?></small></p>
	<table class="user_results">
		<thead>
			<td class="prompt">Sub-Competency</td>
			<td>None</td>
			<td>Low</td>
			<td>Medium</td>
			<td>High</td>
			</tr>
		</thead>

		<tbody>

			<?php
			// get questions
			$request = array(
				'database' => 'MCH-Navigator',
				'layout' => 'SA_Questions_v45',
				'action' => 'find',
				'parameters' => array(
					'query' => array(
						array(
							'section' => '=' . (int) $section,
						),
					),
					'sort' => array(
						array(
							'fieldName' => 'type',
							'sortOrder' => 'ascend',
						),
						array(
							'fieldName' => 'order',
							'sortOrder' => 'ascend',
						),
					),
					'limit' => 100,
				),
			);
			$result = do_filemaker_request($request, 'array');
			$records = array();
			if ((int) ($result['messages'][0]['code'] ?? 500) !== 0) {
				echo $result['messages'][0]['message'] ?? 'Error loading questions.';
			} else {
				foreach ($result['response']['data'] as $row) {
					$records[] = fm_record_shim($row);
				}
			}
			// display
			foreach ($records as $record) {
				$qID = $record->getField('qID');
				$qID_clean = $record->getField('qID_clean');
				$qIDname = $qID;

				if( array_key_exists( $qID, $userResponses ) ){
					echo '<tr><td class="text"><a href="/trainings/results.php?Competencies='.$qID_clean.'&Level='.$levels[$userResponses[$qID]].'"><strong>'.$qID.'</strong> '.$record->getField('text_short').'</a></td>';

					switch ($values[$userResponses[$qID]]) {
					case "None":
						echo '<td><i class="icon mch-dot-circle-o None" aria-hidden="true"></i></td><td></td><td></td><td></td></tr>';
						break;
					case "Low":
						echo '<td></td><td><i class="icon mch-dot-circle-o Low" aria-hidden="true"></i></td><td></td><td></td></tr>';
						break;
					case "Medium":
						echo '<td></td><td></td><td><i class="icon mch-dot-circle-o Medium" aria-hidden="true"></i></td><td></td></tr>';
						break;
					case "High":
						echo '<td></td><td></td><td></td><td><i class="icon mch-dot-circle-o High" aria-hidden="true"></i></td></tr>';
						break;
					default:
						echo '<td></td><td></td><td></td><td></td></tr>';
					}
				}
			}
		?></tbody>
	</table>

	<p style="margin-top:2.5rem;"><strong class="red-text"><i class="icon mch-flag-checkered" aria-hidden="true"></i> GO: Move from Knowledge to Practice.</strong> Use this implementation tool to ensure effectiveness in how you implement this competency:</p>

	<section class="resources">

		<?php
switch ( $section ) {
  case 1:
    ?>
		<ul>
			<li>
				<a href="https://www.mchevidence.org/documents/10-Essential-PH-Services-SDOH.pdf">Resources Linking the Ten Essential Public Health Services to Addressing Social Determinants of Health (SDOH) (MCH Evidence Center).</a> This tool aligns the Ten Essential Public Health Services to activities and resources to advance SDOH.
			</li>
		</ul>
		<?php
    break;
  case 2:
    ?>
		<ul>
			<li>
				<a href="https://vimeo.com/527983670">The Five Rs (National MCH Workforce Development Center).</a> This video describes a self-reflective process to identify the related roles, relationships, resources, rules, and results needed to make a process or system work effectively.
			</li>
		</ul>
		<?php
    break;
  case 3:
    ?>
		<ul>
			<li>
				<a href="https://www.ache.org/about-ache/our-story/our-commitments/ethics/ache-code-of-ethics/creating-an-ethical-culture-within-the-healthcare-organization/ethics-toolkit">Ethics Toolkit (American College of Healthcare Executives).</a> This toolkit provides a multi-step process for ethical decision making, self-assessment tools, and tips for ways to enhance ethical awareness in the service of making better ethical decisions.
			</li>
		</ul>
		<?php
    break;
  case 4:
    ?>
		<ul>
			<li>
				<a href="https://asq.org/quality-resources/root-cause-analysis">Root-Cause Analysis (RCA).</a> RCA is a structured facilitated team process to use critical thinking to identify root causes of an event that resulted in an undesired outcome and develop corrective actions. The MCH Fishbone Diagram (interactive PPT, developed by NCEMCH) has been designed for individual or group work.
			</li>
		</ul>
		<?php
    break;
  case 5:
    ?>
		<ul>
			<li>
				<a href="https://www.ruralhealthinfo.org/toolkits/health-promotion/2/strategies/health-communication">Health Communication Toolkit (Rural Health Information Hub).</a> This toolkit presents a summary of the components that make up successful communication strategies, presents examples of communication interventions, and additional resources.
			</li>
			<li>
				<a href="https://www.cdc.gov/healthcommunication/index.html">Health Communication Gateway (Centers for Disease Control and Prevention).</a> This toolkit provides guiding principles for effective communication, resources for communicators, featured campaigns, and links to training, tools, and communication templates.
			</li>
		</ul>
		<?php
    break;
  case 6:
    ?>
		<ul>
			<li>
				<a href="https://online.hbs.edu/blog/post/strategies-for-conflict-resolution-in-the-workplace">5 Strategies For Conflict Resolution In The Workplace (Harvard Business School).</a> This article outlines five approaches from the Thomas-Kilmann Conflict Model: avoiding, competing, accommodating, compromising, and collaborating. It explains when each strategy is most effective, with collaboration being ideal for most workplace situations. The resource also discusses a leader's ethical responsibilities in managing conflict and emphasizes the importance of addressing workplace disputes to maintain productivity and positive relationships.</li>
		</ul>
		<?php
    break;
  case 7:
    ?>
		<ul>
			<li>
			  <a href="https://www.mchnavigator.org/transformation/documents/33078.pdf">Collaboration and Action to Improve Child Health Systems: A Toolkit for State Leaders.</a> This resource provides tools for state leaders in mapping and improving child health systems through collaborative planning. It provides frameworks, discussion questions, and visual mapping tools to help agencies identify gaps in systems, strengthen partnerships between Title V and Medicaid programs, and develop more coordinated approaches to children's health services.</li>
		</ul>
		<?php
    break;
  case 8:
    ?>
		<ul>
			<li><a href=https://ctb.ku.edu/en/table-of-contents/overview/models-for-community-health-and-development/mapp/main>MAPP: Mobilizing for Action through Planning and Partnerships.</a> This community-driven strategic planning framework guides local health improvement efforts through six phases that include partnership development, shared visioning, comprehensive assessment, and collaborative action planning to address public health challenges.</li>
			<li>
		    <a href="https://ctb.ku.edu/en/increasing-participation-and-membership">Increasing Participation and Membership.</a> This resource provides a systematic approach to expanding involvement in community initiatives through step-by-step guidance. It helps organizations identify who needs to be involved, recruit participants, increase access to participation, create effective outreach strategies, and foster continued engagement. The toolkit emphasizes creating environments where members feel recognized, respected, and rewarded for their contributions.            </li>
		</ul>
		<?php
    break;
  case 9:
    ?>
		<ul>
			<li>
				<a href="https://www.iths.org/investigators/tools-resources/mentoring-tools/">Mentoring Tools (University of Washington’s Institute of Translational Health Sciences).</a> This portal provides access to PDFs of 12 mentoring tools.
			</li>
		</ul>
		<?php
    break;
  case 10:
    ?>
		<ul>
			<li>
				<a href="https://www.phf.org/programs/QItools/Pages/Quality_Improvement_Team_Management_Tools.aspx">Quality Improvement Tools for Team Management (Public Health Foundation).</a> This portal provides access to nine tools and links to other toolkits.
			</li>
		</ul>
		<?php
    break;
  case 11:
    ?>
		<ul>
			<li>
				<a href="https://mchwdc.unc.edu/resources/systems-strengthening-toolkit/">Systems Strengthening Toolkit (National MCH Workforce Development Center).</a> This toolkit provides guidance and access to multiple tools to see work in the context of the “big picture” and ways to collaborate with key partners.
			</li>
		</ul>
		<?php
    break;
  case 12:
    ?>
		<ul>
			<li>
				<a href="https://maternalhealthlearning.org/resources/policy-analysis-tools-summary-how-does-a-policy-impact-maternal-health-and-maternal-health-equity/">Policy Analysis Tools Summary (Maternal Health Learning and Innovation Center).</a> This summary document summarizes tools for determining whether programs and policies improve health outcomes for  all they serve.
			</li>
		</ul>
		<?php
    break;
  default:
    echo "<!-- something went wrong -->";
}

?>
	</section>
	<?php

	if(isset($plan) && $plan){
		echo "</div>"; # end <div class="panel">
	}
} // end of show trainings logic
?>


	<?php if(!isset($plan)){ ?><p align="center"><a href="past-results.php" class="btnesque">Back to <strong>Past Results for Individual Competencies</strong></a></p><?php } ?>
