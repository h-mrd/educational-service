<?php
define('DBHOST', 'db_service_host:3306');
define('DBUSER', 'auth_service_user');
define('DBPASS', 'Auth_service@1397');
define('DBNAME', 'cc_project_database');
$action = (isset($_GET['action'])) ? $_GET['action'] : '';

switch ($action) {
    case "login" : login();
        break;
    case "exit_user" : exit_user();
        break;
    default : display_form_login();
        break;
}

function display_form_login() {
    if (isset($_SESSION['student_number'])) {
        header('Location: main.html');
        return;
    }
    ?>                
    <!DOCTYPE html>
    <!--
    To change this license header, choose License Headers in Project Properties.
    To change this template file, choose Tools | Templates
    and open the template in the editor.
    -->
    <html>
        <head>
            <title>Docker project</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="source/bootstrap.min.css" type="text/css" rel="stylesheet"/>
            <link href="source/styles.css" rel='stylesheet' type='text/css'>
            <script src="source/bootstrap/js/bootstrap.min.js" ></script>

        </head>
        <body>
            <div class="col-sm-4">

            </div>
            <div class="col-sm-4 login">
                <div class="login_prj">
                    <div class="image-ferdowsi">
                        <img src="img/FUM_Logo.png" alt="logo-ferdowsi-uni">
                    </div>
                    <div class="title">
                        <p>پرتال یکپارچه ورود اعضا (پویا)</p>
                    </div>	
                    <div class="form" id="login">

                        <form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <input type="hidden" name="action" value="login" />
                            <div class="form-group">
                                <input type="text" style="direction:rtl;" class="form-control" id="text" placeholder="نام کاربری" name="student_number" size="18" maxlength="25" required>
                            </div>
                            <div class="form-group">
                                <input type="password" style="direction:rtl;" class="form-control" id="pwd" placeholder="رمز ورود" name="password" size="18" maxlength="25"  required>
                            </div>
                            <div class="checkbox">
                                <label><input type="checkbox"> بخاطر بسپار</label>
                            </div>
                            <div class="button login-submit">

                                <input type="submit" value="ورود" />

                            </div>

                            <div class="error"><?php if (isset($GLOBALS['error'])) echo $GLOBALS['error']; ?></div>									
                        </form>
                    </div>	
                </div>  
            </div>
            <div class="col-sm-4">

            </div>


        </body>
    </html>
    <?php
}

function login() {
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        global $error;
        $error = '';

        $student_number = $_GET['student_number'];
        $password = $_GET['password'];

        if (empty($student_number) || empty($password)) {
            $error = "لطفاً همه فیلدها را پر کنید.";
            display_form_login();
            return;
        }

        $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
        $conn->set_charset('utf8');
        if ($conn->connect_error) {
            $error = "متاسفانه نمي توان به پايگاه داده متصل شد.";
            display_form_login();
            return;
        }

        if ($stmt = $conn->prepare("SELECT id FROM students WHERE student_number=? and password=?")) {
            $stmt->bind_param("ss", $student_number, $password);
            $stmt->execute();

            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $_SESSION['student_number'] = $student_number;
                header('Location: main.html');
            } else {
                $error = "نام کاربری یا کلمه عبور اعتبار ندارد";
                display_form_login();
                return;
            }
        } else {
            $error = "عدم اجرای دستور Prepare <br /> شماره خطا = $conn->errno <br /> متن خطا = $conn->error";
            display_form_login();
            return;
        }

        $stmt->close();
        $conn->close();
    }
}
?>                

