<?
$fields = $model->getForm($model);
?>
<div class="form_main">
    <div id="contentRegister">
        <h2 class="headerText">Create a user</h2>
        <form method='post'>
            <? foreach($fields as $field) {
                ?>
            <div class='form_row <?=$field['field']->param('css_class')?> <?=$field['field']->getName()?> <?= $field['errors'] ? "formsubmit_error" : "ok"?>'>
                    <?php if(!@in_array($field['name'],$suppressLabel)) { ?>
                <div class='form_label'>
                            <?=$field['label']?>
                </div>
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
            <div class="form_footer">
                <input type='submit' value='Register' name='register'/>
                <input type='hidden' name='no-redirect' value='true'/>
                <?=@$hidden?></div>
        </form>
        <?
        //include(__MODELS_BASE__.'/boz/views/default/form.php');
        ?>
    </div> <!-- end register -->
    <div id="contentLogin">
        <h2 class="headerText">Or login</h2>
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
            <div class="form_label">User Name</div> <div class="form_input"><input type='text' name='un'/></div>
            <div class="form_label">Password</div>  <div class="form_input"><input type='password' name='pw'/></div>
            <div class="form_footer">
                <input type='submit' value='Login' name='login'/>
                <input type='hidden' name='no-redirect' value='true'/>
        </form>
        <a href='/forgot-password.html'>Forgot Password?</a>
    </div> <!-- end login -->

</div> <!-- end form_main -->
</div>