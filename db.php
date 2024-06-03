<?php
class db{
protected $connection;

function setconnection(){
    try{
        $this->connection=new PDO("mysql:host=LMS-DB; dbname=library_management","root","xsq2003");
    
    }catch(PDOException $e){
        echo "Error";

    }
}

}
