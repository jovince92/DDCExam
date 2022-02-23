<template>
    <Head title="Applicants" />
    <sidebar>
        <div class="container-xl overflow-scroll" style="height: 600px;">
            <div class="table-responsive">
                <div class="table-wrapper">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-md-5  rounded p-1">
                                <h2>Applicants</h2>
                                
                            </div>
                            <div class="col-md-2  rounded p-1">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text" for="inputGroupSelect01">Show:</label>
                                    <select class="form-select" id="inputGroupSelect01" v-model="limit">                                        
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-5 rounded p-1">
                                
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" class="form-control form-control-sm" placeholder="Applicant's name (first/last/middle)" v-model="name" 
                                        @keyup.enter="filterApplicants()">
                                    <a href="#" class="btn bg-light" type="button" id="button-addon2" @click="name=''" >
                                        <i class="text-danger fs-6 bi bi-x-circle"></i>
                                    </a>
                                    <a href="#" class="btn btn-info" type="button" id="button-addon2" @click="filterApplicants()" >
                                        <i class="fs-6 bi bi-search"></i>
                                    </a>
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
                    <spinnder v-if="applicantsLoading==true"></spinnder>
                    <table class="table table-striped table-hover" >
                        <thead>
                            <tr>
                                <th style="width: 20%;">Name</th>
                                <th style="width: 15%;">DOB</th>
                                <th style="width: 15%;">Mobile No.</th>                                
                                <th style="width: 15%;">Email</th>
                                <th style="width: 25%;">RegDate</th>
                                <th style="width: 10%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody v-if="gettingLocations==false">
                            <applicant-items v-for="(applicant,index) in applicants" :key="index" 
                                :applicant="applicant" 
                                :aIndex="index" 
                                @updated="filterApplicants()"
                                :locations="locations"
                                ></applicant-items>
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
    import ApplicantItems from './ApplicantComponents/ApplicantItems.vue';
    import Spinnder from './Layouts/Spinnder.vue';
    import axiosRetry from 'axios-retry';
    




    export default defineComponent({
        components: {
            Head,    
            JetValidationErrors,
            Link,
            Sidebar,
                ApplicantItems,
                Spinnder,
            
            
        },

        props: {
            

            },

        data() {
            return {
                applicants: [],
                applicantsLoading:false,
                limit:25,
                name:"",
                locations:[],
                gettingLocations:true
            }
        },

        methods: {
            getApplicants(){
                this.applicantsLoading=true;
                this.applicants=[];
                axiosRetry(axios, { retries: 3 });
                axios.get('/admin/api/applicant/all/')
                .then(response => {                    
                    this.applicants= response.data
                    //console.log(response.data);
                    this.applicantsLoading=false;
                })
                .catch(error=>{
                    if(error.response.status=='500'){
                        console.log(error);
                    }else{
                        alert(error);
                    }
                });

            },
            filterApplicants(){
                this.applicantsLoading=true;
                this.applicants=[];
                axiosRetry(axios, { retries: 3 });
                axios.post('/admin/api/applicant/filter',{
                    name: this.name,
                    limit:this.limit
                })
                .then(response => {                    
                    this.applicants= response.data
                    //console.log(response.data);
                    this.applicantsLoading=false;
                })
                .catch(error=>{
                    if(error.response.status=='500'){
                        console.log(error);
                    }else{
                        alert(error);
                    }
                });

            },
            getLocations(){
                axiosRetry(axios, { retries: 3 });
                axios.get('/api/locations')
                .then(response => {
                    this.locations=response.data;
                    this.gettingLocations=false;
                    //console.log(response.data);
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
            this.getApplicants();
            this.getLocations();
            
            
        },
        mounted(){
            
        },
        computed:{
            
        }
    })
</script>

<style scoped>
    @import "/public/custom/custom.css";
</style>
