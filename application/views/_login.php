<form method="post">
     <label for="username">Username:</label>
     <input type="text" size="20" name="username"/>
     <br/>
     <label for="password">Password:</label>
     <input type="text" size="20" name="password"/>
     <br/>
     <button name="login" onclick="this.form.submit()">User Login</button>
     <!-- WHU Apr 14, 2016-->
     <a href="registerView.php" name="registerlink">User Registration</a>
     {registerlink}
     {/registerlink}
   </form>