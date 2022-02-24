<template>
  <Head title="Log in" />

  <div class="wrapper">
    <div class="logo"> <img :src="'/storage/logo/logo.png'" alt=""> </div>
    <div class="text-center mt-4 name"> DDC Group </div>
    <div class="text-center"> HR Employment Screening Log In </div>
    <jet-validation-errors class="mb-4" />

    <div v-if="status" class="text-danger">
        {{ status }}
    </div>
    <form class="p-3 mt-3" @submit.prevent="submit">        
        <div class="form-field d-flex align-items-center"> 
          <i class="fs-5 bi-person"></i> 
          <input type="text" name="userName" id="email" placeholder="Email" v-model="form.email" required autofocus > 
        </div>
        <div class="form-field d-flex align-items-center"> 
          <i class="fs-5 bi-key"></i> 
          <input type="password" name="password" id="password" placeholder="Password" v-model="form.password" required autocomplete="current-password"> 
        </div> 
        <button class="btns btn mt-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> <i class="bi bi-briefcase-fill"></i> Login</button>
        <Link class="btnss btn btn-secondary mt-3" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" :href="route('register')"> 
          <i class="bi bi-briefcase-fill"></i>
          <span>
            Apply Now 
          </span> 
        </Link>
    </form>
    <div class="text-center fs-6"> <a href="#">Forgot password?</a>  </div>
  </div>
  
</template>

<script>
import { defineComponent } from 'vue'
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue'
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetCheckbox from '@/Jetstream/Checkbox.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
import { Head, Link } from '@inertiajs/inertia-vue3';

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

  props: {
    canResetPassword: Boolean,
    status: String
  },

  data() {
    return {
      form: this.$inertia.form({
        email: '',
        password: '',
        remember: false
      })
    }
  },
  created(){
    
  },

  methods: {
    submit() {
      this.form
          .transform(data => ({
            ... data,
            remember: this.form.remember ? 'on' : ''
          }))
          .post(this.route('login'), {
            onFinish: () => this.form.reset('password'),
          })
    }
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
     background: #ecf0f3
 }

 .wrapper {
     max-width: 350px;
     min-height: 500px;
     margin: 80px auto;
     padding: 40px 30px 30px 30px;
     background-color: #ecf0f3;
     border-radius: 15px;
     box-shadow: 13px 13px 20px #cbced1, -13px -13px 20px #fff
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
     padding: 10px 15px 10px 10px
 }

 .wrapper .form-field {
     padding-left: 10px;
     margin-bottom: 20px;
     border-radius: 20px;
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
