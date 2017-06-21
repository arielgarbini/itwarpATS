@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Candidatos a Revisar CV</b></div>
				<div class="panel-body">
					
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
					
					<table class="table table-hover">
						<thead>
							<tr>

								<th>Nombre</th>
								<th>Apellido</th>
                                <th>Cliente</th>
                                <th>Posición</th>
								<th>Status</th>
                                <th>Acción</th>
							</tr>
						</thead>
						<tbody>
							@foreach($candidates as $candidate)	
							@if($candidate->statusActual->status_id==9)
							<tr>
								<td><a href="/viewCandidate/{{$candidate->candidate->id}}">{{ $candidate->candidate->name }}</a></td>
								<td><a href="/viewCandidate/{{$candidate->candidate->id}}">{{ $candidate->candidate->surname }}</a></td> 
 								<td>{{$candidate->offer->contact->customer->company_name}}</td>   
								<td>{{$candidate->offer->title}}</td>  
								<td>
								<select class="form-control" id="status_{{$candidate->candidate->id}}_{{$candidate->offer->id}}" onchange="changeStatus(this.id)" name="status">
											<option value="">Status</option>
											@foreach($status as $stat)
											<option value="{{$stat->id}}_{{$candidate->id}}" @if($stat->id==$candidate->statusActual->status_id) selected @endif>{{$stat->status}}</option>
											@endforeach
								</select>	
								</td>
								<td>  
                     			<a href= "/commentCO/{{$candidate->id}}-{{$candidate->offer->id}}-{{$candidate->candidate->id}}" class="btn btn-info" >Ver Comentarios</a>&nbsp;&nbsp;
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
