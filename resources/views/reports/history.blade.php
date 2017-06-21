@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Historial de estados sobre <b>{{$relOC->candidate->name . ' ' . $relOC->candidate->surname}}</b> en la oferta <b>{{$relOC->offer->title}}</b></div>
				<div class="panel-body">
					
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
					
					<table class="table table-hover">
						<thead>
							<tr>

								<th>Fecha</th>
								<th>Usuario</th>
								<th>Estado</th>

							</tr>
						</thead>
						<tbody>
							@foreach($status as $stat)
<tr>
								<td>{{date("d-m-Y G:i", strtotime($stat->created_at))}}</td>
								<td>{{$stat->user->name . ' ' . $stat->user->surname}}</td>
								<td>{{$stat->status->status}}</td>
</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
