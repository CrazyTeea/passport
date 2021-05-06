<template>
  <div>
    <!--<nav-bar :is-admin="user.isAdmin" :id_org="id_org" v-on:save-page="saveObject"
             v-on:block-save="blockSave = !blockSave"/>-->
    <v-page>
      <div v-if="componentReady" class="container">
        <org-select link="/api/organizations/all" error-msg="нет доступных организаций по заданным критериаям"
                    label="Выбранная организация" v-if="$check(['admin','root'])" v-model="id_org"/>

        <h3>Шаг 4: Сведения о тарифах, установленных для проживания в жилом объекте</h3>

        <div v-if="currentObject">

          <stepper
              :back-url="user.isAdmin ?
          `/admin/objects-money/${id_org}/${$route.params.id_object}` :
          `/objects-money/${$route.params.id_object}`"
              :to-url="user.isAdmin ?
          `/admin/objects-end/${id_org}/${$route.params.id_object}` :
          `/objects-end/${$route.params.id_object}`"
              percent="100"
              end-button-label="Далее"
              @save-page="savePage"
          />
          <hr>
          <b-alert variant="danger" show>
            <money-icon/>
            <span style="font-size: 1.2rem">Поля должны быть заполнены в рублях.</span>
          </b-alert>

          <transition enter-active-class="animated fadeIn">
            <b-table-simple fixed borderless style="line-height: 14px;">
              <b-thead>
                <b-tr>
                  <b-th>Размер платы в рублях</b-th>
                  <b-th>За коммунальные услуги с учетом усредненных тарифов</b-th>
                  <b-th>За коммунальные услуги (по показаниям приборов учета)</b-th>
                  <b-th>За пользование жилым помещением</b-th>
                  <b-th>За дополнительные услуги (комфортность, иное)</b-th>
                </b-tr>
              </b-thead>
              <b-tbody>
                <b-tr>
                  <b-td>Для обучающихся за счёт бюджетных средств</b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.u_t_b" :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.k_u_b" :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.p_p_b" :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.d_u_b" :disabled="blockSave"/>
                  </b-td>
                </b-tr>
                <b-tr>
                  <b-td>Для обучающихся по договорам об оказании платных обр. услуг</b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.u_t_p" :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.k_u_p" :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.p_p_p" :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.d_u_p" :disabled="blockSave"/>
                  </b-td>
                </b-tr>
                <b-tr>
                  <b-td>Для лиц не являющимися гражданами России</b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.u_t_nr"
                                  :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.k_u_nr"
                                  :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.p_p_nr"
                                  :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.d_u_nr"
                                  :disabled="blockSave"/>
                  </b-td>
                </b-tr>
                <b-tr>
                  <b-td>Для обучающихся других образовательных организаций</b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.u_t_do"
                                  :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.k_u_do"
                                  :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.p_p_do"
                                  :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.d_u_do"
                                  :disabled="blockSave"/>
                  </b-td>
                </b-tr>
                <b-tr>
                  <b-td>Для иных нанимателей</b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.u_t_in"
                                  :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.k_u_in"
                                  :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.p_p_in"
                                  :disabled="blockSave"/>
                  </b-td>
                  <b-td>
                    <b-form-input type="number" step="0.01" v-model="currentObject.tariff.d_u_in"
                                  :disabled="blockSave"/>
                  </b-td>
                </b-tr>
              </b-tbody>
            </b-table-simple>
          </transition>

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



          <div v-for="(docType,index) in docTypes" :key="index">
            <p v-if="index === 0">
              Локальные нормативные акты, устанавливающие стоимость проживания в общежитии в 2020 году
              или информационное письмо сообщающее о заключении с постояльцами договора найма.
            </p>
            <p class="mt-2" v-if="index === 2">
              Локальные нормативные акты, устанавливающие стоимость проживания в
              общежитии во время короновирусной инфекции (covid-19), если стоимость изменялась.
            </p>
            <b-card border-variant="primary" class="mt-2 shadow rounded">

              <b-card-text>Загрузить документ</b-card-text>
              <b-form-group :label-class="index === 0 ? 'text-danger' : ''" id="fileset-1" label-for="file-1"
                            :label=docType.descriptor.label>
                <b-input-group>
                  <b-form-file v-if="!docType.server_file && !docType.file" v-model="docType.server_file"
                               browse-text="Прикрепить" class="input" placeholder="Файл не выбран"
                               :id="`file-${index}`"
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


        </div>

        <hr>
        <div class="text-center">
          <button class="btn btn-primary" type="button" @click="setZeros()">Заполнить нулями пустые поля</button>
        </div>
        <hr>
      </div>
      <loading v-else/>
    </v-page>


    <scroll-button/>

  </div>
</template>

