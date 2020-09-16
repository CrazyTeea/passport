<template>

  <div id="org-info-page">
    <nav-bar v-on:save-page="savePage" v-on:block-save="blockSave = !blockSave"/>
    <transition enter-active-class="animated fadeInUp">
      <div v-if="componentReady && organization" class="container">
        <h3>Сведения об организации</h3>
        <hr>
        <label class="font-weight-bold">Полное наименование организации"</label>
          {{ organization.name }}
        <br>
        <label class="font-weight-bold">Сокращенное наименование организации"</label>
          {{ organization.short_name }}
        <br>
        <label class="font-weight-bold">Подчинение федеральному органу исполнительной власти" </label>
          {{ organization.founder.founder }}
        <br>
        <label class="font-weight-bold">Регион расположения организации</label>
          {{ organization.region.region }}


        <hr>

        <div class="row">
          <div class="col">
            <label class="font-weight-bold" for="students_count-input">Численность обучающихся :</label>
            {{ organization.stud_cnt }}
          </div>
        </div>
        <div class="row mt-2">
          <div class="col">
            <label class="font-weight-bold ml-4" for="students_count_rus-input">1. Численность обучающихся граждан России :</label>
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
              <b-th>Спо</b-th>
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
              <b-td>По иным о.п.</b-td>
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
                {{organization.info[0].s_f_b_all}}
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
            <label class="font-weight-bold ml-4" for="students_count_foreign-input">2. Численность обучающихся иностранцев: </label>
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
              <b-td>Спо</b-td>
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
              <b-td>По иным о.п.</b-td>
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


      </div>
    </transition>
    <scroll-button/>
  </div>

</template>

<script>
import NavBar from "../../organisms/NavBar";
import {BFormGroup, BFormInput, BTableSimple, BTbody, BTd, BTh, BThead, BTr} from 'bootstrap-vue'
import Axios from "axios";
import scrollButton from "../../organisms/scrollButton";

