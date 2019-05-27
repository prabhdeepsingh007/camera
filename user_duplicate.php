<?php
include 'function.php';
include 'database.php';
include 'genrate_api.php';
include 'test.php';





// if (!isset($_SESSION["visits"]))
// {
//   $_SESSION["visits"] = 0;
//   $refresh=0;

// }



// $_SESSION["visits"] = $_SESSION["visits"] + 1;

// echo $_SESSION["visits"]; 
 
// if ($_SESSION["visits"] > 1)
// {
//     $refresh=1;
//     echo $refresh.'    ';
//     session_unset();
//     session_destroy();
// }
// else
// {
//     $refresh=0;
// }



$c=0;
$lat2=(isset($_GET['lat']))?$_GET['lat']:'';
$long2=(isset($_GET['long']))?$_GET['long']:'';

$lat2=number_format($lat2, 4, '.', '');

$long2=number_format($long2, 4, '.', '');



// $json = file_get_contents("http://127.0.0.1:5000/$lat2,$long2");
// $obj = json_decode($json);

$result = get_data($lat2,$long2/*,distance range: 500-2000*/);
$lath_loc=$result['0']['lat'];
$longh_loc=$result['0']['lng'];
$dist_h=$result['0']['distance'];



$hid=$result['0']['id'];

//Normal Insertion of data


$sqlhos = "SELECT * FROM hospital_data WHERE hid='$hid'";

$resulthos = $db-> query($sqlhos);
$row_hos = $resulthos->fetch_assoc();

$hname=$row_hos['username'];
$tel=$row_hos['pnum'];
$hospital=$row_hos['hospital_name'];
$address=$row_hos['address'];




$sql_acc = "SELECT * FROM accident";
$result_acc = $db-> query($sql_acc);
if($result_acc->num_rows>0)
{
    while($row = $result_acc->fetch_assoc())
    {
    if($row['lat_v']!=$lat2 && $row['lang_v']!=$long2)
    {
        $sql = "INSERT INTO accident (lat_v,lang_v,lat_h,lang_h,count,autonumber,hid) VALUES ('$lat2','$long2','$lath_loc','$longh_loc','0','1','$hid')";
        if ($db->query($sql) === TRUE)
        {    
        
            echo "<script> alert('Inserted into accident'); </script>";
        }
        else
        {
            echo "<script> alert('Not Inserted into accident'); </script>";
        } 
    }
      
    else
    {
      $c=1;
        echo "<script> alert('Already Inserted into accident');</script>";
    }  
  }
}
else
{
  $sql = "INSERT INTO accident (lat_v,lang_v,lat_h,lang_h,count,autonumber,hid) VALUES ('$lat2','$long2','$lath_loc','$longh_loc','0','1','$hid')";
        if ($db->query($sql) === TRUE)
        {    
        
            echo "<script> alert('Inserted'); </script>";
        }
        else
        {
            echo "<script> alert('Not Inserted'); </script>";
        }
}

// Normal insertion gets over

    

//Multiple Insertion Stopage Code::




//Multiple Insertion Stopage Code Stops here: 
//accident_update gets insertion of values $person times::

// if($refresh==0)
// {

$sql_acup = "SELECT * FROM accident_update";
$result_acup = $db-> query($sql_acup);
if($result_acup->num_rows>0)
{
    while($row_ap = $result_acup->fetch_assoc())
    {
    if($row_ap['lat_v']!=$lat2 && $row_ap['long_v']!=$long2)
    {
         $sql_aup = "INSERT INTO accident_update (lat_v,lang_v,lat_h,lang_h,count,hid) VALUES ('$lat2','$long2','$lath_loc','$longh_loc','0','$hid')";
          if ($db->query($sql_aup) === TRUE)
          {    
          
              echo "<script> alert('Inserted'); </script>";
          }
          else
          {
              echo "<script> alert('Not Inserted'); </script>";
          }
    }
      
    else
    {
      $c=1;
        echo "<script> alert('Already Inserted into accident');</script>";
    }  
  }
}
else
{
   $sql_aup = "INSERT INTO accident_update (lat_v,lang_v,lat_h,lang_h,count,hid) VALUES ('$lat2','$long2','$lath_loc','$longh_loc','0','$hid')";
          if ($db->query($sql_aup) === TRUE)
          {    
          
              echo "<script> alert('Inserted'); </script>";
          }
          else
          {
              echo "<script> alert('Already Inserted'); </script>";
          }
}



  // for($i=0;$i<1;$i++)
  // {
  //   $sql_au = "INSERT INTO accident_update (lat_v,lang_v,lat_h,lang_h,count,hid) VALUES ('$lat2','$long2','$lath_loc','$longh_loc','0','$hid')";
  //         if ($db->query($sql_au) === TRUE)
  //         {    
          
  //             echo "<script> alert('Inserted'); </script>";
  //         }
  //         else
  //         {
  //             echo "<script> alert('Not Inserted'); </script>";
  //         }
  // }
