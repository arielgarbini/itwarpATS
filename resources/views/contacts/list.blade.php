@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Contactos</b>
					<a href= "/addcontact/{{$customer_id}}"  style="margin-top:-7px; float:right;" class="btn btn-success" >Nuevo Contacto</a> </div>
				<div class="panel-body">
					
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
					
					<table class="table table-hover">
						<thead>
							<tr>

								<th>Nombre</th>
								<th>Apellido</th>
								<th>Rol</th>
								<th>Acción</th>

							</tr>
						</thead>
						<tbody>
							@foreach($contacts as $contact)						
							<tr>
								<td>{{ $contact->name }}</td>
								<td>{{ $contact->surname }}</td>
								<td>{{ $contact->position->position }}</td>
								<td> @if(Auth::user()->roles_id==1 || Auth::user()->id==$contact->customer->created_by) <a href= "/contact/{{$contact->id}}" class="btn btn-info" >Editar</a>&nbsp;&nbsp;
								<a href= "/deletecontact/{{$contact->id}}" onClick="return confirm('¿Esta seguro? Se eliminarán todos los registros asociados.');" class="btn btn-danger" >Eliminar</a>  @endif</td>
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
