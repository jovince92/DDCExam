<template>
    <div class="modal fade" data-bs-backdrop="static" :id="'applicantModal_'+aIndex" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 80%">
            <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ fname+' '+mname+' '+lname }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" :class="(page==1)?'active':''" @click="page=1" href="#">Applicant Info</a>
                    </li>                    
                    <li class="nav-item">
                        <a class="nav-link" :class="(page==2)?'active':''" @click="page=2" href="#">Contact Details</a>
                    </li>
                </ul>
                <div v-if="page==1" class="container p-2">
                    <!-- <div class="row border-bottom border-dark">
                        <h6 class="fst-italic mb-2">
                                Applicant User Id:
                            <b>
                                {{ applicant.id }}
                            </b>
                        </h6>
                    </div> -->
                    <div class="row mb-1 p-2">
                        <div class="col-md-4">
                            <label for="fname" class="form-label">First Name:</label>
                            <input type="text" disabled class="form-control" id="fname" v-model="fname">
                        </div>
                        <div class="col-md-4">
                            <label for="mname" class="form-label">Middle Name:</label>
                            <input type="text" disabled class="form-control" id="mname" v-model="mname">
                        </div>
                        <div class="col-md-4">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" disabled class="form-control" id="lname" v-model="lname">
                        </div>
                    </div>
                    <div class="row mb-1 p-2">
                        <div class="col-md-4">
                            <label for="dob" class="form-label">DOB:</label>
                            <input type="date" disabled class="form-control" id="dob" v-model="dob">
                        </div>
                        <div class="col-md-4">
                            <label for="gender" class="form-label">Gender:</label>
                            <select name="" disabled id="gender" class="form-select" v-model="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="civil_status" class="form-label">Civil Status</label>
                            <input type="text" disabled class="form-control" id="civil_status" v-model="civil_status">
                        </div>
                        
                    </div>
                    <div class="row mb-1 p-2">
                        <div class="col-md-4">
                            <label for="education" class="form-label" >Civil Status</label>
                            <select name="" disabled id="education" class="form-select" v-model="education">
                                <option value="highschool">High School</option>
                                <option value="college">College</option>
                            </select>
                        </div>
                        <div class="col-md-4"></div>
                        <div class="col-md-4"></div>

                    </div>
                </div>
                <div v-else class="container p-2">
                    <div class="row mb-1 p-2">
                        <div class="col-md-10">
                            <label for="address" class="form-label">Address:</label>
                            <input type="text" disabled class="form-control" id="address" v-model="address">
                        </div>
                        <div class="col-md-2">
                            <label for="zipcode" class="form-label">ZIPCODE:</label>
                            <input type="text" disabled class="form-control" id="zipcode" v-model="zipcode">
                        </div>
                    </div>
                    <div class="row mb-1 p-2">
                        <div class="col-md-4">
                            <label for="region" class="form-label" >Region</label>
                            <input type="text" disabled class="form-control" id="region" v-model="region">
                        </div>
                        <div class="col-md-4">
                            <label for="province" class="form-label" >Province</label>
                            <input type="text" disabled class="form-control" id="province" v-model="province">
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label" >City</label>
                            <input type="text" disabled class="form-control" id="city" v-model="city">
                        </div>
                    </div>
                    <div class="row mb-1 p-2">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address:</label>
                            <input type="text" disabled class="form-control" id="email" v-model="email">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Mobile Number:</label>
                            <input type="text" disabled class="form-control" id="phone" v-model="phone">
                        </div>
                    </div>
                    
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import moment from 'moment';


    export default defineComponent({
        
        components: {
                
            
        },

        props: {
            applicant: Object,
            aIndex: Number
        },

        data() {
            return {
                page: 1,
                fname: this.applicant.first_name,
                mname: this.applicant.middle_name,
                lname: this.applicant.last_name,
                email: this.applicant.applicant_contact.email,

                dob: this.applicant.birthday,
                gender: this.applicant.gender,
                civil_status: this.applicant.civil_status,
                education:this.applicant.highest_education_attainment,

                address:this.applicant.applicant_contact.address,
                zipcode:this.applicant.applicant_contact.zipcode,
                region:this.applicant.applicant_contact.region,
                province:this.applicant.applicant_contact.province,
                city:this.applicant.applicant_contact.city,

                phone:this.applicant.applicant_contact.phone_number,


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
            },
            
            
        },



        created(){
            
        },
        watch:{
            // region(val){
            //     this.getProvinces(val);
            //     //console.log(val);
            // },
            // province(val){
            //     this.getCities(val);
            //     //console.log(val);
            // },
        }
    })
</script>