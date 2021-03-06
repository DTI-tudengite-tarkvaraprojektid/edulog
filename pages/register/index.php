<?php

    include('../../config.php');
    include('../../util/dateTime.php');

    function Redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);
        exit();
    }

    if($_GET) {
        $timezone_name = timezone_name_from_abbr("", $_GET['time_offset']*60, false);
        setcookie('time_offset', $timezone_name, time() + (86400 * 30), "/");
    }

    if($_POST) {


        //check if all required values are filled
        if(!empty($_POST['register-locale']) && !empty($_POST['register-email']) && !empty($_POST['register-password']) && !empty($_POST['register-password-again']) )
        {

            // check password matching
            if($_POST['register-password'] == $_POST['register-password-again'])
            {

                // make db instance
                $db = new Sqlite3("../../" . 'database.sqlite', SQLITE3_OPEN_CREATE | SQLITE3_OPEN_READWRITE);

                // get user with same email
                $query = "select * from users where email='" . $_POST['register-email'] . "'";
                $result = $db->querySingle($query, true);
                if(empty($result)) {

                    // add new user
                    $db->exec('BEGIN');

                     $statement = $db->prepare('INSERT INTO "users" (
                        "email", "password", "locale", "created_at"
                    ) VALUES (:email, :password, :locale, :created_at)');

                    $statement->bindValue(':email', $_POST['register-email']);
                    $statement->bindValue(':password', md5($_POST['register-email'] . $_POST['register-password']));
                    $statement->bindValue(':locale', $_POST['register-locale']);
                    $statement->bindValue(':created_at', dateUTC('Y-m-d H:i:s'));
                    $statement->execute();
                    $db->exec('COMMIT');


                    // login
                    $query = "select * from users where email='" . $_POST['register-email'] . "'";
                    $result = $db->querySingle($query, true);

                    //set token as cookie
                    setcookie('user_id', $result['id'], time() + (86400 * 30), "/");
                    setcookie('locale', $result['locale'], time() + (86400 * 30), "/");
                    Redirect($edulog_root . 'pages/tracker', false);

                } else {
                    // if user exists
                    setcookie('user_id', $result['id'], time() + (86400 * 30), "/");
                    setcookie('locale', $result['locale'], time() + (86400 * 30), "/");
                    Redirect($edulog_root . 'pages/tracker', false);
                };

            } else {
                die();
            }

        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Edulog register</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet">
        <link rel="stylesheet" href="../css/style.css" type="text/css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>

        <script src="<?php echo $edulog_root . 'pages/tracker/js.cookie.js';?>"></script>
        <script src="register.js"></script>
    </head>

    <body>
        <div class="site-content">
            <form id="register-form" action="<?=$_SERVER['PHP_SELF'];?>" method="post" class="logreg">
                <section class="box-head">
                    <h1 id="title">Register</h1>
                </section>
                <div class="login-details">
                    <section>
                        <select id="register-locale" name="register-locale">
                            <option value="et">Eesti</option>
                            <option value="en">English</option>
                        </select>
                    </section>
                    <section>
                        <input type="email" id="register-email" name="register-email" placeholder="E-mail">
                    </section>
                    <section>
                        <input type="password" id="register-password" name="register-password" placeholder="Password">
                    </section>
                    <section>
                        <input type="password" id="register-password-again" name="register-password-again" placeholder="Repeat password">
                    </section>
                    <section>
                        <div class="btn-wrap">
                            <button id="submit-btn" class="f-btn" type="submit">Registreeru</button>
                        </div>
                    </section>
                </div>
            </form>
            <p class="not-user">Already an user? <a class="links" href="../login">Login</a></p>
        </div>
    </body>
</html>
