$(function () {
    $('.txtDateTime').datetimepicker({
        dayOfWeekStart: 1,
        lang: 'vi',
        startDate: '2014-10-10',
        format: 'Y-m-d',
        dateonly: false,
        showHour: false,
        closeOnDateSelect: true,
        showMinute: false,
        timepicker: false,
        onChangeDateTime: function(dp, $input) {
        }
    });
});