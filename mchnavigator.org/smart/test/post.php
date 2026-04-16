<?php
include("../account/cookie.php");
require_once __DIR__ . '/../../filemaker/data-api.php';
$section = 'assessment';
$page = 'Phase 3: Sharing &raquo; Post-Test';
include ('../incl/header.html');
?>

<style>
.test-accessibility-help {
	margin: 1rem 0 1.5rem;
	padding: 0.75rem 1rem;
	background: #fff5cc;
	border-left: 4px solid #1f6fb2;
}

.choice li {
	padding: 0.15rem 0.35rem;
	border-radius: 4px;
}

.choice li label {
	display: block;
	width: 100%;
	padding: 0.1rem 0.2rem;
	box-sizing: border-box;
}

.choice li:focus-within {
	background-color: #eef5ff;
}

.choice input[type="radio"]:focus,
.choice input[type="radio"]:focus-visible,
button:focus,
button:focus-visible {
	outline: 2px solid #1f6fb2;
	outline-offset: 2px;
}
</style>

<script>
function setupSmartTestKeyboardNavigation(formSelector) {
	var form = document.querySelector(formSelector);
	if (!form) {
		return;
	}

	var radios = Array.prototype.slice.call(form.querySelectorAll('input[type="radio"]'));
	if (!radios.length) {
		return;
	}

	var groupNames = [];
	var groups = {};

	radios.forEach(function(radio) {
		if (!groups[radio.name]) {
			groups[radio.name] = [];
			groupNames.push(radio.name);
		}
		groups[radio.name].push(radio);
	});

	function focusNextTarget(groupIndex) {
		var nextGroupName = groupNames[groupIndex + 1];
		if (nextGroupName && groups[nextGroupName] && groups[nextGroupName][0]) {
			groups[nextGroupName][0].focus();
			return true;
		}

		var submitButton = form.querySelector('button[type="submit"], button:not([type]), input[type="submit"]');
		if (submitButton) {
			submitButton.focus();
			return true;
		}

		return false;
	}

	function focusPreviousTarget(groupIndex) {
		var previousGroupName = groupNames[groupIndex - 1];
		if (previousGroupName && groups[previousGroupName] && groups[previousGroupName].length) {
			groups[previousGroupName][groups[previousGroupName].length - 1].focus();
			return true;
		}

		return false;
	}

	radios.forEach(function(radio) {
		radio.addEventListener('keydown', function(event) {
			var groupIndex = groupNames.indexOf(radio.name);
			var group = groups[radio.name] || [];
			var optionIndex = group.indexOf(radio);

			if (event.key === 'Tab') {
				if (event.shiftKey) {
					if (optionIndex > 0) {
						event.preventDefault();
						group[optionIndex - 1].focus();
					} else if (focusPreviousTarget(groupIndex)) {
						event.preventDefault();
					}
				} else {
					if (optionIndex < group.length - 1) {
						event.preventDefault();
						group[optionIndex + 1].focus();
					} else if (focusNextTarget(groupIndex)) {
						event.preventDefault();
					}
				}
			}

			if (event.key === ' ' || event.key === 'Spacebar' || event.key === 'Enter') {
				event.preventDefault();
				radio.checked = true;
				radio.dispatchEvent(new Event('change', { bubbles: true }));
				focusNextTarget(groupIndex);
			}
		});
	});
}

document.addEventListener('DOMContentLoaded', function() {
	setupSmartTestKeyboardNavigation('#smart-test-form');
});
</script>

<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
	<?php include('../incl/nav_generic.html'); ?>

	<div class="ten columns">
		<div id="page_title"><img src="../images/Dashboard-lightbulb-concept.jpg" alt="lightbulb and paper with pencil">
		  <div class="v">
		    <h1>MCHsmart Post-Test</h1>
		  </div>
		</div>
<p>Please answer the questions you took as a pre-test again to gauge how much you have learned from the MCHsmart curriculum.</p>
		<p class="test-accessibility-help"><strong>Keyboard help:</strong> Use <kbd>Tab</kbd> and <kbd>Shift</kbd>+<kbd>Tab</kbd> to move through answer choices. Press <kbd>Space</kbd> or <kbd>Enter</kbd> to select an answer and move to the next question.</p>
		<form method="post" action="save.php" id="smart-test-form">
			<input type="hidden" name="test_type" value="post" readonly="">
			<input type="hidden" name="uID" value="<?php echo $uID; ?>" readonly="">
			<?php include('questions.php'); ?>
			<button type="submit">save</button>
		</form>


	</div>
</div>

<?php include('../incl/footer.html'); ?>
