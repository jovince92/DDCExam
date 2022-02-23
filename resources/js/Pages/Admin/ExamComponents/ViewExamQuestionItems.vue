<template>
    <div class="row">
        <div>
            <span class="fs-5">
                {{ num+1 }}.&nbsp; {{ question.question }}
            </span>

            <span v-if="question.type=='True or False'" class="fs-6 fst-italic text-primary">
                *{{ (question.answer.answer=='true')?'True':'False' }}*
            </span>
        </div>


    </div>
    <table v-if="question.type=='Multiple Choice'" style="width: 100%">
        <tr>
            <td style="width: 25%" v-for="(choice,choiceIndex) in question.choices" :key="choice.id">
                <span :class="(choice.choice==question.answer.answer)?'fw-bolder':''">
                    {{ multipleChoiceItem(choiceIndex+1) }})&nbsp;{{ choice.choice   }}
                </span>
                
                <span class="fs-6 fst-italic text-primary" v-if="choice.choice==question.answer.answer">
                    *Correct Answer*
                </span>
                
            </td>
        </tr>
    </table>
    <div v-else-if="question.type=='True or False'">
        
        <label class="btn rounded m-1" :class="question.answer.answer=='true'?'btn-primary':'btn-secondary'">True</label>
        <label class="btn rounded m-1" :class="question.answer.answer=='false'?'btn-primary':'btn-secondary'">False</label>
    </div>
    <ul v-else-if="question.type=='Enumeration'">
        <span class="fs-6 fst-italic text-primary" >
            *Answers:*
        </span>
        <li v-for="(item,index) in question.answer.answer.split(',')" :key="index">
            {{ item }}
        </li>
    </ul>
    <div v-else-if="question.type=='Essay'">
        <span class="fs-6 fst-italic text-primary" >
            *Essay format*
        </span>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'    
    import moment from 'moment'
    

    export default defineComponent({
        components: {
            
        },

        props: {
            part: String,
            question: Object,
            num: Number
        },

        data() {
            return {
                
            }
        },

        methods: {
            toProperDate(dt){
                let properDate=moment(dt).format('MMMM Do YYYY, h:mm:ss a');
                return properDate;
            },
            
            
            questionNum(num){
                
            },
            multipleChoiceItem(index){
                let letter="";
                switch(index) {
                    case 1:
                        letter="a";
                        break;

                    case 2:
                        letter="b";
                        break;

                    case 3:
                        letter="c";
                        break;

                    default:
                        letter="d";
                    
                }
                return letter;
            },
            answerCheck(choice){
                let correct = false;
                if(choice==this.question.answer.answer){
                    correct=true;
                }
                return correct;
            }
            
            
        },
        created(){
            
        }
    })
</script>