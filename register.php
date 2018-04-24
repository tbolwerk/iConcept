<?php
$current_page='register';
require_once('templates/header.php');
//Register function
if(isset($_POST['submit'])){

  register($_POST['username'],$_POST['firstname'],$_POST['lastname'],$_POST['address1'],$_POST['address2'],$_POST['zipcode'],$_POST['city'],$_POST['country'],$_POST['birthdate'],$_POST['email'],$_POST['email_check'],$_POST['password'],$_POST['password_check'],$_POST['secretAnswer']);
}
?>
<!--Main Layout-->
<main class="py-5 mask rgba-black-light">
  <div class="bg"></div>
<!-- Card -->
<div class="container col-md-4">


<!-- Card -->
<div class="card">

    <!-- Card body -->
    <div class="card-body">

        <!-- Material form register -->
        <form action="" method="post">
            <p class="h4 text-center py-4">Sign up</p>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" class="form-control" name="username">
                <label for="materialFormCardNameEx" class="font-weight-light">Your username</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" class="form-control" name="firstname">
                <label for="materialFormCardNameEx" class="font-weight-light">Your firstname</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text"  class="form-control" name="lastname">
                <label for="materialFormCardNameEx" class="font-weight-light">Your lastname</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" class="form-control" name="address1">
                <label for="materialFormCardNameEx" class="font-weight-light">address1</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" class="form-control" name="address2">
                <label for="materialFormCardNameEx" class="font-weight-light">address2</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" class="form-control" name="zipcode">
                <label for="materialFormCardNameEx" class="font-weight-light">Zipcode</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" class="form-control" name="city">
                <label for="materialFormCardNameEx" class="font-weight-light">City</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" class="form-control" name="country">
                <label for="materialFormCardNameEx" class="font-weight-light">Country</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" class="form-control" name="birthdate">
                <label for="materialFormCardNameEx" class="font-weight-light">Birthdate</label>
            </div>

            <!-- Material input email -->
            <div class="md-form">
                <i class="fa fa-envelope prefix grey-text"></i>
                <input type="email" class="form-control" name="email">
                <label for="materialFormCardEmailEx" class="font-weight-light">Your email</label>
            </div>

            <!-- Material input email -->
            <div class="md-form">
                <i class="fa fa-exclamation-triangle prefix grey-text"></i>
                <input type="email" class="form-control" name="email_check">
                <label for="materialFormCardConfirmEx" class="font-weight-light">Confirm your email</label>
            </div>

            <!-- Material input password -->
            <div class="md-form">
                <i class="fa fa-lock prefix grey-text"></i>
                <input type="password" class="form-control" name="password">
                <label for="materialFormCardPasswordEx" class="font-weight-light">Your password</label>
            </div>

            <!-- Material input password -->
            <div class="md-form">
                <i class="fa fa-exclamation-triangle prefix grey-text"></i>
                <input type="password" class="form-control" name="password_check">
                <label for="materialFormCardPasswordEx" class="font-weight-light">Confirm your password</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" class="form-control" name="secretAnswer">
                <label for="materialFormCardNameEx" class="font-weight-light">secret Answer</label>
            </div>


            <div class="text-center py-4 mt-3">
                <button class="btn btn-cyan" type="submit" name="submit">Register</button>
            </div>
        </form>
        <!-- Material form register -->
<?php
if(isset($error)){
echo "<p class='bq-danger'>" . $error . "</p>";
}
 ?>
    </div>
    <!-- Card body -->

</div>
<!-- Card -->
</div>
<!-- Card -->

</main>
<!--Main Layout-->

<!-- Material form register -->
<?php include 'templates/footer.php'; ?>
