<template>
    <div class='card link-block'>
        <div class="card-header d-flex p-0">
            <h4 class="p-3">{{header}}</h4>
        </div><!-- /.card-header -->
        <div class="card-body">
            <div class="tab-content">
                <ul class="generated-links">
                    <li v-for="link in links" :key="link.accessLink">
                        <a :href="link.accessLink">{{link.accessLink}}</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col col-2">
                    <form class="create-link" :method="formMethod" :action="formAction">
                        <div v-html="csrfField"></div>
                        <input type="hidden" name="only_once" :value="onlyOnce">
                        <input type="hidden" name="api_token" :value="apiToken">
                        <input type="hidden" name="file_id" :value="fileId">

                        <v-btn color="success">{{ createText }}</v-btn>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import csrf from './../../helpers/csrf';

    export default {
        props: {
            'formAction': String,
            'formMethod': {
                type: String,
                default: 'POST'
            },
            'data': String|JSON,
            'fileId': {
                type: Number,
                validate: function (value) {
                    return Number.isInteger(value);
                }
            },
            'apiToken': String,
            'header': String,
            'createText': String,
            'onlyOnce': {
                type: Number,
                validate: function (value) {
                    return Number.isInteger(value);
                }
            },
        },
        mounted() {
          console.log(this.header, this.createText);
        },
        computed:{
            links: function () {
                return JSON.parse(this.data)
            },
            csrfField: function () {
                return csrf.field();
            }
        }
    }
</script>
