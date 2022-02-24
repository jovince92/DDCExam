<template>
    <Head title="DDC Exam" />
    <layout>
        <div class="container p-5" v-if="hasTakenExam==true">
            <div class="row">
                <div class="col-md-12">
                    You have already taken an Exam. Wait for HR to contact you on your registered Mobile Number.
                </div>
            </div>
            
        </div>
        <div class="container" v-else>
            <job-selection @proceed="proceed($event)" v-if="takeExam==false"></job-selection>

            <div v-else class="container p-2">
                <header>
                    <div class="d-flex justify-content-between w-100">
                        <div class="mr-auto">
                            Applying for:&nbsp;{{ job_title }}
                            <br>
                            Exam Name:&nbsp;{{ exam.name }}
                        </div>

                        
                        <div class="ml-auto ">
                            <button v-if="submittingExam==false" class="btn text-light" 
                                :class="(questionAnswer.length==qIndexMax)?'btn-primary':'btn-danger disabled'"
                                @click="saveExam()">
                                Submit Exam
                                <i class="bi bi-box-arrow-right"></i>
                            </button>
                            
                        </div>
                    </div>
                </header>
                
                <spinnder v-if="preparingExam==true"></spinnder>
                <spinnder v-if="submittingExam==true" ></spinnder>
                
                <div v-else class="row">
                    <div class="col-md-12 mx-auto">
                        <div class="h-100 p-2 bg-light border rounded-3 ">
                            <div class="w-100 d-flex justify-content-between">
                                <h4 class="card-title mr-auto">{{ currentPart.part }}</h4>
                                <div class="ml-auto">
                                    Questions answered:
                                    <h6 :class="(questionAnswer.length==qIndexMax)?'text-success':'text-danger'">
                                        {{ questionAnswer.length }}/{{ qIndexMax }}
                                    </h6>
                                    
                                </div>
                            </div>
                            <div class="d-flex flex-row-reverse bd-highlight">
                                <a href="#" class="btn btn-link btn-sm" @click="showInstructions()">
                                    Click here for instructions.
                                </a>
                            </div>
                            
                            <!-- <h6 class="card-subtitle mb-2 text-muted">Card subtitle</h6> -->
                            <div class="card border-info my-3 ">

                                <div class="d-flex justify-content-between align-items-center card-header text-white" id="h1"
                                    :class="(answered==true)?'bg-info':'bg-danger'">
                                    <div class="w-100 d-flex justify-content-between">
                                        <div class="mr-auto">
                                            <span class="fs-5">
                                                Question {{ qIndex}})&nbsp;
                                            </span>
                                            <span class="fs-6 fst-italic">
                                                ({{ currentQuestion.type }})
                                            </span>
                                        </div> 
                                        <div>
                                            <span class="ml-auto">
                                                {{ currentQuestion.points }}{{ (currentQuestion.points<2)?' pt.':' pts.'  }} 
                                            </span>
                                        </div>

                                    </div>
                                    
                                </div>
                                <div id="q1" class="collapse show" aria-labelledby="h1">
                                    <div class="card-body">
                                        <p>{{ currentQuestion.question }}</p>

                                        <!-- /**************************************** */ -->
                                        <div v-if="currentQuestion.type=='Multiple Choice'" class="w-100 row">
                                            <span class="form-label"> Your Answer: {{ selectedChoice }}</span>
                                            
                                            <div class="d-grid gap-2 col-md-3 px-2 mx-auto" v-for="(choice,index) in currentQuestion.choices" :key="index">
                                                <button class="btn  btn-sm  rounded-pill  "
                                                    :class="(selectedChoice==choice.choice)?'btn-primary btn-sm text-light fs-5 ':'btn-outline-primary text-dark'"
                                                    @click="selectedChoice=choice.choice">
                                                    <span v-if="selectedChoice==choice.choice">
                                                        <i class="text-success bi bi-check2-circle"></i>
                                                    </span>
                                                    {{  choice.choice }}

                                                </button>
                                            </div>
                                            
                                            
                                        </div>
                                        <div v-else-if="currentQuestion.type=='True or False'" class="row w-25 d-flex flex-row bd-highlight mb-3">
                                            <span class="form-label"> Your Answer: {{ selectedChoice }} </span>
                                            <button class="btn  btn-sm mx-auto my-2 rounded-pill "
                                                :class="(selectedChoice=='true')?'btn-primary text-light fs-5 ':'btn-outline-primary text-dark'"
                                                @click="selectedChoice='true'"
                                                >
                                                <span v-if="selectedChoice=='true'">
                                                    <i class="text-success bi bi-check2-circle"></i>
                                                </span>
                                                True
                                            </button>

                                            <button class="btn  btn-sm mx-auto my-2 rounded-pill "
                                                :class="(selectedChoice=='false')?'btn-primary text-light fs-5 ':'btn-outline-primary text-dark'"
                                                @click="selectedChoice='false'"
                                                >
                                                <span v-if="selectedChoice=='false'">
                                                    <i class="text-success bi bi-check2-circle"></i>
                                                </span>
                                                False
                                            </button>



                                        </div>
                                        <div v-else-if="currentQuestion.type=='Enumeration'" class="row w-25 d-flex flex-row bd-highlight mb-3">
                                            <span class="form-label"> Your Answers:</span>
                                            <div class="input-group mb-1" v-for="(item,index) in enumItems(currentQuestion.answer.answer)" :key="index">
                                                <span class="input-group-text" id="">{{ index+1 }}</span>
                                                <input type="text" :id="'enumAnswer_'+index" class="form-control form-control-sm" :value="(enumAnswers[index])?enumAnswers[index]:''" >
                                            </div>
                                        </div>
                                        <div v-else-if="currentQuestion.type=='Essay'" class="row w-100 d-flex flex-row bd-highlight mb-3">
                                            <span class="form-label">Your Answer:</span>
                                            <div class="input-group">
                                                
                                                <textarea class="form-control" id="essay" aria-label="With textarea" v-model="essayAnswer"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="w-100 d-flex flex-row-reverse bd-highlight">

                                    <!-- /***************NEXT ANSWER/PART BUTTONS********************** */ -->

                                    <div v-if="currentPartQuestionIndex==(currentPart.questions.length -1 )">
                                        <button class="btn btn-sm  m-2 text-light"
                                            v-if="(currentPartIndex==(partsCounts-1))"
                                            :class="(answered==false)?'disabled btn-secondary':'btn-primary'"
                                            @click="examFinished()">
                                            Exam finished!                                            
                                            <i class="text-light bi bi-arrow-right-circle"></i>
                                        </button>

                                        <button class="btn btn-sm  m-2 text-light"
                                            v-else
                                            :class="(answered==false)?'disabled btn-secondary':'btn-primary'"
                                            @click="nextPartWithConfirmation()">                                            
                                            Go To Next Part
                                            <i class="text-light bi bi-arrow-right-circle"></i>
                                        </button>
                                    </div>
                                    <div v-else>
                                        <button class="btn btn-sm  m-2 text-light"
                                        
                                            :class="((answered==false)||(currentPartQuestionIndex==(currentPart.questions.length -1 )))?'disabled btn-secondary':'btn-primary'"
                                            @click="nextQuestion()">
                                            Next Question
                                            <i class="text-light bi bi-arrow-right-circle"></i>
                                        </button>
                                    </div>



                                    


                                    

                                    








                                    <!-- /***************CONFIRM ANSWER BUTTONS********************** */ -->
                                    <button class="btn btn-sm m-2 text-light" @click="addToQuestionAnswer()"
                                        :class="(answered==false)?'btn-primary':'btn-success'">
                                        <span v-if="answered==false">
                                            <i class="text-light bi bi-check-circle-fill"></i>
                                            Confirm Answer
                                        </span>
                                        <span v-else>
                                            <i class="text-light bi bi-check-circle-fill"></i>
                                            Change Answer
                                        </span>
                                    </button>
                                    
                                </div>
                            </div>


                            <nav aria-label="Got to Question">
                                <ul class="pagination pagination-sm justify-content-center">                                
                                    <li class="page-item" :class="(currentPartQuestionIndex==0)?'disabled':''">
                                        <a class="page-link" href="#" tabindex="-1" @click="prevQuestion()" >Previous Question</a>
                                    </li>
                                    <li class="page-item"  
                                        v-for="(question,index) in currentPart.questions" :key="index" 
                                        :class="(currentPartQuestionIndex==index)?'active':''"
                                        >
                                        <a class="page-link" href="#" @click="selectQuestion(question,index)">
                                            {{ index+1 }}
                                        </a>
                                    </li>
                                    <li class="page-item" :class="(currentPartQuestionIndex==(currentPart.questions.length -1 ))?'disabled':''">
                                        <a class="page-link"  href="#" @click="nextQuestion()">Next Question</a>
                                    </li>                                
                                </ul>
                            </nav>


                            <nav aria-label="Got to Part">
                                <ul class="pagination pagination-sm justify-content-center" >                                
                                    <li class="page-item" :class="(currentPartIndex==0)?'disabled':''">
                                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true" @click="prevPart()">Previous Part</a>
                                    </li>
                                    <li v-for="(part,index) in parts" :key="index" class="page-item" :class="(currentPartIndex==index)?'active':''">
                                        <a class="page-link" href="#"  @click="selectPart(part,index)">
                                            {{ index+1 }}
                                        </a>
                                    </li>
                                    <li class="page-item" :class="(currentPartIndex==(partsCounts-1))?'disabled':''">
                                        <a class="page-link" href="#" @click="nextPart()">Next Part</a>
                                    </li>                                
                                </ul>
                            </nav>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
        













    </layout>
