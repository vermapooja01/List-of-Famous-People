<html>
<head>
<link href="application.css" type="text/css" rel="stylesheet"/>
  <title>Famous People</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<div id="wrapper">

<div id="text_div">
 <div class = "container">
 <div class = "col-sm-12">
 <div class = "well">
 <form method="post" action="index.php">
  <pre>
  <label>Full Name:</label> <input type="text" name="name" placeholder="Name">
  <label>Photo URL:</label> <input type="text" name="img_url" placeholder="Enter Image URL">
  <input class="btn btn-primary" type="submit" name="get_image" value="Create">
  </pre>
 </form>
</div>
</div>
</div>
</div>
<?php
$hn = 'localhost';
$db = 'test2';
$un = 'root';
$pw = '';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);
  
if((isset($_POST['get_image']))&&
   (isset($_POST['img_url']))&&
    (isset($_POST['name']))){
	
        $url=$_POST['img_url'];
        $name=$_POST['name'];
        $image_path=$url;
  
    $query    = "INSERT INTO data VALUES" . "(0, '$name', '$image_path')";
    $result   = $conn->query($query);

    if (!$result){ echo "INSERT failed: $query<br>" . $conn->error . "<br><br>";}
	//unset($_POST['get_image']);
	
    header('Location: index.php');
    exit;	
}
	
if(isset($_POST['del_image'])){
	
  $name=$_POST['dname'];
  $id=$_POST['id'];
 
  $query    = "delete from data where id="."'$id'";
  $result   = $conn->query($query);

if (!$result){ echo "DELETION failed: $query<br>" . $conn->error . "<br><br>";}
}
  
$query="SELECT * FROM data";
$result=$conn -> query($query);
if (!$result) die ("Database access failed: " . $conn->error);

  $rows = $result->num_rows;
  
  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);
echo <<<_END
<div class = "container">
<div class = "row">
<div class = "col-sm-12">
    <div class = "card">
    <pre>
    <span>
    $row[1]
    <br></br>
    <img src=' $row[2]' />
    <form action="index.php" method="post">
    <input type="hidden" name="delete" value="yes">
    <input type="hidden" name="dname" value="$row[1]">
    <input type="hidden" name="id" value="$row[0]">
    <input class="btn btn-primary" type="submit" name="del_image" value="DELETE">
    </form>
    </span>
    </pre>
    </div>
</div>
</div>
</div>

_END;

}
$conn->close();
?>
</div>
</body>
</html>