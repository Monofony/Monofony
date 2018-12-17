import 'semantic-ui-css/components/accordion';
import $ from 'jquery';

import 'sylius/ui/app';
import 'sylius/ui/sylius-auto-complete';

(function($) {
    $(document).ready(function () {
        $('.sylius-autocomplete').autoComplete();
    });
})(jQuery);

window.$ = $;
window.jQuery = $;
