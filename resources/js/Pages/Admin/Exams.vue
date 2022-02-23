<template>
    <Head title="Exams" />
    
    <add-exam-modal :vacancies="vacancies" @getExams="filterExams"></add-exam-modal>
    
    <sidebar>
        
        <div class="container-xl overflow-scroll" style="height: 600px;">
            

            <div class="table-responsive ">
                <div class="table-wrapper ">
                    <div class="table-title">
                        <div class="row">
                            <div class="col-md-3 p-1">
                                <h2>Exams</h2>
                            </div>
                            <div class="col-md-2 p-1">
                                <div class="input-group input-group-sm">
                                    <label class="input-group-text" for="inputGroupSelect01">Show:</label>
                                    <select class="form-select" id="inputGroupSelect01" v-model="limit">                                        
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-7 p-1">
                                <div class="input-group input-group-sm mb-1">
                                    <input type="text" class="form-control form-control-sm" placeholder="Exam name or Job Title" v-model="name" 
                                        @keyup.enter="filterExams()">
                                    <a href="#" class="btn bg-light" type="button" id="button-addon2" @click="name=''" >
                                        <i class="text-danger fs-6 bi bi-x-circle"></i>
                                    </a>
                                    <a href="#" class="btn btn-info" type="button" id="button-addon2" @click="filterExams()" >
                                        <i class="fs-6 bi bi-search"></i>
                                    </a>
                                    <a href="#addExamModal" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addExamModal"> 
                                        <i class="fs-6 bi bi-plus-circle"></i>
                                    </a>
                                </div>

                                

                                <!-- <a href="#" class="btn btn-info btn-sm rounded" @click="getExams"> 
                                    <i class="fs-6 bi bi-arrow-clockwise"></i>
                                    <span>Refresh</span>
                                </a> -->
                            </div>
                        </div>
                    </div>
                    <spinnder v-if="examsLoading==true"></spinnder>
                    <table v-else class="table table-striped table-hover ">
                        <thead>
                            <tr>
                                <th style="width: 8%;">Exam ID</th>                                
                                <th style="width: 16%;">Exam Name</th>
                                <th style="width: 20%;">Exam for&nbsp;(job title):</th>
                                <th style="width: 22%;">Scoring</th>                                
                                <th style="width: 19%;">Date Added</th>
                                <th style="width: 15%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody >
                            <exam-items v-for="(exam, index) in exams" 
                                :key="index" 
                                :exam="exam" 
                                :examIndex="index" 
                                @deleteExam="deleteExam($event)"
                                :vacancies="vacancies"
                                @getExams="filterExams()"
                            ></exam-items>
                            				
                        </tbody>
                    </table>
                    <!-- <div class="clearfix">
                        <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                        <ul class="pagination">
                            <li class="page-item disabled"><a href="#">Previous</a></li>
                            <li class="page-item"><a href="#" class="page-link">1</a></li>
                            <li class="page-item"><a href="#" class="page-link">2</a></li>
                            <li class="page-item active"><a href="#" class="page-link">3</a></li>
                            <li class="page-item"><a href="#" class="page-link">4</a></li>
                            <li class="page-item"><a href="#" class="page-link">5</a></li>
                            <li class="page-item"><a href="#" class="page-link">Next</a></li>
                        </ul>
                    </div> -->
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
    import AddExamModal from './ExamComponents/AddExamModal.vue';
    import ExamItems from './ExamComponents/ExamItems.vue';
    import Spinnder from './Layouts/Spinnder.vue';
    import axiosRetry from 'axios-retry';
    




    export default defineComponent({
        
        components: {
            Head,    
            JetValidationErrors,
            Link,
            Sidebar,
                AddExamModal,
                ExamItems,
                Spinnder,
            
            
        },

        props: {
            

        },

        data() {
            return {
                exams: [],
                examsLoading: false,
                limit:25,
                name:"",
                vacancies:[]
            }
        },
        
        methods: {
            test(){
                console.log('test');
            },
            getExams(){



                
                this.examsLoading=true;
                this.exams=[];
                axiosRetry(axios, { retries: 3 });
                axios.get('/admin/api/exam/all/')
                .then(response => {                    
                    this.exams= response.data
                    //console.log(this.exams);
                    this.examsLoading=false;
                })
                .catch(error=>{
                    if(error.response.status=='500'){
                        console.log(error);
                    }else{
                        alert(error);
                    }
                });
            },
            deleteExam(params){
                //alert(params.id);
                this.examsLoading=true;
                this.$toast.success('Deleting exam...',{
                        position: 'top-right'
                    }
                );
                axiosRetry(axios, { retries: 3 });
                axios.post('/admin/api/exam/delete',{
                    id:params.id
                })
                .then(response => {                    
                    //this.exams= response.data
                    //console.log(this.exams);
                    this.filterExams();
                    this.$toast.success('Delete done!',{
                          position: 'top-right'
                        }
                    );
                })
                .catch(error=>{
                    if(error.response.status=='500'){
                        console.log(error);
                    }else{
                        alert(error);
                    }
                });
            },
            filterExams(){
                this.examsLoading=true;
                this.exams= [];
                axiosRetry(axios, { retries: 3 });
                axios.post('/admin/api/exam/filter',{
                    name:this.name,
                    limit: this.limit
                })
                .then(response => {                    
                    this.exams= response.data
                    this.examsLoading=false;
                    
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
            this.getExams();
            axiosRetry(axios, { retries: 3 });
            axios.get('/api/vaccancies/')
            .then(response => {
                //console.log(response.data[1]);
                //this.vacancies = {...response.data[1]};
                //console.log(this.vacancies);
                response.data[1].forEach(element => {
                    //console.log(element);
                    this.vacancies.push(element);
                });
                //console.log(this.vacancies);
            })
            .catch(error=>{
                if(error.response.status=='500'){
                    console.log(error);
                }else{
                    alert(error);
                }
            });
        }
    })
</script>


<style scoped>
    
    @import "/public/custom/custom.css";
    
</style>