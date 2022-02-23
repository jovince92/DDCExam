<template>
    <layout>
        <div class="offcanvas offcanvas-start w-25" tabindex="-1" id="offcanvas" data-bs-keyboard="false" data-bs-backdrop="false">
            <div class="offcanvas-header">
                <h6 class="offcanvas-title d-none d-sm-block" id="offcanvas">Menu</h6>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body px-0">
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start" id="menu">            
                    <li class="w-100">
                        <Link :href="route('admin.admin')" class=" nav-link text-truncate" :class="(route().current('admin.admin'))?'bg-primary text-white':''">
                            <i class="fs-5 bi-speedometer2"></i><span class="ms-1 d-none d-sm-inline">Dashboard</span> 
                        </Link>
                    </li>
                    <li class="w-100">
                        <Link :href="route('admin.exams')" class=" nav-link text-truncate" :class="(route().current('admin.exams'))?'bg-primary text-white':''">
                            <i class="fs-5 bi-table"></i><span class="ms-1 d-none d-sm-inline">Exams</span>
                        </Link>
                    </li>
                    <li class="w-100">
                        <Link :href="route('admin.applicants')" class=" nav-link text-truncate" :class="(route().current('admin.applicants'))?'bg-primary text-white':''">
                            <i class="fs-5 bi-people"></i><span class="ms-1 d-none d-sm-inline">Applicants</span>
                        </Link>
                    </li>
                    <!-- <li class="dropdown">
                        <a href="#" class="nav-link dropdown-toggle  text-truncate" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="ms-1 d-none d-sm-inline">Applicants</span>
                        </a>
                        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdown">
                            <li><a class="dropdown-item" href="#">New project...</a></li>
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><a class="dropdown-item" href="#">Profile</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </li> -->
                    <li class="w-100">
                        <Link :href="route('admin.results')" class=" nav-link text-truncate" :class="(route().current('admin.results'))?'bg-primary text-white':''">
                            <i class="fs-5 bi-ui-checks-grid"></i><span class="ms-1 d-none d-sm-inline">Results</span>
                        </Link>
                    </li>
                </ul>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col min-vh-100 p-1">
                    <!-- toggler -->
                    <button class="btn float-start" data-bs-toggle="offcanvas" data-bs-target="#offcanvas" role="button" >
                        <i class="bi bi-arrow-right-square-fill fs-3" data-bs-toggle="offcanvas" data-bs-target="#offcanvas"></i>
                    </button>                    
                    <div class="row">
                        <slot></slot>
                    </div>       
                </div>              
                
            </div>
            
        </div>

    </layout>
    
</template>


<script>
    import { defineComponent } from 'vue'
    import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import Layout from './Layout.vue';
    




    export default defineComponent({
        components: {
            Head,    
            JetValidationErrors,
            Link,
            Layout,
            
            
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