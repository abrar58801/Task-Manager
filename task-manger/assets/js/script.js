
// swal alert start
const Toast = Swal.mixin({
    toast: true,
    position: 'top-right',
    iconColor: 'white',
    customClass: {
        popup: 'colored-toast'
    },
    showConfirmButton: false,
    timer: 1500,
    timerProgressBar: true
});
const swamsg = {
    error: (msg) => {
        Toast.fire({
            icon: 'error',
            title: msg
        });
    },
    success: (msg) => {
        Toast.fire({
            icon: 'success',
            title: msg
        })
    }
};
// swal alert end 


$("#task_submit").submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    $.ajax({
        url: './inc/task_submit.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (data, status) {
            const res = JSON.parse(data);

            let html = '';
            if (res.status == 100) {

                let task = res.msg;
                let status = task[0].status == 1
                    ? `<h6 class="text-success m-0 status">Complited</h6>`
                    : `<h6 class="text-warning m-0 status">Pending</h6>`;

                let html = `
                        <tr id="trTaskId${task[0].id}">
                            <td>
                                <h6 class="m-0 title">${task[0].title}</h6>
                            </td>
                            <td>
                                <p class="m-0 text-dark des">${task[0].des}</p>
                            </td>
                            <td>
                                ${status}
                            </td>
                            <td>
                                <div class="d-flex gap-3 justify-content-end action">
                                    ${task['status'] != 1
                        ? `<a href="#" class="bg-success doneTask" title="Task Complete" data-id="${task[0].id}"><i class="fas fa-check"></i></a>`
                        : ''}
                                    <a href="#" class="bg-warning editTask" title="Task Edit" data-bs-toggle="modal" data-bs-target="#taskEdit" data-id="${task[0].id}" data-task_data='${JSON.stringify(task[0])}'>
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="bg-danger deleteTask" title="Task Delete" data-id="${task[0].id}" data-remove="#trTaskId${task[0].id}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    `;

                $('#taskBody').prepend(html);
                $('.modal').modal('hide');
                $("#task_submit").trigger('reset');

                swamsg.success("Successfully Insert");
            } else if (res.status == 102) {

                let task = res.msg;
                let status = task[0].status == 1
                    ? `<h6 class="text-success m-0 status">Complited</h6>`
                    : `<h6 class="text-warning m-0 status">Pending</h6>`;

                let html = `
                            <td>
                                <h6 class="m-0 title">${task[0].title}</h6>
                            </td>
                            <td>
                                <p class="m-0 text-dark des">${task[0].des}</p>
                            </td>
                            <td>
                                ${status}
                            </td>
                            <td>
                                <div class="d-flex gap-3 justify-content-end action">
                                    ${task['status'] != 1
                        ? `<a href="#" class="bg-success doneTask" title="Task Complete" data-id="${task[0].id}"><i class="fas fa-check"></i></a>`
                        : ''}
                                    <a href="#" class="bg-warning editTask" title="Task Edit" data-bs-toggle="modal" data-bs-target="#taskEdit" data-id="${task[0].id}" data-task_data='${JSON.stringify(task[0])}'>
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="#" class="bg-danger deleteTask" title="Task Delete" data-id="${task[0].id}" data-remove="#trTaskId${task[0].id}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                    `;
                

                $(`#trTaskId${task[0].id}`).html(html);
                $('.modal').modal('hide');
                $("#task_submit").trigger('reset');

                swamsg.success("Successfully Updated !");
            } else {
                swamsg.error(res.msg);
            }
        },
    });
});



// delete start
$(document).on('click', '.deleteTask', function () {
    const id = $(this).data('id');
    const remove = $(this).data('remove');

    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: './inc/delete.php',
                type: 'POST',
                data: { id },
                success: response => {
                    const res = JSON.parse(response);
                    if (res.status == 100) {
                        swamsg.success('Deleted !!');
                        $(remove).fadeOut(300, () => {
                            $(remove).remove();
                        })
                    } else {
                        swamsg.error('Failed !!');
                    }
                }
            });
        } else {
            swamsg.success('Your data is safe !');
        };
    });
});
//delete end

// Status start
$(document).on('click', '.doneTask', function () {
    const element = $(this);
    const id = element.data('id');

    $.ajax({
        url: './inc/status.php',
        type: 'POST',
        data: { id },
        success: response => {
            const res = JSON.parse(response);
            if (res.status == 100) {
                swamsg.success(res.msg);
                $(element).fadeOut(300, () => {
                    element.closest('#trTaskId' + id).find('.status').html('<span class="text-success">Completed</span>');
                    element.addClass('d-none');
                });

            } else if (res.status == 101) {
                swamsg.error(res.msg);
            }
        }
    });
});
//Status end

// edit start
$(document).on('click', '.editTask', function () {
    let element = $(this);
    let id = element.data('id');
    let taskData = element.data('task_data');
    console.log(taskData);
    

    $('#task_id').val(id);
    $('#title').val(taskData.title);
    $('#des').val(taskData.des);

});
//edit end