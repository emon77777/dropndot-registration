<?php 
    include 'lib/session.php';
    Session::init();
    Session::checkLoggidIn();
?>
<?php include 'database/config.php'; ?>
<?php include 'database/database.php'; ?>
<?php include 'lib/helper.php'; ?>
<?php 
    if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
        $db = new Database();
        $help = new Helper();

        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $chk_auth = "SELECT * FROM users WHERE email='$email' AND password ='$password' LIMIT 1";
        $result = $db->select($chk_auth);
        if($result == true)
        {
            $value = mysqli_fetch_array($result);
            $row   = mysqli_num_rows($result);
            if ($value['status'] == 1) {
                if ($row > 0) {
                    Session::set("login", true);
                    Session::set("email", $value['email']);
                    Session::set("userId", $value['id']);
                    header("Location:dashboard.php");
                } else {
                    Session::destroy();
                }
            }else{
                echo "<div style='color:red;text-align:center;'><b>Your email is not verified yet !</b></div>";
            }
        }else{
            echo "<div style='color:red;text-align:center;'><b>Email And Password do not match !</b></div>";
        }


    }
?>
<?php include('view/partial/header.php')?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form class="form-horizontal" method="post" action="">
                            <div class="form-group">
                                <label for="email" class="cols-sm-2 control-label">Your Email</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Enter your Email" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="cols-sm-2 control-label">Password</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter your Password" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <button type="submit" class="btn btn-primary btn-lg btn-block login-button">Login</button>
                            </div>
                            <div class="login-register">
                                <a href="index.php">Register</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php include('view/partial/footer.php')?>