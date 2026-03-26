<?php
include("account/cookie.php");
include_once("/home/dh_mch_sftp/globals/filemaker_init.php");
$fm = db_connect("MCH-Navigator");
$section = 'assessment';
$page = 'Feedback';
include ('incl/header.html');
?>

<div class="container wrapper">
	<?php include('incl/nav_generic.html') ?>

	<div class="ten columns">
		<div id="page_title"><img src="images/Dashboard-lightbulb-concept.jpg" alt="lightbulb and paper with pencil">
		  <div class="v">
		    <h1>Program Evaluation</h1>
		  </div>
		</div>

		<p>Thank you for taking the time to learn with MCHsmart! We welcome your feedback on this online curriculum. The MCH Navigator is continuously seeking to improve the quality and effectiveness of the learning opportunities it provides for MCH professionals. Your input is a critical part of this process.</p>


		<form method="post" action="feedback-save.php">	
			<fieldset>
				<legend>The curriculum met my expectations.</legend>		
				<label for="ex1"><input type="radio" value="Strongly agree" id="ex1" name="expectations"> Strongly agree </label>
				<label for="ex2"><input type="radio" value="Agree" id="ex2" name="expectations"> Agree </label>
				<label for="ex3"><input type="radio" value="Neutral" id="ex3" name="expectations"> Neutral </label>
				<label for="ex4"><input type="radio" value="Disagree" id="ex4" name="expectations"> Disagree </label>
				<label for="ex5"><input type="radio" value="Strongly disagree" id="ex5" name="expectations"> Strongly disagree </label>
			</fieldset>	

			<p>
				<label for="most_valuable">What aspects of the curriculum were MOST valuable?</label>
				<textarea id="most_valuable" name="most_valuable"></textarea>
			</p>

			<p>
				<label for="least_valuable">What aspects of the curriculum were LEAST valuable?</label>
				<textarea id="least_valuable" name="least_valuable"></textarea>
			</p>

			<fieldset>
				<legend>The curriculum was:</legend>	
				<label for="diff1"><input type="radio" value="Too easy" id="diff1" name="difficulty"> Too easy </label>
				<label for="diff2"><input type="radio" value="Easy" id="diff2" name="difficulty"> Easy </label>
				<label for="diff3"><input type="radio" value="Just right" id="diff3" name="difficulty"> Just right </label>
				<label for="diff4"><input type="radio" value="Hard" id="diff4" name="difficulty"> Hard </label>
				<label for="diff5"><input type="radio" value="Too hard" id="diff5" name="difficulty"> Too hard </label>
			</fieldset>	

			<fieldset>
				<legend>I can apply the information I learned.</legend>	
				<label for="app1"><input type="radio" value="Strongly agree" id="app1" name="application"> Strongly agree </label>
				<label for="app2"><input type="radio" value="Agree" id="app2" name="application"> Agree </label>
				<label for="app3"><input type="radio" value="Neutral" id="app3" name="application"> Neutral </label>
				<label for="app4"><input type="radio" value="Disagree" id="app4" name="application"> Disagree </label>
				<label for="app5"><input type="radio" value="Strongly disagree" id="app5" name="application"> Strongly disagree </label>
			</fieldset>	

			<p><button type="submit" class="button orange">Submit Evaluation</button></p>
		</form>
	</div>
</div>

<?php include('incl/footer.html') ?>