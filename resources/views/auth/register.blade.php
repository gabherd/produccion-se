<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--BOOTSTRAP-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		<title>Registrarme</title>
		<link rel="stylesheet" href="css/login.css">
	</head>
	<body>
			<div class="box-login shadow">
				<div class="header-login">
					<img class='logo' src="img/node.svg" alt="">
					<span class="txt-title-box">Registro</span>
				</div>
				<div>
					<form action="register" method="post" >
						@csrf
						<div class="form-group">
							<label for="" class="txt-instructions">Codigo de acceso</label>
							<input class="form-control" type="text" name="access_code" placeholder="-----" autocomplete="new-text" value="{{old('access_code')}}" >
							@if($errors->has('access_code'))
					    		<div class="alert alert-danger">
									<p>{{ $errors->first('access_code') }}</p>
					    		</div>
							@endif
						</div>	
						<div class="form-group">
							<label for="" class="txt-instructions">Nombre</label>
							<input class="form-control" type="text" name="name" value="{{old('name')}}" placeholder="Nombre">
							@if($errors->has('name'))
					    		<div class="alert alert-danger">
									<p>{{ $errors->first('name') }}</p>
					    		</div>
							@endif
						</div>	
						<div class="form-group">
							<label for="" class="txt-instructions">Apellido</label>
							<input class="form-control" type="text" name="last_name" value="{{old('last_name')}}" placeholder="Apellido">
							@if($errors->has('last_name'))
					    		<div class="alert alert-danger">
									<p>{{ $errors->first('last_name') }}</p>
					    		</div>
							@endif
						</div>	
						<div class="form-group">
							<label for="" class="txt-instructions">Correo</label>
							<input class="form-control" type="text" name="email" value="{{old('email')}}" autocomplete="new-text" placeholder="alguien@dominio.com" autocomplete="new-text">
							@if($errors->has('email'))
					    		<div class="alert alert-danger">
									<p>{{ $errors->first('email') }}</p>
					    		</div>
							@endif
						</div>	
						<div class="form-group">
							<label for="" class="txt-instructions">Contraseña</label>
							<input class="form-control" type="password" name="password" placeholder="******" autocomplete="new-password">
							@if($errors->has('password'))
					    		<div class="alert alert-danger">
									<p>{{ $errors->first('password') }}</p>
					    		</div>
							@endif
						</div>
						<div class="form-group">
							<label for="" class="txt-instructions">Repetir contraseña</label>
							<input class="form-control" type="password" name="password_confirmation" placeholder="******" autocomplete="new-password">
							@if($errors->has('password_confirmation'))
					    		<div class="alert alert-danger">
									<p>{{ $errors->first('password_confirmation') }}</p>
					    		</div>
							@endif
						</div>
						<button type="submit" class="btn btn-success w-100">Registrarme</button>
					</form>
					<div class="w-100 link-register">
						<a href="/login" class="center">Ya tengo cuenta</a>
					</div>
				</div>

			</div>	
		 <!--jquery-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
		 <!--Bootstrap-->
		<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	</body>
</html>