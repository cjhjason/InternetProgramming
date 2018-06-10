<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Example</title>
  </head>
  <body>
    <form action="index.php" method="post">

    </form>

    <?php
      $pricipal = $_POST['loan'];
      $interest_rate = $_POST['$interest_rate'];
      $years = $_POST['years'];
      $interest = $pricipal * $interest_rate * $years;
      $principal_f = '$'.number_format($pricipal,2);
      $yearly_rate = $interest_rate.'$';
      $interest_f = '$'.number_format($interest,2);

    ?>
  </body>
</html>
