<?php
/*
*Author: Kevin Barasa
*Phone : +254724778017
*Email : kevin.barasa001@gmail.com
*/
error_reporting(0);
  // Reads the variables sent via POST from our gateway
  $sessionId   = $_POST["sessionId"];
  $serviceCode = $_POST["serviceCode"];
  $phoneNumber = $_POST["phoneNumber"];
  $text        = $_POST["text"];
  //create data fields  
  $pNumber="";  
  $shopNumber="";   
  
  $level =0;  
  
  if($text != ""){  
  $text=  str_replace("#", "*", $text);  
  $text_explode = explode("*", $text);  
  $level = count($text_explode);  
  }  
  
if ($level==0){  
    $response  = "CON Welcome to EsVendo products \n";
    $response .= "1. Sanitary towels \n";
    $response .= "2. Diapers";  
    //End of the level 
    } 


  if ($level>0){  
      switch ($text_explode[0])  {  
          case 1:  
              nest_pads($text_explode, $phoneNumber);
          case 2:  
              nest_diapers($text_explode, $phoneNumber);
          break;  
      }  
  } 
  
  function displayPads(){  
       $ussd_text  = "CON How many sanitary towels do you need? \n1. 1 pad @10sh \n2. 3 pads @25sh \n3. 6 pads @50sh \n4. 10 pads @85sh";
       ussd_proceed($ussd_text);  
  }
  function displayDiapers(){  
       $ussd_text  = "CON How many diapers do you need? \n1. 1 diaper @30sh \n2. 3 diapers @55sh \n3. 6 diapers @120sh \n4. 10 diapers @205sh";
       ussd_proceed($ussd_text);  
  }
  function ussd_proceed ($ussd_text){  
      echo $ussd_text;  
  }
  
  //Display Pads 
  function nest_pads($details,$pNumber){  
    if (count($details)==1){  
      $ussd_text= displayPads();  
      ussd_proceed($ussd_text);  
      } 
      else if (count($details)==2){  
      $ussd_text="CON \n Enter Shop Agent Number";  
      ussd_proceed($ussd_text);  
      }  
      else if(count($details) == 3){  
      $ussd_text = "CON \n1. Confirm Transaction \n2. Abort";  
      ussd_proceed($ussd_text);  
      }
      else if(count($details) == 4){  
      $numberBought=$details[1]; 
      $shopNumber=$details[2];  
      $retval = $details[3];
      if($numberBought=="1"){  
      $item="1 pad @5sh";  
      }else if($numberBought=="2"){  
      $item="3 pads @15sh";  
      }else if($numberBought=="3"){  
      $item="6 pads @30sh";  
      }else if($numberBought=="4"){  
      $item="10 pads @50sh";  
      }
      if($retval=="1"){  
      //=================Do your business logic here=========================== 
        include 'database.php'; 
        $pdo = Database::connect();
        $sql = "SELECT * FROM kiosks WHERE `agent_no` = '$shopNumber'";
        $check = $pdo->query($sql);
        $found = count($check);
        if ($found) {
            foreach ($check as $row) {
                $shop = $row['name'];
                $phone = $row['phone'];
              //Remember to put "END" at the start of each echo statement that comes here  
              echo "END You are buying ".$item." from ".$shop." of ". $row['region'] ." \n\n<Please repay before 3rd March 2016>";  
              include('messaging.php');
            } 
        } 
        //if (!$found){echo "END The Agent Number doesn't exist!";}
        Database::disconnect();
      }else{
      //Choice is cancel  
      $ussd_text = "END You have cancelled the transaction";  
      
      ussd_proceed($ussd_text);  
      }
  } 
  exit();
  } 
  
  function nest_diapers($details,$pNumber){  
     if (count($details)==1){  
      $ussd_text= displayDiapers();  
      ussd_proceed($ussd_text);  
      } 
      else if (count($details)==2){  
      $ussd_text="CON \n Enter Shop Agent Number";  
      ussd_proceed($ussd_text);  
      }  
      else if(count($details) == 3){  
      $ussd_text = "CON \n1. Confirm Transaction \n  2. Abort \n";  
      ussd_proceed($ussd_text);  
      }
      else if(count($details) == 4){  
      $numberBought=$details[1];  
      $shopNumber=$details[2];    
      $retval = $details[3];
      if($numberBought=="1"){  
      $item="1 diaper @30sh";  
      }else if($numberBought=="2"){  
      $item="3 Diapers @55sh";  
      }else if($numberBought=="3"){  
      $item="6 Diapers @120sh";  
      }else if($numberBought=="4"){  
      $item="10 Diapers @205sh";  
      }
      if($retval=="1"){  
      //=================Do your business logic here===========================  
        include 'database.php'; 
        $pdo = Database::connect();
        $sql = "SELECT * FROM kiosks WHERE `agent_no` = '$shopNumber'";
        $check = $pdo->query($sql);
        $found = count($check);
        if ($found) {
            foreach ($check as $row) {
                $shop = $row['name'];
                $phone = $row['phone'];
              //Remember to put "END" at the start of each echo statement that comes here  
              echo "END You are buying ".$item." from ".$shop." of ". $row['region'] ." \n\n<Please repay before 3rd March 2016>"; 
              include('messaging.php');
            } 
        } 
        //if (!$found){echo "END The Agent Number doesn't exist!";}
        Database::disconnect();
      }else{//Choice is cancel  
      $ussd_text = "END You have cancelled the transaction";  
      
      ussd_proceed($ussd_text);  
      }    
  } 
  exit();
  } 
  // Print the response onto the page so that our gateway can read it
  header('Content-type: text/plain');
  echo $response;
  // DONE!!!
  ?>