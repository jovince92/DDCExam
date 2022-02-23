<template>
    <double-check-modal
        :result="result"
        @getResults="$emit('getResults')"
        @updateStatus="statusChanged($event)"
        :loadingModal="loadingModal"
        ></double-check-modal>

        <view-applicant-modal
            :applicant="result.applicant"
            :aIndex="result.applicant.id"
        ></view-applicant-modal>
    <tr>
        <td>
            {{ result.applicant.first_name+' '+result.applicant.last_name }}
        </td>
        <td>
            {{ result.job_title }}
        </td>
        <td>
            {{ result.exam.name }}
        </td>
        <td @dblclick="editingScore=true">
            <span v-if="editingScore==false">
                {{ result.applicant_score+' out of '+result.exam.score +' (passing score: '+result.exam.passing_score+')' }}
            </span>
            <div v-else class="d-flex flex-row bd-highlight">
                <input type="number" class="form-control form-control-sm" v-model="score">
                <a href="#">
                    <i class="text-sm text-success bi bi-check-lg" @click="updateScore(result.id)"></i>
                </a>
                <a href="#">
                    <i class="text-sm text-danger bi bi-x-circle" @click="editingScore=false"></i>
                </a>
            </div>
            
        </td>
        <td @dblclick="editingStatus=true">
            <span v-if="editingStatus==false">
                <span v-if="result.status=='Needs manual check'" class="border border-dark px-2 badge rounded-pill bg-warning text-dark">
                    <i class="fs-6 bi bi-exclamation-diamond"></i>&nbsp;
                    {{ result.status }}
                </span>
                <span v-else class="border border-dark px-2 badge rounded-pill" :class="(result.status=='Failed')?'bg-danger':'bg-success'">
                    <i class="fs-6 bi" :class="(result.status=='Failed')?'bi-x-circle':'bi-check-circle'"></i>&nbsp;
                    {{ result.status }}
                </span>
            </span>

            <div v-else class="w-100 d-flex flex-row bd-highlight">
                <select class="form-select form-select-sm mr-1" v-model="status" >
                    <option value="Failed">Failed</option>
                    <option value="Passed">Passed</option>
                    <option value="Needs manual check">Needs manual check</option>
                </select>
                <a href="#">
                    <i class="text-sm text-success bi bi-check-lg" @click="updateStatus(result.id)"></i>
                </a>
                <a href="#">
                    <i class="text-sm text-danger bi bi-x-circle" @click="editingStatus=false"></i>
                </a>
                    
                
            </div>
            
        </td>
        <td>
            {{ toProperDate(result.created_at) }}
        </td>
        <td>
            <a href="#" title="Double Check" data-bs-toggle="modal" :data-bs-target="'#result_modal_'+result.id">
                <i class="fs-4 text-primary bi bi-clipboard-check"></i>
            </a>
            <a href="#" data-bs-toggle="modal" :data-bs-target="'#applicantModal_'+result.applicant.id">
                <i class="fs-4 text-success bi bi-eye"></i>
            </a>
        </td>
    </tr>
</template>

<script >
import { defineComponent } from 'vue';
import moment from 'moment'
import DoubleCheckModal from './DoubleCheckModal.vue';
import ViewApplicantModal from './ViewApplicantModal.vue';

export default defineComponent({
  components: { DoubleCheckModal, ViewApplicantModal },
    emits:['updateScore','updateStatus','getResults'],
    props:{
        result: Object,
        loadingModal: Boolean
    },
    methods: {
        toProperDate(dt){
            let properDate=moment(dt).format('MMMM Do YYYY, h:mm:ss a');
            return properDate;
        },
        updateScore(id){
            this.$emit('updateScore',{
                score_id:id,
                score:this.score
            });
            this.editingScore=false;
        },
        updateStatus(id){
            this.$emit('updateStatus',{
                score_id:id,
                status:this.status
            });
            this.editingStatus=false;
        },
        statusChanged(params){
            //console.log(params);
            this.$emit('updateStatus',{
                score_id:params.score_id,
                status:params.status
            });
            //this.editingStatus=false;
        }
    },
    data() {
        return {
            editingScore: false,
            editingStatus: false,
            status: this.result.status,
            score: this.result.applicant_score,
            
        }
    },
    // watch: {
    //     status:function(val,oldVal){
    //         this.editingStatus=false;
    //     }
    // }
})
</script>
