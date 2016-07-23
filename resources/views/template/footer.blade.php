    <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 2.3.5
        </div>
        <strong>Copyright &copy; 2016 <a mailto="m.s.benbakh@gmail.com">Klivin</a>.</strong> All rights
        reserved.
    </footer>

    <script src="{{asset('assets/plugins/jQuery/jQuery-2.1.4.min.js')}}"></script>
    <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <!-- SlimScroll 1.3.0 -->
    <script src="{{asset('assets/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{asset('assets/plugins/fastclick/fastclick.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('assets/dist/js/app.min.js')}}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{asset('assets/dist/js/demo.js')}}"></script>

    <script src="{{asset('assets/dist/sweetalert/sweetalert.min.js')}}"></script>

    <!-- Select2 -->
    <script src="{{asset('assets/plugins/select2/select2.full.min.js')}}"></script>
    <!-- InputMask -->
    <script src="{{asset('assets/plugins/input-mask/jquery.inputmask.js')}}"></script>
    <script src="{{asset('assets/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
    <script src="{{asset('assets/plugins/input-mask/jquery.inputmask.extensions.js')}}"></script>
    <!-- date-range-picker -->
    <script src="{{asset('assets/plugins/daterangepicker/daterangepicker.js')}}"></script>
    <!-- bootstrap color picker -->
    <script src="{{asset('assets/plugins/colorpicker/bootstrap-colorpicker.min.js')}}"></script>
    <!-- bootstrap time picker -->
    <script src="{{asset('assets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{asset('assets/plugins/iCheck/icheck.min.js')}}"></script>
    <!-- Page script -->
    <!-- DataTables -->
    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

    <script src="{{asset('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    
    <script src="{{asset('assets/bootstrap/js/dialog.js')}}"></script>
    <!-- ChartJS 1.0.1 -->
    <script src="{{asset('assets/plugins/chartjs/Chart.min.js')}}"></script>
    @if(Session::has('info'))
    <script>
        swal("Succès!", "{{ Session::get('info') }}", "success");
    </script>
    @endif
    @if(Session::has('danger'))
    <script>
        swal("Erreur!", "{{ Session::get('danger') }}", "danger");
    </script>
    @endif

