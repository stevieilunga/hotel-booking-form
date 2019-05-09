

<?php

ini_set('display_errors', 1);
session_start();

?>
<!doctype <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hotel booking form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="hotel.css">
    <script src="main.js"></script>
    <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
    <script language="javascript" src="try.js"></script>

</head>

<body>
 

<?php 

require_once('connection.php');
echo $conn->error;
$sql="CREATE TABLE IF NOT EXISTS hotel(
  id INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  FirstName VARCHAR(50),
  LastName VARCHAR(50),
  hotelName VARCHAR(50),
  indate VARCHAR(30),
  outdate VARCHAR(30),
  booked INT(30)
)";
$conn->query($sql);



$firstname = $_POST['Firstname'];
$lastname = $_POST['Lastname'];
$hotel = $_POST['hotel'];
$indate = $_POST['checkin'];
$outdate = $_POST['checkout'];
$booked = $_POST['confirm'];


$sql = "INSERT INTO hotel (FirstName , LastName , hotelName , indate , outdate , booked) VALUES ( '$firstname' , '$lastname' , '$hotel', '$indate' , '$outdate' , '$booked' )";
if(mysqli_query($conn , $sql )){
  echo "success";
  //var_dump($_SESSION);
}else{
  echo "Uncess";
}


?>



  <form class="form-signin" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <h2 class="form-signin-heading">Enter you details</h2>
         <input type="text" class="form-control" placeholder="First name" name="Firstname" autofocus>
        <input type="text" class="form-control" placeholder="Last name" name="Lastname"><br><br>
        <input type="Phone" class="form-control" placeholder="Phone number" name="Phone" autofocus>
        <input type="Email" class="form-control" placeholder="Email" name="Email" autofocus><br><br>
        <input type="date" class="form-control" placeholder="checkin date" name="checkin" autofocus>
        <input type="date" class="form-control" placeholder="checkout date" name="checkout"><br><br>
        <input type="hidden" class="form-control" value="confirmed" name="confirm"><br><br>
        <select name="hotel">
          <option>Select Hotel</option>
          <option value="One and Only">One and Only</option>
          <option value="Silo Hotel">Silo Hotel</option>
          <option value="Cape Grace Hotel">Cape Grace Hotel</option>

        </select>
        <button class="btn btn-lg btn-primary btn-block" type="submit" name="btnlogin">Book now</button>
</form>



<?php



if(isset($_POST['hotel'])){
  $price = 0;

  if($_POST['hotel'] == "One and Only"){
  $price = 500;
  }elseif($_POST['hotel'] == "Silo Hotel"){
  $price = 450;
  }elseif($_POST['hotel'] == "Cape Grace Hotel"){
  $price = 358;
  }



$Firstname = $_POST['Firstname'];
$Lastname = $_POST['Lastname'];
$Phone = $_POST['Phone'];
$Email =$_POST['Email'];
$checkindate = $_POST['checkin'];
$checkoutdate = $_POST['checkout'];

$datedifference = date_diff(date_create($checkindate), date_create($checkoutdate));
$diff = $datedifference->format('%R%a days');
$total = $price * intval($diff);
}


if($_POST){
echo "<p><b>Confirm your Booking</b></p>";
echo '<p>Firstname: '.$_POST['Firstname'].'<p>';
echo '<p>Lastname: '.$_POST['Lastname'].'<p>';
echo '<p>Phone: '.$_POST['Phone'].'<p>';
echo '<p>Email: '.$_POST['Email'].'<p>';
echo '<p>Hotel:  '.$_POST['hotel'].'</p>';
echo '<p>Price:  '.$price.'</p>';
echo '<p>Days:  '.$diff.'</p>';
echo '<p>Total:  '.$total.'</p>';
echo "<form>";
echo "<button>Confirm<button>";
echo "</form>";
}



if(isset($_POST['confirm'])){
  //Preparing and binding a statement
  //prepare is method, this way we only pass the query once and then the values
  $stmt=$conn->prepare("INSERT INTO hotel (firstname,surname,hotelname,indate,outdate) VALUES (?,?,?,?,?)");
  //also part of preparing & binding these values to the questions marks.
  $stmt->bind_param('sssss', $firstname,$surname,$hotelname,$indate,$outdate);
  $firstname=$_SESSION['firstname'];
  $surname=$_SESSION['surname'];
  $hotelname=$_SESSION['hotelname'];
  $indate=$_SESSION['indate'];
  $outdate=$_SESSION['outdate'];
  $stmt->execute();
  echo "Booking confirmed";
  };
  
?>

</body>
</html>






