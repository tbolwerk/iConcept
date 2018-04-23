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
  $questionNumber = $_POST['questionNumber'];
  $replyText = $_POST['replyText'];
  $seller = $_POST['seller'];
  register($username,$firstname,$lastname,$address1,$address2,$zipcode,$city,$country,$birthdate,$email,$password,$questionNumber,$replyText,$seller);
}
?>


<!-- Material form register -->
<form action="" method="post">
    <p class="h4 text-center mb-4">Sign up</p>

    <!-- Material input text -->
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="materialFormRegisterUserNameEx" class="form-control" name="username">
        <label for="materialFormRegisterUserNameEx">Your username</label>
    </div>

    <!-- Material input text -->
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="materialFormRegisterFirstNameEx" class="form-control" name="firstname">
        <label for="materialFormRegisterFirstNameEx">Your firstname</label>
    </div>

    <!-- Material input text -->
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="materialFormRegisterLastNameEx" class="form-control" name="lastname">
        <label for="materialFormRegisterLastNameEx">Your lastname</label>
    </div>

    <!-- Material input text -->
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="materialFormRegisterAddress1Ex" class="form-control" name="address1">
        <label for="materialFormRegisterAddress1Ex">Address 1</label>
    </div>

    <!-- Material input text -->
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="materialFormRegisterAddress2Ex" class="form-control" name="address2">
        <label for="materialFormRegisterAddress2Ex">Address 2</label>
    </div>

    <!-- Material input text -->
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="materialFormRegisterZipcodeEx" class="form-control" name="zipcode">
        <label for="materialFormRegisterZipcodeEx">Zipcode</label>
    </div>

    <!-- Material input text -->
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="materialFormRegisterCityEx" class="form-control" name="city">
        <label for="materialFormRegisterCityEx">City</label>
    </div>

    <!-- Material input text -->
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="materialFormRegisterCountryEx" class="form-control" name="country">
        <label for="materialFormRegisterCountryEx">Country</label>
    </div>

    <!-- Material input text -->
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="date" id="materialFormRegisterBirthdateEx" class="form-control" name="birthdate">
        <label for="materialFormRegisterBirthdateEx">Birthdate</label>
    </div>

    <!-- Material input email -->
    <div class="md-form">
        <i class="fa fa-envelope prefix grey-text"></i>
        <input type="email" id="materialFormRegisterEmailEx" class="form-control" name="email">
        <label for="materialFormRegisterEmailEx">Your email</label>
    </div>

    <!-- Material input email -->
    <div class="md-form">
        <i class="fa fa-exclamation-triangle prefix grey-text"></i>
        <input type="email" id="materialFormRegisterConfirmEx" class="form-control" name="email_check">
        <label for="materialFormRegisterConfirmEx">Confirm your email</label>
    </div>

    <!-- Material input password -->
    <div class="md-form">
        <i class="fa fa-lock prefix grey-text"></i>
        <input type="password" id="materialFormRegisterPasswordEx" class="form-control" name="password">
        <label for="materialFormRegisterPasswordEx">Your password</label>
    </div>

    <!-- Material input password -->
    <div class="md-form">
        <i class="fa fa-exclamation-triangle prefix grey-text"></i>
        <input type="password" id="materialFormRegisterPasswordEx" class="form-control" name="password_check">
        <label for="materialFormRegisterPasswordEx">Confirm your password</label>
    </div>

    <!-- Material input text -->
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="materialFormRegisterQuetionNumberEx" class="form-control" name="questionNumber">
        <label for="materialFormRegisterQuetionNumberEx">questionNumber</label>
    </div>

    <!-- Material input text -->
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="materialFormRegisterReplyTextEx" class="form-control" name="replyText">
        <label for="materialFormRegisterReplyTextEx">ReplyText</label>
    </div>

    <!-- Material input text -->
    <div class="md-form">
        <i class="fa fa-user prefix grey-text"></i>
        <input type="text" id="materialFormRegisterSellerEx" class="form-control" name="seller">
        <label for="materialFormRegisterSellerEx">Seller</label>
    </div>

    <div class="text-center mt-4">
        <button class="btn btn-primary" type="submit" name="submit">Register</button>
    </div>
</form>
<!-- Material form register -->
<?php include 'templates/footer.php'; ?>
