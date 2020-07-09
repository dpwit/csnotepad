<?
	class FugaHooks {
		function __construct(){
			cms_listen_action('models_loaded',$this);
			cms_listen_action('controllers_loaded',$this);
			cms_register_filter('get_cron_jobs',$this);
			cms_register_filter('config_defaults',$this);
			cms_listen_action('fuga_artist_created',$this);
			cms_listen_action('fuga_label_created',$this);
			cms_listen_action('fuga_track_created',$this);
			cms_listen_action('fuga_album_created',$this);
			cms_register_filter('fuga_mapping',$this);
			cms_register_filter('cms_notification_source',$this);
		}
		function cms_notification_source($text){
			if($text=='Fuga') return "<img src='http://a1.twimg.com/profile_images/435486344/Picture_2_bigger.png' alt='Fuga' height='30px'/>";
			return $text;
		}
		function config_defaults($config){
			$config['fuga'] = array(
				'do_import'=>1,
				'auto_publish_artists'=>0,
				'auto_publish_releases'=>1,
//				'do_export'=>0,
				'drop_directory'=>'www/fuga',
				'default_track_price'=>'1.99',
				'default_album_price'=>'9.99',
				'default_ep_price'=>'6.99',
				'default_single_price'=>'4.99',
				'default_category'=>'Fuga Imports',
				'use_suggested_preview_start'=>1,
				'use_suggested_preview_length'=>1,
				'default_preview_length'=>60,
			);
			return $config;
		}
		function get_cron_jobs($jobs){
			if(Config::value('do_import','fuga')){
				require_once(dirname(__FILE__).'/cron/class.FugaImporter.php');
				$jobs[] = new FugaImporter(dirname(dirname(BASEPATH)).'/'.Config::value('drop_directory','fuga'));
			}
			return $jobs;
		}

		function models_loaded(){
			Model::addModel('Fuga_Manual_Correction',false,'BozModel');
			Model::addModel('Fuga_Import',dirname(__FILE__).'/models/class.Fuga_Import.php');
		}
		function controllers_loaded(){
			Controller::addController('FugaManualCorrections',dirname(__FILE__).'/controllers/class.FugaManualCorrections.php');
		}

		function fuga_artist_created($artist,$artist_name){
			$controller = Controller::getInstance('FugaManualCorrections');
			$notification = Model::loadModel('CMSNotification')->createNew(array(
				'source'=>'fuga',
				'url'=>$controller->urlFor('newArtist',array('cms_uid'=>$artist->getId())),
				'summary'=>"New Artist '$artist_name' created by the fuga import process",
				'message'=>"New Artist '$artist_name' created by the fuga import process",
			));
			$notification->writeToDB();
		}
		function fuga_label_created($artist,$artist_name){
			$controller = Controller::getInstance('FugaManualCorrections');
			$notification = Model::loadModel('CMSNotification')->createNew(array(
				'source'=>'fuga',
				'url'=>$controller->urlFor('newLabel',array('cms_uid'=>$artist->getId())),
				'summary'=>"New Label '$artist_name' created by the fuga import process",
				'message'=>"New Label '$artist_name' created by the fuga import process",
			));
			$notification->writeToDB();
		}

		function fuga_mapping($artist,$type){
			if($correction = Model::loadModel('Fuga_Manual_Correction')->getFirst(array('type'=>$type,'import_key'=>$artist))){
				$artist = $correction->db_key;
			}
			return $artist;
		}

		function fuga_track_created($track){
			if(!$track->exists()) $track->price = Config::value('default_track_price','fuga');
			echo "Created $track->name $track->price ".Config::value('default_track_price')."\n";
		}

		function fuga_album_created($album,$xml,$xml_file){
			if(!$album->exists()) {
					$album->price = Config::value('default_'.strtolower($album->release->product_format_type).'_price','fuga');
					$notification = Model::loadModel('CMSNotification')->createNew(array(
						'source'=>'fuga',
						'url'=>$album->urlFor('editItem',array('cms_uid'=>$album->getId())),
						'summary'=>"New Release '$album->name' created by the fuga import process",
						'message'=>"New Release '$album->name' created by the fuga import process",
					));
			}
			echo "Created $album->name $album->price\n";
		}

	}
	new FugaHooks;
?>
