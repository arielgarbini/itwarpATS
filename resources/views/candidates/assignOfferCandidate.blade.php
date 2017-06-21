@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Asignar {{$candidate->name . ' ' . $candidate->surname}} a:</div>
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
				<form class="form-horizontal" role="form" method="POST" action="/addOfferCandidate">

						<div class="list-group">
							<div class="list-group-item">
								<legend>Oferta</legend>

								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<input type="hidden" name="candidates_id" value="{{ $candidate->id }}">
								<input type="hidden" name="offers_id" id="offers_id">

								<div class="form-group">
									<label class="col-md-4 control-label">Oferta</label>
									<div class="col-md-6">
										<input type="text" class="form-control" id="offer" name="offer" value="{{ old('offer') }}" required>
									</div>
								</div>

							

							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-5"><br/>
								<button type="submit" class="btn btn-primary">
									Asignar!
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script>
$( "#offer" ).autocomplete({
	    	source: "{{url('autocompleteOffer')}}",
	    	select: function (event, ui) {
	    		$('#offers_id').val(ui.item.id);
	    		$('#offer').val(ui.item.label);
	    		return false;
	    	}
	    });
</script>

@endsection
