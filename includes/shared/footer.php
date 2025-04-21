</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<footer class="main-footer text-center">
  <strong>
    Copyright &copy; <?php echo date('Y'); ?>
    <a href="#">Emma Auto Multi-Company PLC.</a>.
  </strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
</div> <!-- ./wrapper -->

<!-- Core JS Libraries -->
<script src="<?php echo $basePath; ?>assets/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo $basePath; ?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button); // Resolve conflict between jQuery UI & Bootstrap
</script>
<script src="<?php echo $basePath; ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Plugins -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="<?php echo $basePath; ?>assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo $basePath; ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo $basePath; ?>assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?php echo $basePath; ?>assets/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo $basePath; ?>assets/plugins/sparklines/sparkline.js"></script>
<script src="<?php echo $basePath; ?>assets/plugins/jqvmap/0.vmap.min.js"></script>
<script src="<?php echo $basePath; ?>assets/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="<?php echo $basePath; ?>assets/plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="<?php echo $basePath; ?>assets/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo $basePath; ?>assets/plugins/chosen/chosen.js"></script>
<script src="<?php echo $basePath; ?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- AdminLTE -->
<script src="<?php echo $basePath; ?>assets/dist/js/adminlte.js"></script>
<script src="<?php echo $basePath; ?>assets/dist/js/demo.js"></script>

<!-- Custom Scripts -->
<script src="<?php echo $basePath; ?>assets/js/click_table.js?v=<?= time(); ?>"></script>
<script>
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $(".chosen").chosen();
  });

  function printpage() {
    window.print();
  }
</script>
<script>
  $(document).ready(function () {
    $('#datepicker').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true
    });
    $('.datepicker').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      todayHighlight: true
    });
  });
</script>
<script>
    setTimeout(() => {
        document.querySelectorAll('.alert-success, .alert-danger').forEach(alert => {
            alert.style.display = 'none';
        });
    }, 3000);
</script>
<script>
  const currentPageToExpire = "<?php echo basename($_SERVER['PHP_SELF']); ?>";

  // Detect if the tab is hidden or navigated away from
  document.addEventListener("visibilitychange", () => {
    if (document.visibilityState === "hidden") {
      fetch("<?= BASE_URL ?>ajax/shared/users/clear_verification.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({ page: currentPageToExpire }),
        keepalive: true // ensures it works even on page unload
      });
    }
  });
</script>

</body>
</html>
