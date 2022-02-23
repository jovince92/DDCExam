<template>
    <div class="modal fade" data-bs-backdrop="static" :id="'applicantModal_'+aIndex" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 80%">
            <div class="modal-content" >
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ fname+' '+mname+' '+lname }}</h5>
                <button type="button" class="btn-close" @click="$emit('updated');" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <spinnder v-if="updating==true"></spinnder>

                
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
                            <input type="text" class="form-control" id="fname" v-model="fname">
                        </div>
                        <div class="col-md-4">
                            <label for="mname" class="form-label">Middle Name:</label>
                            <input type="text" class="form-control" id="mname" v-model="mname">
                        </div>
                        <div class="col-md-4">
                            <label for="lname" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lname" v-model="lname">
                        </div>
                    </div>
                    <div class="row mb-1 p-2">
                        <div class="col-md-4">
                            <label for="dob" class="form-label">DOB:</label>
                            <input type="date" class="form-control" id="dob" v-model="dob">
                        </div>
                        <div class="col-md-4">
                            <label for="gender" class="form-label">Gender:</label>
                            <select name="" id="gender" class="form-select" v-model="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="civil_status" class="form-label">Civil Status</label>
                            <input type="text" class="form-control" id="civil_status" v-model="civil_status">
                        </div>
                        
                    </div>
                    <div class="row mb-1 p-2">
                        <div class="col-md-4">
                            <label for="education" class="form-label" >Civil Status</label>
                            <select name="" id="education" class="form-select" v-model="education">
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
                            <input type="text" class="form-control" id="address" v-model="address">
                        </div>
                        <div class="col-md-2">
                            <label for="zipcode" class="form-label">ZIPCODE:</label>
                            <input type="text" class="form-control" id="zipcode" v-model="zipcode">
                        </div>
                    </div>
                    <div class="row mb-1 p-2">
                        <div class="col-md-4">
                            <label for="region" class="form-label" >Region</label>
                            <select v-if="regions" name="" id="region" class="form-select" v-model="region" @change="getProvinces($event)">
                                <option v-for="(region,index) in regions" :key="index" :value="region.regCode">
                                    {{ region.regDesc }}
                                </option>
                            </select>
                            <select v-else name="" id="region" class="form-select" disabled v-model="region" @change="getProvinces($event)">
                                <option value="">
                                    Loading...
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="province" class="form-label" >Province</label>
                            <select v-if="loadingProvs==false" name="" id="province" class="form-select" v-model="province" @change="getCities($event)">
                                <option v-for="(province,index) in provinces" :key="index" :value="province.provCode">
                                    {{ province.provDesc }}
                                </option>
                            </select>
                            <select v-else name="" id="province" class="form-select" disabled>
                                <option value="">
                                    Loading...
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label" >City</label>
                            <select v-if="loadingCities==false" name="" id="city" class="form-select" v-model="city">
                                <option v-for="(city,index) in cities" :key="index" :value="city.citymunCode">
                                    {{ city.citymunDesc }}
                                </option>
                            </select>
                            <select v-else name="" id="city" class="form-select" disabled >
                                <option value="">
                                    Loading...
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-1 p-2">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address:</label>
                            <input type="text" disabled class="form-control" id="email" v-model="email">
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Mobile Number:</label>
                            <input type="text" class="form-control" id="phone" v-model="phone">
                        </div>
                    </div>
                    
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" :disabled="updating" class="btn btn-sm btn-secondary" @click="$emit('updated');" data-bs-dismiss="modal">Close</button>
                <button type="button" :disabled="updating" class="btn btn-sm btn-primary" @click="update()">Save changes</button>
            </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import moment from 'moment';
    import Spinnder from '../Layouts/Spinnder.vue';
    import axiosRetry from 'axios-retry';

    export default defineComponent({
        emits: ['updated'],
        components: {
                Spinnder
            
        },

        props: {
            applicant: Object,
            aIndex: Number,
            locations: Object,
            
        },

        data() {
            return {
                page: 1,
                fname: this.applicant.applicant.first_name,
                mname: this.applicant.applicant.middle_name,
                lname: this.applicant.applicant.last_name,
                email: this.applicant.email,

                dob: this.applicant.applicant.birthday,
                gender: this.applicant.applicant.gender,
                civil_status: this.applicant.applicant.civil_status,
                education:this.applicant.applicant.highest_education_attainment,

                address:this.applicant.applicant.applicant_contact.address,
                zipcode:this.applicant.applicant.applicant_contact.zipcode,
                regionDesc:this.applicant.applicant.applicant_contact.region,
                provinceDesc:this.applicant.applicant.applicant_contact.province,
                cityDesc:this.applicant.applicant.applicant_contact.city,

                phone:this.applicant.applicant.applicant_contact.phone_number,


                region:0,
                province:0,
                city:0,

                regions:[],
                provinces:[],
                cities:[],

                updating:false,
                loadingProvs:false,
                loadingCities:false,


                locationsLoaded:this.gettingLocations
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
            
            getProvinces(id){
                this.loadingProvs=true;
                this.loadingCities=true;
                axiosRetry(axios, { retries: 3 });
                axios.post('/api/provinces',{
                    region_id:id.target.value
                })
                .then(response => {
                    this.provinces=response.data;
                    this.province=response.data[0].provCode;
                    this.loadingProvs=false;
                    axiosRetry(axios, { retries: 3 });
                    axios.post('/api/cities',{
                        province_id:response.data[0].provCode
                    })
                    .then(response_ => {
                        this.cities=response_.data;
                        this.city=response_.data[0].citymunCode;
                        this.loadingLocations=false;
                        this.loadingCities=false;
                    })
                    .catch(error=>{
                        if(error.response.status=='500'){
                            console.log(error);
                        }else{
                            if(error.response.status=='500'){
                                console.log(error);
                            }else{
                                alert(error);
                            }
                        }
                    });
                })
                .catch(error=>{
                    if(error.response.status=='500'){
                        console.log(error);
                    }else{
                        alert(error);
                    }
                });
            },
            getCities(id){
                this.loadingCities=true;
                axiosRetry(axios, { retries: 3 });
                axios.post('/api/cities',{
                    province_id:id.target.value
                })
                .then(response => {
                    this.cities=response.data;
                    this.city=response.data[0].citymunCode;
                    this.loadingCities=false;
                })
                .catch(error=>{
                    if(error.response.status=='500'){
                        console.log(error);
                    }else{
                        alert(error);
                    }
                });
            },
            update(){
                this.updating=true;
                this.$toast.info(`<i class="bi bi-save">&nbsp;Saving to Database</i>`,{
                        position: 'top-right'
                    }
                );
                axiosRetry(axios, { retries: 3 });
                axios.post('/admin/api/applicant/update',{

                    applicant_id: this.applicant.applicant.id,

                    last_name:this.lname,
                    first_name: this.fname,
                    middle_name: this.mname,
                    birthday:this.dob,
                    civil_status:this.civil_status,
                    gender: this.gender,
                    highest_education_attainment:this.education,

                    address:this.address,
                    region: this.region,
                    province: this.province,
                    city:this.city,
                    zipcode:this.zipcode,
                    phone_number:this.phone

                })
                .then(response => {
                    this.updating=false;
                    this.$toast.success(`<i class="bi bi-check-circle">&nbsp;Record Updated!</i>`,{
                        position: 'top-right'
                    });
                    
                })
                .catch(error=>{
                    if(error.response.status=='500'){
                        console.log(error);
                    }else{
                        alert(error);
                    }
                });
                
            },
            populateLocations(){
                let provs=[];
                let cits=[];

                if(this.locations.regions){
                    this.regions=this.locations.regions;

                    

                    this.locations.regions.forEach(region_ => {
                        if(region_.regDesc==this.regionDesc){
                            this.region=region_.regCode;
                        }
                    });
                    
                    this.locations.provinces.forEach(province => {
                        if(province.provDesc==this.provinceDesc){
                            this.province=province.provCode;
                        }

                        if(province.regCode==this.region){
                            provs.push(province);
                        }
                    });

                    this.locations.cities.forEach(city => {
                        if(city.citymunDesc==this.cityDesc){
                            this.city=city.citymunCode;
                        }

                        if(city.provCode==this.province){
                            cits.push(city);
                        }
                    });

                    this.provinces=provs;
                    this.cities=cits;
                }

                
            }
        },



        created(){
            
            this.populateLocations();
            
        },
        mounted(){

            

            
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