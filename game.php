<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XO Game</title>
</head>
<body>
    <form style="width: 500px; margin-left:auto; margin-right:auto; margin-top: 30px" method="POST">
        <?php
            $error = false;
            $x_win = false;
            $o_win = false;
            $count = 0; 
            $username = $_GET['username'];

            include("config/config.php");
            session_start();

            //print the matrix
            for($id = 1; $id < 10; $id++){
                if($id == 4 || $id == 7)
                    print "<br>";

                print "<input style = 'height: 70px !important; text-align: center' name = $id type = text size = 15 ";

                if(isset($_POST['submit']) && !empty($_POST[$id])){
                    
                    // validate that only X and 0 can be used
                    if ($_POST[$id] == 'X' || $_POST[$id] == 'O') {

                        $count ++;

                        print " value = ".$_POST[$id]." readonly>";
                        

                        for($a = 1, $b = 2, $c = 3; $a <= 7, $b <= 8, $c <= 9; $a += 3, $b += 3, $c += 3){
                            if($a = 1 && $b = 2 && $c = 3){

                                // Prepare a select statement
                                $sql = "SELECT idMatrix FROM matrix WHERE userName = ?";
    
                                if($stmt = mysqli_prepare($link, $sql)){
                                    // Bind variables to the prepared statement as parameters
                                    mysqli_stmt_bind_param($stmt, "s", $param_username);
                                    
                                    // Set parameters
                                    $param_username = $username;
                                    
                                    // Attempt to execute the prepared statement
                                    if(mysqli_stmt_execute($stmt)){
                                        /* store result */
                                        mysqli_stmt_store_result($stmt);
                                        
                                        if(mysqli_stmt_num_rows($stmt) == 1){
                                            $sql = "UPDATE matrix SET `1`=?,`2`=?,`3`=? WHERE username = ?";
    
                                            if($stmt = mysqli_prepare($link, $sql)){
                                                // Bind variables to the prepared statement as parameters
                                                mysqli_stmt_bind_param($stmt, "ssss", $param_a, $param_b, $param_c, $param_username);
                                                
                                                // Set parameters
                                                $param_a = $_POST["$a"];
                                                $param_b = $_POST["$b"]; 
                                                $param_c = $_POST["$c"];
                                                $param_username = $username;
    
                                                // Attempt to execute the prepared statement
                                                if(mysqli_stmt_execute($stmt)){
                                                // Redirect to login page
                                                header("location: game.php?username=".$param_user."");
                                                } else{
                                                    echo "Algo salio mal, favor intente mas tarde.";
                                                }
                                            }
                                        } else{
                                            $sql_2 = "INSERT INTO matrix (1,2,3, username) VALUES (?, ?, ?, ?)";
    
                                            if($stmt = mysqli_prepare($link, $sql_2)){
                                                // Bind variables to the prepared statement as parameters
                                                mysqli_stmt_bind_param($stmt, "ssss", $param_a, $param_b, $param_c, $param_username);
                                                
                                                // Set parameters
                                                $param_a = $_POST["$a"];
                                                $param_b = $_POST["$b"]; 
                                                $param_c = $_POST["$c"];
                                                $param_username = $username;
                                                
                                                // Attempt to execute the prepared statement
                                                if(mysqli_stmt_execute($stmt)){
                                                // Redirect to login page
                                                header("location: game.php?username=".$param_user."");
                                                } else{
                                                    echo "Algo salio mal, favor intente mas tarde.";
                                                }
                                            }
                                        }
                                    } else{
                                        echo "Oops! Algo salio mal, favor intente mas tarde.";
                                    }
                                }
                                
                            }
                            if($_POST["$a"] == $_POST["$b"] && $_POST["$b"] == $_POST["$c"]){
                                if($_POST["$a"] == 'X'){
                                    $x_win = true;
                                }
                                elseif($_POST["$a"] == 'O'){
                                    $o_win = true;
                                }
                            } 
                        }

                        for($a = 1, $b = 4, $c = 7; $a <= 3, $b <= 6, $c <= 9; $a += 1, $b += 1, $c += 1){
                            if($_POST["$a"] == $_POST["$b"] && $_POST["$b"] == $_POST["$c"]){
                                if($_POST["$a"] == 'X'){
                                    $x_win = true;
                                }
                                elseif($_POST["$a"] == 'O'){
                                    $o_win = true;
                                }
                            } 
                        }

                        for($a = 1, $b = 5, $c = 9; $a <= 3, $b <= 5, $c >= 7; $a += 2, $b += 0, $c -= 2){
                            if($_POST["$a"] == $_POST["$b"] && $_POST["$b"] == $_POST["$c"]){
                                if($_POST["$a"] == 'X'){
                                    $x_win = true;
                                }
                                elseif($_POST["$a"] == 'O'){
                                    $o_win = true;
                                }
                            } 
                        }
                    }
                    else{
                        print ">";
                        $error = true;
                    }
                }
                else{
                    print ">";
                }
            }
        ?>
        <br>
        <br>
        <p>
            <input name="submit" type="submit">
        </p>

        <?php
            echo "<p>Jugador uno: $username </p>
            <p>Partidas ganadas: 0
            <br>
            <br>";
            echo "<span>LINK DE INVITACION</span><br>
            <a href='http://localhost/XO-Game/index.php?username=$username'>Partida</a>"
        ?>
    </form>
    
    <?php
        if($o_win){
            print "Ha ganado el jugador O";
        }
        elseif($x_win){
            print "Ha ganado el jugador X";
            
        }
        elseif ($count == 8 || $count == 9 && !$o_win && !$x_win) {
            print "Ningun jugador ha ganado";
        }
        elseif($error){
            print "Por favor ingresar los valores X y O";
        }
    ?>
</body>
</html>