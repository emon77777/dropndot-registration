<?php
    include 'lib/session.php';
    Session::checkSession();
?>

<?php include('view/partial/header.php')?>

<nav class="navbar navbar-light bg-light justify-content-between">
    <h3>Kamrul Hasan</h3>

    <?php
        if (isset($_GET['action']) && $_GET['action']=="logout") {
            Session::destroy();
        }
    ?>

    <a href="?action=logout" class="btn btn-outline-success my-2 my-sm-0">Logout</a>
</nav>

<div class="container">
    
        <div class="alert alert-success text-center" role="alert" style="margin-top:10%">
            Hello <b>Kamrul Hasan</b>, Welcome to dashboard
    </div>
</div>
<?php include('view/partial/footer.php')?>