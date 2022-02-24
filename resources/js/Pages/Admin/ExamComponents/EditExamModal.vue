<template>
    <!-- Modal -->
    <add-question-modal></add-question-modal>
        <div class="modal fade modal-md" :id="'editExamModal'+examIndex" tabindex="-1" aria-labelledby="editExamModalLabel" aria-hidden="true">
            <div class="modal-dialog" style="max-width: 100%">
                <div class="modal-content" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="editExamModalLabel">Add Exam</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="container" style="height: 500px over">
                            <div class="row" style="width:90%">
                                <div class="col-md-3 " >                                    
                                    <div id="home_body">            
                                        <div class="row">                
                                            <div class="col">                    
                                                <label style="display:flex;" for="part">
                                                    Job Category 
                                                    <span class="text-primary" style="font-style: italic;font-size: 10px;padding: 6px;">
                                                        Select one or multiple
                                                    </span>
                                                </label>   
                                                <div class="d-flex flex-wrap overflow-scroll" style="height:300px; width:100%">
                                                    <div class="flex-fill">
                                                        <div v-for="(vacancy,index) in vacancies" :key=index class="form-check ">
                                                            <input class="form-check-input" type="checkbox" :value="vacancy.job_id+','+ vacancy.job_title" :id=vacancy.job_id v-model="selectedJobs">
                                                            <label class="form-check-label" :for=vacancy.job_id>
                                                                {{ vacancy.job_title }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="border border-1 rounded overflow-scroll" style="height:  330px">
                                                    Selected:
                                                    <span class="fs-6">
                                                        <table>                                                            
                                                            <tr>
                                                                <td>
                                                                    Job Id
                                                                </td>
                                                                <td>
                                                                    Vaccancy
                                                                </td>
                                                            </tr>
                                                            <tr v-for="(job,index) in selectedJobs" :key="index">
                                                                <td>
                                                                    {{ jobFormatter(job)[0] }}
                                                                </td>
                                                                <td>
                                                                    {{ jobFormatter(job)[1] }}
                                                                </td>
                                                            </tr>                                                            
                                                        </table>                                                        
                                                    </span>

                                                </div> -->
                                                
                                            </div>           
                                        </div>            
                                        <div class="row mb-3">                
                                            <div class="col col-lg-12 col-md-12 col-sm-12">                    
                                                <div class="editable"></div>
                                            </div>            
                                        </div>            
                                        
                                        
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row border border-1 rounded p-1">
                                        <div class="col-md-4">
                                            <div class="form-group">                         
                                                <label for="examName">Exam Name</label>                         
                                                <input type="text" name="examName" class="form-control form-control-sm" v-model="examName" id="examName"  placeholder="Exam name" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="examScore">Score</label>
                                                <input type="number" name="examScore" class="form-control form-control-sm" disabled :value="examScore()" id="examScore"  placeholder="Score" required="">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="passingScore">Passing Score</label>
                                                <input type="number" name="passingScore" class="form-control form-control-sm" v-model="examPassingScore" id="passingScore"  placeholder="Passing score" required="">
                                            </div>
                                        </div>                          
                                    </div>
                                    <div class="row  border border-1 rounded p-1">
                                        <h5>Add Question</h5>
                                        
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-md-4">
                                                
                                                    <label for="Part">Part</label>
                                                    <input type="text" name="part" class="form-control form-control-sm" v-model=questionPart id="part" placeholder="Part name..." required="">                                
                                                    
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="examType">Type</label>
                                                    <select v-model="examType" class="form-select form-select-sm" aria-label="Default select example">                                                
                                                        <option value="1">Multiple Choice</option>
                                                        <option value="2">True or False</option>                                                
                                                        <option value="3">Essay</option>
                                                        <option value="4">Enumeration</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-4">

                                                    <label for="point">Question Point/s</label>
                                                    <input type="number" name="point" class="form-control form-control-sm" v-model="qTempPoint" id="point"  required="">                                

                                                </div>
                                            </div>
                                            
                                            
                                            <!-- {{ examType }} -->
                                            
                                            <label for="examType">Question:</label>
                                            <textarea name="part" class="form-control form-control-sm" id="question" v-model="qTemp" required="" rows="3">   </textarea>                             
                                            <div v-if="examType==1">
                                                <div class="form-group p-2">
                                                    
                                                    a)&nbsp;<input type="text" v-model="c1" class="form-check-label" placeholder="Choice #1" />&nbsp; <button @click="correctAnswer=c1" :class="(correctAnswer==c1)?'btn btn-primary':'btn btn-secondary'" class="mb-1 btn-sm rounded-pill"><i class="fs-5 bi bi-check-circle"></i></button>
                                                    <br>
                                                    b)&nbsp;<input type="text" v-model="c2" class="form-check-label" placeholder="Choice #2" />&nbsp; <button @click="correctAnswer=c2" :class="(correctAnswer==c2)?'btn btn-primary':'btn btn-secondary'" class="mb-1 btn-sm rounded-pill"><i class="fs-5 bi bi-check-circle"></i></button>
                                                    <br>
                                                    c)&nbsp;<input type="text" v-model="c3" class="form-check-label" placeholder="Choice #3" />&nbsp; <button @click="correctAnswer=c3" :class="(correctAnswer==c3)?'btn btn-primary':'btn btn-secondary'" class="mb-1 btn-sm rounded-pill"><i class="fs-5 bi bi-check-circle"></i></button>
                                                    <br>
                                                    d)&nbsp;<input type="text" v-model="c4" class="form-check-label" placeholder="Choice #4" />&nbsp; <button @click="correctAnswer=c4" :class="(correctAnswer==c4)?'btn btn-primary':'btn btn-secondary'" class="mb-1 btn-sm rounded-pill"><i class="fs-5 bi bi-check-circle"></i></button>
                                                    
                                                </div>
                                            </div>
                                            <div v-if="examType==2">
                                                <div class="form-group p-2">
                                                    
                                                    <button @click="correctAnswer='true'" :class="(correctAnswer=='true')?'btn btn-primary':'btn btn-secondary'" class="btn-sm rounded-pill">True</button>
                                                    &nbsp;
                                                    <button @click="correctAnswer='false'" :class="(correctAnswer=='false')?'btn btn-primary':'btn btn-secondary'" class="btn-sm rounded-pill">False</button>
                                                    
                                                </div>
                                            </div>
                                            <div v-if="examType==4">
                                                <div class="form-group p-2">
                                                    <span class="fs-6"> No. of items:</span> <input type="number" style="width: 60px" v-model="enumItems">
                                                    <div v-for="(enumItem,index) in enumItems" :key="index">
                                                        {{ index+1 }}. &nbsp; <input type="text" :id="'enumAnswer'+index" :ref="'enumAnswer'+index" v-model="enumAnswers[index]">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <button v-if="editingQuestion==false" type="button" @click="addQuestion" class="mt-3 btn-success btn-sm"><i class=" fs-5 bi bi-plus-circle-fill"></i>Add Question</button>
                                        <button v-else type="button" @click="saveQuestion" class="mt-3 btn-success btn-sm"><i class=" fs-5 bi bi-save-fill"></i>Confirm Changes</button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <p>List of Questions</p>
                            </div>
                            <!-- <div class="col-lg-6 col-md-6 col-sm-12">
                                <button type="button" class="btn btn-sm btn-primary" id="add_question" style="float:right;" @click="showAddQuestion" >
                                    <i class="fs-5 bi bi-plus-square"></i> Add
                                </button>
                            </div> -->
                        </div>
                        <ul class="nav nav-tabs">

                            <li class="nav-item" v-for="(part,index) in questionParts()" :key="index">
                                <a class="nav-link" :class="(selectedPartIndex==index)?'active':''" href="#" @click="changePart(part,index)" >{{ part }}</a>
                            </li>
                            
                        </ul>
                        <div class="row">
                            <div class="col col-lg-12 col-md-12 col-sm-12">
                                <div class="">
                                    <div id="list_question_tbl_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-6"></div>
                                            <div class="col-sm-12 col-md-6"></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <table class="table table-sm table-striped table-bordered dataTable no-footer" id="list_question_tbl" role="grid" aria-describedby="list_question_tbl_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th style="width:10%">Part</th>
                                                            <th style="width:55%">Question</th>
                                                            <th style="width:25%">Type</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <edit-exam-question-items
                                                             v-for="(questionItems,index) in questions" 
                                                            :key="index" 
                                                            :questionIndex="index" 
                                                            :question="questionItems"
                                                            :part="selectedPart"
                                                            @deleteQuestion="deleteQuestion($event)"
                                                            @editQuestion="editQuestion($event)"
                                                            ></edit-exam-question-items>
                                                        
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    
                    <div class="modal-footer">
                        <button type="button" v-if="processing==false" class="btn btn-secondary" data-bs-dismiss="modal" @click="$emit('getExams')"> <i class="fs-5 bi bi-x-circle"></i> Close</button>
                        <button type="button" v-if="processing==false&&justUpdated==false" class="btn btn-primary" @click="updateExam"> <i class="fs-5 bi bi-save"></i> Save changes</button>
                    </div>
                    
                </div>
            </div>
        </div>
