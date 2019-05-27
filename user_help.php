<!DOCTYPE html>
<html>
<head>
	<title>Home_Page</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  	<style type="text/css">
  		.animate {
		  display: flex;
		  justify-content: center;
		  align-items: center;
		}
		.human-heart {
		  margin: 5em;
		  animation: 1.8s infinite beatHeart;
		}

		@keyframes beatHeart {
		  0% {
		    transform: scale(1);
		  }
		  25% {
		    transform: scale(1.1);
		  }
		  40% {
		    transform: scale(1);
		  }
		  60% {
		    transform: scale(1.1);
		  }
		  100% {
		    transform: scale(1);
		  }
}
  	</style>
</head>
<body style="background-color: powderblue;">

<br>	
<div class="container-fluid">
	<div class="container">
		<div class="row">
			<div class="col-xs-3">
				<a href="#"><img src="error.png" style="width:20px;"></a>
			</div>

			<div class="col-xs-6">
				
			</div>
			<div class="col-xs-3">
				<a href="#"><img src="settings-work-tool.png" style="width:20px;float:right;"></a>
			</div>
		</div>
	</div>
</div>
<br><br>
<div class="container-fluid">
	<div class="container">
		<div class="row">
			<div class="col-xs-1">
				
			</div>
			<div class="col-xs-10">
				<center><h3 style="color: white;font-family: roboto;"><b>Click the button in case of Emergency!!!</b></h3></center>
			</div>
			<div class="col-xs-1">
				
			</div>
			
			
		</div>
	</div>
</div>
<br><br>
<div class="container-fluid">
	<div class="container">
		<div class="row">
			<div class="col-xs-4">
				
			</div>
			<div class="col-xs-4">
				<center class="animate" ><img src="help.png" onclick="getLocation()" style="width: 122px;" class="human-heart" alt="human heart" /></center>
			</div>
			<div class="col-xs-4">
				
			</div>
			
			
		</div>
	</div>
</div>

<div class="container-fluid">
	<div class="container">
		<div class="row">
			<div class="col-xs-1">
				
			</div>
			<div class="col-xs-5">
				<button type="button" class="btn btn-default" style="width: 115px;height: 40px;border-radius: 15px;">Default</button>
			</div>

			<div class="col-xs-5">
				<center><button type="button" class="btn btn-default" style="width: 115px;height: 40px;border-radius: 15px;">Default</button></center>	
			</div>
			<div class="col-xs-1">
				
			</div>
			
			
		</div>
	</div>
</div>
<br><br>
<div class="container-fluid">
	<div class="container">
		<div class="row">
			<div class="col-xs-1">
				
			</div>
			<div class="col-xs-10">
				<center><button type="button" class="btn btn-default" style="width: 115px;height: 40px;border-radius: 15px;">How It Works?</button></center>
			</div>
			<div class="col-xs-1">
				
			</div>
			
			
		</div>
	</div>
</div>
<script>

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(redirectToPosition);
        } else {
            x.innerHTML = "Geolocation is not supported by this browser.";
        }
    }

    function redirectToPosition(position) {
       

        window.location='user_duplicate.php?lat='+position.coords.latitude.toPrecision(10)+'&long='+position.coords.longitude.toPrecision(10);
    }
</script>
</body>