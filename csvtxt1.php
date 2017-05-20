<?php
    ini_set('display_errors', 1);
    error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    include 'prop.php';
   session_start();
if (!isset($_SESSION['filedata']) && empty($_SESSION['filedata'])) {
    echo "No values in session";
    return;
}
    $buffer=$_SESSION['filedata'];
    // foreach($buffer as $buf){
    //     echo $buf . "</br>";
    // }


if (isset($_POST["mappedfield"])) {
    $mapfields = $_POST["mappedfield"];
}
if (isset($_POST["colno"])) {
    $colno = $_POST["colno"];
}
if (isset($_POST["field_mapped_colname"])) {
    $mapcolumnnames = $_POST["field_mapped_colname"];
}
if (isset($_POST["field_mapped_colval"])) {
    $mapcolvals = $_POST["field_mapped_colval"];
}
if (isset($_POST["basename"])) {
    $basename = $_POST["basename"];
}

try {
    $colnos=explode(",", $colno);
   // echo $colno;
   // print_r($mapcolumnnames);
    $qry=" insert into mstbase (";
    $qry = $qry . $mapfields ;
    if (empty($mapcolumnnames)== false) {
        $qry = $qry . "," . $mapcolumnnames;
    }
    $qry = $qry . ", base_name, upload_date ) values (";
        
    //$qry= "insert into mstbase (" .  $mapfields . " , " .  $mapcolumnnames . ", base_name,upload_date ) values ("  ;
    $insqry='';
   // print_r($qry);
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
         $conn->beginTransaction();
    $firstcol=true;
    foreach ($buffer as $buf) {
        if ($firstcol == true) {
            $firstcol=false;
            continue;
        }
        $insqry='';
        //echo $buf;
        $vals =explode(",", $buf);
        if (empty($buf)) {
            echo "empty";
            break;
        }
        //var_dump( $vals);
        //var_dump($colnos);
        
        $qry1='';
        for ($i=0; $i< sizeof($vals); $i++) {
           // $arrno=$cols[$i];
            $qry1 .=  "'" . $vals[$i] . "',";
        }

           
        //$qry2=substr($qry1,0,-1);
        if ($qry1 == '' || $qry1 == "" || empty($qry1)) {
            echo "here we go";
        }
        if (empty($mapcolvals)) {
            $qry1 .=  "'" . $basename  . "','" . date('Y-m-d') . "')";
            //break;
        }else{
        $qry1 .= $mapcolvals . ",'" . $basename  . "','" . date('Y-m-d') . "')";
        }
           print_r($qry1) ;
        $insqry = $qry . $qry1;
        print_r ($insqry);
        $conn->exec($insqry);
        //}
    }
     $conn->commit();
    echo "ok";
    //echo $insqry;
} catch (Exception $e) {
    var_dump($insqry);
    echo 'Caught exception: ',  $e->getMessage(), "\n";
    $conn->rollBack();
}
    $conn=null;
