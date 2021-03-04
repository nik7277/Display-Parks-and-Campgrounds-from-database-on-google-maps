<?php
require("dbinfo.php");

// Start XML file, create parent node

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

// Opens a connection to a MySQL server

$connection = mysqli_connect('localhost',$username,$password,$database);
if (!$connection) {  die('Not connected : ' . mysql_error());}


// Select all the rows in the markers table

$query = "SELECT * FROM markers WHERE 1";
$result = mysqli_query($connection,$query);
if (!$result) {
  die('Invalid query: ' . mysql_error());
}


// Iterate through the rows, adding XML nodes for each

while ($row = mysqli_fetch_array($result)){
  // Add to XML document node
  $node = $dom->createElement("marker");
  $newnode = $parnode->appendChild($node);
  $newnode->setAttribute("id",$row['id']);
  $newnode->setAttribute("name",$row['name']);
  $newnode->setAttribute("address", $row['address']);
  $newnode->setAttribute("lat", $row['lat']);
  $newnode->setAttribute("lng", $row['lng']);
  $newnode->setAttribute("type", $row['type']);
}

$xmlString = $dom->saveXML();

$xml = simplexml_load_string($xmlString);

$json = json_encode($xml);

echo $json;

?>