<script>
import {
  BAlert,
  BButton,
  BCard,
  BCardText,
  BFormFile,
  BFormGroup,
  BFormInput,
  BFormSelect,
  BInputGroup,
  BProgress,
  BTableSimple,
  BTbody,
  BTd,
  BTh,
  BThead,
  BTr,
} from 'bootstrap-vue';
import Axios from 'axios';

import scrollButton from '../../organisms/scrollButton';
import OrgSelect from "../../organisms/orgSelect";
import {mainMixin} from "../../mixins";
import MoneyIcon from "../../organisms/moneyIcon";
import Loading from "../../organisms/loading";
import Stepper from "../../organisms/stepper";
import VPage from "../../organisms/vPage";

export default {
  name: 'object_tariff',
  components: {
    VPage,
    Stepper,
    Loading, BCard,
    MoneyIcon, BCardText,
    OrgSelect, BFormGroup,
    scrollButton,
    BInputGroup,
    BButton, BProgress,
    BFormSelect,
    BFormInput,
    BThead, BFormFile,
    BTh, BAlert,
    BTr,
    BTd,
    BTbody,
    BTableSimple,
  },
  async mounted() {
    await this.getUser();
    if (this.user.isAdmin)
      this.id_org = this.$route.fullPath.split('/')[3] || this.user.id_org
    else this.id_org = this.user.id_org;

    await this.getObject();

    await this.getDocTypes();

    this.componentReady = true;
  },
  watch: {
    async id_org() {
      if (this.componentReady)
        await this.getObject();
    },
    objects() {
      this.objectsTitle = this.objects.map((item, index) => ({
        value: index,
        text: `${item.name} [${item.kad_number}]`,
      }));
    },
  },
  methods: {
    async getUser() {
      await Axios.get('/api/user/current').then((res) => {
        this.user = res.data;
        this.user.isAdmin = !!res.data.roles.root || !!res.data.roles.admin
      });
    },
    setObject(index) {
      this.currentObject = this.objects.find((item, i) => i === index);
    },
    async getObject() {
      await Axios.get(`/api/objects/org/${this.id_org}/${this.$route.params.id_object}`).then((res) => {
        this.currentObject = res.data;
        if (!this.currentObject.tariff) {
          this.currentObject.tariff = {};
        }

      });
    },

    canChange() {
      return window.Permission === 'user' | window.Permission === 'root'
    },
    downFile: id => window.location.href = `/app/documents/get-obj-doc?id=${id}`,
    async deleteFile(item) {
      if (item.file) {
        const data = new FormData();
        data.append('desc', item.descriptor.desc);
        await Axios.post(`/object/del-file/${this.currentObject.id}`, data, {
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
          await Axios.post(`/object/set-obj-files/${this.currentObject.id}`, data, {
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

    validate() {
      for (let i = 0; i < this.inputs.length; i++) {
        let item = this.inputs[i];

        if (this.isEmpty(this.currentObject.tariff[item]))
          return false;
      }
      if (!this.isUser)
        return true;
      if (!this.docTypes.length)
        return false;
      const file = this.docTypes[0];

      return file.server_file || file.file;

    },
    setZeros() {
      this.inputs.forEach(item => {
        if (this.isEmpty(this.currentObject.tariff[item]))
          this.currentObject.tariff[item] = 0;
      })
      this.$forceUpdate()

    },

    async getDocTypes() {
      await Axios.get(`/api/get-obj-doc-types/${this.currentObject.id}`).then((res) => {
        this.docTypes = res.data;
        this.docTypes = this.docTypes.map((item) => ({...item, ...{progress: 0, fileName: null, delButton: true}}));
      });
    },
    async savePage(validate, resolve) {


      if (validate && !this.validate()) {
        await this.$bvModal.msgBoxOk("Для сохранения необходимо заполнить пустые поля.");
        resolve(false);
        return;
      }
      const data = new FormData();
      data.append('tariff', JSON.stringify(this.currentObject.tariff));
      await Axios.post(`/object/set-tariff/${this.currentObject.id}`, data, {
        headers: {
          'X-CSRF-Token': this.csrf,
        },
      });
      resolve(true)
    },
  },
  data() {
    return {
      blockSave: false,
      csrf: document.getElementsByName('csrf-token')[0].content,
      componentReady: false,
      currentObject: null,
      id_org: 0,
      docTypes: [],
      isUser: window.Permission === 'user',
      inputs: [
        'u_t_b', 'k_u_b', 'p_p_b', 'd_u_b', 'u_t_p', 'k_u_p', 'p_p_p', 'd_u_p', 'u_t_nr',
        'k_u_nr', 'p_p_nr', 'd_u_nr', 'u_t_do', 'k_u_do', 'p_p_do', 'd_u_do', 'u_t_in',
        'k_u_in', 'p_p_in', 'd_u_in'
      ],
      objectsTitle: [],
      objects: [],
      user: {},
    };
  },
  mixins: [mainMixin]
};
</script>

<style scoped/>