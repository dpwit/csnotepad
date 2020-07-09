<!DOCTYPE HTML>  
<html>
  <head>
    <style>
      .error {color: #FF0000;}
    </style>
  </head>
    <body>  

    <?php
      // define variables and set to empty values
      $nameErr = $emailErr = $telephoneErr = "";
      $name = $email = $telephone = "";

      if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (empty($_POST["name"])) {
      $nameErr = "Your name is required";
      } else {
      $name = signup_request($_POST["name"]);
      }
  
      if (empty($_POST["email"])) {
      $emailErr = "A valid email is required";
      } else {
      $email = signup_request($_POST["email"]);
      }
    
      if (empty($_POST["telephone"])) {
      $telephoneErr = "A valid number is required";
      } else {
      $email = signup_request($_POST["telephone"]);
      }
      } 

      function signup_request($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
      }
    ?>

  <h2>PHP Form Validation Example</h2>
  <p><span class="error">* required field.</span></p>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
      Name: <input type="text" name="name">
      <span class="error">* <?php echo $nameErr;?></span>
      <br><br>
      E-mail: <input type="text" name="email">
      <span class="error">* <?php echo $emailErr;?></span>
      <br><br>
      Telephone: <input type="text" name="telephone">
      <span class="error">* <?php echo $telephoneErr;?></span>
      <br><br>
      <input type="submit" name="submit" value="Submit">  
  </form>

    <?php
    echo "<h2>YResults:</h2>";
    echo $name;
    echo "<br>";
    echo $email;
    echo "<br>";
    echo $telephone;
    echo "<br>";
    ?>

    </body>
  </html>