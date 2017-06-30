@extends('admin')
@section('page-header')
	<h1>
		Consultar Candidatos Cargados
		<small></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
		<li class="active">Consultar</li>
	</ol>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
            <div class="col-md-9 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Consultar Histórico de Candidatos Cargados!
				</div>
				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="/postReportRecruiter">
						<div class="list-group">
							<div class="list-group-item">
								<legend>Seleccione recruiter y período</legend>
                                                                <div class="form-group">
									<label class="col-md-4 control-label">Recruiter</label>
									<div class="col-md-4">
										<select class="form-control" name="recruiter_id" value="{{ old('recruiter_id') }}" required>
											<option value="">Seleccione Recruiter</option>
											@foreach($recruiters as $rec)
											<option value="{{$rec->id}}">{{$rec->name}}</option>
											@endforeach
										</select>
									</div>
								</div>	
								<div class="form-group">
									<label class="col-md-4 control-label">Desde</label>
									<div class="col-md-4">
										<input type="date" class="form-control" name="desde" value="{{ old('desde') }}" required>
									</div>
								</div>							
								<div class="form-group">
									<label class="col-md-4 control-label">Hasta</label>
									<div class="col-md-4">
										<input type="date" class="form-control" name="hasta" value="{{ old('hasta') }}"  required>
									</div>
								</div>	

								<div class="form-group">
							<div class="col-md-4 col-md-offset-4"><br/>
								<button type="submit" class="btn btn-primary">
									Consultar!
								</button>
							</div>
						</div>

							</form>
							
		@if($candidatos!=null)
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Candidatos cargados x fecha
				</div>
				<div class="panel-body">
					
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
				
					<table class="table table-hover">
						<thead>
							<tr>

								<th>Fecha</th>
								<th>Cantidad</th>
								</tr>
						</thead>
						<tbody>
							<?php 

                                                     $total = 0;

							?>
							@foreach($candidatos as $candidato)
							<tr>
								<th>{{ $candidato->{'date'}  }}</td>
								<td> {{ $candidato->{'total'}  }}  </td>	
								</tr>


							@endforeach
							</tbody>
					</table>
					@endif
		
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
