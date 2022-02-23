<template>
    <tr v-if="part==question[5]">
        <td>
            {{ question[5] }}
        </td>
        <td>
            {{ question[0] }}
        </td>
        <td>
            {{ question[1] }}
        </td>
        <td>
            <a href="#"  @click="editQuestion(questionIndex)"><i class="fs-5 bi bi-pencil-square text-success"></i></a>
            <a href="#"  @click="deleteQuestion(questionIndex)"><i class="fs-5 bi bi-trash text-danger"></i></a>
        </td>
                                                            
    </tr>
</template>

<script>
import { defineComponent } from 'vue'
export default defineComponent({
    components: { },

    props: {
        question:Array,
        questionIndex: Number,
        part: String
    },
    data(){
        return {
            
        }
    },
    methods:{
        deleteQuestion(index){
            this.$emit('deleteQuestion',index)
        },
        editQuestion(index){
            this.$emit('editQuestion',{
                question: this.question[0],
                part: this.question[5],
                type: this.question[4],
                choices: this.question[2],
                answer: this.question[3],
                points: this.question[6],
                index: index
            })
        }
    },
    watch:{
        
        
    },
    created(){
        
    }
})
</script>
