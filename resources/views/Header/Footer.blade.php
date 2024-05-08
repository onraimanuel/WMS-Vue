<script src="Asset/plugins/jquery/jquery.min.js"></script>
<script src="Asset/plugins/jquery-ui/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="Asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="Asset/plugins/chart.js/Chart.min.js"></script>
<script src="Asset/plugins/sparklines/sparkline.js"></script>
<script src="Asset/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="Asset/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<script src="Asset/plugins/jquery-knob/jquery.knob.min.js"></script>
<script src="Asset/plugins/moment/moment.min.js"></script>
<script src="Asset/plugins/daterangepicker/daterangepicker.js"></script>
<script src="Asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="Asset/plugins/summernote/summernote-bs4.min.js"></script>
<script src="Asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="Asset/dist/js/adminlte.js"></script>
<script src="Asset/dist/js/demo.js"></script>
<script src="Asset/dist/js/pages/dashboard.js"></script>
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
<script src="Asset/plugins/jquery/jquery.min.js"></script>
<script src="Asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
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
<script src="Asset/dist/js/adminlte.min.js"></script>
<script src="Asset/dist/js/demo.js"></script>
<script src="Asset/plugins/jquery/jquery.min.js"></script>
<script src="Asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="Asset/plugins/select2/js/select2.full.min.js"></script>
<script src="Asset/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script src="Asset/plugins/moment/moment.min.js"></script>
<script src="Asset/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="Asset/plugins/daterangepicker/daterangepicker.js"></script>
<script src="Asset/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="Asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="Asset/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="Asset/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<script src="Asset/plugins/dropzone/min/dropzone.min.js"></script>
<script src="Asset/dist/js/adminlte.min.js"></script>
<script src="Asset/dist/js/demo.js"></script>
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