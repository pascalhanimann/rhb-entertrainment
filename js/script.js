// Vue-Komponente für POIs definieren
Vue.component("poi", {
	"props": ["poi"],
	"template": "#template-poi"
});

new Vue({
	"el": "#app",
	"data": {
		"api": null,
		"fontSizeTrigger": 10
	},
	"computed": {
		// Gibt die letzte Station, an der der Zug gehalten hat, zurück
		"stationBefore": function() {
			var station = null;
			
			for (var i = 0; i < this.api.stations.length; i++) {
				if (this.api.stations[i].location <= this.api.percent) {
					station = this.api.stations[i];
				}
			}
			
			return station;
		},
		// Gibt die nächste Station, an der der Zug halten wird, zurück
		"stationAfter": function() {
			var station = null;
			
			for (var i = 0; i < this.api.stations.length; i++) {
				if (this.api.stations[i].location > this.api.percent) {
					station = this.api.stations[i];
					break;
				}
			}
			
			return station;
		},
		// Berechnet je nach Streckenprozent, wie weit die Perlschnur heruntergeschoben werden muss
		"locationvh": function() {
			var stationBefore = this.stationBefore;
			var stationAfter = this.stationAfter;
			
			var vhMin = 34;
			var vhMax = (34 - ((this.api.stations.length - 1) * 17));
			
			if (stationBefore == null) {
				return vhMin;
			} else if (stationAfter == null) {
				return vhMax;
			} else {
				var vhBase = (34 - (stationBefore.index * 17));
				var diff = stationAfter.location - stationBefore.location;
				var wayDone = this.api.percent - stationBefore.location;
				var vhDelta = (wayDone / diff * 17);
				
				return vhBase - vhDelta;
			}
		},
		// Formatiert eine Uhrzeit im Format HH:mm
		"formattedtime": function() {
			return moment.unix(this.api.time).format("HH:mm");
		}
	},
	"methods": {
		// Berechnet für jede Station die Schriftgrösse
		"calculateFontSize": function(station) {
			return this.calculateForStation(station, 20, 36);
		},
		// Berechnet für jede Station die Deckkraft
		"calculateOpacity": function(station) {
			return this.calculateForStation(station, 0.5, 1);
		},
		// Berechnet einen beliebigen Wert für eine beliebige Station, wenn min und max des Wertes bekannt sind
		"calculateForStation": function(station, min, max) {
			if (this.api.stations[this.api.stations.length - 1].index == station.index && this.stationAfter == null) {
				var range = 100 - this.api.stations[this.api.stations.length - 2].location;
				var diff = 100 - this.api.percent;
				
				return (max - (diff / range * (max - min)));
			} else if (this.stationBefore.index == station.index) {
				var range = (this.stationAfter == null ? 100 : this.stationAfter.location) - this.stationBefore.location;
				var diff = this.api.percent - this.stationBefore.location;
				
				return (max - (diff / range * (max - min)));
			} else if (this.stationAfter != null && this.stationAfter.index == station.index) {
				var range = this.stationAfter.location - (this.stationBefore == null ? 0 : this.stationBefore.location);
				var diff = this.stationAfter.location - this.api.percent;
				
				return (max - (diff / range * (max - min)));
			} else {
				return min;
			}
		},
		// Berechnet, wie gross die "Perle" bei dieser Station sein muss
		"calculateBulletDimension": function(station) {
			return this.calculateForStation(station, 4, 10);
		},
		// Schaut, ob diese Station die Start- oder Endstation ist und zeigt je nach dem ein anderes Bild der "Perle" an
		"calculateBackground": function(station) {
			var pic = "./images/schnur_beide.png";
			
			if (station.index == 0) {
				pic = "./images/schnur_start.png";
			} else if (station.index == (this.api.stations.length - 1)) {
				pic = "./images/schnur_ende.png";
			}
			
			return "background-image: url('" + pic + "');";
		},
		// Berechnet, wieviele Sekunden es noch bis zur angegebenen Station sind
		"calculateRemainingTime": function(station) {
			var remainingPercent = station.location - this.api.percent;
			var remainingSeconds = remainingPercent / 100 * this.api.time_per_way;
			
			return remainingSeconds;
		}
	},
	"filters": {
		// Rundet eine Sekundenanzahl auf ganze Minuten
		"toMinutes": function(seconds) {
			return Math.round(seconds / 60, 0);
		},
		// Berechnet, um wieviel Grad der Zeiger bei der Geschwindigkeitsanzeige gedreht werden muss
		"rotate": function(speed) {
			var min = -135;
			var max = 135;
			var factor = speed / 120;
			var deg = min + factor * (max - min);
			
			return "transform: rotate(" + Math.round(deg) + "deg);";
		},
		// Berechnet, welche Farbe die Temperaturanzeige haben muss
		"temperatureColor": function(temperature) {
			var min = -20;
			var max = 40;
			var red = [77, 239];
			var green = [101, 58];
			var blue = [224, 44];
			var factor = (parseInt(temperature) + 20) / (max - min);
			
			var r = red[0] + factor * (red[1] - red[0]);
			var g = green[0] + factor * (green[1] - green[0]);
			var b = blue[0] + factor * (blue[1] - blue[0]);
			
			return "background-color: rgb(" + Math.round(r) + ", " + Math.round(g) + ", " + Math.round(b) + ");";
		},
		// Berechnet, wie stark gefüllt die Temperaturanzeige sein soll
		"temperatureHeight": function(temperature) {
			var min = -20;
			var max = 40;
			
			temperature = parseInt(temperature);
			temperature += 20;
			
			return "height: " + (1 - temperature / (max - min)) * 100 + "%;";
		}
	},
	// Wird beim Start von Vue ausgeführt und sorgt dafür, dass alle 2 Sekunden das interne JSON aktualisiert wird
	"mounted": function() {
		var vue = this;
		
		window.setInterval(function() {
			var vue2 = vue;
			
			$.ajax("./json.php", {
				"dataType": "json",
				"complete": function(response, status) {
					vue2.$data.api = response.responseJSON;
				}
			});
		}, 2000);
	}
});
