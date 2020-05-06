$(document).ready(function() {

    summernoteInit();
});

function summernoteInit() {
    $('.summernote-field').summernote({
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['link']],
            ['view', ['codeview']],
        ],
        height: 200,
        popover: {
            image: [],
            link: [],
            air: []
        },
    });

    let imageUploadDiv = $('div.note-group-select-from-files');
    if (imageUploadDiv.length) {
        imageUploadDiv.remove();
    }
}
