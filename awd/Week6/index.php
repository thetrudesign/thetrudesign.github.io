<!DOCTYPE HTML>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Tru Dinh Week 6</title>
    <!--Jquery 3.2.1 --->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!--Jquery 3.2.1 --->
    <!--bootstrap 4.0-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--bootstrap 4.0-->
    <!--Jquery validate -->
    <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js">


    </script>
    <!--Jquery validate -->

    <script type="text/javascript" src="jquery.blockUI.js"></script>

    <link href="style.css" rel="stylesheet" type="text/css" media="screen" />



    <script type="text/javascript">
        var debugging = false;


        $(document).ready(function() {
            //cache common selectors
            $register = $('#register');
            $login = $('#login');
            $loginInvalid = $('#login-invalid');
            $results = $('#results');

            //validate the forms using the validate plugin. 

            $register.validate({
                messages: {
                    email: {
                        required: "Please enter email address",
                        email: "Enter a valid email address",
                        remote: jQuery.validator.format("{0} is already taken, please enter a different address.")
                    },
                    username: {
                        required: "Please enter a username",
                        remote: jQuery.validator.format("{0} is already taken, please enter a different username.")
                    }
                },
                submitHandler: function() {
                    //cache common selectors
                    $first_name = $('#first_name');
                    $last_name = $('#last_name');
                    $email = $('#email');
                    $username = $('#username');
                    $password = $('#password');
                    $.ajax({
                        type: 'POST',
                        url: 'process.php',
                        dataType: 'JSON',
                        data: {
                            'function': 'register',
                            'debugging': debugging,
                            'username': $username.val(),
                            'password': $password.val(),
                            'first_name': $first_name.val(),
                            'last_name': $last_name.val(),
                            'email': $email.val()
                        },

                        beforeSend: function() {
                            //start blocking of page
                            $.blockUI({
                                message: '<h4><i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>   Processing request, please wait...</h4>',
                                css: {
                                    border: 'none',
                                    padding: '15px',
                                    backgroundColor: '#212529',
                                    borderRadius: '5px',
                                    '-webkit-border-radius': '3px',
                                    '-moz-border-radius': '3px',
                                    opacity: .5,
                                    color: '#ffffff'
                                }, //end css
                                overlayCSS: {
                                    backgroundColor: '#cce5ff',
                                    opacity: 0.9
                                } //end overlayCSS
                            }); //end blockUI
                        },
                        complete: function() {
                            $.unblockUI();
                        }, //end complete
                        success: function(data) {
                            if (data.result == 'true') {
                                //user added
                                $register.slideUp(function() {
                                    //show complete message after form slides away.
                                    $('#register-complete').fadeIn();
                                });

                            } else {
                                $results.html('Sorry, an error occurred with your request: ' + data.message);
                            }
                        } //end success()
                    }); //end ajax
                } //end submitHandler
            }); //end validate      
            $login.validate({
                messages: {
                    username: {
                        required: "Please enter username"
                    },
                    password: {
                        required: "Please enter password"
                    }
                },
                submitHandler: function() {
                    //get the username and password for login page. 
                    $username = $('#loginUsername');
                    $password = $('#loginPassword');

                    $.ajax({
                        type: 'POST',
                        url: 'process.php',
                        dataType: 'JSON',
                        data: {
                            'function': 'login',
                            'debugging': debugging,
                            'username': $username.val(),
                            'password': $password.val()
                        },
                        beforeSend: function() {
                            //start blocking of page
                            $.blockUI({
                                message: '<h4><i class="fa fa-circle-o-notch fa-spin" style="font-size:24px"></i>   Processing request, please wait...</h4>',
                                css: {
                                    border: 'none',
                                    padding: '15px',
                                    backgroundColor: '#212529',
                                    borderRadius: '5px',
                                    '-webkit-border-radius': '3px',
                                    '-moz-border-radius': '3px',
                                    opacity: .5,
                                    color: '#ffffff'
                                }, //end css
                                overlayCSS: {
                                    backgroundColor: '#cce5ff',
                                    opacity: 0.9
                                } //end overlayCSS
                            }); //end blockUI
                        },
                        complete: function() {
                            $.unblockUI();
                        }, //end complete
                        success: function(data) {
                            if (data.login == 'true') {
                                //login successful
                                $login.slideUp(function() {
                                    //show complete message after form slides away.
                                    $('#login-complete').fadeIn();
                                });

                                $loginInvalid.hide();

                            } else {
                                //show the invalid login message. 
                                $loginInvalid.fadeIn();
                            }
                        } //end success()
                    }); //end ajax
                } //end submitHandler
            }); //end login
        }); //end document.ready()

    </script>
</head>

<body>

    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <h1>Random Message Board</h1>
                <hr/>

                <div class="row">
                    <div id="message" class="col-6">
                        <?php include('message.php');
					?>
                    </div>
                    <div class="col-6 alert alert-info">
                        <p>Keep your message PG rated</p>
                        <hr/>
                        <p>Refresh the page if your message isn't showing</p>
                        <hr/>
                        <p>Create an account and login to post messages on this board</p>
                    </div>
                </div>

                <hr/>
            </div>
        </div>
        <div class="row">
            <div class="col-6 mt-5">
                <div id="register-box" class="box">
                    <h2>Create a new account</h2>
                    <div id="register-complete" class="alert alert-success">
                        <strong>Your registration is complete. You may now login. </strong>
                    </div>
                    <form action="" method="post" name="register" id="register">
                        <p>
                            <label for="first_name" class="col-form-label">First Name:</label>
                            <input type="text" name="first_name" id="first_name" class="required form-control col-8" />
                        </p>
                        <p>
                            <label for="last_name" class="col-form-label">Last Name:</label>
                            <input type="text" name="last_name" id="last_name" class="required form-control col-8" />
                        </p>
                        <p>
                            <label for="email" class="col-form-label">Email:</label>
                            <input type="text" name="email" id="email" class="required email form-control col-8" remote="check_email.php" />
                        </p>

                        <p>
                            <label for="username" class="col-form-label">Username:</label>
                            <input type="text" name="username" id="username" class="required form-control col-8" remote="check_user.php" />
                        </p>

                        <p>
                            <label for="password" class="col-form-label">Password:</label>
                            <input type="password" name="password" id="password" class="required form-control col-8" />
                        </p>

                        <p>
                            <input type="submit" name="btnRegister" id="btnRegister" value="Register" class="btn" />
                        </p>
                    </form>
                </div>
            </div>
            <div class="col-6 mt-5">
                <div id="login-box" class="box alert alert-primary">
                    <h2>Login</h2>
                    <div id="login-complete" class="alert alert-success">
                        <strong>You are now logged in. <br/><a class="btn btn-success" href="protected.php">View Your Account</a></strong>
                    </div>
                    <div id="login-invalid">
                        <strong>Invalid login, please try again.</strong>
                    </div>
                    <form action="" method="post" name="login" id="login">
                        <p>
                            <label for="username" class="col-form-label">Username:</label>
                            <input type="text" name="loginUsername" id="loginUsername" class="required form-control" />
                        </p>

                        <p>
                            <label for="password" class="col-form-label">Password:</label>
                            <input type="password" name="loginPassword" id="loginPassword" class="required form-control" />
                        </p>

                        <p>
                            <input type="submit" name="btnLogin" id="btnLogin" value="Login" class="btn btn-primary form-control" />
                        </p>
                    </form>

                </div>


                <div id="results">
                </div>

            </div>
        </div>
    </div>

</body>

</html>