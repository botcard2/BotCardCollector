<?php

/* 
 * Purpose: view for registering players
 * 
 * Date        Name           Change 
 * ---------------------------------
 * 14-Apr-2016 William Hu     Inital
 */

?>

<div class="col-lg-4 col-lg-offset-4">
<h2>Hello There</h2>
<h5>Please enter the required information below.</h5> 
<div>
    <form method="post">
     <label for="usernameRegister">Username:</label>
     <input type="text" size="20" name="usernameRegister"/>
     <br/>
     <label for="passwordRegister">Password:</label>
     <input type="text" size="20" name="passwordRegister"/>
    <label for="passwordRetype">Password Confirm:</label>
     <input type="text" size="20" name="passwordRetype"/>
    <button name="userRegister"  value="userRegister" onclick="this.form.submit()">Create user</button>
    </form>
</div>

