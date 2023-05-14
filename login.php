<?php
    $title = "Login";
    require_once "includes/header.php";
?>

    <div class="cards animated fadeInDown ">
        <div class="card-pic">
            <img src="images/login.webp" class="img-fluid rounded d-block login-photo" alt="">
        </div>
        <div class="login-card login  ">
            <div class="card login-b">
                <div class="card-title mb-0">
                    <h1 class="text-center">CCCWABCMS</h1>
                    <?php
                        // if(isset($_GET['empty']) and $_GET['empty'] == true) { Errormessage::input_empty() ;}
                        // if(isset($_GET['email']) and $_GET['email'] == "notexist") { Errormessage::email_exist() ;}
                        // if(isset($_GET['login']) and $_GET['login'] == "failed") { Errormessage::login_failed() ;}
                    ?>
                </div>
                <div class="card-body">
                    <form action="controller/user_login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" placeholder="Email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" placeholder="Password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-5 d-flex btn-flex">
                            <button type="submit" name="submit" class="btn btn-lg btn-primary btn-login " onclick="this.blur();">LOGIN</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php
    require_once "includes/footer.php";
?>