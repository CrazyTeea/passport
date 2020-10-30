<template>
  <div>
    <nav-bar :is-admin="user.isAdmin" :id_org="id_org" v-on:save-page="saveObject" v-on:block-save="blockSave = !blockSave"/>
    <transition enter-active-class="animated fadeInUp">
      <div v-if="componentReady" class="container">


        <org-select v-can:admin,root v-model="id_org"/>

        <div class="rov">
          <div class="col-8">
            <h4>Сведения о тарифах установленных для проживания в жилом объекте</h4>
          </div>
        </div>

        <div class="row">
          <div class="col-6"><label>Наименование жилого объекта</label></div>
          <div class="col-6">
            <b-form-select @change="setObject" :options="objectsTitle"/>
          </div>
        </div>

        <b-button v-if="!blockSave" :to="{name:'object',params:{modalShow:true}}" variant="outline-secondary">Добавить
          объект
        </b-button>
        <hr>
        <transition enter-active-class="animated fadeIn">
          <b-table-simple fixed v-if="currentObject" borderless style="line-height: 14px;">
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
                <b-td>Для обучающиеся за счёт бюджетных средств</b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.u_t_b" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.k_u_b" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.p_p_b" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.d_u_b" :disabled="blockSave"/>
                </b-td>
              </b-tr>
              <b-tr>
                <b-td>Для обучающиеся по договорам об оказании платных обр. услуг</b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.u_t_p" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.k_u_p" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.p_p_p" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.d_u_p" :disabled="blockSave"/>
                </b-td>
              </b-tr>
              <b-tr>
                <b-td>Для лиц не являющимися гражданами России</b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.u_t_nr" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.k_u_nr" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.p_p_nr" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.d_u_nr" :disabled="blockSave"/>
                </b-td>
              </b-tr>
              <b-tr>
                <b-td>Для обучающихся других образовательных организаций</b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.u_t_do" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.k_u_do" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.p_p_do" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.d_u_do" :disabled="blockSave"/>
                </b-td>
              </b-tr>
              <b-tr>
                <b-td>Для иных нанимателей</b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.u_t_in" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.k_u_in" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.p_p_in" :disabled="blockSave"/>
                </b-td>
                <b-td>
                  <b-form-input type="number" v-model="currentObject.tariff.d_u_in" :disabled="blockSave"/>
                </b-td>
              </b-tr>
            </b-tbody>
          </b-table-simple>
        </transition>

      </div>
    </transition>
    <scroll-button/>

  </div>
</template>

<script>
import {BButton, BFormInput, BFormSelect, BTableSimple, BTbody, BTd, BTh, BThead, BTr,} from 'bootstrap-vue';
import Axios from 'axios';
import NavBar from '../../organisms/NavBar';
import scrollButton from '../../organisms/scrollButton';
import OrgSelect from "../../organisms/orgSelect";

export default {
  name: 'object_tariff',
  components: {
    OrgSelect,
    scrollButton,
    NavBar,
    BButton,
    BFormSelect,
    BFormInput,
    BThead,
    BTh,
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

    this.blockSave = this.user.isAdmin;

    await this.getObject();

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
        text: item.name,
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
      await Axios.get(`/api/objects/org/${this.id_org}`).then((res) => {
        this.objects = res.data;
        this.objects.forEach((item) => {
          if (!item.tariff) {
            item.tariff = {};
          }
        });
      });
    },
    async saveObject() {
      const data = new FormData();
      data.append('tariff', JSON.stringify(this.currentObject.tariff));
      Axios.post(`/object/set-tariff/${this.currentObject.id}`, data, {
        headers: {
          'X-CSRF-Token': this.csrf,
        },
      }).then((res) => {
        if (res.data.success) this.getObject();
      }).finally(() => {
        this.blockSave = true;
      });
    },
  },
  data() {
    return {
      blockSave: false,
      csrf: document.getElementsByName('csrf-token')[0].content,
      componentReady: false,
      currentObject: null,
      id_org: 0,
      objectsTitle: [],
      objects: [],
      user: {},
    };
  },
};
</script>

<style scoped>

</style>
