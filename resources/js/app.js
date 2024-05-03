import './bootstrap'
import './lang.js'
import { createApp } from 'vue/dist/vue.esm-bundler';
import '@fortawesome/fontawesome-free/css/all.css';
///// Admin /////////////
import users from './components/admin/User.vue';
import modal from './components/layout/modal.vue';

///// User //////////////
import profile from './components/user/Profile.vue';

window.vue_app = createApp({})
vue_app.component('users', users)
vue_app.component('modal', modal)
vue_app.component('profile', profile)
vue_app.mount('#app')
