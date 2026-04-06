<?php
include("../account/cookie.php");
include_once(__DIR__ . "/../../../globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'personal';
$page_title = "Self-Assessment";
include ('../../incl/header.html');
?>
<div class="container" style="margin-top: 2rem; margin-bottom: 2rem;">
<?php include('../../incl/leftnav.html'); ?>
<div class="nine columns">
<?php include('../../incl/title.html'); ?>

<?php
	// display past results function
	$priorities = array();
	$understandings = array();
	function getPlan($section){
		global $fm, $uID, $priorities, $understandings;
		$plan = true;

		$request = $fm->newFindCommand('SA_Responses_v45');
		$request->addFindCriterion('uID', "=".$uID);
		$request->addFindCriterion('section', "=".$section);
		$request->addSortRule('date', 1, FILEMAKER_SORT_DESCEND);
		$request->setRange(0, 1);
		$result = $request->execute();

		if (FileMaker::isError($result)) {
			#echo $result->getMessage();
			echo '<p>You have not yet completed this Competency.</p><p>&nbsp;</p>';
			$priorities[$section] = 0;
			$understandings[$section] = 0;
		} else {
			$records = $result->getRecords();
			$record = $records[0];
			$rID = $record->getField('rID');
			#echo '<div class="accordion" id="competency'.sprintf('%02d', $section).'"><p class="aHead">click to see detailed results</p><div class="toggleContent">';
			include("../v4/competency_past.php");
			#echo '</div></div>';
		}
	}
?>
<script src="https://cdn.ncemch.org/js/jquery/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highcharts/4.0.4/highcharts.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highcharts/4.0.4/modules/exporting.js"></script>
<script>
$(function () {
    $('#container').highcharts({
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: null
        },
        subtitle: {
            text: null
        },
        xAxis: [{
            categories: ['Competency 1', 'Competency 2', 'Competency 3', 'Competency 4', 'Competency 5', 'Competency 6', 'Competency 7', 'Competency 8', 'Competency 9', 'Competency 10', 'Competency 11', 'Competency 12'],
            type: 'category',
            labels: {
                rotation: -45
            },
            min: 0,
            max: 11
        }],
        yAxis: [{ // Primary yAxis
            categories: ["None","Low","Medium","High"],
            type: 'category',
            tickInterval: 1,
            max: 3,
            labels: {
                format: '{value}°C',
                style: {
                    color: Highcharts.getOptions().colors[1]
                },
                formatter: function () {
                    return '<i>' +
                        this.value + '</i>';
                }
            },
            title: {
                text: null            }
        }, { // Secondary yAxis
            title: {
                text: null
            },
            labels: {
                format: '{value} mm',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            opposite: true
        }],
        tooltip: {
            enabled: false
        },
        plotOptions: {
            series: {
                pointWidth: 8,
                marker: {
                    radius: 8,
                    symbol: 'diamond'
                }
            }
        },
        legend: {
            verticalAlign: 'top',
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },
        series: [{
            name: 'Understanding',
            type: 'column',
            data: [<?php echo implode(",", $understandings); ?>]

        }, {
            name: 'Priority',
            type: 'scatter',
            data: [<?php echo implode(",", $priorities); ?>]
        }]
    });
});
</script>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<h2>Ways to Keep Motivated in Learning More</h2>
				<p>Staying motivated to learn more can be difficult as a public health professional. Competing demands, tight deadlines, and lack of time are issues that we all deal with. To use this personalized learning plan successfully, we have identified some quick tips and trick for maintaining your motivation and momentum as you advance your knowledge and skills:</p>
				<ul>
					<li><a href="https://www.youtube.com/watch?v=u6XAPnuFjJc">Drive: The Surprising Truth About What Motivates Us</a> from RSA Action and Research Centre (video).</li>
					<li><a href="http://www.ted.com/search?q=motivation">Staying Motivated</a> from TED Talks (videos).</li>
					<li><a href="http://www.lifehack.org/articles/productivity/how-to-stay-motivated.html">How to Stay Motivated</a> 5 Tips from LifeHack (web page).</li>
					<li><a href="http://www.forbes.com/sites/nextavenue/2013/07/19/how-to-stay-motivated-and-accomplish-anything/">How To Stay Motivated and Accomplish Anything</a> from Forbes (web page).</li>
				</ul>

			</div>
			<p align="center">
				<button onClick="javascript:getpage('print');" class="btnesque">Print Results</button>
				<button onClick="javascript:getpage('email');" class="btnesque">Email Results</button>
				<button onClick="javascript:getpage('pdf');" class="btnesque">Download PDF of Results</button>
				<button onClick="javascript:window.location.assign('csv.php');" class="btnesque">Download CSV of Results</button>
				</strong><br>
				<small><em>*note: the graph will not be included using these options</em></small></p>
			<form method="post" action="../save.php" id="savepage" target="_blank">
				<input type="hidden" name="action" id="action" />
				<input type="hidden" name="html" id="html" />
			</form>
			<script>
				$( document ).ready(function() {
					//$(".toggleContent").hide();
				});
				// accorions
				$( ".aHead" ).click(function() {
					if($(this).html() == "Hide Assessment Details"){
						$(this).html("View Assessment Details");
					}else{
						$(this).html("Hide Assessment Details");
					}
					$(this).parent().children(".toggleContent").toggle();
				});
				// final output
				function getpage(a){
					$("#action").val(a);
					$("#html").val($("#printarea").html());
					$("#savepage").submit();
				}
			</script>

</div>

<footer>
<div class="container">
	<div class="spotlight">
		<div class="fcell">
			<span>
				<h3 style="color: #fff; margin-bottom: 1rem;">MCH Navigator</h3>
				<p style="color: #999;">National Center for Education in Maternal and Child Health<br />
				Georgetown University<br />
				mchnavigator@ncemch.org</p>
			</span>
		</div>
		<div class="fcell">
			<ul class="fsocial">
			  <li><a href="https://www.facebook.com/mchnavigator" target="_blank"><span class="pe-so-facebook"></span></a></li>
			  <li><a href="https://twitter.com/mchnavigator" target="_blank"><span class="pe-so-twitter"></span></a></li>
			  <li><a href="https://www.linkedin.com/company/mch-navigator" target="_blank"><span class="pe-so-linkedin"></span></a></li>
			  <li><a href="https://vimeo.com/channels/5min" target="_blank"><span class="pe-so-vimeo"></span></a></li>
			</ul>
		</div>
	</div>
</div>
</footer>
<span style="text-align: center; display: block; max-width: 1400px; width: 90%; margin: 1rem auto; font-size: .8rem; line-height: 1rem; color: #777;">This project is supported by the Health Resources and Services Administration (HRSA) of the U.S. Department of Health and Human Services (HHS) under grant number UE8MC25742; MCH Navigator for $180,000/year. This information or content and conclusions are those of the author and should not be construed as the official position or policy of, nor should any endorsements be inferred by HRSA, HHS or the U.S. Government.</span>
</body>
</html>

