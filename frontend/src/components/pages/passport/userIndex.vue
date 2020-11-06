<template>
  <div>

    <nav-bar :is-admin="user.isAdmin" :id_org="id_org" v-on:save-page="savePage"
             v-on:block-save="blockSave = !blockSave"></nav-bar>
    <transition enter-active-class="animated fadeInUp">
      <div v-if="componentReady">


        <b-jumbotron v-if="!user.id_org && !user.isAdmin">
          <template v-slot:header>
            <span class="text text-danger">Ошибка</span>
          </template>

          <template v-slot:lead>
            У пользователя отсутсвует информация об организации
            Обратитесь в техническую поддержку
          </template>
        </b-jumbotron>

        <div class="container mt-2" v-else>

          <org-select link="/api/organizations/all" error-msg="нет доступных организаций по заданным критериаям"
                    label="Выбранная организация" v-can:admin,root v-model="id_org"/>


          <div class="row">
            <div class="col-8"><h4>{{ organization.name }}</h4></div>
            <div class="col-4">
              <b-button v-can:user href="/org-info" block variant="outline-secondary">Перейти к заполнению</b-button>
            </div>
          </div>
          <div style="margin-top: 10px;" class="row">
            <div class="col-8"><h5>Регион: {{ organization.region.region }}</h5></div>
            <div class="col-4">
              <b-button block variant="outline-secondary">Инструкция</b-button>
            </div>
          </div>
          <div style="margin-top: 10px;" class="row">
            <div class="col-4">
              <label class="font-weight-bold">Контактные данные заполнены</label>
            </div>
            <div class="col">
              <div v-if="cont_dan">
                <i class="fas fa-check text-success fa-2x"></i>
              </div>
              <div v-else>
                <i class="fas fa-times fa-2x text-danger"></i>
              </div>
            </div>
          </div>
          <div style="margin-top: 10px;" class="row">
            <div class="col-4">
              <label class="font-weight-bold">Документы загружены</label>
            </div>
            <div class="col">
              <!--<div v-if="cont_dan">
                <i class="fas fa-check text-success fa-2x"></i>
              </div>-->
              <div>
                <i class="fas fa-times fa-2x text-danger"></i>
              </div>
            </div>
          </div>

          <b-card no-body class="mt-2 mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
              <label class="text-left mt-2 ml-2 font-weight-bold btn-block" v-b-toggle.news>Новости</label>
            </b-card-header>
            <b-collapse id="news" visible accordion="news" role="tabpanel">
              <b-card-body>
                <b-card-text>Здесь будут новости</b-card-text>
              </b-card-body>
            </b-collapse>
          </b-card>
          <b-card no-body class="mt-2 mb-1">
            <b-card-header header-tag="header" class="p-1" role="tab">
              <label class="text-left ml-2 mt-2 font-weight-bold btn-block" v-b-toggle.contact_info>Контактные данные
                заполняющих мониторинг сотрудников</label>
            </b-card-header>
            <b-collapse id="contact_info" visible accordion="contact_info" role="tabpanel">
              <b-card-body>
                <div class="row">
                  <transition-group class="list-item" tag="div" name="fade">

                    <div class="card-center" v-for="(user_info,index) in users_info" :key="`lol`+index">
                      <b-card no-body>
                        <b-card-body class="contact">

                          <label class="font-weight-bold" :for="`user_info_${index}_name`">Фамилия Имя Отчество</label>
                          <b-form-input :disabled="blockSave" :id="`user_info_${index}_name`" v-model="user_info.name"/>
                          <label class="mt-4 font-weight-bold" :for="`user_info_${index}_position`">Должность</label>
                          <b-form-input :disabled="blockSave" :id="`user_info_${index}_position`"
                                        v-model="user_info.position"/>
                          <label class="mt-4 font-weight-bold" :for="`user_info_${index}_phone`">Мобильный
                            телефон</label>
                          <b-form-input :disabled="blockSave" :id="`user_info_${index}_phone`"
                                        v-model="user_info.phone"/>
                          <label class="mt-4 font-weight-bold" :for="`user_info_${index}_email`">email</label>
                          <b-form-input :disabled="blockSave" :id="`user_info_${index}_email`"
                                        v-model="user_info.email"/>
                        </b-card-body>
                        <template v-if="!blockSave" v-slot:footer>
                          <b-button @click="deleteUserInfo(index)" variant="outline-danger" block>Удалить</b-button>
                        </template>
                      </b-card>
                    </div>
                  </transition-group>
                  <div v-if="users_info.length < 2" class="col-6"
                       style="margin-left: -10px; min-width: 51% !important;">
                    <b-card no-body v-if="!blockSave" class="contact-card">
                      <b-card-body class="justify-content-center align-items-center d-flex" @click="addUserInfo">
                        <i class="fa fa-plus fa-10x "></i>
                        <!--<img class="center" style="width: 25%"
                             src="http://peterhanne.de/site/assets/files/4699/plus_schwarz.png" alt="Добавить">-->
                      </b-card-body>
                    </b-card>
                  </div>
                </div>
              </b-card-body>
            </b-collapse>
          </b-card>
        </div>

      </div>
    </transition>
    <!--<scroll-button/>-->
  </div>

