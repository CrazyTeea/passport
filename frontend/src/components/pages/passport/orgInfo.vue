<template>
  <div id="org-info-page">

    <v-page>
      <div v-if="componentReady && organization" class="container">

        <org-select link="/api/organizations/all" error-msg="нет доступных организаций по заданным критериаям"
                    label="Выбранная организация" v-if="$check(['admin','root'])" v-model="id_org"/>

        <h3>Шаг 1: Сведения об организации</h3>


        <stepper
            :back-url="user.isAdmin ? `/admin/data/${id_org}` : '/main'"
            :to-url="user.isAdmin ? `/admin/area-info/${id_org}` : '/area-info'"
            percent="20"
            end-button-label="Далее"
            @save-page="savePage"
        />
        <hr>

        <label class="font-weight-bold">Полное наименование организации:</label>
        {{ organization.name }}
        <br>
        <label class="font-weight-bold">Сокращенное наименование организации:</label>
        {{ organization.short_name }}
        <br>
        <label class="font-weight-bold">Подчинение федеральному органу исполнительной власти: </label>
        {{ organization.founder.founder }}
        <br>
        <label class="font-weight-bold">Регион расположения организации:</label>
        {{ organization.region.region }}

        <hr>

        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Численность обучающихся :</label>
            {{ organization.stud_cnt }}
          </div>
        </div>
        <div class="row mt-2">
          <div class="col">
            <label class="font-weight-bold ml-4">1. Численность обучающихся граждан России :</label>
            {{ organization.stud_cnt_rus }}
          </div>
        </div>

        <b-table-simple fixed v-if="organization.info" class="mt-2" small borderless>
          <b-thead>
            <b-tr>
              <b-th>Численность обучающихся граждан России</b-th>
              <b-th>За счёт средств федерального бюджета</b-th>
              <b-th>За счёт средств бюджета субъекта</b-th>
              <b-th>За счёт средств местного бюджета</b-th>
              <b-th>По договорам об оказании платных образовательных услуг</b-th>
              <b-th>Всего</b-th>
            </b-tr>
          </b-thead>
          <b-tbody>
            <b-tr>
              <b-td>С.П.О.</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_f_b_spo" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_b_s_spo" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_m_b_spo" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_p_u_spo" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="mt-1">
                  {{ organization.info[0].spo_all }}
                </div>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>Бакалавриат</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_f_b_bak" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_b_s_bak" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_m_b_bak" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_p_u_bak" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold ">
                <div class="mt-1">
                  {{ organization.info[0].bak_all }}
                </div>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>Специалитет</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_f_b_spec" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_b_s_spec" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_m_b_spec" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_p_u_spec" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="mt-1">
                  {{ organization.info[0].spec_all }}
                </div>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>Магистратура</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_f_b_mag" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_b_s_mag" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_m_b_mag" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_p_u_mag" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="mt-1">
                  {{ organization.info[0].mag_all }}
                </div>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>Аспирантура</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_f_b_asp" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_b_s_asp" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_m_b_asp" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_p_u_asp" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="mt-1">
                  {{ organization.info[0].asp_all }}
                </div>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>Ординатура</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_f_b_ord" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_b_s_ord" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_m_b_ord" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_p_u_ord" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="mt-1">
                  {{ organization.info[0].ord_all }}
                </div>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>По иным п.о</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_f_b_in" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_b_s_in" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_m_b_in" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[0].s_p_u_in" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="mt-1">
                  {{ organization.info[0].in_all }}
                </div>

              </b-td>
            </b-tr>
            <b-tr>
              <b-th>Всего</b-th>
              <b-td class="font-weight-bold">
                <div class="ml-3">
                  {{ organization.info[0].s_f_b_all }}
                </div>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="ml-3">
                  {{ organization.info[0].s_b_s_all }}
                </div>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="ml-3">
                  {{ organization.info[0].s_m_b_all }}
                </div>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="ml-3">
                  {{ organization.info[0].s_p_u_all }}
                </div>
              </b-td>
              <b-td class="font-weight-bold">
                <!--{{ organization.info[0].all }}--><!--{{ organization.info[0].all }}-->
              </b-td>
            </b-tr>
          </b-tbody>
        </b-table-simple>

        <div class="row mt-5">
          <div class="col-10">
            <label class="font-weight-bold ml-4">2. Численность обучающихся иностранцев: </label>
            {{ organization.stud_cnt_foreign }}
          </div>
        </div>

        <b-table-simple v-if="organization.info" fixed class="mt-2" small borderless>
          <b-thead>
            <b-tr>
              <b-th>Численность обучающихся иностранцев</b-th>
              <b-th>За счёт средств федерального бюджета</b-th>
              <b-th>За счёт средств бюджета субъекта</b-th>
              <b-th>За счёт средств местного бюджета</b-th>
              <b-th>По договорам об оказании платных образовательных услуг</b-th>
              <b-th>Всего</b-th>
            </b-tr>
          </b-thead>
          <b-tbody>
            <b-tr>
              <b-td>С.П.О.</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_f_b_spo" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_b_s_spo" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_m_b_spo" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_p_u_spo" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="mt-1">
                  {{ organization.info[1].spo_all }}
                </div>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>Бакалавриат</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_f_b_bak" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_b_s_bak" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_m_b_bak" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_p_u_bak" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="mt-1">
                  {{ organization.info[1].bak_all }}
                </div>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>Специалитет</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_f_b_spec" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_b_s_spec" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_m_b_spec" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_p_u_spec" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="mt-1">
                  {{ organization.info[1].spec_all }}
                </div>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>Магистратура</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_f_b_mag" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_b_s_mag" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_m_b_mag" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_p_u_mag" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="mt-1">
                  {{ organization.info[1].mag_all }}
                </div>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>Аспирантура</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_f_b_asp" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_b_s_asp" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_m_b_asp" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_p_u_asp" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="mt-1">
                  {{ organization.info[1].asp_all }}
                </div>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>Ординатура</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_f_b_ord" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_b_s_ord" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_m_b_ord" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_p_u_ord" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="mt-1">
                  {{ organization.info[1].ord_all }}
                </div>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>По иным п.о</b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_f_b_in" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_b_s_in" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_m_b_in" :disabled="blockSave"/>
              </b-td>
              <b-td>
                <b-form-input type="number" v-model="organization.info[1].s_p_u_in" :disabled="blockSave"/>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="mt-1">
                  {{ organization.info[1].in_all }}
                </div>
              </b-td>
            </b-tr>
            <b-tr>
              <b-th>Всего</b-th>
              <b-td class="font-weight-bold">
                <div class="ml-3">
                  {{ organization.info[1].s_f_b_all }}
                </div>

              </b-td>
              <b-td class="ml-2 font-weight-bold">
                <div class="ml-3">
                  {{ organization.info[1].s_b_s_all }}
                </div>
              </b-td>
              <b-td class="ml-2 font-weight-bold">
                <div class="ml-3">
                  {{ organization.info[1].s_m_b_all }}
                </div>
              </b-td>
              <b-td class="font-weight-bold">
                <div class="ml-3">
                  {{ organization.info[1].s_p_u_all }}
                </div>
              </b-td>
              <b-td class="font-weight-bold">
                <!--  <div class="mt-1">
                  {{ organization.info[1].all }}
                  </div>-->
              </b-td>
            </b-tr>
          </b-tbody>
        </b-table-simple>
        <hr>

        <div class="text-center">
          <button class="btn btn-primary" type="button" @click="setZeros()">Заполнить нулями пустые поля</button>
          <hr>
        </div>

        <stepper
            :back-url="user.isAdmin ? `/admin/data/${id_org}` : '/main'"
            :to-url="user.isAdmin ? `/admin/area-info/${id_org}` : '/area-info'"
            percent="20"
            end-button-label="Далее"
            @save-page="savePage"
        />
        <br>
      </div>
      <loading v-else/>
    </v-page>
    <scroll-button/>
  </div>

