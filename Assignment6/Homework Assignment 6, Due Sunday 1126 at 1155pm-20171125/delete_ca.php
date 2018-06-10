<?php
    $filename = "calendar.txt";
    if (unlink($filename))
        echo 'delete all events';
    // //Redirect to calendar.php
    echo '<script type="text/javascript"> window.location.href = "calendar.php" </script>'
?>
