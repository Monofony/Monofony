(function($) {
    $(document).ready(function () {
      $('#sylius_customer_createUser').change(function(){
        $('#user-form').toggle();
      });

      $('.js-datePicker').calendar({
        type: 'date',
        formatter: {
          date: function (date, settings) {
            if (!date) return '';
            var day = date.getDate();
            var month = date.getMonth() + 1;
            var year = date.getFullYear();

            if (month < 10) {
              month = "0" + month;
            }

            return day + '/' + month + '/' + year;
          }
        },
        parser: {
          date: function (text, settings) {
            var dateAsArray = text.split('/')
            return new Date(dateAsArray[2], dateAsArray[1] - 1, dateAsArray[0]);
          }
        },
      });
    });
})(jQuery);

