@extends('admin')
@section('page-header')
	<h1>
		Crear Cliente
		<small></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
		<li class="active">Nuevo cliente</li>
	</ol>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">Nuevo cliente</div>
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
				<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="/addcustomer">

						<div class="list-group">
							<div class="list-group-item">
								<legend>Información de la empresa</legend>

								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								
								<div class="form-group">
									<label class="col-md-4 control-label">Razón Social / Nombre Fantasía</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}" required>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Logo</label>
									<div class="col-md-6">
										<input type="file" class="form-control" name="logo">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Descripción de la Empresa</label>
									<div class="col-md-6">
										<textarea class="form-control" name="company_description"></textarea>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Asignado a</label>
									<div class="col-md-6">
										<select class="form-control" name="owned_by" value="{{ old('owned_by') }}" required>
											@foreach($users as $user)
											<option value="{{$user->id}}">{{$user->name . ' ' . $user->surname}}</option>
											@endforeach
										</select>	
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">País</label>
									<div class="col-md-6">
										<select class="form-control" id="country" name="country" value="{{ old('country') }}" required>
											<option value="">Seleccione País</option>
											@foreach($countries as $country)
											<option value="{{$country->id}}">{{$country->country}}</option>
											@endforeach
										</select>	
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Provincia</label>
									<div class="col-md-6">
										<select class="form-control" id="state" name="state" value="{{ old('state') }}" required disabled>
											<option value="">Seleccione Provincia</option>
										</select>	
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Dirección</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="address" value="{{ old('address') }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Ciudad</label>
									<div class="col-md-3">
									<input type="text" class="form-control" name="city" class="form-control" value="{{ old('city') }}"> 
									</div> 
									<label class="col-md-1 control-label">CP</label>
									<div class="col-md-2">
										<input type="text" class="form-control" name="post_code" value="{{ old('post_code') }}"> 
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-5"><br/>
								<button type="submit" class="btn btn-primary">
									Crear Cliente
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        	
<script>
	
$('#country').change(function() {

	var id = $( "#country" ).val();	
	$.post("{{url('state')}}",
    {
        id: id,
        "_token": '{{ csrf_token() }}'
    },
    function(data){
       $( "#state" ).prop( "disabled", false ); 
        
        $('#state').html('<option value="">Seleccione Provincia</option>');

          $.each(data, function(index, element){
                
                 $('#state').append('<option value="'+element.id+'">'+element.state+'</option>');
                                  
            });
    });
   
});


   </script>

@endsection
