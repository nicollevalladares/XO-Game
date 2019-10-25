<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XO Game</title>
</head>
<body>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            setInterval(function(){ 
                window.location.reload();
            }, 2000);
        });
        
    </script>
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
                        
                        //first row
                        for($a = 1, $b = 2, $c = 3; $a <= 7, $b <= 8, $c <= 9; $a += 3, $b += 3, $c += 3){
                            if($_POST["$a"] == $_POST["$b"] && $_POST["$b"] == $_POST["$c"]){
                                if($_POST["$a"] == 'X'){
                                    $x_win = true;
                                }
                                elseif($_POST["$a"] == 'O'){
                                    $o_win = true;
                                }
                            } 
                        }
                        
                        //first column
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
                        
                        //diagonal
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