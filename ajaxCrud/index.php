<!DOCTYPE html>
<html>
    <head>
        <title> Ajax CRUD Demo</title>
        <link href="includes/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <script src="includes/jquery.js" type="text/javascript"></script>
        <script src="includes/bootstrap.min.js" type="text/javascript"></script>
        <script src="includes/jquery.twbsPagination.min.js" type="text/javascript"></script>
        <script src="includes/validator.min.js" type="text/javascript"></script>
        <script src="includes/toastr.min.js" type="text/javascript"></script>
        <link href="includes/toastr.min.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>


        <div class="container">
            <div class="row">
                <div class="col-lg-12 margin-tb">					
                    <div >
                        <center><h2>USER DETAILS</h2></center>
                    </div>
                    <div class="pull-right" margin="bottom:10px;">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#add-user">
                            Create Item
                        </button>
                    </div>
                </div>
            </div>


            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th width="200px">Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>


            <ul id="pagination" class="pagination-sm"></ul>


            <!-- Create Item Modal -->
            <div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">Add User</h4>
                        </div>


                        <div class="modal-body">
                            <form data-toggle="validator" action="ajaxfiles/create.php" method="POST">

                                <div class="form-group">
                                    <label class="control-label" for="name">Name :-</label>
                                    <input type="text" name="name" class="form-control" data-error="Please Enter Name :-" required />
                                    <div class="help-block with-errors"></div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label" for="age">Age :- </label>
                                    <input type="number" name="age" class="form-control" data-error="Please Enter Age" required> 
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="gender"> Gender :-</label>
                                    <select name="gender" class="form-control" >
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label" for="address">Address :- </label>
                                    <textarea name="address" class="form-control" data-error="Please Enter Address" required> </textarea>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn crud-submit btn-success">Submit</button>
                                </div>


                            </form>


                        </div>
                    </div>


                </div>
            </div>


            <!-- Edit Item Modal -->
            <div class="modal fade" id="edit-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            <h4 class="modal-title" id="myModalLabel">Edit User</h4>
                        </div>


                        <div class="modal-body">
                            <form data-toggle="validator" action="ajaxfiles/update.php" method="put">
                                <input type="hidden" name="id" class="edit-id">


                                <div class="form-group">
                                    <label class="control-label" for="name">Name :-</label>
                                    <input type="text" name="name" class="form-control" data-error="Please Enter Name :-" required />
                                    <div class="help-block with-errors"></div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label" for="age">Age :- </label>
                                    <input type="number" name="age" class="form-control" data-error="Please Enter Age" required> 
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label" for="gender"> Gender :-</label>
                                    <select name="gender" class="form-control" >
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label" for="address">Address :- </label>
                                    <textarea name="address" class="form-control" data-error="Please Enter Address" required> </textarea>
                                    <div class="help-block with-errors"></div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success edit-submit">Submit</button>
                                </div>


                            </form>


                        </div>
                    </div>
                </div>
            </div>


        </div>
    </body>

    <script type="text/javascript">
        var url = "http://localhost/ajaxcrud/";
        $(document).ready(function () {


            var page = 1;
            var current_page = 1;
            var total_page = 0;
            var is_ajax_fire = 0;


            manageData();
            /* manage data list */
            function manageData() {
                $.ajax({
                    dataType: 'json',
                    url: url + 'ajaxfiles/getdata.php',
                    data: {page: page}
                }).done(function (data) {
                    total_page = Math.ceil(data.total / 5);
                    current_page = page;


                    $('#pagination').twbsPagination({
                        totalPages: total_page,
                        visiblePages: current_page,
                        onPageClick: function (event, pageL) {
                            page = pageL;
                            if (is_ajax_fire != 0) {
                                getPageData();
                            }
                        }
                    });


                    manageRow(data.data);
                    is_ajax_fire = 1;


                });


            }


            /* Get Page Data*/
            function getPageData() {
                $.ajax({
                    dataType: 'json',
                    url: url + 'ajaxfiles/getdata.php',
                    data: {page: page}
                }).done(function (data) {
                    manageRow(data.data);
                });
            }


            /* Add new User table row */
            function manageRow(data) {
                var rows = '';
                $.each(data, function (key, value) {
                    console.log(value);
                    rows = rows + '<tr>';
                    rows = rows + '<td> ' + value.name + '</td>';
                    rows = rows + '<td>' + value.age + '</td>';
                    rows = rows + '<td>' + value.gender + '</td>';
                    rows = rows + '<td>' + value.address + '</td>';
                    rows = rows + '<td data-id="' + value.id + '">';
                    rows = rows + '<button data-toggle="modal" data-target="#edit-user" class="btn btn-primary edit-user">Edit</button> ';
                    rows = rows + '<button class="btn btn-danger remove-user">Delete</button>';
                    rows = rows + '</td>';
                    rows = rows + '</tr>';
                });


                $("tbody").html(rows);
            }


            /* Create new User */
            $(".crud-submit").click(function (e) {

                e.preventDefault();
                var form_action = $("#add-user").find("form").attr("action");
                var name = $("#add-user").find("input[name='name']").val();
                var age = $("#add-user").find("input[name='age']").val();
                var gender = $("#add-user").find("select[name='gender']").val();
                var address = $("#add-user").find("textarea[name='address']").val();
                if (name != '' && age != '') {

                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: url + form_action,
                        data: {age: age, name: name, gender: gender, address: address},
                        success: function (response) {
                            console.log("oj");
                            $("#add-user").find("input[name='name']").val('');
                            $("#add-user").find("input[name='age']").val('');
                            $("#add-user").find("select[name='gender']").val('');
                            $("#add-user").find("textarea[name='address']").val('');
                            getPageData();
                            $(".modal").modal('hide');
                            toastr.success('User Added Successfully.', 'Success Alert', {timeOut: 5000});
                        }
                    });
                } else {
                    alert('Please Fill Details')
                }


            }
            );


            /* Remove User */
            $("body").on("click", ".remove-user", function () {
                var id = $(this).parent("td").data('id');
                var c_obj = $(this).parents("tr");

                $.ajax({
                    dataType: 'json',
                    type: 'POST',
                    url: url + 'ajaxfiles/delete.php',
                    data: {id: id}
                }).done(function (data) {
                    c_obj.remove();
                    toastr.success('User Deleted Successfully.', 'Success Alert', {timeOut: 5000});
                    getPageData();
                });


            });


            /* Edit User */
            $("body").on("click", ".edit-user", function () {

                var id = $(this).parent("td").data('id');
                var address = $(this).parent("td").prev("td").text();
                var name = $(this).parent("td").prev("td").prev("td").prev("td").prev("td").text();
                var age = $(this).parent("td").prev("td").prev("td").prev("td").text();
                var gender = $(this).parent("td").prev("td").prev("td").text();
                console.log(id);

                $("#edit-user").find("input[name='name']").val(name);
                $("#edit-user").find("input[name='age']").val(age);
                $("#edit-user").find("textarea[name='address']").val(address);
                $("#edit-user").find("select[name='gender']").val(gender);
                $("#edit-user").find(".edit-id").val(id);





            });


            /* Updated user */
            $(".edit-submit").click(function (e) {


                e.preventDefault();
                var form_action = $("#edit-user").find("form").attr("action");
                var name = $("#edit-user").find("input[name='name']").val();
                var age = $("#edit-user").find("input[name='age']").val();
                var gender = $("#edit-user").find("select[name='gender']").val();
                var address = $("#edit-user").find("textarea[name='address']").val();


                var id = $("#edit-user").find(".edit-id").val();


                if (name != '' && age != '') {
                    $.ajax({
                        dataType: 'json',
                        type: 'POST',
                        url: url + form_action,
                        data: {name: name, age: age, address: address, gender: gender, id: id}
                    }).done(function (data) {
                       getPageData();
                            $(".modal").modal('hide');
                            toastr.success('User Added Successfully.', 'Success Alert', {timeOut: 5000});
                    });
                } else {
                    alert('You are missing title or description.')
                }


            });
        });
    </script>
</html>