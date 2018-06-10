//map
// map init
var Coffman = {lat: 44.9727, lng:  -93.23540000000003};


// globalize
var map;
var infowindow;
var current_pos;
var restaurant_marker_array = [];
var directionsService;
var directionsDisplay;
var geocoder;
var JSONresponse_location_array = new Array;


function initMap() {
    directionsService = new google.maps.DirectionsService;
    directionsDisplay = new google.maps.DirectionsRenderer;
    map = new google.maps.Map(document.getElementById("map"), {
        zoom: 14,
        center: Coffman
    });

    //init

    // init directionsDisplay
    directionsDisplay.setMap(map);
    directionsDisplay.setPanel(document.getElementById('right-panel'));
    // init infoWindow
    infoWindow = new google.maps.InfoWindow({map: map});
    // path autocomplete
    var input = (document.getElementById('destination'));
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.bindTo('bounds', map);
    // geocoder
    geocoder = new google.maps.Geocoder();
    // init all calendar_marker
    calendar_marker();

    // Try HTML5 geolocation.
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            current_pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            // infoWindow.setPosition(pos);
            // infoWindow.setContent('Your Position');

        }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
        });
    } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
    }
}

function handleLocationError(browserHasGeolocation, infoWindow, current_pos) {
    infoWindow.setPosition(current_pos);
    infoWindow.setContent(browserHasGeolocation ?
        'Error: The Geolocation service failed.' :
        'Error: Your browser doesn\'t support geolocation.');
}


function geocodeAddress(geocoder, address) {
        var code;
        geocoder.geocode({'address': address + " ,MN, 55455"}, function(results, status) {
          if (status === 'OK') {
            var marker = new google.maps.Marker({
            position: results[0].geometry.location ,
            animation:google.maps.Animation.BOUNCE,
            map:map
            });
            google.maps.event.addListener(marker, 'click', function() {

              // infoWindow.setContent( "<p>" + locateEvent(address) + "</p>" +
                                    // "<img style=\"width:100px;height:50px\" src=" +  locateImagePath(address)  + " >");
              infoWindow.setContent("Event");
              infoWindow.open(map, this);
            });

          } else {
            alert('Geocode was not successful for the following reason: ' + status);
          }
        });
      }

function calendar_marker(){
    for (i = 0; i < JSONresponse_location_array.length; i++) {
      geocodeAddress(geocoder, JSONresponse_location_array[i]);
  }
}


function callback(results, status) {
  if (status == google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      var place = results[i];
      createMarker(results[i]);
      // console.log(results[i]);
    }
  }
}

function createMarker(place) {
        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });
        restaurant_marker_array.push(marker);
        // https://stackoverflow.com/questions/9520808/google-places-api-places-detail-request-undefined
        var request = { reference: place.reference };
        service.getDetails(request, function(details, status) {
        // infoWindow
        google.maps.event.addListener(marker, 'click', function() {
        if (details){
          infoWindow.setContent("<div>" + details.name + "</div>" +
                                "<div>" + details.formatted_address + "</div>" );
          infoWindow.open(map, this);
        }
        else {
          infoWindow.setContent("Location Name Details Return null Value" );
          infoWindow.open(map, this);
        }
          });
        });
}


function cleanMarker(){
  for (var i = 0; i < restaurant_marker_array.length; i++) {
          restaurant_marker_array[i].setMap(null);
        }
  restaurant_marker_array = [];
}


function findResturants(){
  if (current_pos){
    var r = document.getElementById("radius").value;
    if (!r)
      alert("Please Enter search radius");
    else{
      // maximum radius
      if (r > 50000)
        alert("Please Enter radius smaller than 50000");
      else {
        cleanMarker();
        var request = {
        location: current_pos,
        radius: r,
        type:['restaurant']
        // query: 'restaurant'
        };
        service = new google.maps.places.PlacesService(map);
        service.nearbySearch(request, callback);
      }
    } // if (!r)
  } // if (current_pos)
  else {
    alert("Please wait to find current location!")
  }
}

