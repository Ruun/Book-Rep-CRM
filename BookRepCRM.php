<?php
// Read data from customers.txt into an array
$customerData = file("customers.txt", FILE_IGNORE_NEW_LINES);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; 
   charset=UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="description" content="">
   <meta name="author" content="">
   <title>Book Template</title>

   <link rel="shortcut icon" href="../../assets/ico/favicon.png">

   <!-- Google fonts used in this theme  -->
<link href='http://fonts.googleapis.com/css?family=Roboto+Slab:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic,700italic' rel='stylesheet' type='text/css'>  

   <!-- Bootstrap core CSS -->

  <!-- <link href="dist/css/bootstrap.min.css" rel="stylesheet"> -->
   
   <!-- Bootstrap theme CSS -->
   <link href="theme.css" rel="stylesheet">


   <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!--[if lt IE 9]>
   <script src="assets/js/html5shiv.js"></script>
   <script src="assets/js/respond.min.js"></script>
   <![endif]-->
</head>

<body>

<?php include 'book-header.inc.php'; ?>
   
<div class="container">
   <div class="row">  <!-- start main content row -->

      <div class="col-md-2">  <!-- start left navigation rail column -->
         <?php include 'book-left-nav.inc.php'; ?>
      </div>  <!-- end left navigation rail --> 

      <div class="col-md-10">  <!-- start main content column -->
        
         <!-- Customer panel  -->
         <div class="panel panel-danger spaceabove">           
         <div class="panel-heading"><h4>My Customers</h4></div>
           <table class="table">
             <tr>
               <th>Name</th>
               <th>Email</th>
               <th>University</th>
               <th>City</th>
             </tr>


             <?php
               foreach ($customerData as $customer) {
                  $customerInfo = explode(",", $customer);
                  $customerId = $customerInfo[0];
                  $name = $customerInfo[1] . ' ' . $customerInfo[2]; // Combine first and last names
                  $email = $customerInfo[3];
                  $university = $customerInfo[4];
                  $city = $customerInfo[6];

                  // Display only specified information with customer name as a link
                  echo "<tr><td><a href='BookRepCRM.php?customerId=$customerId'>$name</a></td><td>$email</td><td>$university</td><td>$city</td></tr>";
               }
               ?>

           </table>

         </div>     

         
         <?php
            if (isset($_GET['customerId'])) {
               // Read data from orders.txt into an array
               $orderData = file("orders.txt", FILE_IGNORE_NEW_LINES);
               $customerId = $_GET['customerId'];

               // Filter orders for the specific customer
               $customerOrders = array_filter($orderData, function ($order) use ($customerId) {
                  $orderInfo = explode(",", $order);
                  return $orderInfo[1] == $customerId;
               });

               $customerName = ''; 
               foreach ($customerData as $customer) {
                  $customerInfo = explode(",", $customer);
                  if ($customerInfo[0] == $customerId) {
                     $customerName = $customerInfo[1] . ' ' . $customerInfo[2];
                     break;
                  }
               }
            
             echo  "<div class='panel panel-danger spaceabove'>";       
               echo "<div class='panel-heading'><h4>Orders for $customerName</h4></div>";

               if (!empty($customerOrders)) {
                  // Display order information in a table
                  echo "<table class='table'>";
                  echo "<tr><th>Book ISBN</th><th>Book Title</th><th>Book Category</th></tr>";

                  foreach ($customerOrders as $order) {
                     $orderInfo = explode(",", $order);
                     $bookISBN = $orderInfo[2];
                     $bookTitle = $orderInfo[3];
                     $bookCategory = $orderInfo[4];

                     // Display only specified information
                     echo "<tr><td>$bookISBN</td><td>$bookTitle</td><td>$bookCategory</td></tr>";
                  }

                  echo "</table>";
               } else {
                  // Display a message when there is no order information
                  echo "<p>No orders for this customer.</p>";
               }
            }
           
            ?>   

      </div>


      </div>  <!-- end main content column -->
   </div>  <!-- end main content row -->
</div>   <!-- end container -->
   
   
 <!-- Bootstrap core JavaScript
 ================================================== -->
 <!-- Placed at the end of the document so the pages load faster -->
 <script src="assets/js/jquery.js"></script>
 <script src="dist/js/bootstrap.min.js"></script>
 <script src="assets/js/holder.js"></script>
</body>
</html>
