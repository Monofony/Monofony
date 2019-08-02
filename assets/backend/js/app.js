import '../../common/js/app';

import 'semantic-ui-calendar/dist/calendar';

import './app-date-time-picker';
import './sylius-compound-form-errors';

import '../scss/main.scss';

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
