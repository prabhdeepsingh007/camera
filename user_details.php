<?php

include 'function.php';
include 'database.php';

$hid=(isset($_GET['hid']))?$_GET['hid']:'';
$dist=(isset($_GET['dist']))?$_GET['dist']:'';

echo $hid;

$sqlhos = "SELECT * FROM hospital_data WHERE hid='$hid'";

$resulthos = $db-> query($sqlhos);
$row_hos = $resulthos->fetch_assoc();

$hname=$row_hos['username'];
$tel1=$row_hos['pnum'];
$hospital=$row_hos['hospital_name'];
echo $hospital;
$address=$row_hos['address'];

$sq_acc2="SELECT * from auto_driver WHERE conf='1'";
$result3 = $db-> query($sq_acc2);
$row3 = $result3->fetch_assoc();
$conf=$row3['conf'];
$tel=$row3['telephone'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Details to the User</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<meta http-equiv="refresh" content="5">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDCXYaYdHCFFhsctcSBpipkmuvAPVgu6uM&libraries=places" type="text/javascript"></script>
    <script src="hospital.js"></script>
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  	<style type="text/css">

  	.card {
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
      width: 100%;
    height: 75px;
}

.card:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.contain {
  padding: 2px 16px;
}

.card1 {
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
      
    height: 220px;
}

.card1:hover {
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.contain1 {
  padding: 2px 16px;
}
  		
  	</style>
</head>
<body>
<div class="container-fluid" style="background-color: #0077A4">
	<br>
	
		<div class="row">
			<?php 
			if($conf==0)
			{
			?>
			<div class="col-xs-6">
				<p style="font-size: 23px;font-family: roboto;color: white;"><b>Hold on.</b></p>
			</div>


			<div class="col-xs-3">
				
			</div>
			<div class="col-xs-3">
				<center><button type="button" class="btn btn-default" style="border-radius: 50%;background-color: #0077A4;"><a href="#" style="text-decoration: none;color: blue;"><b style="color: white">X</b></a></button></center>
			</div>

			<?php
			}
			else if($conf==1)
			{
			?>
			<div class="col-xs-6">
				<p style="font-size: 23px;font-family: roboto;color: white;"><b>You are doing great.</b></p>
			</div>
			

			<div class="col-xs-3">
				
			</div>
			<div class="col-xs-3">
				<center><button type="button" class="btn btn-default" style="border-radius: 50%;background-color: #0077A4;"><a href="#" style="text-decoration: none;color: blue;"><b style="color: white">X</b></a></button></center>
			</div>

			<?php
			}
			?>

		

		<br>
		<br>

		<div class="container">
			<div class="row">

				<div class="col-xs-12">
					<?php 
					if($conf==0)
					{
					?>
					<p style="color: white;font-family: roboto;">Searching for Help  .</p>
					<?php
					}
					else if($conf==1)
					{ 
					?>
					<p style="color: white;font-family: roboto;">Help is on its way  .</p>
					<?php }
					?>
				</div>
			</div>
		</div>

		
		<!-- This code will come under if and else of the confirmation part of auto and is mapped with the database that whether the auto driver has confirmed or not.-->
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<?php 
					if($conf==0)
					{
					?>
					<img src="30.gif" style="width">
					<?php
					}
					else if($conf==1)
					{
					?>
					
					<?php
					}
					?>
				</div>
			</div>
		</div>

		<br>
	</div>
</div>

<br>
<?php 

if($conf==0)
{
?>
<div class="container-fluid" style="margin-top: 10px;">
	
		<div class="row">
			<div class="col-xs-12">
				<div class="card">
				  <div class="contain">
				    <p style="    line-height: 62px;font-family: roboto;font-size: 17px;color: #acacac;">Driver Details will appear here.</p> 
				  </div>
				</div>
		    </div>
			
		</div>	
		
</div>
<?php 
}
else if($conf==1)
{
?>
<div class="container-fluid" style="margin-top: 10px;">
	
	<div class="card">
		<div class="contain">
			<br>
			<div class="row">
				<div class="col-xs-2">
					<img src="phone.png" style="width:30px;">
				</div>
				<div class="col-xs-2">
					<p style="margin-left: -19px;font-family: roboto;color:black;"><?php echo $tel; ?></p>
				</div>
				<div class="col-xs-2"> 
					
				</div>

				<div class="col-xs-6">
					<p style="float: right;font-family: roboto;color: #005DFF">Call Driver Now ></p>
				</div>
			</div>
		</div>
			
	</div>	
		
</div>
<?php
}?>

<br>
<div class="container-fluid" style="margin-top: 10px;">
  <div class="card1">
    <div class="contain1">
      <div class="row">
      
        <div class="col-xs-3"> 
        <br>  
          <img src="hospital.jpg" style="width: 120px;border-radius: 9px;height: 103px;">    
        </div>

        <div class="col-xs-2">
          
        </div>

        <div class="col-xs-7">
          <br>
           <p>Nearest Hospital</p>
           <p style="font-size: 18px;line-height: 17px;"><b><?php echo $hospital; ?></b></p>
           <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="height: 44px;width: 142px;background-color: #0077A4;"><label style="font-family: roboto;">Address</label></button>

           <div class="modal fade" id="myModal" role="dialog" style="top: 240px;">
              <div class="modal-dialog">
    
      <!-- Modal content-->
                  <div class="modal-content">
                    
                    <div class="modal-body">
                        <p><?php echo $address; ?></p>
                    </div>
                    
                  </div>
      
              </div>
            </div>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-xs-2">
          <img src="phone.png" style="width:30px;">
        </div>
        <div class="col-xs-2">
          <p style="margin-left: -19px;font-family: roboto;"><?php echo $tel1; ?></p>
        </div>
        <div class="col-xs-2"> 
          
        </div>

        <div class="col-xs-6">
          <p style="float: right;font-family: roboto;color: #005DFF">Call Hospital Now</p>
        </div>
      </div>

      <br>
      <div class="row">
        <div class="col-xs-2">
          <img src="navigation.png" style="width:24px;">
        </div>
        <div class="col-xs-2">
          <p style="margin-left: -19px;font-family: roboto;"><?php echo $dist; ?></p>
        </div>
        <div class="col-xs-2"> 
          
        </div>

        <div class="col-xs-6">
          <p style="float: right;font-family: roboto;color: #005DFF">Navigate to Hospital</p>
        </div>
      </div>


    </div>
  </div>    
</div>  
    
</div>


<br>
<div class="container-fluid" style="margin-top: 10px;">
	<div class="container">
		<div class="row">
			<a href="#"><div class="card1" style="height:100px;">
				<div class="contain1">
					<div class="col-xs-2"> 
					<br>	
						<img src="camera.png" style="    width: 70px;border-radius: 9px;">    
					</div>

					<div class="col-xs-2">
						
					</div>

					<div class="col-xs-8">
						<br><br>
						<h4 style="color: #707070;font-family: roboto;"><b>Upload Image Here..</b></h4>
					</div>
				</div>
			</div></a>
		 </div>
			
		</div>	
	</div>	
</div>

</body>
</html>