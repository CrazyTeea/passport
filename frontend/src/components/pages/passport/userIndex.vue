<template>
  <div>
    <v-page>
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
          <org-select v-if="$check(['admin','root'])" v-model="id_org"
                      error-msg="нет доступных организаций по заданным критериаям"
                      label="Выбранная организация" link="/api/organizations/all"/>

          <div class="row">
            <div class="col-8"><h4>{{ organization.name }}</h4></div>
            <div class="col-4"></div>
          </div>

          <div style="margin-top: 10px;" class="row">
            <div class="col-8"><h5>Регион: {{ organization.region.region }}</h5></div>
          </div>


          <div class="row">
            <div style="height:16px" class="col-8 mt-4"><h5>Статистика</h5></div>
          </div>
          <hr>
          <div class="row">
            <div class="col-12">
              <ol>
                <label style="margin-right:4px">Внесено контактных данных:</label>
                <label class="font-weight-bold">{{ getCountUsersInfo }}</label><br>
                <label class="mt-1" style="margin-right:4px">Добавлено жилых объектов:</label>
                <label class="font-weight-bold">{{ objects.length }}</label><br>
                <label class="mt-1" style="margin-right:4px">Добавлена информация по жилым объектам:</label>
                <label class="font-weight-bold">{{ getCountObjectsWhereCountPol }}</label><br>
                <label class="mt-1" style="margin-right:4px">
                  Добавлено жилых объектов, используемых в уставной деятельности:
                </label>
                <label class="font-weight-bold">{{ getCountObjectsWhereUstavDey }}</label><br>
                <label class="mt-1" style="margin-right:4px">Добавлено документов:</label>
                <label class="font-weight-bold">{{ getCountFiles }}</label><br>
              </ol>
            </div>
          </div>

          <b-alert class="d-flex justify-content-start align-items-center" show variant="warning">
            <alert-icon/>
            <div class="ml-3">
              Отчёт считается заполненным при добавлении информации об объектах,
              информации об организации, контактных данных и прикреплённой сканированной копии отчёта.
            </div>
          </b-alert>
          <b-alert class="d-flex justify-content-start align-items-center" show variant="info">
            <info-icon/>
            <div class="ml-3">
              В случае отсутствия жилых объектов необходимо прикрепить письмо с информацией об этом на официальном
              бланке организации с подписью руководителя и печатью учреждения.
            </div>
          </b-alert>
          <b-alert class="d-flex justify-content-start align-items-center" show variant="info">
            <info-icon/>
            <div class="ml-3">
              <div>Сбор данных по миниторингу заканчивается 15 апреля.</div>
              <div class="mt-1">Данные собираются за 2020 год.</div>
            </div>

          </b-alert>

          <div class="row">
            <div class="col-8 mt-4">
              <div style="margin-top: 14px"><h5 style=" margin-bottom: 0px">Добавление информации</h5></div>
            </div>
            <div class="col-4 mt-4">
              <b-button block target="_blank" variant="outline-secondary" @click="goto()">Добавить объект</b-button>

              <b-modal v-model="modal_show" centered hide-header>
                <b-form-group id="fieldset-obj_name" label="Наименование добавляемого жилого объекта"
                              label-for="obj_name">
                  <b-form-input v-model="objName" id="obj_name"/>
                </b-form-group>
                <b-form-group id="fieldset-obj_id_region" label="Регион расположения добавляемого жилого объекта"
                              label-for="obj_id_region">
                  <v-select v-model="objIdRegion" id="obj_id_region" label="text" :options="regions"
                            :reduce="item=>item.value"/>
                </b-form-group>

                <template v-slot:modal-footer>
                  <!--                  <b-alert show variant="primary">
                                      Если у организации появился новый жилой объект, то лучше сначала его добавить в подсистему
                                      "Управление
                                      имуществом", тогда в выпадающем списке объектов он появится автоматически.
                                    </b-alert>-->
                  <b-button @click="modal_show = !modal_show" variant="outline-danger">Отмена</b-button>
                  <b-button @click="addObject" variant="outline-success">Сохранить</b-button>
                </template>
              </b-modal>
            </div>
          </div>
          <hr>

          <div class="card mb-3 pt-3 pb-3 col-12 contact-card" style="cursor: pointer"
               @click="goTo(user.isAdmin ? `/admin/add-contact/${id_org}` : '/add-contact')">
            <div style="horiz-align: right" class="row no-gutters">
              <div class="col-md-8">
                <label class="font-weight-bold" style="margin-right:4px">Добавление контактных данных</label>
              </div>
              <div class="col-md-3">
                <label style="margin-right:4px">Добавлено контактов:</label><label
                  class="font-weight-bold">{{ getCountUsersInfo }}</label>
              </div>
              <div class="text-right col-md-1"/>
            </div>
          </div>

          <div v-for="(object, i) in objects" class="card mb-3 pt-3 pb-3 col-12 contact-card" style="cursor: pointer"
               :key="`object-${i}`">
            <div style="horiz-align: right" class="d-flex justify-content-between no-gutters">
              <div @click="goToObject(object)">
                <label class="font-weight-bold" style="margin-right:4px">{{ object.name }}</label>
                <label>({{ object.kad_number }})</label>
                <p class="card-text"><small class="text-muted">{{ object.address }}</small></p>
              </div>
              <div class="d-flex">
                <v-ellipse
                    :value="object.count_pol"
                    :max-value="object.full_count_pol"
                />
                <div class="boxer ml-3">
                  <i class="fas fa-trash" @click="deleteObject(object.id)"/>
                </div>
              </div>

            </div>
          </div>

          <div class="card mb-3 pt-3 pb-3 col-12 contact-card" style="cursor: pointer"
               @click="goTo(user.isAdmin ? `/admin/org-info/${id_org}` : '/org-info')">
            <div style="horiz-align: right" class="d-flex justify-content-between no-gutters">
              <div>
                <label class="font-weight-bold" style="margin-right:4px">Информация об организации</label>
                <p class="card-text"><small class="text-muted">{{ organization.name }}</small></p>
              </div>
              <div class="d-flex">
                <v-ellipse
                    :value="organization.count_pol"
                    :max-value="organization.full_count_pol"
                />
                <div class="boxer no ml-3"></div>
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-8 mt-4">
              <div style="margin-top: 14px"><h5 style=" margin-bottom: 0px">Отчёт по паспорту жилищного фонда</h5></div>
            </div>
            <div class="col-4 mt-4">
              <!--<b-button target="_blank" href="" block variant="outline-secondary">Скачать</b-button>-->
              <export-modal :is-nav="true" :id_org="id_org">Скачать</export-modal>
            </div>
          </div>
          <hr>
          <b-modal no-close-on-esc
                   no-close-on-backdrop
                   centered
                   ref="error-modal" hide-footer
          >
            <template v-slot:modal-header>
              <div class="text-center  d-block w-100">
                <span class="font-weight-bold">Ошибка!</span>
              </div>

            </template>
            <div class="justify-content-center d-block text-center text-danger">
              <h3>Размер файла должен быть меньше 20 мб!</h3>
            </div>
            <b-button class="mt-3" variant="outline-danger" block @click="hideModal">Я понял(а)</b-button>
          </b-modal>

          <div v-if="docTypes.length || isUser">
            <b-card v-for="(docType,index) in docTypes" border-variant="primary" class="mt-2 shadow rounded"
                    :key="index">
              <b-card-text>Загрузить документ</b-card-text>
              <b-form-group id="fileset-1" label-for="file-1" :label=docType.descriptor.label>
                <b-input-group>
                  <b-form-file v-if="!docType.server_file && !docType.file" v-model="docType.server_file"
                               browse-text="Прикрепить" class="input" placeholder="Файл не выбран" :id="`file-${index}`"
                               :ref="'fileInput' + index" @input="saveFile(docType,index)"/>
                </b-input-group>
                <div v-if="docType.fileName" class="row mt-2">
                  <div class="col-4">{{ docType.fileName }}</div>
                  <div class="col-8">
                    <b-progress animated max="100" show-progress variant="info" :value="docType.progress"/>
                  </div>
                </div>
                <transition enter-active-class="animated zoomIn" leave-active-class="animated zoomOutDown"
                            name="custom-classes-transition">
                  <div v-if="docType.server_file || docType.file" class="d-block">
                    <div class="row">
                      <div class="col d-flex align-items-center justify-content-center">
                        <span v-if="docType.server_file" class="pointer font-weight-bold text-center">
                          {{ docType.server_file.name }}
                        </span>
                        <span v-if="docType.file" class="pointer font-weight-bold text-center" @click="downFile(docType.id)">
                          {{ docType.file.name }}
                        </span>
                        <i v-if="docType.delButton && canChange()" class="ml-2 fas fa-trash-alt trash-icon"
                           @click="deleteFile(docType)"/>
                      </div>
                    </div>
                  </div>
                </transition>
              </b-form-group>
            </b-card>
          </div>
          <br>
        </div>
      </div>
      <loading v-else/>
    </v-page>
  </div>
