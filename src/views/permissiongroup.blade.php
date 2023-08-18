<x-rolebasesystem::header />
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Permission group</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12 mb-4 text-right">
                                        <button type="button" class="btn btn-primary mt-2 btn_action" id="btn_addpermission" data-id="1"><i class="fa fa-plus"></i> Add Permission
                                            Group</button>
                                    </div>
                                </div>
                                <table id="tbl_permissiongroup" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Permission Group </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Permission Group </th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
  
    <!-- //add & edit permission group model -->
    <div class="modal fade" id="modal_add_edit_permission_group">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modal_add_edit_permission_group_title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" id="form_add_edit_permission_group" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="hid_permissiongroupid" id="hid_permissiongroupid">
                        <input type="hidden" name="hid_actionid" id="hid_actionid">
                        <div class="form-group">
                            <label>Permission Group Name </label>
                            <input type="text" name="txt_permissiongroupname" class="form-control" id="txt_permissiongroupname">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="btn_modal_add_edit_permission_group"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title " id="modal-delete-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                    <div class="modal-body">
                        <input type="hidden" name="hid_deleteid" id="hid_deleteid">
                        <p id="modal-delete-message"></p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="btn-delete">Delete</button>
                    </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <x-rolebasesystem::footer />
    <script>
        $(function() {
            var table = $('#tbl_permissiongroup').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "ajax": {
                    'url': '/getpermissiongroup',
                    beforeSend: function() {
                        $('#preloader').show();
                    },
                    complete: function() {
                        $('#preloader').hide();
                    }
                },
                "columns": [{
                        "data": "permission_group"
                    },
                    {
                        visible: true,
                        data: null,
                    },
                ],
                "createdRow": function(row, data, index) {
                    $('td', row).eq(1).html(
                        '<button type="button" name="btn_edit" data-id="2" id="btn_edit" class="btn btn-warning btn_action"><i class="fa fa-edit"></i></button><button type="button" name="btn_delete" id="btn_delete" class="btn btn-danger ml-2" data-id="' +
                        data['permission_group_id'] + '"><i class="fa fa-trash"></i></button>');
                },

            });

            //set the value of permission group form
            $("body").on("click", ".btn_action", function() {
                if ($(this).attr("data-id") == 1) {
                    $("#hid_actionid").val(1);
                    $("#modal_add_edit_permission_group_title").text("Add Permission Group")
                    $("#btn_modal_add_edit_permission_group").text("Add")
                } else {
                    var data = table.row($(this).parents('tr')).data();
                    $("#hid_actionid").val(2);
                    $("#hid_permissiongroupid").val(data['permission_group_id']);
                    $("#txt_permissiongroupname").val(data['permission_group']);
                    $("#modal_add_edit_permission_group_title").text("Edit  Permission Group");
                    $("#btn_modal_add_edit_permission_group").text("Update");
                }
                $("#modal_add_edit_permission_group").modal()
            });



            //cinfirm modal form delete permission group
            $("body").on("click", "#btn_delete", function() {
                $("#hid_deleteid").val($(this).attr('data-id'));
                $("#modal-delete-title").text('Delete Role');
                $("#modal-delete-message").text('Are you sure want to delete Permission Group ?');
                $("#modal-delete").modal();
            });

            //delete permission group
            $("#btn-delete").click(function() {
                $.ajax({
                    type: 'POST',
                    url: '/deletepermissiongroup',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        role_id: $("#hid_deleteid").val(),
                    },
                    beforeSend: function() {
                        $("#preloader").show();
                    },
                    success: function(data) {
                        if (data.success) {
                            $("#modal-delete").modal('toggle')
                            toastr.success(data.message);
                            table.ajax.reload();
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    complete: function() {
                        $("#preloader").hide();
                    },
                });
            })

            //clear form when modal is close
            $('#modal_add_edit_permission_group').on('hidden.bs.modal', function() {
                $("#form_add_edit_permission_group")[0].reset();
                $("#form_add_edit_permission_group").each(function() {
                    $(".form-control").removeClass('is-invalid')
                })
            })

            //permission group form  validation 
            $('#form_add_edit_permission_group').submit(function(e) {
                e.preventDefault();
                var url;
                var actionData = [];
                if ($("#hid_actionid").val() == 1) {
                    url = "/addpermissiongroup";
                    actionData = {
                        permission_group: $("#txt_permissiongroupname").val(),
                    };
                } else {
                    url = "/editpermissiongroup";
                    actionData = {
                        id: $("#hid_permissiongroupid").val(),
                        permission_group: $("#txt_permissiongroupname").val(),
                    };
                }
                $.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: actionData,
                    beforeSend: function() {
                        $("#preloader").show();
                    },
                    success: function(data) {
                        if (data.success) {
                            $("#modal_add_edit_permission_group").modal('toggle')
                            toastr.success(data.message);
                            table.ajax.reload();
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    complete: function() {
                        $("#preloader").hide();
                    },
                });
            })

        });
    </script>
</body>

</html>