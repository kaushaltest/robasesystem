<html>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<!-- Optional theme -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    label
    {
        font-weight: 300;
    }
    </style>
</head>

<body>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Permission of roles </h1>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Permission of roles List</h3>
                            </div>
                            <div class="card-body">
                                <form id="form_permission_of_roles" action="#" method="post">
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <div class="form-group">
                                                <label>Select Role</label>
                                                <select id="drp_role" name="drp_role" class="custom-select drp_role">
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 box_checkall text-right">
                                            <div class="form_group">
                                                <div class="custom-control custom-checkbox mt-5">
                                                    <input class="custom-control-input" type="checkbox" id="chk_checkall" name="chk_checkall">
                                                    <label for="chk_checkall" class="custom-control-label"><b>Check
                                                            All</b></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="all_permission">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-2.2.4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(function() {

            $(".box_checkall").hide();

            //get role data
            getRole();

            function getRole() {
                $.ajax({
                    type: 'GET',
                    url: '/getrole',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function() {
                        $("#preloader").show();
                    },
                    success: function(data) {
                        if (data.success) {
                            if (data.data) {
                                var roleList = "<option value=''>Select Role</option>";
                                for (var i = 0; i < data.data.length; i++) {
                                    roleList += "<option value='" + data.data[i].role_id + "'>" + data
                                        .data[i].role_name + "</option>";
                                }
                                $("#drp_role").html(roleList);
                            }
                        }
                    },
                    complete: function() {
                        $("#preloader").hide();
                    },
                });
            }

            //get all permission list on role change
            $("#drp_role").change(function() {
                $.ajax({
                    type: 'POST',
                    url: '/getpermissionofroles',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        role_id: $(this).val()
                    },
                    beforeSend: function() {
                        $("#preloader").show();
                    },
                    success: function(data) {
                        if (data.success) {
                            if (data.data) {
                                var permission = "";
                                $(".box_checkall").show();
                                for (var i = 0; i < data.data[0].length; i++) {
                                    permission += '<div class="col-md-4 mb-5  ">';
                                    permission +=
                                        '<div class="custom-control custom-checkbox">';
                                    permission +=
                                        '<input class="custom-control-input chk_group" type="checkbox"  id="chk_group_' +
                                        i + '" name="chk_group" value="">';
                                    // permission +=
                                    //     '<input class="custom-control-input chk_group" type="checkbox"  id="chk_group_' +
                                    //     i + '" name="chk_group" value="" disabled>';
                                    permission += '<label for="chk_group_' + i +
                                        '" class="custom-control-label"><b>' + data.data[0][i]
                                        .permission_group + '</b></label>';
                                    permission += '</div>';
                                    for (var j = 0; j < data.data[1].length; j++) {
                                        if (data.data[0][i].permission_group == data.data[1][j]
                                            .permission_group) {
                                            permission += '<div class="form_group">';
                                            permission +=
                                                '<div class="custom-control custom-checkbox">';
                                            permission +=
                                                '<input class="custom-control-input" type="checkbox"  id="chk_' +
                                                data.data[1][j].permission_id +
                                                '" name="chk_permissions[]" value="' + data
                                                .data[1][j].permission_id + '">';
                                            // permission +=
                                            //     '<input class="custom-control-input" type="checkbox"  id="chk_' +
                                            //     data.data[1][j].permission_id +
                                            //     '" name="chk_permissions[]" value="' + data
                                            //     .data[1][j].permission_id + '" disabled>';
                                            permission += '<label for="chk_' + data.data[1][j]
                                                .permission_id +
                                                '" class="custom-control-label">' + data.data[1]
                                                [j].permission + '</label>';
                                            permission += '</div>';
                                            permission += '</div>';
                                        }
                                    }
                                    permission += '</div>';
                                }
                                permission +=
                                    '<div class="col-md-12 mb-5"><button class="btn btn-primary" type="submit">Save Permission</button></div>';
                                $("#all_permission").html(permission);
                                $(data.data[2]).each(function(key, val) {
                                    $('#chk_' + val.permission_access_id).prop(
                                        'checked', true);
                                });
                            } else {
                                $(".box_checkall").hide();
                            }
                        }
                    },
                    complete: function() {
                        $("#preloader").hide();
                    },
                });
            });

            //check all checkbox 
            $("#chk_checkall").click(function() {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });

            //check group wise 
            $(document).on("click", ".chk_group", function() {
                $(this).closest('div').siblings().find('input:checkbox').not(this).prop('checked', this
                    .checked);
            });

            //save permission
            $("#form_permission_of_roles").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '/savepermission',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: $("#form_permission_of_roles").serialize(),
                    beforeSend: function() {
                        $("#preloader").show();
                    },
                    success: function(data) {
                        if (data.success) {
                            toastr.success(data.message);
                            window.location = "./permissionofroles";
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    complete: function() {
                        $("#preloader").hide();
                    },
                });
            });

        });
    </script>
</body>

</html>