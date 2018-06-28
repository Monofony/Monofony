(function ($) {
    $(document).ready(function () {
        $('.sylius-autocomplete').autoComplete();
        $('.sylius-tabular-form').addTabErrors();
        $('.ui.accordion').addAccordionErrors();
        $('#sylius_customer_createUser').change(function () {
            $('#user-form').toggle();
        });

        $('.app-date-picker').datePicker();
        $('.app-date-time-picker').dateTimePicker();
    });
})(jQuery);

