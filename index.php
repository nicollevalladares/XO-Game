<?php
   include("config/config.php");
   session_start();

   $username = $name = "";
   $username_err = $name_err = "";
   $user_one = $_GET['username'];
   
   // Processing form data when form is submitted
   if($_SERVER["REQUEST_METHOD"] == "POST"){
   
        // Validate username
        if(empty(trim($_POST["username"]))){
            $username_err = "Por favor ingrese un nombre de usuario.";
        } 
        else{
            // Prepare a select statement
            $sql = "SELECT idUser FROM users WHERE userName = ?";

            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                
                // Set parameters
                $param_username = trim($_POST["username"]);
                
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    /* store result */
                    mysqli_stmt_store_result($stmt);
                    
                    if(mysqli_stmt_num_rows($stmt) == 1){
                        $username_err = "Este usuario ya existe.";
                    } else{
                        $username = trim($_POST["username"]);
                    }
                } else{
                    echo "Oops! Algo salio mal, favor intente mas tarde.";
                }
            }
            
            // Close statement
            mysqli_stmt_close($stmt);
        }
      
      // Validate name
      if(empty(trim($_POST["name"]))){
         $name_err = "Por favor ingrese un nombre.";
      }
      else{
         $name = trim($_POST["name"]);
      }
      
      // Check input errors before inserting in database
      if(empty($username_err) && empty($name_err)){
         
         // Prepare an insert statement
         $sql = "INSERT INTO users (username, name) VALUES (?, ?)";
         
         if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_name);
            
            // Set parameters
            $param_username = $username;
            $param_name = $name; 
            $param_user = $user_one;
            
            echo "$param_user";
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
               // Redirect to login page
               header("location: game.php?username=".$param_user."");
            } else{
                echo "Algo salio mal, favor intente mas tarde.";
            }
         }

         
         // Close statement
         mysqli_stmt_close($stmt);
      }

      // Close connection
      mysqli_close($link);
      
   }
?>

<style>
   * {
      margin: 0px;
      padding: 0px;
   }
   body {
      font-size: 120%;
      background: #F8F8FF;
   }

   .header {
      width: 30%;
      margin: 50px auto 0px;
      color: white;
      background: #5F9EA0;
      text-align: center;
      border: 1px solid #B0C4DE;
      border-bottom: none;
      border-radius: 10px 10px 0px 0px;
      padding: 20px;
   }
   form, .content {
      width: 30%;
      margin: 0px auto;
      padding: 20px;
      border: 1px solid #B0C4DE;
      background: white;
      border-radius: 0px 0px 10px 10px;
   }
   .input-group {
      margin: 10px 0px 10px 0px;
   }
   .input-group label {
      display: block;
      text-align: left;
      margin: 3px;
   }
   .input-group input {
      height: 30px;
      width: 93%;
      padding: 5px 10px;
      font-size: 16px;
      border-radius: 5px;
      border: 1px solid gray;
   }
   .btn {
      padding: 10px;
      font-size: 15px;
      color: white;
      background: #5F9EA0;
      border: none;
      border-radius: 5px;
   }
   .error {
      width: 92%; 
      margin: 0px auto; 
      padding: 10px; 
      border: 1px solid #a94442; 
      color: #a94442; 
      background: #f2dede; 
      border-radius: 5px; 
      text-align: left;
   }
   .success {
      color: #3c763d; 
      background: #dff0d8; 
      border: 1px solid #3c763d;
      margin-bottom: 20px;
   }
</style>

<html>
<head>
  <title>SIGN UP</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Registrarse</h2>
  </div>
	
  <form method="post">
  	<div class="input-group">
  	   <label>Username</label>
  	   <input type="text" name="username" value="<?php echo $username; ?>">
      <span class="help-block"><?php echo $username_err; ?></span>
  	</div>
  	<div class="input-group">
      <label>Name</label>
      <input type="text" name="name" value="<?php echo $name; ?>">
      <span class="help-block"><?php echo $name_err; ?></span>
  	</div>
  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Registrarse</button>
  	</div>
  </form>
</body>
</html>