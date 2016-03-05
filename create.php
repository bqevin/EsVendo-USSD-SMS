<?php
     
    require 'database.php';
 
    if ( !empty($_POST)) {
        // keep track validation errors
        $nameError = null;
        $emailError = null;
        $mobileError = null;
         
        // keep track post values
        $name = $_POST['name'];
        $shopNumber = $_POST['shopn'];
        $region = $_POST['region'];
        $shop = $_POST['shop'];
        $mobile = $_POST['mobile'];
         
        // validate input
        $valid = true;
        if (empty($name)) {
            $nameError = 'Please enter Name';
            $valid = false;
        }
         
        // if (empty($email)) {
        //     $emailError = 'Please enter Email Address';
        //     $valid = false;
        // } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
        //     $emailError = 'Please enter a valid Email Address';
        //     $valid = false;
        // }
         
        if (empty($mobile)) {
            $mobileError = 'Please enter Mobile Number';
            $valid = false;
        }
        if (empty($shop)) {
            $shopError = 'Please enter Shop Name';
            $valid = false;
        }
        if (empty($shopNumber)) {
            $shopnError = 'Please enter Shop Number';
            $valid = false;
        }
        if (empty($region)) {
            $regionError = 'Please enter Shop Number';
            $valid = false;
        }
         
        // insert data
        if ($valid) {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO kiosks (shopkeeper, region, phone, agent_no, name) values(?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($name, $region, $mobile, $shopNumber, $shop));
            Database::disconnect();
            echo "You have successfully registered {$shop}";
            // header("Location: index.php");
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link   href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style type="text/css" media="screen">
      td,th{padding: 5px;}
    </style>
</head>
 
<body>
    <div class="container">
     
                <div class="span10 offset1">
                    <div class="row">
                        <h3>Create an Agent</h3>
                    </div>
             
                    <form class="form-horizontal" action="create.php" method="post">
                      <div class="control-group <?php echo !empty($nameError)?'error':'';?>">
                        <label class="control-label">Name</label>
                        <div class="controls">
                            <input name="name" type="text"  placeholder="Name" value="<?php echo !empty($name)?$name:'';?>">
                            <?php if (!empty($nameError)): ?>
                                <span class="help-inline"><?php echo $nameError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($shopError)?'error':'';?>">
                        <label class="control-label">Shop Name</label>
                        <div class="controls">
                            <input name="shop" type="text"  placeholder="shop Name" value="<?php echo !empty($shop)?$shop:'';?>">
                            <?php if (!empty($shopError)): ?>
                                <span class="help-inline"><?php echo $shopError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($shopnError)?'error':'';?>">
                        <label class="control-label">Agent Number</label>
                        <div class="controls">
                            <input name="shopn" type="text"  placeholder="Agent Number" value="<?php echo !empty($shopn)?$shopn:'';?>">
                            <?php if (!empty($shopnError)): ?>
                                <span class="help-inline"><?php echo $shopnError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                      <div class="control-group <?php echo !empty($regionError)?'error':'';?>">
                        <label class="control-label">Region</label>
                        <div class="controls">
                            <input name="region" type="text"  placeholder="Region" value="<?php echo !empty($region)?$region:'';?>">
                            <?php if (!empty($regionError)): ?>
                                <span class="help-inline"><?php echo $regionError;?></span>
                            <?php endif; ?>
                        </div>
                      </div>
                     <!--  <div class="control-group <?php echo !empty($emailError)?'error':'';?>">
                        <label class="control-label">Email Address</label>
                        <div class="controls">
                            <input name="email" type="text" placeholder="Email Address" value="<?php echo !empty($email)?$email:'';?>">
                            <?php if (!empty($emailError)): ?>
                                <span class="help-inline"><?php echo $emailError;?></span>
                            <?php endif;?>
                        </div>
                      </div> -->
                      <div class="control-group <?php echo !empty($mobileError)?'error':'';?>">
                        <label class="control-label">Mobile Number</label>
                        <div class="controls">
                            <input name="mobile" type="text"  placeholder="Mobile Number" value="<?php echo !empty($mobile)?$mobile:'';?>">
                            <?php if (!empty($mobileError)): ?>
                                <span class="help-inline"><?php echo $mobileError;?></span>
                            <?php endif;?>
                        </div>
                      </div>
                      <div class="form-actions">
                          <button type="submit" class="btn btn-success">Create Shop</button>
                          <a class="btn" href="index.php">Back</a>
                        </div>
                    </form>
                </div>
                <h2>Registered Agents</h2>
                    <table class="table-bordered">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Shop</th>
                          <th>Agent No.</th>
                          <th>Phone</th>
                          <th>Region</th>
                        </tr>
                      </thead>
                      <tbody>
                <?php
                $pdo = Database::connect();
                        $sql = "SELECT * FROM kiosks ORDER BY id ASC";
                        $check = $pdo->query($sql);
                        $found = count($check);
                        if ($found) {
                            foreach ($check as $row) {
                                $shop = $row['name'];
                                $shopkeeper = $row['shopkeeper'];
                                $region = $row['region'];
                                $agent_no = $row['agent_no'];
                                $phone = $row['phone'];
                              //Remember to put "END" at the start of each echo statement that comes here  
                              echo " 
                        <tr>
                          <td>{$shopkeeper}</td>
                          <td>{$shop}</td>
                          <td>{$agent_no}</td>
                          <td>{$phone}</td>
                          <td>{$region}</td>
                        </tr>
                     ";  
                            } 
                        } 
                        //if (!$found){echo "END The Agent Number doesn't exist!";}
                        Database::disconnect();
                ?>
                 </tbody>
                    </table>
    </div> <!-- /container -->
  </body>
</html>