<?php

require("includes/common.php");

  // Getting the values from the signup page using $_POST[] and cleaning the data submitted by the user.
  $first = filter_input(INPUT_POST,'first name');
  $name = mysqli_real_escape_string($con, $first);
  
  $last = filter_input(INPUT_POST,'last name');
  $name1 = mysqli_real_escape_string($con, $last);

  $email = filter_input(INPUT_POST,'email');
  $emaill = mysqli_real_escape_string($con, $email);

  $pass = filter_input(INPUT_POST,'password');
  $passw = mysqli_real_escape_string($con, $pass);
  $password = MD5($passw);

  $phone = filter_input(INPUT_POST,'phone');
  $contact = mysqli_real_escape_string($con, $phone);

  $regex_email = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/";
  $regex_num = "/^[789][0-9]{9}$/";

  $query = "SELECT * FROM users WHERE email='$emaill'";
  $result = mysqli_query($con, $query)or die($mysqli_error($con));
  $num = mysqli_num_rows($result);
  
  if ($num != 0) {
    $m = "<span class='red'>Email Already Exists</span>";
    header('location: signup.php?m1=' . $m);
  } else if (!preg_match($regex_email, $emaill)) {
    $m = "<span class='red'>Not a valid Email Id</span>";
    header('location: signup.php?m1=' . $m);
  } else if (!preg_match($regex_num, $phone)) {
    $m = "<span class='red'>Not a valid phone number</span>";
    header('location: signup.php?m2=' . $m);
  } else {
    
    $query = "INSERT INTO users(email, password, first_name,last_name,phone)VALUES('" . $emaill . "','" . $password . "','" . $name . "','" . $name1 . "','" . $contact . "')";
    mysqli_query($con, $query) or die(mysqli_error($con));
    $user_id = mysqli_insert_id($con);
    $_SESSION['email'] = $email;
    $_SESSION['user_id'] = $user_id;
    header('location: products.php');
  }