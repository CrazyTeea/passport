import Vue from 'vue';
import VueRouter from 'vue-router';
import orgList from "./components/pages/admin/orgList";
import userIndex from "./components/pages/passport/userIndex";
import orgInfo from "./components/pages/passport/orgInfo";
import covid from "./components/pages/passport/covid";
import areaInfo from "./components/pages/passport/areaInfo";
import livingInfo from "./components/pages/passport/livingInfo";
import livingInfoInv from "./components/pages/passport/livingInfoInv";
import object from "./components/pages/object/object";
import objectArea from "./components/pages/object/objectArea";
import objectMoney from "./components/pages/object/objectMoney";
import objectTariff from "./components/pages/object/objectTariff";
import objectEnd from "./components/pages/object/objectEnd";
import addContact from "./components/pages/passport/addContact";


Vue.use(VueRouter);

const routes = [

    {
        name: 'orgList',
        path: '/admin/statistic',
        component: orgList// () => import(/* webpackChunkName: "orgList" */'./components/pages/admin/orgList')// orgList
    },
    {
        name: 'userIndex',
        path: '/main',
        component: userIndex, //() => import(/* webpackChunkName: "userIndex" */'./components/pages/passport/userIndex'), // userIndex,
        alias: '/admin/data/:id'
    },
    {
        name: 'orgInfo',
        path: '/org-info',
        component: orgInfo,//() => import(/* webpackChunkName: "orgInfo" */'./components/pages/passport/orgInfo'), // orgInfo,
        alias: '/admin/org-info/:id'
    },
    {
        name: 'covid',
        path: '/org-covid',
        component: covid,//() => import(/* webpackChunkName: "covid" */'./components/pages/passport/covid'), // orgInfo,
        alias: '/admin/org-covid/:id'
    },
    {
        name: 'areaInfo',
        path: '/area-info',
        component: areaInfo,//() => import(/* webpackChunkName: "areaInfo" */'./components/pages/passport/areaInfo'), //areaInfo,
        alias: '/admin/area-info/:id'
    },
    {
        name: 'livingInfo',
        path: '/living-info',
        component: livingInfo,//() => import(/* webpackChunkName: "livingInfoInv" */'./components/pages/passport/livingInfo'), // livingInfo,
        alias: '/admin/living-info/:id'
    },
    {
        name: 'livingInfoInv',
        path: '/living-info-inv',
        component: livingInfoInv,//() => import(/* webpackChunkName: "livingInfoInv" */'./components/pages/passport/livingInfoInv'), //livingInfoInv,
        alias: '/admin/living-info-inv/:id'
    },
    {
        path: '/objects-info/:id_object',
        component: object,//() => import(/* webpackChunkName: "object" */'./components/pages/object/object'), //object,
        name: 'object',
        props: true,
        alias: '/admin/objects-info/:id/:id_object'

    },
    {
        name: 'objectArea',
        path: '/objects-area/:id_object',
        component: objectArea,//() => import(/* webpackChunkName: "objectArea" */'./components/pages/object/objectArea'), //objectArea,
        alias: '/admin/objects-area/:id/:id_object'
    },
    {
        name: 'objectMoney',
        path: '/objects-money/:id_object',
        component: objectMoney,//() => import(/* webpackChunkName: "objectMoney" */'./components/pages/object/objectMoney'),//objectMoney,
        alias: '/admin/objects-money/:id/:id_object'
    },
    {
        name: 'objectTariff',
        path: '/objects-tariff/:id_object',
        component: objectTariff,//() => import(/* webpackChunkName: "objectTariff" */'./components/pages/object/objectTariff'),//objectTariff,
        alias: '/admin/objects-tariff/:id/:id_object'
    },
    {
        name: 'objectEnd',
        path: '/objects-end/:id_object',
        component: objectEnd,//() => import(/* webpackChunkName: "objectEnd" */'./components/pages/object/objectEnd'),//objectEnd,
        alias: '/admin/objects-end/:id/:id_object'
    },
    {
        name: 'addContact',
        path: '/add-contact',
        component: addContact,//() => import(/* webpackChunkName: "addContact" */'./components/pages/passport/addContact'),//uploadPage,
        alias: '/admin/add-contact/:id'
    },
];

export default new VueRouter({
    mode: 'history',
    routes,
});
