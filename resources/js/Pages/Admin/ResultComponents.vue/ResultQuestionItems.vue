<template>
    <div class="card border-info mb-4  w-100" v-if="showThisQuestion==true" >
        <div class="d-flex justify-content-between align-items-center card-header bg-info text-white" id="h2">
            <div class="row w-100">
                <div class="col-md-9 ">
                    <span>
                        Question {{ index +1 }}
                        <span class="fs-6">
                            ({{ type }})&nbsp;{{ question.points }}&nbsp;{{ (question.points>1)?' pts.':'pt.' }}
                        </span>
                    </span>
                </div>
                <div class="col-md-3 d-flex flex-row bd-highlight">
                    <div class="input-group mb-3 text-sm">
                        <span class="input-group-text" id="basic-addon1">Score</span>
                        <input type="number" class="form-control form-control-sm" :max="question.points" placeholder="Input score" v-model="score">
                        <a v-if="updating==false" href="#" class="btn-sm" :class="(checked==1)?'btn-success':'btn-danger'" 
                            
                            title="Check"
                            @click="updateScore(question.id)">
                            <i class="fs-4 text-light bi bi-check-circle"></i>
                        </a>
                        <a href="#" v-else class="btn-secondary btn-sm disabled">
                            <i class="fs-4 text-light bi bi-check-circle"></i>
                        </a>


                        
                        
                    </div>
                </div>
            </div>
            
        </div>
        <div id="q2" aria-labelledby="h2" style="">
            <div class="card-body">
                <p>{{ question.question }}</p>
                <div class="w-100 row">
                    <div class="col-md-6 p-1">
                        <div v-if="type=='Enumeration'">
                            <h6>Applicant's Answer:</h6>
                            <ul class="list-group">
                                <li v-for="(answer,index) in enumApplicantAnswers(question.id)" :key="index"
                                    class="list-group-item">
                                    {{ answer }}
                                </li>
                            </ul>
                        </div>

                        <div v-else>
                            <h6>Applicant's Answers:</h6>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    {{ applicantQuestionAnswer(question.id) }}
                                </li>
                            </ul>
                        </div>
                    </div>


                    <div class="col-md-6 p-1">
                        <div v-if="type!='Essay'&&type!='Enumeration'">
                            <h6>Correct Answer: (if any)</h6>
                            <ul class="list-group">
                                <li class="list-group-item">
                                    {{ question.answer.answer }}
                                </li>
                            </ul>
                        </div>
                        <div v-if="type=='Enumeration'">
                            <h6>Correct Answers: (if any)</h6>
                            <ul class="list-group">
                                <li  v-for="(answer,index) in enumAnswers(question.answer.answer)" :key="index"
                                class="list-group-item">
                                    {{ answer }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</template>

<script>

    import { defineComponent } from 'vue'
    import axiosRetry from 'axios-retry';


    export default defineComponent({
  
        emits:['changeScore'],
        props:{
            question: Object,
            index: Number,
            applicantAnswers: Object,
            showOnlyNotChecked:Boolean,
            score_id: Number
        },
        data() {
            return {
                type:this.question.type,
                score: this.questionScore(this.question.id),
                checked: 0,
                updating: false,
                
                
                
            }
        },
        methods:{
            applicantQuestionAnswer(qid){
                let answer="";
                this.applicantAnswers.forEach(qA => {
                    if (qA.question_id==qid){
                        answer=qA.applicant_answer;
                    }
                });

                return answer;
            },
            enumAnswers(answer){

                return answer.split(',');

            },
            enumApplicantAnswers(qid){
                let answer="";

                this.applicantAnswers.forEach(qA => {
                    if (qA.question_id==qid){
                        answer=qA.applicant_answer;
                    }
                });

                return answer.split(',');

            },
            questionScore(qid){
                let score=0;
                this.applicantAnswers.forEach(qA => {
                    if (qA.question_id==qid){
                        score=qA.score;
                    }
                });
                //console.log(score);
                return score;
                //this.score=score;
            },
            updateScore(qid){
                this.updating=true;
                let qaId=0;
                this.applicantAnswers.forEach(qA => {
                    if (qA.question_id==qid){
                        qaId=qA.id;
                    }
                });
                axiosRetry(axios, { retries: 3 });
                axios.post(route('admin.scores_update_2'),{
                    answer_id:qaId,
                    score:this.score,
                    score_id: this.score_id
                })
                .then(response => {
                    this.updating=false;
                    this.checked=1;
                    this.$emit('changeScore',{
                        newScore: response.data
                    });
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
            //console.log(this.applicantAnswers);
            //console.log(this.score);
            
        },
        mounted(){
            //this.score=this.questionScore(this.question.id);
            //this.questionScore(this.question.id);
        }
        ,
        computed:{
            showThisQuestion(){
                let ok = true;
                let checked=0;
                this.applicantAnswers.forEach(qA => {
                    if (qA.question_id==this.question.id){
                        checked=qA.checked;
                        this.checked=qA.checked;
                    }
                });

                if(this.showOnlyNotChecked==true){
                    if(checked==1){
                        ok=false;
                    }
                }
                //console.log(checked);
                return ok;
            }

        }
    })

</script>
