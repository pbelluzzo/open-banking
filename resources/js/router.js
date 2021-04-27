import Vue from "vue";
import VueRouter from "vue-router";
import ExampleComponent from "./components/ExampleComponent";
import ClientsCreate from "./views/ClientsCreate";

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: ExampleComponent},
        { path: '/clients/create', component: ClientsCreate},
    ]
});