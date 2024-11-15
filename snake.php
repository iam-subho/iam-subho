<form action="snake.php" method="post" style="text-align: center">

    <label>
        No of grid
        <input type="number" name="grid" value="4">
    </label>
    <br><br>
    <label>
        No of Player is 3
    </label>
    <br><br>
    <button type="submit"> Play</button>
</form>


<?php

//Snake Ladder game with 3 player and variable grid size

if($_POST){

    $no_of_grid = $_POST['grid'];
    $maxValue = $no_of_grid*$no_of_grid;

    $intSum = 1;
    $cordinateMap = array();
    for($i = 0;$i<$no_of_grid;$i++){
        if($i % 2 ==0){
            for($j = 0;$j<$no_of_grid;$j++){
              $cordinateMap[$intSum] = array($j,$i);
              $intSum++;
            }
        }else{
            for ($j = $no_of_grid-1; $j >= 0; $j--) {
              $cordinateMap[$intSum] = array($j,$i);
              $intSum++;
            }
        }
    }

    $co_history = [];

    $va_history = [];

    $dice_history = [];

    $round = 0;
    $winner = 0;
    $x = 0 ; $y = 0;
    while(1){

        for($i=1; $i<=3; $i++){

            $dice = rand(1,6);
            $dice_history[$i][$round] = $dice;
            $value = $dice;
            if($round == 0){
                $va_history[$i][$round] = $value;
            }else{
                $cal = $va_history[$i][$round-1] + $value ;
                $value = $cal>$maxValue?$va_history[$i][$round-1]:$cal;
                $va_history[$i][$round] = $value;
            }


            $co_history[$i][$round] = $cordinateMap[$value];

            if($value == $maxValue){
                $winner = $i;
                break;
            }
        }
        $round++;
        if($winner){
            break;
        }

    }
    echo '<pre>';
    //print_r($cordinateMap);
    echo "<h3>No of Grid ".$no_of_grid."</h3><br>";echo "<br>";
    //print_r($dice_history); echo "  "; print_r(($va_history)); echo "<br>";



    echo "<table border='1'>";
    $coRound = 1;
    echo "<tr>";
    foreach ($cordinateMap as $key => $value){

        echo "<th>".$key . '(' .implode(',',$value).')'."</th>";

        if($coRound % $no_of_grid == 0){
            echo "</tr>";
            echo "<tr>";
        }
        $coRound++;
    }

   echo "</table>";
   echo "<br><br><br>";
    if($dice_history && $va_history){

        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>Player No</th><th>Dice History</th><th>Postion History</th><th>Cordinate History</th><th>Winner</th>";
        echo "</tr>";
        echo "<tbody>";

        for($i = 1 ;$i<=3; $i++){
            echo "<tr>";
             echo "<td> $i </td>";
             echo "<td>"; echo implode(",",$dice_history[$i]);  echo"</td>";
             echo "<td>"; echo implode(',',$va_history[$i]);  echo"</td>";
             echo "<td>";

             foreach ($co_history[$i] as $value){
                 echo "(".implode(",",$value).")";
             }

             echo"</td>";

             if($winner == $i){
                 echo "<td>Winner</td>";
             }else{
                 echo "<td>-</td>";
             }
             echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";


    }
}
