<?php
	$json = array();
	$now = time();
	$time_per_way = 4 * 60 * 60 + 17 * 60;
	$time_total = 2 * $time_per_way;
	$time = $now % $time_per_way;
	$reverse = ($now % $time_total) >= $time_per_way;
	$way_percent = $time / $time_per_way * 100;
	
	$json['time_per_way'] = $time_per_way;
	$json['percent'] = round($way_percent, 2);
	$json['speed'] = rand(0, 100);
	$json['temperature'] = rand(-10, 25);
	$json['time'] = $now;
	
	if ($reverse) {
		$json['stations'] = array(
			array(
				'index' => 0,
				'name' => 'Tirano',
				'location' => 0
			),
			array(
				'index' => 1,
				'name' => 'Le Prese',
				'location' => 11.32
			),
			array(
				'index' => 2,
				'name' => 'Poschiavo',
				'location' => 18.34
			),
			array(
				'index' => 3,
				'name' => 'Alp Grüm',
				'location' => 42.2
			),
			array(
				'index' => 4,
				'name' => 'Pontresina',
				'location' => 58.13
			),
			array(
				'index' => 5,
				'name' => 'Bergün',
				'location' => 71.0
			),
			array(
				'index' => 6,
				'name' => 'Filisur',
				'location' => 76.1
			),
			array(
				'index' => 7,
				'name' => 'Tiefencastel',
				'location' => 83.3
			),
			array(
				'index' => 8,
				'name' => 'Chur',
				'location' => 100
			)
		);
	} else {
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
	}
	
	echo json_encode($json, JSON_PRETTY_PRINT + JSON_UNESCAPED_UNICODE);
?>