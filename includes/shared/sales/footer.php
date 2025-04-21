</div>
<!-- /.content-wrapper -->


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
<div class="d-print-none text-center">
  <footer style="bottom: 5px;">

  </footer>
</div>

</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= $basePath?>assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= $basePath?>assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?= $basePath?>assets/plugins/chosen/chosen.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= $basePath?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>


<script src="<?= $basePath?>assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= $basePath?>assets/dist/js/adminlte.js"></script>

<script src="<?= $basePath?>assets/dist/js/demo.js"></script>
<!-- Custom Scripts -->
<script src="<?php echo $basePath; ?>assets/js/click_table.js?v=<?= time(); ?>"></script> 
<script>
  $(".chosen").chosen();
</script>
<script>
  function printpage() {
    window.print()
  }
</script>

</body>

</html>