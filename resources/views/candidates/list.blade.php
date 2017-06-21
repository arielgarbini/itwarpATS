@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Filtros</b> </div>

				<div class="panel-body">

				<form class="form-inline" method="POST" action="filterCandidates">
				  <div class="form-group">
				    <select class="form-control" name="profile">
				    	<option  value="0">Seleccione Perfil</option>
				    	@foreach($profiles as $profile)
				    	<option  value="{{$profile->id}}" @if(isset($prof) && $prof==$profile->id) selected @endif>{{$profile->profile}}</option>
				    	@endforeach
				    </select>
				  </div>
				  <div class="form-group">
				   <select class="form-control" name="recruiter">
				    	<option  value="0">Seleccione Recruiter</option>
				    	@foreach($recruiters as $recruiter)
				    	<option  value="{{$recruiter->id}}" @if(isset($rec) && $rec==$recruiter->id) selected @endif>{{$recruiter->name}}</option>
				    	@endforeach
				   </select>
				  </div>
				  <div class="form-group">
				  <select class="form-control" name="status">
				    	<option  value="0">Seleccione Estado</option>
				    	@foreach($status as $stat)
				    	<option  value="{{$stat->id}}" @if(isset($statu) && $statu==$stat->id) selected @endif>{{$stat->status}}</option>
				    	@endforeach
				  </select>  
				  </div>
				  <div class="form-group">
				    <input type="text" class="form-control" placeholder="Buscar dentro CV" @if(isset($find)) value="{{$find}}" @endif name="find">
				  </div>
				  <button type="submit" class="btn btn-default">Aplicar Filtros</button>
				  <button type="reset" class="btn btn-default">Borrar Filtros</button>
				</form>
			    
			    </div>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				<div class="panel-heading"><b>Candidatos</b>
					<a href= "/addcandidate"  style="margin-top:-7px; float:right;" class="btn btn-success" >Nuevo Candidato</a></div>
				<div class="panel-body">
					
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
					

					<table class="table table-hover">
						<thead>
							<tr>

								<th>Nombre</th>
								<th>Apellido</th>
								<th>Profile</th>
								<th>Cargado por</th>
								<th>Estado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							@foreach($candidates as $candidate)						
							<tr>
								<td><a href="/viewCandidate/{{$candidate->id}}">{{ $candidate->name }}</a></td>
								<td><a href="/viewCandidate/{{$candidate->id}}">{{ $candidate->surname }}</a></td>
								<?php $prof = ""; ?>
								@foreach($candidate->profiles as $profile)
									<?php $prof .= $profile->profile['profile'] .','; ?> 		
								@endforeach
								<?php $prof = substr_replace($prof, "", -1) ?>
								<td>{{ $prof }}</td>
								<td>{{ $candidate->recruiter->name .' '.$candidate->recruiter->surname }}</td>
								<td>{{ $candidate->workStatus->status }}</td>
								<td><a href= "/candidateComments/{{$candidate->id}}" class="btn btn-primary" >Comentarios</a>&nbsp;&nbsp;<a href= "/addOfferCandidate/{{$candidate->id}}" class="btn btn-warning" >Postular!</a>&nbsp;&nbsp;<a href= "/candidate/{{$candidate->id}}" class="btn btn-info" >Editar</a>@if(Auth::user()->roles_id==1 || Auth::user()->id==$candidate->created_by)&nbsp;&nbsp;
								<a href= "/deletecandidate/{{$candidate->id}}" onClick="return confirm('¿Esta seguro? Se eliminarán todos los registros asociados.');" class="btn btn-danger" >Eliminar</a>  @endif</td>
							</tr>
							@endforeach
						</tbody>
					</table>
						@if(!isset($filter)) <center> <?php echo $candidates->render(); ?> </center> @endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
