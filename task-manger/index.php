<?php
require "./inc/config.php";
require "./inc/head.php";
require "./inc/header.php";
?>

<style>
    .action a {
        width: 25px;
        height: 25px;
        border-radius: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 14px;
    }

    /* sweet alert */
    .colored-toast.swal2-icon-success {
        background-color: #28a745 !important;
        color: #fff;
        width: 200px;
    }

    .colored-toast.swal2-icon-error {
        background-color: #dc3545 !important;
        color: #fff;
        width: 200px;
    }

    .swal2-popup.swal2-toast {
        padding: 10px !important;
    }

    .swal2-popup.swal2-toast .swal2-title {
        font-size: 16px !important;
        font-weight: 400;
    }

    /* sweet alert */
</style>

<section>
    <div class="container my-5">
        <div class="col-12 mb-5 text-end">
            <button class="btn m-0" data-bs-toggle="modal" data-bs-target="#taskEdit"><i class="fas fa-plus"></i> Add Task</button>
        </div>
        <div class="card p-3">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Task</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody id="taskBody">
                        <?php
                        $select_task = runFatch("SELECT * FROM tbl_task ORDER BY id DESC");
                        if ($select_task) {
                            foreach ($select_task as $task) {
                                $status = $task['status'] == 1 ? '<h6 class="text-success m-0 status">Completed</h6>' : '<h6 class="text-warning m-0 status">Pending</h6>';
                        ?>
                                <tr id="trTaskId<?= $task['id'] ?>">
                                    <td>
                                        <h6 class="m-0 title"><?= $task['title'] ?></h6>
                                    </td>
                                    <td>
                                        <p class="m-0 text-dark des"><?= $task['des'] ?></p>
                                    </td>
                                    <td>
                                        <?= $status ?>
                                    </td>
                                    <td>
                                        <div class="d-flex gap-3 justify-content-end action">
                                            <?php
                                            if ($task['status'] != 1) {
                                            ?>
                                                <a href="#" class="bg-success doneTask" title="Task Complete" data-id="<?= $task['id'] ?>"><i class="fas fa-check"></i></a>
                                            <?php
                                            }
                                            ?>
                                            <a href="#" class="bg-warning editTask" title="Task Edit" data-bs-toggle="modal" data-bs-target="#taskEdit" data-task_data='<?= json_encode($task) ?>' data-id="<?= $task['id'] ?>"><i class="fas fa-edit"></i></a>
                                            <a href="#" class="bg-danger deleteTask" title="Task Delete" data-id="<?= $task['id'] ?>" data-remove="#trTaskId<?= $task['id'] ?>">
                                                <i class="fas fa-trash"></i>
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        }else{
                            ?>
                            <tr>
                                <td colspan="4" class="text-danger text-center">Task not found !</td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>


    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="taskEdit" tabindex="-1" aria-labelledby="taskEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-dark" id="taskEditLabel">Task</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="task_submit">
                <div class="modal-body">
                    <input type="hidden" name="task_id" id="task_id">
                    <div class="mb-3">
                        <label class="form-label">Task Title</label>
                        <input type="text" name="title" id="title" class="form-control" placeholder="Enter Task Title">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="des" class="form-control" id="des" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require "./inc/footer.php";
require "./inc/script.php";
?>