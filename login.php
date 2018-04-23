<?php
$current_page='login';
require_once('templates/header.php');

//login SCRIPTS
if(isset($_POST['submit'])){//if submit pressed
  login($_POST['email'], $_POST['password']);//login function
}

?>


<?php if(isset($error)) {
  echo $error;
}
  ?>
<!--Main Layout-->
<main class="py-5 mask rgba-black-light flex-center">
  <div class="bg"></div>
<!-- Card -->
<div class="container col-md-4">
<div class="card">
    <!-- Card body -->
    <div class="card-body">

<<<<<<< HEAD
        <!-- Material form login -->
        <form method="post" action="">
            <p class="h4 text-center py-4">Sign in</p>

 
=======
<<<<<<< HEAD
        <!-- Material form login -->
        <form>
            <p class="h4 text-center py-4">Sign in</p>


=======
        <!-- Material form register -->
        <form>
            <p class="h4 text-center py-4">Sign up</p>

            <!-- Material input text -->
            <div class="md-form">
                <i class="fa fa-user prefix grey-text"></i>
                <input type="text" id="materialFormCardNameEx" class="form-control">
                <label for="materialFormCardNameEx" class="font-weight-light">Your name</label>
            </div>
>>>>>>> 0fdc1181bd0c8f165469e3001cac66a1d976e558
>>>>>>> 4690ffd83489c216225c43ccb46d87fb93853e6b

            <!-- Material input email -->
            <div class="md-form">
                <i class="fa fa-envelope prefix grey-text"></i>
                <input type="email" id="materialFormCardEmailEx" class="form-control">
                <label for="materialFormCardEmailEx" class="font-weight-light">Your email</label>
            </div>

<<<<<<< HEAD
   
=======
<<<<<<< HEAD
=======
            <!-- Material input email -->
            <div class="md-form">
                <i class="fa fa-exclamation-triangle prefix grey-text"></i>
                <input type="email" id="materialFormCardConfirmEx" class="form-control">
                <label for="materialFormCardConfirmEx" class="font-weight-light">Confirm your email</label>
            </div>
>>>>>>> 4690ffd83489c216225c43ccb46d87fb93853e6b

>>>>>>> 0fdc1181bd0c8f165469e3001cac66a1d976e558
            <!-- Material input password -->
            <div class="md-form">
                <i class="fa fa-lock prefix grey-text"></i>
                <input type="password" id="materialFormCardPasswordEx" class="form-control">
                <label for="materialFormCardPasswordEx" class="font-weight-light">Your password</label>
            </div>

            <div class="text-center py-4 mt-3">
                <button class="btn btn-cyan" type="submit">login</button>
            </div>
        </form>
<<<<<<< HEAD
        <!-- Material form login -->
=======
<<<<<<< HEAD
        <!-- Material form login -->
=======
        <!-- Material form register -->
>>>>>>> 0fdc1181bd0c8f165469e3001cac66a1d976e558
>>>>>>> 4690ffd83489c216225c43ccb46d87fb93853e6b

    </div>
    <!-- Card body -->
</div>
<!-- Card -->
</div>
</main>
<!--Main Layout-->
<?php include 'templates/footer.php'; ?>
