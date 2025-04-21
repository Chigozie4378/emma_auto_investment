<?php
class AuthController extends ControllerV2
{
    public $userErr = "";
    public $user = "";

    public function showUsers()
    {
        return $this->fetchResult(table_name: "registered", order_by: "date_registered asc");
    }
    public function showUser()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            return $this->fetchResult("registered", ["id=$id"]);
        }
    }
    public function loginUser()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $conn = $this->connect();

            $username     = mysqli_escape_string($conn, $_POST["username"]);
            $input_pass   = mysqli_escape_string($conn, $_POST["password"]);
            $mac_address  = strtoupper(trim(mysqli_escape_string($conn, $_POST["mac_address"])));

            // Get role dynamically from file name
            $page = basename($_SERVER['PHP_SELF']); // e.g., director_login.php
            $role = match ($page) {
                'director_login.php' => 'director',
                'admin_login.php'    => 'admin',
                'manager_login.php'  => 'manager',
                default              => 'staff'
            };

            $allowed_mac_addresses = IPs::allowedMacAddresses();

            date_default_timezone_set('GMT+1');

            $current_time = strtotime(date("H:i"));
            $start_time = strtotime("04:00");
            $end_time = strtotime("23:30");

            if (in_array($mac_address, $allowed_mac_addresses) && ($current_time >= $start_time && $current_time <= $end_time)) {

                $result = $this->fetchResult("registered", where: [
                    "username=$username",
                    "role=$role",
                    "status=active"
                ]);

                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $id = $row['id'];
                    $stored_pass = $row["password"];
                    $password_match = false;

                    if (password_verify($input_pass, $stored_pass)) {
                        $password_match = true;
                    } elseif (md5($input_pass) === $stored_pass) {
                        $password_match = true;
                        $new_hash = password_hash($input_pass, PASSWORD_DEFAULT);
                        $this->updates("registered", U::col("password='$new_hash'"), U::where("id = $id"));
                    }

                    if ($password_match) {
                        $_SESSION["{$role}fullname"] = $row["firstname"] . " " . $row["lastname"];
                        $_SESSION["{$role}username"] = $row["username"];
                        $_SESSION["{$role}lastname"] = $row["lastname"];
                        $_SESSION["{$role}passport"] = $row["passport"];

                        // Optional: shut down Flask
                        // $ch = curl_init();
                        // curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:5000/shutdown");
                        // curl_setopt($ch, CURLOPT_POST, true);
                        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        // curl_exec($ch);
                        // curl_close($ch);

                        // header("Location: {$role}/dashboard.php");
                        $dashboardPage = ($role === 'admin') ? "{$role}/confirm_transfer.php" : "{$role}/dashboard.php";
                        header("Location: $dashboardPage");

                        exit;
                    } else {
                        echo "<div class='alert alert-danger text-center'><strong>Danger!</strong> Incorrect password.</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger text-center'><strong>Danger!</strong> No active $role found with that username.</div>";
                }
            } else {
                if (!in_array($mac_address, $allowed_mac_addresses)) {
                    echo "<div class='alert alert-danger text-center'><strong>Danger!</strong> Access denied: Unauthorized device!</div>";
                } elseif ($current_time < $start_time || $current_time > $end_time) {
                    echo "<div class='alert alert-danger text-center'><strong>Danger!</strong> Access denied: Outside of office hours.</div>";
                }
            }
        }
    }



    public function addNewUser()
    {
        if (isset($_POST["add"])) {

            $password1 = mysqli_escape_string($this->connect(), $_POST["password"]);
            $cpassword = mysqli_escape_string($this->connect(), $_POST["cpassword"]);
            $role = mysqli_escape_string($this->connect(), $_POST["role"]);
            $date = date('Y-m-d H:i:s');
            if ($password1 == $cpassword) {
                $firstname = mysqli_escape_string($this->connect(), $_POST["firstname"]);
                $lastname = mysqli_escape_string($this->connect(), $_POST["lastname"]);
                $username = mysqli_escape_string($this->connect(), $_POST["username"]);
                $password  = password_hash($password1, PASSWORD_DEFAULT);
                $user =  $this->fetchResult("registered", ["username=$username"]);

                $passport_tmp_name = $_FILES["passport"]["tmp_name"];
                $passport_name = $_FILES["passport"]["name"];
                $file_path = "../assets/passport/" . $passport_name;
                move_uploaded_file($passport_tmp_name, $file_path);
                if ($user->num_rows > 0) {
                    $this->userErr = "<strong>Danger!</strong> Invalid Staff Registeration.";
                } else {
                    $this->insert("registered", $firstname, $lastname, $username, $password, $role, $file_path, "active", $date);
                    $this->user = "<div class='alert alert-success text-center'><strong>Success!</strong> Staff Added Successfully.</div>";
                    echo "<script>
                         setTimeout(function(){
                            window.location.href = window.location.href
                         }, 1000);
                    </script>";
                }
            } else {
                $this->userErr = "<div class='alert alert-danger text-center'><strong>Danger!</strong> Invalid Staff Registeration.</div>";
                echo "<script>
                setTimeout(function(){
                   window.location.href = window.location.href
                }, 1000);
                </script>";
            }
        }
    }

    public function userDelete()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($_GET['id']) {
                $this->trashWhere("registered", "id=$id"); ?>
                <script>
                    document.getElementById('delete').style.display = 'block';
                </script>
<?php }
        }
    }
    public function userEdit($tablename)
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($_GET['id']) {
                $row = mysqli_fetch_array($this->fetchResult("registered", ["id=$id"]));
                echo $row["$tablename"];
            }
        }
    }
    public function userUpdate()
    {
        if (!isset($_POST["edit"])) return;

        $conn = $this->connect();

        $id        = mysqli_escape_string($conn, $_POST["id"]);
        $firstname = mysqli_escape_string($conn, $_POST["firstname"]);
        $lastname  = mysqli_escape_string($conn, $_POST["lastname"]);
        $username  = mysqli_escape_string($conn, $_POST["username"]);
        $role      = mysqli_escape_string($conn, $_POST["role"]);
        $status    = mysqli_escape_string($conn, $_POST["status"]);

        $updateCols = [
            "firstname=$firstname",
            "lastname=$lastname",
            "role=$role",
            "status=$status"
        ];

        // Update password only if not empty
        if (!empty($_POST["password"])) {
            $password = password_hash(mysqli_escape_string($conn, $_POST["password"]), PASSWORD_DEFAULT);
            $updateCols[] = "password='$password'";
        }

        // Update passport only if a new file is uploaded
        if (isset($_FILES["passport"]) && $_FILES["passport"]["error"] === 0 && !empty($_FILES["passport"]["name"])) {
            $passport_tmp = $_FILES["passport"]["tmp_name"];
            $passport_name = basename($_FILES["passport"]["name"]);
            $file_path = "../assets/passport/" . $passport_name;

            // Try to move the uploaded file
            if (move_uploaded_file($passport_tmp, $file_path)) {
                // Fetch old passport path
                $result = $this->fetchResult("registered", ["id=$id"]);
                if ($result && $result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $old_passport = $row['passport'];
                    if (file_exists($old_passport)) {
                        unlink($old_passport); // Delete the old passport
                    }
                }

                $updateCols[] = "passport='$file_path'";
            }
        }

        // Perform update
        $this->updates("registered", U::col(...$updateCols), U::where("id = $id"));
        echo "<script>
                window.location.href = window.location.pathname + '?id=$id&updated=1';
            </script>";
        exit;
    }
    public function userBlock($username)
    {

        $status = "inactive";
        $this->updates(
            "registered",
            U::col("status=$status"),
            U::where("username = $username")
        );

        new Redirect("add_new_user.php");
    }
    public function userUnBlock($username)
    {

        $status = "active";
        $this->updates(
            "registered",
            U::col("status=$status"),
            U::where("username = $username")
        );

        new Redirect("add_new_user.php");
    }
    public function checkUsername($username)
    {
        return $this->fetchResult("registered", ["username=$username"]);
    }

    public function logout()
    {
        $shared = new Shared();
        $role = $shared->getRole();

        // Manually set the session name based on the role before starting session
        session_name($role . '_sess');
        session_start();

        // Unset and destroy only this role's session
        session_unset();
        session_destroy();

        // Remove session cookie for this session
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Redirect to the correct login page
        $loginPage = ($role === 'staff') ? 'index.php' : $role . '_login.php';
        header("Location: ../" . $loginPage);
        exit();
    }
}
?>