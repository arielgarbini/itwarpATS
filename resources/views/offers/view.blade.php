@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Detalle de <b>{{ $offer->title }}</b></div>
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
				<form class="form-horizontal" role="form" method="POST" enctype="multipart/form-data" action="/offer">

						<div class="list-group">
							<div class="list-group-item">
								<legend>Información de la Oferta</legend>

								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="offer_id" value="{{ $offer->id }}">
								
								<div class="form-group">
									<label class="col-md-4 control-label">Título</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="title" value="{{ $offer->title }}" disabled>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Descripción</label>
									<div class="col-md-6">
										<textarea class="form-control" name="description" rows="20" disabled>{{ $offer->description }}</textarea>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Job Description</label>
									<div class="col-md-6">
										<input type="file" class="form-control" name="job_description">
										@if($offer->job_description!=null)
										<a href="{{url('jds/'.$offer->job_description)}}" download> Descargar JD </a>
										@endif
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Posiciones abiertas</label>
									<div class="col-md-6">
										<input type="number" class="form-control" name="open_positions" value="{{ $offer->open_positions }}" disabled>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Fecha de Publicación</label>
									<div class="col-md-6">
										<input type="date" class="form-control" name="open_date" value="{{ $offer->open_date }}" required disabled>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Salario Bruto</label>
									<label class="col-md-1 control-label">Min.</label>
									<div class="col-md-2">
										<input type="text" class="form-control" name="salary_min" value="{{$offer->salary_min}}" disabled> 
									</div>
									<label class="col-md-1 control-label">Max.</label>
									<div class="col-md-2">
										<input type="text" class="form-control" name="salary_max" value="{{$offer->salary_max}}" disabled> 
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Jornada</label>
									<label class="col-md-1 control-label">Entrada</label>
									<div class="col-md-2">
										<input type="time" class="form-control" name="from_hr" value="{{$offer->from_hr}}" disabled> 
									</div>
									<label class="col-md-1 control-label">Salida</label>
									<div class="col-md-2">
										<input type="time" class="form-control" name="to_hr" value="{{$offer->to_hr}}" disabled> 
									</div>
								</div>

							<legend>Información de la Compañía</legend>

								<div class="form-group">
									<label class="col-md-4 control-label">Nombre de Contacto</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="contact" id="contact" value="{{$offer->contact->name . ' ' . $offer->contact->surname}}" disabled>
										<input type="hidden" class="form-control" name="contact_id" id="contact_id" value="{{ $offer->contact->id }}">
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Razón Social / Nombre Fantasía</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="company_name" id="company_name" value="{{ $offer->contact->customer->company_name }}" readonly disabled>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Email</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="contact_email" id="contact_email" value="{{ $offer->contact->email }}" readonly disabled>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Telefono</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="contact_telefono" id="contact_telefono" value="{{ $offer->contact->telephone }}" readonly disabled>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Celular</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="contact_celu" id="contact_celu" value="{{ $offer->contact->mobile }}" readonly disabled>
									</div>
								</div>

							<legend>Lugar de Trabajo</legend>

								<div class="form-group">
									<label class="col-md-4 control-label">Ubicación</label>
									<div class="col-md-6">
										<input type="text" class="form-control" name="address" id="address" value="{{ $direccion }}" disabled>
									</div>
								</div>

						<div class="form-group">
									<label class="col-md-4 control-label">Otra dirección?</label>
									<div class="col-md-6">
										<div class="radio">
										  <label>
    								<input type="radio" name="other_address" id="other_address_yes" value="1" disabled> Si
  </label>
</div>
<div class="radio">
  <label>
    <input type="radio" name="other_address" id="other_address_no" value="0" disabled>No
  </label>
</div>
</div>
								</div>
<div class="form-group">
									<label class="col-md-4 control-label">Recruiters</label>
									<div class="col-md-6">
							<select name="recruiters[]" multiple disabled>
								@foreach($recruiters as $recruiter)
  									<option value="{{$recruiter->id}}" } @if(in_array($recruiter->id, $reclutadores)) selected @endif >{{$recruiter->name . ' ' . $recruiter->surname}}</option>
  								@endforeach
							</select>
							</div>
							</div>

							<legend>Estado de Oferta</legend>

							<div class="form-group">
									<label class="col-md-4 control-label">Estado</label>
									<div class="col-md-6">
										<select class="form-control" name="offerstatus" value="{{ old('offerstatus') }}" disabled>
											<option value="">Seleccione Estado</option>
											@foreach($offerStatus as $os)
											<option value="{{$os->id}}" @if($os->id==$offer->offerstatus_id) selected @endif>{{$os->status}}</option>
											@endforeach
										</select>	
									</div>
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
