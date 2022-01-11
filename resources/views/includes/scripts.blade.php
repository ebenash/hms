<!-- OneUI Core JS: jQuery, Bootstrap, slimScroll, scrollLock, Appear, CountTo, Placeholder, Cookie and App.js -->
<script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery.scrollLock.min.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery.appear.min.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery.countTo.min.js') }}"></script>
<script src="{{ asset('assets/js/core/jquery.placeholder.min.js') }}"></script>
<script src="{{ asset('assets/js/core/js.cookie.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

<!-- Page Plugins -->
<script src="{{ asset('assets/js/plugins/slick/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/fullcalendar/gcal.min.js') }}"></script>

<!-- Page JS Plugins -->
<script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-colorpicker/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/masked-inputs/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/dropzonejs/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>

<!-- Page JS Code -->
<script src="{{ asset('assets/js/pages/base_tables_datatables.js') }}"></script>
<!--<script src="{{ asset('assets/js/pages/base_pages_dashboard.js') }}"></script>-->
<script>
    jQuery(function () {
        // Init page helpers (Slick Slider plugin)
        App.initHelpers('slick');
    });
</script>

<script type="text/javascript"> 
    function display_c(){
    var refresh=1000; // Refresh rate in milli seconds
    mytime=setTimeout('display_ct()',refresh)
    }
    function display_ct() {
    var x = new Date()
    var x1=x.toUTCString();// changing the display to UTC string
    document.getElementById('dateandtime').innerHTML = x1;
    tt=display_c();
    }
</script>
<script src="{{ asset('assets/js/pages/base_comp_calendar.js') }}"></script>

@if(isset($all_calendar_reservations))
    {!! $all_calendar_reservations->script() !!}
@endif
<script>
console.log("document is ready");
$(document).ready(function() {

  if(window.location.href.indexOf('#modal-view-add-reservation') != -1) {
    $('#modal-view-add-reservation').modal('show');
  }

}); 
</script>

<script src="{{ asset('assets/js/pages/base_forms_pickers_more.js') }}"></script>
<script>
    jQuery(function () {
        // Init page helpers (BS Datepicker + BS Datetimepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
        App.initHelpers(['datepicker', 'datetimepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']);
    });
</script>
