<?php 
session_start();
require_once('.login/login/includes/connect.php');
require_once('.login/login/if-loggedin.php');
if(isset($_POST) & !empty($_POST)){
    // PHP Form Validations
    if(empty($_POST['email'])){ $errors[]="User Name / E-Mail field is Required"; }
    if(empty($_POST['password'])){ $errors[]="Password field is Required"; }
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

    if(empty($errors)){
        // Check the Login Credentials
        $sql = "SELECT * FROM users WHERE ";
        if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            $sql .= "email=?";
        }else{
            $sql .= "username=?";
        }
        $result = $db->prepare($sql);
        $result->execute(array($_POST['email']));
        $count = $result->rowCount();
        $res = $result->fetch(PDO::FETCH_ASSOC);
        if($count == 1){
            // Compare the password with password hash
            if(password_verify($_POST['password'], $res['password'])){
                // regenerate session id
                session_regenerate_id();
                $_SESSION['login'] = true;
                $_SESSION['id'] = $res['id'];
                $_SESSION['last_login'] = time();

                // redirect the user to members area/dashboard page
                header("location: index.php");
            }else{
                $errors[] = "User Name / E-Mail & Password Combination not Working";
            }
        }else{
            $errors[] = "User Name / E-Mail not Valid";
        }
    }
} 
// 1. Create CSRF token
$token = md5(uniqid(rand(), TRUE));
$_SESSION['csrf_token'] = $token;
$_SESSION['csrf_token_time'] = time();
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
    <script src="js/jquery.js" defer></script>
    <script src="js/app.js" defer></script>

</head>

<body>
    <div id="page">
        <header>
            <div class="logo-cont">
                <a href="index.html"><img src="assets/logo/DWD.svg" alt="Dolly Web Development Logo" class="logo"></a>
            </div>
            <section class="top-section-cont">
                <div class="top-title-cont">
                    <h1>Dolly Web Development</h1>
                </div>
                <div class="cent-wrapper">
                    <nav class="top-nav">
                        <ul>
                            <li class="top-nav-li">HOME</li>

                            <li class="top-nav-li" id="account">ACCOUNT</li>

                            <li class="top-nav-li">ACCESSIBILITY</li>
                            <li class="top-nav-li">ABOUT</li>
                            <li class="top-nav-li">HELP</li>
                            <li class="top-nav-li">CONTACT</li>
                        </ul>
                    </nav>
                </div>
            </section>
            <div class="portal-btn-cont">
                <button class="portal-btn btns">CUSTOMER PORTAL</button>
            </div>
        </header>
        <main>
            <div class="signin-modal-cont">
                <div class="signin-exit-cont">
                    <i class="fas fa-times-circle signin-exit-btn"></i>
                </div>
                <h2 class="form-title">Sign-In</h2>
                <form role="form" method="post" class="signin-form">
                <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
                    <label for="email" class="label-email">Email</label><br/><br/>
                    <input type="email" name="email" id="email" value="" placeholder="example@email.com" autofocus value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>"><br/><br/>
                    <label for="password" class="label-password">Password</label><br/><br/>
                    <input type="password" name="password" id="password" value="" placeholder="********">
                    <div class="signin-link-cont">
                        <p class="forgot"><a href="forgot.html" class="form-links">Forgot password?</a></p>
                        <p class="create"><a href="./register.php" class="form-links">Create an account?</a></p>
                    </div>
                    <div class="signin-btn-cont">
                        <input type="submit" name="submit" id="submit" value="Login" class="form-btns form-submit btns">
                    </div>
                </form>
            </div>



            <div class="details-form-cont">
                <div class="signin-exit-cont">
                    <i class="fas fa-times-circle signin-exit-btn details-exit-btn"></i>
                </div>
                <form role="form" method="post" class="details-form">
                    <div class="key-cont">
                        <br/>
                        <h3 class="key">KEY</h3><br/>
                        <hr/>
                        <p><span class="red">*</span> = REQUIRED</p>
                    </div>
                    <div class="details-form-title-cont">
                        <h2>Details Form</h2>
                    </div>
                    <label for="name">Name: <span class="red">*</span></label>
                    <input type="text" name="name" id="name"><br/>
                    <label for="details-email">Email: <span class="red">*</span></label>
                    <input type="email" name="details-email" id="details-email"><br/>
                    <label for="phone">Phone Number: <span class="red">*</span></label>
                    <input type="tel" name="phone" id="phone"><br/>
                    <label for="company">Company Name:</label>
                    <input type="text" name="company" id="company"><br/>
                    <hr/>
                    <label for="budget">-Budget-</label><br/>
                    <div class="budget-slider-cont">
                        <input type="range" name="budget" id="budget" min="50" max="10000" value="50" class="slider" step="50">
                        <p>USD: $<span id="budget-amount"></span></p>
                    </div>
                    <hr/>
                    <label for="deadline">-Deadline-</label><br/>
                    <input type="radio" name="deadline" id="less-than" value="less-than">
                    <label for="less-than"> &lt1 Week</label>
                    <input type="radio" name="deadline" id="one-two" value="one-two">
                    <label for="one-two">1-2 weeks</label>
                    <input type="radio" name="deadline" id="three-four" value="three-four">
                    <label for="three-four">3-4 weeks</label><br/>
                    <input type="radio" name="deadline" id="two-month" value="two-month">
                    <label for="two-month">2 Months</label>
                    <input type="radio" name="deadline" id="three-month" value="three-month">
                    <label for="three-month">3 Months</label>
                    <input type="radio" name="deadline" id="four-month" value="four-month">
                    <label for="four-month">4 Months</label><br/>
                    <input type="radio" name="deadline" id="five-month" value="five-month">
                    <label for="five-month">5 Months</label>
                    <input type="radio" name="deadline" id="six-month" value="six-month">
                    <label for="six-month">6 Months</label>
                    <input type="radio" name="deadline" id="year" value="year">
                    <label for="year">1 Year</label><br/>
                    <input type="radio" name="deadline" id="none" value="none">
                    <label for="none">None</label><br/>
                    <hr/>
                    <label for="additional">-Briefly Describe Your Website or App Vision- <span class="red">*</span></label><br/>
                    <textarea name="additionl" id="additional" cols="30" rows="10"></textarea><br/>
                    <input type="submit" value="Submit" name="details-submit" id="details-submit">                    
                </form>
            </div>

            <div class="submit-modal-cont">
                <h3>Thank you for your interest!</h3>
                <p>You will here a response within 24 hours.</p>
                <p>Have a great day!</p>
            </div>







            <div class="main-title-cont main-home">
                <h2>- Get A Free Quote And Start A Website Build Today -</h2>
            </div>
            <section class="home-info-section main-home">
                <div class="main-info-cont">
                    <p class="main-info-p">Get started with a website build from a professional, knowledgeable, and
                        leading web developer.</p>
                    <div class="get-started-btn-cont">
                        <button class="get-started-btn btns">GET STARTED</button><br />
                    </div>
                    <p class="or">Or</p>
                    <p class="learn-more"><a href="help.html" class="learn-more-link" title="Need Some Help?"><span class="lm-dash">-</span> LEARN MORE <span class="lm-dash">-</span></a></p>
                </div>
            </section>
        </main>
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