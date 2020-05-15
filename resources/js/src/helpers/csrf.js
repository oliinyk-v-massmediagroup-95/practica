
let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

export default  {
    field: function () {
        return '<input type="hidden" name="_token" value="' + token + '">'
    },

    token: function () {
        return token;
    }
}

