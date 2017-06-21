<!DOCTYPE html>
<html lang="es-AR">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Nuevo candidato a Revisar!</h2>

		<div>
		Equipo, se ha asignado un posible candidato a revisar en la posición de {{$relOC->offer->title}}, del cliente {{$relOC->offer->contact->customer->company_name}}. 
		</div>
		<div> El recruiter que postuló al candidato fue: <b>{{$relOC->recruiters->name . ' ' . $relOC->recruiters->surname}}</b>. </div>
        <div> Para acceder al perfil del candidato <a target="_blank" href="http://ats.itwarp.com/viewCandidate/{{$relOC->candidates_id}}">,{{$relOC->candidate->name . ' ' . $relOC->candidate->surname}}, haga click aquí</a>. </div>
		<div> Para actualizar el estado del candidato con respecto a la posición, <a target="_blank" href="http://ats.itwarp.com/candidates/{{$relOC->offers_id}}">haga click aquí</a>. </div>
	</body>
</html>