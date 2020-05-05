<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <line-chart :chart-data="data" :height="100" :options="{ responsive: true, maintainAspectRation: true }"></line-chart>
                <button v-on:click="update" class="btn btn-success btn-xs text mt-1 mh-18">Обновить</button>
            </div>
        </div>
    </div>
</template>

<script>

    import LineChart from "./LineChart.js"
    //import PieChart from "./PieChart";

    export default {
        components: {
            LineChart
        },
        data: function() {
           return {
               data: [],
           }
        },
        mounted() {
            this.update();
            console.log('Component 6 Chart.JS Random mounted...');
        },
        methods: {
            update: function () {
                    axios.get('/start/random-chart').then((response) =>  {
                        this.data = response.data
                        console.log('response (!) = ' + response.data)
                    });
            }
        }
    }
</script>
