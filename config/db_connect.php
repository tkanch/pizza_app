

<?php

//connect to database
$conn=mysqli_connect('localhost','tasnim','kofovan!','pizza_project');


//checking connection
if(!$conn) {
  echo "connection error:" .mysqli_connect_error();
}

?>
