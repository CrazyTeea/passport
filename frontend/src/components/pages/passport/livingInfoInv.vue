<template>
  <div>
    <!--<nav-bar v-on:block-save="blockPage = !blockPage" v-on:save-page="savePage" :id_org="id_org"
             :is-admin="user.isAdmin"/>-->
    <v-page>
      <div v-if="componentReady" class="container">
        <org-select link="/api/organizations/all" error-msg="нет доступных организаций по заданным критериаям"
                    label="Выбранная организация" v-if="$check(['admin','root'])" v-model="id_org"/>

        <h3>
          Шаг 4: Сведения о проживающих лицах с ограниченными возможностями в жилищном фонде, используемом в уставной
          деятельности
        </h3>

        <stepper
            :back-url="user.isAdmin ? `/admin/living-info/${id_org}` : '/living-info'"
            :to-url="user.isAdmin ? `/admin/org-covid/${id_org}` : '/org-covid'"
            percent="80"
            end-button-label="Далее"
            @save-page="savePage"
        />
        <hr>
        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Проживающие из числа обучающихся с ограниченными возможностями
              здоровья:</label>
            {{ living.cnt_inv }} Человек
          </div>
        </div>
        <hr>

        <b-tabs content-class="mt-3" nav-class="font-weigh-bold" small justified>
          <b-tab no-body>
            <template v-slot:title>
                        <span class="text-secondary">
                        За счёт федерального бюджета
                        </span>
            </template>
            <living-table :items="items_b.items"
                          title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт федерального бюджета"
                          :is-invalid="true" :block-save="blockPage" v-bind:can-save="items_b.canSave"/>

          </b-tab>
          <b-tab no-body>
            <template v-slot:title>
                        <span class="text-secondary">
                        За счёт бюджета субъекта
                        </span>
            </template>
            <living-table :items="items_s.items"
                          title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт бюджета субъекта"
                          :is-invalid="true" :block-save="blockPage" v-bind:can-save="items_s.canSave"/>

          </b-tab>
          <b-tab no-body>
            <template v-slot:title>
                        <span class="text-secondary">
                        За счёт местного бюджета
                        </span>
            </template>
            <living-table :items="items_m.items"
                          title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт местного бюджета"
                          :is-invalid="true" :block-save="blockPage" v-bind:can-save="items_m.canSave"/>

          </b-tab>
          <b-tab no-body>
            <template v-slot:title>
                        <span class="text-secondary">
                              По договорам об оказании
                        платных образовательных услуг
                        </span>
            </template>
            <living-table :items="items_p.items"
                          title="Проживающие из числа обучающихся с ограниченными возможностями по договорам об оказании платных образовательных услуг"
                          :is-invalid="true" :block-save="blockPage" v-bind:can-save="items_p.canSave"/>

          </b-tab>
        </b-tabs>
        <hr>

        <div class="text-center">
          <button class="btn btn-primary" type="button" @click="setZeros()">Заполнить нулями пустые поля</button>
          <hr>
        </div>

        <stepper
            :back-url="user.isAdmin ? `/admin/living-info/${id_org}` : '/living-info'"
            :to-url="user.isAdmin ? `/admin/org-covid/${id_org}` : '/org-covid'"
            percent="80"
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
import {BFormInput, BInputGroup, BTab, BTabs,} from 'bootstrap-vue';
import Axios from 'axios';

import livingTable from '../../organisms/livingTable';
import ScrollButton from '../../organisms/scrollButton';
import OrgSelect from "../../organisms/orgSelect";
import {mainMixin} from "../../mixins";
import Loading from "../../organisms/loading";
import Stepper from "../../organisms/stepper";
import VPage from "../../organisms/vPage";

