<?php
class Army {
    public $grunts;
    public $generals;
    public $mages;

    public function __construct($num){
        $counter = $num;
        $this->grunts = rand(0,$counter);
        $counter -= $this->grunts;
        $this->generals = rand(0,$counter);
        $this->mages = $counter - $this->generals;

    }


    function get_units(){
        return "Grunts: ". $this->grunts. "<br> Generals: " . $this->generals . "<br> Mages: " . $this->mages . "<br>";
    }

    function calculate_power(){
        $power = $this->grunts * 2 + $this->generals * 4 + $this->mages * 8;
        return $power;
    }

}

function winner(int $x, int $y) {
    if($x == 0 || $y ==  0) {
        trigger_error("Power level error: Values must be greater than 0.");

    }
    else if ($x > $y) {
        return "The winner is the blue team!";
    }
    else if ($x < $y){
        return "The winner is the red team!";
    }
    else if ($x == $y){
        return "The battle ended in a draw!";
    }
}



if(isset($_GET['submit']) && !empty($_GET['blue']) && !empty($_GET['red'])){
    $blue_num = $_GET['blue'];
    $red_num = $_GET['red'];

    $blue_army = new Army($blue_num);
    $blue_units =  $blue_army->get_units();

    $red_army = new Army($red_num);
    $red_units = $red_army->get_units();
    $winner = winner($blue_army->calculate_power(),$red_army->calculate_power());

    $log  = date("F j, Y, G:i:s").PHP_EOL.
            "Blue team: ". $blue_units .PHP_EOL.
            "Red team: ". $red_units .PHP_EOL.
            "Winner: ".$winner.PHP_EOL.
            "-------------------------".PHP_EOL;
    //-
    file_put_contents('./log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);

}



    
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>-Battle of 2 Armies-</title>
    <style>
        * {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
        .wrapper {
            text-align: center;
            padding-top: 100px;
            position: relative;
        }
        .warning {
            color: red;
        }

        .result {
            display: grid;
            grid-template-columns: auto auto;
            width: 40%;
            margin: auto;
        }
        .winner {
            grid-column-start: 1;
            grid-column-end: 3;
        }

        footer { 
            
            position: absolute;
            bottom: 0;
            width: 100%;  
        }

        footer p {
            text-align: center;
            color:gray;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <form action ="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" >
            <div>
                <label for="blue">Enter the number of <span style="color:blue;">blue</span>  army</label>
                <input type="number" name="blue" id="blue">
                <br>
                <div>
                    <span id="msgBlue" class="warning"></span>
                </div>
                
            </div>
                <br>
            <div>
                <label for="blue">Enter the number of <span style="color:red;">red</span>  army</label>
                <input type="number" name="red" id="red">
                <br>
                <div>
                    <span id="msgRed" class="warning"></span>
                </div>
            </div>
            <input type="submit" name="submit" id="submit" value="Submit">
        </form>
        <div class="result">
            <div class="blue">
                <?php if(isset($winner)) echo "Blue units: <br>" . $blue_units; ?>
            </div>
            <div class="red">
                <?php if(isset($winner)) echo "Red units: <br>" . $red_units; ?>
            </div>
            <div class="winner">
                <h2><?php if(isset($winner)) echo $winner; ?></h2>
            </div>
        </div>
    </div>
 
    <script>
        document.getElementById("submit").onclick = function(event) {
            var send_form = true;


            var blue_input = document.getElementById("blue");
            var blue = document.getElementById("blue").value;
            if (blue.length == 0) {
                send_form = false;
                document.getElementById("msgBlue").innerHTML = "Please enter the number of blue soldiers";
                blue_input.style.border="1px solid red";
            }else if(blue < 0){
                send_form = false;
                document.getElementById("msgBlue").innerHTML = "Please enter a number greater than 0.";
                blue_input.style.border="1px solid red";
            }
            else {
                document.getElementById("msgBlue").innerHTML = "";
                blue_input.style.border="1px solid green";
            }

            var red_input = document.getElementById("red");
            var red = document.getElementById("red").value;
            if (red.length == 0) {
                send_form = false;
                document.getElementById("msgRed").innerHTML = "Please enter the number of red soldiers";
                red_input.style.border="1px solid red";
            }else if(red < 0){
                send_form = false;
                document.getElementById("msgRed").innerHTML = "Please enter a number greater than 0.";
                red_input.style.border="1px solid red";
            }
            else {
                document.getElementById("msgRed").innerHTML = "";
                red_input.style.border="1px solid green";
            }

            if (send_form != true) {
                event.preventDefault();
            }

        }
    </script>
    <footer>
        <p>Rules: Units are randomly generated from the inputed numbers, the team with greater power level wins.
        </p>
        <p>Multipliers:</p>
        <p>Grunt x2 <br> General x4 <br> Mage x8
        </p></p>
    </footer>
</body>
</html>
