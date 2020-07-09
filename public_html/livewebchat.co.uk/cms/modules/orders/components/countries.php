<?
require(dirname(__FILE__).'/../data/countries.php');
foreach($countries_detail as $country){
	$countries[$country[1]]=$country[4];
	$continents[$country[1]]=$country[0];
}
