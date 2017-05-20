<?php
  ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    
    include 'prop.php';
class resultobj{
    public $base_name;
    public $totalduplicates;
    public $totalnumbers;
}
//     $servername = "localhost";
// $username = "root";
// $password = "root";
// $dbname = "iab";
             try{
                   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // $selectqry="SELECT DISTINCT fname,count(mblno) as totalnumbers, count(case when isduplicate='Y' then 1 end) as totalduplicates,
             //count(case when isvalid='N' then 1 end) as totalinvalid from tblbase group by fname ";
    //   $selectqry="SELECT  x.base_name,count(x.c) as totalduplicates,(select count(*) from mstbase) totalnumbers 
    //               FROM
    //               (
    //                   select base_name, Count(mobileno) as c
    //                   from mstbase
    //                   group by base_name,mobileno
    //                   having Count(mobileno) > 1
    //               ) x group by x.base_name";

    $selectqry="SELECT  x.base_name,count(x.c) as totalduplicates,(select count(*) from mstbase where base_name=x.base_name) as totalnumbers 
                  FROM
                  (
                      select base_name, Count(mobileno) as c
                      from mstbase
                      group by base_name,mobileno
                      having Count(mobileno) >= 1
                  ) x group by x.base_name";

             $sth = $conn->prepare($selectqry);
             $sth->execute();
            // $results=$sth->fetchAll(PDO::FETCH_ASSOC);
            $results=array();
             while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                $ret =new resultobj();
                $ret->base_name=$row["base_name"];
                $ret->totalduplicates =$row["totalduplicates"];
                $ret->totalnumbers=$row["totalnumbers"];
                $results[]=$ret;
                  
             }
             //$results ="";

             $json=json_encode($results);
             echo $json;


             }catch(Exception $e){
                  echo 'Caught exception: ',  $e->getMessage(), "\n";

             }

?>