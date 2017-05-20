<html>
    <head>
         <script src="./contents/jquery.min.js" type="text/javascript"></script>
        </head>
    <body>
        
<?php
    ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "iab";
$checkinvalidno_length= isset($_POST["chkino"]);
$checkduplicateno=isset($_POST["chkdupno"]);
$checkinvalidno=isset($_POST["chkstno"]);

echo $checkduplicateno;



     if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
  }
else
  {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
             $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      try{
          $tmpname=$_FILES["file"]["tmp_name"];
          $fname=$_FILES["file"]["name"];

            
          $handle = fopen($tmpname, "r") or die("Couldn't get handle");
        if ($handle) {
            $stmt=$conn->prepare("CALL usp_insertbase(:pmblno,:pprovider,:pmdate,:pteam,:pfname,:pisduplicate,:pisvalid)");
            $stmt->bindParam('pmblno',$mblno);
            $stmt->bindParam('pprovider',$provider);
            $stmt->bindParam('pmdate',$mdate);
            $stmt->bindParam('pteam',$team);
            $stmt->bindParam('pfname',$fname);
            $stmt->bindParam('pisduplicate',$isdup);
            $stmt->bindParam('pisvalid',$isvalid);
            $conn->beginTransaction();


            while (!feof($handle)) {
                $buffer = fgets($handle, 4096);
                // Process buffer here..
                //echo $buffer . "<br>";
               
                $vals =explode(",",$buffer);

              // echo "<div id='" . $vals[0] . "'>" . $vals[0] . "</div>";
              //$id="";
             

                if (! empty($vals[0]) && $vals[0] != 'COMPETITOR'){
                     $mblno=$vals[0];
                    $provider=$vals[2];
                    $mdate=$vals[7];
                    $team=$vals[8];
                    $isdup="N";
                    $isvalid="Y";

                    $stmt->execute();
                   // $insqry= "INSERT IGNORE INTO tblbase(mblno,provider,team,mdate,fname) values('" . $vals[0] . "','" . $vals[2] . "','" . $vals[7] . "','" . $vals[8] . "','" . $fname . "')";
                    //$insqry = $insqry . " Select * from (select '" . $vals[0] . "' ) as tmp where not EXISTS (select mblno from tblbase where mblno='" . $vals[0] . "')";
                    //echo $insqry . "<br>";
                    //$conn->exec($insqry);
                    // $retid = $conn->lastInsertId();
                    // if ($retid != $id){
                    //   //  echo "ok " . "<br>";

                    // }else{
                    //     echo $buffer . " Duplicate or Invalid Record" . "<br>";
                    // }
                    // $id=$retid;

                }


            }
            fclose($handle);
            $conn->commit();

            echo "<div> File Uploaded Successfully !!! You will be redirect shortly </div>";
            
          //  $conn = null;

      }
      
    }
    catch(Exception $e){
        echo 'Caught exception: ',  $e->getMessage(), "\n";
         $conn->rollback();
    }
     $conn = null;
header("Refresh: 6;url=index.html");
      }

    ?>
    
</body>
    </html>