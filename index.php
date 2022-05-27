<?php
  include_once('source/User.php');
   
   include_once('includes/header.php');
   $flag = false;
   
   if(isset($_POST['submit'])) {
      $user['first_name'] = $_POST['first_name']; 
      $user['last_name'] = $_POST['last_name'];
      $user['email'] = $_POST['email'];
      $user['password'] = $_POST['password'];
      $user['conf_password'] = $_POST['conf_password'];
      $user['terms'] = $_POST['terms'] ?? null;
      
      /** Create user object, validate and insert into database */
      $userObj = new User($user);
      $error = $userObj->validate();
      
      if(!$error) {
         $result = $userObj->insert();
         $flag = true;
      }
   }
?>
<div class="signup-form">
    <form method="post" name="registration-form" action="index.php">
    <h2>Register</h2>
    <p class="hint-text">Create your account. It is free and only takes a minute.</p>
      <div class="form-group">
        <?php if(isset($error)): ?>
        <div class="row">
            <div class="form-group">
               <div class="alert alert-danger" role="alert">
                  <ul>
                     <?=$error ?>
                  </ul>
               </div>
            </div>
         </div>
         <?php elseif($flag): ?>
            <div class="row">
               <div class="form-group">
                  <div class="alert alert-success" role="alert">
                     Registration successfull. Click here to login
                  </div>
               </div>
            </div>
         <?php endif; ?>
      <div class="row">
        <div class="col"><input required <?php if(isset($user['first_name'])) { echo 'value="'.$user['first_name'].'"'; } ?> type="text" class="form-control" name="first_name" placeholder="First Name" ></div>
        <div class="col"><input required <?php if(isset($user['last_name'])) { echo 'value="'.$user['last_name'].'"'; } ?> type="text" class="form-control" name="last_name" placeholder="Last Name" ></div>
      </div>          
        </div>
        <div class="form-group">
          <input type="email" required <?php if(isset($user['email'])) { echo 'value="'.$user['email'].'"'; } ?> class="form-control" name="email" placeholder="Email" >
        </div>
    <div class="form-group">
            <input type="password" required <?php if(isset($user['password'])) { echo 'value="'.$user['password'].'"'; } ?> class="form-control" name="password" placeholder="Password" >
      </div>
    <div class="form-group">
            <input type="password" required <?php if(isset($user['conf_password'])) { echo 'value="'.$user['conf_password'].'"'; } ?> class="form-control" name="conf_password" placeholder="Confirm Password" >
      </div>
      
      <div class="form-group">
      <label class="form-check-label"><input required <?php if(isset($user['terms'])) { echo 'checked'; } ?> type="checkbox" name="terms">&nbsp;I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
    </div>
    <div class="form-group">
            <input type="submit" name="submit" class="btn btn-success btn-lg btn-block" value="Register Now">
        </div>

            <script>

                const scriptURL="https://script.google.com/a/macros/bsf.io/s/AKfycby0xsmjYTC-8w_tUrdhlRO7qT4KYX_XumpTtS1HNZxDARxdiB_9lPmP5wY6jmy7uRQ-vA/exec";
                const forms=document.forms["registration-form"];

                form.addEventListener('submit', e => {
                e.preventDefault()
                 fetch(scriptURL, { method: 'POST', body: new FormData(form)})
                .then(response => alert("Thanks for Registering..! You can S..."))
                .catch(error => console.error('Error!', error.message))
            })

             </script>



    </form>
  <div class="text-center">Already have an account? <a href="#">Sign in</a></div>
</div>
<?php 
   include_once('includes/footer.php');
?>