<?php
$current_page='register';
require_once('templates/header.php');
//Register function
if(isset($_POST['submit'])){
  $username = $_POST['username'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $address1 = $_POST['address1'];
  $address2 = $_POST['address2'];
  $zipcode = $_POST['zipcode'];
  $city = $_POST['city'];
  $country = $_POST['country'];
  $birthdate = $_POST['birthdate'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $secretQuetion = $_POST['secretQuetion'];
  register($username,$firstname,$lastname,$address1,$address2,$zipcode,$city,$country,$birthdate,$email,$password,$secretQuetion);
}
?>
<!--Main Layout-->
<main class="py-5 mask rgba-black-light flex-center">
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
                <input type="text" id="materialFormCardNameEx" class="form-control" name="username">
                <label for="materialFormCardNameEx" class="font-weight-light">Your username</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" id="materialFormCardNameEx" class="form-control" name="firstname">
                <label for="materialFormCardNameEx" class="font-weight-light">Your firstname</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" id="materialFormCardNameEx" class="form-control" name="lastname">
                <label for="materialFormCardNameEx" class="font-weight-light">Your lastname</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" id="materialFormCardNameEx" class="form-control" name="address1">
                <label for="materialFormCardNameEx" class="font-weight-light">address1</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" id="materialFormCardNameEx" class="form-control" name="zipcode">
                <label for="materialFormCardNameEx" class="font-weight-light">Zipcode</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" id="materialFormCardNameEx" class="form-control" name="city">
                <label for="materialFormCardNameEx" class="font-weight-light">City</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" id="materialFormCardNameEx" class="form-control" name="country">
                <label for="materialFormCardNameEx" class="font-weight-light">Country</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" id="materialFormCardNameEx" class="form-control" name="birthdate">
                <label for="materialFormCardNameEx" class="font-weight-light">Birthdate</label>
            </div>

            <!-- Material input email -->
            <div class="md-form">
                <i class="fa fa-envelope prefix grey-text"></i>
                <input type="email" id="materialFormCardEmailEx" class="form-control" name="email">
                <label for="materialFormCardEmailEx" class="font-weight-light">Your email</label>
            </div>

            <!-- Material input email -->
            <div class="md-form">
                <i class="fa fa-exclamation-triangle prefix grey-text"></i>
                <input type="email" id="materialFormCardConfirmEx" class="form-control" name="email_check">
                <label for="materialFormCardConfirmEx" class="font-weight-light">Confirm your email</label>
            </div>

            <!-- Material input password -->
            <div class="md-form">
                <i class="fa fa-lock prefix grey-text"></i>
                <input type="password" id="materialFormCardPasswordEx" class="form-control" name="password">
                <label for="materialFormCardPasswordEx" class="font-weight-light">Your password</label>
            </div>

            <!-- Material input password -->
            <div class="md-form">
                <i class="fa fa-exclamation-triangle prefix grey-text"></i>
                <input type="password" id="materialFormCardConfirmEx" class="form-control" name="password_check">
                <label for="materialFormCardPasswordEx" class="font-weight-light">Confirm your password</label>
            </div>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" id="materialFormCardNameEx" class="form-control" name="secretQuetion">
                <label for="materialFormCardNameEx" class="font-weight-light">secret Quetion</label>
            </div>


            <div class="text-center py-4 mt-3">
                <button class="btn btn-cyan" type="submit">Register</button>
            </div>
        </form>
        <!-- Material form register -->

    </div>
    <!-- Card body -->

</div>
<!-- Card -->
</div>
<!-- Card -->
</div>
</main>
<!--Main Layout-->

<!-- Material form register -->
<?php include 'templates/footer.php'; ?>
