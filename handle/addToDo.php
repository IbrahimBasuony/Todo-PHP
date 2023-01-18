<?php

require_once '../App.php';



if($request->hasPost("submit")){
    
    $title=$request->clean("title");


    $validation->validate("title", $title , ["Required" , "Str"] );
    $errors=$validation->getError();

    if(empty($errors)){

      $str=$conn->prepare("insert into todo (`title`) values (:title)");
      $str->bindparam(":title",$title,PDO::PARAM_STR);
      $out=$str->execute(); 
      
      
      if($out){
        $session->set("success","Data Added Successfly");
        $request->header("../index.php");
      }else{
        $session->set("error","Error in Inserting");
        $request->header("../index.php");
      }

        
    }else{
        $session->set("errors",$errors);
        $request->header("../index.php");

    }
    
}else{
    $request->header("../index.php");

}