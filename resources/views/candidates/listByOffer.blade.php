@extends('admin')
@section('page-header')
	<h1>
		Candidatos de la oferta
		<small>{{$offerTitle}}</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
		<li class="active">Candidatos de la oferta</li>
	</ol>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Candidatos de la oferta {{$offerTitle}}</b>
				<a href= "/addCandidateOffer/{{$offerID}}"  style="margin-top:-7px; float:right;" class="btn btn-success" >Asignar Candidato</a></div>
				<div class="panel-body">
					
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
					
					<table class="table table-hover">
						<thead>
							<tr>

								<th>Nombre</th>
								<th>Apellido</th>
                                <th>Postulado</th>
                                <th>Actualización ultimo estado</th>
								<th>Status</th>
                                <th>Acción</th>
							</tr>
						</thead>
						<tbody>
							@foreach($candidates as $candidate)	
@if(Auth::user()->roles_id == 3)
 @if($candidate->status_id != 4)
  <tr>
								<td><a href="/viewCandidate/{{$candidate->candidate->id}}">{{ $candidate->candidate->name }}</a></td>
								<td><a href="/viewCandidate/{{$candidate->candidate->id}}">{{ $candidate->candidate->surname }}</a></td>
                                <td>{{  date("d-m-Y h:i:s A", strtotime($candidate->created_at)) }}</td>   
<td>{{  date("d-m-Y h:i:s A", strtotime($candidate->statusActual->updated_at)) }}</td>   
								<td>
								<select class="form-control" id="status_{{$candidate->candidate->id}}_{{$offerID}}" onchange="changeStatus(this.id)" name="status">
											<option value="">Status</option>
											@foreach($status as $stat)
											<option value="{{$stat->id}}_{{$candidate->id}}" @if($stat->id==$candidate->statusActual->status_id) selected @endif>{{$stat->status}}</option>
											@endforeach
								</select>	
								</td>
                      <td>  
                     <a href= "/deletecandidateOffer/{{$offerID}}-{{$candidate->id}}" onClick="return confirm('¿Esta seguro?');" class="btn btn-danger" >Eliminar</a>&nbsp;&nbsp;
                		<a href= "/commentCO/{{$candidate->id}}-{{$offerID}}-{{$candidate->candidate->id}}" class="btn btn-info" >Ver Comentarios</a>&nbsp;&nbsp;
                		<a href= "/candidateOfferHistory/{{$candidate->id}}" class="btn btn-warning" >Historial</a>
                      </td>
							</tr>
 @endif
@else					
							<tr>
								<td><a href="/viewCandidate/{{$candidate->candidate->id}}">{{ $candidate->candidate->name }}</a></td>
								<td><a href="/viewCandidate/{{$candidate->candidate->id}}">{{ $candidate->candidate->surname }}</a></td> 
 <td>{{  date("d-m-Y h:i:s A", strtotime($candidate->created_at)) }}</td>   
<td>{{  date("d-m-Y h:i:s A", strtotime($candidate->updated_at)) }}</td>  
								<td>
								<select class="form-control" id="status_{{$candidate->candidate->id}}_{{$offerID}}" onchange="changeStatus(this.id)" name="status">
											<option value="">Status</option>
											@foreach($status as $stat)
											<option value="{{$stat->id}}_{{$candidate->id}}" @if($stat->id==$candidate->statusActual->status_id) selected @endif>{{$stat->status}}</option>
											@endforeach
									</select>	
								</td>
								<td>  
                     <a href= "/commentCO/{{$candidate->id}}-{{$offerID}}-{{$candidate->candidate->id}}" class="btn btn-info" >Ver Comentarios</a>&nbsp;&nbsp;
                		<a href= "/candidateOfferHistory/{{$candidate->id}}" class="btn btn-warning" >Historial</a>
                 </td>
							</tr>
@endif
							@endforeach
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script>
   
    function changeStatus(id) {

    var status_RelID = $( "#"+id ).val();
   
    $.post("{{url('changeCandidateStatus')}}",
    {
        status_RelID: status_RelID,
        "_token": '{{ csrf_token() }}'
    }, 
    function(data){

        }, 'json'); 
    alert("Estado cambiando correctamente.");
    }
</script>
@endsection
