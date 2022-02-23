<template>
  <Head title="Register" />

  <div class="mb-5"></div>
  <div class="wrapper p-2 m-auto">
    
    <div class="text-center mt-2 name"> DDC Group </div>
    <div class="text-center"> Application Form </div>
    <jet-validation-errors class="mb-4" />

    
    <form class="p-3 mt-3" @submit.prevent="submit">
      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" :class="'w-'+pBar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" >
          <span v-if="regPart==4">
            <span v-if="justRegistered==false">
              Processing. Please wait....
            </span>
            <span v-else>
              Registration Complete. Return to Log in Page
            </span>
          </span>
        </div>
      </div>
      
      <div v-if="regPart==1" class="container">
        <h5>
          Applicant Information
        </h5>
        <hr class="text-dark mb-2">
        <div class="row">
          <div class="col-md-4 px-1">
            <label for="firstname" class="px-1">First Name:</label>
            <div class="form-field d-flex align-items-center">
              <input type="text" name="firstname" id="firstname" placeholder="First Name" v-model="form.nameFirst" required autofocus > 
            </div>

          </div>
          <div class="col-md-4 px-1">
            <label for="middlename" class="px-1">Middle Name:</label>
            <div class="form-field d-flex align-items-center">
              <input type="text" name="middlename" id="middlename" placeholder="Middle Name" v-model="form.nameMiddle" required autofocus > 
            </div>
          </div>
          <div class="col-md-4 px-1">
            <label for="lastname" class="px-1">Last Name:</label>
            <div class="form-field d-flex align-items-center">
              <input type="text" name="lastname" id="lastname" placeholder="Last Name" v-model="form.nameLast" required autofocus > 
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 px-1">
            <label for="birthday" class="px-1">DOB:</label> 
            <div class="form-field d-flex align-items-center">
              <input type="date" name="birthday" id="birthday" placeholder="Birthday" v-model="form.birthday" required autofocus > 
            </div>
          </div>

          <div class="col-md-4 px-1">
            <label for="civil_status" class="px-1">Civil Status:</label> 
            <div class="form-field d-flex align-items-center">
              <input type="input" name="civil_status" id="civil_status" placeholder="Civil Status" v-model="form.civilStatus" required autofocus > 
            </div>
          </div>

          <div class="col-md-4 px-1">
            <label for="gender" class="px-1">Gender:</label> 
            <select v-model="form.gender" class="form-select form-field d-flex align-items-center" >
              <option selected disabled value="">Choose Gender..</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4">
            <label for="highest_education_attainment" class="px-1">Highest Educational Attainment:</label> 
            <select v-model="form.highest_education_attainment" id="highest_education_attainment" class="form-select form-field d-flex align-items-center" >
              <option selected disabled value="">Select Education..</option>
              <option value="highschool">High School</option>
              <option value="college">College</option>
            </select>
          </div>
          <div class="col-md-4"></div>
          <div class="col-md-4"></div>
        </div>
      </div>

      <!-- /************************************************************************************** */ -->
      <div v-else-if="regPart==2" class="container">
        <h5>
          Applicant Contact details
        </h5>
        <hr class="text-dark mb-2">
        <div class="row">
          <div class="col-md-10 px-1">
            <label for="address" class="px-1">Address:</label> 
            <div class="form-field d-flex align-items-center">
              <input type="text" name="address" id="address" placeholder="House No., Street name, Barangay/Subdivision/Village" v-model="form.address" required autofocus > 
            </div>
          </div>
          <div class="col-md-2 px-1">
            <label for="zipcode" class="px-1">ZIP CODE:</label> 
            <div class="form-field d-flex align-items-center">
              <input type="text" name="zipcode" id="zipcode" placeholder="ZIP CODE" v-model="form.zipcode" required autofocus > 
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4 px-1" v-if="regions">
            <label for="province" class="px-1">Region:</label>
            <select v-model="region" id="region" class="form-select form-field d-flex align-items-center" >
              <option v-for="(region_,index) in regions" :key="index" :value="region_.regCode" >
                {{ region_.regDesc }}
              </option>
            </select>
          </div>
          <div class="col-md-4 px-1">
            <label for="province" class="px-1">Province:</label>
            <select v-if="loadingProvs==false" v-model="province" id="province" class="form-select form-field d-flex align-items-center" >
              <option v-for="(province_,index) in provinces" :key="index" :value="province_.provCode" >
                {{ province_.provDesc }}
              </option>
            </select>
            <select v-else id="province" class="form-select form-field d-flex align-items-center" >
              <option  >
                Loading...
              </option>
            </select>
            
          </div>
          <div class="col-md-4 px-1">
            <label for="city" class="px-1">City/Town:</label>
            <select v-if="loadingCities==false" v-model="city" id="city" class="form-select form-field d-flex align-items-center" >
              <option v-for="(city_,index) in cities" :key="index" :value="city_.citymunCode" >
                {{ city_.citymunDesc }}
              </option>
            </select>

            <select v-else id="city" class="form-select form-field d-flex align-items-center" >
              <option  >
                Loading...
              </option>
            </select>

          </div>
        </div>
        <div class="row">
          <div class="col-md-4 px-1">
            <label for="email" class="px-1">Email Address:</label>
            <div class="form-field d-flex align-items-center">
              <input type="email" name="email" id="email" placeholder="Email Address" v-model="form.email" required autofocus > 
            </div>
          </div>
          <div class="col-md-4 px-1">
            <label for="phone" class="px-1">Mobile Number:</label>
            <div class="form-field d-flex align-items-center">
              <input type="text" name="phone" id="phone" placeholder="Mobile #" v-model="form.phone" required autofocus pattern="[0-9]+"> 
            </div>
          </div>
          <div class="col-md-4 px-1"></div>

        </div>
      </div>

      <div v-else-if="regPart==3" class="container">
        <h5>
          Set Password
        </h5>
        <hr class="text-dark mb-2">
        <div class="row">
          <div class="col-md-6 p-1 d-flex flex-column bd-highlight mb-1 border-right rounded">
            <div class="row border-bottom" v-for="(info,index) in infoArray" :key="index">
              <div class="col-md-6 fs-6 fw-light">
                {{ info[0] }}
              </div>
              <div class="col-md-6 fs-6">
                {{ info[1] }}
              </div>
            </div>
          </div>
          
          <div class="col-md-6 p-1 border-left rounded">
            <div class="row">
              <div class="col-md-12 px-1 mx-auto">
                
                <label for="login_email" class="px-1">
                  Log in Email:
                
                  <span class="text-danger font-italic" style="font-size: 13px;">
                    {{ emailMsg }}
                  </span>
                </label> 
                <div class="form-field d-flex align-items-center">
                  <input type="text" name="login_email" id="login_email" v-model="form.email" disabled >
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12 px-1 mx-auto">
                <label for="password" class="px-1">Password:</label> 
                <div class="form-field d-flex align-items-center">
                  <input type="password" name="password" id="password" v-model="form.password" placeholder="Password..." > 
                </div>
              </div>
            </div>
            <div class="row"> 
              <div class="col-md-12 px-1 mx-auto">
                <label for="password_confirmation" class="px-1">Confirm Password:</label> 
                <div class="form-field d-flex align-items-center">
                  <input type="password" name="password_confirmation" id="password_confirmation" v-model="form.password_confirmation" placeholder="Confirm Password" > 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row mt-5">
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
          <div class="mr-5" v-if="justRegistered==true||processing==true">
            <button disabled class="btn btn-secondary m-3 py-1 px-3 rounded">
              <span class="text-dark">
                <i class="fs-5  bi bi-x-circle-fill"></i>
                Back
              </span>
            </button>

            <button disabled class="btn btn-success m-3 py-1 px-3 rounded">
              <span class="text-dark">
                <i class="fs-5  bi bi-check-circle-fill"></i>
                Done
              </span>
            </button>
          </div>
          <div class="mr-5" v-else>

            <button v-if="regPart==1"  disabled class="btn btn-secondary m-3 py-1 px-3 rounded">
              <span class="text-light">
                <i class="fs-5  bi bi-x-circle-fill"></i>
                Back
              </span>
            </button>

            <a v-else href="#" @click="prevStep()" class="btn btn-success m-3 py-1 px-3 rounded">
              <span class="text-light">
                <i class="fs-5  bi bi-backspace-fill"></i>
                Back
              </span>
            </a>

            <a v-if="regPart<3" href="#" @click="nextStep()" class="btn btn-success m-3 py-1 px-3 rounded">
              <span class="text-light">
                Next
                <i class="fs-5 bi bi-backspace-reverse-fill"></i>
              </span>
            </a>

            <a href="#" v-else @click="finalStep()"  :class="(emailExist==true)?'btn-secondary disabled':'btn-primary'" class="btn m-3 py-1 px-3 rounded">
              <span class="text-light">
                <i class="fs-5 bi bi-check-circle-fill"></i>
                Done
              </span>
            </a>

          </div>
          
        </div>
      </div>
    </form>
    <div class="text-center fs-6"> <Link :href="route('login')">Return to Login</Link>  </div>
  </div>
  