// }

//Multiple insertion gets over
?>

<?php

$ta = array();
$lata=array();
$lnga=array();
$dist=array();
$val  = get_ip_address("http://www.auctionbaazar.com//tracker_service/api.php?Getdata");

$a=array("\"status\": \"1\",\"message\": \"Success\",");
$s=str_replace($a,"\"Coords\": ",$val);
$dec= json_decode($s,True);
$length=sizeof($dec['Coords']);



for($i=0;$i<$length;$i++)
{


$telephone = $dec['Coords'][$i]['dm_phone1'];
$lat =$dec['Coords'][$i]['dm_latitude'];
$lng =$dec['Coords'][$i]['dm_longitude'];
$ta[$i]=$telephone;
$lata[$i]=$lat;
$lnga[$i]=$lng;


}
?>

<?php

 function get_ip_address($value)
 {
   $content = file_get_contents($value);
   $result  = $content;
   return $result;
 }

function GetDrivingDistance($lat1, $lat2, $long1, $long2)
{
  error_reporting(E_ERROR | E_PARSE);
$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=pl-PL&key=AIzaSyDCXYaYdHCFFhsctcSBpipkmuvAPVgu6uM";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);

    curl_close($ch);
      $response_a = json_decode($response, true);
      
      $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
      $time = $response_a['rows'][0]['elements'][0]['duration']['text'];
      return array('distance' => $dist, 'time' => $time);

}

for($i=0;$i<$length;$i++)
{
   

      $longitude=$lnga[$i];
      $latitude=$lata[$i];
     
         $distance = GetDrivingDistance($lat2,$latitude,$long2,$longitude);
        $dist[$i]=$distance['distance'];
        
}
for($i=0;$i<$length;$i++)
{
  for($j=$i+1;$j<$length;$j++)
  {
    if($dist[$i]>$dist[$j])
    {
      $t=$dist[$i];
      $dist[$i]=$dist[$j];
      $dist[$j]=$t;

      $t=$ta[$i];
      $ta[$i]=$ta[$j];
      $ta[$j]=$t;
      
      $t=$lata[$i];
      $lata[$i]=$lata[$j];
      $lata[$j]=$t;

      $t=$lnga[$i];
      $lnga[$i]=$lnga[$j];
      $lnga[$j]=$t;

    }
  }
}

