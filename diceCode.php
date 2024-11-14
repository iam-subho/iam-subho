<form method="post" action="code.php">
    <label>
        <select name="choose">
            <option value="">Choose you bet</option>
            <option value="1">Below 7</option>
            <option value="2">Exact 7</option>
            <option value="3">Above 7</option>
        </select>
    </label>
    <label>
        <input type="submit" name="sub_btn"  value="Continue Play">
    </label>
    <label>
        <input type="submit" name="sub_btn" value="Reset and Play again"/>
    </label>
</form>


<?php

session_start();

if(!key_exists('amt',$_SESSION)){
    $_SESSION['amt'] = 100;
}else{
    $amt = $_SESSION['amt'];
}

//echo $amt." ";


if($_POST){

    $dice1 = rand(1,6);
    $dice2 = rand(1,6);

    $result = $dice1 + $dice2;

    echo "Dice 1  Outcome is ".$dice1; echo "<br>";
    echo "Dice 2  Outcome is ".$dice2; echo "<br>";
    echo "Sum of Dice1 and Dice 2  is ".$result; echo "<br>";
    //print_r($_POST); echo "<br>";

    if($_POST['sub_btn'] == 'Continue Play'){

        if($_POST['choose'] == ""){
            echo "please choose your bet";
            exit();
        }

        if($amt<20){
            echo "Please reset the game as minimum balance thresold Rs 20 reach";
        }

        $amt = $amt-10;
        if($result == 7 && $_POST['choose'] == 2){
            $amt = $amt+30;
            echo "Congratulations ! You win ! Your balance is now ".$amt." Rs.";
        }elseif($result > 7 && $_POST['choose'] == 3){
            $amt = $amt+20;
            echo "Congratulations ! You win ! Your balance is now ".$amt." Rs.";
        }elseif($result < 7 && $_POST['choose'] == 1){
            $amt = $amt+20;
            echo "Congratulations ! You win ! Your balance is now ".$amt." Rs.";
        }else{
            echo "Sorry ! You lost ! Your balance is now ".$amt." Rs";
        }

        $_SESSION['amt'] = $amt;

    }else{
        $amt = 100;
        $_SESSION['amt'] = $amt;
    }

}else{
    echo "no data";
}

?>
