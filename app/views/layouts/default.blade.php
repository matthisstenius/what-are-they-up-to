<!DOCTYPE html>
<html class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Place favicon.ico and apple-touch-icon(s) in the root directory -->

        <link rel="stylesheet" href="css/main.css">
        <link href="http://fnt.webink.com/wfs/webink.css/?project=E169C8DB-E86B-4ADE-B0C1-2674A0B8F333&fonts=C9BCE4CA-4162-DC9F-20E1-CD15D4ED98E5:f=Hortensia,E10DC5A5-6E69-88A0-32FF-0256CBA64855:f=ProximaNovaSoft-Regular" rel="stylesheet" type="text/css"/>
        <script src="js/vendor/modernizr-2.7.1.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
		
		<div class="header-wrapper">
			<header class="header grid pad">
				<a href="/" class="logo">What Are They Up To</a>
			</header>
		</div>

		<div class="container">
			@yield('content')
		</div>
		
		<div class="footer-wrapper">
			<footer class="footer grid pad">
				
			</footer>
		</div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=places&sensor=false"></script>
        <script src="js/main.js"></script>
    </body>
</html>
