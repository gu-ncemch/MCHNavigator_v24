<!doctype html>
<html class="no-js" lang="">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Assesserella 5,000</title>


	<link rel="stylesheet" href="just-the-docs-default.css">
</head>

<body>
	<h1>Assesserella 5,000</h1>
	<a href="emails.php" id="other-step">Check Emails</a>
	<section>
		<h2>Samoflangize Spreadsheet</h2>
		<p>Paste in Excel data, don't forget to include the headers!</p>

		<textarea id="tsv" action="" method="get" style="height:5rem;"></textarea>
		<button onclick="getTSV()">Summate!</button>

	</section>


	<script>
	function getTSV() {
		let tsv = document.getElementById("tsv").value;
		if (tsv != '') {
			let csv = tsv.replace(/\t/g, ",");
			getUserData(csv);
		}
	}

	let userScores = {};

	function getUserData(csv) {
		// console.log(csv);
		userScores = {};

		let line_number = 1;
		let knowledgeNum = null;
		let skillsNum = null;
		let sectionNum = null;
		let nameNum = null;

		csv.split(/\r?\n/).every((line) => {
			// console.log(line);

			let csvData = line.split(",");
			let cell_number = 0;

			if (line_number == 1) {
				// console.log('just once');
				line.split(',').forEach((cell) => {
					cell = cell.trim();
					switch (cell) {
						case 'response_summary_knowledge':
							knowledgeNum = cell_number;
							break;
						case 'response_summary_skills':
							skillsNum = cell_number;
							break;
						case 'section':
							sectionNum = cell_number;
							break;
						case 'SA_Users::email':
							nameNum = cell_number;
							break;
						default:
							// do nothing
					}
					cell_number++;
				});
				line_number++;
				return true; // Skip headers
			}

			if (knowledgeNum == null || skillsNum == null || sectionNum == null || nameNum == null) {
				// console.log('something is null');
				// console.log(knowledgeNum);
				// console.log(skillsNum);
				// console.log(sectionNum);
				// console.log(nameNum);
				return false; // Exit the loop, no headers
			}

			let name = csvData[nameNum].trim();
			let section = Number(csvData[sectionNum].trim());
			let knowledge = Number(csvData[knowledgeNum].trim());
			let skills = Number(csvData[skillsNum].trim());

			let testType = '';
			if (!userScores.hasOwnProperty(name) || !userScores[name].hasOwnProperty(section) || !userScores[name][section].hasOwnProperty('pre_k')) {
				testType = 'pre';
				// console.log('pre');
			} else {
				testType = 'post';
				// console.log('post');
			}

			if (!userScores.hasOwnProperty(name)) {
				userScores[name] = {};
			}
			if (!userScores[name].hasOwnProperty(section)) {
				userScores[name][section] = {};
			}
			userScores[name][section][testType + "_k"] = knowledge;
			userScores[name][section][testType + "_s"] = skills;

			line_number++;
			return true; // Skip headers
		});

		getTotalData();
	}

	// do puke
	function getTotalData() {
		// console.log(userScores);
		// console.log(Object.keys(userScores).length);
		if (Object.keys(userScores).length == 0) {
			// console.log('no userScores');
		}

		let individualTables = "";
		let userAverages = {};
		for (let i = 1; i <= 12; i++) {
			userAverages["comp_" + i] = {
				"pre_k": [],
				"post_k": [],
				"pre_s": [],
				"post_s": []
			}
		};

		// INDIVIDUALS
		Object.keys(userScores).forEach(user => {
			datum = userScores[user];
			// console.log(user, datum);
			individualTables += "<h2>" + user + "</h2><table><tr><td>-</td><td>Pre-training knowledge</td><td>Post-training knowledge</td><td>Pre-training skills</td><td>Post-training skills</td></tr>";
			Object.keys(datum).forEach(section => {
				// console.log("comp " + section + " > ", datum[section]);
				if (userAverages["comp_" + section] != undefined && datum[section]["pre_k"] != undefined) {
					userAverages["comp_" + section]["pre_k"].push(datum[section]["pre_k"]);
				}
				if (userAverages["comp_" + section] != undefined && datum[section]["pre_s"] != undefined) {
					userAverages["comp_" + section]["pre_s"].push(datum[section]["pre_s"]);
				}
				if (userAverages["comp_" + section] != undefined && datum[section]["post_k"] != undefined) {
					userAverages["comp_" + section]["post_k"].push(datum[section]["post_k"]);
				}
				if (userAverages["comp_" + section] != undefined && datum[section]["post_s"] != undefined) {
					userAverages["comp_" + section]["post_s"].push(datum[section]["post_s"]);
				}
				individualTables += "<tr><td>comp " + section + "</td><td>" + datum[section]["pre_k"] + "</td><td>" + datum[section]["post_k"] + "</td><td>" + datum[section]["pre_s"] + "</td><td>" + datum[section]["post_s"] + "</tr></td>";
				// console.log("comp " + section + " " + datum[section]["pre_k"] + " " + datum[section]["post_k"] + " " + datum[section]["pre_s"] + " " + datum[section]["post_s"]);
			});
			individualTables += "</table>";
		});
		individualTables = individualTables.replaceAll("undefined", "0"); // @todo should this be 0 or -
		// console.log(individualTables);
		document.getElementById("individualTables").innerHTML = individualTables;
		// AVERAGES
		// console.log(userAverages);
		finalAverage = "<h2>averages</h2><table><tr><td>-</td><td>Pre-training knowledge</td><td>Post-training knowledge</td><td>Pre-training skills</td><td>Post-training skills</td></tr>";
		Object.keys(userAverages).forEach(comp => {
			datum = userAverages[comp];
			// console.log(comp, datum);
			finalAverage += "<tr><td>" + comp + "</td><td>" + calcAvg(datum["pre_k"]) + "</td><td>" + calcAvg(datum["post_k"]) + "</td><td>" + calcAvg(datum["pre_s"]) + "</td><td>" + calcAvg(datum["post_s"]) + "</tr></td>";
		});
		finalAverage += "</table>";
		// console.log(finalAverage);
		document.getElementById("finalAverage").innerHTML = finalAverage;
	}
	// calcAvg
	function calcAvg(arr) {
		// console.log(arr);
		// console.log(arr.length);
		if (arr.length === 0) {
			return 0; // Avoid division by zero if the array is empty
		}

		const sum = arr.reduce((total, currentValue) => total + Number(currentValue), 0);

		// console.log(sum);
		return Math.round(sum / arr.length * 10) / 10;
	}
	</script>

	<div id="individualTables"></div>
	<div id="finalAverage"></div>

</body>

</html>
