<?
/**
* @package Model_System
*/

session_start();
$oldId = $_SESSION['id'];
require_once(dirname(__FILE__).'/../../../requiredConnections.php');
cms_no_template();
?>
<div class='mm-tree' >
<?
	$rel = $_GET['rel'];
	$id = $_GET['id'];
	list($parent,$child) = explode("/",$rel);
	$model = Model::loadModel(Model::unpluralize($parent));
	$model->getAll(array(),array('for_fetch'=>1));
	while($category = $model->fetch()){
		if($child){
			echo "<div class='item'><div class='item-title'>{$category->getLabel()}</div>
				<div class='children'>";
			foreach($category->$child() as $package){
				echo "<div class='child'><a class='package-selector close' id='package-{$package->getID()}-{$package->getLabel()}'>{$package->getLabel()}</a></div>";	
			}
			echo "</div></div>";
		} else {
			echo "<div class='child'><a class='category-selector close' id='category-{$category->getID()}-{$category->getLabel()}'>{$category->getLabel()}</a></div>";	
		}
	}
$_SESSION['id'] = $oldId;
?>
</div>
<?
	require_once(dirname(__FILE__).'/../../../footer.php');
?>
