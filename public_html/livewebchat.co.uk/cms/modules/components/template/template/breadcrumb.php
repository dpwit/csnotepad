<img src="/images/bc_01.png" alt="bc_l" class="bc" />
<div id="bcmiddle">
<?php 
/**
* @package Elite_Promo
*/
$links = array();
foreach($list as $k=>$v){
	if(is_object($v)){
		$k = $v->getUrl();
		$v = $v->getLabel();
	}
	if($k){
		$links[$k] = "<a class='breadcrumb' href='$k'>$v</a>";
	} else {
		$links[$k] = "<span class='breadcrumb'>$v</span>";

	}
}
$chevron = "<span class='chevron1'>" . $this->params['separator'] . "</span>";

echo join($chevron,$links);
?>
<div id='breadcrumb-search-fields' style='display:none;'>
	<input type='hidden' name='from' value='<?=$_REQUEST['from']?$_REQUEST['from']:$_SERVER['REQUEST_URI']?>'/>
</div>
</div>
<img src="/images/bc_03.png" alt="bc_r" class="bc" />
