<?php
    $connection = mysqli_connect("localhost","root","");
    $db = mysqli_select_db($connection,"lms");
    $query = "DELETE FROM issued_books WHERE book_no = $_GET[bn]";
    $query_run = mysqli_query($connection,$query);
?>
<script type="text/javascript">
    alert("Issued book deleted successfully...");
    window.location.href = "view_issued_book.php";
</script>
