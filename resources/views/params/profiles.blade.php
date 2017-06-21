@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-3 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">@if(isset($profile)) <b>Editar Perfil</b> @else <b>Nuevo Perfil</b> @endif </div>

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
				<form class="form-inline" method="POST" action="/profile">
				  <div class="form-group">
				    <input type="text" class="form-control" @if(isset($profile)) value="{{$profile->profile}}" @else value="{{ old('profile') }}" @endif name="profile">
				   @if(isset($profile)) <input type="hidden"  value="{{$profile->id}}" name="profile_id"> @endif
				  </div>
				  <button type="submit" class="btn btn-default">@if(isset($profile)) Editar @else Crear @endif </button>
				  </form>
			    
			    </div>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Perfiles IT</b> </div>
				<div class="panel-body">
					
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
					
					<table class="table table-hover">
						<thead>
							<tr>

								<th>Perfil</th>
								<th>Acción</th>

							</tr>
						</thead>
						<tbody>
							@foreach($profiles as $profile)						
							<tr>
								<td>{{ $profile->profile }}</td>
								<td><a href= "/profiles/{{$profile->id}}" class="btn btn-info" >Editar</a>
								<a href= "/deleteprofile/{{$profile->id}}" onClick="return confirm('¿Esta seguro?');" class="btn btn-danger" >Eliminar</a></td>
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
