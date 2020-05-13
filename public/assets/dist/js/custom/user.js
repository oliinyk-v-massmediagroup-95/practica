$(document).ready(function () {
    inputKeyUpHideError();

    datePicker();
    confirmDelete();
    createLink();
});

function createLink() {
    $('form.create-link').submit(function (e) {
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            success: (response) => {

                if(response.data && response.data.accessLink) {
                    const link = response.data.accessLink;
                    $(this).parents('.link-block').find('.generated-links').append('<li><a href="' + link + '">' + link + '</a></li>');
                }
            },
            // dataType: dataType
        });
        e.preventDefault();
    });
}

function confirmDelete() {
    $('.item-delete__btn').click(function (e) {
        if (!confirm('Are you sure?')) {
            e.preventDefault();
        }
    });
}

function datePicker() {
    $("#datepicker").datepicker();
}

function inputKeyUpHideError() {
    $('.form-control').keyup(function () {
        $('#' + $(this).attr('name') + '-error').css('display', 'none');
    })
}

