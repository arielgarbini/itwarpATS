@extends('app')

@section('content')

                    @if (Session::has('message'))
                    <div class="alert alert-info">{{ Session::get('message') }}</div>
                    @endif
<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				<div class="panel-heading"><b>Reporte General</b></div>
				<div class="panel-body">
					
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
					

					<table class="table table-hover">
						<thead>
							<tr>
								<th>Posición</th>
								<th>Cliente</th>
								<th>Abierta desde</th>
								<th>Recruiters asignados</th>
								<th>Perfiles postulados</th>
								<th title="Sin postular">I01</th>
								<th title="Revisión CV">I02</th>
								<th title="Entrevista ITW">I04</th>
								<th title="Postulado a Recruiting Manager">I05</th>
<th title="Rechazado por ITW">I09</th>
								<th title="Postulado a cliente">E01</th>
								<th title="Entrevista Cliente">E03</th>
<th title="Rechazado por Cliente">E04</th>
								<th title="Contratado">I10</th>
							</tr>
						</thead>
						<tbody>
							@foreach($positions as $position)
						<tr>
							<td><a href="{{url('candidates/'.$position->id)}}"><b>{{$position->title}}</b></a></td>
							<td><b>{{$position->contact->customer->company_name}}</b></td>
							<td>{{date("d-m-Y", strtotime($position->open_date))}}</td>
							<?php $rec = ""; ?>
							@foreach($position->recruiters as $recruiter)
							@if($recruiter->recruiter!=4)
							<?php $rec .= \App\User::find($recruiter->recruiter)->name .','; ?>
							@endif
							@endforeach
							<?php $rec = substr_replace($rec, "", -1) ?>
							<td>{{ $rec }}</td>
							<td><a href="{{url('candidates/'.$position->id)}}">{{$position->candidates->count()}}</a></td>
							<?php
                                  $arrayStatus = Array();
							foreach ($position->candidates->where('is_active', 1) as $can) {
		                    $arrayStatus[] = $can->rel_status_candidate_offer_id;
                             
		                	}
                                       
		                	$stats = \App\RelStatusCandidateOffer::whereIn('id', $arrayStatus)->get();
		                	?>
							<td>{{$stats->where('status_id', 1)->count()}}</td>
							<td>{{$stats->where('status_id', 9)->count()}}</td>
							<td>{{$stats->where('status_id', 10)->count()}}</td>
							<td>{{$stats->where('status_id', 8)->count()}}</td>
<td>{{$stats->where('status_id', 4)->count()}}</td>
							<td>{{$stats->where('status_id', 2)->count()}}</td>
							<td>{{$stats->where('status_id', 3)->count()}}</td>
<td>{{$stats->where('status_id', 5)->count()}}</td>
							<td>{{$stats->where('status_id', 7)->count()}}</td>
						</tr>
						 <?php unset($arrayStatus);?>
							@endforeach
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>


@endsection

