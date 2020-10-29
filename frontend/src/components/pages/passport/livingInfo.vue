<template>
  <div>
    <nav-bar :is-admin="user.isAdmin" :id_org="id_org" v-on:save-page="savePage" v-on:block-save="blockPage = !blockPage"/>
    <transition enter-active-class="animated fadeInUp">
      <div v-if="componentReady" class="container">
        <div class="row">
          <div class="col-8">
            <h3>
              Сведения о проживающих в жилищном фонде, используемом в уставной деятельности
            </h3>
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Всего проживающих: </label>

            {{ living.cnt_stud }} Человек
          </div>
        </div>

        <hr>

        <div class="row ">
          <div class="col">
            <label class="font-weight-bold">Проживающие из числа обучающихся: </label>

            {{ living.cnt_stud_obuch }} Человек

          </div>
        </div>

        <b-tabs lazy content-class="mt-3" nav-class="font-weigh-bold" small justified>
          <b-tab no-body>
            <template v-slot:title>
                        <span class="text-secondary">
                        За счёт федерального бюджета
                        </span>
            </template>

            <living-table :deletedItems="itemsToDelete" :items="items_b.items"
                          :budjet_type="0"
                          title="Проживающие из числа обучающихся за счёт федерального бюджета" :is-invalid="false"
                          :block-save="blockPage" v-bind:can-save="items_b.canSave"/>

          </b-tab>
          <b-tab no-body>
            <template v-slot:title>
                        <span class="text-secondary">
                        За счёт бюджета субъекта
                        </span>
            </template>

            <living-table :deletedItems="itemsToDelete" :items="items_s.items"
                          :budjet_type="1"
                          title="Проживающие из числа обучающихся за счёт бюджета субъекта" :is-invalid="false"
                          :block-save="blockPage" v-bind:can-save="items_s.canSave"/>

          </b-tab>
          <b-tab no-body>
            <template v-slot:title>
                        <span class="text-secondary">
                        За счёт местного бюджета
                        </span>
            </template>

            <living-table :deletedItems="itemsToDelete" :items="items_m.items"
                          :budjet_type="2"
                          title="Проживающие из числа обучающихся за счёт местного бюджета" :is-invalid="false"
                          :block-save="blockPage" v-bind:can-save="items_m.canSave"/>

          </b-tab>
          <b-tab no-body>
            <template v-slot:title>
                        <span class="text-secondary">
                              По договорам об оказании
                        платных образовательных услуг
                        </span>
            </template>

            <living-table :deletedItems="itemsToDelete" :items="items_p.items"
                          :budjet_type="3"
                          title="Проживающие из числа обучающихся по договорам об оказании платных образовательных услуг"
                          :is-invalid="false"
                          :block-save="blockPage" v-bind:can-save="items_p.canSave"/>

          </b-tab>
        </b-tabs>
        <hr class="mt-2">
        <div class="row mt-3">
          <div class="col-6">
            <label for="live_proz_poluch_step">Проживающие из числа обучающихся, получающие государственную соц.
              стипендию</label>
          </div>
          <div class="col-6">
            <b-input-group append="Человек">
              <template v-slot:prepend>
                <b-input-group-text>
                  <i id="bitch_tooltip" class="fas fa-question-circle"></i>
                </b-input-group-text>
                <b-tooltip custom-class="tooltip_width" target="bitch_tooltip">
                  Количество проживающих, указанных в ч.5 ст.36 от 29.12.2012
                  № 273-ФЗ «Об образовании в Российской Федерации»
                </b-tooltip>
              </template>
              <b-form-input :disabled="blockPage" v-model="organization.living.cnt_stug_step"
                            id="live_proz_poluch_step"/>
            </b-input-group>

          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Проживающие из числа персонала и их семей: </label>
            {{ living.prozh_is_person }} Человек
          </div>
        </div>
        <br>

        <b-table-simple fixed borderless small>
          <b-thead>
            <b-tr>
              <b-th></b-th>
              <b-th>Персонал</b-th>
              <b-th>Члены семей</b-th>
            </b-tr>
          </b-thead>
          <b-tbody>
            <b-tr>
              <b-td>Работники</b-td>
              <b-td>
                <b-form-input v-model="organization.living.rab_p" :disabled="blockPage"/>
              </b-td>
              <b-td>
                <b-form-input v-model="organization.living.rab_s" :disabled="blockPage"/>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>Научные сотрудники</b-td>
              <b-td>
                <b-form-input v-model="organization.living.nauch_p" :disabled="blockPage"/>
              </b-td>
              <b-td>
                <b-form-input v-model="organization.living.nauch_s" :disabled="blockPage"/>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>Профессорско-преподавательский состав</b-td>
              <b-td>
                <b-form-input v-model="organization.living.prof_p" :disabled="blockPage"/>
              </b-td>
              <b-td>
                <b-form-input v-model="organization.living.prof_s" :disabled="blockPage"/>
              </b-td>
            </b-tr>
            <b-tr>
              <b-td>Иные категории сотрудников организации</b-td>
              <b-td>
                <b-form-input v-model="organization.living.in_p" :disabled="blockPage"/>
              </b-td>
              <b-td>
                <b-form-input v-model="organization.living.in_s" :disabled="blockPage"/>
              </b-td>
            </b-tr>
            <b-tr>
              <b-th>Всего</b-th>
              <b-th>
                {{ living.all_p }}
              </b-th>
              <b-th>
                {{ living.all_s }}
              </b-th>
            </b-tr>
          </b-tbody>
        </b-table-simple>
        <hr>

        <div class="row mb-2">
          <div class="col-6">
            <label for="live_inie_prozh" class="font-weight-bold">Иные проживающие</label>
          </div>
          <div class="col-6">
            <b-input-group append="Человек">
              <b-form-input :disabled="blockPage" v-model="organization.living.inie_pr" id="live_inie_prozh"/>
            </b-input-group>
          </div>
        </div>

      </div>
    </transition>
    <scroll-button/>
  </div>

