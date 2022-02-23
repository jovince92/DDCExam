<template>
    <applicant-modal 
        :applicant="applicant" 
        :locations="locations" 
        :aIndex="aIndex"
        @updated="$emit('updated')"></applicant-modal>
    <tr>
        <td>
            {{ applicant.applicant.first_name+' '+applicant.applicant.last_name }}
        </td>
        <td>
            {{ toProperDOB(applicant.applicant.birthday) }}
        </td>
        <td>
            {{ applicant.applicant.applicant_contact.phone_number }}
        </td>
        <td>
            {{ applicant.email }}
        </td>
        <td>
            {{ toProperDate(applicant.created_at) }}
        </td>
        <td>
            <a href="#" data-bs-toggle="modal" :data-bs-target="'#applicantModal_'+aIndex">
                <i class="fs-5 bi bi-pencil-square text-primary"></i>
            </a>
        </td>
    </tr>
</template>

<script>
    import { defineComponent } from 'vue';
    import moment from 'moment';
    import ApplicantModal from './ApplicantModal.vue';

    export default defineComponent({
        emits: ['updated'],
        components: {
                ApplicantModal
            
        },

        props: {
            applicant: Object,
            aIndex: Number,
            locations: Object,
            
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
            toProperDOB(dt){
                let properDate=moment(dt).format('MMMM Do YYYY');
                return properDate;
            }
        },
        created(){
            
        }
    })
</script>