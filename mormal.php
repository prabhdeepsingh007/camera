<?php
include 'function.php';
include 'database.php';
include 'genrate_api.php';
include 'test.php';





if (!isset($_SESSION["visits"]))
{
  $_SESSION["visits"] = 0;
  $refresh=0;

}



$_SESSION["visits"] = $_SESSION["visits"] + 1;

echo $_SESSION["visits"]; 
 
if ($_SESSION["visits"] > 1)
{
    $refresh=1;
    echo $refresh.'    ';
    session_unset();
    session_destroy();
}
else
{
    $refresh=0;
}



$c=0;
$lat2=(isset($_GET['lat']))?$_GET['lat']:'';
$long2=(isset($_GET['long']))?$_GET['long']:'';

$txt=(isset($_GET['txt']))?$_GET['txt']:'';


// $json = file_get_contents("http://127.0.0.1:5000/$lat2,$long2");
// $obj = json_decode($json);

$result = get_data($lat2,$long2/*,distance range: 500-2000*/);
$lath_loc=$result['0']['lat'];
$longh_loc=$result['0']['lng'];

$hid=$result['0']['id'];
//Normal Insertion of data
$sql_acc = "SELECT * FROM accident";
$result_acc = $db-> query($sql_acc);
if($result_acc->num_rows>0)
{
    while($row = $result_acc->fetch_assoc())
    {
    if($row['lat_v']!=$lat2 && $row['lang_v']!=$long2)
    {
        $sql = "INSERT INTO accident (lat_v,lang_v,lat_h,lang_h,count,autonumber,hid) VALUES ('$lat2','$long2','$lath_loc','$longh_loc','0','1',$hid')";
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

if($refresh==0)
{
  for($i=0;$i<1;$i++)
  {
    $sql_au = "INSERT INTO accident_update (lat_v,lang_v,lat_h,lang_h,count,hid) VALUES ('$lat2','$long2','$lath_loc','$longh_loc','0','$hid')";
          if ($db->query($sql_au) === TRUE)
          {    
          
              echo "<script> alert('Inserted'); </script>";
          }
          else
          {
              echo "<script> alert('Not Inserted'); </script>";
          }
  }
}
else
{
  session_unset();
}

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

    echo $dist[$i];


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
       

         if($refresh==0)
        {
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
          }
      
        


        }
      }
    } 

    
  }
  else if($dist[$i]<=2)
  {
    echo $dist[$i];
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

         if($refresh==0)
        {
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
        
      }
      }
    }
    
  }
  else if($dist[$i]<=3)
  {
    echo $dist[$i];
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
      

         if($refresh==0)
        {
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
      }
      }
    }
    
  }
  else if($dist[$i]<=4)
  {
    echo $dist[$i];
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

        if($refresh==0)
        {
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
      }
      }
    }
   
  }
  else if($dist[$i]<=5)
  {
    echo $dist[$i];
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
         
        if($refresh==0)
        {
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
      }
      }
    }
     
  }
}

}
?>
 <!-- <div id="map"></div>
  <script type="text/javascript">

let map;
// // global array to store the marker object 
 let markersArray = [];

function initMap() {

  map = new google.maps.Map(document.getElementById('map'), {


    center: {lat:<?php echo $lat2 ;?> ,lng: <?php echo $long2 ;?>},
    zoom: 13
  });
  var queryString = decodeURIComponent(window.location.search);

queryString = queryString.substring(1);
var queries = queryString.split('&');
var a=parseFloat(queries[0]);
var b=parseFloat(queries[1]);

  <?php  for($i=0;$i<sizeof($ta);$i++)
  {
  ?>
  addMarker(<?php echo $lata[$i];?>,<?php echo $lnga[$i]; ?>,'green');
  <?php }?>

  addMarker(<?php echo $lat2 ;?>,<?php echo $long2 ;?>,'red');


}

function addMarker(Lat,Lng, color) {
  let url = 'http://maps.google.com/mapfiles/ms/icons/';
  url += color + '-dot.png';
  var latLng={lat:Lat,lng:Lng};
    let marker = new google.maps.Marker({
    map: map,
    position: latLng,
    icon: {
      url: url
    }
  });

  //store the marker object drawn in global array
  markersArray.push(marker);
}

</script> -->



