<?php
include 'function.php';
include 'database.php';
?>
<!DOCTYPE html>
<html>

<body onload="getLocation()">

<script>

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(redirectToPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function redirectToPosition(position) {
       

        window.location='user_details.php?lat='+position.coords.latitude.toPrecision(10)+'&long='+position.coords.longitude.toPrecision(10);
    }
</script>

</body>
</html>