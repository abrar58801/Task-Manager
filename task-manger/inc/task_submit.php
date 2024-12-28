<?php
// ini_set("display_errors", 1);
// ini_set("display_startup_errors", 1);
// error_reporting(E_ALL);
require './config.php';

$res = [];
if (isset($_POST['des']) && !empty($_POST['des'])) {
    $des = filter($_POST['des']);
} else {
    $res['msg'] = 'Description is required';
    $res['status'] = 101;
}

if (isset($_POST['title']) && !empty($_POST['title'])) {
    $title = filter($_POST['title']);
} else {
    $res['msg'] = 'Title is required';
    $res['status'] = 101;
}

if (isset($_POST['task_id']) && !empty($_POST['task_id'])) {
    $task_id = filter($_POST['task_id']);
} else {
    $task_id = 0;
}


if (!$res) {

    if(isset($task_id) && !empty($task_id)){
        $update_query = "UPDATE tbl_task SET title = '$title', des = '$des' WHERE id = '$task_id'";
    
        $update = runUpdate($update_query);
        if ($update) {

            $task_data = runFatch("SELECT * FROM tbl_task WHERE id = $task_id");
    
            $res['status'] = 102;
            $res['msg'] = $task_data;
        } else {
            $res['status'] = 101;
            $res['msg'] = 'An Error Occured';
        }
    }else{

        $insert_query = "INSERT INTO tbl_task (title, des) VALUES ('$title', '$des')";
    
        $insert = runInsert($insert_query);
        if ($insert) {

            $task_data = runFatch("SELECT * FROM tbl_task ORDER BY id DESC LIMIT 1");
    
            $res['status'] = 100;
            $res['msg'] = $task_data;
        } else {
            $res['status'] = 101;
            $res['msg'] = 'An Error Occured';
        }

    }
}

echo json_encode($res);
