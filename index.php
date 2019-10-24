<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>XO Game</title>
</head>
<body>
    <form method="POST" action="index.php">
        <?php
            $error = false;
            $x_win = false;
            $o_win = false;

            for($id = 1; $id < 10; $id++){
                if($id == 4 || $id == 7){
                    print "<br><input name = $id type = text size = 8>";
                }
                else{
                    print "<input name = $id type = text size = 8>";
                }

                if(isset($_POST['submit']) && !empty($_POST[$id])){
                    if ($_POST[$id] == 'X' || $_POST[$id] == '0') {
                        print "value = $_POST[$id]";

                        for($a = 1, $b = 2, $c = 3; $a <= 7, $b <= 8, $c <= 9; $a += 3, $b += 3, $c += 3){
                            if($_POST[$a] == $_POST[$b] && $_POST[$b] == $_POST[$c]){
                                if($_POST[$a] == 'x'){
                                    $x_win = true;
                                }
                                else{
                                    $o_win = true;
                                }
                            } 
                        }

                        for($a = 1, $b = 4, $c = 7; $a <= 3, $b <= 6, $c <= 9; $a += 1, $b += 1, $c += 1){
                            if($_POST[$a] == $_POST[$b] && $_POST[$b] == $_POST[$c]){
                                if($_POST[$a] == 'x'){
                                    $x_win = true;
                                }
                                else{
                                    $o_win = true;
                                }
                            } 
                        }

                        for($a = 1, $b = 5, $c = 9; $a <= 3, $b <= 5, $c <= 9; $a += 2, $b += 5, $c -= 2){
                            if($_POST[$a] == $_POST[$b] && $_POST[$b] == $_POST[$c]){
                                if($_POST[$a] == 'x'){
                                    $x_win = true;
                                }
                                else{
                                    $o_win = true;
                                }
                            } 
                        }
                    }
                    else{
                        $error = true;
                    }
                }
            }
        ?>

        <p><input name="submit" type="submit"></p>
    </form>
    
</body>
</html>