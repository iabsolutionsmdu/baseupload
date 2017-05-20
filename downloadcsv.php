<?php
  ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);

    include 'prop.php';
    if (isset($_GET["args"])){
        $args=$_GET["args"];
    }
             try{
               function contains($searchword,$searchstring){
                   return strpos($searchstring,$searchword) !== false;
               }

                   $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
             //$selectqry="SELECT slno,mblno,provider,team,mdate from tblbase where fname='vmp.csv'";
             $selectqry="SELECT slno,
  mobileno,  service_provider,customer_firstname,  customer_lastname,  customer_address1,  customer_address2,
  customer_address3,  customer_state,  customer_country,  pincode,  base_name,  campaign_name,
  fld1,  fld2,  fld3,  fld4,  fld5,  fld6,  fld7,  fld8,  fld9,  fld10,  fld11,  fld12,  fld13,  fld14,
  fld15,  fld16,  fld17,  fld18,  fld19,  fld20,  fld1_mapped_colname,  fld2_mapped_colname,  fld3_mapped_colname,
  fld4_mapped_colname,   fld5_mapped_colname,  fld6_mapped_colname,  fld7_mapped_colname,  fld8_mapped_colname,
  fld9_mapped_colname,  fld10_mapped_colname,  fld11_mapped_colname,  fld12_mapped_colname,  fld13_mapped_colname,
  fld14_mapped_colname,  fld15_mapped_colname,  fld16_mapped_colname,  fld17_mapped_colname,  fld18_mapped_colname,
  fld19_mapped_colname,  fld20_mapped_colname from mstbase where base_name='" . $args ."'";
             $sth = $conn->prepare($selectqry);
             $sth->execute();
            // $results=$sth->fetchAll(PDO::FETCH_ASSOC);
             $data = fopen('php://output', 'w');
             $columnNamesRow = "Sl#, MobileNo, Provider,Team, Date";
             header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="export.csv"');
                header('Pragma: no-cache');
                header('Expires: 0');
                // $arr=explode(",",$columnNamesRow);
                // fputcsv($data,$arr);
                $firstrow=true;
                $colcount=0;
                while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                    
                    //print_r($row); 
                    //here i am removing columns with null values so only valid column for that particular csv will be allowed
                     $cols=array_filter($row,function($value) {
                            return ($value !== null && $value !== false && $value !== ''); 
                        });
                        $headerrow='';
                        $firstrowval='';
                        //get the header which are stored in different fields under name fld_mapped_column and
                        //assing them as a single row along with default fields, so the generic fields which
                        //contains column values will be having their original csv header name from the mapped_column
                        //this is for the header row only. the logic here is get the keys of the array check for length
                        //of header row the generic fields have max length of 5 so skip them all
                        if ($firstrow == true){
                            foreach($cols as $key => $value){
                                if (strlen($key)>5){
                                    if (contains('fld',$key)){
                                        $headerrow .=$value . " ";
                                    }else{
                                        $headerrow .=$key . " ";
                                        $firstrowval .=$value . " ";
                                    }
                                
                                }else if(strlen($key) <=5){
                                    $colcount = $colcount + 1 ;
                                    if (contains('slno',$key)==false  ){
                                        // if ( empty($value) == false){
                                            
                                        // }
                                        $firstrowval .=$value . " ";
                                    }
                                  //  print_r($colcount);
                                }
                                
                            }

                            $hrow= explode(" ",$headerrow);
                            $fval=explode(" ", $firstrowval);
                            fputcsv($data, $hrow);         
                            $firstrow = false;
                            fputcsv($data, $fval);
                            continue;
                        }else{
                    // echo $colcount;
                     $newcols= array_splice($cols,$colcount+3);
                     
                    // $cols.array_push( $newcols[sizeof($newcols)-1]);
                  array_shift($cols);
                   fputcsv($data, $cols);
                   }
                }
              

                fclose($data);
                die;
            //  $json=json_encode($results);
            //  echo $json;
           
            // $headers = array();
            // for ($i = 0; $i < 6; $i++) {
            //     $headers[] = mysql_field_name($result , $i);
            // }
            // $fp = fopen('php://output', 'w');
            // if ($fp && $result) {
            //     header('Content-Type: text/csv');
            //     header('Content-Disposition: attachment; filename="export.csv"');
            //     header('Pragma: no-cache');
            //     header('Expires: 0');
            //     fputcsv($fp, $headers);
            //     while ($row = $result->fetch_array(MYSQLI_NUM)) {
            //         fputcsv($fp, array_values($row));
            //     }
            //     die;
            // }


             }catch(Exception $e){
                  echo 'Caught exception: ',  $e->getMessage(), "\n";
                  die;

             }

?>