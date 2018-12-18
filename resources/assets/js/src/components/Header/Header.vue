<template>
    <header class="app-header navbar" >
        <button v-if="userRole.title === 'admin'" class="navbar-toggler mobile-sidebar-toggler d-lg-none" type="button" @click="mobileSidebarToggle">
            <span class="navbar-toggler-icon"></span>
        </button>
        <b-link class="navbar-brand" to="#">
        </b-link>
        <span style="color: #f9cc09;
    font-size: 22px;
"><b>EBPearls</b></span>
        <button v-if="userRole.title === 'admin'" class="navbar-toggler sidebar-toggler d-md-down-none" type="button" @click="sidebarToggle">
            <span class="navbar-toggler-icon"></span>
        </button>
        <b-navbar-nav class="ml-auto">
            <HeaderDropdown/>
        </b-navbar-nav>
    </header>
</template>
<style>
    .app-header.navbar .navbar-brand {
        display: inline-block;
        width: 64px;
        height: 55px;
        padding: 0.5rem 1rem;
        margin-right: 0;
        background-color: #fff;
        background-image: url(/static/img/logo.png);
        background-repeat: no-repeat;
        background-position: center center;
        background-size: 51px auto;
        border-bottom: 1px solid #a4b7c1;
    }
</style>
<script>
  import HeaderDropdown from './HeaderDropdown.vue'
  import {mapGetters} from 'vuex';

  export default {
    name: 'c-header',
    components: {
      HeaderDropdown
    },
    computed: {
      ...mapGetters({userRole: 'getRole'})
    },
    watch: {
      userRole(e) {
        if (e.title !== 'admin') {
          document.body.classList.toggle('sidebar-hidden')
        }
      }
    },
    methods: {
      sidebarToggle(e) {
        e.preventDefault()
        document.body.classList.toggle('sidebar-hidden')
      },
      sidebarMinimize(e) {
        e.preventDefault()
        document.body.classList.toggle('sidebar-minimized')
      },
      mobileSidebarToggle(e) {
        e.preventDefault()
        document.body.classList.toggle('sidebar-mobile-show')
      },
      asideToggle(e) {
        e.preventDefault()
        document.body.classList.toggle('aside-menu-hidden')
      }
    }
  }
</script>
