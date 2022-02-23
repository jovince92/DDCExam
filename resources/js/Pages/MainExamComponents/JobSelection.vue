<template>
   
    <div class="container">
            <div class="row mx-auto pt-4">
                <div class="col-md-12 mx-auto">
                    Applying for: 
                    <span class="fs-6 text-primary">
                        (select one Job Title)
                    </span>
                </div>
            </div>
            <spinnder v-if="loadingJobs==true"></spinnder>

            <div class="row mx-auto">
                <div class="ml-auto" :class="(select==1)?'col-md-6':'col-md-8'">


                    <div v-for="(v, index) in vacancies" :key="index">
                        <div v-if="index == 0 || index % 3 == 0" class="row fs-6">
                            <div class="col-md-4 d-grid" v-if="vacancies[index]" >
                                <button @click="selectVacancy(vacancies[index].job_id,vacancies[index].job_title,vacancies[index].vacancy_name,vacancies[index].job_description)"
                                    class="btn m-1 text-sm d-flex flex-row"
                                    :class="(selectedJobID==vacancies[index].job_id)?'btn-success  btn-sm':'btn-info  btn-sm'"
                                    >
                                    <i :class="(selectedJobID==vacancies[index].job_id)?' bi bi-check-circle':'bi bi-dot'" class="text-sm mr-auto ">
                                        
                                    </i>
                                    <span class="text-sm">
                                        {{ vacancies[index].job_title }}
                                    </span>
                                    
                                </button>
                            </div>

                            <div class="col-md-4 d-grid" v-if="vacancies[index+1]">
                                <button @click="selectVacancy(vacancies[index+1].job_id,vacancies[index+1].job_title,vacancies[index+1].vacancy_name,vacancies[index+1].job_description)"
                                    class="btn m-1 text-sm d-flex flex-row"
                                    :class="(selectedJobID==vacancies[index+1].job_id)?'btn-success  btn-sm':'btn-info  btn-sm'"
                                    >
                                    <i :class="(selectedJobID==vacancies[index+1].job_id)?' bi bi-check-circle':'bi bi-dot'" class="text-sm mr-auto ">
                                        
                                    </i>
                                    <span class="text-sm">
                                        {{ vacancies[index+1].job_title }}
                                    </span>
                                    
                                </button>
                            </div>

                            <div class="col-md-4 d-grid" v-if="vacancies[index+2]">
                                <button @click="selectVacancy(vacancies[index+2].job_id,vacancies[index+2].job_title,vacancies[index+2].vacancy_name,vacancies[index+2].job_description)"
                                    class="btn m-1 text-sm d-flex flex-row"
                                    :class="(selectedJobID==vacancies[index+2].job_id)?'btn-success  btn-sm':'btn-info  btn-sm'"
                                    >
                                    <i :class="(selectedJobID==vacancies[index+2].job_id)?' bi bi-check-circle':'bi bi-dot'" class="text-sm mr-auto ">
                                        
                                    </i>
                                    <span class="text-sm">
                                        {{ vacancies[index+2].job_title }}
                                    </span>
                                    
                                </button>
                                
                            </div>

                        </div>        
                    </div>

<!-- 
                    <button href="#" @click="selectVacancy(vacancy.job_id,vacancy.job_title,vacancy.vacancy_name,vacancy.job_description)" 
                        class="flex-fill bd-highlight btn m-1" 
                        v-for="(vacancy,index) in vacancies" 
                        :key="index"
                        :class="(selectedJobID==vacancy.job_id)?'btn-success  btn-sm':'btn-info  btn-sm'"
                        :title="vacancy.job_description"
                            >
                        <i :class="(selectedJobID==vacancy.job_id)?'    bi bi-check-circle':'bi bi-dot'" class="text-sm">
                            {{ vacancy.job_title }}
                        </i>
                    </button> -->
                    
                </div>
                <div :class="(select==1)?'col-md-3':'col-md-4'">
                    <div class="row">
                        <div class="col">
                            <h5 class="fw-bolder ">{{ selectedJobTitle }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h6 class="fw-bold fst-italic">{{ selectedJobName }}</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <p class="font-monospace">
                                {{ selectedJobDesc }}
                            </p>
                        </div>
                    </div>
                    <div class="row">                        
                        <!-- <div class="col-md-6"></div> -->
                        <div class="col-md-6 mx-auto">
                            <spinnder v-if="loading==true&&select==0"></spinnder>
                            <a v-if="selectedJobID!=0" href="#" 
                                @click="getAvailableExams()" 
                                class="fs-6 btn  btn-sm mx-2 text-white" 
                                title="Proceed to Selection"
                                style="white-space: nowrap"
                                :class="(loading==true)?'disabled btn-secondary':'btn-primary'"
                                > 
                                View available exams.
                            </a>
                        </div>
                    </div>
                </div>
                <div v-if="select==1" class="col-md-3 mr-auto">

                    <spinnder v-if="loading==true" style="z-index: 100;"></spinnder>
                    <div v-if="exams.length<1">
                        No Available exams for this Job Title
                    </div>
                    <div v-else>
                        Available exams: <br>


                        <ul class="list-group list-group-sm" v-if="loading==false">
                            <li class="list-group-item list-group-item-info" v-for="(exam,index) in exams"
                            :key="index">
                                <a href="#" @click="takeExam(exam)">
                                    {{ exam.name }}        
                                </a>
                            </li>
                            
                        </ul>

                        
                    </div>
                </div>
            </div>
        </div>
</template>


<script>
import { defineComponent } from 'vue'
import Spinnder from '../Admin/Layouts/Spinnder.vue';
import axiosRetry from 'axios-retry';


export default defineComponent({
    emits: ['proceed'],
  components: { Spinnder },
    data(){
        return{
            select:0,

            vacancies:[],
            selectedJobID: 0,
            selectedJobTitle: "",
            selectedJobName: "",
            selectedJobDesc: "",

            loadingJobs:false,
            loading:false,

            

            exams:[]
        }
    },
    created(){
        this.loadingJobs=true;
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
                this.loadingJobs=false;
            })
            .catch(error=>{
                if(error.response.status=='500'){
                    console.log(error);
                }else{
                    alert(error);
                }
            });
            //this.$swal('Hello Vue world!!!');
    },
    methods:{
        selectVacancy(id,job,name,desc){
            this.selectedJobID=id;
            this.selectedJobTitle=job;
            this.selectedJobName=name;
            this.selectedJobDesc=desc
        },
        proceed(exam){
            this.$emit('proceed',{
                job_id:this.selectedJobID,
                job_title: this.selectedJobTitle,
                job_name: this.selectedJobName,
                job_desc:this.selectedJobDesc,
                exam:exam
                
            });
        },
        getAvailableExams(){
            this.loading=true;
            axiosRetry(axios, { retries: 3 });
            axios.post('/api/availableexams',{
                job_id:this.selectedJobID
            })
            .then(response => {
                this.loading=false;
                this.exams=response.data;
                this.select=1;
                //console.log(response.data);
            })
            .catch(error=>{
                if(error.response.status=='500'){
                    console.log(error);
                }else{
                    alert(error);
                }
            });
            //this.$swal('Hello Vue world!!!');
        },
        takeExam(exam){
            // this.$swal('Take this exam?');
            this.$swal({
                title: exam.name,
                text: "Take this exam?",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Proceed!'
            }).then((result) => {
            if (result.isConfirmed) {
                this.proceed(exam);
            }
            })
        }
       
    }

})
</script>
