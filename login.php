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
                        if(isset($_GET['error']) and $_GET['error'] == "notfound") { echo '<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-0" role="alert">
                            The account you are trying to sign in does not exist.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>' ;}
                        if(isset($_GET['login']) and $_GET['login'] == "failed") { echo '<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-0" role="alert">
                            Invalid username or password.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>' ;}
                          if(isset($_GET['user']) and $_GET['user'] == "inactive") { echo '<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center mb-0" role="alert">
                           This user has been deactivated.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                          </div>' ;}
                    ?>
                    
                </div>
                <div class="card-body">
                    
                    <form action="controller/user_login.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" placeholder="Email or Student ID" value="<?php if(isset($_SESSION['email'])){ echo $_SESSION['email']; } ?>" class="form-control" required>
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