<template>

  <div>
    <nav-bar :id_org="id_org" v-on:save-page="savePage" v-on:block-save="blockPage = !blockPage"/>
    <transition enter-active-class="animated fadeInUp">
      <div v-if="componentReady" class="container">
        <div class="row">
          <div class="col-8">
            <h3>
              Сведения о проживающих лицах с ограниченными возможностями в жилищном фонде, используемом в уставной
              деятельности
            </h3>
          </div>
        </div>
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
                          title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт федерального бюджета"
                          :is-invalid="true" :block-save="blockPage" v-bind:can-save="items_s.canSave"/>

          </b-tab>
          <b-tab no-body>
            <template v-slot:title>
                        <span class="text-secondary">
                        За счёт местного бюджета
                        </span>
            </template>
            <living-table :items="items_m.items"
                          title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт федерального бюджета"
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
                          title="Проживающие из числа обучающихся с ограниченными возможностями здоровья за счёт федерального бюджета"
                          :is-invalid="true" :block-save="blockPage" v-bind:can-save="items_p.canSave"/>

          </b-tab>
        </b-tabs>

      </div>
    </transition>
    <scroll-button/>
  </div>
</template>

<script>
import {BFormInput, BInputGroup, BTab, BTabs,} from 'bootstrap-vue';
import Axios from 'axios';
import NavBar from '../../organisms/NavBar';
import livingTable from '../../organisms/livingTable';
import ScrollButton from '../../organisms/scrollButton';

export default {
  name: 'livingInfoInv',
  data() {
    return {
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
      let toNum = num => typeof num === 'string' ? num.toNumber() : num;
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
    async savePage() {
      const data = new FormData();
      this.organization = this.organization ?? {};
      this.organization.living_studs = [
        ...this.items_b.items.rf, this.items_s.items.rf, ...this.items_m.items.rf, ...this.items_p.items.rf,
        ...this.items_b.items.in, this.items_s.items.in, ...this.items_m.items.in, ...this.items_p.items.in
      ];
      this.organization.invalid = 1;
      data.append('org_living', JSON.stringify(this.organization));
      await Axios.post(`/organization/set-org-living/${this.id_org}`, data, {
        headers: {
          'X-CSRF-Token': this.csrf,
        },
      }).then((res) => {
        if (res.data.success) this.getOrg();
      }).finally(() => {
        this.blockPage = true;
      });
    },

  },
  async mounted() {
    await this.getUser();
    this.id_org = this.user.id_org;
    await this.getOrg();
    // document.addEventListener("pagehide", this.unloadEvent(event));
    //  document.addEventListener("pageshow", this.loadEvent());
    this.componentReady = true;
  },
  components: {
    ScrollButton,
    NavBar,
    livingTable,
    BFormInput,
    BInputGroup,
    BTabs,
    BTab,
  },
};
</script>

<style scoped>

</style>
