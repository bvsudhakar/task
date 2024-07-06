<?php include_once('connection.php');
session_start();
@$tid = $_SESSION['admin_id'];
if ($tid == '') {

    echo "<script>window.location='index.php'</script>";
    session_destroy();
}

$id = $_POST['id'];

$ssql = mysqli_query($conn, "SELECT * FROM `tbl_students` WHERE `id`='$id'");
$row = mysqli_fetch_object($ssql);
?>
<div class="form-group">
    <label class="control-label col-sm-2" for="Name">Student Name:</label>
    <div class="col-sm-10">
        <input type="test" class="form-control input" value="<?php echo $row->name; ?>" id="Name1" placeholder="Enter Name" name="name1">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="subject">Subject:</label>
    <div class="col-sm-10">
        <input type="text" class="form-control input" id="subject1" value="<?php echo $row->subject; ?>" placeholder="Enter Subject" name="subject1">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="marks">Marks:</label>
    <div class="col-sm-10">
        <input type="hidden" id="id" value="<?php echo $row->id; ?>" name="id">
        <input type="number" class="form-control input" id="marks1" value="<?php echo $row->marks; ?>" placeholder="Enter Marks" name="marks1">
    </div>
</div>
