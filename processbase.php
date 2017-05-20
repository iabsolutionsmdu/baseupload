<html>
    <head>
        <title>IAB Base</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
   
    <script src="https://code.jquery.com/jquery-1.10.2.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="~/Scripts/html5shiv.min.js"></script>
        <script src="~/Scripts/respond.min.js"></script>
    <![endif]-->
    <!--[if lt IE 8]>
        <script src="~/Scripts/excanvas.js"></script>
        
    <![endif]-->

    <style>
       
        body {
            padding-top: 70px;
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }
        /* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba( 255, 255, 255, .8) url('http://i.stack.imgur.com/FhHRx.gif') 50% 50% no-repeat;
        }
        /* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
        
        body.loading {
            overflow: hidden;
        }
        /* Anytime the body has the loading class, our
   modal element will be visible */
        
        body.loading .modal {
            display: block;
        }
    
        </style>
        </head>
    <body>
        <form name="formprocess" method="post" action="csvtxt1.php">
         <nav class="navbar navbar-default  navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                <a class="navbar-brand" href="Index.html">IAB</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">

                  
                    <li class="active">
                        <a href="Index.html">Home</a>
                    </li>
                    <li>
                         <a href="report.html" >Reports</a>
                    </li>

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
    
<?php
    ini_set('display_errors', 1); error_reporting(-1);
    ini_set('error_log', 'files/log.txt');
    ini_set('log_errors_max_len', 0);
    ini_set('log_errors', true);
    include 'prop.php';

// $checkinvalidno_length= isset($_POST["chkino"]);
// $checkduplicateno=isset($_POST["chkdupno"]);
// $checkinvalidno=isset($_POST["chkstno"]);

//cho $checkduplicateno;



     if ($_FILES["file"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
  }
else
  {
      //  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      try{
          $tmpname=$_FILES["file"]["tmp_name"];
          $fname=$_FILES["file"]["name"];
     
          $fieldnames=array("Mobileno","service_provider","customer_firstname","customer_lastname",
          "customer_address1","customer_address2","customer_address3"
          ,"customer_state","customer_country","pincode", "campaign_name");

            
          $handle = fopen($tmpname, "r") or die("Couldn't get handle");
        if ($handle) {
                 session_start();
                 $filedata=[];
                   while (!feof($handle)) {
                     $fvals=fgets($handle,4096);
                     //echo $fvals;
                     array_push($filedata,$fvals);
                 }

            $_SESSION['filedata'] = $filedata;

            //$buffer = fgets($handle, 4096);
                // Process buffer here..
             //   echo $buffer . "<br>";
              
                $vals =explode(",",$filedata[0]);
                ?>
                 <input type='hidden' id='hdnfilename' name='hdnfilename' value="<?php echo $fname; ?>"></input>
                   
                <div class="container">
        <div class="row">

            <div class="col-md-6">
                <div class="panel panel-default" >
                    <div class="panel-heading">Process Base</div>
                    <div class="panel-body">
                        <?php
                echo "<table class='table' id='tblfields'>";
                foreach($vals as $arr){
                    echo "<tr><td>";
                    echo $arr;
                    echo "</td>";
                    echo "<td><select class='select2'>";
                     echo "<option>" . ''  . "</option>";
                    foreach($fieldnames as $fld){
                        echo "<option value=" . $fld . ">" . $fld . "</option>";
                    }
                    echo "</select></td></tr>";
                }
                echo "</table>";
                ?>

           </div>
           <div class="panel-footer">
               <button type="button" name="Submit" id="btnSubmit" class="button-info" onclick="return confirm('Sure to Process?');)">Process File </button>
               </div>
           </div>
           </div>
          
           </div>
           </div>
<?php
          //  $conn->beginTransaction();


           
            fclose($handle);
         //   $conn->commit();

           
            
          //  $conn = null;

      }
      
    }
    catch(Exception $e){
        echo 'Caught exception: ',  $e->getMessage(), "\n";
      //   $conn->rollback();
    }
    // $conn = null;
//header("Refresh: 6;url=index.html");
      }

    ?>
     <div class="modal">
        <!-- Place at bottom of page -->
    </div>
    <script type="text/javascript">
     $body = $("body");

$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});
    $(document).ready(function(){

        var d=new Date();
        var curdate=d.getFullYear() + "-" + ('0' + (d.getMonth() +1)).slice(-2) + "-" +('0' + (d.getDate())).slice(-2);
        $('#btnSubmit').on('click',function(e){
            e.preventDefault();
            var s="insert into tblbase (";
            var s1="";var s2="";var s3="";var s4="";
            var arr=[];
            var ct=0;
            var colcount=0;
            var bname=$('#hdnfilename').val();
            var tempfiledname=[];
            $('#tblfields tr').each(function(i,j){
                var obj=new Object();
                obj.colno=ct++;
                obj.colname=$(this).find('td').eq('0').text();
                var mappedfield=$(this).find('td').eq('1').find('.select2 option:selected').text();
                if (mappedfield === ""){
                    colcount++;
                    mappedfield = "fld" +  colcount.toString();
                }
                
               
                obj.mapfield=mappedfield;
                obj.mapcolumnname=mappedfield + "_mapped_colname";
                obj.basename=bname;
                obj.uploadate=curdate;
                //console.log(obj);
              // arr.push(obj);
                s1= s1+    mappedfield + " , "; 
                s2 = s2 +  obj.colno + ", " ;
                if (mappedfield.startsWith('fld')){
                    s3= s3 + mappedfield + "_mapped_colname" + "," ;
                     s4 = s4 + "'" + obj.colname + "',";
                }
                
               
            });
            s1=s1.replace(/,\s*$/, '');
            s2=s2.replace(/,\s*$/, '');
            s3=s3.replace(/,\s*$/, '');
            s4=s4.replace(/,\s*$/, '');
            tempfiledname=s1.split(",");
            var xcount=0;
            for (var i=0;i<tempfiledname.length ;i++){
                var fnamea=tempfiledname[i];
                var count=0;
                for (var j=0;j< tempfiledname.length;j++){
                    if (fnamea == tempfiledname[j]){
                            count++;
                    }
                }
                if (count > 1){
                    xcount = count;
                    alert('No Two Fileds can be Mapped Repeatedly ' + fnamea);
                    return;
                }
            }
            

            $.ajax({
                type: "POST",
                url: "csvtxt1.php",
                data: "mappedfield=" + s1 +"&colno=" + s2 + "&field_mapped_colname=" + s3 + "&field_mapped_colval=" + s4 + "&basename=" + bname, 
                success: function (retdata) {
                    alert(retdata);
                },
                error: function (jqxhr, error, status) {
                    console.log(jqxhr);
                    console.log(error);
                    alert(error);
                }

            });
        });
    });
    </script>
</body>
    </html>