@extends('admin')
@section('page-header')
	<h1>
		Editar Contacto de
		<small>{{$contact->customer->company_name}}</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
		<li class="active">Editar Contacto</li>
	</ol>
@endsection
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Editar contacto de {{$contact->customer->company_name}}</div>
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
				<form class="form-horizontal" role="form" method="POST" action="/contact">

						<div class="list-group">
							<div class="list-group-item">
								<legend>Información del Contacto</legend>

								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="contact_id" value="{{$contact->id}}">
								
								<div class="form-group">
									<label class="col-md-4 control-label">Nombre</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="name" value="{{$contact->name}}" required>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Apellido</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="surname" value="{{$contact->surname}}" required>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">E-mail</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="email" value="{{$contact->email}}" required>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Celular</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="mobile" value="{{ $contact->mobile }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Teléfono</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="telephone" value="{{ $contact->telephone }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Rol</label>
									<div class="col-md-6">
										<select class="form-control" name="rol" required>
											<option value="">Seleccione Rol</option>
										@foreach($roles as $rol)
											<option value="{{$rol->id}}" @if($rol->id==$contact->positions_id) selected @endif >{{$rol->position}}</option>
										@endforeach
										</select>	
									</div>
								</div>

							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-5"><br/>
								<button type="submit" class="btn btn-primary">
									Editar Contacto
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