</template>

<script>
import {
  BFormInput,
  BInputGroup,
  BInputGroupText,
  BTab,
  BTableSimple,
  BTabs,
  BTbody,
  BTd,
  BTh,
  BThead,
  BTooltip,
  BTr,
} from 'bootstrap-vue';
import Axios from 'axios';
import NavBar from '../../organisms/NavBar';
import livingTable from '../../organisms/livingTable';
import scrollButton from '../../organisms/scrollButton';

export default {
  name: 'livingInfo',
  components: {
    scrollButton,
    NavBar,
    livingTable,
    BFormInput,
    BInputGroup,
    BTabs,
    BTab,
    BTableSimple,
    BThead,
    BTbody,
    BTh,
    BTd,
    BTr,
    BInputGroupText,
    BTooltip,
  },
  data() {
    return {
      csrf: document.getElementsByName('csrf-token')[0].content,
      blockPage: false,
      user: {},
      organization: {},
      living: {
        cnt_stud_obuch: 0,
        cnt_stud: 0,
        all_p: 0,
        all_s: 0,
        prozh_is_person: 0,
      },
      id_org: null,
      componentReady: false,
      itemsToDelete: [],
      items_b: {
        items: {
          rf: [],
          in_och: [],
          in_ochzaoch: [],
          in_zaoch: []
        },
        canSave: [],
      },
      items_s: {
        items: {
          rf: [],
          in_och: [],
          in_ochzaoch: [],
          in_zaoch: []
        },
        canSave: [],
      },
      items_m: {
        items: {
          rf: [],
          in_och: [],
          in_ochzaoch: [],
          in_zaoch: []
        },
        canSave: [],
      },
      items_p: {
        items: {
          rf: [],
          in_och: [],
          in_ochzaoch: [],
          in_zaoch: []
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
      this.living.cnt_stud_obuch = 0;
      let toNum = num => typeof num === 'string' ? num.toNumber() : num;
      Object.keys(this.items_b.items).forEach(i => {
        this.living.cnt_stud_obuch +=
            this.items_b.items[i].reduce((a, b) =>
                a + toNum(b.spo)
                + toNum(b.bak)
                + toNum(b.spec)
                + toNum(b.mag)
                + toNum(b.asp)
                + toNum(b.ord)
                + toNum(b.in)
                , 0)
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


      this.living.all_p = toNum(this.organization.living.rab_p)
          + toNum(this.organization.living.nauch_p)
          + toNum(this.organization.living.prof_p)
          + toNum(this.organization.living.in_p)
      this.living.all_s =
          toNum(this.organization.living.rab_s)
          + toNum(this.organization.living.nauch_s)
          + toNum(this.organization.living.prof_s)
          + toNum(this.organization.living.in_s);

      this.living.prozh_is_person = this.living.all_s + this.living.all_p;

      this.living.cnt_stud = toNum(this.organization.living.inie_pr)
          + toNum(this.living.cnt_stud_obuch)
          + toNum(this.living.prozh_is_person);
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
          living_st_inv: 0,
        },
      }).then((res) => {
        this.organization = res.data;

        if (this.organization) {

          this.organization.living = res.data.living ?? {};
          const bud = [
            'items_b', 'items_s', 'items_m', 'items_p'
          ];
          res.data.livingStudents.forEach(item => {
            let type = item.type;
            let budjet_type = item.budjet_type
            item.label = this.getLabel(type);
            item.all = 0;
            if (item.type.split('_')[0] === 'rf') {
              this[bud[budjet_type]].items.rf.push(item);
            } else {
              this[bud[budjet_type]].items[type].push(item);
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
                    invalid: null,
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
                this[bud[budjet_type]].items[type] = this[bud[budjet_type]].items[type] || [];
                if (!this[bud[budjet_type]].items[type].find(item => item.type === type && item.budjet_type === budjet_type)) {
                  this[bud[budjet_type]].items[type].push({
                    asp: null,
                    bak: null,
                    budjet_type: budjet_type,
                    in: null,
                    invalid: null,
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
        this.cntLiving();
      });

    },
    async savePage() {
      const data = new FormData();
      this.organization.living_studs = [
        ...this.items_b.items.rf, ...this.items_b.items.in_och, ...this.items_b.items.in_ochzaoch, ...this.items_b.items.in_zaoch,
        ...this.items_s.items.rf, ...this.items_s.items.in_och, ...this.items_s.items.in_ochzaoch, ...this.items_s.items.in_zaoch,
        ...this.items_m.items.rf, ...this.items_m.items.in_och, ...this.items_m.items.in_ochzaoch, ...this.items_m.items.in_zaoch,
        ...this.items_p.items.rf, ...this.items_p.items.in_och, ...this.items_p.items.in_ochzaoch, ...this.items_p.items.in_zaoch
      ];

      this.organization.invalid = 0;

      data.append('toDelete', JSON.stringify(this.itemsToDelete))

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
    }
  },
  async mounted() {
    await this.getUser();
    if (this.user.isAdmin)
      this.id_org = this.$route.fullPath.split('/')[3] || this.user.id_org
    else this.id_org = this.user.id_org;

    this.blockPage = this.user.isAdmin;

    await this.getOrg();
    this.componentReady = true;


  },
};
</script>

<style scoped>

</style>
