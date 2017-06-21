<!DOCTYPE html>
<html lang="es-AR">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Verificar candidato!</h2>

		<div>
		Hola, se ha cambiado el estado de un candidato en la oferta {{$relOC->offer->title}}, del cliente {{$relOC->offer->contact->customer->company_name}}. 
		</div>
        <div> Para acceder al perfil del candidato <a target="_blank" href="http://ats.itwarp.com/viewCandidate/{{$relOC->candidates_id}}">,{{$relOC->candidate->name . ' ' . $relOC->candidate->surname}}, haga click aquí</a>. </div>
		<div> Para verificar el estado del candidato con respecto a la posición, <a target="_blank" href="http://ats.itwarp.com/candidates/{{$relOC->offers_id}}">haga click aquí</a>. </div>
	</body>
</html>