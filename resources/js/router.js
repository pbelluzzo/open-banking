import Vue from "vue";
import VueRouter from "vue-router";
import ExampleComponent from "./components/ExampleComponent";
import ClientsCreate from "./views/ClientsCreate";
import ClientsShow from "./views/ClientsShow";
import ClientsEdit from "./views/ClientsEdit";
import ClientsIndex from "./views/ClientsIndex";

Vue.use(VueRouter);

export default new VueRouter({
    mode: 'history',
    routes: [
        { path: '/', component: ExampleComponent},
        { path: '/clients', component: ClientsIndex},
        { path: '/clients/create', component: ClientsCreate},
        { path: '/clients/:id', component: ClientsShow},
        { path: '/clients/:id/edit', component: ClientsEdit},
    ]
});