<?
	require_once(dirname(__FILE__).'/../cli-env.php');

	foreach(Model::listModels() as $model){
		$inst = Model::loadModel($model);

		try {
			$q = $inst->getAll(array(),array('for_fetch'=>1,'show_deleted'=>1));
			while($r = $q->fetch()){
				$found = false;
				foreach($r->relationships as $k=>$v){
					$m = @$r->manager($k);
					if($m instanceof BasicFileManager){
						$m->params['id-only'] = true;
						$old = $r->$k('original',array('as_url'=>false));
						$m->params['id-only'] = false;
						$new = $r->$k('original',array('as_url'=>false));
						if(file_exists($old)){
							copy($old,$for_import = dirname(__FILE__).'/tmp/'.$r->$k);
							$r->$k = $for_import;
							$r->writeToDB();
						}
						$found=true;
					}
				}
				$r->__destroy();
				if(!$found) break;
			}
		} catch(Exception $e){
			echo "Skipping $model\n";
		}
	}
?>
