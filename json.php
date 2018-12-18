<?php
	include './php/db.php';
	
    $json = array();
	$now = time();
	$time_per_way = 4 * 60 * 60 + 17 * 60;
	$time_per_way = 300;
	$time_total = 2 * $time_per_way;
	$time = $now % $time_per_way;
	$reverse = ($now % $time_total) >= $time_per_way;
	$way_percent = $time / $time_per_way * 100;
    $env_data = $db->get_env_data($way_percent);
	
	$json['time_per_way'] = $time_per_way;
	$json['percent'] = round($way_percent, 2);
	
	$json['time'] = $now;
	
	if ($env_data != null) {
		$json['speed'] = $env_data['speed'] + round(rand(-2 , 2));
		$json['temperature'] = $env_data['temperature'];
		$json['elevation'] = $env_data['elevation'] + round(rand(-1 , 1));
	}
	
	$pois = array(
		array(
			'title' => 'Solis Viadukt',
			'description' => 'In wenigen Momenten fahren wir über die höchste Brücke der Albulalinie: Der Solisviadukt führt 85 Meter hoch über den Fluss Albula. Ein Bogen von 42 Metern Spannweite trägt die Konstruktion. Es ist der längste Brückenbogen der Albulalinie.',
			'location' => 11
		),
		array(
			'title' => 'Landwasserviadukt',
			'description' => 'Der 142 Meter lange Landwasserviadukt ist das Wahrzeichen der Rhätischen Bahn. Der Viadukt führt in schönem Schwung über das Landwassertal direkt in die schroffe Felswand in den Landwassertunnel hinein. Markenzeichen des Landwasserviadukts sind die sechs nahe aufeinander folgenden, 65 Meter hohen Brückenpfeiler mit einer Spannweite von nur 20 Metern.',
			'location' => 20
		),
		array(
			'title' => 'Stuls - Zeitreise ins Jahr 1903',
			'description' => 'Wir erreichen bald Stuls. Besser gesagt: Wir fahren am Bahnhof Stuls vorbei, weit weg vom Dorf. Aus der Zeit des Beginns des Bahnverkehrs, über 100 Jahre hinweg, stehen hier heute noch Bauten. 1903 herrschte hier noch reges Treiben. Die Gebäude, welche vom Zug aus gut sichtbar sind, stehen unter Denkmalschutz. ',
			'location' => 26.5
		),
		array(
			'title' => 'Kehrtunnels & Schlaufen',
			'description' => 'Wir befinden uns nun im steilsten und spektakulärsten Abschnitt der Albulalinie. Auf der kurzen Distanz von Bergün nach Preda überwindet der Zug in unzähligen Schlaufen 416 Höhenmeter. Den Dreh findet er nur dank einem bahntechnischen Meisterwerk: den insgesamt vier Kehrtunnels. Erst das Ausweichen in diese kreisförmigen Tunnels im Berginneren ermöglicht im Steilhang genügend weite Kurvenradien, damit sich der Zug in die Höhe schrauben kann.',
			'location' => 33
		),
		array(
			'title' => 'Engadin - Die Wiege des Wintertourismus',
			'description' => 'Wir befinden uns im Oberengadin, der Wiege des Wintertourismus. Die Bahnlinie überquert in Samedan den Inn. Von der Quelle am Malojapass durchfliesst der 500 Kilometer lange Alpenstrom das ganze Engadin und fliesst weiter durch Österreich und Deutschland, wo er in Passau in die Donau mündet. Die Berninalinie wird hier vom Fluss «Flaz» begleitet, ein wichtiger Zufluss des Inns. Hier in Samedan befindet sich zudem der höchstgelegene Flugplatz Europas.',
			'location' => 38
		),
		array(
			'title' => 'Bernina Gletscher - Das ewige Eis',
			'description' => 'Die Luftseilbahn Bernina Diavolezza erschliesst bequem die Bergstation auf 3 000 Metern über Meer. Oben wartet ein überwältigendes Alpen-Panorama mit Aussicht auf den Pers- und Morteratsch-Gletscher. Am Horizont erheben sich imposante Gipfel. Der Piz Bernina ist mit 4 049 Metern über Meer der höchste Gipfel der Ostalpen.',
			'location' => 53
		),
		array(
			'title' => 'Valposchiavo - Das südlichste Tal Graubünden',
			'description' => 'Mit dem Puschlav haben wir das südlichste Tal Graubündens erreicht – und zugleich auch den italienischen Sprachraum: Valposchiavo, so nennen die Einheimischen ihr Tal. Ankommen und Entschleunigen ist in der Ruheoase hinter den Bergen die Devise.',
			'location' => 71
		),
		array(
			'title' => 'Miralago - Der Ort am Lago di Poschiavo',
			'description' => 'Miralago nennen sich der winzige Ort und die Bahnstation am Südufer des Lago di Poschiavo. In den ersten Jahren des 20. Jahrhunderts, während des Baus der Bernina-Bahn, erlebte der Weiler eine Blütezeit. Heute ist die Gegend bekannt für Ruhe und Entspannung.',
			'location' => 92
		),
		array(
			'title' => 'Kreisviadukt Brusio',
			'description' => 'Der Kreisviadukt von Brusio – man nennt ihn auch das Gesellenstück der Schweizer Eisenbahningenieure. Hier dreht man sich im Kreis. Um im steilen Gelände Höhe zu überwinden, schlängelt sich der Zug in einer 360-Grad-Schleife über neun Bögen zu Tal. Unter einem der Viaduktbögen hindurch fädelt sich der Zug wieder aus. Das höchst fotogene Bauwerk gehört zum Repertoire jedes Bernina Express Reisenden.',
			'location' => 96
		)
	);
	
	$json['stations'] = array(
		array(
			'index' => 0,
			'name' => 'Chur',
			'location' => 0
		),
		array(
			'index' => 1,
			'name' => 'Tiefencastel',
			'location' => 16.7
		),
		array(
			'index' => 2,
			'name' => 'Filisur',
			'location' => 23.9
		),
		array(
			'index' => 3,
			'name' => 'Bergün',
			'location' => 29.0
		),
		array(
			'index' => 4,
			'name' => 'Pontresina',
			'location' => 41.87
		),
		array(
			'index' => 5,
			'name' => 'Alp Grüm',
			'location' => 57.8
		),
		array(
			'index' => 6,
			'name' => 'Poschiavo',
			'location' => 81.66
		),
		array(
			'index' => 7,
			'name' => 'Le Prese',
			'location' => 88.68
		),
		array(
			'index' => 8,
			'name' => 'Tirano',
			'location' => 100
		)
	);
	
	if ($reverse) {
		$json['stations'] = array_reverse($json['stations']);
		
		for ($i = 0; $i < sizeof($json['stations']); $i++) {
			$json['stations'][$i]['index'] = $i;
			$json['stations'][$i]['location'] = 100 - $json['stations'][$i]['location'];
		}
	}
	
	foreach ($pois as $poi) {
		if (abs($way_percent - ($reverse ? 100 - $poi['location'] : $poi['location'])) <= 1) {
			$json['poi'] = $poi;
		}
	}
	
	echo json_encode($json, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
?>