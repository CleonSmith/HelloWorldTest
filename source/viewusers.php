<?php
$servername = 'mysql.flyover-games.com';
$username = 'helloworld_admin';
$password = 'helloworld';
$dbname = 'helloworld_registrationtest';
$tablename = 'registeredusers';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT firstname, lastname, address1, address2, city, state, zip, country, timestamp FROM $tablename ORDER BY id DESC";
$result = $conn->query($sql);

//echo "First Name\tLast Name\tAddress1\tAddress2\tCity\tState\tZip\tCountry\tDate <br>";

echo "<style>
table, th, td {
    border: 1px solid black;
}
</style>
</head>
<body>

<table style=\"width:100%\">
  <tr>
    <th>First Name</th>
    <th>Last Name</th>
	<th>Address1</th>
	<th>Address2</th>
	<th>City</th>
	<th>State</th>
	<th>Zip</th>
	<th>Country</th>
	<th>Date</th>
  </tr>";

 if ($result->num_rows > 0) 
 {
//    output data of each row
    while($row = $result->fetch_assoc()) 
	{
		echo "<tr>";
		echo "<td>" . $row["firstname"] . "</td>";
		echo "<td>" . $row["lastname"] . "</td>";
		echo "<td>" . $row["address1"] . "</td>";
		echo "<td>" . $row["address2"] . "</td>";
		echo "<td>" . $row["city"] . "</td>";
		echo "<td>" . $row["state"] . "</td>";
		echo "<td>" . $row["zip"] . "</td>";
		echo "<td>" . $row["country"] . "</td>";
		echo "<td>" . $row["timestamp"] . "</td>";
		echo "</tr>";
	}
 } 
 else 
 {
 
     echo "0 results";
 }

echo "</table>";

 $conn->close();
 ?>