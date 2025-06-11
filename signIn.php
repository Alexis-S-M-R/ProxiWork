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
            <form action="./bd_php/getAccountInfo.php" method="post" class="form">
                <h2>Sign In</h2>
                <?php if (isset($_GET['error'])) { ?>
     		        <div class="error"><?php echo  $_GET['error']; ?></div>
     	        <?php } ?>
                <div class="info">
                    <input name="fname" type="text" placeholder="First name">
                    <input name="lname" type="text"  placeholder="Last name">
                    <input name="pnumber" type="number" placeholder="Phone number">
                    <input name="address" type="text" placeholder="Address">
                    <input name="email" type="email" placeholder="Email Address">
                    <input name="password" type="password" placeholder="Password"> 
                </div>
                <button class="button" type="submit">Create account</button>
            </form>
            </div>
        </div>
    </div>
    </form>
</body>
</html>