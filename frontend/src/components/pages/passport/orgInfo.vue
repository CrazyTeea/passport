<template>

    <transition name="bounce">
        <div v-if="componentReady" id="org-info-page">
        <nav-bar v-on:save-page="savePage" v-on:block-save="blockSave = !blockSave"/>
        <div v-if="organization" class="container">
            <h3>Сведения об организации</h3>
            <hr>
            <b-form-group
                    id="input-group-org_name"
                    label="Полное наименование организации"
                    label-for="input-org_name"
            >
                <b-form-input
                        id="input-org_name"
                        v-model="organization.name"
                        disabled
                ></b-form-input>
            </b-form-group>
            <b-form-group
                    id="input-group-short_name"
                    label="Сокращенное наименование организации"
                    label-for="input-short_name"
            >
                <b-form-input
                        id="input-short_name"
                        v-model="organization.short_name"
                        disabled
                ></b-form-input>
            </b-form-group>
            <b-form-group
                    id="input-group-org_founder"
                    label="Подчинение федеральному органу исполнительной власти"
                    label-for="input-org_founder"
            >
                <b-form-input
                        id="input-org_founder"
                        v-model="organization.founder.founder"
                        disabled
                ></b-form-input>
            </b-form-group>
            <b-form-group
                    id="input-group-org_region"
                    label="Регион расположения организации"
                    label-for="input-org_region"
            >
                <b-form-input
                        id="input-org_region"
                        v-model="organization.region.region"
                        disabled
                ></b-form-input>
            </b-form-group>
            <hr>

            <div class="row">
                <div class="col-8">
                    <label class="font-weight-bold" for="students_count-input">Численность обучающихся</label>
                </div>
                <div class="col-4">
                    <b-form-input disabled id="students_count-input" v-model="organization.stud_cnt"/>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-8">
                    <label class="font-weight-bold ml-4" for="students_count_rus-input">1. Численность обучающихся граждан России</label>
                </div>
                <div class="col-4">
                    <b-form-input disabled id="students_count_rus-input" v-model="organization.stud_cnt_rus"/>
                </div>
            </div>

            <b-table-simple fixed v-if="organization.info" class="mt-2" small borderless>
                <b-thead>
                    <b-tr>
                        <b-th> <span class="ml-5">1. Численность обучающихся граждан России</span></b-th>
                        <b-th>За счёт средств федерального бюджета</b-th>
                        <b-th>За счёт средств бюджета субъекта</b-th>
                        <b-th>За счёт средств местного бюджета</b-th>
                        <b-th>По договорам об оказании платных образовательных услуг </b-th>
                        <b-th>Всего</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr>
                        <b-th>Спо</b-th>
                        <b-td><b-form-input v-model="organization.info[0].s_f_b_spo" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_b_s_spo" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_m_b_spo" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_p_u_spo" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Бакалавриат</b-th>
                        <b-td><b-form-input v-model="organization.info[0].s_f_b_bak" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_b_s_bak" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_m_b_bak" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_p_u_bak" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Специалитет</b-th>
                        <b-td><b-form-input v-model="organization.info[0].s_f_b_spec" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_b_s_spec" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_m_b_spec" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_p_u_spec" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Магистратура</b-th>
                        <b-td><b-form-input v-model="organization.info[0].s_f_b_mag" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_b_s_mag" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_m_b_mag" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_p_u_mag" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Аспирантура</b-th>
                        <b-td><b-form-input v-model="organization.info[0].s_f_b_asp" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_b_s_asp" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_m_b_asp" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_p_u_asp" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Ординатура</b-th>
                        <b-td><b-form-input v-model="organization.info[0].s_f_b_ord" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_b_s_ord" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_m_b_ord" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_p_u_ord" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>По иным о.п</b-th>
                        <b-td><b-form-input v-model="organization.info[0].s_f_b_in" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_b_s_in" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_m_b_in" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[0].s_p_u_in" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Всего</b-th>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                </b-tbody>
            </b-table-simple>

            <div class="row mt-2">
                <div class="col-10">
                    <label class="font-weight-bold ml-4" for="students_count_foreign-input">2. Численность обучающихся иностранцев</label>
                </div>
                <div class="col-2">
                    <b-form-input disabled id="students_count_foreign-input" v-model="organization.students_count_foreign"/>
                </div>
            </div>

            <b-table-simple v-if="organization.info" fixed class="mt-2" small borderless>
                <b-thead>
                    <b-tr>
                        <b-th> <span class="ml-5">2. Численность обучающихся иностранцев</span></b-th>
                        <b-th>За счёт средств федерального бюджета</b-th>
                        <b-th>За счёт средств бюджета субъекта</b-th>
                        <b-th>За счёт средств местного бюджета</b-th>
                        <b-th>По договорам об оказании платных образовательных услуг </b-th>
                        <b-th>Всего</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr>
                        <b-th>Спо</b-th>
                        <b-td><b-form-input v-model="organization.info[1].s_f_b_spo" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_b_s_spo" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_m_b_spo" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_p_u_spo" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Бакалавриат</b-th>
                        <b-td><b-form-input v-model="organization.info[1].s_f_b_bak" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_b_s_bak" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_m_b_bak" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_p_u_bak" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Специалитет</b-th>
                        <b-td><b-form-input v-model="organization.info[1].s_f_b_spec" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_b_s_spec" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_m_b_spec" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_p_u_spec" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Магистратура</b-th>
                        <b-td><b-form-input v-model="organization.info[1].s_f_b_mag" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_b_s_mag" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_m_b_mag" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_p_u_mag" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Аспирантура</b-th>
                        <b-td><b-form-input v-model="organization.info[1].s_f_b_asp" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_b_s_asp" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_m_b_asp" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_p_u_asp" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Ординатура</b-th>
                        <b-td><b-form-input v-model="organization.info[1].s_f_b_ord" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_b_s_ord" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_m_b_ord" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_p_u_ord" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>По иным о.п</b-th>
                        <b-td><b-form-input v-model="organization.info[1].s_f_b_in" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_b_s_in" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_m_b_in" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input v-model="organization.info[1].s_p_u_in" :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Всего</b-th>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                </b-tbody>
            </b-table-simple>



        </div>

    </div>
    </transition>

