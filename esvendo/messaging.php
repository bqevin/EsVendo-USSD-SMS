    <?php
    // Be sure to include the file you've just downloaded
    require_once('AfricasTalkingGateway.php');
    // Specify your login credentials
    $username   = "bqevin";
    $apikey     = "65b35ee24938d70705ce7f68da3f58f4b05d828ea54cedb636d99c2ae78c1c3a";
    // Specify the numbers that you want to send to in a comma-separated list
    // Please ensure you include the country code (+254 for Kenya in this case)
    $agent = $phone;
    $client =  $_POST["phoneNumber"];
    $receipt = strtoupper(genRandomString());
    // And of course we want our recipients to know what we really do
    $messageClient = "Confirmed ".$receipt.". You have bought ".$item." from ".$shop.". \nYou can proceed to request the item with this e-receipt.\n Thank you for using EsVendo!";
    $messageAgent    = "Confirmed ".$receipt." from ".$client.". Has bought through ".$shop." ".$item."\nYou can proceed to give them the item in this e-receipt.\n Thank you for being EsVendo partner!";             
    // Create a new instance of our awesome gateway class
    $gateway    = new AfricasTalkingGateway($username, $apikey);
    // Any gateway error will be captured by our custom Exception class below, 
    // so wrap the call in a try-catch block
    try 
    { 
      // Thats it, hit send and we'll take care of the rest. 
      $results = $gateway->sendMessage($agent, $messageAgent);
      $results = $gateway->sendMessage($client, $messageClient);
                
      // foreach($results as $result) {
      //   // status is either "Success" or "error message"
      //   echo " Number: " .$result->number;
      //   echo " Status: " .$result->status;
      //   echo " MessageId: " .$result->messageId;
      //   echo " Cost: "   .$result->cost."\n";
      // }
    }
    catch ( AfricasTalkingGatewayException $e )
    {
      echo "Encountered an error while sending: ".$e->getMessage();
    }
    function genRandomString() {
      $length = 10;
      $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
      $string = '';
       
      for ($p = 0; $p < $length; $p++) {
      $string .= $characters[mt_rand(0, strlen($characters))];
      }
       
      return $string;
    }
    // DONE!!! 