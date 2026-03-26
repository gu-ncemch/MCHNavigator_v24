<?php include_once("/home/dh_mch_sftp/globals/errors.php"); ?>
<!DOCTYPE html>
<html lang="en" >
<head>
<meta charset="UTF-8">
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /><![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/foundation/5.5.1/css/foundation.min.css" />
<title>Error</title>
</head>
<body>
<div class="row" style="max-width:60rem; margin-top:5rem;">
	<div class="small-12 columns" id="main_column">
		<main class="content text-center">
			<h1><a href="/" id="logolink"><img src="https://www.mchnavigator.org/images/main_logo.png" alt="MCH Navigator"></a></h1>
			<h2><?php echo $error['code']; ?> Error</h2>
			<p><?php echo $error['message']; ?></p>
			<p>Return to the <a href="/"><strong>Home Page</strong></a>.</p>
		</main>
	</div>
</div>
</body>
</html>
