<?php
 
////////////////////////////// ONE USER'S DATA ACCESS ///////////////////////////////////////

require "db.php";
 
// fuction Transaction($user_id = null)
// {
//     if ($user_id != null)
//     {
//         //
 
//         $SQL = "SELECT * FROM transaction WHERE user_id='$user_id'";
 
//         $results = mysqli_query($conn, $SQL);
 
//         $data = array();
 
//         while($row = mysqli_fetch_assoc($results))
//         {
//             $data[] = $row;
//         }
 
//         return $data;
//     }
 
//     return false;
// }
// $data = Transaction(6);
 
// echo "<pre>";
// print_r($data);
// echo "</pre>";



///////////////////////////////// ONE USER'S DATA OUTPUT//////////////////////////////////////////




function Transaction($transaction_id=null) {
    if($transaction_id){
        $SQL="SELECT * FROM transaction WHERE transaction_id='$transaction_id'";
        global $conn;
        $results = mysqli_query($conn,$SQL);
        // if(mysqli_num_rows($ewsults) > 0) {
            while($row = mysqli_fetch_assoc($results)){
                $data[] = $row;
            }

        return $data;

    }

    return false;
}


$transaction_id = 1;
$data = Transaction($transaction_id);

echo "<pre>";
print_r($data);
echo "</pre>";

echo "<br>";

?>

<?php






//////////////////////////////////// TRANSACTION_STATUS UPDATE ////////////////////////////////////////////




echo "<br>";




function TransactionStatus($user_id=null,$transaction_status=null){

    if($user_id AND $transaction_status){

        if($transaction_status == 'success'){$transaction_status = 'Success';}
        elseif($transaction_status == 'failed'){$transaction_status = 'Failed';}
        elseif($transaction_status == 'pending'){$transaction_status = 'Pending';}
        else {$transaction_status = '';}

        if($transaction_status!=''){
        $SQL="UPDATE transaction SET transaction_status = '$transaction_status' WHERE user_id= '$user_id'";
        global $conn;

        $results = mysqli_query($conn,$SQL);

        if($results){
                return "Status updated successfully!";
            } else {
                return "Error : ".mysqli_error($conn);
            }   
        }
    }
    return "Invalid ID or Status!";
}

    $user_id = 8;
    $transaction_status = "success";

    $data = TransactionStatus($user_id,$transaction_status);

 echo "<pre>";
 print_r($data);
 echo "</pre>";

echo "<br>";

?>


<?php



//////////////////////////////////////// INSERT NEW DATA ////////////////////////////////////////////////////////////////////////////


echo "<br>";



function TransactionNew($a=null){

if(is_array($a))
    {
        $transaction_id=$a['transaction_id'];
        $user_id=$a['user_id'];
        $account_no=$a['account_no'];
        $transaction_type=$a['transaction_type'];
        $amount=$a['amount'];
        $balance_after=$a['balance_after'];
        $payment_method=$a['payment_method'];
        $transaction_status=$a['transaction_status'];
        $reference_no=$a['reference_no'];
        $description=$a['description'];
        $transaction_date=$a['transaction_date'];

    if(!$transaction_status){$transaction_status = 'Pending';}


$SQL = "INSERT INTO transaction (
transaction_id,
user_id,
account_no,
transaction_type,
amount,
balance_after,
payment_method,
transaction_status,
reference_no,
description,
transaction_date)
VALUES(
'$transaction_id',
'$user_id',
'$account_no',
'$transaction_type',
'$amount',
'$balance_after',
'$payment_method',
'$transaction_status',
'$reference_no',
'$description',
'$transaction_date')";

global $conn;

$results = mysqli_query($conn,$SQL);

if($results){
    return "Transaction Inserted Successfully";
} else {
    return "Error : ".mysqli_error($DB);
}
    }
    return "Invalid Data!";
}

$a = [
'transaction_id' => 15,
'user_id' => 15,
'account_no' => 'ACC1015',
'transaction_type' => 'Credit',
'amount' => 2550,
'balance_after' => 55500,
'payment_method' => 'Cash',
'transaction_status' => 'Success',
'reference_no' => 'REF1015',
'description' => 'salery',
'transaction_date' => '2026-06-04'
];

