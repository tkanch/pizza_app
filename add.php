<?php
session_start();
$name=$_SESSION['name'] ?? 'guest';

include('config\db_connect.php');

$email="";
$title="";
$ingredients="";


$errors=[
  "email" => "",
  "title" => "",
  "ingredients" => ""
];


//check if form is submitted
  if(isset($_POST['submit'])){

   //check email is not empty and it is valid
    if(empty($_POST['email'])) {
      $errors['email'] = "Please enter an Email";
    }
    else {
      $email =$_POST['email'];
      if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
      $errors['email'] = "Please enter a valid email address";
         }
    }
    //check title is not empty and contains letters and spaces only
    if(empty($_POST['title'])) {
      $errors['title'] = "Please enter a title";
    }
    else {
      $title=$_POST['title'];
      if(!preg_match('/^[a-zA-Z\s]+$/',$title)){
      $errors['title'] = 'Title must be letters and spaces only';
      }
    }

    //check ingredients is not empty
    if(empty($_POST['ingredients'])) {
      $errors["ingredients"] = "Please enter atleast one Ingredient";
    }
    else {
      $ingredients=$_POST['ingredients'];
      if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z]*)*$/',$ingredients)){
      $errors["ingredients"] = 'Ingredients must be a comma seperated lists';
      }
    }

    if(array_filter($errors)){
      //echo ('errors in the form');
    }
    else {

      $email=mysqli_real_escape_string($conn,$_POST['email']);
      $title=mysqli_real_escape_string($conn,$_POST['title']);
      $ingredients=mysqli_real_escape_string($conn,$_POST['ingredients']);

      //create sql
      $sql="INSERT INTO pizzas(title,email,ingredients) VALUES('$title','$email','$ingredients')";

    //save to database and check
    if(mysqli_query($conn,$sql)){
      //success
      header('location:index.php');
    }
    else {
      //error
      echo 'query-error: ' . mysqli_error($conn);
    }


    }
  } //end of post check


 ?>


<!DOCTYPE html>
<html lang="en">


<?php include 'templates\header.php'; ?>

<sectionclass="container grey-text">
  <h4 class="center">Add a Pizza</h4>
    <form class="white" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <label f>Your Email:</label>
      <input type="text" name="email"  value =" <?php echo htmlspecialchars($email); ?> ">
      <div class="red-text">
        <?php echo $errors["email"]; ?>
      </div>
      <label f>Pizza Title:</label>
      <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" >
      <div class="red-text">
        <?php echo $errors["title"]; ?>
      </div>
      <label f>Ingredients:(comma seperated)</label>
      <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients); ?>" >
      <div class="red-text">
        <?php echo $errors["ingredients"]; ?>
      </div>
      <div class="center">
        <input type="submit" name="submit" value="submit" class="btn brand z-depth-0">
      </div>
    </form>
</section>
<?php include 'templates\footer.php'; ?>


</html>
