<?
	class FugaManualCorrections extends Controller {

		function cms_newLabel($params){
			$label = Model::loadModel('Label')->get($params['cms_uid']);
			$this->showView('map_item',array(
				'item'=>$label,
				'listings'=>array('releases'),
			));
		}
		function cms_newArtist($params){
			$artist = Model::loadModel('Artist')->get($params['cms_uid']);
			$this->showView('map_item',array(
				'item'=>$artist,
				'listings'=>array('releases','tracks'),
			));
		}

		function cms_remapArtist($params){
			$artistF = Model::loadModel('Artist');
			$old = $artistF->get($params['from']);
			$new = $artistF->get($params['to']);

			Model::loadModel('Fuga_Manual_Corrections')->createNew(array(
				'type'=>'artist',
				'import_key'=>$old->name,
				'db_key'=>$new->name
			))->writeToDB();

			$funcs = array('releases','tracks');
			foreach($funcs as $func)
			foreach($old->$func() as $release){
				$artists = array();
				foreach($release->artists() as $k=>$v){
					if($v->getId()==$old->getId()){
						$artists[] = $new;
					} else {
						$artists[] = $v;
					}
				}
				$release->artists = $artists;
				$release->writeToDB();
			}
			$this->showView('map_item_confirmation',array('old'=>$old,'new'=>$new));
			$old->delete();
		}
		function cms_remapLabel($params){
			$labelF = Model::loadModel('Label');
			$old = $labelF->get($params['from']);
			$new = $labelF->get($params['to']);

			Model::loadModel('Fuga_Manual_Corrections')->createNew(array(
				'type'=>'label',
				'import_key'=>$old->getLabel(),
				'db_key'=>$new->getLabel(),
			))->writeToDB();

			$funcs = array('releases');
			foreach($funcs as $func)
			foreach($old->$func() as $release){
				$release->label_uid=$new->getId();
				$release->writeToDB();
			}
			$this->showView('map_item_confirmation',array('old'=>$old,'new'=>$new));
			$old->delete();
		}
	}
?>
