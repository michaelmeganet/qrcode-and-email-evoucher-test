<?php
session_start();
include "new-header.php";

if(isset($_POST['reset_click'])){
    session_destroy();
}
?>
<div class="container" style="text-align:center">
    &nbsp;
    <h2>Welcome to Ishin Japanese Dining Control</h2>
    <h3>Select one of the top right menu to continue</h3>
</div>


<?php
include 'new-footer.php';
?>