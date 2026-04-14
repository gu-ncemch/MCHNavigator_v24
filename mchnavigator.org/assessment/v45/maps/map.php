<?php
include("../../account/cookie.php");
require_once __DIR__ . '/../../../filemaker/data-api.php';

$section = 'assessment';
$page = 'individual';
$page_title = 'Assessment Maps';
include('../../../incl/header.html');

function v45_map_results_by_section($uID) {
	$request = array(
		'database' => 'MCH-Navigator',
		'layout' => 'SA_Responses_v45',
		'action' => 'find',
		'parameters' => array(
			'query' => array(
				array(
					'uID' => '=' . (int) $uID,
				),
			),
			'sort' => array(
				array(
					'fieldName' => 'section',
					'sortOrder' => 'ascend',
				),
				array(
					'fieldName' => 'date',
					'sortOrder' => 'descend',
				),
			),
			'limit' => 500,
		),
	);

	$result = do_filemaker_request($request, 'array');
	$completed = array();
	if ((int) ($result['messages'][0]['code'] ?? 500) !== 0 || empty($result['response']['data'])) {
		return $completed;
	}

	foreach ($result['response']['data'] as $record) {
		$currentSection = (int) ($record['fieldData']['section'] ?? 0);
		if ($currentSection > 0) {
			$completed[$currentSection] = true;
		}
	}

	return $completed;
}

$completedSections = v45_map_results_by_section($uID);
$competencyTitles = array(
	1 => 'MCH Knowledge Base/Context',
	2 => 'Self-Reflection',
	3 => 'Ethics',
	4 => 'Critical Thinking',
	5 => 'Communication',
	6 => 'Negotiation and Conflict Resolution',
	7 => 'Responsive and Effective MCH Systems',
	8 => 'Community Expertise and Perspectives',
	9 => 'Teaching, Coaching, and Mentoring',
	10 => 'Interdisciplinary/Interprofessional Team Building',
	11 => 'Systems Approach',
	12 => 'Policy',
);
?>
<link rel="stylesheet" href="../../styles.css">
<style>
.map-grid {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
	gap: 1.5rem;
	margin-top: 2rem;
}

.map-card {
	border: 1px solid #d8d8d8;
	border-radius: 8px;
	padding: 1rem;
	background: #fff;
}

.map-card h3 {
	margin-bottom: 0.5rem;
}

.map-card p {
	margin-bottom: 0.75rem;
}

.map-card img {
	display: block;
	width: 100%;
	height: auto;
	border: 1px solid #eee;
	background: #fafafa;
}

.map-status {
	font-weight: bold;
}

.map-status.complete {
	color: #2e7d32;
}

.map-status.incomplete {
	color: #777;
}
</style>

<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
	<?php include('../../../incl/leftnav.html'); ?>
	<div class="nine columns">
		<?php include('../../../incl/title.html'); ?>

		<h2>Assessment Maps</h2>
		<p>You have completed <strong><?php echo count($completedSections); ?></strong> of 12 competencies.</p>

		<div class="map-grid">
			<?php for ($i = 1; $i <= 12; $i++) { ?>
			<div class="map-card">
				<h3>Map <?php echo $i; ?></h3>
				<p><strong>Competency <?php echo $i; ?>:</strong> <?php echo htmlspecialchars($competencyTitles[$i], ENT_QUOTES, 'UTF-8'); ?></p>
				<p class="map-status <?php echo isset($completedSections[$i]) ? 'complete' : 'incomplete'; ?>">
					<?php echo isset($completedSections[$i]) ? 'Completed' : 'Not completed'; ?>
				</p>
				<p><a href="../competency_<?php echo sprintf('%02d', $i); ?>.php" class="button small">Open Competency</a></p>
				<img src="map-<?php echo $i; ?>.svg" alt="Assessment map for competency <?php echo $i; ?>">
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php include('../../../incl/footer.html'); ?>
