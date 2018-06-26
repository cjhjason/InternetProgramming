<!DOCTYPE html>
<!-- Name:Jinhao Chen; X500:chen4566; -->
<html>

<head>
  <meta charset="utf-8">
  <title>My Calendar</title>
  <link rel="stylesheet" href="style.css">
  <!-- Google Places  Maps -->
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=XXXXXXXXXX&libraries=places&callback=initMap"></script>
  <script type="text/javascript" src="script.js"></script>
</head>


<body>


  <div id="Title">
    <h1>My Calendar</h1>
  </div>



  <div id="Navigator">
    <nav>
      <ul id="NavigatorList">
        <li><a href="calendar.php" id="MyCalendarLeft">My Calendar </a></li>
        <li><a href="form.php" id="ForminputRight">Form input</a></li>
      </ul>
    </nav>
  </div>




  <div id="CalendarTableDiv">
    <table id="CalendarTable">
      <p id="noevent">Calendar has no event, Please use the input to enter some events</p>
    </table>
  </div>


  <div id="mapInfo-div">
    <input id="searchbox" type="text"><input type="button" value="Search">
  </div>

  <div id="map"></div>



<script type="text/javascript">
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        if (this.responseText){
            var event_text = "";
            var JSONresponse = JSON.parse(this.responseText);    
            analysisJSON(JSONresponse);
            document.getElementById("noevent").remove();
        }
    }
    };
    xmlhttp.open("GET", "calendar.txt", true);
    xmlhttp.send();

</script>




</body>

</html>


<!-- Browser:Chrome safari -->
