<!DOCTYPE html>
<html lang="es">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ITWarp Consulting</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/flick/jquery-ui.css">
	<link href="{{asset('css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css">
       

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

</head>

<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">ITWarp Consulting - ATS</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					
					@if (!Auth::guest())
					@if(Auth::user()->roles_id!=2)			
					<!-- <li><a href="{{ url('/') }}">Menu1</a></li> -->
					<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Ventas <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
							<li><a href="{{ url('/customers') }}">Clientes</a></li>			
							<li><a href="{{ url('/contacts') }}">Contactos</a></li>
							</ul>

					</li>
                  
					@endif

					<li><a href="{{ url('/offers') }}">Ofertas Laborales</a></li> 
					
					<li><a href="{{ url('/candidates') }}">Candidatos</a></li>

					<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Reportes <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
							<li><a href="{{ url('reportesOportunidades') }}">Oportunidades</a></li>
                                                        <li><a href="{{ url('reportesRecruiters') }}">Recruiters</a></li>				
							</ul>

					</li>


					<li><a href="{{ url('revision') }}">Revisión CV</a></li>

							
					<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> Parametros del Sistema <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
							<li><a href="{{ url('/profiles') }}">Perfiles IT</a></li>			
							</ul>

					</li>
                                  
                                       <li><a href="{{ url('offerClosed') }}">Ofertas Cerradas/Perdidas</a></li>
					@endif
				</ul>

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Ingresar</a></li>
					@else
					  
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name . ' ' . Auth::user()->surname }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
							<li><a href="{{ url('/profile/'.Auth::user()->id) }}">Perfil</a></li>
							@if(Auth::user()->roles_id==1)				
							<li><a href="{{ url('/users') }}">Usuarios</a></li>
							@endif
							<li><a href="{{ url('/auth/logout') }}">Salir</a></li>
							</ul>
						</li>
					  @endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

</body>
</html>
