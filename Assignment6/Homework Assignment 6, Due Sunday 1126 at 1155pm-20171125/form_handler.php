<?php

    $JSON_setup = array("eventname"=>array(),"starttime"=> array(),"endtime"=>array(),"location"=>array(),"day"=>array());
    $filename = "calendar.txt";
    if (file_exists($filename)){
        // echo "file exists";
        $myfile = file_get_contents($filename);
        if ($myfile){
            // echo "readfile Result: ".$myfile;
            $JSON_array = json_decode($myfile, true);
            if (!empty($_POST)){
                array_push($JSON_array["eventname"],$_POST["eventname"]);
                array_push($JSON_array["starttime"],$_POST["starttime"]);
                array_push($JSON_array["endtime"],$_POST["endtime"]);
                array_push($JSON_array["location"],$_POST["location"]);
                array_push($JSON_array["day"],$_POST["day"]);
                // echo $JSON_array["eventname"];
                // var_dump($JSON_array);
                $JSON_array_encode = json_encode($JSON_array);
                file_put_contents($filename, $JSON_array_encode);
            }
        }
        else {
            // echo "file is empty";
            $JSON_setup = json_encode($JSON_setup);
            file_put_contents($filename, $JSON_setup);
        }

    }
    else {
        // echo "file not exist";
        if (!empty($_POST)){
            array_push($JSON_setup["eventname"],$_POST["eventname"]);
            array_push($JSON_setup["starttime"],$_POST["starttime"]);
            array_push($JSON_setup["endtime"],$_POST["endtime"]);
            array_push($JSON_setup["location"],$_POST["location"]);
            array_push($JSON_setup["day"],$_POST["day"]);
            // echo $JSON_array["eventname"];
            // var_dump($JSON_array);
            $JSON_array_encode = json_encode($JSON_setup);
            file_put_contents($filename, $JSON_array_encode);
        }
    }

    // //Redirect to calendar.php
    echo '<script type="text/javascript"> window.location.href = "calendar.php" </script>'
?>
