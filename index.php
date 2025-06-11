<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>ProxiWork</title>
    <link rel="stylesheet" href="css/signIn.css">
</head>
<body>
    <h1>ProxiWork</h1>
    <div>
        <div class="midle">
            <img class="logo-index" src="assets/img/logo.png">
            <div class="formulaire">
            <form action="./bd_php/login.php" method="post" class="form" >
                <h2>Login Form</h2>
                <?php if (isset($_GET['error'])) { ?>
     		        <div class="error"><?php echo  $_GET['error']; ?></div>
     	        <?php } ?>
    
                <div class="info">
                    <input name="uname" type="email" placeholder="Email Address">
                    <input name="password" type="password" placeholder="Password"> 
                </div>

                <a class="text" href="/ProxiWork/forgotPassword.html">Forgot password?</a>
                <button class="button" type="submit">Login</button>
            </form>
            <button class="button" onclick="window.location.href='signIn.php'">Create account</button>
            </div>
        </div>
    </div>
    </form>
</body>
</html>