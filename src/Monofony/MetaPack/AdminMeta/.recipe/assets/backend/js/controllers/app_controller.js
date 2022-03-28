import {Controller} from '@hotwired/stimulus';
import 'babel-polyfill';
import 'sylius/ui/js/sylius-auto-complete';

import '../shim-semantic-ui';
import '../app-date-time-picker';
import '../app-images-preview';
import '../sylius-compound-form-errors';
import loadComponents from '../sylius-app';

export default class extends Controller {
  connect() {
    loadComponents();
    $(document).previewUploadedImage('#sylius_admin_user_avatar');
    $('.sylius-autocomplete').autoComplete();
    $('.sylius-tabular-form').addTabErrors();
    $('.ui.accordion').addAccordionErrors();
    $('#sylius_customer_createUser').change(function () {
      $('#user-form').toggle();
    });

    $('.app-date-picker').datePicker();
    $('.app-date-time-picker').dateTimePicker();
    $('.ui.checkbox').checkbox();
  }
}
