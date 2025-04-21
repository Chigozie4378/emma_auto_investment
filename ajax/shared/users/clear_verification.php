<?php
include "../../../autoload/loader.php";

$data = json_decode(file_get_contents("php://input"), true);
$page = $data['page'] ?? '';
echo '<script>
    console.log("$page")
</script>';

if ($page && isset($_SESSION["verified_$page"])) {
    unset($_SESSION["verified_$page"]);
}
http_response_code(204); // No content
exit;
?>
