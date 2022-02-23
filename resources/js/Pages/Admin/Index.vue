<template>
    <Head title="DashBoard" />
    

    <sidebar>
        <dashboard-cards></dashboard-cards>

    </sidebar>
    	
    
  
   
</template>

<script>
    import { defineComponent } from 'vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Sidebar from './Layouts/Sidebar.vue';
import DashboardCards from './IndexComponents/DashboardCards.vue';
    




    export default defineComponent({
        components: {
            Head,    
            JetValidationErrors,
            Link,
            Sidebar,
                DashboardCards,
            
            
        },

        props: {
            

            },

        data() {
            return {
            
            }
        },

        methods: {
            
        }
    })
</script>

<style scoped>
@import "/public/custom/custom.css";    
</style>