</template>

<script>
import {BFormInput, BTableSimple, BTbody, BTd, BTh, BThead, BTr,} from 'bootstrap-vue';
import Axios from 'axios';

import scrollButton from '../../organisms/scrollButton';
import OrgSelect from "../../organisms/orgSelect";
import {mainMixin} from "../../mixins";
import Loading from "../../organisms/loading";
import Stepper from "../../organisms/stepper";
import VPage from "../../organisms/vPage";

export default {
  async mounted() {
    await this.getUser();
    if (this.user.isAdmin)
      this.id_org = this.$route.fullPath.split('/')[3] || this.user.id_org
    else this.id_org = this.user.id_org;

    //this.blockSave = this.user.isAdmin;

    await this.getOrg();
    this.componentReady = true;
  },
  components: {
    VPage,
    Stepper,
    Loading,
    BFormInput,
    BTableSimple,
    BTbody,
    BTd,
    BTh,
    BThead,
    BTr,
    OrgSelect,
    scrollButton
  },
  data() {
    return {
      csrf: document.getElementsByName('csrf-token')[0].content,
      blockSave: false,
      user: {},
      students: [],

      inputs: [
        's_b_s_asp', 's_b_s_bak', 's_b_s_in', 's_b_s_mag', 's_b_s_ord', 's_b_s_spec',
        's_b_s_spo', 's_f_b_asp', 's_f_b_bak', 's_f_b_in', 's_f_b_mag', 's_f_b_ord', 's_f_b_spec', 's_f_b_spo',
        's_m_b_asp', 's_m_b_bak', 's_m_b_in', 's_m_b_mag', 's_m_b_ord', 's_m_b_spec', 's_m_b_spo', 's_p_u_asp',
        's_p_u_bak', 's_p_u_in', 's_p_u_mag', 's_p_u_ord', 's_p_u_spec', 's_p_u_spo'
      ],

      id_org: null,
      students_foreign: [],
      organization: {
        founder: {
          founder: '',
        },
        region: {
          region: '',
        },
      },
      componentReady: false,
    };
  },


  methods: {

    validate() {
      if (!this.organization.hasOwnProperty('info'))
        return false

      for (let i = 0; i < this.inputs.length; i++) {
        let item = this.inputs[i];
        if (this.isEmpty(this.organization.info[0][item]))
          return false;
        if (this.isEmpty(this.organization.info[1][item]))
          return false;
      }
      return true;
    },

    async getOrg() {
      await Axios.get(`/api/organization/by-id/${this.id_org}`).then((res) => {
        this.organization = res.data;
        this.organization = {...this.organization, ...res.data.organization};
        this.organization.info = [{}, {}]
        if (res.data.info) {
          res.data.info.forEach((item) => {
            this.organization.info[parseInt(item.stud_type)] = item;
          });
        }
        this.organization.info[0].stud_type = 0;
        this.organization.info[1].stud_type = 1;

      });
    },
    async getUser() {
      await Axios.get('/api/user/current').then((res) => {
        this.user = res.data;
        this.user.isAdmin = !!res.data.roles.root || !!res.data.roles.admin
      });
    },
    async savePage(validate,resolve) {

      if (validate && !this.validate()) {
        await this.$bvModal.msgBoxOk("Для сохранения необходимо заполнить пустые поля.")
        resolve(false)
        return;
      }

      const data = new FormData();
      data.append('org', JSON.stringify(this.organization));
      await Axios.post(`/organization/set-org-info/${this.id_org}`, data, {
        headers: {'X-CSRF-Token': this.csrf},
      })

      resolve(true)

    },
    setZeros() {

      this.inputs.forEach(item => {
        if (this.isEmpty(this.organization.info[0][item]))
          this.organization.info[0][item] = 0;
        if (this.isEmpty(this.organization.info[1][item]))
          this.organization.info[1][item] = 0;
      })

      this.$forceUpdate()

    },
    cntInfo(index) {

      if (this.organization.info[index]) {
        this.organization.info[index].spo_all = ~~parseInt(this.organization.info[index].s_f_b_spo)
            + ~~parseInt(this.organization.info[index].s_b_s_spo)
            + ~~parseInt(this.organization.info[index].s_m_b_spo)
            + ~~parseInt(this.organization.info[index].s_p_u_spo);
        this.organization.info[index].bak_all = ~~parseInt(this.organization.info[index].s_f_b_bak)
            + ~~parseInt(this.organization.info[index].s_b_s_bak)
            + ~~parseInt(this.organization.info[index].s_m_b_bak)
            + ~~parseInt(this.organization.info[index].s_p_u_bak);
        this.organization.info[index].spec_all = ~~parseInt(this.organization.info[index].s_f_b_spec)
            + ~~parseInt(this.organization.info[index].s_b_s_spec)
            + ~~parseInt(this.organization.info[index].s_m_b_spec)
            + ~~parseInt(this.organization.info[index].s_p_u_spec);
        this.organization.info[index].mag_all = ~~parseInt(this.organization.info[index].s_f_b_mag)
            + ~~parseInt(this.organization.info[index].s_b_s_mag)
            + ~~parseInt(this.organization.info[index].s_m_b_mag)
            + ~~parseInt(this.organization.info[index].s_p_u_mag);
        this.organization.info[index].asp_all = ~~parseInt(this.organization.info[index].s_f_b_asp)
            + ~~parseInt(this.organization.info[index].s_b_s_asp)
            + ~~parseInt(this.organization.info[index].s_m_b_asp)
            + ~~parseInt(this.organization.info[index].s_p_u_asp);
        this.organization.info[index].ord_all = ~~parseInt(this.organization.info[index].s_f_b_ord)
            + ~~parseInt(this.organization.info[index].s_b_s_ord)
            + ~~parseInt(this.organization.info[index].s_m_b_ord)
            + ~~parseInt(this.organization.info[index].s_p_u_ord);
        this.organization.info[index].in_all = ~~parseInt(this.organization.info[index].s_f_b_in)
            + ~~parseInt(this.organization.info[index].s_b_s_in)
            + ~~parseInt(this.organization.info[index].s_m_b_in)
            + ~~parseInt(this.organization.info[index].s_p_u_in);
        this.organization.info[index].all = ~~parseInt(this.organization.info[index].in_all)
            + ~~parseInt(this.organization.info[index].ord_all)
            + ~~parseInt(this.organization.info[index].asp_all)
            + ~~parseInt(this.organization.info[index].mag_all)
            + ~~parseInt(this.organization.info[index].spec_all)
            + ~~parseInt(this.organization.info[index].bak_all)
            + ~~parseInt(this.organization.info[index].spo_all);
        this.organization.info[index].s_f_b_all = ~~parseInt(this.organization.info[index].s_f_b_spo)
            + ~~parseInt(this.organization.info[index].s_f_b_bak)
            + ~~parseInt(this.organization.info[index].s_f_b_spec)
            + ~~parseInt(this.organization.info[index].s_f_b_mag)
            + ~~parseInt(this.organization.info[index].s_f_b_asp)
            + ~~parseInt(this.organization.info[index].s_f_b_ord)
            + ~~parseInt(this.organization.info[index].s_f_b_in);
        this.organization.info[index].s_b_s_all = ~~parseInt(this.organization.info[index].s_b_s_spo)
            + ~~parseInt(this.organization.info[index].s_b_s_bak)
            + ~~parseInt(this.organization.info[index].s_b_s_spec)
            + ~~parseInt(this.organization.info[index].s_b_s_mag)
            + ~~parseInt(this.organization.info[index].s_b_s_asp)
            + ~~parseInt(this.organization.info[index].s_b_s_ord)
            + ~~parseInt(this.organization.info[index].s_b_s_in);
        this.organization.info[index].s_m_b_all = ~~parseInt(this.organization.info[index].s_m_b_spo)
            + ~~parseInt(this.organization.info[index].s_m_b_bak)
            + ~~parseInt(this.organization.info[index].s_m_b_spec)
            + ~~parseInt(this.organization.info[index].s_m_b_mag)
            + ~~parseInt(this.organization.info[index].s_m_b_asp)
            + ~~parseInt(this.organization.info[index].s_m_b_ord)
            + ~~parseInt(this.organization.info[index].s_m_b_in);
        this.organization.info[index].s_p_u_all = ~~parseInt(this.organization.info[index].s_p_u_spo)
            + ~~parseInt(this.organization.info[index].s_p_u_bak)
            + ~~parseInt(this.organization.info[index].s_p_u_spec)
            + ~~parseInt(this.organization.info[index].s_p_u_mag)
            + ~~parseInt(this.organization.info[index].s_p_u_asp)
            + ~~parseInt(this.organization.info[index].s_p_u_ord)
            + ~~parseInt(this.organization.info[index].s_p_u_in);
      }


    }
  },
  mixins: [mainMixin],
  watch: {
    async id_org() {
      if (this.componentReady) await this.getOrg()
    },
    organization: {
      handler() {
        this.cntInfo(0);
        this.cntInfo(1);

        this.organization.stud_cnt_rus = ~~parseInt(this.organization.info[0]?.all);
        this.organization.stud_cnt_foreign = ~~parseInt(this.organization.info[1]?.all);

        this.organization.stud_cnt = ~~parseInt(this.organization.stud_cnt_rus)
            + ~~parseInt(this.organization.stud_cnt_foreign);
      },
      deep: true,
    },
  }
};
</script>

<style scoped/>