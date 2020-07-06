<template>
    <div>
        <nav-bar v-on:save-page="savePage" v-on:block-save="blockSave = !blockSave"></nav-bar>

        <b-jumbotron v-if="!user.id_org" >
            <template v-slot:header>
                <span class="text text-danger">Ошибка</span>
            </template>

            <template v-slot:lead>
                У пользователя отсутсвует информация об организации
                Обратитесь в техническую поддержку
            </template>
        </b-jumbotron>

        <div class="container mt-2" v-else>
            <div class="row">
                <div class="col-8"><h4>{{organization.name}}</h4></div>
                <div class="col-4"><b-button href="/org-info" block variant="outline-secondary">Перейти к заполнению</b-button></div>
            </div>
            <div style="margin-top: 10px;" class="row">
                <div class="col-8"><h5>Регион: {{organization.region.region}}</h5></div>
                <div class="col-4"><b-button block variant="outline-secondary">Инструкция</b-button></div>
            </div>
            <div style="margin-top: 10px;" class="row">
                <div class="col-3">
                    <label class="font-weight-bold" for="contact_check">Контактные данные заполнены</label>
                </div>
                <div class="col-6">
                    <b-form-checkbox disabled id="contact_check"></b-form-checkbox>
                </div>
            </div>
            <div style="margin-top: 10px;" class="row">
                <div class="col-3">
                    <label class="font-weight-bold" for="file_check">Документы загружены</label>
                </div>
                <div class="col-6">
                    <b-form-checkbox disabled id="file_check"></b-form-checkbox>
                </div>
            </div>

            <b-card style="margin-top: 10px;" no-body class="mb-1">
                <b-card-header header-tag="header" class="p-1" role="tab">
                    <label class="text-left font-weight-bold btn-block" v-b-toggle.news >Новости</label>
                </b-card-header>
                <b-collapse id="news" visible accordion="news"  role="tabpanel">
                    <b-card-body>
                        <b-card-text>Здесь будут новости</b-card-text>
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
                            <transition-group class="list-item" tag="div" name="fade">

                                <div class="card-center" v-for="(user_info,index) in users_info" :key="`lol`+index">
                                    <b-card no-body>
                                        <b-card-body class="contact">
                                            <div v-if="!blockSave">
                                                <label :for="`user_info_${index}_name`">Фамилия Имя Отчество</label>
                                                <b-form-input :id="`user_info_${index}_name`" v-model="user_info.name"/>
                                                <label :for="`user_info_${index}_position`">Должность</label>
                                                <b-form-input :id="`user_info_${index}_position`" v-model="user_info.position"/>
                                                <label :for="`user_info_${index}_phone`">Мобильный телефон</label>
                                                <b-form-input :id="`user_info_${index}_phone`" v-model="user_info.phone"/>
                                                <label :for="`user_info_${index}_email`">email</label>
                                                <b-form-input :id="`user_info_${index}_email`" v-model="user_info.email"/>
                                            </div>
                                            <div v-else>
                                                <div class="row">
                                                    <div class="col-12">
                                                        Фамилия Имя Отчество
                                                        <p>{{user_info.name}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        Должность
                                                        <p> {{user_info.position}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                       Мобильный телефон
                                                        <p>{{user_info.phone}}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        email
                                                        <p> {{user_info.email}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </b-card-body>
                                        <template v-if="!blockSave" v-slot:footer>
                                            <b-button @click="deleteUserInfo(index)" variant="outline-danger" block>Удалить</b-button>
                                        </template>
                                    </b-card>
                                </div>
                            </transition-group>
                            <div class="col-6" style="margin-left: -10px; min-width: 51% !important;">
                                <b-card v-if="!blockSave" class="contact-card">
                                    <b-card-body @click="addUserInfo">
                                        <img class="center" style="width: 25%" src="http://peterhanne.de/site/assets/files/4699/plus_schwarz.png" alt="Добавить">
                                    </b-card-body>
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
                csrf: document.getElementsByName("csrf-token")[0].content,
                blockSave:true,
                user: {},
                organization:{
                    region:{
                        region:''
                    }
                },
                users_info:[{
                    id:null,
                    name:'',
                    position:'',
                    phone:'',
                    email:''
                }]
            }
        },
        async mounted() {
            await this.getUser();
            if (this.user.id_org) {
                await this.getOrg(this.user.id_org);
                await this.getUserInfo()
            }
        },
        methods:{
            async savePage(){
                let data = new FormData();

                data.append('users',JSON.stringify(this.users_info))

                await Axios.post(`/organization/users-info/${this.user.id_org}`,data,{
                    headers: {
                        "X-CSRF-Token": this.csrf
                    }
                }).then(res=>{
                    this.getUserInfo();
                })
            },
            addUserInfo(){
                if (this.users_info.length < 3)
                    this.users_info.push({
                        id:null,
                        name:null,
                        position:null,
                        phone:null,
                        email:null
                    });
            },
            async deleteUserInfo(index){
                let id = this.users_info[index].id;
                if (id){
                    await Axios.post(`/organization/users-info/${id}/delete`, {}, {
                        headers: {
                            "X-CSRF-Token": this.csrf
                        }
                    }).then(res => {
                        if (res.data.success)
                            this.users_info.splice(index,1);
                    })
                }else this.users_info.splice(index,1);
            },
            async getUser(){
                await Axios.get('/api/user/current').then(res=>
                {this.user = res.data; console.log(res.data)});
            },
            async getOrg(){
                await Axios.get(`/api/organization/by-id/${this.user.id_org}`).then(res=>
                {this.organization = res.data;console.log(res.data)});
            },
            async getUserInfo(){
                await Axios.get(`/api/organization/users/${this.user.id_org}`).then(res=>{
                    this.users_info = [];
                    res.data.forEach((item,index)=>{

                        this.users_info.push({
                            id:item.id,
                            name : item.name,
                            position : item.position,
                            email : item.email,
                            phone : item.phone,

                        })

                    })
                })
            }
        }

    }
</script>

<style scoped>
    .card-center{
        min-width: 49%;
        margin-left: 5px;
        margin-bottom: 5px;
    }
    .contact-card{
        min-height: 100%;
    }
    .contact{
        min-width: 45% !important;
    }
    .contact-card:hover{
        background: rgba(0, 0, 0, 0.03);
        cursor: pointer;
    }
    .center{
        margin-left: 35%;
        margin-top: 25%;
        margin-bottom: 25%;
    }
    .list-item{
        min-width: 50%;
        display: contents;
        flex-basis: 100%;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity ease .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
        opacity: 0;
    }

</style>