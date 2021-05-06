<template>

  <v-page>
    <div class="container" v-if="componentReady">

      <org-select v-if="$check(['admin','root'])" v-model="id_org" label="Выбранная организация"
                  link="/api/organizations/all"
                  error-msg="нет доступных организаций по заданным критериаям"/>


      <h3>Шаг 5: Сведения о последствиях короновирусной инфекции (covid-19).</h3>
      <hr>

      <b-alert variant="danger" show>
        <money-icon/>
        <span style="font-size: 1.2rem">Поля должны быть заполнены в рублях.</span>
      </b-alert>

      <stepper
          :back-url="user.isAdmin ? `/admin/living-info-inv/${id_org}` : '/living-info-inv'"
          :to-url="user.isAdmin ? `/admin/data/${id_org}` : '/main'"
          percent="100"
          end-button-label="Завершить"
          @save-page="savePage"
      />

      <hr>


      <div class="row">
        <div class="col-6"><label for="covid1">Наличие мер поддержки обучающихся, проживающих в общежитиях,
          в связи с распространением новой коронавирусной инфекции (COVID-19)</label></div>
        <div class="col-6">
          <b-form-select v-model="organization.covid_var1" id="covid1" :options="[
                  {value:0, text:'Нет'},
                  {value:1, text:'Дa'},
                ]"/>
        </div>
      </div>
      <div v-if="organization.covid_var1 === 1 || organization.covid_var1 === '1'" class="row">
        <div id="huy_mest_tooltip" class="col-6">
          <label class="ml-2" for="covid2">Наличие мер поддержки обучающихся, проживающих в общежитиях,
            в связи с распространением новой коронавирусной инфекции (COVID-19)
            <i class="fas fa-question-circle"></i>
          </label>
        </div>
        <div class="col-6">
          <b-form-textarea v-model="organization.covid_var2" id="covid2"/>
        </div>
        <b-tooltip target="huy_mest_tooltip">
          <div class="d-flex min-width">
            <ul>
              <li>Отмена платы за проживание (найм и КУ);</li>
              <li>Отмена платы за проживание (найм и КУ);</li>
              <li>предоставление питания;</li>
              <li>отмена платы за найм;</li>
              <li>перерасчет платы за проживание на период отсутствия студента в общежитии (по заявлению);</li>
              <li>компенсация расходов на проезд к месту проживания (по заявлению);</li>
              <li>выплата материальной поддержки в части компенсации приобретения средств личной гигиены (по заявлению);
              </li>
              <li>иное".</li>
            </ul>
          </div>

        </b-tooltip>
      </div>

      <div v-if="organization.covid_var1 === 1 || organization.covid_var1 === '1'" class="row mt-2">
        <div class="col-6"><label class="ml-2" for="covid_var3">Объем средств, направленных на
          осуществление мер поддержки обучающихся, проживающих в общежитиях,
          в связи с распространением новой коронавирусной инфекции (COVID-19)</label></div>
        <div class="col-6">

          <b-input-group append="рублей">
            <b-form-input v-model="organization.covid_var3" type="number" step="0.01" id="covid_var3"/>
          </b-input-group>



        </div>
      </div>

      <div class="row mt-2">
        <div class="col-6"><label for="covid_var4">Объем недополученных доходов в связи со снижением платы за проживание,
          платы за коммунальные услуги и т.д.,
          в рамках оказания мер поддержки обучающихся в связи с распространением новой коронавирусной инфекции
          (COVID-19)</label></div>
        <div class="col-6">
          <b-input-group append="рублей">
            <b-form-input v-model="organization.covid_var4" type="number" step="0.01" id="covid_var4"/>
          </b-input-group>
        </div>
      </div>

      <div class="row mt-2">
        <div id="huy_mest_tooltip2" class="col-6">
          <label for="covid_var5">Объем средств, затраченных на противоэпидемиологические мероприятия (в соответствии с
            рекомендациями Роспотребнадзора)
            <i class="fas fa-question-circle"></i>
          </label>

        </div>
        <div class="col-6">
          <b-input-group append="рублей">
            <b-form-input v-model="organization.covid_var5" type="number" step="0.01" id="covid_var5"/>
          </b-input-group>
        </div>
        <b-tooltip target="huy_mest_tooltip2">
          Указывается сумма за финансовый год
        </b-tooltip>
      </div>


    </div>
    <loading v-else/>
  </v-page>

</template>

<script>
import Loading from "../../organisms/loading";
import OrgSelect from "../../organisms/orgSelect";
import Axios from "axios";
import MoneyIcon from "../../organisms/moneyIcon";

import {BAlert, BFormInput, BFormSelect, BFormTextarea, BInputGroup, BTooltip} from 'bootstrap-vue';
import Stepper from "../../organisms/stepper";
import {mainMixin} from "../../mixins";
import VPage from "../../organisms/vPage";

export default {
  name: "covid",
  components: {
    VPage,
    Stepper,BInputGroup,
    MoneyIcon, BAlert, BFormSelect, BFormInput,
    OrgSelect, Loading, BFormTextarea, BTooltip
  },
  data() {
    return {
      inputs: ['covid_var1', "covid_var4", "covid_var5"],
      csrf: document.getElementsByName('csrf-token')[0].content,
      id_org: null,
      organization: {
        default: () => Object
      },
      user: {
        default: () => Object
      },
      componentReady: {
        default: () => false
      }
    }
  },
  async mounted() {
    await this.getUser()

    if (this.user.isAdmin)
      this.id_org = this.$route.fullPath.split('/')[3] || this.user.id_org
    else this.id_org = this.user.id_org;

    await this.getOrg();

  },
  mixins: [mainMixin],
  methods: {
    async getUser() {
      await Axios.get('/api/user/current').then((res) => {
        this.user = res.data;
        this.user.isAdmin = !!res.data.roles.root || !!res.data.roles.admin
      });
    },
    async getOrg() {


      try {
        const {data} = await Axios.get(`/api/organization/by-id/${this.id_org}`);

        this.organization = data.organization;

      } catch (e) {
        this.organization = {};
      }


    },
    validate() {

      for (let i = 0; i < this.inputs.length; i++) {
        let item = this.inputs[i];
        if (this.isEmpty(this.organization[item]))
          return false;
      }
      return true;
    },
    async savePage(validate, resolve) {

      if (validate && !this.validate()) {
        await this.$bvModal.msgBoxOk("Для сохранения необходимо заполнить пустые поля.")
        resolve(false)
        return;
      }

      try {
        let formData = new FormData();
        formData.append('organization', JSON.stringify(this.organization));
        const {data} = await Axios.post(`/organization/set-org-covid/${this.id_org}`, formData, {
          headers: {
            'X-CSRF-Token': this.csrf,
          },
        });
        resolve(true);

      } catch (e) {
        resolve(false)
        console.error(e)
      }


    }
  }
}
</script>

<style scoped>
  .min-width {
    min-width: 350px;
    background: inherit;
    border:inherit;
  }
</style>