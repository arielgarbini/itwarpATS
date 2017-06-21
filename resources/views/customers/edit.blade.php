@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">{{ $cliente->company_name }}</div>
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
				<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="/customer">

						<div class="list-group">
							<div class="list-group-item">
								<legend>Información de la empresa</legend>

								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								
								<input type="hidden" name="customer_id" value="{{ $cliente->id }}">
								
								<div class="form-group">
									<label class="col-md-4 control-label">Razón Social / Nombre Fantasía</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="company_name" value="{{ $cliente->company_name }}" required>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Logo</label>
									<div class="col-md-6">
										<input type="file" class="form-control" name="logo">
										<img src="{{asset('logos/'.$cliente->logo)}}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Descripción de la Empresa</label>
									<div class="col-md-6">
										<textarea class="form-control" name="company_description">{{ $cliente->company_description }}</textarea>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Asignado a</label>
									<div class="col-md-6">
										<select class="form-control" name="owned_by" required>
											@foreach($users as $user)
											<option value="{{$user->id}}" @if($user->id==$cliente->owned_by) selected @endif >{{$user->name . ' ' . $user->surname}}</option>
											@endforeach
										</select>	
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">País</label>
									<div class="col-md-6">
										<select class="form-control" id="country" name="country" required>
											<option value="">Seleccione País</option>
											@foreach($countries as $country)
											<option value="{{$country->id}}" @if($country->id==$cliente->address->countries_id) selected @endif >{{$country->country}}</option>
											@endforeach
										</select>	
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Provincia</label>
									<div class="col-md-6">
										<select class="form-control" id="state" name="state" required>
											<option value="">Seleccione Provincia</option>
											@foreach($states as $state)
											<option value="{{$state->id}}" @if($state->id==$cliente->address->states_id) selected @endif >{{$state->state}}</option>
											@endforeach
										</select>	
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Dirección</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="address" value="{{ $cliente->address->address }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Ciudad</label>
									<div class="col-md-3">
									<input type="text" class="form-control" name="city" class="form-control" value="{{ $cliente->address->city }}"> 
									</div> 
									<label class="col-md-1 control-label">CP</label>
									<div class="col-md-2">
										<input type="text" class="form-control" name="post_code" value="{{ $cliente->address->post_code }}"> 
									</div>
								</div>
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-5"><br/>
								<button type="submit" class="btn btn-primary">
									Editar Cliente
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
