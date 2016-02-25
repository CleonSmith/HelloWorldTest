<?PHP
require_once("databaseutility.php");
require_once("./include/us-state-names-abbrevs.php");

$databaseutility = new DatabaseUtility();

if(isset($_POST['submitted']))
{
   if($databaseutility->RegisterUser())
   {
        $databaseutility->RedirectToURL("submitcomplete.html");
   }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US">
<head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
    <title>Contact us</title>
    <link rel="STYLESHEET" type="text/css" href="style/helloworldtest.css" />
    <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>     
</head>
<body>

<!-- Form Code Start -->
<div id='helloworldtest'>
<form id='register' action='<?php echo $databaseutility->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>Register User</legend>

<input type='hidden' name='submitted' id='submitted' value='1'/>

<div class='short_explanation'>* required fields</div>

<div><span class='error'><?php echo $databaseutility->GetErrorMessage(); ?></span></div>
<div class='container'>
    <label for='name' >First Name*: </label><br/>
    <input type='text' name='firstname' id='firstname' value='<?php echo $databaseutility->SafeDisplay('firstname') ?>' maxlength="32" /><br/>
    <span id='register_name_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='name' >Last Name*: </label><br/>
    <input type='text' name='lastname' id='lastname' value='<?php echo $databaseutility->SafeDisplay('lastname') ?>' maxlength="32" /><br/>
    <span id='register_name_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='name' >Address1*: </label><br/>
    <input type='text' name='address1' id='address1' value='<?php echo $databaseutility->SafeDisplay('address1') ?>' maxlength="64" /><br/>
    <span id='register_name_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='name' >Address2: </label><br/>
    <input type='text' name='address2' id='address2' value='<?php echo $databaseutility->SafeDisplay('address2') ?>' maxlength="64" /><br/>
    <span id='register_name_errorloc' class='error'></span>
</div>
<div class='container'>
    <label for='name' >City*: </label><br/>
    <input type='text' name='city' id='city' value='<?php echo $databaseutility->SafeDisplay('city') ?>' maxlength="64" /><br/>
    <span id='register_name_errorloc' class='error'></span>
</div>
<div class='container'>
	<label for='name'>State*: </label><br/>
	<select name='state'>
		<option value=""></option>
		<?php 
		foreach($us_state_abbrevs as $state):
			echo '<option value="'.$state.'">'.$state.'</option>';
		endforeach;	
		?>
	</select>
</div>
<div class='container'>
    <label for='name' >Zip*: </label><br/>
    <input type='text' name='zip' id='zip' value='<?php echo $databaseutility->SafeDisplay('zip') ?>' maxlength="9" /><br/>
    <span id='register_name_errorloc' class='error'></span>
</div>
<div class='container'>
	<label for='name'>Country*: </label><br/>
	<select name='country'>
	<option value="US">US</option>	
	</select>
</div>

<div class='container'>
    <input type='submit' name='Submit' value='Submit' />
</div>

</fieldset>
</form>
<!-- client-side Form Validations:
Uses the excellent form validation script from JavaScript-coder.com-->

<script type='text/javascript'>
// <![CDATA[
    
    var frmvalidator  = new Validator("register");
    frmvalidator.EnableOnPageErrorDisplay();
    frmvalidator.EnableMsgsTogether();

	//Validation
	frmvalidator.addValidation("firstname","req","Please input your first name");
	frmvalidator.addValidation("lastname","req","Please input your last name");
	frmvalidator.addValidation("address1","req","Please input your address");
	frmvalidator.addValidation("city","req","Please input your city");
	frmvalidator.addValidation("state", "req", "Please select your state");
	frmvalidator.addValidation("country", "req", "Please select your state");
// ]]>
</script>

<!--
Form Code End (see html-form-guide.com for more info.)
-->

</body>
</html>