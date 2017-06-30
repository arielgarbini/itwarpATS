@extends('admin')
@section('page-header')
	<h1>
		Editar candidato
		<small>{{$candidate->name . ' ' . $candidate->surname}}</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
		<li class="active">Editar candidato</li>
	</ol>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Editar candidato - <b>{{$candidate->name . ' ' . $candidate->surname}}</b></div>
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
				<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="/candidate">

						<div class="list-group">
							<div class="list-group-item">
								<legend>Información personal</legend>

								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
								<div class="form-group">
									<label class="col-md-4 control-label">Nombre</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="name" value="{{ $candidate->name }}" required>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Apellido</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="surname" value="{{ $candidate->surname }}" required>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">E-mail</label>
									<div class="col-md-6">
										<input type="email" class="form-control" name="email" value="{{ $candidate->email }}" required>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Celular</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="cellphone" value="{{ $candidate->cellphone }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Teléfono</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="telephone" value="{{ $candidate->telephone }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">CV</label>
									<div class="col-md-6">
										<textarea class="form-control" name="resume" required>{{ $candidate->resume }}</textarea>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">CV - Archivo Original</label>
									<div class="col-md-6">
										<input type="file" class="form-control" name="original_resume">
										@if($candidate->original_resume!=null)
										<a href="{{url('cv_originales/'.$candidate->original_resume)}}" download> Descargar CV Original </a>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">CV - Archivo ITW Formateado</label>
									<div class="col-md-6">
										<input type="file" class="form-control" name="itwarp_resume">
										@if($candidate->itwarp_resume!=null)
										<a href="{{url('cv_formateados/'.$candidate->itwarp_resume)}}" download> Descargar CV Formateado </a>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">País</label>
									<div class="col-md-6">
										<select class="form-control" id="country" name="country" value="{{ old('country') }}" required>
											<option value="">Seleccione País</option>
											@foreach($countries as $country)
											<option value="{{$country->id}}" @if($country->id==$candidate->address->countries_id) selected @endif >{{$country->country}}</option>
											@endforeach
										</select>	
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Provincia</label>
									<div class="col-md-6">
										<select class="form-control" id="state" name="state" value="{{ old('state') }}" required>
											<option value="">Seleccione Provincia</option>
											@foreach($states as $state)
											<option value="{{$state->id}}" @if($state->id==$candidate->address->states_id) selected @endif >{{$state->state}}</option>
											@endforeach
										</select>	
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Dirección</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="address" value="{{ $candidate->address->address }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Ciudad</label>
									<div class="col-md-3">
									<input type="text" class="form-control" name="city" class="form-control" value="{{ $candidate->address->city }}"> 
									</div> 
									<label class="col-md-1 control-label">CP</label>
									<div class="col-md-2">
										<input type="text" class="form-control" name="post_code" value="{{$candidate->address->post_code }}"> 
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Salario Bruto</label>
									<label class="col-md-1 control-label">Actual</label>
									<div class="col-md-2">
										<input type="text" class="form-control" name="current_salary" value="{{ $candidate->current_salary }}"> 
									</div>
									<label class="col-md-1 control-label">Pretendido</label>
									<div class="col-md-2">
										<input type="text" class="form-control" name="intended_salary" value="{{ $candidate->intended_salary }}"> 
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Origen</label>
									<div class="col-md-6">
										<select class="form-control" id="country" name="sources_id" value="{{ old('sources_id') }}">
											<option value="">Seleccione origen</option>
											@foreach($sources as $source)
											<option value="{{$source->id}}" @if($source->id==$candidate->sources_id) selected @endif >{{$source->source}}</option>
											@endforeach
										</select>	
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Experiencia desde</label>
									<div class="col-md-4">
										<input type="text" class="form-control" name="experience_year" placeholder="Año en formato XXXX" value="{{ $candidate->experience_year }}"> 
								
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Profiles</label>
									<div class="col-md-6">
					            <?php $prof = ""; ?>
								@foreach($candidate->profiles as $profile)
									<?php $prof .= $profile->profile['profile'] .','; ?> 		
								@endforeach
								<?php $prof = substr_replace($prof, "", -1) ?>
											<input type="text" class="form-control" name="profiles" id="profiles" value="{{$prof}}"> 
						
							</div>
							</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Estado Laboral</label>
									<div class="col-md-6">
										<select class="form-control" id="candidateworkstatus" name="candidateworkstatus" >
											<option value="">Seleccione estado</option>
											@foreach($workstatus as $ws)
											<option value="{{$ws->id}}" @if($ws->id==$candidate->candidateworkstatus_id) selected @endif >{{$ws->status}}</option>
											@endforeach
										</select>	
									</div>
								</div>

							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-5"><br/>
								<button type="submit" class="btn btn-primary">
									Actualizar Candidato
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript" charset="utf-8"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
<script src="{{asset('js/tag-it.js')}}" type="text/javascript"></script>
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

$(function(){
      $('#profiles').tagit({
      	allowSpaces:true,
      	autocomplete: {
        delay: 0,
        minLength: 2,
        source: "{{url('autocompleteProfiles')}}"
    }
      });
});


   </script>
@endsection
