<?php
class Shared extends ControllerV2
{
    protected $role;
    protected $fullnameSession;

    public function __construct()
    {
        parent::__construct();

        $this->preventBackAccess();

        // Skip session enforcement for AJAX or public utility routes
        if ($this->isPublicRoute()) {
            return;
        }

        if (!$this->isLoginPage()) {
            $this->detectRole();
            $this->validateAccess();
            $this->enforceRoleAccess();
        }
    }



    // Determine user's role from session
    protected function detectRole()
    {
        if (isset($_SESSION['directorusername'])) {
            $this->role = 'director';
            $this->fullnameSession = 'directorfullname';
        } elseif (isset($_SESSION['managerusername'])) {
            $this->role = 'manager';
            $this->fullnameSession = 'managerfullname';
        } elseif (isset($_SESSION['staffusername'])) {
            $this->role = 'staff';
            $this->fullnameSession = 'stafffullname'; // ✅ fixed typo
        } elseif (isset($_SESSION['adminusername'])) {
            $this->role = 'admin';
            $this->fullnameSession = 'adminfullname';
        } else {
            // No session set — force login page based on URL folder
            $this->redirectToLogin();
        }
    }

    // Validate that role session data exists
    protected function validateAccess()
    {
        if (!isset($_SESSION[$this->fullnameSession])) {
            $this->redirectToLogin();
        }
    }

    // Enforce that user does not access folders meant for another role
    protected function enforceRoleAccess()
    {
        $currentPath = $_SERVER['PHP_SELF'];

        if (strpos($currentPath, "/director/") !== false && $this->role !== 'director') {
            $this->redirectToLogin("director");
        } elseif (strpos($currentPath, "/manager/") !== false && $this->role !== 'manager') {
            $this->redirectToLogin("manager");
        } elseif (strpos($currentPath, "/staff/") !== false && $this->role !== 'staff') {
            $this->redirectToLogin("staff");
        } elseif (strpos($currentPath, "/admin/") !== false && $this->role !== 'admin') {
            $this->redirectToLogin("admin");
        }
    }

    // Dynamically redirect to login page
    protected function redirectToLogin($forcedRole = null)
    {
        if (!$forcedRole) {
            $currentPath = $_SERVER['PHP_SELF'];
            if (strpos($currentPath, '/director/') !== false) {
                $forcedRole = 'director';
            } elseif (strpos($currentPath, '/manager/') !== false) {
                $forcedRole = 'manager';
            } elseif (strpos($currentPath, '/admin/') !== false) {
                $forcedRole = 'admin';
            } elseif (strpos($currentPath, '/staff/') !== false) {
                $forcedRole = 'staff';
            }
        }

        switch ($forcedRole) {
            case 'director':
                header("Location: " . BASE_URL . "director_login.php"); // ✅ absolute path
                break;
            case 'manager':
                header("Location: " . BASE_URL . "manager_login.php");
                break;
            case 'admin':
                header("Location: " . BASE_URL . "admin_login.php");
                break;
            case 'staff':
                header("Location: " . BASE_URL . "index.php");
                break;
            default:
                header("Location: " . BASE_URL . "index.php");
        }
        exit();
    }


    // Redirect already-logged-in users from login page to their dashboard
    public function redirectIfLoggedIn()
    {
        if (isset($_SESSION['directorusername'])) {
            header("Location: " . BASE_URL . "director/dashboard.php");
            exit();
        } elseif (isset($_SESSION['managerusername'])) {
            header("Location: " . BASE_URL . "manager/dashboard.php");
            exit();
        } elseif (isset($_SESSION['staffusername'])) {
            header("Location: " . BASE_URL . "staff/dashboard.php");
            exit();
        } elseif (isset($_SESSION['adminusername'])) {
            header("Location: " . BASE_URL . "admin/confirm_transfer.php");
            exit();
        }
    }

    // Prevent enforcement logic from running on login pages
    protected function isLoginPage()
    {
        $loginPages = [
            'director_login.php',
            'manager_login.php',
            'admin_login.php',
            'index.php'
        ];

        $currentFile = basename($_SERVER['PHP_SELF']);
        return in_array($currentFile, $loginPages);
    }
    protected function isPublicRoute()
    {
        $path = $_SERVER['PHP_SELF'];

        // Skip enforcement for AJAX scripts or other non-role folders
        return strpos($path, '/ajax/') !== false ||
            strpos($path, '/includes/') !== false ||
            strpos($path, '/assets/') !== false ||
            strpos($path, '/print/') !== false;
    }
    public static function getActiveRole()
    {
        if (!empty($_SESSION['active_role'])) {
            return $_SESSION['active_role'];
        }

        if (!empty($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
            if (strpos($referer, 'director') !== false) return 'director';
            if (strpos($referer, 'manager') !== false) return 'manager';
            if (strpos($referer, 'staff') !== false || strpos($referer, 'index.php') !== false) return 'staff';
            if (strpos($referer, 'admin') !== false) return 'admin';
        }

        return '';
    }

    protected function preventBackAccess()
    {
        header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }



    // Helper methods
    public function getRole()
    {
        return $this->role;
    }

    public function getFullname()
    {
        return $_SESSION[$this->fullnameSession] ?? '';
    }

    // public function getUsername()
    // {
    //     return $_SESSION[$this->getRole() . "username"] ?? "";
    // }
    public function getUsername()
    {
        // If role is already set (normal page), use the current logic
        if (!empty($this->role)) {
            return $_SESSION[$this->role . "username"] ?? "";
        }

        // Fallback for AJAX or non-role scripts
        $roles = ['director', 'manager', 'admin', 'staff'];
        foreach ($roles as $role) {
            if (isset($_SESSION[$role . 'username'])) {
                return $_SESSION[$role . 'username'];
            }
        }

        return "";
    }
}
