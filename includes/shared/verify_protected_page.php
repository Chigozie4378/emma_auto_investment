<?php
$page = basename($_SERVER['PHP_SELF']);
?>

<!-- ✅ Always include the timeout logic, even after verification -->
<script>
  let inactivityTimeout;
  let isUploading = false;

  function resetInactivityTimer() {
    if (isUploading) return; // ✅ Prevent timeout during upload
    clearTimeout(inactivityTimeout);
    inactivityTimeout = setTimeout(() => {
      fetch("<?php echo BASE_URL ?>ajax/shared/clear_verification.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          page: "<?php echo $page ?>"
        }),
        keepalive: true
      }).then(() => {
        window.location.href = "<?php echo BASE_URL.$role ?>/stock.php";
      });
    }, 60000);
  }

  // Detect user interaction
  ["click", "mousemove", "keydown", "scroll", "touchstart"].forEach(event => {
    document.addEventListener(event, resetInactivityTimer, false);
  });

  // Detect file upload
  const form = document.querySelector("form");
  if (form) {
    form.addEventListener("submit", function () {
      isUploading = true;              // ✅ prevent auto timeout
      clearTimeout(inactivityTimeout); // just in case
    });
  }

  resetInactivityTimer();
</script>


<?php
// ✅ Only show SweetAlert if user is NOT verified
if (!isset($_SESSION["verified_$page"]) || $_SESSION["verified_$page"] !== true) {
?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      Swal.fire({
        title: 'Enter your password to continue',
        input: 'password',
        inputLabel: 'Password',
        inputPlaceholder: 'Enter your password',
        inputAttributes: {
          autocapitalize: 'off',
          autocorrect: 'off'
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        allowOutsideClick: false,
        allowEscapeKey: true,
        preConfirm: (password) => {
          return fetch('/emma_auto_investment/ajax/shared/users/verify_password.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({
                password: password,
                page: "<?php echo $page ?>"
              })
            })
            .then(response => response.json())
            .then(data => {
              if (!data.success) {
                throw new Error(data.message)
              }
              return true;
            })
            .catch(error => {
              Swal.showValidationMessage(error.message);
            });
        }
      }).then((result) => {
        if (result.isConfirmed) {
          location.reload();
        } else if (result.isDismissed) {
          window.history.back(); // Or use: window.location.href = 'dashboard.php';
        }
      });
    });
  </script>
<?php
  exit;
}
?>
