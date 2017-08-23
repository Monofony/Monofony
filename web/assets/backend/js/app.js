(function ($) {
    $(document).ready(function () {
        $('.sylius-autocomplete').autoComplete();
        $('#sylius_customer_createUser').change(function () {
            $('#user-form').toggle();
        });

        $('.app-date-picker').datePicker();
        $('.app-date-time-picker').dateTimePicker();
    });
})(jQuery);

