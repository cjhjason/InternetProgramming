<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Form input</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript">
    // Form Validation
    function validateForm(){
        var event_name = document.forms["myForm"]["eventname"].value;
        var event_location = document.forms["myForm"]["location"].value;
        var event_starttime = document.forms["myForm"]["starttime"].value;
        var event_endtime = document.forms["myForm"]["endtime"].value;
        var msgDiv = document.getElementById("errormsg");
        var alert_string = ""

        if (!/[a-zA-Z0-9\s]+[a-zA-Z0-9]$/.test(event_name) || event_name == ""){
          alert_string += "<p>Error event name format:xxx 000</p>";
        }
        if (event_starttime == ""){
            alert_string += "<p>Empty start time</p>";
        }
        if (event_endtime == ""){
          alert_string += "<p>Empty end time</p>";
        }
        if (!/^[a-zA-Z0-9\s]+[a-zA-Z0-9]$/.test(event_location) || event_name == ""){
          alert_string += "<p>Error event location format:xxx 000</p>";
        }
        console.log(Date.parse(event_starttime));
        if (event_starttime > event_endtime){
            alert_string += "<p>Error in start and end time</p>";
            alert("startime greater than end time");
        }

        if (alert_string == ""){
            return true;
        }else{
            msgDiv.innerHTML = alert_string;
            alert(alert_string);
            return false;
        }


    }

    function clearCalendar() {
        var xmlhttp = new XMLHttpRequest();
        // xmlhttp.onreadystatechange = function() {
        // };
        xmlhttp.open("GET", "delete_ca.php", true);
        xmlhttp.send();
        // var noevent = document.createElement("p");
        // noevent.setAttribute("id","noevent");
        // document.getElementById("CalendarTable").appendChild(noevent);

    }
    function submitCalendar() {
        document.forms["myForm"]["onsubmission"].value = "submit"
    }



    </script>
  </head>
  <body>


    <div id="Title">
      <h1>Calendar Input</h1>
    </div>

    <div class="Navigator">
      <nav>
        <ul id="NavigatorList">
          <li><a href="calendar.php">My Calendar </a></li>
          <li><a href="form.php">Form input</a></li>
        </ul>
      </nav>
    </div>

    <div id="errormsg"></div>


    <div id="Input">
      <form class="" name="myForm" onsubmit="return validateForm();"  action="form_handler.php" method="post">

      <p>Event Name<input  name="eventname" type="text" ></p>
      <p>Start Time<input  name="starttime" type="time" ></p>
      <p>End Time<input  name="endtime" type="time" ></p>
      <p>Location<input  name="location" type="text" ></p>
      <p>Week of the day
        <select  name = "day">
            <option>Mon</option>
            <option>Tue</option>
            <option>Wed</option>
            <option>Thu</option>
            <option>Fri</option>
          </select>
      </p>
      <p><button id="submitbutton" type="submit" name="submit" onclick="submitCalendar()">Submit</button></p>
      <p><button id="clearbutton" type="reset" name="reset" onclick="clearCalendar()">Clear</button></p>
      <p hidden><input type="hidden" name="onsubmission" value="submit"></p>
      </form>
    </div>



  </body>
</html>
