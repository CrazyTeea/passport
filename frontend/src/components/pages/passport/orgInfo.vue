<template>
    <div id="org-info-page">
        <nav-bar v-on:block-save="blockSave = !blockSave"/>
        <div class="page">
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
                <div class="col-10">
                    <label class="font-weight-bold" for="students_count-input">Численность обучающихся</label>
                </div>
                <div class="col-2">
                    <b-form-input disabled id="students_count-input" v-model="organization.students_count"/>
                </div>
            </div>
            <div style="margin-top: 5px" class="row">
                <div class="col-10">
                    <label style="margin-left: 20px" class="font-weight-bold" for="students_count_rus-input">1. Численность обучающихся граждан России</label>
                </div>
                <div class="col-2">
                    <b-form-input disabled id="students_count_rus-input" v-model="organization.students_count_rus"/>
                </div>
            </div>

            <b-table-simple style="margin-top: 15px" small borderless>
                <b-thead>
                    <b-tr>
                        <b-th> <span style="margin-left: 50px">1. Численность обучающихся граждан России</span></b-th>
                        <b-th>За счёт средств федерального бюджета</b-th>
                        <b-th>За счёт средств бюджета субъекта</b-th>
                        <b-th>За счёт средств местного бюджета</b-th>
                        <b-th>По договорам об оказании платных образовательных услуг </b-th>
                        <b-th>Всего</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr>
                        <b-th>Среднее профессиональное образование</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Бакалавриат</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Специалитет</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Магистратура</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Аспирантура</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Ординатура</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>По иным образовательным программам</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
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

            <div style="margin-top: 5px" class="row">
                <div class="col-10">
                    <label style="margin-left: 20px" class="font-weight-bold" for="students_count_foreign-input">2. Численность обучающихся иностранцев</label>
                </div>
                <div class="col-2">
                    <b-form-input disabled id="students_count_foreign-input" v-model="organization.students_count_foreign"/>
                </div>
            </div>

            <b-table-simple style="margin-top: 15px" small borderless>
                <b-thead>
                    <b-tr>
                        <b-th> <span style="margin-left: 50px">2. Численность обучающихся иностранцев</span></b-th>
                        <b-th>За счёт средств федерального бюджета</b-th>
                        <b-th>За счёт средств бюджета субъекта</b-th>
                        <b-th>За счёт средств местного бюджета</b-th>
                        <b-th>По договорам об оказании платных образовательных услуг </b-th>
                        <b-th>Всего</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr>
                        <b-th>Среднее профессиональное образование</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Бакалавриат</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Специалитет</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Магистратура</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Аспирантура</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>Ординатура</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input disabled/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-th>По иным образовательным программам</b-th>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
                        <b-td><b-form-input :disabled="blockSave"/></b-td>
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

</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import {BFormGroup,BFormInput,BTh,BTr,BTd,BThead,BTbody,
        BTableSimple} from 'bootstrap-vue'
    import Axios from "axios";
    export default {
        data(){
            return {
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
                }
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
            await this.getOrg(this.id_org);
        },
        methods:{
            async getUser(){
                await Axios.get('/api/user/current').then(res=>
                {this.user = res.data; console.log(res.data)});
            },
            async getOrg(id){
                await Axios.get(`/api/organization/by-id/${id}`).then(res=>
                {this.organization = res.data;console.log(res.data)});
            }
        }

    }
</script>

<style scoped>
    .page{
        margin-top: 15px;
        margin-right: 25%;
        margin-left: 25%;
    }
</style>