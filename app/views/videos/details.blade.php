<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="ico/favicon.ico">
	<link rel="apple-touch-icon" href="ico/apple-touch-icon.png">

	<title>Hobbies and Careers</title>

	<!-- Bootstrap core CSS -->
	<link href="{{ url('css/bootstrap.min.css') }}" rel="stylesheet">

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Custom styles for this template -->
	<link href="{{ url('css/main.css') }}" rel="stylesheet">

	<!-- Library styles -->
	<link href="{{ url('css/jquery.fancybox.css') }}" rel="stylesheet">

	<!-- Specials Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>
</head>
	
<body class="bg-video">

<div class="container">
	<div class="box video">
		<div class="panel-body">
			<div class="embed-responsive embed-responsive-16by9">
				<iframe  class="embed-responsive-item" src="http://www.youtube.com/embed/{{ $video["id"] }}?rel=0" allowfullscreen></iframe>
			</div>
			<div class="page-header">
				<h2>{{ $video["snippet"]["title"] }}</h2>
			</div>
			<p>{{ Str::words($video["snippet"]["description"],100) }}...</p>
		</div>
		<div class="panel-footer clearfix">
			<a href="#" class="btn btn-default btn-sm">
				<span class="glyphicon glyphicon-star" aria-hidden="true"></span> Add to my board
			</a>
			@foreach($topics as $topic)
				<a href="{{ url('topics/preview'.$topic["mid"]) }}" class="tag">{{{ $topic["name"] }}}</a>
			@endforeach
		</div>
	</div><!-- /.video -->

	<?php
	/*
	<div class="row">
		<div class="col-md-4 col-sm-6">
			<div class="box video">
				<div class="panel-body">
					<figure>
						<a class="fancyvideo" data-fancybox-type="iframe" href="video.html"><img src="images/video.jpg" alt=""></a>
					</figure>
					<div class="page-header">
						<h2>{{ $video["snippet"]["title"] }}</h2>
					</div>
				</div>
				<div class="panel-footer">
					<a href="#" class="btn btn-default btn-sm">
						<span class="glyphicon glyphicon-star" aria-hidden="true"></span> Add to my board
					</a>

					<a href="#" class="tag">Large Career</a>
				</div>
			</div>
		</div>
	</div>
	*/ 
	?>

</div>

<!-- Bootstrap core JavaScript
================================================== -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="{{ url('js/bootstrap.min.js') }}"></script>
<script src="{{ url('js/docs.min.js') }}"></script>
<script src="{{ url('js/jquery.fancybox.pack.js') }}"></script>
<script src="{{ url('js/main.js') }}"></script>
<script>
	$(function(){
		$('.tag').click(function(e){
			e.preventDefault();
			parent.location.href = $(this).attr('href');
		});
	});
</script>

</body>
</html>