</template>

<script>
import {
  BButton,
  BCard,
  BCardBody,
  BCardHeader,
  BCardText,
  BCollapse,
  BFormInput,
  BJumbotron,
  VBToggle,
} from 'bootstrap-vue';
import Axios from 'axios';
import NavBar from '../../organisms/NavBar.vue';
import OrgSelect from "../../organisms/orgSelect";

export default {
  components: {
    OrgSelect,
    NavBar,
    BJumbotron,
    BButton,
    BCard,
    BCardBody,
    BFormInput,
    BCardHeader,
    BCardText,
    BCollapse,
  },
  directives: {
    BToggle: VBToggle,
  },
  data() {
    return {
      test: null,
      csrf: document.getElementsByName('csrf-token')[0].content,
      blockSave: false,
      user: {},
      cont_dan: false,
      componentReady: false,
      id_org: 0,
      organization: {
        region: {
          region: '',
        },
      },
      users_info: [{
        id: null,
        name: '',
        position: '',
        phone: '',
        email: '',

      }],
    };
  },
  async mounted() {
    await this.getUser();

    if (this.user.isAdmin)
      this.id_org = this.$route.fullPath.split('/')[3] || this.user.id_org
    else this.id_org = this.user.id_org;

    this.blockSave = this.user.isAdmin


    await this.update();

    this.componentReady = true;
  },
  watch:{
    async id_org(){
      if (this.componentReady)
        await this.update()
    }
  },
  methods: {

    async update() {
      await this.getOrg(this.id_org);
      await this.getUserInfo();
    },

    async savePage() {
      const data = new FormData();

      data.append('users', JSON.stringify(this.users_info));

      await Axios.post(`/organization/users-info/${this.id_org}`, data, {
        headers: {
          'X-CSRF-Token': this.csrf,
        },
      }).then((res) => {
        if (res.data.success) this.getUserInfo();
      }).finally(() => {
        this.blockSave = true;
      });
    },
    addUserInfo() {
      if (this.users_info.length < 3) {
        this.users_info.push({
          id: null,
          name: null,
          position: null,
          phone: null,
          email: null,
        });
      }
    },
    async deleteUserInfo(index) {
      const {id} = this.users_info[index];
      if (id) {
        await Axios.post(`/organization/users-info/${id}/delete`, {}, {
          headers: {
            'X-CSRF-Token': this.csrf,
          },
        }).then((res) => {
          if (res.data.success) {
            this.users_info.splice(index, 1);
          }
        });
      } else this.users_info.splice(index, 1);
    },
    async getUser() {
      await Axios.get('/api/user/current').then((res) => {
        this.user = res.data;
        this.user.isAdmin = !!res.data.roles.root || !!res.data.roles.admin
      });
    },
    async getOrg() {
      await Axios.get(`/api/organization/by-id/${this.id_org}`).then((res) => {
        this.organization = {...res.data, ...res.data.organization};
      });
    },
    async getUserInfo() {
      await Axios.get(`/api/organization/users/${this.id_org}`).then((res) => {
        this.users_info = [];
        res.data.forEach((item) => {
          this.users_info.push({
            id: item.id,
            name: item.name,
            position: item.position,
            email: item.email,
            phone: item.phone,

          });
        });
        if (res.data.length) {
          res.data.forEach((item) => {
            Object.keys(item).forEach((key) => {
              this.cont_dan = !!item[key];
            });
          });
        }
      });
    },
  },

};
</script>

<style scoped>
.card-center {
  min-width: 49%;
  margin-left: 5px;
  margin-bottom: 5px;
}

.contact-card {
  min-height: 100%;
}

.contact {
  min-width: 45% !important;
}

.contact-card:hover {
  background: rgba(0, 0, 0, 0.03);
  cursor: pointer;
}

.center {
  margin-left: 35%;
  margin-top: 25%;
  margin-bottom: 25%;
}

.list-item {
  min-width: 50%;
  display: contents;
  flex-basis: 100%;
}

.fade-enter-active, .fade-leave-active {
  transition: opacity ease .5s;
}

.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */
{
  opacity: 0;
}

</style>
