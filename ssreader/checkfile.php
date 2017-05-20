<?php
    ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);

require_once "Classes/PHPExcel/IOFactory.php";
 //http://stackoverflow.com/questions/9695695/how-to-use-phpexcel-to-read-data-and-insert-into-database
 /**  Define a Read Filter class implementing PHPExcel_Reader_IReadFilter  */
class chunkReadFilter implements PHPExcel_Reader_IReadFilter
{
    private $_startRow = 0;

    private $_endRow = 0;

    /**  Set the list of rows that we want to read  */
    public function setRows($startRow, $chunkSize) {
        $this->_startRow    = $startRow;
        $this->_endRow        = $startRow + $chunkSize;
    }

    public function readCell($column, $row, $worksheetName = '') {
        //  Only read the heading row, and the rows that are configured in $this->_startRow and $this->_endRow
        if (($row == 1) || ($row >= $this->_startRow && $row < $this->_endRow)) {
            return true;
        }
        return false;
    }
}

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
$inputFileType = 'Excel2007';
$inputFileName = $fname;
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objReader->setLoadSheetsOnly('Sheet1');
$objPHPExcel = $objReader->load($fname);
$rows = count($objPHPExcel->getActiveSheet()->toArray());    
for ($start_row = 1; $start_row < $rows; $start_row ++){
  var_dump($start_row) ;
}

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