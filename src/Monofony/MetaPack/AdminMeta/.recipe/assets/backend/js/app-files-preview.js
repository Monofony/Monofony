import $ from 'jquery';

const displayUploadedFile = function displayUploadedFile(input) {
    debugger;

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = (event) => {
            const $link = $(input).parent().siblings('a');
            const fileName = $(input).val().split('\\').pop();

            $link.removeAttr('href');
            $link.addClass('disabled');
            $('.filename', $link).html(fileName);
            $link.show();
        };

        reader.readAsDataURL(input.files[0]);
    }
};

$.fn.extend({
    previewUploadedFile(root) {
        $(root).on('change', 'input[type="file"]', function () {
            displayUploadedFile(this);
        });
    },
});
