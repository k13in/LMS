<?php

include("data_class.php");


$request=$_GET['reqid'];
$book=$_GET['book'];
$userselect= $_GET['userselect'];
$getdate= date("Y/m/d");
$days= $_GET['days'];

$returnDate=Date('Y/m/d', strtotime('+'.$days.'days'));

$obj=new data();
$obj->setconnection();
$obj->issuebookapprove($book,$userselect,$days,$getdate,$returnDate,$request);
