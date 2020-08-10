<?php
    include '../lib/session.php';
    Session::checkSession();
?>

<?php include('view/partial/header.php')?>

<nav class="navbar navbar-light bg-light justify-content-between">
    <h3>Kamrul Hasan</h3>
    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Logout</button>
</nav>

<div class="container">
    
        <div class="alert alert-success" role="alert" style="margin-top:10%">
            Hello <b>Kamrul Hasan</b>, Welcome to dashboard
            <span style="float:right"><b>LOGOUT</b></span>
    
    </div>
</div>
<?php include('view/partial/footer.php')?>