if($c==0)
{
for($i=0;$i<$length;$i++)
{

  if($dist[$i]<=1)
  {

   


    $sql2 = "SELECT * FROM accident WHERE lat_v='$lat2' and lang_v='$long2'";
    $result2 = $db-> query($sql2);
    if($result2->num_rows>0)
    {
      while($row = $result2->fetch_assoc()) 
      {
        if($row['count']=='0')
        {


                   
         $test = "0";
         
         $l1=$lata[$i];
         $l2=$lnga[$i];
       

        //  if($refresh==0)
        // {
           $m1="Emergency Please Help Give Your Conformation!";      
            $mobile=$ta[$i];
            $msg="Emergency Please Help Give Your Conformation!";
          //echo SendSMS("$mobile","$msg"); Update to firebase.

                 

              $sql1 = "INSERT INTO auto_driver (telephone,message,conf,lat_v,long_v,lat_a,lang_a) VALUES ('$ta[$i]','$m1','2','$lat2','$long2','$lata[$i]','$lnga[$i]')";
              if ($db->query($sql1) === TRUE)
              {    
                echo "<script> alert('Inserted');</script>";
              }
              else
              {
                 echo "<script> alert('Not Inserted');</script>";
              }
          // }
      
        


        }
      }
    } 

    
  }
  else if($dist[$i]<=2)
  {
  


    $sql2 = "SELECT * FROM accident WHERE lat_v='$lat2' and lang_v='$long2'";
    $result2 = $db-> query($sql2);
    if($result2->num_rows>0)
    {
      while($row = $result2->fetch_assoc()) 
      {
        if($row['count']=='0')
        {
                      
         $test = "0";
         
         $l1=$lata[$i];
         $l2=$lnga[$i];

        //  if($refresh==0)
        // {
         $m1="Emergency Please Help Give Your Conformation!";      
          $mobile=$ta[$i];
        $msg="Emergency Please Help Give Your Conformation!";
        

           $sql1 = "INSERT INTO auto_driver (telephone,message,conf,lat_v,long_v,lat_a,lang_a) VALUES ('$ta[$i]','$m1','2','$lat2','$long2','$lata[$i]','$lnga[$i]')";
          if ($db->query($sql1) === TRUE)
          {    
            echo "<script> alert('Inserted');</script>";
          }
          else
          {
             echo "<script> alert('Not Inserted');</script>";
          }
         
        }
        
      // }
      }
    }
    
  }
  else if($dist[$i]<=3)
  {
 
    $sql2 = "SELECT * FROM accident WHERE lat_v='$lat2' and lang_v='$long2'";
    $result2 = $db-> query($sql2);
    if($result2->num_rows>0)
    {
      while($row = $result2->fetch_assoc()) 
      {
        if($row['count']=='0')
        {
         $test = "0";
        
         $l1=$lata[$i];
         $l2=$lnga[$i];
      

        //  if($refresh==0)
        // {
         $m1="Emergency Please Help Give Your Conformation!";      
          $mobile=$ta[$i];
        $msg="Emergency Please Help Give Your Conformation!";
        //echo SendSMS("$mobile","$msg");

           $sql1 = "INSERT INTO auto_driver (telephone,message,conf,lat_v,long_v,lat_a,lang_a) VALUES ('$ta[$i]','$m1','2','$lat2','$long2','$lata[$i]','$lnga[$i]')";
          if ($db->query($sql1) === TRUE)
          {    
            echo "<script> alert('Inserted');</script>";
          }
          else
          {
             echo "<script> alert('Not Inserted');</script>";
          }
      
         
        }
      // }
      }
    }
    
  }
  else if($dist[$i]<=4)
  {
    
    $sql2 = "SELECT * FROM accident WHERE lat_v='$lat2' and lang_v='$long2'";
    $result2 = $db-> query($sql2);
    if($result2->num_rows>0)
    {
      while($row = $result2->fetch_assoc()) 
      {
        if($row['count']=='0')
        {
                 
         $test = "0";
         $l1=$lata[$i];
         $l2=$lnga[$i];

        // if($refresh==0)
        // {
         $m1="Emergency Please Help Give Your Conformation!";      
          $mobile=$ta[$i];
        $msg="Emergency Please Help Give Your Conformation!";
        //echo SendSMS("$mobile","$msg");           

          $sql1 = "INSERT INTO auto_driver (telephone,message,conf,lat_v,long_v,lat_a,lang_a) VALUES ('$ta[$i]','$m1','2','$lat2','$long2','$lata[$i]','$lnga[$i]')";
          if ($db->query($sql1) === TRUE)
          {    
            echo "<script> alert('Inserted');</script>";
          }
          else
          {
             echo "<script> alert('Not Inserted');</script>";
          }
  
         
        }
      // }
      }
    }
   
  }
  else if($dist[$i]<=5)
  {
   
    $sql2 = "SELECT * FROM accident WHERE lat_v='$lat2' and lang_v='$long2'";
    $result2 = $db-> query($sql2);
    if($result2->num_rows>0)
    {
      while($row = $result2->fetch_assoc()) 
      {
        if($row['count']=='0')
        {
                 
         $test = "0";
         
         $l1=$lata[$i];
         $l2=$lnga[$i];
         
        // if($refresh==0)
        // {
         $m1="Emergency Please Help Give Your Conformation!";      
          $mobile=$ta[$i];
        $msg="Emergency Please Help Give Your Conformation!";
        //echo SendSMS("$mobile","$msg");           

          $sql1 = "INSERT INTO auto_driver (telephone,message,conf,lat_v,long_v,lat_a,lang_a) VALUES ('$ta[$i]','$m1','2','$lat2','$long2','$lata[$i]','$lnga[$i]')";
          if ($db->query($sql1) === TRUE)
          {    
            echo "<script> alert('Inserted');</script>";
          }
          else
          {
             echo "<script> alert('Not Inserted');</script>";
          }
          
        
         
        }
      // }
      }
    }
     
  }
}

}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Details to the User</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
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
			if(true)
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
			else
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
					<p style="color: white;font-family: roboto;">Searching for Help  .</p>
				</div>
			</div>
		</div>

		
		<!-- This code will come under if and else of the confirmation part of auto and is mapped with the database that whether the auto driver has confirmed or not.-->
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<img src="30.gif" style="width">
				</div>
			</div>
		</div>

		<br>
	</div>
</div>

<br>
<?php 
$a=1;
if($a==1)
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
else
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
					<p style="margin-left: -19px;font-family: roboto;">912345678</p>
				</div>
				<div class="col-xs-2"> 
					
				</div>

				<div class="col-xs-6">
					<p style="float: right;font-family: roboto;color: #005DFF">Call Driver Now</p>
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
          <p style="margin-left: -19px;font-family: roboto;"><?php echo $tel; ?></p>
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
          <p style="margin-left: -19px;font-family: roboto;"><?php echo $dist_h; ?></p>
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


<script type="text/javascript">

   var hid="<?php echo $hid; ?>";
   var dist="<?php echo $dist_h; ?>";

   window.location='user_details.php?hid='+hid+'&dist='+dist;
</script>
</body>
</html>