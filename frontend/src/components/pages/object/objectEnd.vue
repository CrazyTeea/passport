<template>
  <div>
    <v-page>
      <div v-if="componentReady" class="container">
        <org-select v-if="$check(['admin','root'])" v-model="id_org" label="Выбранная организация"
                    link="/api/organizations/all"
                    error-msg="нет доступных организаций по заданным критериаям"/>

        <h3>Шаг 5: Завершение</h3>


        <stepper
            :back-url="user.isAdmin ?
          `/admin/objects-tariff/${id_org}/${$route.params.id_object}` :
          `/objects-tariff/${$route.params.id_object}`"
            :to-url="user.isAdmin ?
          `/admin/data/${id_org}` :
          '/main'"
            percent="100"
            end-button-label="Далее"
            @save-page="savePage"
        />
        <hr>

        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h2>Обращаем внимание, что единица измерения всех денежных показателей - рубли. Поэтому поля должны быть
              заполнены в рублях.</h2>
            <br>
            <b-alert class="text-center" show variant="light">
              <h4>500.00 <b>не равно</b> пятьсот тысяч рублей,<br>500.00 <b>равно</b> пятьсот рублей.</h4>
            </b-alert>
          </div>
          <b-img src="/img/free-icon-owl-1183760.svg" width="300"/>
        </div>

      </div>
      <loading v-else/>
    </v-page>

  </div>
</template>

<script>
import Axios from "axios";
import OrgSelect from "../../organisms/orgSelect";
import {BAlert, BImg} from "bootstrap-vue";
import {mainMixin} from "../../mixins";
import Loading from "../../organisms/loading";
import Stepper from "../../organisms/stepper";
import VPage from "../../organisms/vPage";

export default {
  async mounted() {
    await this.getUser();
    if (this.user.isAdmin) this.id_org = this.$route.fullPath.split('/')[3] || this.user.id_org
    else this.id_org = this.user.id_org;

    this.blockSave = this.user.isAdmin;


    this.componentReady = true;
  },
  components: {VPage, Stepper, Loading, BAlert, BImg, OrgSelect},
  data() {
    return {
      blockSave: false,
      csrf: document.getElementsByName('csrf-token')[0].content,
      componentReady: false,
      id_org: 0,

      user: {},
    };
  },
  methods: {
    async getUser() {
      await Axios.get('/api/user/current').then((res) => {
        this.user = res.data;
        this.user.isAdmin = !!res.data.roles.root || !!res.data.roles.admin
      });
    },
    async savePage(validate, resolve) {

      await Axios.post(`/object/update-count/${this.$route.params.id_object}`, null, {
        headers: {'X-CSRF-Token': this.csrf}
      })

      resolve(true)


    },
  },
  mixins: [mainMixin],
}
</script>

<style scoped/>