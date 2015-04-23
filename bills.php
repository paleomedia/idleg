<?php
$thisPage="Bills"; 
include 'top.php';
require_once("dao.php"); ?>
  
<div class="maincontainer">
   
<?php include 'dash.php'; 


// read the json file contents
 
    $jsondata = file_get_contents('http://openstates.org/api/v1/bills/?apikey=bcc2a830883c4f459dbffe94b2a3e90f&state=id&search_window=session'); 

//convert json object to php associative array
    $bills = json_decode($jsondata, true);
    
 //   echo "<pre>" . print_r($bills, 1) . "</pre>";

    $dao = new Dao();
    $connection = $dao->getConnection();
    $i = 1;
    foreach ($bills as $bill) {
        $bill_name = $bill['bill_id'];
        $year = $bill['session'];
        $title = $bill['title'];
        $bill_id = $bill['id'];
        
        echo "inserting record $i<br/>";
        $i++;
        
        $dao->saveBills($bill_id, $year, $title, $bill_name, $connection) or die(print_r($connection->errorInfo(), true));
        echo "$bill_name actually inserted</br>";
    } 
    
    
      
include 'footer.php'; ?>