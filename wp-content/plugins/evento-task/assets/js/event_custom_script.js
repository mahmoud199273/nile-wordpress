jQuery(document).ready(function () {
    jQuery('[data-toggle="datepicker"]').datepicker();


    jQuery('#event_start_date').on('change', function() {
        var checkIn_date = jQuery(this).val();
        var date = new Date(checkIn_date);
        var start_date = new Date(date);
        start_date.setDate(start_date.getDate() + 1);
        jQuery('#event_end_date').datepicker('reset');
        jQuery('#event_end_date').datepicker('setStartDate', start_date);
        jQuery('#event_end_date').datepicker('setDate', start_date);
    });
    jQuery('#event_end_date').datepicker({
        startDate: new Date(),
        todayHighlight: true,
        autoHide: true,
    });
});