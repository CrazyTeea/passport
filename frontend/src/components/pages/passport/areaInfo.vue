<template>
  <div>
    <nav-bar v-on:save-page="savePage" v-on:block-save="blockSave =!blockSave"/>
    <transition enter-active-class="animated fadeInUp">
      <div v-if="componentReady" class="container">
        <div class="row">
          <div class="col-8">
            <h3>Сведения о количестве мест и площади жилищного фонда, используемого в уставной деятельности</h3>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-12">
            <h4>Площадь</h4>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Общая площадь, пригодная для проживания:</label>
            {{ area.area_prig_prozh }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col "><label class="ml-2  font-weight-bold">1. Жилая площадь, пригодная для проживания:</label>
            {{ area.area_zhil_prig_prozh }}м<sup>2</sup>

          </div>
        </div>
        <div class="row">
          <div class="col"><label class="ml-4 font-weight-bold">А. Занятая обучающимися:</label>
            {{ area.area_zan_obuch }}м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col"><label class=" ml-4 font-weight-bold">Б. Занятая иными категориями нанимателей:</label>
            {{ area.area_in_kat_nan }}м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col"><label class="ml-4 font-weight-bold">В. Свободная:</label>
            {{ area.svobod }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col"><label class="ml-4 font-weight-bold">Г. Неиспользуемая:</label>
            {{ area.ne_isp }} м<sup>2</sup>

          </div>
        </div>
        <div class="row">
          <div class="col "><label class="ml-2 font-weight-bold">2. Нежилая площадь в пригодных для проживания
            объектах:</label>
            {{ area.ne_zhil_plosh_v_prig_dlya_prozh }}м<sup>2</sup>
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col"><label class="font-weight-bold">Общая площадь, непригодная для проживания:</label>
            {{ area.area_obsh_ne_prig_dlya_prozh }}м<sup>2</sup>
          </div>
        </div>

        <b-table-simple fixed borderless>
          <b-thead>
            <b-tr>
              <b-th>Общая площадь, непригодная для проживания</b-th>
              <b-th>Жилая площадь</b-th>
              <b-th>Нежилая площадь</b-th>
              <b-th>Общая площадь</b-th>
            </b-tr>
          </b-thead>
          <b-tbody>
            <b-tr>
              <b-th>Требует капитального ремонта</b-th>
              <b-td>
                {{ area.area_zhil_t_k_r }}
              </b-td>
              <b-td>
                {{ area.area_ne_zhil_t_k_r }}
              </b-td>
              <b-td>
                {{ area.all_t_k_r }}
              </b-td>
            </b-tr>
            <b-tr>
              <b-th>Находится в аварийном состоянии</b-th>
              <b-td>
                {{ area.area_zhil_n_a_s }}
              </b-td>
              <b-td>
                {{ area.area_ne_zhil_n_a_s }}
              </b-td>
              <b-td>
                {{ area.all_n_a_s }}
              </b-td>
            </b-tr>
            <b-tr>
              <b-th>Непригодна для проживания</b-th>
              <b-td>
                {{ area.area_zhil_n_p }}
              </b-td>
              <b-td>
                {{ area.area_ne_zhil_n_p }}
              </b-td>
              <b-td>
                {{ area.all_n_p }}
              </b-td>
            </b-tr>
          </b-tbody>
        </b-table-simple>

        <hr>

        <div class="row">
          <div class="col"><label class="font-weight-bold">Количество квадратных метров жилой площади на одного
            проживающего: </label>
            {{ area.area_kv_metr_zhil }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col"><label class="font-weight-bold">Количество квадратных метров общей площади на одного
            проживающего: </label>
            {{ area.area_kv_metr_obsh }}м <sup>2</sup>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col"><label class="font-weight-bold">Площадь объектов, не используемых в уставной
            деятельности: </label>
            {{ area.area_obj_ne_isp_v_ust_dey }} м<sup>2</sup>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col">
            <h4>Места</h4>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Количество мест: </label>
            {{ area.area_cnt_mest }} мест
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="ml-2 font-weight-bold">1. Количество пригодных для проживания мест: </label>
            {{ area.area_cnt_mest_prig_prozh }} мест
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="ml-4 font-weight-bold">А. Количество мест, занятых обучающимися: </label>
            {{ area.area_cnt_mest_zan_obuch }} мест
          </div>
        </div>

        <b-table-simple fixed borderless>
          <b-thead>
            <b-tr>
              <b-th>А. Количество мест, занятых обучающимися</b-th>
              <b-th>м<sup>2</sup> на одного проживающего</b-th>
              <b-th>6 м<sup>2</sup> и более на одного проживающего</b-th>
              <b-th>Всего</b-th>
            </b-tr>
          </b-thead>
          <b-tbody>
            <b-tr>
              <b-th>
                Среднее профессиональное образование
              </b-th>
              <b-td>
                {{ area.m2_spo }}
              </b-td>
              <b-td>
                {{ area.c6m2_spo }}
              </b-td>
              <b-td>
                {{area.all_c6m2_spo}}
              </b-td>
            </b-tr>
            <b-tr>
              <b-th>
                Бакалавриат
              </b-th>
              <b-td>
                {{ area.m2_bak }}
              </b-td>
              <b-td>
                {{ area.c6m2_bak }}
              </b-td>
              <b-td>
                {{area.all_c6m2_bak}}
              </b-td>
            </b-tr>
            <b-tr>
              <b-th>
                Специалитет
              </b-th>
              <b-td>
                {{ area.m2_spec }}
              </b-td>
              <b-td>
                {{ area.c6m2_spec }}
              </b-td>
              <b-td>
                {{area.all_c6m2_spec}}
              </b-td>
            </b-tr>
            <b-tr>
              <b-th>
                Магистратура
              </b-th>
              <b-td>
                {{ area.m2_mag }}
              </b-td>
              <b-td>
                {{ area.c6m2_mag }}
              </b-td>
              <b-td>
                {{area.all_c6m2_mag}}
              </b-td>
            </b-tr>
            <b-tr>
              <b-th>
                Аспирантура
              </b-th>
              <b-td>
                {{ area.m2_asp }}
              </b-td>
              <b-td>
                {{ area.c6m2_asp }}
              </b-td>
              <b-td>
                {{area.all_c6m2_asp}}
              </b-td>
            </b-tr>
            <b-tr>
              <b-th>
                Ординатрура
              </b-th>
              <b-td>
                {{ area.m2_ord }}
              </b-td>
              <b-td>
                {{ area.c6m2_ord }}
              </b-td>
              <b-td>
                {{area.all_c6m2_ord}}
              </b-td>
            </b-tr>
            <b-tr>
              <b-th>
                Иные обучающиеся
              </b-th>
              <b-td>
                {{ area.m2_in }}
              </b-td>
              <b-td>
                {{ area.c6m2_in }}
              </b-td>
              <b-td>
                {{area.all_c6m2_in}}
              </b-td>
            </b-tr>
            <b-tr>
              <b-th>
                Всего
              </b-th>
              <b-td>
                {{area.all_m2}}
              </b-td>
              <b-td>
                {{area.all_6m2}}
              </b-td>
              <b-td>
                {{area.all_all}}
              </b-td>
            </b-tr>
          </b-tbody>
        </b-table-simple>

        <div class="row">
          <div class="col">
            <label class="ml-4 font-weight-bold">Б. Количество мест, занятых иными категориями проживающих: </label>
            {{ area.area_cnt_mest_zan_in_obuch }} мест
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="ml-4 font-weight-bold">В. Количество свободных мест: </label>
            {{ area.area_cnt_svob_mest }} мест

          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="ml-4 font-weight-bold">Г. Количество неиспользуемых мест: </label>
            {{ area.area_cnt_ne_mest }} мест
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label class=" ml-2 font-weight-bold">2. Количество непригодных к использованию мест: </label>
            {{ area.area_cnt_mest_ne_prig_k_prozh }} мест
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Количество мест, оборудованных для лиц с ограниченными возможностями
              здоровья: </label>
            {{ area.area_cnt_mest_invalid }} мест
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <label class="font-weight-bold" for="org_area_cnt_mest_nuzd">Количество обучающихся, нуждающихся в
              жилье: </label>
          </div>
          <div class="col-6">
            <b-input-group append="человек">
              <b-form-input id="org_area_cnt_mest_nuzd" v-model="organization.area.area_cnt_nuzhd_zhil"
                            :disabled="blockSave"/>
            </b-input-group>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <label class="font-weight-bold" for="org_area_cnt_live_in_other">Количество обучающихся, проживающих в жилом
              фонде других организаций</label>
          </div>
          <div class="col-6">
            <b-input-group append="человек">
              <b-form-input id="org_area_cnt_live_in_other" v-model="organization.area.area_cnt_prozh_u_drugih"
                            :disabled="blockSave"/>
            </b-input-group>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Количество мест, возможных к вводу в эксплуатацию после проведения
              восстановительных работ: </label>
            {{ area.area_cnt_mest_vozm_k_vvodu_v_esk }} мест
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label class="ml-2 font-weight-bold">
              1. <i id="bitch_tooltip" class="fas fa-question-circle"></i> Количество мест, возможных к вводу в
              эксплуатацию из числа неиспользуемых после проведения восстановительных работ:
              <div class="text-black-50">
                {{ area.area_cnt_mest_vozm_mest_is_neisp }} мест
              </div>

            </label>
            <b-tooltip custom-class="tooltip_width" target="bitch_tooltip">
              Восстановительные работы - проведение капитального ремонта/приведения
              объекта в соответствие с установленными санитарными и техническими
              правилами и нормами, иными требованиями законодательства
            </b-tooltip>

          </div>
        </div>

        <div class="row">
          <div class="col">
            <label class="ml-2 font-weight-bold">
              2. <i id="bitch_tooltip2" class="fas fa-question-circle"></i> Количество мест, возможных к вводу в
              эксплуатацию из числа непригодных к использованию после проведения
              восстановительных работ:
              <div class="text-black-50">
                {{ area.area_cnt_mest_vozm_mest_is_neprig }} мест
              </div>
            </label>

            <b-tooltip custom-class="tooltip_width" target="bitch_tooltip2">
              Восстановительные работы - проведение капитального ремонта/приведения
              объекта в соответствие с установленными санитарными и техническими
              правилами и нормами, иными требованиями законодательства
            </b-tooltip>

          </div>
        </div>


      </div>
    </transition>
    <scroll-button/>
  </div>
</template>

<script>
import Axios from 'axios';
import NavBar from "../../organisms/NavBar";
import {
  BFormInput,
  BInputGroup,
  BInputGroupText,
  BTableSimple,
  BTbody,
  BTd,
  BTh,
  BThead,
  BTooltip,
  BTr
} from 'bootstrap-vue'
import Decimal from 'decimal.js'
import scrollButton from "../../organisms/scrollButton";

export default {
  components: {
    scrollButton,
    NavBar,
    BTooltip,
    BInputGroupText,
    BInputGroup,
    BFormInput,
    BTableSimple,
    BThead,
    BTbody,
    BTh,
    BTd,
    BTr
  },
  data() {
    return {
      componentReady: false,
      area: {
        area_zhil_t_k_r: 0
      },
      csrf: document.getElementsByName("csrf-token")[0].content,
      blockSave: false,
      id_org: null,
      organization: null,
      user: {}
    }
  },
  computed: {
    objArea() {
      return this.organization?.area;
    }
  },
  watch: {
    objArea() {
      if (this.componentReady)
        this.countArea()

    }
  },
  methods: {
    countArea() {
      console.log('kek');

      let zil = {
        area_zan_obuch: 0,
        area_in_kat_nan: 0,
        svobod: 0,
        ne_isp: 0
      }
      let nezil = 0;


      this.organization.objects?.forEach(item => {
        if (item.area) {
          zil.area_zan_obuch = new Decimal(item.area.zan_obuch).plus(zil.area_zan_obuch).toFixed(3);
          zil.area_in_kat_nan = new Decimal(item.area.zan_inie).plus(zil.area_in_kat_nan).toFixed(3);
          zil.svobod = new Decimal(item.area.svobod).plus(zil.svobod).toFixed(3);
          zil.ne_isp = new Decimal(item.area.neisp).plus(zil.ne_isp).toFixed(3);

          nezil = (new Decimal(item.area.punkt_pit).plus(
              new Decimal(item.area.pom_dlya_uch).plus(
                  new Decimal(item.area.pom_dlya_med).plus(
                      new Decimal(item.area.pom_dlya_sport).plus(
                          new Decimal(item.area.pom_dlya_soc).plus(
                              new Decimal(item.area.pom_dlya_kult).plus(
                                  new Decimal(item.area.in_nezh_plosh)))))))).plus(nezil).toFixed(3);
        }

      })

      console.log(this.area.area_zhil_t_k_r);

      this.area.all_t_k_r =
          new Decimal(this.area.area_zhil_t_k_r ?? 0).plus(
              new Decimal(this.area.area_ne_zhil_t_k_r ?? 0)).toFixed(3);

      this.area.all_n_a_s =
          new Decimal(this.area.area_zhil_n_a_s ?? 0).plus(
              new Decimal(this.area.area_ne_zhil_n_a_s ?? 0)).toFixed(3);

      this.area.all_n_p =
          new Decimal(this.area.area_zhil_n_p ?? 0).plus(
              new Decimal(this.area.area_ne_zhil_n_p ?? 0)).toFixed(3);

      this.area.area_obsh_ne_prig_dlya_prozh =
          this.area.all_n_p.plus(
              this.area.all_n_a_s.plus(
                  this.area.all_t_k_r));


      this.area.area_zan_obuch = zil.area_zan_obuch;
      this.area.area_in_kat_nan = zil.area_in_kat_nan;
      this.area.svobod = zil.svobod;
      this.area.ne_isp = zil.ne_isp;
      this.area.ne_zhil_plosh_v_prig_dlya_prozh = nezil;


      this.area.area_zhil_prig_prozh =
          new Decimal(this.area.area_zan_obuch).plus(
              new Decimal(this.area.area_in_kat_nan).plus(
                  new Decimal(this.area.svobod).plus(
                      new Decimal(this.area.ne_isp))));
      this.area.area_prig_prozh =
          new Decimal(this.area.area_zhil_prig_prozh).plus(
              new Decimal(this.area.ne_zhil_plosh_v_prig_dlya_prozh));


      let b = new Decimal(this.area.area_zan_obuch).plus(new Decimal(this.area.area_in_kat_nan)).toNumber();
      this.area.area_kv_metr_zhil = b > 0 ? (this.area.area_zhil_prig_prozh / (b)) : 0;
      this.area.area_kv_metr_obsh = b > 0 ? (this.area.area_prig_prozh / (b)) : 0;

      this.area.area_obj_ne_isp_v_ust_dey =
          new Decimal(this.area.area_obsh_ne_prig_dlya_prozh).plus(
              new Decimal(this.area.area_prig_prozh));

      this.area.area_cnt_mest_zan_obuch = this.organization.objects?.reduce((a, b) => a + +((b.area) ? b.area.cnt_mest_zan_obuch : 0), 0);
      this.area.area_cnt_mest_zan_in_obuch = this.organization.objects?.reduce((a, b) => a + +(b.area ? b.area.cnt_mest_zan_in_obuch : 0), 0);
      this.area.area_cnt_svob_mest = this.organization.objects?.reduce((a, b) => a + +(b.area ? b.area.cnt_svobod_mest : 0), 0);
      this.area.area_cnt_ne_mest = this.organization.objects?.reduce((a, b) => a + +(b.area ? b.area.cnt_neisp_mest : 0), 0);
      this.area.area_cnt_mest_ne_prig_k_prozh = this.organization.objects?.reduce((a, b) => a + +(b.area ? b.area.cnt_nepr_isp_mest : 0), 0);
      this.area.area_cnt_mest_invalid = this.organization.objects?.reduce((a, b) => a + +(b.area ? b.area.cnt_mest_inv : 0), 0);
      this.area.area_cnt_mest_vozm_mest_is_neisp = this.organization.objects?.reduce((a, b) => a + +(b.area ? b.area.cnt_mest_vozm_neisp_mest : 0), 0);
      this.area.area_cnt_mest_vozm_mest_is_neprig = this.organization.objects?.reduce((a, b) => a + +(b.area ? b.area.cnt_mest_vozm_neprig_mest : 0), 0);


      this.area.area_cnt_mest_prig_prozh =
          new Decimal(this.area.area_cnt_mest_zan_obuch).plus(
              new Decimal(this.area.area_cnt_mest_zan_in_obuch).plus(
                  new Decimal(this.area.area_cnt_svob_mest).plus(
                      new Decimal(this.area.area_cnt_ne_mest))));

      this.area.area_cnt_mest = new Decimal(this.area.area_cnt_mest_prig_prozh).plus(
          new Decimal(this.area.area_cnt_mest_ne_prig_k_prozh));


      this.area.area_cnt_mest_vozm_k_vvodu_v_esk = new Decimal(this.area.area_cnt_mest_vozm_mest_is_neisp).plus(
          new Decimal(this.area.area_cnt_mest_vozm_mest_is_neprig));


    },
    async getUser() {
      await Axios.get('/api/user/current').then(res => {
        this.user = res.data;
      });
    },
    async getOrg() {
      await Axios.get(`/api/organization/by-id/${this.id_org}`).then(res => {
            this.organization = res.data;
            this.organization.area = this.area = res.data.area ?? {}
          }
      );
      await Axios.get(`/api/objects/org/${this.id_org}`).then(res => {
        this.organization.objects = res.data
      })
      this.countArea()


    },
    async savePage() {
      let data = new FormData();
      data.append('org_area', JSON.stringify(this.organization.area));
      await Axios.post(`/organization/set-org-area/${this.id_org}`, data, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(() => {
        this.getOrg();
      }).finally(() => {
        this.blockSave = true;
      })
    }
  },
  async mounted() {
    await this.getUser();
    this.id_org = this.user.id_org;
    await this.getOrg();
    this.componentReady = true;
  }
}
</script>

<style scoped>
.tooltip_width .tooltip-inner {
  min-width: 100% !important;
  margin: 0 !important;
  display: block !important;
}

.row {
  margin-top: 5px;
}

</style>