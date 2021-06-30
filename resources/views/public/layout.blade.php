<html lang="en">
	<head>
		<!--jquery-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
        <!--BOOTSTRAP-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <!--FontAwesome-->
        <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		@yield('resources')
		<title>Document</title>
	</head>
	<body>
        <div class="main">

			<nav class="navbar">
			    <div class="title-navbar">
			        <img src="img/menu.svg" id="btn-menu" class="cursor" alt="" height="30">
			        <span class="navbar-brand mb-0 h1">Produccion SE</span>
			        
			    </div>
			    <div class="user-data">
			        <div class="user-name">{{ Auth::user()->name }}</div>
			        <div class="content-user-image">
			            <img src="img/animals/{{ Auth::user()->avatar }}.svg" class="user-image">
			        </div>
			    </div>
			</nav>

			<div class="menu-container">
	            <div class="space-free"></div>
	            <div class="menu-body">
	                <a class="item-menu cursor" href="{{ route('home') }}">
	                    <img src="img/dashboard.svg" height="20">
	                    <div class="text-menu">Dasboard</div>
	                </a>
	                <a class="item-menu cursor" href="{{ route('stop') }}">
	                    <img src="img/mantenimiento.svg" height="20">
	                    <div class="text-menu">Paros de maquina</div>
	                </a>
	            </div>
	        </div>

        	@yield('content')
        </div>

        @yield('modals')

        <!--Bootstrap-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        @yield('scripts')
	</body>
</html>