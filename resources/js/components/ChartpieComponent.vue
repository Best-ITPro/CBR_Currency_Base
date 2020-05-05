<template>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <pie-chart :chart-data="data" :height="100" :options="{ responsive: true, maintainAspectRation: true }"></pie-chart>
            </div>
        </div>
    </div>
</template>

<script>

    import PieChart from "./PieChart";

    export default {
        components: {
            PieChart
        },
        data: function() {
           return {
               data: [],
           }
        },
        mounted() {
            this.update();
            console.log('Component 5 Chart.JS Pie mounted...');
        },
        methods: {
            update: function () {
                    axios.get('/start/data-chart').then((response) =>  {
                        this.data = response.data
                        console.log('response (!) = ' + response.data)
                    });
            }
        }
    }
</script>
