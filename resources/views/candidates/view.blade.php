@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-5 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading"><b>{{$candidate->name . ' ' . $candidate->surname}}</b></div>
				<div class="panel-body">
			    
			    <form class="form-horizontal" role="form">
						<div class="list-group">
							<div class="list-group-item">
								<legend>Información personal</legend>
								
								<div class="form-group">
									<label class="col-md-6 control-label"><b>Nombre: </b> {{ $candidate->name }}</label>
								</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>Apellido: </b> {{ $candidate->surname }}</label>
									
								</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>E-mail: </b> {{ $candidate->email }}</label>
									
								</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>Celular: </b> {{ $candidate->cellphone }}</label>
									
								</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>Teléfono: </b> {{ $candidate->telephone }}</label>
									
								</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>CV - Archivo Original: </b> @if($candidate->original_resume!=null)
										<a href="{{url('cv_originales/'.$candidate->original_resume)}}" download> Descargar CV Original </a>
										@endif </label>
								
								</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>CV - Archivo ITW Formateado: </b> @if($candidate->itwarp_resume!=null)
										<a href="{{url('cv_formateados/'.$candidate->itwarp_resume)}}" download> Descargar CV Formateado </a>
										@endif</label>
									
								</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>País: </b> {{$candidate->address->country->country}}</label>
									
								</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>Provincia: </b> {{$candidate->address->state->state}}</label>
									
								</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>Dirección: </b> {{ $candidate->address->address }}</label>
									
								</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>Ciudad: </b> {{ $candidate->address->city }} </label>
									
									<label class="col-md-1 control-label"><b>CP: </b> {{$candidate->address->post_code }} </label>
									
								</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>Salario Bruto</b> </label>
									<label class="col-md-1 control-label"><b>Actual: </b>  ${{ $candidate->current_salary }}</label>
									
									<label class="col-md-1 control-label"><b>Pretendido: </b> ${{ $candidate->intended_salary }} </label>
									
								</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>Origen: </b> {{$candidate->source->source}}</label>
									
								</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>Experiencia desde: </b> {{ $candidate->experience_year }}</label>
									
								</div>
								<?php $prof = ""; ?>
								@foreach($candidate->profiles as $profile)
									<?php $prof .= $profile->profile['profile'] .','; ?> 		
								@endforeach
								<?php $prof = substr_replace($prof, "", -1) ?>
								<div class="form-group">
									<label class="col-md-6 control-label"><b>Profiles: </b> {{ $prof }}</label>
									
							</div>

								<div class="form-group">
									<label class="col-md-6 control-label"><b>Estado Laboral: </b> {{$candidate->workStatus->status}}</label>
									
								</div>

							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