</template>

<script>
    import { defineComponent } from 'vue'
    
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Layout from './Admin/Layouts/Layout.vue';
    import JobSelection from './MainExamComponents/JobSelection.vue';
    import Spinnder from './Admin/Layouts/Spinnder.vue';
    import axiosRetry from 'axios-retry';
    
    




    export default defineComponent({
        components: {
            Head,    
            
            Link,
            Layout,
            JobSelection,
                Spinnder,
            
            
        },

        props: {
            

            },

        data() {
            return {

                hasTakenExam:false,
                submittingExam:false,

                selectedJob:Object,
                takeExam:false,
                exam:[],
                job_id:0,
                job_title: "",
                job_name: "",
                job_desc:"",

                parts:[],
                partsCounts:0,
                
                qIndex:1,
                qIndexMax:0,


                currentPartIndex:0,

                currentPartQuestionIndex:0,

                questions:[],
                
                preparingExam:false,
                currentQuestion:Object,

                lastItem: false,

                essayAnswer:"",

                questionAnswer:[],


                selectedChoice:"",

                enumAnswerCount:0,

                enumAnswers:[],

                currentPart:[],

                answered:false,


                
                
            }
        },

        methods: {
            proceed(params){
                this.takeExam=true;
                this.job_id=params.job_id;
                this.job_title=params.job_title;
                this.job_name=params.job_name;
                this.job_desc=params.job_desc;
                this.exam=params.exam;

                this.parts=this.questionParts(params.exam);
                this.partsCounts=this.parts.length;

                this.currentPartQuestionIndex=0;
                this.currentPartIndex=0;
                this.currentPart=this.parts[0];
                this.currentQuestion = this.parts[0].questions[0];
                

                this.qIndexMax=params.exam.questions.length;

                // console.log(this.parts);
                // console.log(this.partsCounts);

            },
            questionParts(exam){
                this.preparingExam=true;
                let p=[];
                let temp=[];
                let partsQuestion=[];
                
                exam.questions.forEach(question => {
                    temp.push(question.part);

                });

                p=[...new Set(temp)]; //GET DISTINCT PARTS FROM QUESTIONS ARRAY

                
                //CREATE PARTS OBJECT WITH QUESTIONS ARRAY
                for(let b=0;b<p.length;b++){
                    let q=[];
                    for(let a=0;a<exam.questions.length;a++){
                        if(p[b]==exam.questions[a].part){
                            q.push(exam.questions[a]);
                        }
                    }
                    
                    partsQuestion.push({
                        part:p[b],
                        questions:q
                    });
                }
                
                this.preparingExam=false;
                //console.log(partsQuestion);
                return partsQuestion;
                
            },
            
            
            
            enumItems(answer){
                //console.log(answer);
                let items = answer.split(',');
                this.enumAnswerCount = items.length;
                return items;
            },
            addToQuestionAnswer(){
                let answer="";
                let enumerationAnswers=[];
                let isAnswered=false;
                let answeredIndex=0;
                
                if(this.currentQuestion.type=='Multiple Choice'||this.currentQuestion.type=='True or False'){
                    answer=this.selectedChoice;
                }
                else if(this.currentQuestion.type=='Enumeration'){
                    for(let i=0;i<this.enumAnswerCount;i++){
                        enumerationAnswers.push(document.getElementById('enumAnswer_'+i).value);
                        //console.log(document.getElementById('enumAnswer'+i).val);
                    }
                    answer=enumerationAnswers.toString();
                }else if(this.currentQuestion.type=='Essay'){
                    answer=this.essayAnswer;
                }
                
                
                for(let i=0;i<this.questionAnswer.length;i++){
                    if(this.questionAnswer[i].question_id==this.currentQuestion.id){
                        isAnswered=true;
                        answeredIndex=i;
                    }
                }

                if(isAnswered==false){
                    this.questionAnswer.push({
                        question_id: this.currentQuestion.id,
                        question_text: this.currentQuestion.question,
                        question_points: this.currentQuestion.points,
                        question_part: this.currentQuestion.part,
                        question_type: this.currentQuestion.type,
                        answer: answer
                    });
                }else{
                    let temp={
                        question_id: this.currentQuestion.id,
                        question_text: this.currentQuestion.question,
                        question_points: this.currentQuestion.points,
                        question_part: this.currentQuestion.part,
                        question_type: this.currentQuestion.type,
                        answer: answer
                    };
                    this.questionAnswer.splice(answeredIndex,1, temp);
                }

                //console.log(this.questionAnswer);
                this.answered=true;
                this.$toast.success(`<i class="fs-5 bi bi-check2-circle"></i>`,{
                        position: 'top-right',
                        timeout: 100,
                        classNames: ["fade"],
                    }
                );
            },
            checkifAnswered(){
                let isAnswered=false;
                let answeredIndex=0;
                for(let i=0;i<this.questionAnswer.length;i++){
                    if(this.questionAnswer[i].question_id==this.currentQuestion.id){
                        isAnswered=true;
                        answeredIndex=i;
                    }
                }

                if(isAnswered==true){
                    if(this.currentQuestion.type=='Multiple Choice'||this.currentQuestion.type=='True or False'){
                        this.selectedChoice=this.questionAnswer[answeredIndex].answer;
                        console.log(this.selectedChoice);
                    }else if(this.currentQuestion.type=='Enumeration'){
                        let temp = this.questionAnswer[answeredIndex].answer.split(',');
                        this.enumAnswers=temp;
                        
                    }else if(this.currentQuestion.type=='Essay'){
                        this.essayAnswer=this.questionAnswer[answeredIndex].answer;
                    }
                    this.answered=true;
                }else{
                    this.selectedChoice="";
                    this.enumAnswerCount=0;
                    this.essayAnswer="";
                    this.answered=false;
                }
                
            }
            ,
            selectPart(part,index){
                this.currentPart=part;
                this.currentPartIndex=index;
                this.currentQuestion=this.currentPart.questions[0];
                this.currentPartQuestionIndex=0;
                this.qIndex=1;

                

            },
            nextPart(index){
                this.currentPartIndex=this.currentPartIndex+1;
                this.currentPart=this.parts[this.currentPartIndex];
                this.currentQuestion=this.currentPart.questions[0];
                this.currentPartQuestionIndex=0;
                this.qIndex=1;

                

            },
            nextPartWithConfirmation(index){


                this.$swal({
                    title: 'Proceed to next part?',
                    text: "You can still come back to this part",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Proceed'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.currentPartIndex=this.currentPartIndex+1;
                        this.currentPart=this.parts[this.currentPartIndex];
                        this.currentQuestion=this.currentPart.questions[0];
                        this.currentPartQuestionIndex=0;
                        this.qIndex=1;
                    };
                });


                

                

            },
            prevPart(index){
                this.currentPartIndex=this.currentPartIndex-1;
                this.currentPart=this.parts[this.currentPartIndex];
                this.currentQuestion=this.currentPart.questions[0];
                this.currentPartQuestionIndex=0;
                this.qIndex=1;

                

            },
            prevQuestion(){
                this.currentPartQuestionIndex=this.currentPartQuestionIndex-1;
                this.currentQuestion = this.currentPart.questions[this.currentPartQuestionIndex];

                this.qIndex=this.currentPartQuestionIndex+1;

                //console.log(this.selectedChoice);


            },
            nextQuestion(){
                this.currentPartQuestionIndex=this.currentPartQuestionIndex+1;
                this.currentQuestion = this.currentPart.questions[this.currentPartQuestionIndex];

                this.qIndex=this.currentPartQuestionIndex+1;

            },
            selectQuestion(question,index){
                this.currentQuestion=question;
                this.currentPartQuestionIndex=index;
                this.qIndex=this.currentPartQuestionIndex+1;

            },
            showInstructions(){

                this.$swal({
                title: 'Instructions',
                width: 800,
                color: '#716add',
                html:`<p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc fermentum, tortor sed hendrerit hendrerit, nisi felis porttitor tortor, id mollis arcu turpis eget enim. Nulla eu libero risus. Ut imperdiet fermentum augue vel lacinia. Fusce sagittis eu lectus in interdum. Cras dictum sem metus, a facilisis mauris pharetra ac. Pellentesque sapien turpis, efficitur eu nunc quis, auctor tristique tortor. Aenean et aliquet nunc, vel luctus erat. Nulla tortor nibh, pellentesque ac ex at, bibendum convallis purus.

                        Praesent tortor erat, convallis eget ornare eu, dignissim non mauris. Sed in tincidunt nunc, at tincidunt leo. Donec fermentum pellentesque faucibus. Etiam vitae velit porttitor, efficitur odio ut, mollis metus. Vestibulum tincidunt odio nibh, et mattis arcu mattis quis. Nam et viverra quam. Aenean elementum purus a metus sodales dapibus nec vel orci. Vivamus pulvinar enim non pretium scelerisque. Ut posuere sollicitudin mi, a fringilla diam congue sit amet. Praesent eros eros, commodo et nunc vel, luctus egestas metus. Morbi at auctor quam. Nunc nulla quam, convallis sed aliquet id, convallis in ante. Praesent dignissim tortor aliquet est fringilla laoreet. Vivamus quis lacus vehicula, sollicitudin felis sed, porttitor orci.
                    </p>`
                });
                
            },
            saveExam(){
                this.submittingExam=true;
                this.$toast.warning(`Submitting Exam... Don't leave this page!`,{
                        position: 'top-right',
                    }
                );
                axiosRetry(axios, { retries: 3 });
                axios.post(route('applicant_exams_save'),{
                    exam_id:this.exam.id,
                    passing_score: this.exam.passing_score,
                    job_id: this.job_id,
                    job_title: this.job_title,
                    question_answer: this.questionAnswer

                })
                .then(response => {
                    this.submittingExam=false;
                    this.$toast.success(`Exam submitted!`,{
                            position: 'top-right',
                        }
                    );
                    this.hasTakenExam=true;
                })
                .catch(error=>{
                    if(error.response.status=='500'){
                        console.log(error);
                    }else{
                        alert(error);
                    }
                });
            },
            examFinished(){
                this.$swal(
                    'Exam Finished!',
                    "Click 'Submit Exam' button to finish, or review your answers",
                    'success'
                );
            }
            



            
            
        },
        created(){
            
            axiosRetry(axios, { retries: 3 });
            axios.get(route('exams_check'))
                .then(response => {
                    
                    this.hasTakenExam=(response.data>0)?true:false;
                    //alert(this.hasTakenExam);
            })
            .catch(error=>{
                if(error.response.status=='500'){
                    console.log(error);
                }else{
                    alert(error);
                }
            });

            
        },
        watch:{

            currentQuestion(){
                this.checkifAnswered();
            }

            


        }
    })
</script>

<style scoped>

    
    

</style>>
