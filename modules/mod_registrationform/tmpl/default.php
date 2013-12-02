<meta charset="utf-8">
<?php
// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );
?>

<?php //include file
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base() . 'modules/mod_registrationform/tmpl/css/style.css');
?>

<div class="form-1"> 
	<h4>Register Form</h4><hr>
<form id="member-registration"
		action="/photo_checkin/index.php/register?task=registration.register"
		method="post" class="form-validate" enctype="multipart/form-data">
		<fieldset>

<span class="spacer"><span class="before"></span><span class="text"><label
							id="jform_spacer-lbl" class=""></span><span class="after"></span>
</span>

<table width="auto" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="145">&nbsp;</td>
    <td width="auto">&nbsp;</td>
  </tr>
  
  <tr>
    <td>
    	<label class="textfont" id="jform_name-lbl" for="jform_name" class="hasTip required"
						title="">Name:<span class="star">&nbsp;*</span></label>
    </td>
    <td>
    	<input class="thaifont" type="text" placeholder="ÀÀÀÀ" name="jform[name]" id="jform_name" value=""
						class="required" size="30" aria-required="true"
						required="required">
    </td>
  </tr>
  
  <tr>
    <td>
    	<label class="textfont" id="jform_username-lbl" for="jform_username"
						class="hasTip required" title="">Username:<span class="star">&nbsp;*</span></label>
    </td>
    <td>
    	<input type="text" name="jform[username]" id="jform_username"
						value="" class="validate-username required" size="30"
						aria-required="true" required="required">
    </td>
  </tr>
  
  <tr>
    <td>
    	<label class="textfont" id="jform_password1-lbl" for="jform_password1"
						class="hasTip required" title="">Password:<span class="star">&nbsp;*</span></label>
    </td>
    <td>
    	<input type="password" name="jform[password1]" id="jform_password1"
						value="" autocomplete="off" class="validate-password required"
						size="30" aria-required="true" required="required">
    </td>
  </tr>

   <tr>
    <td>
    	<label class="textfont" id="jform_password2-lbl" for="jform_password2"
						class="hasTip required" title="">Confirm Password:<span
						class="star">&nbsp;</span></label>
    </td>
    <td>
    	<input type="password" name="jform[password2]" id="jform_password2"
						value="" autocomplete="off" class="validate-password required"
						size="30" aria-required="true" required="required">
    </td>
  </tr>
  
  <tr>
    <td>
    	<label class="textfont" id="jform_email1-lbl" for="jform_email1"
						class="hasTip required" title="">Email Address:<span class="star">&nbsp;*</span></label>
    </td>
    <td>
    	<input type="email" placeholder="example@gmail.com" name="jform[email1]"
						class="validate-email required" id="jform_email1" value=""
						size="50" aria-required="true" required="required">
    </td>
  </tr> 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  </tr> 
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
  
    <td align="right">&nbsp;</td>
    <td align="right"> <button type="submit" class="validate">Register</button> </td>
  </tr>
</table>
</fieldset>
	<input type="hidden" name="option" value="com_users"> 
	<input type="hidden" name="task" value="registration.register"> 
	<input type="hidden" name="e9c70a32d12431f9d0a3e250a075f659" value="1">
		</div>
	</form>
</div>





