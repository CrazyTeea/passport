<template>
  <div>
    <!--<nav-bar v-on:block-save="blockPage = !blockPage" v-on:save-page="savePage" :id_org="id_org"
             :is-admin="user.isAdmin"/>-->
    <v-page>
      <div v-if="componentReady" class="container">
        <org-select link="/api/organizations/all" error-msg="нет доступных организаций по заданным критериаям"
                    label="Выбранная организация" v-if="$check(['admin','root'])" v-model="id_org"/>

        <h3>Шаг 3: Сведения о проживающих в жилищном фонде, используемом в уставной деятельности</h3>

        <stepper
            :back-url="user.isAdmin ? `/admin/area-info/${this.id_org}` : '/area-info'"
            :to-url="user.isAdmin ? `/admin/living-info-inv/${this.id_org}` : '/living-info-inv'"
            percent="60"
            end-button-label="Далее"
            @save-page="savePage"
        />
        <hr>

        <div class="row">
          <div class="col">
            <b-alert
                v-if="organization.area.area_cnt_mest_zan_obuch + organization.area.area_cnt_mest_zan_in_obuch !== living.cnt_stud"
                show variant="danger">
              Количество внесённых вами мест, занятых обучающимися и иными категориями проживающих в объектах,
              используемых в уставной деятельности, равно
              <b>{{ organization.area.area_cnt_mest_zan_obuch + organization.area.area_cnt_mest_zan_in_obuch }}</b>.
              Сумма проживающих должна соответствать количеству занятых мест.
            </b-alert>

            <label class="font-weight-bold">Всего проживающих: </label>

            {{ living.cnt_stud }} Человек
          </div>
        </div>

        <hr>

        <div class="row ">
          <div class="col">
            <b-alert v-if="organization.area.area_cnt_mest_zan_obuch !== living.cnt_stud_obuch" show variant="danger">
              Количество внесённых вами мест, занятых обучающимися в объектах, используемых в уставной деятельности,
              равно <b>{{ organization.area.area_cnt_mest_zan_obuch }}</b>. Сумма проживающих из числа обучающихся
              должна соответствать количеству занятых мест обучающимися.
            </b-alert>

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
            <label for="live_inie_prozh" class="font-weight-bold">
              Иные проживающие <i class="fas fa-question-circle" id="tooltip-target-1"/>
              <b-tooltip target="tooltip-target-1" triggers="hover">Не обучающиеся и не персонал и их семьи</b-tooltip>
            </label>
          </div>
          <div class="col-6">
            <b-input-group append="Человек">
              <b-form-input :disabled="blockPage" v-model="organization.living.inie_pr" id="live_inie_prozh"/>
            </b-input-group>
          </div>
        </div>
        <hr>

        <div class="text-center">
          <button class="btn btn-primary" type="button" @click="setZeros()">Заполнить нулями пустые поля</button>
          <hr>
        </div>

        <stepper
            :back-url="user.isAdmin ? `/admin/area-info/${this.id_org}` : '/area-info'"
            :to-url="user.isAdmin ? `/admin/living-info-inv/${this.id_org}` : '/living-info-inv'"
            percent="60"
            end-button-label="Далее"
            @save-page="savePage"
        />
        <br>
      </div>
      <loading v-else />
    </v-page>


    <scroll-button/>
  </div>

</template>

<script>
import {
  BAlert,
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

import livingTable from '../../organisms/livingTable';
import scrollButton from '../../organisms/scrollButton';
import OrgSelect from "../../organisms/orgSelect";
import {mainMixin} from "../../mixins";
import Loading from "../../organisms/loading";
import Stepper from "../../organisms/stepper";
import VPage from "../../organisms/vPage";

export default {
  name: 'livingInfo',
  components: {
    VPage,
    Stepper,
    Loading,
    OrgSelect,
    scrollButton,
    livingTable,
    BAlert,
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
      inputs: [
        'spo', 'bak',
        'spec', 'mag', 'asp', 'ord', 'in',
      ],
      inputs2: [
        'rab_p',
        'rab_s',
        'nauch_p',
        'nauch_s',
        'prof_p',
        'prof_s',
        'in_p',
        'in_s',
        'inie_pr',
        'cnt_stug_step'
      ],
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
      this.living.cnt_stud_obuch = 0;
      let toNum = num => typeof num === 'string' ? num.toNumber() : (num || 0);
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
      let toNum = num => typeof num === 'string' ? num.toNumber() : (num || 0);

      await Axios.get(`/api/organization/by-id/${this.id_org}`, {params: {living_st_inv: 0}}).then((res) => {
        this.organization = res.data;

        if (this.organization) {
          if (this.organization.objects) {
            this.organization.area.area_cnt_mest_zan_obuch = this.organization.objects.reduce((a, b) => a + toNum((b.area) ? b.area.cnt_mest_zan_obuch : 0), 0);
            this.organization.area.area_cnt_mest_zan_obuch = this.organization.area.area_cnt_mest_zan_obuch ?? 0;
            this.organization.area.area_cnt_mest_zan_in_obuch = this.organization.objects.reduce((a, b) => a + toNum(b.area ? b.area.cnt_mest_zan_in_obuch : 0), 0);
          }

          this.organization.living = res.data.living ?? {};
          const bud = [
            'items_b', 'items_s', 'items_m', 'items_p'
          ];

          bud.forEach(item => {
            this[item].items.rf = [];
            this[item].items.in_och = [];
            this[item].items.in_ochzaoch = [];
            this[item].items.in_zaoch = [];
          })

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
      await Axios.get(`/api/objects/org/${this.id_org}`).then((res) => {
        this.organization.objects = res.data;

        if (this.organization) {
          if (this.organization.objects) {
            this.organization.area.area_cnt_mest_zan_obuch = this.organization.objects.reduce((a, b) => a + toNum((b.area) ? b.area.cnt_mest_zan_obuch : 0), 0);
            this.organization.area.area_cnt_mest_zan_obuch = this.organization.area.area_cnt_mest_zan_obuch ?? 0;
            this.organization.area.area_cnt_mest_zan_in_obuch = this.organization.objects.reduce((a, b) => a + toNum(b.area ? b.area.cnt_mest_zan_in_obuch : 0), 0);
          }
        }
      });
    },

    validate() {

      for (let i = 0; i < this.inputs.length; i++) {
        let item = this.inputs[i];

        //let this.items_b.items.rf

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


      }
      for (let i = 0; i < this.inputs2.length; i++) {
        let item = this.inputs2[i];
        if (this.isEmpty(this.organization.living[item]))
          return false;
      }
      return true;
    },

    async savePage(validate,resolve) {

      if (validate && !this.validate()) {
        await this.$bvModal.msgBoxOk("Для сохранения необходимо заполнить пустые поля.")
        resolve(false)
        return;
      }

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
      }
      for (let i = 0; i < this.inputs2.length; i++) {
        let item = this.inputs2[i];
        if (this.isEmpty(this.organization.living[item]))
          this.organization.living[item] = 0;
      }
      this.$forceUpdate()
    },
  },
  async mounted() {
    await this.getUser();
    if (this.user.isAdmin)
      this.id_org = this.$route.fullPath.split('/')[3] || this.user.id_org
    else this.id_org = this.user.id_org;

    //this.blockPage = this.user.isAdmin;

    await this.getOrg();
    this.componentReady = true;
  },
  mixins: [mainMixin]
};
</script>

<style scoped>

</style>