</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import {BFormGroup, BFormInput, BTableSimple, BTbody, BTd, BTh, BThead, BTr} from 'bootstrap-vue'
    import Axios from "axios";

    export default {
        data(){
            return {
                csrf: document.getElementsByName("csrf-token")[0].content,
                blockSave:true,
                user:{},
                students:[],
                students_foreign:[],
                organization:{
                    founder:{
                        founder:''
                    },
                    region:{
                        region:''
                    }
                },
                componentReady:false
            }
        },
        components:{
            NavBar,
            BFormGroup,
            BFormInput,
            BThead,BTbody,
            BTableSimple,
            BTh,BTr,BTd
        },
        async mounted() {
            await this.getUser();
            this.id_org = this.user.id_org
            await this.getOrg()
            this.componentReady=true;
        },
        methods:{
            async getUser(){
                await Axios.get('/api/user/current').then(res=>
                {this.user = res.data;});
            },
            async getOrg(){
                await Axios.get(`/api/organization/by-id/${this.id_org}`).then(res=>
                    {
                        this.organization = res.data;
                        this.organization = {...this.organization,...res.data.organization};
                        if (res.data.info){
                            res.data.info.forEach(item=>{
                                this.organization.info[parseInt(item.stud_type)] = item;
                            })
                        }
                        this.organization.info = res.data.info || {};
                    }
                );
            },
            async savePage(){
                let data = new FormData();
                data.append('org',JSON.stringify(this.organization));
                await Axios.post(`/organization/set-org-info/${this.id_org}`,data,{
                    headers: {
                        "X-CSRF-Token": this.csrf
                    }
                }).then(res=>{
                    this.getOrg()
                    console.log(res.data);
                }).finally(()=>{
                    this.blockSave = true;
                })
            }
        }

    }
</script>

<style scoped>
    .bounce-enter-active {
        transition: all .3s ease;
    }
    .bounce-leave-active {
        transition: all .3s ease;
    }
    .bounce-enter  {
        transform: translateX(100px);
        opacity: 0;
    }
    .bounce-leave-to {
        transform: translateX(-100px);
        opacity: 0;
    }
</style>