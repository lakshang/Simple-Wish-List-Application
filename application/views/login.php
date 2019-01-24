<html lang="en">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <meta charset="UTF-8">
        <title>Login/Register</title>
    </head>
    <body>
        <div class="container register-form">
            <br><br>
            <h4>Registration Form</h4>
            <table>
                <tr>
                    <td>Username</td>
                    <td><input type="text" class="form-control username-input" required=""></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" class="form-control password-input" required=""></td>
                </tr>
                <tr>
                    <td>Wish List Name</td>
                    <td><input type="text" class="form-control name-input" required=""></td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td><input type="text" class="form-control descrip-input" required=""></td>
                </tr>
                <tr>
                <br>
                <td><button class="btn btn-primary register-user">Register</button></td>
<!--                <td><button class="btn btn-success login-user">Login</button></td>-->
                </tr>
            </table>
        </div>
        <div class="container login-form">
            <br><br>
            <h4>Login Form</h4>
            <table>
                <tr>
                    <td>Username</td>
                    <td><input type="text" class="form-control username-input-login" required=""></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" class="form-control password-input-login" required=""></td>
                </tr>
                <!--<td><button class="btn btn-primary register-user">Register</button></td>-->
                <td><button class="btn btn-success login-user">Login</button></td>
                </tr>
            </table>
        </div>
        <script>
            $(document).ready(function () {

                $('.register-user').click(function (event) {
                    event.preventDefault();
                    var username = $('.username-input').val();
                    var password = $('.password-input').val();
                    var name = $('.name-input').val();
                    var descrip = $('.descrip-input').val();
                    //                    console.log('Credentials' +name+" "+descrip);
                    $.ajax({
                        method: "POST",
                        url: "<?php echo base_url(); ?>index.php/login_controller/user",
                        dataType: 'JSON',
                        data: {username: username, password: password, name: name, descrip: descrip},

                        success: function (data) {
                            alert('Registration Completed');
                            $('.username-input').val("");
                            $('.password-input').val("");
                            $('.name-input').val("");
                            $('.descrip-input').val("");
                        }
                    });
                });
            });

            $(document).ready(function () {
                $('.login-user').click(function (event) {
                    event.preventDefault();
                    var username = $('.username-input-login').val();
                    var password = $('.password-input-login').val();
                    //                    console.log('Credentials' +name+" "+descrip);
                    $.ajax({
                        method: "POST",
                        url: "<?php echo base_url(); ?>index.php/login_controller/userLogin",
                        dataType: 'JSON',
                        data: {username: username, password: password},
                        success: function (data) {

                            window.location.href = "<?php echo base_url(); ?>index.php/index_controller/wishlist";
                            $('.username-input-login').val("");
                            $('.password-input-login').val("");
                        }
                    });
                });
            });
        </script>

    </body>
</html>