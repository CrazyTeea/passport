import Vue from 'vue';
import VueRouter from 'vue-router';
import userIndex from './components/pages/passport/userIndex';
import orgInfo from './components/pages/passport/orgInfo';
import areaInfo from './components/pages/passport/areaInfo';
import livingInfo from './components/pages/passport/livingInfo';
import livingInfoInv from './components/pages/passport/livingInfoInv';
import object from './components/pages/object/object';
import objectArea from './components/pages/object/objectArea';
import objectTariff from './components/pages/object/objectTariff';
import objectMoney from './components/pages/object/objectMoney';
import uploadPage from './components/pages/docs/uploadPage';
import manual from './components/pages/passport/manual';
import orgList from './components/pages/admin/orgList';


Vue.use(VueRouter);

const routes = [
    /*{
      path: '',
      component: userIndex
    },*/
    {
      path: '/admin/statistic',
      component: orgList
    },
    {
        path: '/main',
        component: userIndex,
        alias: '/admin/data/:id'
    },
    {
        path: '/org-info',
        component: orgInfo,
        alias: '/admin/org-info/:id'
    },
    {
        path: '/area-info',
        component: areaInfo,
        alias: '/admin/area-info/:id'
    },
    {
        path: '/living-info',
        component: livingInfo,
        alias: '/admin/living-info/:id'
    },
    {
        path: '/living-info-inv',
        component: livingInfoInv,
        alias: '/admin/org-info-inv/:id'
    },
    {
        path: '/objects-info',
        component: object,
        name: 'object',
        props: true,
        alias: '/admin/objects-info/:id'

    },
    {
        path: '/objects-area',
        component: objectArea,
        alias: '/admin/object-area-info/:id'
    },
    {
        path: '/objects-tariff',
        component: objectTariff,
        alias: '/admin/object-tariff/:id'
    },
    {
        path: '/objects-money',
        component: objectMoney,
        alias: '/admin/object-money/:id'
    },
    {
        path: '/documents',
        component: uploadPage,
        alias: '/admin/documents/:id'
    },
    {
        path: '/manual',
        component: manual,
    },

];

export default new VueRouter({
    mode: 'history',
    routes,
});