export default {
  data() {
    return {
      csrf: document.getElementsByName("csrf-token")[0].content,
      blockSave: false,
      user: {},
      students: [],
      students_foreign: [],
      organization: {
        founder: {
          founder: ''
        },
        region: {
          region: ''
        }
      },
      componentReady: false
    }
  },
  watch: {
    organization: {
      handler() {

        this.cntInfo(0);
        this.cntInfo(1);


        this.organization.stud_cnt_rus = ~~parseInt(this.organization.info[0].all)
        this.organization.stud_cnt_foreign = ~~parseInt(this.organization.info[1].all)

        this.organization.stud_cnt =
            ~~parseInt(this.organization.stud_cnt_rus) +
            ~~parseInt(this.organization.stud_cnt_foreign)
      },
      deep: true
    }
  },
  components: {
    scrollButton,
    NavBar,
    BFormGroup,
    BFormInput,
    BThead, BTbody,
    BTableSimple,
    BTh, BTr, BTd
  },
  async mounted() {
    await this.getUser();
    this.id_org = this.user.id_org
    await this.getOrg()
    this.componentReady = true;
  },
  methods: {
    cntInfo(index) {
      this.organization.info[index].spo_all =
          ~~parseInt(this.organization.info[index].s_f_b_spo) +
          ~~parseInt(this.organization.info[index].s_b_s_spo) +
          ~~parseInt(this.organization.info[index].s_m_b_spo) +
          ~~parseInt(this.organization.info[index].s_p_u_spo)
      this.organization.info[index].bak_all =
          ~~parseInt(this.organization.info[index].s_f_b_bak) +
          ~~parseInt(this.organization.info[index].s_b_s_bak) +
          ~~parseInt(this.organization.info[index].s_m_b_bak) +
          ~~parseInt(this.organization.info[index].s_p_u_bak)
      this.organization.info[index].spec_all =
          ~~parseInt(this.organization.info[index].s_f_b_spec) +
          ~~parseInt(this.organization.info[index].s_b_s_spec) +
          ~~parseInt(this.organization.info[index].s_m_b_spec) +
          ~~parseInt(this.organization.info[index].s_p_u_spec)
      this.organization.info[index].mag_all =
          ~~parseInt(this.organization.info[index].s_f_b_mag) +
          ~~parseInt(this.organization.info[index].s_b_s_mag) +
          ~~parseInt(this.organization.info[index].s_m_b_mag) +
          ~~parseInt(this.organization.info[index].s_p_u_mag)
      this.organization.info[index].asp_all =
          ~~parseInt(this.organization.info[index].s_f_b_asp) +
          ~~parseInt(this.organization.info[index].s_b_s_asp) +
          ~~parseInt(this.organization.info[index].s_m_b_asp) +
          ~~parseInt(this.organization.info[index].s_p_u_asp)
      this.organization.info[index].ord_all =
          ~~parseInt(this.organization.info[index].s_f_b_ord) +
          ~~parseInt(this.organization.info[index].s_b_s_ord) +
          ~~parseInt(this.organization.info[index].s_m_b_ord) +
          ~~parseInt(this.organization.info[index].s_p_u_ord)
      this.organization.info[index].in_all =
          ~~parseInt(this.organization.info[index].s_f_b_in) +
          ~~parseInt(this.organization.info[index].s_b_s_in) +
          ~~parseInt(this.organization.info[index].s_m_b_in) +
          ~~parseInt(this.organization.info[index].s_p_u_in)
      this.organization.info[index].all =
          ~~parseInt(this.organization.info[index].in_all) +
          ~~parseInt(this.organization.info[index].ord_all) +
          ~~parseInt(this.organization.info[index].asp_all) +
          ~~parseInt(this.organization.info[index].mag_all) +
          ~~parseInt(this.organization.info[index].spec_all) +
          ~~parseInt(this.organization.info[index].bak_all) +
          ~~parseInt(this.organization.info[index].spo_all)
      this.organization.info[index].s_f_b_all =
          ~~parseInt(this.organization.info[index].s_f_b_spo) +
          ~~parseInt(this.organization.info[index].s_f_b_bak) +
          ~~parseInt(this.organization.info[index].s_f_b_spec) +
          ~~parseInt(this.organization.info[index].s_f_b_mag) +
          ~~parseInt(this.organization.info[index].s_f_b_asp) +
          ~~parseInt(this.organization.info[index].s_f_b_ord) +
          ~~parseInt(this.organization.info[index].s_f_b_in)
      this.organization.info[index].s_b_s_all =
          ~~parseInt(this.organization.info[index].s_b_s_spo) +
          ~~parseInt(this.organization.info[index].s_b_s_bak) +
          ~~parseInt(this.organization.info[index].s_b_s_spec) +
          ~~parseInt(this.organization.info[index].s_b_s_mag) +
          ~~parseInt(this.organization.info[index].s_b_s_asp) +
          ~~parseInt(this.organization.info[index].s_b_s_ord) +
          ~~parseInt(this.organization.info[index].s_b_s_in)
      this.organization.info[index].s_m_b_all =
          ~~parseInt(this.organization.info[index].s_m_b_spo) +
          ~~parseInt(this.organization.info[index].s_m_b_bak) +
          ~~parseInt(this.organization.info[index].s_m_b_spec) +
          ~~parseInt(this.organization.info[index].s_m_b_mag) +
          ~~parseInt(this.organization.info[index].s_m_b_asp) +
          ~~parseInt(this.organization.info[index].s_m_b_ord) +
          ~~parseInt(this.organization.info[index].s_m_b_in)
      this.organization.info[index].s_p_u_all =
          ~~parseInt(this.organization.info[index].s_p_u_spo) +
          ~~parseInt(this.organization.info[index].s_p_u_bak) +
          ~~parseInt(this.organization.info[index].s_p_u_spec) +
          ~~parseInt(this.organization.info[index].s_p_u_mag) +
          ~~parseInt(this.organization.info[index].s_p_u_asp) +
          ~~parseInt(this.organization.info[index].s_p_u_ord) +
          ~~parseInt(this.organization.info[index].s_p_u_in)
    },
    async getUser() {
      await Axios.get('/api/user/current').then(res => {
        this.user = res.data;
      });
    },
    async getOrg() {
      await Axios.get(`/api/organization/by-id/${this.id_org}`).then(res => {
            this.organization = res.data;
            this.organization = {...this.organization, ...res.data.organization};
            if (res.data.info) {
              res.data.info.forEach(item => {
                this.organization.info[parseInt(item.stud_type)] = item;
              })
            }
            this.organization.info = res.data.info || {};
          }
      );
    },
    async savePage() {
      let data = new FormData();
      data.append('org', JSON.stringify(this.organization));
      await Axios.post(`/organization/set-org-info/${this.id_org}`, data, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(res => {
        this.getOrg()
        console.log(res.data);
      }).finally(() => {
        this.blockSave = true;
      })
    }
  }

}
</script>

<style scoped>

</style>