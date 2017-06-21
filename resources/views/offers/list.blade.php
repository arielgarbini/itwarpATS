@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Ofertas</b>
				@if(Auth::user()->roles_id!=2)	<a href= "/addoffer"  style="margin-top:-7px; float:right;" class="btn btn-success" >Nueva Oferta Laboral</a> @endif</div>
				<div class="panel-body">
					
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
					
					<table class="table table-hover" id="simpleTable">
						<thead>
							<tr>
								
								<th data-sort="int">Estado <i class="fa fa-sort" aria-hidden="true"></i></th>
								<th data-sort="string">Posición <i class="fa fa-sort" aria-hidden="true"></i></th>
								<th data-sort="string">Cliente <i class="fa fa-sort" aria-hidden="true"></i></th>
								<th data-sort="int">Vacantes <i class="fa fa-sort" aria-hidden="true"></i></th>
								<th>Abierta desde</th>
								<th>Acciones</th>

							</tr>
						</thead>
						<tbody>
							@if(Auth::user()->roles_id!=2)
							@foreach($offers as $offer)
                                                        @if($offer->is_active==1)						
							<tr>
								<td><span class="circulo_status" title="{{$offer->status->status}}" style="background: {{$offer->status->color}}; border: 3px solid {{$offer->status->color}};">{{$offer->status->nro}}</span></td>
								<td><a href= "/viewoffer/{{$offer->id}}">{{ $offer->title }}</a></td>
								<td>{{ $offer->contact->customer->company_name }}</td>
								<td>{{ $offer->open_positions }}</td>
								<td>{{ $offer->open_date }}</td>
								<td><a href= "/candidates/{{$offer->id}}" class="btn btn-warning" >Candidatos</a>&nbsp;&nbsp;<a href= "/offerComments/{{$offer->id}}" class="btn btn-primary" >Comentarios</a>&nbsp;&nbsp;<a href= "/offer/{{$offer->id}}" class="btn btn-info" >Editar</a>@if(Auth::user()->roles_id==1 || Auth::user()->id==$offer->created_by)&nbsp;&nbsp;
								<a href= "/deleteoffer/{{$offer->id}}" onClick="return confirm('¿Esta seguro? Se eliminarán todos los registros asociados.');" class="btn btn-danger" >Eliminar</a>  @endif</td>
							</tr>
 @endif
							@endforeach
							@else
							@foreach($offers as $offer)
                                                        @if($offer->is_active==1 && $offer->offer->status->id!=7 && $offer->offer->status->id!=8 && $offer->offer->status->id!=9)						
							<tr>
								<td><a href= "/viewoffer/{{$offer->offer->id}}">{{ $offer->offer->title }}</a></td>
								<td>{{ $offer->offer->contact->customer->company_name }}</td>
								<td>{{ $offer->offer->open_positions }}</td>
								<td>{{ $offer->offer->open_date }}</td>
								<td><a href= "/candidates/{{$offer->offer->id}}" class="btn btn-warning" >Candidatos</a>&nbsp;&nbsp;<a href= "/offerComments/{{$offer->offer->id}}" class="btn btn-primary" >Comentarios</a>&nbsp;&nbsp;<a href= "/offer/{{$offer->offer->id}}" class="btn btn-info" >Editar</a>@if(Auth::user()->roles_id==1 || Auth::user()->id==$offer->offer->created_by)&nbsp;&nbsp;
								<a href= "/deletecontact/{{$offer->offer->id}}" onClick="return confirm('¿Esta seguro? Se eliminarán todos los registros asociados.');" class="btn btn-danger" >Eliminar</a>  @endif</td>
							</tr>
                                                        @endif
							@endforeach
							@endif
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="{{asset('js/stupidtable.js')}}"></script>
<script>  $("#simpleTable").stupidtable(); </script>
@endsection
