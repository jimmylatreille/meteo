<?php

class Meteo {
	
	public $temp;

	public function __construct(){
		
		$geo = json_decode(file_get_contents("http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}"));
		$yahoo   = simplexml_load_file("http://query.yahooapis.com/v1/public/yql?q=select * from geo.places where text='Place {$geo->city}'&format=xml");
		$weather = simplexml_load_file("http://weather.yahooapis.com/forecastrss?w={$yahoo->results->place->woeid}&u=c");
		preg_match('/\w*\,\s{1}\d{2}\s{1}/', (string)$weather->channel->item->description, $match, PREG_OFFSET_CAPTURE);
		$this->temp = explode(",", $geo->city.','.strtolower(preg_replace('/\s/', '', $match[0][0])));
	}

	/**
	 * Commentaire
	 * @param  $valeur $val [description]
	 * @return [type]      [description]
	 */
	public function icon($val){

		$val = strtolower($val);
		$time = (int) date("H");

		$icon = array(
			'mixedsnowandsleet'  		=> array('wi-day-snow', 'wi-night-alt-snow'),
			'freezingdrizzle'  	        => array('wi-day-hail', 'wi-night-alt-hail'),
			'drizzle'  			=> array('wi-day-hail', 'wi-night-alt-hail'),
			'freezingrain'  		=> array('wi-day-hail', 'wi-night-alt-hail'),
			'showers'  			=> array('wi-day-showers', 'wi-night-alt-showers'),
			'snowflurries'  		=> array('wi-day-snow', 'wi-night-alt-snow'),
			'lightsnowshowers'  		=> array('wi-day-snow', 'wi-night-alt-snow'),
			'blowingsnow'  			=> array('wi-day-snow', 'wi-night-alt-snow'),
			'snow'  			=> array('wi-day-snow', 'wi-night-alt-snow'),
			'hail'  			=> array('wi-day-hail', 'wi-night-alt-hail'),
			'sleet'  			=> array('wi-day-hail', 'wi-night-alt-hail'),
			'blustery'  			=> array('wi-day-cloudy-gusts', 'wi-night-alt-cloudy-gusts'),
			'windy'  			=> array('wi-day-cloudy-gusts', 'wi-night-alt-cloudy-gusts'),
			'cloudy'  			=> array('wi-day-cloudy', 'wi-night-alt-cloudy-windy'),
			'mixedrainandhail'  		=> array('wi-day-hail', 'wi-night-alt-hail'),
			'isolatedthunderstorms'  	=> array('wi-day-thunderstorm', 'wi-night-alt-thunderstorm'),
			'scatteredthunderstorms'  	=> array('wi-day-thunderstorm', 'wi-night-alt-thunderstorm'),
			'scatteredshowers'  		=> array('wi-day-showers', 'wi-night-alt-showers'),
			'heavysnow'  			=> array('wi-day-snow', 'wi-night-alt-snow'),
			'scatteredsnowshowers'  	=> array('wi-day-snow', 'wi-night-alt-snow'),
			'thundershowers'  		=> array('wi-day-storm-showers', 'wi-night-alt-storm-showers'),
			'isolatedthundershowers'  	=> array('wi-day-thunderstorm', 'wi-night-alt-thunderstorm'),
			'mostlycloudy' 	                => array('wi-day-cloudy', 'wi-night-alt-cloudy-windy'),
			'partlycloudy'      		=> array('wi-day-cloudy', 'wi-night-alt-cloudy-windy'),
			'clear'             		=> array('wi-day-sunny', 'wi-night-clear'),
			'fair'              		=> array('wi-day-sunny', 'wi-night-clear'),
			'sunny'             		=> array('wi-day-sunny', 'wi-night-clear'),
			'tornado' 			=> array('wi-tornado', 'wi-tornado'),
			'tropicalstorm'  		=> array('wi-thunderstorm', 'wi-thunderstorm'),
			'hurricane'  			=> array('wi-hurricane', 'wi-hurricane'),
			'severethunderstorms'  		=> array('wi-thunderstorm', 'wi-thunderstorm'),
			'thunderstorms'  		=> array('wi-lightning', 'wi-lightning'),
			'mixedrainandsnow'  		=> array('wi-rain-mix', 'wi-rain-mix'),
			'mixedrainandsleet'  		=> array('wi-rain-mix', 'wi-rain-mix'),
			'dust'  			=> array('wi-dust', 'wi-dust'),
			'foggy'  			=> array('wi-dust', 'wi-dust'),
			'haze'  			=> array('wi-dust', 'wi-dust'),
			'smoky'  			=> array('wi-cloudy', 'wi-cloudy'),
			'hot'  				=> array('wi-hot', 'wi-hot'),
			'snowshowers'  		        => array('wi-snow', 'wi-snow'),
			'cold'  			=> array('wi-thermometer-exterior', 'wi-thermometer-exterior'),
			'notavailable'  		=> array('wi-thermometer-exterior', 'wfi-thermometer-exterior'),
		);

		$seasonTime = $this->season();

		if($time <= $seasonTime[0] || $time >= $seasonTime[1]){
			$weather = $icon[$val][1];
		}else {
			$weather = $icon[$val][0];
		}

		return $weather;
	}

	public function season(){

		$day = array(
			1 => array(6.7, 17.5),
			2 => array(6.4, 18),
			3 => array(6.1, 18.5),
			4 => array(5.8, 19),
			5 => array(5.5, 19.5),
			6 => array(5, 20),
			7 => array(6.7, 19.5),
			8 => array(5.5, 19),
			9 => array(5.8, 18.5),
			10 => array(6.1, 18),
			11 => array(6.7, 17.5),
			12 => array(7, 17)
		);

		return $day[date('n')];
	}
}

$meteo = new Meteo();
