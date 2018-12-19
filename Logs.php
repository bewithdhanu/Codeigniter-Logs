<?php
defined('BASEPATH') or exit('No direct script access allowed');
/******
Author:Dhanu K
Email:bewithdhanu@gmail.com
Website:bewithdhanu.in
*******/
class logs extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //some logic to ristrict logs contoller
        /*if (!$this->session->has_userdata('user_id')) {
            redirect("./");
        }*/
    }
    public function index(){
echo <<<EOT
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Logs</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        #footer {
            position: fixed;
            height: 50px;
            background: #fff;
            padding: 10px;
            bottom: 0px;
            left: 0px;
            right: 0px;
            margin-bottom: 0px;
        }
    </style>
</head>
<body>
  
<div class="container-fluid">
    <h1>Codeigniter Logs</h1>  
  <pre class="logs" style="margin-bottom: 50px;font-size: smaller;">
  </pre>         
</div>
<footer class="footer" id="footer">
  <div class="container-fluid">
    <div class="row">
        <div class="col-md-6" style="padding-top: 7px;">Codeigniter Logs</div>
        <div class="col-md-6" style="text-align: right;padding-top: 7px;"><div class="btn btn-default btn-xs" onclick="getLogs(true)">Refresh</div> | <div class="btn btn-danger btn-xs" onclick="clearLogs()">Clear Logs</div></div>
    </div>
  </div>
</footer>
</body>
<script type="text/javascript">
    getLogs(true);
    function getLogs(bool){
        $.ajax({
            url:"./logs/log",
            success:function(data){
                $(".logs").html(data);
                if(bool)
                    $('html, body').scrollTop( $(document).height() );
                setTimeout(function(){getLogs(false);}, 30000);
            }
        });
    }
    function clearLogs(){
        $.ajax({
            url:"./logs/clearLogs",
            success:function(data){
                $(".logs").html(data);
                $('html, body').scrollTop( $(document).height() );
            }
        });
    }
</script>
</html>
EOT;
    }
    public function log($date=null){
        if($date==null){
            $date=date("Y-m-d");
        }
        echo readFile("./application/logs/log-".$date.".php",$date);
    }
    public function clearLogs(){
        $date=date("Y-m-d");
        $file = "./application/logs/log-".$date.".php";
        $f = @fopen($file, "r+");
        if ($f !== false) {
            ftruncate($f, 0);
            fclose($f);
        }
        echo readFile($file,$date);
    }
    public function readFile($file,$date){

        $file = fopen($file,"r");   

        if(!$file) { 
            echo "$date --> Log not found till now.\n";    //getting this error everytime.
            exit; 
        } 

        $size = filesize($file); 

        if(!$size) { 
            echo "$date --> File is empty.\n"; 
            exit; 
        } 

        $content = fread($file,$size); 

        fclose($file); 
        return $content;
    }
}
