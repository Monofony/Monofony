import 'semantic-ui-css/components/accordion';
import $ from 'jquery';

import 'sylius/ui/app';
import 'sylius/ui/sylius-auto-complete';
import 'sylius/ui/sylius-product-attributes';
import 'sylius/ui/sylius-product-auto-complete';
import 'sylius/ui/sylius-prototype-handler';

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

window.$ = $;
window.jQuery = $;

