<?php 
session_start();
require_once('.login/login/includes/connect.php');
require_once('.login/login/if-loggedin.php');
if(isset($_POST) & !empty($_POST)){
    // PHP Form Validations
    if(empty($_POST['username'])){ $errors[]="User Name field is Required"; }else{
        // Check Username is Unique with DB query
        $sql = "SELECT * FROM users WHERE username=?";
        $result = $db->prepare($sql);
        $result->execute(array($_POST['username']));
        $count = $result->rowCount();
        if($count == 1){
            $errors[] = "User Name already exists in database";
        }
    }
    if(empty($_POST['email'])){ $errors[]="E-mail field is Required"; }else{
        // Check Email is Unique with DB Query
        $sql = "SELECT * FROM users WHERE email=?";
        $result = $db->prepare($sql);
        $result->execute(array($_POST['email']));
        $count = $result->rowCount();
        if($count == 1){
            $errors[] = "E-Mail already exists in database";
        }
    }
    if(empty($_POST['mobile'])){ $errors[]="Mobile field is Required"; }
    if(empty($_POST['password'])){ $errors[]="Password field is Required"; }else{
        // check the repeat password
        if(empty($_POST['passwordr'])){ $errors[]="Repeat Password field is Required"; }else{
            // compare both passwords, if they match. Generate the Password Hash
            if($_POST['password'] == $_POST['passwordr']){
                // create password hash
                $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }else{
                // Display Error Message
                $errors[] = "Both Passwords Should Match";
            }
        }
    }

    // CSRF Token Validation
    if(isset($_POST['csrf_token'])){
        if($_POST['csrf_token'] === $_SESSION['csrf_token']){
        }else{
            $errors[] = "Problem with CSRF Token Validation";
        }
    }
    // CSRF Token Time Validation
    $max_time = 60*60*24; // in seconds
    if(isset($_SESSION['csrf_token_time'])){
        $token_time = $_SESSION['csrf_token_time'];
        if(($token_time + $max_time) >= time() ){
        }else{
            $errors[] = "CSRF Token Expired";
            unset($_SESSION['csrf_token']);
            unset($_SESSION['csrf_token_time']);
        }
    }

    // If no Errors, Insert the Values into users table
    if(empty($errors)){
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $result = $db->prepare($sql);
        $values = array(':username'=> $_POST['username'],
                        ':email'=> $_POST['email'],
                        ':password'=> $pass_hash
                        );
        $res = $result->execute($values);
        if($res){
            $messages[] = "User Registered";
            // get the id from last insert query and insert a new record into user_info table with mobile number
            $userid = $db->lastInsertID();
            $uisql = "INSERT INTO user_info (uid, mobile) VALUES (:uid, :mobile)";
            $uiresult = $db->prepare($uisql);
            $values = array(':uid'=> $userid,
                            ':mobile'=> $_POST['mobile']
                            );
                            header("Location: index.php");
                return;
            $uires = $uiresult->execute($values) or die(print_r($result->errorInfo(), true));
            if($uires){
                $messages[] = "Added User Meta Information";
                
            }

        }
        
        
        
    }
}
// CSRF Protection
// 1. Create CSRF token
$token = md5(uniqid(rand(), TRUE));
$_SESSION['csrf_token'] = $token;
$_SESSION['csrf_token_time'] = time();

// 2. add CSRF token to form
// 3. check the CSRF token on form submission
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dolly Web Development</title>
    <link rel="stylesheet" href="css/RESET.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/register.css">
    <script src="js/jquery.js" defer></script>
    <script src="js/app.js" defer></script>

</head>

<body>
    <div id="page">
            <div class="signup-form-cont">
            <div class="signin-exit-cont">
                    <i class="fas fa-times-circle signin-exit-btn"></i>
                </div>
                <h2 class="form-title">Sign-Up</h2>
                <form role="form" method="post">
                        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                        <fieldset>
                            <div class="form-group">
                                <label for="username">Username</label><br/>
                                <input class="form-control" placeholder="Username" name="username" type="text" autofocus value="<?php if(isset($_POST['username'])){ echo $_POST['username']; } ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">E-mail</label><br/>
                                <input class="form-control" placeholder="example@email.com" name="email" type="email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
                            </div>
                            <div class="form-group">
                                <label for="mobile">Phone Number</label><br/>
                                <input class="form-control" placeholder="Mobile" name="mobile" type="text" value="<?php if(isset($_POST['mobile'])){ echo $_POST['mobile']; } ?>">
                            </div>
                            <div class="form-group">
                            <label for="password">Password</label><br/>
                                <input class="form-control" placeholder="********" name="password" type="password" value="">
                            </div>
                            <div class="form-group">
                                <label for="passwordr">Re-type Password</label><br/>
                                <input class="form-control" placeholder="********" name="passwordr" type="password" value="">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="submit" class="btns btn-lg btn-success btn-block" value="Register" />
                            <button class="btns" id="sign-up-cancel-btn"><a href="index.php">Cancel</a></button>
                        </fieldset>
                    </form>
            </div>
            </div>



        <footer>
            <div class="copyright-cont">
                <p class="copyright">&#169;Copyright 2021</p>
            </div>
            <div class="social-cont">
                <a href="https://www.facebook.com/dev.dollinger" alt="My Facebook Page" target="_blank"><i
                        class="fab fa-facebook-square" title="Facebook"></i></a>
                <a href="https://github.com/edolly2" alt="My GitHub Page" target="_blank"><i
                        class="fab fa-github-square" title="GitHub"></i></a>
                <a href="https://stackexchange.com/users/20534397/edolly2" alt="My Stack Overflow Page"
                    target="_blank"><i class="fab fa-stack-overflow" title="StackOverflow.com"></i></a>
                <a href="https://twitter.com/DevDollinger" alt="My Twitter Page" target="_blank"><i
                        class="fab fa-twitter-square" title="Twitter"></i></a>
                <a href="https://www.linkedin.com/in/eric-dollinger-967876202/" alt="My Linkedin Page"
                    target="_blank"><i class="fab fa-linkedin last" title="LinkedIn"></i></a>
            </div>
        </footer>
    </div>
</body>

</html>