@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Usuarios</b>
					<a href= "/adduser"  style="margin-top:-7px; float:right;" class="btn btn-success" >Nuevo Usuario</a> </div>
				<div class="panel-body">
					
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
					
					<table class="table table-hover">
						<thead>
							<tr>

								<th>Nombre</th>
								<th>Apellido</th>
								<th>Tipo Usuario</th>
								<th>Acción</th>
							</tr>
						</thead>
						<tbody>
							@foreach($usuarios as $user)						
							<tr>
								<th>{{ $user->name  }}</th>
								<td>{{ $user->surname }}</td>
								<td>{{ $user->rol->rol }}</td>
								<td><a href= "/profile/{{$user->id}}" class="btn btn-info" >Editar</a>@if(Auth::user()->id!=$user->id)&nbsp;&nbsp;
								<a href= "/deleteuser/{{$user->id}}" onClick="return confirm('¿Esta seguro?');" class="btn btn-danger" >Eliminar</a>  @endif</td>
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