</template>

<script >
import { defineComponent } from 'vue'
import Label from '../../../Jetstream/Label.vue';
import AddQuestionModal from './AddQuestionModal.vue';
import EditExamQuestionItems from './EditExamQuestionItems.vue';
import QuestionItems from './QuestionItems.vue';
import axiosRetry from 'axios-retry';

export default defineComponent({
    emits: ["getExams"],
  components: { AddQuestionModal, Label, QuestionItems, EditExamQuestionItems },
   
   props: {
       currentExam: Object,            
        examIndex: Number,
        vacancies: Array
   },
   created(){
       
    //    this.selectedJobs=this.currentExam.categories;
       this.examName=this.currentExam.name;
    //    this.examScore=this.currentExam.score;
       this.examPassingScore=this.currentExam.passing_score;
       
       this.currentExam.categories.forEach(job => {
           this.selectedJobs.push(job.job_id+','+job.vacancy_name)
       });

       this.currentExam.questions.forEach(qArray => {
           let choices=[];
           let answer="";
           let qTypeInt=0;
           let temp=[];


           if(qArray.type=='Multiple Choice'){
               //choices=qArray.choices.choice;
               //console.log(qArray.choices);
               qArray.choices.forEach(c => {
                   choices.push(c.choice);
               });
           }

           if(qArray.type!='Essay'){
               answer=qArray.answer.answer;
           }

           if(qArray.type=='Multiple Choice'){
               qTypeInt=1;
           }
           else if(qArray.type=='True or False'){
               qTypeInt=2;
           }
           else if(qArray.type=='Essay'){
               qTypeInt=3;
           }
           else if(qArray.type=='Enumeration'){
               qTypeInt=4;
           }



           /* *
			 * * question[0]=question name
			 * * question[1]=question type (string)
			 * * question[2]=choices(array) if any
			 * * question[3]=answer(if not an essay)
			 * * question[4]=question type (int)
			 * * question[5]=question part
			 */

            temp=[
                qArray.question,   //0
                qArray.type,        //1
                choices,             //2
                answer,              //3
                qTypeInt,            //4
                qArray.part,        //5
                qArray.points        //6
            ];

           this.questions.push(temp);
           //console.log(this.questions);
       });

   },
   mounted(){
       
   },
   data(){
       return {
           
           selectedJobs:[],
           examName:"",
           examPassingScore:0,
           examType: 1,
           
           qTemp:"",
           qTempPoint:0,
           correctAnswer:"NaN",
           c1:"Choice #1",c2:"Choice #2",c3:"Choice #3",c4:"Choice #4",
           enumItems: 0,
           enumAnswers:[],
           questionPart:"",
           editingQuestion:false,
           editingQuestionIndex:0,
           processing: false,
           questions:[],

           selectedPart:"",
           selectedPartIndex: 0,



           justUpdated: false
       }
   },
   methods:{
    examScore(){
        let total=0;
        this.questions.forEach(q => {
            total=total+q[6];
        });
        return total;
    },
    questionParts(){
        let temp=[];
        this.questions.forEach(q => {
            temp.push( q[5]);
        });

        let parts = temp.filter((v, i, a) => a.indexOf(v) === i);
        
        if(this.selectedPart==""){
            this.selectedPart=parts[0];
        }

        return parts;
    },
    changePart(part,index){
        
        this.selectedPartIndex=index;
        this.selectedPart=part;
        console.log(this.selectedPart);
    },
    toLowerCaseNoSpaces(str){
        let newStr=str.toLowerCase();
        newStr = newStr.replace(/\s/g, "");
        //console.log(newStr);
        return newStr;
    },


    
    showAddQuestion(){
        var x = this.$swal('Hello Vue world!!!');
        console.log(x);
    },
    addQuestion(){
        let choices=[];
        let answer="";
        let enumerationAnswers=[];
        let examType="";
        let qArr=[];

        if(this.inputChecks()==false){
            return 0;
        }


        if(this.examType==1){
            choices.push(this.c1);
            choices.push(this.c2);
            choices.push(this.c3);
            choices.push(this.c4);

            answer=this.correctAnswer;

            examType="Multiple Choice";
        }else if(this.examType==2){
            choices.push('True');
            choices.push('False');

            answer=this.correctAnswer;

            examType="True or False";
        }else if(this.examType==4){
            for(let i=0;i<this.enumItems;i++){
                enumerationAnswers.push(document.getElementById('enumAnswer'+i).value);
                //console.log(document.getElementById('enumAnswer'+i).val);
            }
            answer=enumerationAnswers.toString();

            examType="Enumeration";
        }else if(this.examType==3){
            examType="Essay";
        }   
        
        
        
        qArr=[this.qTemp,examType,choices,answer,this.examType,this.questionPart,this.qTempPoint];
        this.questions.push(qArr);

        // this.questions.forEach(element => {
        //     console.log(element)    ;
        // });

        this.$toast.success('Question added to exam',{
                position: 'top-right'
            }
        );
        this.qTemp="";
        this.c1="Choice #1";
        this.c2="Choice #2";
        this.c3="Choice #3";
        this.c4="Choice #4";
        this.qTempPoint=0;
        this.enumItems=0;
        this.correctAnswer=0;
    },
    saveQuestion(){
        let choices=[];
        let answer="";
        let enumerationAnswers=[];
        let examType="";
        let qArr=[];

        if(this.inputChecks()==false){
            return 0;
        }

        if(this.examType==1){
            choices.push(this.c1);
            choices.push(this.c2);
            choices.push(this.c3);
            choices.push(this.c4);

            answer=this.correctAnswer;

            examType="Multiple Choice";
        }else if(this.examType==2){
            choices.push('True');
            choices.push('False');

            answer=this.correctAnswer;

            examType="True or False";
        }else if(this.examType==4){
            for(let i=0;i<this.enumItems;i++){
                enumerationAnswers.push(document.getElementById('enumAnswer'+i).value);
                //console.log(document.getElementById('enumAnswer'+i).val);
            }
            answer=enumerationAnswers.toString();

            examType="Enumeration";
        }else if(this.examType==3){
            examType="Essay";
        }   
        
        
        
        qArr=[this.qTemp,examType,choices,answer,this.examType,this.questionPart,this.qTempPoint];
        this.questions.splice(this.editingQuestionIndex,1, qArr);

       
        this.editingQuestion=false;
        this.editingQuestionIndex=-1;
        this.$toast.success('Question changes saved',{
                position: 'top-right'
            }
        );
        this.qTemp="";
        this.c1="Choice #1";
        this.c2="Choice #2";
        this.c3="Choice #3";
        this.c4="Choice #4";
        this.enumItems=0;
        this.qTempPoint=0;
        this.correctAnswer=0;
        
    },
    deleteQuestion(index){
        //console.log(index);
        this.questions.splice(index,1);
    },
    editQuestion(question){
        this.examType=question.type;


        this.editingQuestion=true;
        this.editingQuestionIndex=question.index;

        this.qTemp=question.question;
        this.questionPart=question.part;
        this.qTempPoint=question.points;
        

        if(question.type==1||question.type==2){
            this.correctAnswer=question.answer;
        }

        if(question.type==1){
            this.c1=question.choices[0];
            this.c2=question.choices[1];
            this.c3=question.choices[2];
            this.c4=question.choices[3];
        }

        

        if(question.type==4){
            let enumAnswers=question.answer.split(',');
            this.enumItems=enumAnswers.length;
            for(let i=0;i<this.enumItems;i++){
                //console.log(enumAnswers[i]);
                // document.getElementById('enumAnswer'+i).value=enumAnswers[i];
                // this.$refs['enumAnswer'+i].value=enumAnswers[i];
                this.enumAnswers[i]=enumAnswers[i];
            }
            //console.log(this.enumAnswers);
        }
    },
    inputChecks(){
        let isGood=true;

        if(this.qTempPoint<1){
            this.$toast.show("'Input proper question point!", {
                type: "error",
                // all of other options may go here
            });
            isGood=false;
        }

        if(this.questionPart==""){
            this.$toast.show("'Part' is empty!", {
                type: "error",
                // all of other options may go here
            });
            isGood=false;
        }

        if(this.qTemp==""){
            this.$toast.show("Question is blank!", {
                type: "error",
                // all of other options may go here
            });
            isGood=false;
        }


        if(this.examType==1||this.examType==2){
            if(this.correctAnswer==""){
                this.$toast.show("Choose correct answer!", {
                    type: "error",
                    // all of other options may go here
                });
                isGood=false;
            }
        }

        if(this.examType==1){
            if(this.c1==""){
                this.$toast.show("Choice 'a)' is empty!", {
                    type: "error",
                    // all of other options may go here
                });
                isGood=false;
            }
            if(this.c2==""){
                this.$toast.show("Choice 'b)' is empty!", {
                    type: "error",
                    // all of other options may go here
                });
                isGood=false;
            }
            if(this.c3==""){
                this.$toast.show("Choice 'c)' is empty!", {
                    type: "error",
                    // all of other options may go here
                });
                isGood=false;
            }
            if(this.c4==""){
                this.$toast.show("Choice 'd)' is empty!", {
                    type: "error",
                    // all of other options may go here
                });
                isGood=false;
            }
        }
        

        return isGood;
    },
    updateExam(){
        if(this.checkBeforeSave()==false){
            return 0;
        }

        this.$toast.success('Updating exam...',{
                position: 'top-right'
            }
        );
        this.processing=true;
        let choices=[
            this.c1,
            this.c2,
            this.c3,
            this.c4
        ];
        axiosRetry(axios, { retries: 3 });
        axios.post(route('admin.update_exam'),{
            exam_id:this.currentExam.id,
            name: this.examName,
            score: this.examScore(),
            passing_score: this.examPassingScore,
            jobs:this.selectedJobs,
            questions: this.questions,            
            //choices:choices
        })
        .then(response => {
            this.$toast.success('Updates saved to database',{
                position: 'top-right'
            });
            this.processing=false;
            this.justUpdated=true;
        })
        .catch(error=>{
            if(error.response.status=='500'){
                console.log(error);
            }else{
                alert(error);
            }
        });
    },
    jobFormatter(str){
        let job=str.split(',');
        return job;
    },
    checkBeforeSave(){
        let isGood =true;
        if(this.selectedJobs.length<1){
            this.$toast.show("Select at least 1 vacancy!", {
                type: "error",
                // all of other options may go here
            });
            isGood=false;
        }
        if(this.examName==""){
            this.$toast.show("Exam name is blank!", {
                type: "error",
                // all of other options may go here
            });
            isGood=false;
        }
        
        if(this.examPassingScore==0){
            this.$toast.show("Input valid passing score!", {
                type: "error",
                // all of other options may go here
            });
            isGood=false;
        }

        return isGood;
    }
    
   },
   watch:{
    //    examType:function(val,oldVal){
    //        if(oldVal){
    //         this.correctAnswer="";
    //         this.enumItems=0;
    //         this.qTemp="";
    //        }
    //    }
   },
   
})
</script>
