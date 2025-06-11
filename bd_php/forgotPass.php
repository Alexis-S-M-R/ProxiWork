<?php 
session_start(); 
include "db_connect.php";

if (isset($_POST['email']))
{
    function validate($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email = validate($_POST["email"]);

    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1)
    {
        $password = uniqid();
        $hash_pass = password_hash($password, PASSWORD_BCRYPT);

        $message = "Hello this is your new password : ";
        $headers = "From: no-reply@votre-site.com\r\n" .
                       "Reply-To: support@votre-site.com\r\n" .
                       "Content-Type: text/plain; charset=UTF-8";

        if (mail($email, "Forgotten password", $message, $headers))
        {
            $changePassSql = "UPDATE user SET mdp=? WHERE email=?";
            $stmt = $conn->prepare($changePassSql);
            $stmt->execute([$hash_pass, $email]);
            echo "yes";
        } else
        {
            echo "no";
        }
    }
}