</template>

<script>
import { defineComponent } from 'vue'
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetCheckbox from "@/Jetstream/Checkbox.vue";
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import axiosRetry from 'axios-retry';


export default defineComponent({
  components: {
    Head,
    JetAuthenticationCard,
    JetAuthenticationCardLogo,
    JetButton,
    JetInput,
    JetCheckbox,
    JetLabel,
    JetValidationErrors,
    Link,
  },
  watch:{
    region(val){
      this.getProvinces(val);
    },
    province(val){
      this.getCities(val);
    },
  },
  mounted(){
    
  },
  data() {
    return {
      form: this.$inertia.form({
        nameFirst: '',
        nameLast: '',
        nameMiddle: '',
        birthday:'',
        civilStatus:'',
        gender:'',
        highest_education_attainment:'',

        address:'',        
        phone:'',
        email:'',
        

        password: '',
        password_confirmation: '',

        zipcode:'',

        terms: false,
      }),
      regPart: 1,
      regions:[],
      provinces:[],
      cities:[],
      city:1,
      province:1,
      region:1,

      pBar:0,
      
      justRegistered:false,
      processing: false,

      emailExist: true,
      emailMsg: '',

      infoArray:[],
      loadingProvs:false,
      loadingCities:false
      

    }
  },

  methods: {
    submit() {
      this.form.post(this.route('register'), {
        onFinish: () => this.form.reset('password', 'password_confirmation'),
      })
    },
    fullAddress(){
      let province="",city="";
      

      this.provinces.forEach(p => {
        if(p.provCode==this.province){
          province=p.provDesc;
        }
      });
      this.cities.forEach(c => {
        if(c.citymunCode==this.city){
          city=c.citymunDesc;
        }
      });

      return this.form.address+', '+city+', '+province+' '+this.form.zipcode;
    },
    registerApplicant(){
      this.processing=true;
      axiosRetry(axios, { retries: 3 });
      axios.post('/api/applicant/create',{
        fname: this.form.nameFirst,
        lname: this.form.nameLast,
        mname: this.form.nameMiddle,
        dob: this.form.birthday,
        civil_status: this.form.civilStatus,
        gender: this.form.gender,
        education: this.form.highest_education_attainment,

        address: this.form.address,
        region: this.region,
        province: this.province,
        city:this.city,
        zipcode: this.form.zipcode,
        email: this.form.email,
        phone: this.form.phone,
        password: this.form.password
      })
      .then(response => {
          console.log(response.data);
          this.justRegistered=true;
          this.processing=false;
          this.$swal('Registration complete! Return to Log in Page!');
      })
      .catch(error=>{
        if(error.response.status=='500'){
            console.log(error);
        }else{
            alert(error);
        }
      });
    },
    getRegions(){
      axiosRetry(axios, { retries: 3 });
      axios.get('/api/regions')
        .then(response => {
          this.regions=response.data;
          this.region=13;
          this.pBar=this.pBar+25;
        })
        .catch(error=>{
            if(error.response.status=='500'){
                console.log(error);
            }else{
                alert(error);
            }
        });
    },
    getProvinces(id){
      axiosRetry(axios, { retries: 3 });
      this.loadingCities=true;
      this.loadingProvs=true;
      axios.post('/api/provinces',{
          region_id:id
        })
        .then(response => {
          this.provinces=response.data;
          this.province=response.data[0].provCode;
          this.loadingCities=false;
          this.loadingProvs=false;
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
      axiosRetry(axios, { retries: 3 });
      this.loadingCities=true;
      axios.post('/api/cities',{
          province_id:id
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
    nextStep(){
      


      if(this.firstStepCheck()==false&&this.regPart==1){
        return 0;
      }

      if(this.regPart==2){
        this.emailCheck();
        if(this.secondStepCheck()==false){
          return 0;
        }
        this.infoArray=[];  
        this.infoArray.push(['Full Name:',this.form.nameFirst+' '+this.form.nameMiddle+' '+this.form.nameLast]);
        this.infoArray.push(['Address:',this.fullAddress()]);
        this.infoArray.push(['Mobile No.:',this.form.phone]);
        this.infoArray.push(['Email:',this.form.email]);
        this.infoArray.push(['Gender:',this.form.gender]);
        this.infoArray.push(['Civil Status:',this.form.civilStatus]);
        this.infoArray.push(['Highest Educational Attainment:',this.form.highest_education_attainment]);
        this.infoArray.push(['Date of Birth',this.form.birthday]);
      }
      
      

      this.regPart=this.regPart+1;
      this.pBar=this.pBar+25;

    },
    finalStep(){
      
      if(this.finalStepCheck()==false&&this.regPart==3){
        return 0;
      }
      this.regPart=this.regPart+1;
      this.pBar=this.pBar+25;

      this.registerApplicant();

    },
    prevStep(){
      this.regPart=this.regPart-1;
      this.pBar=this.pBar-25;
      
    },
    firstStepCheck(){
      let isOk = true;
      
      if(this.form.nameFirst.length==""){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Fill out First Name</i>`,{
            position: 'top-right'
          }
        );
        isOk=false;
      }

      if(this.form.nameLast==""){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Fill out Last Name</i>`,{
            position: 'top-right'
          }
        );
        isOk=false;
      }
      if(this.form.nameMiddle==""){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Fill out Middle Name</i>`,{
            position: 'top-right'
          }
        );
        isOk=false;
      }
      if(this.form.birthday==""){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Fill out DOB</i>`,{
            position: 'top-right'
          }
        );
        isOk=false;
      }
      if(this.form.civilStatus==""){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Fill out Civil Status</i>`,{
            position: 'top-right'
          }
        );
        isOk=false;
      }
      if(this.form.gender==""){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Choose Gender</i>`,{
            position: 'top-right'
          }
        );
        isOk=false;
      }
      if(this.form.highest_education_attainment==""){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Fill out First Education</i>`,{
            position: 'top-right'
          }
        );
        isOk=false;
      }

      return isOk;
    },
    async emailCheck(){
      this.emailExist= true;
      this.emailMsg='';
      axiosRetry(axios, { retries: 3 });
      await axios.post('/api/applicant/check',{
        email: this.form.email
      })
      .then(response => {
        this.emailExist=(response.data==1)?true:false;
        this.emailMsg=(response.data==1)?"*Email already exist. Go back to previous page*":"";
      })
      .catch(error=>{
        if(error.response.status=='500'){
            console.log(error);
        }else{
            alert(error);
        }
      });
      // console.log(exist);
      // return await exist;
    },
    secondStepCheck(){
      let isOk=true;
      let validRegex = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;;
      

      // if(await this.emailCheck()==1){
      //   await this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Email Address already exist</i>`,{
      //       position: 'top-right'
      //     }
      //   );
      //   console.log('email exist');
      //   return false;
      // }




      if(this.form.address==""){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Fill out Address</i>`,{
            position: 'top-right'
          }
        );
        isOk=false;
      }
      if(!this.form.email.match(validRegex)){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Invalid Email Address</i>`,{
            position: 'top-right'
          }
        );
        isOk=false;
      }
      if(this.form.phone==""){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Fill out Mobile Phone</i>`,{
            position: 'top-right'
          }
        );
        isOk=false;
      }
      if(this.form.zipcode==""){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Fill out ZIPCODE</i>`,{
            position: 'top-right'
          }
        );
        isOk=false;
      }

      return isOk;

    },
    finalStepCheck(){
      let isOk=true;

      if(this.form.password.length<8){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Passwords must be atleast 8 characters.</i>`,{
            position: 'top-right'
          }
        );
        return false;
      }

      if(this.form.password==""||this.form.password_confirmation==""){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Passwords don't match</i>`,{
            position: 'top-right'
          }
        );
        return false;
      }

      if(this.form.password!=this.form.password_confirmation){
        this.$toast.error(`<i class="bi bi-exclamation-triangle">&nbsp;Passwords don't match</i>`,{
            position: 'top-right'
          }
        );
        isOk=false;
      }
      return isOk;
    },
  },

  created(){
    this.getRegions();
  }
})
</script>

<style scoped>
   @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

 * {
     margin: 0;
     padding: 0;
     box-sizing: border-box;
     font-family: 'Poppins', sans-serif
 }

 body {
     background: #eaf3fa
 }

 .wrapper {
     max-width: 90%;
     min-height: 500px;
     ;
     background-color: #e7eaf2;
     border-radius: 15px;
     box-shadow: 13px 13px 20px #a5a8ab, -13px -13px 20px #fff
 }

 .logo {
     width: 80px;
     margin: auto
 }

 .logo img {
     width: 100%;
     height: 80px;
     object-fit: cover;
     border-radius: 50%;
     box-shadow: 0px 0px 3px #5f5f5f, 0px 0px 0px 5px #ecf0f3, 8px 8px 15px #a7aaa7, -8px -8px 15px #fff
 }

 .wrapper .name {
     font-weight: 600;
     font-size: 1.4rem;
     letter-spacing: 1.3px;
     padding-left: 10px;
     color: #555
 }

 .wrapper .form-field input {
     width: 100%;
     display: block;
     border: none;
     outline: none;
     background: none;
     font-size: 1rem;
     color: #666;
     /* padding: 10px 15px 10px 10px */
 }

 .wrapper .form-field {
     padding-left: 10px;
     margin-bottom: 20px;
     border-radius: 10px;
     box-shadow: inset 8px 8px 8px #cbced1, inset -8px -8px 8px #fff
 }

 .wrapper .form-field .fas {
     color: #555
 }

 .wrapper .btns {
     box-shadow: none;
     width: 100%;
     font-size: 1.3rem;
     background-color: #039BE5;
     color: #fff;
     border-radius: 25px;
     box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff;
     letter-spacing: 1.3px
 }

 .wrapper .btns:hover {
     background-color: #039BE5
 }

  .wrapper .btnss {
     box-shadow: none;
     width: 100%;
     font-size: 1.3rem;
     
     
     
     color: #fff;
     border-radius: 25px;
     box-shadow: 3px 3px 3px #b1b1b1, -3px -3px 3px #fff;
     
 }

 .wrapper .btnss:hover {
     background-color: #98cae4
 }

 .wrapper a {
     text-decoration: none;
     font-size: 0.8rem;
     color: #03A9F4
 }

 .wrapper a:hover {
     color: #039BE5
 }

 @media(max-width: 380px) {
     .wrapper {
         margin: 30px 20px;
         padding: 40px 15px 15px 15px
     }
 }



</style>