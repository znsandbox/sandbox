<?php

namespace ZnSandbox\Sandbox\Error\Domain\Helpers;

class OutputHelper {
	
	public static function criticalError($message, $type = 'warning') {
		if(in_array(APP, [CONSOLE, API])) {
			echo strip_tags($message);
		} else {
			echo self::getHtml($message, $type);
		}
		exit;
	}
	
	private static function getHtml($message, $type = 'warning') {
		return '
<html>
<head>
			<title>API documentation</title>
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
			<meta name="generator" content="https://github.com/raml2html/raml2html 6.7.0">
			<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/styles/default.min.css">
			<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
			<script type="text/javascript" src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/highlight.min.js"></script>
		</head>
<body>
<div class="container" style="margin-top: 20px">
	<div class="row">
		<div class="col-md-9" role="main">
			<div class="jumbotron">
				<h1>' . ucfirst($type) . '</h1>
				<div class="alert alert-' . $type . '">
					' . $message . '
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>';
	}
}
