@extends('admin')
@section('page-header')
	<h1>
		Comentarios del candidato
		<small>{{$candidate->name . ' ' . $candidate->surname}}</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
		<li class="active">Comentarios</li>
	</ol>
@endsection

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Comentarios sobre <b>{{$candidate->name . ' ' . $candidate->surname}}</b></div>
				<div class="panel-body">
					
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
					
					<table class="table table-hover">
						<thead>
							<tr>

								<th>Fecha</th>
								<th>Usuario</th>
                                                                <th>Oferta</th>
                                                                <th>Cliente</th>
								<th>Comentario</th>

							</tr>
						</thead>
						<tbody>
							@foreach($candidate->comments as $comment)
<tr>
								<td>{{date("d-m-Y", strtotime($comment->created_at))}}</td>
								<td>{{$comment->user->name . ' ' . $comment->user->surname}}</td>
								<td></td>
								<td></td>
	<td>{{$comment->comment}}</td>
</tr>
							@endforeach
                                                        @foreach($comments as $comment)
<tr>
								<td>{{date("d-m-Y", strtotime($comment->created_at))}}</td>
								<td>{{$comment->user->name . ' ' . $comment->user->surname}}</td>
								<td>{{$comment->relOC->offer->title}}</td>
								<td>{{$comment->relOC->offer->contact->customer->company_name}}</td>
								<td>{{$comment->comment}}</td>
</tr>
							@endforeach
						</tbody>
					</table>
					<form class="form-horizontal" role="form" method="POST" action="/candidateComments">

						<div class="list-group">
							<div class="list-group-item">
								<legend>Agregar comentario</legend>

								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="candidate_id" value="{{ $candidate->id }}">
								
								<div class="form-group">
									<label class="col-md-4 control-label">Comentario</label>
									<div class="col-md-6">
									<textarea class="form-control" name="comment" required></textarea>
									</div>
								</div>
									</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-5"><br/>
								<button type="submit" class="btn btn-primary">
									Agregar comentario!
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
