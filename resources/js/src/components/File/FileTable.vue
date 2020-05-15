<template>
    <div class="col-12">
        <div class="card">
            <div class="card-header" style="width: 100%;">
                <v-row>
                    <v-col cols="11">
                        <h3 class="card-title" style="font-size: 1.9rem">Files List</h3>
                    </v-col>

                    <v-col cols="1">
                        <a :href="createFileRoute">
                            <v-btn depressed color="primary">
                                Create
                            </v-btn>
                        </a>
                    </v-col>
                </v-row>

            </div>
            <!-- /.card-header -->
            <div>
                <v-simple-table>
                    <template v-slot:default>
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>IMAGE</th>
                            <th>OPERATIONS</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in data" :key="item.id">
                            <td>{{item.id}}</td>
                            <td>{{item.original_name}}</td>
                            <td><img style="width: 100px;" :alt="item.original_name" :src="item.url_path"></td>
                            <td>
                                <v-row>
                                    <v-col cols="2">
                                        <a :href="item.show_path">
                                            <div class="my-2">
                                                <v-btn depressed small color="default">Show</v-btn>
                                            </div>
                                        </a>
                                    </v-col>

                                    <v-col cols="2">
                                        <div class="my-2" @click="deleteFileSubmit(item.delete_path)">
                                            <v-btn depressed small color="error">Delete</v-btn>
                                        </div>
                                    </v-col>
                                </v-row>
                            </td>
                        </tr>
                        </tbody>
                    </template>
                </v-simple-table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</template>
<script>
    import csrf from './../../helpers/csrf'

    export default {
        props: {
            files: JSON | String,
            createFileRoute: String,
        },
        methods: {
            deleteFileSubmit: function (delete_path) {
                if(confirm('Are you sure?')){
                    let form = document.createElement('form');

                    form.action = delete_path;
                    form.method = 'POST';

                    form.innerHTML = csrf.field();
                    form.innerHTML += '<input name="_method" value="DELETE">'

                    document.body.appendChild(form);

                    form.submit();
                }
            }
        },
        computed: {
            data: function () {
                return JSON.parse(this.files);
            }
        }
    }
</script>
