<?php
    ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    ini_set('memory_limit', '1024M'); // or you could use 1G

require_once "Classes/PHPExcel/IOFactory.php";
 
 

  if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
  }
else
  {
      $fname=$_FILES["file"]["tmp_name"];
//load Excel template file
// $objTpl = PHPExcel_IOFactory::load($fname);
// $objTpl->setActiveSheetIndex(0);  //set first sheet as active
$inputFileType = 'CSV';
$inputFileName = $fname;
$objReader =PHPExcel_IOFactory::createReader('CSV')
            ->setDelimiter(',')
            ->setEnclosure('"')
            ->setSheetIndex(0)
            ->load($fname);

 $objWorksheet = $objReader->setActiveSheetIndex(0);
    $highestRow = $objWorksheet->getHighestRow();
    $highestColumn = $objWorksheet->getHighestColumn();
    $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
 for ($row = 1; $row <= $highestRow; ++$row)
    {
         $file_data = array();
        for ($col = 0; $col <= $highestColumnIndex; ++$col)
        {  
            $value=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue(); 
            $file_data[$col]=trim($value);
        }
        $result[] = $file_data;
    }
    print_r($result);
//$objPHPExcel = $objReader->load($fname);
// $rows = count($objReader->getActiveSheet()->toArray());    
// for ($start_row = 1; $start_row < $rows; $start_row ++){
//   var_dump($start_row) ;
// }

/**  Define how many rows we want to read for each "chunk"  **/
// $chunkSize = 20;
// /**  Create a new Instance of our Read Filter  **/
// $chunkFilter = new chunkReadFilter();

// /**  Tell the Reader that we want to use the Read Filter that we've Instantiated  **/
// $objReader->setReadFilter($chunkFilter);

// /**  Loop to read our worksheet in "chunk size" blocks  **/
// /**  $startRow is set to 2 initially because we always read the headings in row #1  **/

// for ($startRow = 2; $startRow <= 65536; $startRow += $chunkSize) {
//     echo 'Loading WorkSheet using configurable filter for headings row 1 and for rows ',$startRow,' to ',($startRow+$chunkSize-1),'<br />';
//     /**  Tell the Read Filter, the limits on which rows we want to read this iteration  **/
//     $chunkFilter->setRows($startRow,$chunkSize);
//     /**  Load only the rows that match our filter from $inputFileName to a PHPExcel Object  **/
//     $objPHPExcel = $objReader->load($fname);

//     //    Do some processing here

//     $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//     var_dump($sheetData);
//     echo '<br /><br />';
// }


  }

?>