echo TransactionNew($a);


echo "<br>";



?>



<?php





///////////////////////////////////// UPDATE ANY TRANSACTION ////////////////////////////////////////

echo "<br>";






function TransactionUpdate($d=null){
    if(is_array($d))
        {
        $transaction_id=$d['transaction_id'];
        $user_id=$d['user_id'];
        $account_no=$d['account_no'];
        $transaction_type=$d['transaction_type'];
        $amount=$d['amount'];
        $balance_after=$d['balance_after'];
        $payment_method=$d['payment_method'];
        $transaction_status=$d['transaction_status'];
        $reference_no=$d['reference_no'];
        $description=$d['description'];
        $transaction_date=$d['transaction_date'];
   
        global $conn;

  if($user_id){$user_id=" `user_id` = '$user_id',";}
  if($account_no){$account_no=" `account_no` = '$account_no',";}
  if($transaction_type){$transaction_type=" `transaction_type` = '$transaction_type',";}
  if($amount){$amount=" `amount` = '$amount',";}
  if($balance_after){$balance_after=" `balance_after` = '$balance_after',";}
  if($payment_method){$payment_method=" `payment_method` = '$payment_method',";}
  if($transaction_status){$transaction_status=" `transaction_status` = '$transaction_status',";}
  if($reference_no){$reference_no=" `reference_no` = '$reference_no',";}
  if($description){$description=" `description` = '$description',";}
  if($transaction_date){$transaction_date=" `transaction_date` = '$transaction_date',";}

    $SET=$user_id.$account_no.$transaction_type.$amount.$balance_after.$payment_method.$transaction_status.$reference_no.$description.$transaction_date;
    $SET = rtrim($SET, ",");

    $SQL = "UPDATE `transaction` SET $SET WHERE `transaction_id` = '$transaction_id'";

    $results = mysqli_query($conn,$SQL);

    if ($results){
        return "Transaction Updated Successfully";
    } else {
        return "Error :".mysqli_error($conn);
        }
        
    }
     return "Invalid Data";   
}

$d = [
    'transaction_id'   => 11,  
    'user_id'          => 11,
    'account_no'       => 'ACC1011',
    'transaction_type' => 'Debit',
    'amount'           => 500000,
    'balance_after'    => 30000,
    'payment_method'   => 'UPI',
    'transaction_status' => 'Success',
    'reference_no'     => 'REF1011',
    'description'      => 'Bill Payment',
    'transaction_date' => '2026-07-13'
];

echo TransactionUpdate($d);


echo "<br>";
echo "<br>";
echo "<br>";


?>






<?php




///////////////////////////////////////// GET MULTIPLE RECORDS FROM DATABASE ///////////////////////////////////////



echo "<br>";




