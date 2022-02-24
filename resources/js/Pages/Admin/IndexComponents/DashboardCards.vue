<template>
    <spinnder v-if="loading==true"></spinnder>
    <div class="row" v-else >
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">New Applicants</h4>
                    <div class="text-end">
                        <h2 class="font-light mb-0"><i class="bi bi-arrow-up text-success"></i> {{ dashboardData.applicants }}</h2>
                        <span class="text-muted">No. of New Registrations</span>
                    </div>
                    <!-- <span class="text-success">80%</span>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 80%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> -->
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Exams</h4>
                    <div class="text-end">
                        <h2 class="font-light mb-0"><i class="bi bi-dash-lg" style="color: orange;"></i> {{ dashboardData.exams }} </h2>
                        <span class="text-muted">Total No. of Exams</span>
                    </div>
                    <!-- <span class="text-success">80%</span>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 80%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> -->
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Passing Rate</h4>
                    <div class="text-end">
                        <h2 class="font-light mb-0"><i class="bi bi-arrow-down text-danger"></i> {{ dashboardData.passing_rate }}%</h2>
                        <span class="text-muted">Pass percentage</span>
                    </div>
                    <!-- <span class="text-success">80%</span>
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 80%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-6" v-if="dashboardData['results']">
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item list-group-item-info w-100 fw-bold" >Exam Result Breakdown:</li>
            </ul>
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item list-group-item-action list-group-item-success w-75" >Passed:</li>
                <li class="list-group-item list-group-item-action list-group-item-success w-25">{{ dashboardData['results']['passed'] }}</li>
            </ul>
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item list-group-item-action list-group-item-warning w-75" >Needs manual check</li>
                <li class="list-group-item list-group-item-action list-group-item-warning w-25">{{ dashboardData['results']['needs_check'] }}</li>
            </ul>
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item list-group-item-action list-group-item-danger w-75" >Failed</li>
                <li class="list-group-item list-group-item-action list-group-item-danger w-25">{{ dashboardData['results']['failed'] }}</li>
            </ul>
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item list-group-item-action list-group-item-primary w-75  fw-bold" >Total</li>
                <li class="list-group-item list-group-item-action list-group-item-primary w-25  fw-bold">{{ dashboardData['completed_exams'] }}</li>
            </ul>


        </div>
    </div>
</template>

<script >
import { defineComponent } from 'vue'
import Spinnder from '../Layouts/Spinnder.vue';

import axiosRetry from 'axios-retry';

export default defineComponent({
  components: { Spinnder },
    
    data() {
        return {
            dashboardData:[],
            loading:false,
            
        }
    },
    methods: {
        
        getDashboardData(){


            this.loading=true;
            axiosRetry(axios, { retries: 3 });

            axios.get(route('admin.admin_index'))
            .then(response => {                    
                //console.log(response.data);
                
                this.dashboardData=response.data;
                this.loading=false;
            })
            .catch(error=>{
                if(error.response.status=='500'){
                    console.log(error);
                }else{
                    alert(error);
                }
            });
        }
    },
    created(){
        
    },
    mounted(){
        this.getDashboardData();
    }
    
})
</script>

<style scoped>
    

    
</style>
