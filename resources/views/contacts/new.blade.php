@extends('admin')
@section('page-header')
	<h1>
		Crear Contacto
		<small></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
		<li class="active">Nuevo contacto</li>
	</ol>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Nuevo contacto de {{$customer->company_name}}</div>
				<div class="panel-body">
					@if (count($errors) > 0)
					<div class="alert alert-danger">
						<strong>Ups!</strong> Existen los siguientes errores.<br><br>
						<ul>
							@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
					@endif
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
				<form class="form-horizontal" role="form" method="POST" action="/addcontact">

						<div class="list-group">
							<div class="list-group-item">
								<legend>Información del Contacto</legend>

								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="customer_id" value="{{$customer->id}}">
								
								<div class="form-group">
									<label class="col-md-4 control-label">Nombre</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Apellido</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="surname" value="{{ old('surname') }}" required>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">E-mail</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="email" value="{{ old('email') }}" required>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Celular</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Teléfono</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="telephone" value="{{ old('telephone') }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Rol</label>
									<div class="col-md-6">
										<select class="form-control" name="rol" value="{{ old('rol') }}" required>
											<option value="">Seleccione Rol</option>
										@foreach($roles as $rol)
											<option value="{{$rol->id}}">{{$rol->position}}</option>
										@endforeach
										</select>	
									</div>
								</div>

							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-5"><br/>
								<button type="submit" class="btn btn-primary">
									Crear Contacto
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
