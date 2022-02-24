<template>
        
    <div class="modal fade" data-bs-backdrop="static" :id="'result_modal_'+result.id" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog " style="max-width: 90%" >
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ result.applicant.first_name+' '+result.applicant.last_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    @click="$emit('getResults')"></button>
            </div>
            <div class="modal-body">

                <!-- /*************************************** */ -->
                <div class="row">
                    <div class="col-md-8 mr-auto">
                        <button class="btn btn-danger text-light btn-sm rounded" v-if="showOnlyNotChecked==true" @click="showOnlyNotChecked=false">
                            Show all questions
                        </button>
                        <button v-else class="btn btn-danger text-light btn-sm rounded" @click="showOnlyNotChecked=true">
                            Show only questions that needs manual checking
                        </button>
                    </div>
                    
                    <div class="col-md-4 ml-auto text-sm">
                        <span class="text-sm fst-italic"> 
                            Passing score:&nbsp;{{ passingScore }}
                        </span>
                        <div class="input-group mb-1">
                            <span class="input-group-text" id="basic-addon1">Score:</span>
                            <input type="number" class="form-control form-control-sm" :max="maxScore" v-model="score" >
                            <span class="input-group-text" id="basic-addon2">/{{ maxScore }}&nbsp;&nbsp;&nbsp;&nbsp;  </span>

                        </div>
                        <div class="input-group mb-1">
                            <label class="input-group-text " for="inputGroupSelect01">Remarks</label>
                            <select class="form-select form-select-sm " id="inputGroupSelect01" v-model="remarks">
                                <option value="Needs manual check">Needs manual check</option>
                                <option value="Passed">Passed</option>
                                <option value="Failed">Failed</option>
                            </select>
                            <a href="#" v-if="updating==false" class="btn-success btn-sm"
                                @click="updateStatus">
                                <i class="fs-4 text-light bi bi-check-circle"></i>
                            </a>
                            <label v-else class="input-group-text" >
                                <i class="fs-4 text-light bi bi-check-circle"></i>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- /*************************************** */ -->
                <ul class="nav nav-tabs mt-2">
                    <li v-for="(part,index) in partitionedQuestions" :key="index" class="nav-item">
                        <a href="#" class="nav-link" :class="(currentPart==part.part)?'active':''"
                            @click="currentPart=part.part">
                            {{ part.part }}
                        </a>
                    </li>
                </ul>
                <div v-for="(part,index) in partitionedQuestions" :key="index"> 
                    <div v-if="currentPart==part.part">
                        <result-question-items
                            v-for="(question,index) in part.questions" :key="index"
                            :question="question"
                            :index="index"
                            :applicantAnswers="applicantAnswers"
                            :showOnlyNotChecked="showOnlyNotChecked"
                            :score_id="result.id"
                            @changeScore="changeScore($event)"
                            ></result-question-items>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    @click="$emit('getResults')">Close</button>
            </div>
            </div>
        </div>
    </div>

</template>

<script >

    import { defineComponent } from 'vue'
    import ResultQuestionItems from './ResultQuestionItems.vue';
    import axiosRetry from 'axios-retry';

    export default defineComponent({
        emits:['getResults','updateStatus'],
        components: { ResultQuestionItems },
        props:{
            result: Object,
            loadingModal: Boolean
        },
        data() {
            return {
                questions: this.result.exam.questions,
                applicantAnswers: this.result.applicant.applicant_answer,
                partitionedQuestions:[],
                currentPart:"",
                showOnlyNotChecked:false,
                score: this.result.applicant_score,
                maxScore:this.result.exam.score,
                passingScore:this.result.exam.passing_score,
                remarks:this.result.status,
                updating: false
                
                
            }
        },
        methods: {
            partitionQuestions(){
                let p=[];
                let temp=[];
                let partsQuestion=[];
                
                this.questions.forEach(question => {
                    temp.push(question.part.trim());
                });

                p=[...new Set(temp)]; //GET DISTINCT PARTS FROM QUESTIONS ARRAY

                

                //CREATE PARTS OBJECT WITH QUESTIONS ARRAY
                for(let b=0;b<p.length;b++){
                    let q=[];
                    for(let a=0;a<this.questions.length;a++){
                        if(p[b]==this.questions[a].part){
                            q.push(this.questions[a]);
                        }
                    }
                    
                    partsQuestion.push({
                        part:p[b],
                        questions:q
                    });
                }
                this.currentPart=partsQuestion[0].part;
                this.partitionedQuestions=partsQuestion;
                
            },
            changeScore(params){
                this.score=params.newScore;
            },
            updateStatus(){

                
                
                this.updating=true;
                axiosRetry(axios, { retries: 3 });
                axios.post(route('admin.scores_status'),{
                    score_id:this.result.id,
                    status: this.remarks
                })
                .then(response => {
                    this.updating=false;
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
            this.partitionQuestions();
            //console.log(this.result.applicant.applicant_answers);
            console.log(this.loadingModal);
            
        },
        watch:{
            // loadingModal: function(val){
            //     console.log(this.loadingModal);
            // }
        }
        
    })
    

</script>