export default {

  data() {
    return {
      inputs: [
        'spo', 'bak',
        'spec', 'mag', 'asp', 'ord', 'in',
      ],
      csrf: document.getElementsByName('csrf-token')[0].content,
      componentReady: false,
      blockPage: false,
      user: {},
      organization: {},
      id_org: null,
      living: {
        cnt_inv: 0,
      },
      items_b: {
        items: {
          rf: [],
          in: []
        },
        canSave: [],
      },
      items_s: {
        items: {
          rf: [],
          in: []
        },
        canSave: [],
      },
      items_m: {
        items: {
          rf: [],
          in: []
        },
        canSave: [],
      },
      items_p: {
        items: {
          rf: [],
          in: []
        },
        canSave: [],
      },
    };
  },
  watch: {
    async id_org() {
      if (this.componentReady)
        await this.getOrg()
    },
    organization: {
      handler() {
        this.cntLiving();
      },
      deep: true,
    },
    items_b: {
      handler() {
        this.cntLiving();
      },
      deep: true,
    },
    items_s: {
      handler() {
        this.cntLiving();
      },
      deep: true,
    },
    items_m: {
      handler() {
        this.cntLiving();
      },
      deep: true,
    },
    items_p: {
      handler() {
        this.cntLiving();
      },
      deep: true,
    },
  },
  methods: {
    getLabel(type) {
      let arr =
          {
            'rf_och': 'Граждане РФ, обучающиеся по очной форме',
            'in_och': 'Иностранцы, обучающиеся по очной форме',
            'rf_zaoch': 'Граждане РФ, обучающиеся по заочной форме',
            'in_zaoch': 'Иностранцы, обучающиеся по заочной форме',
            'rf_ochzaoch': 'Граждане РФ, обучающиеся по очно-заочной форме',
            'in_ochzaoch': 'Иностранцы, обучающиеся по очно-заочной форме',
          };
      return arr[type];
    },
    cntLiving() {
      /*this.living.cnt_inv = ~~parseInt(this.items_b.items[this.items_b.items.length - 1].all)
          + ~~parseInt(this.items_m.items[this.items_m.items.length - 1].all)
          + ~~parseInt(this.items_s.items[this.items_s.items.length - 1].all)
          + ~~parseInt(this.items_p.items[this.items_p.items.length - 1].all);*/


      this.living.cnt_inv = 0;
      let toNum = num => typeof num === 'string' ? num.toNumber() : (num || 0);
      Object.keys(this.items_b.items).forEach(i => {

        this.living.cnt_inv +=
            this.items_b.items[i].reduce((a, b) => {
              return a + toNum(b.spo)
                  + toNum(b.bak)
                  + toNum(b.spec)
                  + toNum(b.mag)
                  + toNum(b.asp)
                  + toNum(b.ord)
                  + toNum(b.in)
            }, 0)
            + this.items_s.items[i].reduce((a, b) => a + toNum(b.spo)
            + toNum(b.bak)
            + toNum(b.spec)
            + toNum(b.mag)
            + toNum(b.asp)
            + toNum(b.ord)
            + toNum(b.in), 0)
            + this.items_m.items[i].reduce((a, b) => a + toNum(b.spo)
            + toNum(b.bak)
            + toNum(b.spec)
            + toNum(b.mag)
            + toNum(b.asp)
            + toNum(b.ord)
            + toNum(b.in), 0)
            + this.items_p.items[i].reduce((a, b) => a + toNum(b.spo)
            + toNum(b.bak)
            + toNum(b.spec)
            + toNum(b.mag)
            + toNum(b.asp)
            + toNum(b.ord)
            + toNum(b.in), 0)
      });


    },
    async getUser() {
      await Axios.get('/api/user/current').then((res) => {
        this.user = res.data;
        this.user.isAdmin = !!res.data.roles.root || !!res.data.roles.admin
      });
    },
    async getOrg() {
      await Axios.get(`/api/organization/by-id/${this.id_org}`, {
        params: {
          living_st_inv: 1,
        },
      }).then((res) => {
        this.organization = res.data;
        if (this.organization) {

          this.organization.living = res.data.living ?? {};
          const bud = [
            'items_b', 'items_s', 'items_m', 'items_p'
          ];

          bud.forEach(item => {
            this[item].items.rf = [];
            this[item].items.in = [];
          })

          res.data.livingStudents.forEach((item) => {
            let type = item.type;
            let budjet_type = item.budjet_type
            item.label = this.getLabel(type);
            item.all = 0;

            if (item.type.split('_')[0] === 'rf') {
              this[bud[budjet_type]].items.rf.push(item);
            } else {
              this[bud[budjet_type]].items.in.push(item);
            }

          });


          [0, 1, 2, 3].forEach(budjet_type => {
            ['rf_och', 'rf_zaoch', 'rf_ochzaoch', 'in_och', 'in_zaoch', 'in_ochzaoch'].forEach(type => {

              if (type.split('_')[0] === 'rf') {
                if (!this[bud[budjet_type]].items.rf.find(item => item.type === type && item.budjet_type === budjet_type)) {
                  this[bud[budjet_type]].items.rf.push({
                    label: this.getLabel(type),
                    asp: null,
                    bak: null,
                    budjet_type: budjet_type,
                    in: null,
                    invalid: 1,
                    mag: null,
                    name: null,
                    ord: null,
                    spec: null,
                    spo: null,
                    type: type,
                    all: 0
                  });
                }
              } else {

                if (!this[bud[budjet_type]].items.in.find(item => item.type === type && item.budjet_type === budjet_type)) {
                  this[bud[budjet_type]].items.in.push({
                    label: this.getLabel(type),
                    asp: null,
                    bak: null,
                    budjet_type: budjet_type,
                    in: null,
                    invalid: 1,
                    mag: null,
                    name: null,
                    ord: null,
                    spec: null,
                    spo: null,
                    type: type,
                    all: 0
                  })
                }
              }

            })
          });
        }
      });

    },

    validate() {
      for (let i = 0; i < this.inputs.length; i++) {
        let item = this.inputs[i];

        let items = this.items_b.items.rf;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_b.items.rf[j][item]))
            return false;
        }
        items = this.items_s.items.rf;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_s.items.rf[j][item]))
            return false;
        }

        items = this.items_m.items.rf;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_m.items.rf[j][item]))
            return false;
        }

        items = this.items_p.items.rf;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_p.items.rf[j][item]))
            return false;
        }

        items = this.items_b.items.in;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_b.items.in[j][item]))
            return false;
        }
        items = this.items_s.items.in;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_s.items.in[j][item]))
            return false;
        }

        items = this.items_m.items.in;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_m.items.in[j][item]))
            return false;
        }

        items = this.items_p.items.rf;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_p.items.in[j][item]))
            return false;
        }
      }
      return true;

    },

    async savePage(validate, resolve) {

      if (validate && !this.validate()) {
        await this.$bvModal.msgBoxOk("Для сохранения необходимо заполнить пустые поля.")
        resolve(false)
        return;
      }

      const data = new FormData();
      this.organization = this.organization ?? {};
      this.organization.living_studs = [
        ...this.items_b.items.rf, ...this.items_s.items.rf, ...this.items_m.items.rf, ...this.items_p.items.rf,
        ...this.items_b.items.in, ...this.items_s.items.in, ...this.items_m.items.in, ...this.items_p.items.in
      ];

      this.organization.invalid = 1;
      data.append('org_living', JSON.stringify(this.organization));
      await Axios.post(`/organization/set-org-living/${this.id_org}`, data, {
        headers: {
          'X-CSRF-Token': this.csrf,
        },
      })
      resolve(true)

    },
    async setZeros() {


      for (let i = 0; i < this.inputs.length; i++) {
        let item = this.inputs[i];

        let items = this.items_b.items.rf;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_b.items.rf[j][item]))
            this.items_b.items.rf[j][item] = 0
        }
        items = this.items_s.items.rf;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_s.items.rf[j][item]))
            this.items_s.items.rf[j][item] = 0
        }

        items = this.items_m.items.rf;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_m.items.rf[j][item]))
            this.items_m.items.rf[j][item] = 0
        }

        items = this.items_p.items.rf;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_p.items.rf[j][item]))
            this.items_p.items.rf[j][item] = 0
        }

        items = this.items_b.items.in;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_b.items.in[j][item]))
            this.items_b.items.in[j][item] = 0
        }
        items = this.items_s.items.in;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_s.items.in[j][item]))
            this.items_s.items.in[j][item] = 0
        }

        items = this.items_m.items.in;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_m.items.in[j][item]))
            this.items_m.items.in[j][item] = 0
        }

        items = this.items_p.items.rf;

        for (let j = 0; j < items.length; j++) {
          if (this.isEmpty(this.items_p.items.in[j][item]))
            this.items_p.items.in[j][item] = 0
        }
      }
      this.$forceUpdate()


    },
  },
  async mounted() {
    await this.getUser();
    if (this.user.isAdmin)
      this.id_org = this.$route.fullPath.split('/')[3] || this.user.id_org
    else this.id_org = this.user.id_org;

    ///this.blockPage = this.user.isAdmin;

    await this.getOrg();
    // document.addEventListener("pagehide", this.unloadEvent(event));
    //  document.addEventListener("pageshow", this.loadEvent());
    this.componentReady = true;
  },
  components: {
    VPage,
    Stepper,
    Loading,
    OrgSelect,
    ScrollButton,
    livingTable,
    BFormInput,
    BInputGroup,
    BTabs,
    BTab,
  },
  mixins: [mainMixin]
};
</script>

<style scoped/>