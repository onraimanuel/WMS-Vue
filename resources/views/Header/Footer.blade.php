<!-- jQuery -->
<script src="Asset/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="Asset/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="Asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="Asset/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="Asset/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="Asset/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="Asset/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="Asset/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="Asset/plugins/moment/moment.min.js"></script>
<script src="Asset/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="Asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="Asset/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="Asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="Asset/dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="Asset/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="Asset/dist/js/pages/dashboard.js"></script>

<!-- DataTables  & Plugins -->
<script src="Asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="Asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="Asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="Asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="Asset/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="Asset/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="Asset/plugins/jszip/jszip.min.js"></script>
<script src="Asset/plugins/pdfmake/pdfmake.min.js"></script>
<script src="Asset/plugins/pdfmake/vfs_fonts.js"></script>
<script src="Asset/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="Asset/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="Asset/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


<!-- jQuery -->
<script src="Asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="Asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="Asset/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="Asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="Asset/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="Asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="Asset/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="Asset/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="Asset/plugins/jszip/jszip.min.js"></script>
<script src="Asset/plugins/pdfmake/pdfmake.min.js"></script>
<script src="Asset/plugins/pdfmake/vfs_fonts.js"></script>
<script src="Asset/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="Asset/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="Asset/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="Asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="Asset/dist/js/demo.js"></script>

<!-- jQuery -->
<script src="Asset/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="Asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="Asset/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="Asset/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="Asset/plugins/moment/moment.min.js"></script>
<script src="Asset/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="Asset/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="Asset/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="Asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="Asset/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="Asset/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- dropzonejs -->
<script src="Asset/plugins/dropzone/min/dropzone.min.js"></script>
<!-- AdminLTE App -->
<script src="Asset/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="Asset/dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>