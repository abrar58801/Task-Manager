<?php
require "./config.php";

$response = [];

if (isset($_POST['id']) && filter($_POST['id'])) {
    $id = filter($_POST['id']);
}

if($id){
    $updateQuery = "UPDATE tbl_task SET status = 1 WHERE id = '{$id}'";
    $update = runUpdate($updateQuery);

    if ($update) {
        $response['status'] = '100';
        $response['msg'] = 'Task Done!!';
    } else {
        $response['status'] = '101';
        $response['msg'] = 'Oops.. Something wrong. Please try after sometime!!!';
    }
}
echo json_encode($response);
?>
