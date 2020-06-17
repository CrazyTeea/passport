<template>
    <div>
        <nav-bar></nav-bar>

        <b-jumbotron v-if="!user.id_org" >
            <template v-slot:header>
                <span class="text text-danger">Ошибка</span>
            </template>

            <template v-slot:lead>
                У пользователя отсутсвует информация об организации
                Обратитесь в техническую поддержку
            </template>
        </b-jumbotron>

        <div class="page" v-else>
            <div class="row">
                <div class="col-8"><h4>{{organization.name}}</h4></div>
            </div>
            <div style="margin-top: 10px;" class="row">
                <div class="col-8"><h5>Регион: {{organization.region}}</h5></div>
            </div>
            <div style="margin-top: 10px;" class="row">
                <div class="col-3">
                    <label class="font-weight-bold" for="contact_check">Контактные данные заполнены</label>
                </div>
                <div class="col-6">
                    <b-form-checkbox id="contact_check"></b-form-checkbox>
                </div>
            </div>
            <div style="margin-top: 10px;" class="row">
                <div class="col-3">
                    <label class="font-weight-bold" for="file_check">Документы загружены</label>
                </div>
                <div class="col-6">
                    <b-form-checkbox id="file_check"></b-form-checkbox>
                </div>
            </div>

            <b-card style="margin-top: 10px;" no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                    <label class="text-left font-weight-bold btn-block" v-b-toggle.news >Новости</label>
                </b-card-header>
                <b-collapse id="news" visible accordion="news"  role="tabpanel">
                    <b-card-body>
                        <b-card-text>I start opened because <code>visible</code> is <code>true</code></b-card-text>
                    </b-card-body>
                </b-collapse>
            </b-card>
            <b-card style="margin-top: 10px;" no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                    <label class="text-left font-weight-bold btn-block" v-b-toggle.contact_info >Контактные данные
                        заполняющих мониторинг сотрудников</label>
                </b-card-header>
                <b-collapse id="contact_info" visible accordion="contact_info"  role="tabpanel">
                    <b-card-body >
                        <div class="row">
                            <div class="col-6" v-for="(user_info,index) in users_info" :key="index">
                                <b-card >
                                    <label :for="`user_info_${index}_name`">Фамилия Имя Отчество</label>
                                    <b-form-input :id="`user_info_${index}_name`" v-model="user_info.name"/>
                                    <label :for="`user_info_${index}_position`">Должность</label>
                                    <b-form-input :id="`user_info_${index}_position`" v-model="user_info.position"/>
                                    <label :for="`user_info_${index}_phone`">Мобильный телефон</label>
                                    <b-form-input :id="`user_info_${index}_phone`" v-model="user_info.phone"/>
                                    <label :for="`user_info_${index}_email`">email</label>
                                    <b-form-input :id="`user_info_${index}_email`" v-model="user_info.email"/>
                                </b-card>
                            </div>
                            <div class="col-6">
                                <b-card  class="contact-card">
                                    <b-card-body class="center">
                                        <span>Добавить</span><br>
                                        <img
                                                @click="addUserInfo"
                                                src="http://peterhanne.de/site/assets/files/4699/plus_schwarz.png"
                                                style="width: 25%" alt="Добавить">
                                        <br>

                                    </b-card-body>
                                    <template v-slot:footer>
                                        <b-button @click="deleteUserInfo" variant="outline-danger" block>Удалить</b-button>
                                    </template>
                                </b-card>
                            </div>
                        </div>
                    </b-card-body>
                </b-collapse>
            </b-card>


        </div>

    </div>
</template>

<script>
    import NavBar from "../../organisms/NavBar.vue";
    import {BJumbotron,BButton,BCollapse,
        BFormCheckbox,BCardHeader,BFormInput,
        BCard,BCardBody,BCardText,VBToggle} from 'bootstrap-vue';
    import Axios from 'axios';
    export default {
        components:{
            NavBar,
            BJumbotron,
            BButton,
            BFormCheckbox,
            BCard,
            BCardBody,
            BFormInput,
            BCardHeader,
            BCardText,
            BCollapse,
        },
        directives:{
            BToggle:VBToggle
        },
        data() {
            return {
                user: {},
                organization:{},
                users_info:[{
                    name:'',
                    position:'',
                    phone:'',
                    email:''
                }]
            }
        },
        async mounted() {
            await this.getUser();
            if (this.user.id_org)
                await this.getOrg(this.user.id_org);
        },
        methods:{
            addUserInfo(){
                if (this.users_info.length < 3)
                    this.users_info.push({
                        name:'',
                        position:'',
                        phone:'',
                        email:''
                    });
            },
            deleteUserInfo(){
                if (this.users_info.length > 1)
                    this.users_info.pop()
            },
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
        margin-right: 15%;
        margin-left: 17%;
    }
    .contact-card{
        min-height: 100%;
    }
    .contact-card:hover{
        background: rgba(0, 0, 0, 0.03);
        cursor: pointer;
    }
    .center{
        margin-top: 10%;
        margin-left: 38%;
    }

</style>