<template>
    <Head title="Exams" />
    
    
    
    <sidebar>
        
        <div class="container-xl overflow-scroll" style="height: 600px;">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-md-4">
                                <h2>Applicant Scores</h2>
                                <div class="input-group input-group-sm w-50">
                                    <label class="input-group-text" for="inputGroupSelect01">Show:</label>
                                    <select class="form-select" id="inputGroupSelect01" v-model="limit">                                        
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">

                            </div>
                            <div class="col-md-6 border rounded p-1">
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="passed" 
                                                v-model="passed" true-value="1" false-value="0" >
                                            <label class="form-check-label" for="passed">
                                                Passed
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="needscheck"
                                                v-model="needsCheck" true-value="1" false-value="0" >
                                            <label class="form-check-label" for="needscheck">
                                                Needs manual check
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="failed"
                                                v-model="failed" true-value="1" false-value="0" >
                                            <label class="form-check-label" for="failed">
                                                Failed
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="input-group input-group-sm mb-1">
                                            <input type="text" class="form-control form-control-sm" placeholder="Applicant's name or Exam Name" v-model="name" 
                                                @keyup.enter="filterResults()">
                                            <a href="#" class="btn bg-light" type="button" id="button-addon2" @click="name=''" >
                                                <i class="text-danger fs-6 bi bi-x-circle"></i>
                                            </a>
                                            <a href="#" class="btn btn-info" type="button" id="button-addon2" @click="filterResults()" >
                                                <i class="fs-6 bi bi-search"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <!-- <div class="col-md-2">
                                <a href="#" class="btn btn-info btn-sm rounded" @click="getResults"> 
                                    <i class="fs-6 bi bi-arrow-clockwise"></i>
                                    <span>Refresh</span>
                                </a>
                            </div> -->
                        </div>
                    </div>
                    <spinnder v-if="resultsLoading==true"></spinnder>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th style="width: 15%;">Applicant</th>
                                <th style="width: 10%;">Applying For:</th>
                                <th style="width: 10%;">Exam Name</th>
                                <th style="width: 15%;">Score(dbl clck to edit.)</th>
                                <th style="width: 15%;">Status(dbl clck to edit.)</th>                                
                                <th style="width: 25%;">Exam Date</th>
                                <th style="width: 10%;">Manual Check</th>
                            </tr>
                        </thead>
                        <tbody>
                            <result-items 
                                v-for="(result,index) in results" :key="index" :result="result"
                                @updateStatus="updateStatus($event)" @updateScore="updateScore($event)"
                                @getResults="filterResults()"
                                :loadingModal="loadingModal"
                                ></result-items>
                            				
                        </tbody>
                    </table>
                    
                </div>
            </div>

        </div>

        
        

    </sidebar>
    	
    
  
   
</template>

<script>
    import { defineComponent } from 'vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Sidebar from './Layouts/Sidebar.vue';
    import Spinnder from './Layouts/Spinnder.vue';
    import ResultItems from './ResultComponents.vue/ResultItems.vue';
    import axiosRetry from 'axios-retry';
    




    export default defineComponent({
        components: {
            Head,    
            JetValidationErrors,
            Link,
            Sidebar,
                Spinnder,
                ResultItems,
            
            
        },

        props: {
            

            },

        data() {
            return {
                resultsLoading:false,

                results:[],
                loadingModal:false,
                passed: 1,
                failed: 1,
                needsCheck: 1,
                name:"",
                limit: 25
            }
        },

        methods: {
            getResults(){
                this.resultsLoading=true;
                this.results=[];
                axiosRetry(axios, { retries: 3 });
                axios.get(route('admin.scores'))
                .then(response => {
                    this.results=response.data;
                    this.resultsLoading=false;
                })
                .catch(error=>{
                    if(error.response.status=='500'){
                        console.log(error);
                    }else{
                        alert(error);
                    }
                });
            },
            filterResults(){
                this.resultsLoading=true;
                this.results=[];
                axiosRetry(axios, { retries: 3 });
                axios.post(route('admin.scores_filter'),{
                    passed: this.passed,
                    failed: this.failed,
                    needs_check: this.needsCheck,
                    name:this.name,
                    limit:this.limit
                })
                .then(response => {
                    this.results=response.data;
                    console.log(response.data);
                    this.resultsLoading=false;
                })
                .catch(error=>{
                    if(error.response.status=='500'){
                        console.log(error);
                    }else{
                        alert(error);
                    }
                });
            },
            updateStatus(params){
                this.resultsLoading=true;
                this.loadingModal=true;
                axiosRetry(axios, { retries: 3 });
                axios.post(route('admin.scores_status'),{
                    score_id:params.score_id,
                    status: params.status
                })
                .then(response => {
                    this.filterResults();
                    this.loadingModal=false;
                })
                .catch(error=>{
                    if(error.response.status=='500'){
                        console.log(error);
                    }else{
                        alert(error);
                    }
                });
            },
            updateScore(params){
                this.resultsLoading=true;
                axiosRetry(axios, { retries: 3 });
                
                axios.post(route('admin.scores_update'),{
                    score_id:params.score_id,
                    score: params.score
                })
                .then(response => {
                    this.filterResults();
                })
                .catch(error=>{
                    if(error.response.status=='500'){
                        console.log(error);
                    }else{
                        alert(error);
                    }
                });
            },
            // resultArray(results){
            //     let arr=[];
            //     results.forEach(result => {
                    
            //         if(result.status=='Needs manual check'){
            //             if(this.needsCheck==1){
            //                 arr.push(result);
            //             }
            //         }

            //         if(result.status=='Passed'){
            //             if(this.passed==1){
            //                 arr.push(result);
            //             }
            //         }

            //         if(result.status=='Failed'){
            //             if(this.failed==1){
            //                 arr.push(result);
            //             }
            //         }
            //     });
            //     return arr;
            // }

        },
        created(){  
            this.getResults();
            
        },
        computed:{
            
        }
    })
</script>
<style scoped>
    
    @import "/public/custom/custom.css";
    
</style>
