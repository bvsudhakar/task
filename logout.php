<?php
session_start();
session_unset();

unset($_SESSION['admin_id']);
session_destroy();

echo "<script>window.location='index.php'</script>";

?>
