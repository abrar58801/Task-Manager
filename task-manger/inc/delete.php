<?php
require "./config.php";

$response = [];

$id = '';

if (isset($_POST['id']) && filter($_POST['id'])) {
    $id = filter($_POST['id']);
}

if ($id) {
    
    $deleteQuery = "DELETE FROM tbl_task WHERE id = '{$id}'";

    $delete = runDelete($deleteQuery);

    if ($delete) {
        $response['status'] = '100';
        $response['msg'] = 'Deleted !!';
        
    } else {
        $response['status'] = '101';
        $response['msg'] = 'Failed';
    }
}

echo json_encode($response);
?>