<template>
    <div class="modal fade modal-md" :id="'viewExamModal'+examIndex" tabindex="-1" aria-labelledby="viewExamModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 100%">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewExamModalLabel"> {{ currentExam.name }} </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        
                        
                    </div>
                    
                    <div class="modal-body">
                        <div class="row">
                            <div  class="d-flex flex-row bd-highlight mb-3" >
                                Exams for:
                                <ul>
                                    <li v-for="(category,index) in currentExam.categories" :key="index">
                                        {{ category.vacancy_name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mb-2" v-for="(part,index) in questionnaireParts" :key="index" >
                            <h5>{{ part }}</h5>
                            <hr>
                            <div class="container mb-1" v-for="(question,qIndex) in filterQuestions(currentExam.questions,part)" :key="question.id">                                
                                <view-exam-question-items  :part="part" :question="question" :num="qIndex"></view-exam-question-items>
                            </div>
                            
                        </div>                        
                    </div>

                    
                    <div class="modal-footer">
                        
                    </div>
                    
                </div>
            </div>
        </div>
</template>


<script>
    import { defineComponent } from 'vue'    
    import moment from 'moment'
import ViewExamQuestionItems from './ViewExamQuestionItems.vue';

    export default defineComponent({
        components: {
                ViewExamQuestionItems
        },

        props: {
            currentExam: Object,            
            examIndex: Number
        },

        data() {
            return {
                questionnaireParts:[],
                ctr:0,
                currentPart:""

                
            }
        },

        methods: {
            getDistinctParts(){
                let parts=[];
                this.currentExam.questions.forEach(question => {
                    parts.push(question.part);
                });

                
                let distinctParts=[...new Set(parts)];
                this.questionnaireParts=distinctParts;
                //console.log(this.questionnaireParts);
            },
            isQuestionPartofPart(question,part){                
                let isPart=false;
                if(question.part==part){
                     isPart=true;
                }
                
                return isPart;
            },
            resetCtr(){
                this.ctr=0;
            },
            increment(){
                this.ctr=this.ctr+1;
            },
            filterQuestions(questions,part){
                let filteredQuestions=[];
                questions.forEach(question => {
                    if(question.part==part){
                        filteredQuestions.push(question);
                    }
                });

                return filteredQuestions;

            }
            
        },
        created(){
            this.getDistinctParts();
            //console.log(this.questionnaireParts);
            //console.log(this.currentExam);
        },
        
        
    })
</script>