// direction
function checkTransit() {
    if (document.getElementById("WALKING").checked == true)
      return "WALKING";
    else if (document.getElementById("TRANSIT").checked == true)
      return "TRANSIT";
    else if (document.getElementById("BICYCLING").checked == true)
      return "BICYCLING";
    else if (document.getElementById("DRIVING").checked == true)
      return "DRIVING";

}

function calculateAndDisplayRoute(directionsService, directionsDisplay,destination,travelMode) {
       directionsService.route({
         origin: current_pos,
         destination: destination,
         travelMode: travelMode
       }, function(response, status) {
         if (status === 'OK') {
           directionsDisplay.setDirections(response);
         } else {
           window.alert('Directions request failed due to ' + status);
         }
       });
     }



function getDirection(){
  var travelMode = checkTransit();
  var destination = document.getElementById("destination").value;
  if (current_pos)
    if (destination)
      calculateAndDisplayRoute(directionsService, directionsDisplay, destination, travelMode);
    else
      alert("Please enter destination");
  else alert("Wait for locating current position");
}


// AnalysisJSON and put it in array
var day = 5;
var MAX_Event_Number = 5;
var week_Array = new Array(day);


function analysisJSON(JSONresponse){

    // init day_array
    // week_Array = new Array(5);
    for (i = 0 ; i < day; i++){
        week_Array[i] = new Array(MAX_Event_Number);
        for (j = 0; j < MAX_Event_Number; j++){
            week_Array[i][j] = "";
        }
    }
    // console.log(JSONresponse);
    var len = (JSONresponse.starttime.length);
    var a = JSONresponse.starttime;
    var swapped;
    do {
        swapped = false;
        for (i=0; i < len-1; i++) {
            if (a[i] > a[i+1]) {
                swap_Event(JSONresponse.starttime,i,i+1);
                swap_Event(JSONresponse.endtime,i,i+1);
                swap_Event(JSONresponse.day,i,i+1);
                swap_Event(JSONresponse.location,i,i+1);
                swap_Event(JSONresponse.eventname,i,i+1);
                swapped = true;
            }
        }
    } while (swapped);



    for (d in JSONresponse.day){
        var day_int = day_Switch(JSONresponse.day[d]);
        for (i = 0; i < MAX_Event_Number; i++){
            if (week_Array[day_int][i] == ""){
                week_Array[day_int][i] = form_string(JSONresponse,d);
                break;
            }
        }

    }
    // week_Array.sort(sortFunction);

    formCalendar(week_Array);
    // console.log(week_Array);

}


function swap_Event(array,i,j){
    var temp = array[i];
    array[i] = array[j];
    array[j] = temp;
    return array;
}



// convert day to int
function day_Switch(day){
    switch (day) {
        case "Mon":
        return 0;
        case "Tue":
        return 1;
        case "Wed":
        return 2;
        case "Thu":
        return 3;
        case "Fri":
        return 4;
            break;
        default:

    }
}

function reverse_day_Switch(day_int){
    switch (day_int) {
        case 0:
        return "Mon";
        case 1:
        return "Tue";
        case 2:
        return "Wed";
        case 3:
        return "Thu";
        case 4:
        return "Fri";
            break;
        default:

    }
}

function form_string(JSONresponse,d){
    event_text = "";
    event_text += '<td>'
    event_text += '<p class="eventtime">' + JSONresponse.starttime[d] + " - " + JSONresponse.endtime[d] + "</p>";
    event_text += '<p class="eventname">' + JSONresponse.eventname[d] + "</p>";
    event_text += '<p class="eventloc">' + JSONresponse.location[d] + "</p>";
    event_text += "</td>";
    JSONresponse_location_array.push(JSONresponse.location[d]);
    return event_text;
}

// Dectect if day td exist,
//      if exist then add child
//      else create child
function formCalendar(week_Array){
    var table = document.getElementById("CalendarTable")
    var output_String ="";
    for (i = 0; i < day; i++){
        if (week_Array[i][0] != ""){
            output_String += "<tr><th>" + reverse_day_Switch(i) + "</th>";
            for (j = 0; j< MAX_Event_Number; j++){
                if (week_Array[i][j] != ""){
                    output_String += week_Array[i][j];
                }
            }
            output_String += "</tr>";
        }
    }
    // console.log(output_String);
    table.innerHTML = output_String;
}
