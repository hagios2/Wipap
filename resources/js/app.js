/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/* const vue_prime = require('./node_modules/primevue');

Vue.use(vue_prime); */

window.Vue = require('vue');
window.primevue = require('primevue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

/* import TabMenu from 'primevue/tabmenu';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import Sidebar from 'primevue/sidebar';
import Menubar from 'primevue/menubar';
import Button from 'primevue/button';  */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('tab-menu', require('./components/tab_menu.vue'));

Vue.component('Accordion', require('primevue/accordion'));

Vue.component('AccordionTab', require('primevue/accordiontab'));

Vue.component('Sidebar', require('primevue/sidebar'));

Vue.component('Menubar', require('primevue/menubar'));

Vue.component('Button', require('primevue/button')); 

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
