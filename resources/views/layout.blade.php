<!DOCTYPE html>
<html>
<head>
	<title>@yield("titulo","Softsystem")</title>
	<link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css')}}">
	<script src="{{mix('js/app.js')}}" defer></script>
</head>
<body>
	<div id="app" class="d-flex flex-column h-screen justify-content-between">
		<main>
			@yield("contenido")
		</main>
		<footer class="text-center text-secondary">
			{{ config('app.name') }} | Copyright @ {{ date('Y')}}
		</footer>
	</div>
</body>
</html>