<?
/**
* @package BozBoz_CMS
*/

	class Skint_TempHooks {
		function __construct(){
			cms_listen_action('components_loaded',$this);
		}
		function components_loaded(){
			Component::mapClass('NewsHome',dirname(__FILE__).'/components/NewsHome.php');
			Component::mapClass('LatestMerchandise',dirname(__FILE__).'/components/LatestMerchandise.php');
			Component::mapClass('UpcomingDates',dirname(__FILE__).'/components/UpcomingDates.php');
			Component::mapClass('Signup',dirname(__FILE__).'/components/Signup.php');
			Component::mapClass('Competition',dirname(__FILE__).'/components/Competition.php');
			Component::mapClass('SkintTop10',dirname(__FILE__).'/components/SkintTop10.php');
			Component::mapClass('Featured',dirname(__FILE__).'/components/Featured.php');
			Component::mapClass('ArtistGallery',dirname(__FILE__).'/components/ArtistGallery.php');
			Component::mapClass('Releases',dirname(__FILE__).'/components/Releases.php');
		}
	}
	new Skint_TempHooks();
