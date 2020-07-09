<?
/**
* @package Elite_Promo
*/

	class PromoAdminUser extends AdminUser {
		function maxHexLength(){
			return 8;
		}
		function getHexData(){
			return substr(str_pad(base_convert($this->id.'-'.$this->userid,36,16),8,'0',STR_PAD_LEFT),0,$this->maxHexLength());
		}
	}
?>
