@extends('admin')
@section('page-header')
	<h1>
		Listado de Clientes
		<small></small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
		<li class="active">Clientes</li>
	</ol>
@endsection
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Clientes</b>
					<a href= "/addcustomer"  style="margin-top:-7px; float:right;" class="btn btn-success" >Nuevo Cliente</a> </div>
				<div class="panel-body">
					
					@if (Session::has('message'))
					<div class="alert alert-info">{{ Session::get('message') }}</div>
					@endif
					
					<table class="table table-hover">
						<thead>
							<tr>

								<th>Compañía</th>
								<th>Acción</th>
							</tr>
						</thead>
						<tbody>
							@foreach($clientes as $cliente)						
							<tr>
								<th>{{ $cliente->company_name }}</th>
								<td><a href= "/contacts/{{$cliente->id}}" class="btn btn-warning" >Contactos</a> @if(Auth::user()->roles_id==1 || Auth::user()->id==$cliente->created_by)&nbsp;&nbsp; <a href= "/customer/{{$cliente->id}}" class="btn btn-info" >Editar</a>&nbsp;&nbsp;
								<a href= "/deletecustomer/{{$cliente->id}}" onClick="return confirm('¿Esta seguro? Se eliminarán todos los registros asociados.');" class="btn btn-danger" >Eliminar</a>  @endif</td>
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
