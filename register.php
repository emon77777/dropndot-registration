<?php
    //Import PHPMailer classes into the global namespace
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require_once 'vendor/autoload.php';
 ?>

<?php include 'database/config.php'; ?>
<?php include 'database/database.php'; ?>
<?php include 'lib/helper.php'; ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST')
	{

        function sendMail($email, $name)
        {
            
            $path = "http://" . $_SERVER['SERVER_NAME'] . "/dropndot-registration/status.php?action=changeStatus&email={$email}";
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.googlemail.com';  //mailtrap SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = '';   //use your mail
                $mail->Password = '';   //use your password
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
            
                $mail->setFrom('noreply@artisansweb.net', 'admin');
                $mail->addAddress($email, $name);
            
                $mail->isHTML(true);
            
                $mail->Subject = 'User activation link';
                $mail->Body    = "Hello <b>{$name}</b>, <p>This is a activation link. click the link below</p><br><a target='_blank' href={$path}>Click here</a>";
            
                if (!$mail->send()) {
                    echo "<div style='color:red;text-align:center;'><b>An error occurd sending mail</b></div>";
                    echo '<br>';
                    echo 'Mailer Error: ' . $mail->ErrorInfo;
                }
                else{
                    echo "<div style='color:green;text-align:center;'><b>Registration Successful. Please check email for activation</b></div>";
                }
            } catch (Exception $e) {
                echo "<div style='color:green;text-align:center;'><b>Registration Successful</b></div>";
                echo "<div style='color:red;text-align:center;'><b>Mail sending failed</b></div>";
                echo "<div style='color:red;text-align:center;'>Mail Error : <b>{$mail->ErrorInfo}</b></div>";
            }
        }

        

        $db = new Database();
        $user_data = new Helper();
        
        $name = $user_data->validation($_POST['name'], 'Name');
        $email = $user_data->validateEmail($_POST['email'], 'Email');
        $phone = $user_data->validation($_POST['phone'], 'Phone');
        $password_new = $user_data->validation($_POST['password'], 'Password');
        $password_confirm = $user_data->validation($_POST['password_confirm'], 'Confirm Password');
        $password = $user_data->hashPassword($password_new);

        if($name && $email && $phone && $password_new && $password_confirm )
        {
            $chk_email = "SELECT * FROM users WHERE email='$email'";
            $result = $db->select($chk_email);
            if($result == true)
            {
                echo "<div style='color:red;text-align:center;'><b>Email already ecists !</b></div>";
            }else{
                $chk_password = $user_data->matchPassword($password_new, $password_confirm);
                if($chk_password == true)
                {
                    $query="INSERT INTO users(name, email, phone, password) VALUES('$name', '$email', '$phone', '$password')";
                    $userInsert=$db->insert($query);
                    if ($userInsert) {
                        sendMail($email, $name);
                    }else{
                        echo "<div style='color:red;text-align:center;'><b>User not inserted !</b></div>";
                    }
                }
                else
                {
                    echo "<div style='color:red;text-align:center;'><b>Password didn't matched !</b></div>";
                }
            }
        }
	}
?>

<?php include('view/partial/header.php')?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form class="form-horizontal" method="post" action="">
                            <div class="form-group">
                                <label for="name" class="cols-sm-2 control-label">Your Name</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter your Name" />
                                    </div>
                                </div>
                            </div>
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
                                <label for="phone" class="cols-sm-2 control-label">Phone</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-users fa" aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter your Phone" />
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
                            <div class="form-group">
                                <label for="confirm" class="cols-sm-2 control-label">Confirm Password</label>
                                <div class="cols-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                        <input type="password" class="form-control" name="password_confirm" id="password_confirm" placeholder="Confirm your Password" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <button type="submit" class="btn btn-primary btn-lg btn-block login-button">Register</button>
                            </div>
                            <div class="login-register">
                                <a href="login.php">Login</a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php include('view/partial/footer.php')?>