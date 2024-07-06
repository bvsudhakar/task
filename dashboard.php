<?php include_once('connection.php');
 
    session_start();
    @$tid = $_SESSION['admin_id'];
    if ($tid == '') {
    
        echo "<script>window.location='index.php'</script>";
        session_destroy();
    }

$fail = "";
$success = "";
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $marks = $_POST['marks'];

    $csql = mysqli_query($conn, "SELECT * FROM `tbl_students` WHERE `name`='$name' AND `subject`='$subject' ");
    $count = mysqli_num_rows($csql);

    if($count){
        $check = "check_failed";
        header("location:dashboard.php?msg=check");
    }else{
        $sql = mysqli_query($conn, "INSERT INTO `tbl_students`(`name`, `subject`, `marks`) VALUES ('$name','$subject','$marks')");
        if ($sql) {
            $success = "success";
            header("location:dashboard.php?msg=success");
        } else {
            $fail = "Some Errror occured please try.";
            header("location:dashboard.php?msg=error");
        }
    }
}
if (isset($_POST['edit'])) {
    $name = $_POST['name1'];
    $subject = $_POST['subject1'];
    $marks = $_POST['marks1'];
    $id = $_POST['id'];

    $sql = mysqli_query($conn, "UPDATE `tbl_students` SET `name`='$name',`subject`='$subject',`marks`='$marks' WHERE `id`='$id'");
    if ($sql) {
        $success = "success";
        header("location:dashboard.php?msg=edit_success");
    } else {
        $fail = "Some Errror occured please try.";
        header("location:dashboard.php?msg=error");
    }
}
if (isset($_GET['action']) && $_GET['action'] == "delete") {
    $id = $_GET['id'];
    $sql = mysqli_query($conn, "DELETE FROM `tbl_students` WHERE `id`='$id'");
    if ($sql) {
        $success = "del_success";
        header("location:dashboard.php?msg=del_success");
    } else {
        $fail = "Some Errror occured please try.";
        header("location:dashboard.php?msg=error");
    }
}
$ssql = mysqli_query($conn, "SELECT * FROM `tbl_students` ORDER BY id DESC");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Teachers</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
    .error_msg {
        font-size: 15px;
        margin-bottom: 5px;
        color: #f74040;
        display: none;
    }

    .error_msg1 {
        font-size: 15px;
        margin-bottom: 5px;
        color: #f74040;
        display: none;
    }
</style>

<body>

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">PHP TASK</a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><span class="glyphicon glyphicon-home"></span> Home</a></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($_GET['msg']) && $_GET['msg'] == "success") {
        ?>
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> Student data Added Successfull..
            </div>
        <?php
        }
        if (isset($_GET['msg']) &&  $_GET['msg'] == "del_success") {
        ?>
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> Student data Deleted Successfull..
            </div>
        <?php
        }
        if (isset($_GET['msg']) &&  $_GET['msg'] == "edit_success") {
        ?>
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> Student data Edited Successfull..
            </div>
        <?php
        } 
        if (isset($_GET['msg']) &&  $_GET['msg'] == "check") {
            ?>
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Failed!</strong> Student data Already Exists...
                </div>
            <?php
            }?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Subjects</th>
                    <th>Marks</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_object($ssql)) { ?>
                    <tr>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->subject; ?></td>
                        <td><?php echo $row->marks; ?></td>
                        <td>
                            <button class="btn btn-primary" onclick="get_data('<?php echo $row->id; ?>')" data-toggle="modal" data-target="#myModal1">Edit</button>
                            <a href="dashboard.php?action=delete&id=<?php echo $row->id; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete ?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class=" row">

            <button class="btn btn-info" data-toggle="modal" data-target="#myModal">Add Student</button>
        </div>
        <div id="myModal1" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Edit Details</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="post" onsubmit="return validation1();">
                            <div id="edit_form">
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="Name">Student Name:</label>
                                    <div class="col-sm-10">
                                        <input type="test" class="form-control input" id="Name1" placeholder="Enter Name" name="name1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="subject">Subject:</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control input" id="subject1" placeholder="Enter Subject" name="subject1">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2" for="marks">Marks:</label>
                                    <div class="col-sm-10">
                                        <input type="number" class="form-control input" id="marks1" placeholder="Enter Marks" name="marks1">
                                    </div>
                                </div>
                            </div>
                            <span class="error_msg1">Please Enter Correct Details.</span>

                    </div>
                    <div class="modal-footer">
                        <input type="submit" id="login_btn1" class="btn btn-primary" name="edit" value="Edit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>

            </div>
        </div>
        <div id="myModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Detailsr</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" method="post" onsubmit="return validation();">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="Name">Student Name:</label>
                                <div class="col-sm-10">
                                    <input type="test" class="form-control input" id="Name" placeholder="Enter Name" name="name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="subject">Subject:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control input" id="subject" placeholder="Enter Subject" name="subject">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="marks">Marks:</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control input" id="marks" placeholder="Enter Marks" name="marks">
                                </div>
                            </div>
                            <span class="error_msg">Please Enter Correct Details.</span>

                    </div>
                    <div class="modal-footer">
                        <input type="submit" id="login_btn" class="btn btn-primary" name="add" value="Add">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</body>
<script>
    function get_data(id) {
        $.ajax({
            url: "getdata.php",
            type: "post",
            data: {
                'id': id
            },
            success: function(d) {
                $('#edit_form').html(d);
            }
        });
    }

    function validation() {
        var Name = document.querySelector("#Name");
        var subject = document.querySelector("#subject");
        var marks = document.querySelector("#marks");
        var error_msg = document.querySelector(".error_msg");

        if (Name.value.length <= 3 || subject.value.length <= 3 || marks.value.length < 0) {
            error_msg.style.display = "inline-block";
            Name.style.border = "1px solid #f74040";
            subject.style.border = "1px solid #f74040";
            marks.style.border = "1px solid #f74040";
            return false;
        } else {
            //alert("form submitted successfully")
            return true;
        }


    }

    function validation1() {
        var Name = document.querySelector("#Name1");
        var subject = document.querySelector("#subject1");
        var marks = document.querySelector("#marks1");
        var error_msg = document.querySelector(".error_msg1");

        if (Name.value.length <= 3 || subject.value.length <= 3 || marks.value.length < 0) {
            error_msg.style.display = "inline-block";
            Name.style.border = "1px solid #f74040";
            subject.style.border = "1px solid #f74040";
            marks.style.border = "1px solid #f74040";
            return false;
        } else {
            //alert("form submitted successfully")
            return true;
        }


    }
    var input_fields = document.querySelectorAll(".input");
    var login_btn = document.querySelector("#login_btn");

    input_fields.forEach(function(input_item) {
        input_item.addEventListener("input", function() {
            if (input_item.value.length > 3) {
                login_btn.disabled = false;
                login_btn.className = "btn enabled"
            }
        })
    })
</script>


</html>
