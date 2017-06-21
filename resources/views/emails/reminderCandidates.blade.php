<!DOCTYPE html>
<html lang="es-AR">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Candidatos a postular!</h2>

		<div>
		Estimado Ejecutivo Comercial, quedan pendientes los siguientes candidatos a postular: 
		</div>
                <p></p>
                @foreach($relOC as $roc)
                <div> Nombre de Oferta:  <b>{{$roc->offer->title}}</b> </div>
                <div> Nombre del Cliente:  <b>{{$roc->offer->contact->customer->company_name}}</b> </div>
                <div> Recruiter:  <b>{{$roc->recruiters->name . ' ' . $roc->recruiters->surname}}</b> </div>
                <div> Para acceder al perfil del candidato <a target="_blank" href="http://ats.itwarp.com/viewCandidate/{{$roc->candidates_id}}">{{$roc->candidate->name . ' ' . $roc->candidate->surname}}, haga click aquí</a>. </div>
		<div> Para actualizar el estado del candidato con respecto a la posición, <a target="_blank" href="http://ats.itwarp.com/candidates/{{$roc->offers_id}}">haga click aquí</a>. </div>
                <p></p>
                @endforeach
	</body>
</html>