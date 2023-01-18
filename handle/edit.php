<?php

require_once '../App.php';

if($request->hasPost("submit") && $request->hasGet("id") ){
    $id=$request->get("id");
    $title=$request->clean("title");
    //echo $id ;

    $validation->validate("title", $title , ["Required" , "Str"] );
    $errors=$validation->getError();

    if(empty($errors)){
            $stm=$conn->prepare("select *  from todo where `id`=:id");
            $stm->bindparam(":id",$id,PDO::PARAM_INT);
            $out = $stm->execute();

            if($out){
                $stm=$conn->prepare("update todo set `title`=:title where id=:id");
                $stm->bindparam(":id",$id,PDO::PARAM_INT);
                $stm->bindparam(":title",$title,PDO::PARAM_STR);
                $todo_update = $stm->execute();

                        if($todo_update){
                        $session->set("success","Data is  Updated Successfly");
                        $request->header("../index.php");
                        }else{
                            $session->set("error","Data is not  Updated ");
                            $request->header("../edit.php?id=$id"); 
                        }
            }else{
                $session->set("error","Data is not  Found ");
                $request->header("../index.php");
            }
    
    }else{
    $session->set("errors",$errors);
    $request->header("../edit.php?id=$id");
    }



}else{
    $session->set("error","Error");
    $request->header("../index.php");
}







