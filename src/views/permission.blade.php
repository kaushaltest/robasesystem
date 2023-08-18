<x-rolebasesystem::header />
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Permission</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 mb-4 text-right">
                                <button type="button" class="btn btn-primary mt-2 btn_action" data-id="1"><i class="fa fa-plus"></i> Add Permission</button>
                            </div>
                        </div>
                        <table id="tbl_permission" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Permission name </th>
                                    <th>Slug</th>
                                    <th>Permission group</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Permission name </th>
                                    <th>Slug</th>
                                    <th>Permission group</th>
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


<!-- //add & edit permission model -->
<div class="modal fade" id="modal_add_edit_permission">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modal_add_edit_permission_title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form_add_edit_permission" method="post">
                <div class="modal-body">
                    <input type="hidden" name="hid_permissionid" id="hid_permissionid">
                    <input type="hidden" name="hid_actionid" id="hid_actionid">
                    <div class="form-group">
                        <label>Permission Name </label>
                        <input type="text" name="txt_permissionname" class="form-control" id="txt_permissionname">
                    </div>
                    <div class="form-group">
                        <label>Select Permission Group </label>
                        <select name="drp_permissiongroup" id="drp_permissiongroup" class="form-control">

                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btn_modal_add_edit_permission"></button>
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

        var table = $('#tbl_permission').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "ajax": {
                'url': '/getpermission',
                beforeSend: function() {
                    $('#preloader').show();
                },
                complete: function() {
                    $('#preloader').hide();
                }
            },
            "columns": [{
                    "data": "permission"
                },
                {
                    "data": "slug"
                },
                {
                    "data": "permission_group"
                },
                {
                    visible: true,
                    data: null,
                },
            ],
            "createdRow": function(row, data, index) {
                $('td', row).eq(3).html(
                    '<button type="button" name="btn_edit" data-id="2" id="btn_edit" class="btn btn-warning btn_action"><i class="fa fa-edit"></i></button><button type="button" name="btn_delete" id="btn_delete" class="btn btn-danger ml-2" data-id="' +
                    data['permission_id'] + '"><i class="fa fa-trash"></i></button>');
            },

        });

        //get permission group data
        getPermissionGroup();

        function getPermissionGroup() {
            $.ajax({
                type: 'GET',
                url: '/getpermissiongroup',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $("#preloader").show();
                },
                success: function(data) {
                    if (data.success) {
                        if (data.data) {
                            var permissionData = "<option value=''>Select Group</option>";
                            for (var i = 0; i < data.data.length; i++) {
                                permissionData += "<option value='" + data.data[i]
                                    .permission_group_id + "'>" + data.data[i].permission_group +
                                    "</option>";
                            }
                            $("#drp_permissiongroup").html(permissionData);
                        }
                    }
                },
                complete: function() {
                    $("#preloader").hide();
                },
            });
        }

        //set the value of add & edit  permission form
        $("body").on("click", ".btn_action", function() {
            if ($(this).attr("data-id") == 1) {
                $("#hid_actionid").val(1);
                $("#modal_add_edit_permission_title").text("Add Permission")
                $("#btn_modal_add_edit_permission").text("Add")
            } else {
                var data = table.row($(this).parents('tr')).data();
                $("#hid_actionid").val(2);
                $("#hid_permissionid").val(data['permission_id']);
                $("#txt_permissionname").val(data['permission']);
                $("#drp_permissiongroup").val(data['permission_group_id']);
                $("#modal_add_edit_permission_title").text("Edit Permission");
                $("#btn_modal_add_edit_permission").text("Update");
            }
            $("#modal_add_edit_permission").modal()
        });



        //confirm modal for delete permission
        $("body").on("click", "#btn_delete", function() {
            $("#hid_deleteid").val($(this).attr('data-id'));
            $("#modal-delete-title").text('Delete Permission');
            $("#modal-delete-message").text('Are you sure want to delete Permission ?');
            $("#modal-delete").modal();
        });

        //delete permission
        $("#btn-delete").click(function() {
            $.ajax({
                type: 'POST',
                url: '/deletepermission',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    permission_id: $("#hid_deleteid").val(),
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
        $('#modal_add_edit_permission').on('hidden.bs.modal', function() {
            $("#form_add_edit_permission")[0].reset();
            $("#form_add_edit_permission").each(function() {
                $(".form-control").removeClass('is-invalid')
            })
        })

        //permission for validation
        $('#form_add_edit_permission').submit(function(e) {
            e.preventDefault();
            var url;
            var actionData = [];
            if ($("#hid_actionid").val() == 1) {
                url = "/addpermission";
                actionData = {
                    permission_name: $("#txt_permissionname").val(),
                    permission_group: $("#drp_permissiongroup").val(),

                };
            } else {
                url = "/editpermission";
                actionData = {
                    id: $("#hid_permissionid").val(),
                    permission_name: $("#txt_permissionname").val(),
                    permission_group: $("#drp_permissiongroup").val(),

                };
            }
            console.log(actionData);
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
                        $("#modal_add_edit_permission").modal('toggle')
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