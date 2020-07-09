<?
$fields = $model->getForm($model);
?>
<div id="shop">
<div class="form_main">
    <div id="contentRegister">
        <h3 class="headerText">Create a user</h3>
        <form method='post'>
            <? foreach($fields as $field) {
                ?>
            <div class='form_row <?=$field['field']->param('css_class')?> <?=$field['field']->getName()?> <?= $field['errors'] ? "formsubmit_error" : "ok"?>'>
                    <?php if(!@in_array($field['name'],$suppressLabel)) { ?>
                <label>
                            <?=$field['label']?>
                </label>
                        <? } ?>
                <div class='form_input'>
                        <?=$field['html']?>
                </div>
                    <? if($field['errors']) { ?>
                <div class='form_error'>
                            <?=$field['errors']?>
                </div>
                        <? } ?>
                    <? if($field['notes']) { ?>
                <div class='form_notes'>
                            <?=$field['notes']?>
                </div>
                        <? } ?>
                <div class='form_row_footer'></div>
            </div>
                <? } /* end foreach */ ?>
                <input type='submit' class="coolButton" value='Register' name='register'/>
                <input type='hidden' name='no-redirect' value='true'/>
                <?=@$hidden?></div>
        </form>
        <?
        //include(__MODELS_BASE__.'/boz/views/default/form.php');
        ?>
    </div> <!-- end register -->
    <div id="contentLogin">
        <h3 class="headerText">Or login</h3>
        <?
        if($reason = @$_GET['failure_reason']) {
            
            ?>
        <div class='error'>
                <?	switch($reason) { 
                    case 'not_matched': default:
                        ?>
            <p>Your login details have not been recognised.  Please try again.</p>
                    <? 	} ?>
    
        </div>
            <?
        }
        ?>
        <form method='post'>
            <label>User Name</label>
			<div class="form_input"><input type='text' name='un'/></div>
            <label>Password</label>
			<div class="form_input"><input type='password' name='pw'/></div>
                <input type='submit' class="coolButton" value='Login' name='login'/>
                <input type='hidden' name='no-redirect' value='true'/>
        </form>
        <a href='/forgot-password.html'>Forgot Password?</a>
    </div> <!-- end login -->

</div> <!-- end form_main -->
<!--</div>-->