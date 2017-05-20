<?php
    ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    // If you need to parse XLS files, include php-excel-reader
    require('php-excel-reader/excel_reader2.php');

    require('SpreadsheetReader.php');

    // $Reader = new SpreadsheetReader('example.xlsx');
    // // insert every row just after reading it
    // foreach ($Reader as $row)
    // {
    //     $db->insert($row);
    // }
    if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
  }
else
  {
      $fname= $_FILES["file"]["tmp_name"];
       $Reader = new SpreadsheetReader($fname);
    // insert every row just after reading it
    foreach ($Reader as $row)
    {
        //$db->insert($row);
         print_r($row);
    }
//   echo "Upload: " . $_FILES["file"]["name"] . "<br>";
//   echo "Type: " . $_FILES["file"]["type"] . "<br>";
//   echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
//   echo "Stored in: " . $_FILES["file"]["tmp_name"];
  }
?>