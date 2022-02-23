<template>
    
    <view-exam-modal :currentExam="propExam" :examIndex="examIndex"></view-exam-modal>
    <edit-exam-modal :vacancies="vacancies" :currentExam="propExam" :examIndex="examIndex" @getExams="$emit('getExams')"></edit-exam-modal>
    <tr>                                
        <td> {{ propExam.id }} </td>
        <td>{{ propExam.name }}</td>
        <td>
            <ul>
                <li v-for="(category,index) in propExam.categories" :key="index">
                    {{ category.vacancy_name }}
                </li>
            </ul>

        </td>
        <td>
            {{ propExam.score }} max score ({{ propExam.passing_score }} passing score)
        </td>
        <td> {{ toProperDate(propExam.created_at) }} </td>
        <td>
            <div class="d-flex flex-row bd-highlight">
                <a href="#"  data-bs-toggle="modal" :data-bs-target="'#viewExamModal'+examIndex" ><i class="fs-4 bi bi-eye text-success"></i></a>
                <a href="#"   data-bs-toggle="modal" :data-bs-target="'#editExamModal'+examIndex"><i class="fs-4 bi bi-pencil-square text-primary"></i></a>
                <a href="#" @click="deleteExam(propExam.id,propExam.name)"><i class="fs-4 bi bi-trash text-danger"></i></a>
            </div>
        </td>
    </tr>	

</template>




<script>
    import { defineComponent } from 'vue'    
    import moment from 'moment'
    import ViewExamModal from './ViewExamModal.vue';
import EditExamModal from './EditExamModal.vue';

    export default defineComponent({
        emits: ["deleteExam",'getExams'],
        components: {
            ViewExamModal,
                EditExamModal
        },

        props: {
            exam: Object,
            examIndex: Number,
            vacancies: Array

        },

        data() {
            return {
                propExam:this.exam
            }
        },

        methods: {
            toProperDate(dt){
                let properDate=moment(dt).format('MMMM Do YYYY, h:mm:ss a');
                return properDate;
            },
            deleteExam(id,name){
                //alert(id+' '+name);


                this.$swal({
                    title: 'Are you sure?',
                    text: "Exam will be deleted!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.$emit('deleteExam',{id:id});        
                    }
                })

            


                
            }
            
            
        },
        created(){
            
        }
    })
</script>


<style scoped>
    
    @import "/public/custom/custom.css";

</style>