<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript">
    // Form Validation
    function validateForm(){
        var name = document.forms["loginform"]["name"].value;
        var password = document.forms["loginform"]["password"].value;
        var msgDiv = document.getElementById("errormsg");
        var alert_string = ""


        if (name == ""){
            alert_string += "<p>Empty Login Name</p>";
        }
        if (password == ""){
          alert_string += "<p>Empty Login Password</p>";
        }

        if (alert_string == ""){
            return true;
        }else{
            msgDiv.innerHTML = alert_string;
            return false;
        }

    }


    </script>
  </head>
  <body>


    <div id="Title">
      <h1>Login Page</h1>
    </div>

    <div class="Navigator">
      <nav>
        <ul id="NavigatorList">
<!--          <li><a href="calendar.php">My Calendar </a></li>-->
<!--          <li><a href="form.php">Form input</a></li>-->
        </ul>
      </nav>
    </div>

    <div id="errormsg"></div>


    <div id="Input">
      <form class="" name="loginform" onsubmit="return validateForm();"  action="validateLogin.php" method="post">
      <p>Login Name<input  name="name" type="text" ></p>
      <p>Login Password<input  name="password" type="text" ></p>
      <p><button id="loginsubmitbutton" type="submit" name="submit">Submit</button></p>
      </form>
    </div>



  </body>
</html>
