<?php
  ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);

    $servername = "localhost";
$username = "root";
$password = "root";
$dbname = "iab";
$obj=json_decode($_POST['data']);

if (isset($obj->fdt)){
$fromdate =$obj->fdt;
} 



if (isset($obj->tdt)){
    $todate =$obj->tdt;
}

   if (empty($fromdate) || empty($todate)){
           echo "Select From Date";
           return;
       }
    

$rpttype="";
if (isset($obj->ttype)){
    $rpttype=$obj->ttype;
}

if ($rpttype == 'feedbackreport'){



             try{
                   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             $selectqry="select basename,mblno,custname,state,campaign,dialdate,feedback from tblfeedback where STR_TO_DATE(dialdate, '%d-%b-%y')  between STR_TO_DATE('" . $fromdate . "', '%d-%b-%y')  and str_to_date('" . $todate . "','%d-%b-%y')";
             $sth = $conn->prepare($selectqry);
             $sth->execute();
             $results=$sth->fetchAll(PDO::FETCH_ASSOC);
             $json=json_encode($results);
             echo $json;


             }catch(Exception $e){
                  echo 'Caught exception: ',  $e->getMessage(), "\n";

             }
}elseif ($rpttype == 'distinctbase'){

}elseif($rpttype == 'duplicatebase'){

}elseif($rpttype == 'invalidbase'){

}


?>