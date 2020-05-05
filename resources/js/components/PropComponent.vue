<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>URL</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="url in urldata">
                        <td>{{ url.title}}</td>
                        <td>{{ url.url }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
          'urldata'
        ],
        mounted() {
            console.log('Component 2 Vue.JS => Blade mounted...');
            this.update()
        },
        methods: {
            update: function () {
                console.log(this.urldata);
            }
        }
    }
</script>