function TransactionRecords($r=null){
    if(is_array($r)) {
        
    $Sort = $r['Sort'];

    $transaction_id = isset($r['transaction_id'])? " AND `transaction_id`='".$r['transaction_id']."'" : '';

    $user_id = isset($r['user_id'])? " AND `user_id`='".$r['user_id']."'" : '';

    $account_no = isset($r['account_no'])? " AND `account_no`='".$r['account_no']."'" : '';

    $transaction_type = isset($r['transaction_type'])? " AND `transaction_type`='".$r['transaction_type']."'" : '';

    $amount = isset($r['amount'])? " AND `amount`='".$r['amount']."'" : '';

    $balance_after = isset($r['balance_after'])? " AND `balance_after`='".$r['balance_after']."'" : '';

    $payment_method = isset($r['payment_method'])? " AND `payment_method`='".$r['payment_method']."'" : '';

    $transaction_status = isset($r['transaction_status'])? " AND `transaction_status`='".$r['transaction_status']."'" : '';

    $reference_no = isset($r['reference_no'])? " AND `reference_no`='".$r['reference_no']."'" : '';

    $description = isset($r['description'])? " AND `description`='".$r['description']."'" : '';

    $transaction_date = isset($r['transaction_date'])? " AND `transaction_date`='".$r['transaction_date']."'" : '';


    if($Sort == 'id'){$Sortt = 'id';}
    elseif($Sort == 'transaction_id'){ $Sortt = 'transaction_id'; }
    elseif($Sort == 'user_id'){ $Sortt = 'user_id'; }
    elseif($Sort == 'account_no'){ $Sortt = 'account_no'; }
    elseif($Sort == 'transaction_type'){ $Sortt = 'transaction_type'; }
    elseif($Sort == 'amount'){ $Sortt = 'amount'; }
    elseif($Sort == 'balance_after'){ $Sortt = 'balance_after'; }
    elseif($Sort == 'payment_method'){ $Sortt = 'payment_method'; }
    elseif($Sort == 'transaction_status'){ $Sortt = 'transaction_status'; }
    elseif($Sort == 'reference_no'){ $Sortt = 'reference_no'; }
    elseif($Sort == 'description'){ $Sortt = 'description'; }
    elseif($Sort == 'transaction_date'){ $Sortt = 'transaction_date'; }

    else{ $Sortt = 'id';}
    $SortBy = strtoupper($r['sortby']??'ASC');
}


    $WhereClause="1=1".$transaction_id.$user_id.$account_no.$transaction_type.$amount.$balance_after.$payment_method.$transaction_status.$reference_no.$description.$transaction_date;

    $Limit=isset($r['LIMIT'])? $r['LIMIT'] : '';
    if (!$Limit){$Limit = 10;}

    $Offset=isset($r['OFFSET'])? $r['OFFSET'] : 0;

    $SQL = "SELECT*FROM `transaction` WHERE ".$WhereClause." ORDER BY `".$Sortt."` $SortBy LIMIT ".$Limit." OFFSET ".$Offset;
    // echo $SQL;

    global $conn;
    $aa=0;
    $results = mysqli_query($conn,$SQL);
    // print_r($SQL);
    if(mysqli_num_rows($results) >0){
        while ($t = mysqli_fetch_assoc($results)){
            $ts[$aa] = $t; $aa++;
        }
    }
    else {$ts = null;}
   return $ts;
}


$r = [
    'Sort' => 'transaction_id',
    'sortby' => 'DESC',
    'LIMIT' => 5,
    'OFFSET' => 0,
    'user_id' => 6
];
echo "<pre>";
print_r(TransactionRecords($r));
echo "</pre>";
echo "<br>";


$r = [
    'Sort' => 'transaction_id',
    'sortby' => 'DESC',
    'LIMIT' => 5,
    'OFFSET' => 0,
    'user_id' => 8
];
echo "<pre>";
print_r(TransactionRecords($r));
echo "</pre>";
echo "<br>";


$r = [
    'Sort' => 'transaction_id',
    'sortby' => 'DESC',
    'LIMIT' => 5,
    'OFFSET' => 0,
    'user_id' => 7
];
echo "<pre>";
print_r(TransactionRecords($r));
echo "</pre>";
echo "<br>";



$r = [
    'Sort' => 'transaction_id',
    'sortby' => 'DESC',
    'LIMIT' => 5,
    'OFFSET' => 0,
    'user_id' => 2
];

echo "<pre>";
print_r(TransactionRecords($r));
echo "</pre>";


echo "<br>";




?>





<?php





////////////////////////////////////////////// SINGLE RECORD FROM DATABASE ///////////////////////////////////////////


echo "<br>";


function TransactionRecord($r=null){

  $SQL="SELECT * FROM `transaction` WHERE `transaction_id` = '".$r."'";

  global $conn;
  $aa = 0;
  $results = mysqli_query($conn, $SQL); 
  if(mysqli_num_rows($results) > 0){ 
    while($t = mysqli_fetch_assoc($results)){ 
        $ts[$aa] = $t; $aa++;
        }
    } else {$ts = null;}
  
  return $ts;
  
}

$r =9;
$results = TransactionRecord($r);
echo "<pre>";
print_r($results);
echo "</pre>";









?>