</template>

<script>
import {
  BAlert,
  BButton,
  BCard,
  BCardBody,
  BCardHeader,
  BCardText,
  BCollapse,
  BFormFile,
  BFormGroup,
  BFormInput,
  BImg,
  BInputGroup,
  BJumbotron,
  BProgress,
  VBToggle,
} from 'bootstrap-vue';
import Axios from 'axios';

import OrgSelect from "../../organisms/orgSelect";
import {mainMixin} from "../../mixins";
import ExportModal from "../../organisms/exportModalButton";
import vSelect from 'vue-select';
import Loading from "../../organisms/loading";
import VPage from "../../organisms/vPage";
import InfoIcon from "../../organisms/infoIcon";
import AlertIcon from "../../organisms/alertIcon";
import VEllipse from "../../organisms/vEllipse";


export default {
  components: {
    VEllipse,

    AlertIcon,
    InfoIcon,
    VPage,
    Loading,
    ExportModal,
    BAlert,
    BButton,
    BCard,
    BCardBody,
    BCardHeader,
    BCardText,
    BCollapse,
    BFormFile,
    BFormGroup,
    BFormInput,
    BImg,
    BInputGroup,
    BJumbotron,
    BProgress,
    OrgSelect,
    vSelect
  },
  directives: {BToggle: VBToggle},
  data() {
    return {
      blockSave: false,
      componentReady: false,
      cntRs: 0,
      cont_dan: false,
      csrf: document.getElementsByName('csrf-token')[0].content,
      docTypes: [],
      id_org: 0,
      isUser: window.Permission === 'user',
      modal_show: false,
      objCnt: 0,
      objIdRegion: null,
      objName: '',
      objects: [],
      organization: {
        region: {
          region: '',
        },
      },
      regions: [],
      test: null,
      user: {},
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
  watch: {
    async id_org() {
      if (this.componentReady)
        await this.update()
    },
  },
  methods: {
    async deleteFile(item) {
      if (item.file) {
        const data = new FormData();
        data.append('desc', item.descriptor.desc);
        await Axios.post(`/organization/del-file/${this.id_org}`, data, {
          headers: {
            'X-CSRF-Token': this.csrf,
          },
        }).then((res) => {
          item.file = null;
          item.progress = 0;
          item.fileName = null;
        });
      }

      item.server_file = null;
    },
    async deleteObject(id) {

      let asq = await this.$bvModal.msgBoxConfirm(
              'Вы уверены, что хотите удалить объект?', {
                noCloseOnBackdrop: true,
                noCloseOnEsc: true,
                centered: true,
                okVariant: 'outline-danger',
                okTitle: 'Удалить',
                cancelTitle: 'Нет'
              })
      if (!asq) {
        return;
      }

      const data = new FormData();
      await Axios.post(`/object/delete/${id}`,
          data, {
            headers: {
              'X-CSRF-Token': this.csrf,
            },
          }).then((res) => {
        if (res.data.success) {
          this.getObject();
        }
      });
    },
    async getCntRealEstate() {
      await Axios.get('/api/objects/cnt-real-estate', {
        params: {
          id_org: this.id_org
        }
      }).then(res => this.cntRs = res.data ** 1)
    },
    async getDocTypes() {
      await Axios.get(`/api/get-doc-types/${this.id_org}`).then((res) => {
        this.docTypes = res.data;
        this.docTypes = this.docTypes.map((item) => ({...item, ...{progress: 0, fileName: null, delButton: true}}));
      });
    },
    async getObjCnt() {

      if (this.id_org) {
        await Axios.get(`/api/cnt-objects/org/${this.id_org}`).then((res) => this.objCnt = res.data);
      }
    },
    async getObject() {
      await Axios.get(`/api/objects/org/${this.id_org}`).then((res) => {
        this.objects = res.data;
      });
    },
    async getOrg() {
      await Axios.get(`/api/organization/by-id/${this.id_org}`).then((res) => {
        this.organization = {...res.data, ...res.data.organization};
      });
    },
    async getRegions() {
      await Axios.get('/api/regions').then((response) => {
        response.data.forEach((item) => {
          this.regions.push({
            value: item.id,
            text: item.region,
          });
        });
      });
    },
    async getUser() {
      await Axios.get('/api/user/current').then((res) => {
        this.user = res.data;
        this.user.isAdmin = !!res.data.roles.root || !!res.data.roles.admin
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

    async saveFile(item, index) {
      if (item.server_file) {
        const size = (item.server_file.size / 1024) / 1024;

        if (size > 20) {
          item.server_file = null;
          this.showModal();
          const n = (`fileInput${index}`);
          if (this.$refs[n].length) {
            this.$refs[n][0].reset();
          } else this.$refs[n].reset();
        }
        if (item.server_file) {
          const data = new FormData();
          data.append('desc', item.descriptor.desc);
          data.append(item.descriptor.desc, item.server_file);
          item.fileName = item.server_file.name;
          item.delButton = false;
          await Axios.post(`/organization/set-org-files/${this.id_org}`, data, {
            onUploadProgress: (e) => {
              item.progress = Math.round((e.loaded * 100) / e.total);
            },
            headers: {
              'X-CSRF-Token': this.csrf,
            },
          }).then(() => {
            const i = this.docTypes.findIndex((item2) => item2.descriptor.desc === item.descriptor.desc);
            if (i !== -1) {
              this.docTypes[i].file = item.server_file;
              item.server_file = null;
              setTimeout(() => {
                item.fileName = null;
                item.delButton = true;
              }, 2000);
            }
          });
        }
      }
    },
    async update() {
      await this.getOrg();
      await this.getUserInfo();
      await this.getObject();
      await this.getDocTypes();
      await this.getObjCnt();
      await this.getCntRealEstate();
      await this.getRegions();
    },
    async addObject() {
      let object = {
        address: null,
        doc_number: null,
        exp_date: null,
        flat_plan: null,
        flat_type: null,
        id: null,
        name: this.objName,
        id_region: this.objIdRegion,
        kad_number: null,
        money_bud_sub: null,
        money_faip: null,
        money_vneb: null,
        rec_money_bud_sub: null,
        rec_money_faip: null,
        rec_money_vneb: null,
        ob_fin_stroy: null,
        osn_isp: null,
        prib_type: null,
        reconstruct: null,
        reg_zap: null,
        smet: null,
        stroy_date_end: null,
        stroy_date_start: null,
        ustav_dey: null,
        id_realEstate: null,
        date_start_reconstruct: null,
        date_end_reconstruct: null,
        reason: null,
        uslovie: null,
        nevos_reason: null,
        pandus: null,
        mech_por: null,
        sanusel: null,
        signal: null,
        pokr: null,
        vives: null,
        min_per: null,
        max_per: null,
      };
      this.objName = null;
      this.objIdRegion = null;
      this.modal_show = false;

      const data = new FormData();
      data.append('object', JSON.stringify(object));
      await Axios.post(`/object/create/${this.id_org}`,
          data, {
            headers: {
              'X-CSRF-Token': this.csrf,
            },
          }).then((res) => {
        if (res.data.success) {
          this.getObject();
        }
      });
    },

    canChange() {
      return window.Permission === 'user' || window.Permission === 'root'
    },
    downFile: id => window.location.href = `/app/documents/get-doc?id=${id}`,
    goto() {
      if (!Number(this.cntRs))
        this.modal_show = !this.modal_show;
      else
        window.location.href = 'https://xn--b1adcgjb2abq4al4j.xn--80apneeq.xn--p1ai/real-estate/add'
    },
    goToObject(object) {
      this.goTo(
          this.user.isAdmin ?
              `/admin/objects-info/${this.id_org}/${object.id}` :
              `/objects-info/${object.id}`
      );
    }
  },
  computed: {
    orgCntCol() {
      return this.toNum(this.organization.count_pol) * 100 / this.toNum(this.organization.full_count_pol);
    },
    getCountObjectsWhereCountPol() {
      let count = 0;
      for (let i = 0; i < this.objects.length; i++) {
        if (Number(this.objects[i].count_pol) !== Number(this.objects[i].const_count_pol)) count++;
      }
      return count;
    },
    getCountObjectsWhereUstavDey() {
      let count = 0;
      for (let i = 0; i < this.objects.length; i++) {
        if (Number(this.objects[i].ustav_dey) === 1) count++;
      }
      return count;
    },
    getCountFiles() {
      let count = 0;
      for (let i = 0; i < this.docTypes.length; i++) {
        if (this.docTypes[i].file !== null) count++;
      }
      return count;
    },
    getCountUsersInfo() {
      let count = 0;
      for (let i = 0; i < this.users_info.length; i++) {
        if (this.users_info[i].email !== null || this.users_info[i].name !== null || this.users_info[i].phone !== null || this.users_info[i].position !== null) count++;
      }
      return count;
    },
  },
  mixins: [mainMixin]
};
</script>

<style scoped>
.boxer {
  width: 55px;
  height: 55px;
  display: flex;
  justify-content: center;
  align-items: center;
  border: 3px solid #e6e9f0;
  border-radius: 100%;
  transition: all ease 1000ms;
}

.boxer:hover > i  {
  color: #cd000a;
}
.boxer.no {
  border: none !important;
}

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


.shadow {
  box-shadow: 0 0 10px; /* Параметры тени */
}

.trash-icon {
  color: red;
  transform: scale(1);
  transition: all .3s ease;
}

.input {
  z-index: 0 !important;
}

.trash-icon:hover {
  transform: scale(1.3);
  transition: all .3s ease;
}
</style>