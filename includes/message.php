<?php
if(isset($_SESSION['message']))
{
    ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>HEY</strong> <?$_SESSION['message']; ?>
        <button type=button class="btn-close" data-bs-toggle="alert" aria-label="Close"></button>
    </div>
    <?php
    unset($_SESSION['message']);
}
?>