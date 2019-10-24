<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XO Game</title>
</head>
<body>
    <form method="POST" action="game.php">
        <?php
            $error = false;
            $x_win = false;
            $o_win = false;
            $count = 0;
            $v1 = $_GET['username'];

            //print the matrix
            for($id = 1; $id < 10; $id++){
                if($id == 4 || $id == 7)
                    print "<br>";

                    print "<input name = $id type = text size = 8";
                
                if(isset($_POST['submit']) && !empty($_POST[$id])){
                    
                    // validate that only X and 0 can be used
                    if ($_POST[$id] == 'X' || $_POST[$id] == 'O') {

                        $count ++;

                        print " value = ".$_POST[$id]." readonly>";

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

        <p>
            <input name="submit" type="submit">
        </p>
        

        <h3>LINK DE INVITACION</h3>
        <a href='http://localhost/XO-Game/index.php?username='.$v1 target="_blank">Partida</a>
    </form>
    
    <?php
        if($o_win){
            print "Ha ganado el jugador O";
                    
            $sql = "INSERT INTO users_games_won (users_idUser, games_idGame, quantity) VALUES (1, 1, 1)";
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