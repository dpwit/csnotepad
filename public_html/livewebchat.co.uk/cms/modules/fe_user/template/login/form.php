<?
/**
* @package Elite_Promo
*/

			if(!$user){
?>
				login<input type="text" id="loginbox" name="un"/>
				<input type="password" id="passwordbox" name="pw" /><input type="submit" id="loginSubmit" name="login" value='login' />
				<input type='hidden' name='return' value='<?=htmlspecialchars($_POST['return']?$_POST['return']:$_SERVER['REQUEST_URI'])?>'/>
<?
				$options = array('register.html'=>'register','forgot-password.html'=>'forgotten password?');
			} else {
				if($user->status>0){
					$name = "<a href='".$user->getUrl()."'>$user->realName</a>";
				} else {
					$name = $user->realName;
				}
?>
				<p>Logged In As <?=$name?></a></p>
<?
				$options = array(
					'logout.html'=>'Log Out',
					'dashboard.html'=>'Dashboard',
					'profile.html'=>'Profile',
				);

				switch($user->status) { 
					case 1:
						$options['topup.html'] = 'Top Up';
						break;
					case -1:
						$options['reactivate.html'] = 'Request Reactivation';
				}
			}

			foreach($options as $k=>$v){
				$options[$k] = sprintf("<a href='%1\$s'>%2\$s</a>",$k,$v);
			}
?>
			<div id="loginoptions"><?=join("&nbsp;|&nbsp;",$options)?></div>
			</form></div> <!-- end login  -->
<?
