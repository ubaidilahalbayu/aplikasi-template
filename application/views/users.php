<!-- Modal -->
<div class="modal fade" id="changePassModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Form Change Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="form-changePass">
            <input type="text" hidden id="id_user_dummy" name="id_user_dummy">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" aria-describedby="passHelp">
                <div id="passHelp" class="form-text">Must be 8-20 characters long.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPass" name="confirmPass">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Same Password</label>
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" form="form-changePass">Save changes</button>
      </div>
    </div>
  </div>
</div>

<hr>
<h3>Data User</h3>
<table id="myTable" class="display">
    <thead>
        <tr>
            <th>No</th>
            <th>Oauth Provider</th>
            <th>Oauth UId</th>
            <th>Email</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Block</th>
            <th>Created</th>
            <th>Modified</th>
            <th>Action</th>
        </tr>
    </thead>
</table>
<script type="text/javascript">
    $(document).ready(function (){
        // console.log($.md5('admin'));
        var access_token = '<?php echo !empty($this->session->userdata('access_token'))?$this->session->userdata('access_token'):''; ?>'
        var table = new DataTable('#myTable', {
            // config options...
            columnDefs: [
                { width: '5%', targets: 0 },
                { width: '25%', targets: 9 },
                { className: "text-center", targets: '_all'}
            ]
        });
        renderTable();

        table.on('click', '.btn-block', function () {
            var id_user = $(this).attr('id_user');
            var is_block = $(this).attr('is_block');
            var email = $(this).attr('email');
            var msg = is_block==1?"Mau di Blockir?":"Mau di Aktifkan Kembali?"
            if (confirm("Apakah user dengan email "+email+" "+msg)) {                
                $.ajax({
                    url: "http://localhost/aplikasi-template/api/users",
                    headers: {
                        "Authorization": access_token
                    },
                    method: "PUT",
                    dataType: 'json',
                    data: {
                        "where_data": {
                            "id_user": id_user
                        },
                        "update_data": {
                            "is_block": is_block
                        }
                    }
                }).done(function (result) {
                    alert(result.message);
                    renderTable();
                });
            }
        });

        table.on('click', '.btn-changePass', function(){
            $("#id_user_dummy").val($(this).attr('id_user'));
        });

        $("#form-changePass").on("submit", function(evt){
            evt.preventDefault();
            formData = $(this).serialize();
            data = [];
            formData.split('&').forEach(s => {
                var [key, value] = s.split('=');
                data[key] = value;
            });
            if (data['password'].length < 8 || data['password'].length > 20) {
                alert("Must be 8-20 characters long!");
            }else{
                if (data['password'] !== data['confirmPass']) {
                    alert("Not Same Password with Confirm Password!!");
                }else{
                    var password = $.md5(data['password']);
                    $.ajax({
                        url: "http://localhost/aplikasi-template/api/users",
                        headers: {
                            "Authorization": access_token
                        },
                        method: "PUT",
                        dataType: 'json',
                        data: {
                            "where_data": {
                                "id_user": data['id_user_dummy']
                            },
                            "update_data": {
                                "password": password
                            }
                        }
                    }).done(function (result) {
                        alert(result.message);
                        renderTable();
                    });
                }
            }
            // console.log(data['password'].length);
        })

        function renderTable() {
            table.clear().draw(false);
            $.ajax({
                url: "http://localhost/aplikasi-template/api/users",
                headers: {
                    "Authorization": access_token
                },
                method: "GET",
                dataType: 'json'
            }).done(function (result) {
                if (result.status) {
                    var data = result.data;
                    var rowTable = [];
                    for (let i = 0; i < data.length; i++) {
                        var columnTable = [];
                        columnTable.push(i+1);
                        var oauth_prov = data[i].oauth_provider;
                        var blk = "No";
                        var btn_changePass = '';
                        var btn_block = '<button type="button" class="btn btn-block btn-sm btn-danger" id_user="'+data[i].id_user+'" is_block ="'+1+'" email="'+data[i].email+'">Block</button>';
                        if (oauth_prov == "") {
                            oauth_prov = "Login Password";
                            btn_changePass = '<button type="button" class="btn btn-changePass btn-sm btn-warning" id_user="'+data[i].id_user+'" data-bs-toggle="modal" data-bs-target="#changePassModal">Change Password</button>';
                        }
                        if (data[i].is_block == 1) {
                            blk = "Yes";
                            btn_block = '<button type="button" class="btn btn-block btn-sm btn-success" id_user="'+data[i].id_user+'" is_block ="'+0+'" email="'+data[i].email+'">Activate</button>';
                        }
                        if (data[i].is_admin == 1) {
                            btn_block = "";
                        }
                        columnTable.push(oauth_prov);
                        columnTable.push(data[i].oauth_uid);
                        columnTable.push(data[i].email);
                        columnTable.push(data[i].first_name);
                        columnTable.push(data[i].last_name);
                        columnTable.push(blk);
                        columnTable.push(data[i].created);
                        columnTable.push(data[i].modified);
                        columnTable.push(btn_changePass+' '+btn_block);
                        // // console.log(columnTable);
                        rowTable.push(columnTable);
                        table.row.add(columnTable).draw(false);
                    }
                }
            });
        }
    });
</script>