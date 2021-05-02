import Vue from "vue";
import router from "./router";
import App from "./components/App";
import VueTheMask from 'vue-the-mask';

require('./bootstrap');

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router
});
