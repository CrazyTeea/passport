<template>
  <div>
    <nav-bar :is-admin="user.isAdmin" :id_org="id_org" v-on:save-page="savePage"
             v-on:block-save="blockSave =!blockSave"/>
    <transition enter-active-class="animated fadeInUp">
      <div v-if="componentReady" class="container">


        <org-select link="/api/organizations/all" error-msg="нет доступных организаций по заданным критериаям"
                    label="Выбранная организация" v-can:admin,root v-model="id_org"/>

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
            {{ organization.area.area_prig_prozh }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col "><label class="ml-2  font-weight-bold">1. Жилая площадь, пригодная для проживания:</label>
            {{ organization.area.area_zhil_prig_prozh }} м<sup>2</sup>

          </div>
        </div>
        <div class="row">
          <div class="col"><label class="ml-4 font-weight-bold">А. Занятая обучающимися:</label>
            {{ organization.area.area_zan_obuch }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col"><label class=" ml-4 font-weight-bold">Б. Занятая иными категориями нанимателей:</label>
            {{ organization.area.area_in_kat_nan }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col"><label class="ml-4 font-weight-bold">В. Свободная:</label>
            {{ organization.area.svobod }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col"><label class="ml-4 font-weight-bold">Г. Неиспользуемая:</label>
            {{ organization.area.ne_isp }} м<sup>2</sup>

          </div>
        </div>
        <div class="row">
          <div class="col "><label class="ml-2 font-weight-bold">2. Нежилая площадь в пригодных для проживания
            объектах:</label>
            {{ organization.area.ne_zhil_plosh_v_prig_dlya_prozh }} м<sup>2</sup>
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col"><label class="font-weight-bold">Общая площадь, непригодная для проживания:</label>
            {{ organization.area.area_obsh_ne_prig_dlya_prozh }} м<sup>2</sup>
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
              <b-td>Требует капитального ремонта</b-td>
              <b-td>
                {{ organization.area.area_zhil_t_k_r || 0 }}
              </b-td>
              <b-td>
                {{ organization.area.area_ne_zhil_t_k_r || 0 }}
              </b-td>
              <b-th>
                {{ organization.area.all_t_k_r }}
              </b-th>
            </b-tr>
            <b-tr>
              <b-td>Находится в аварийном состоянии</b-td>
              <b-td>
                {{ organization.area.area_zhil_n_a_s || 0 }}
              </b-td>
              <b-td>
                {{ organization.area.area_ne_zhil_n_a_s || 0 }}
              </b-td>
              <b-th>
                {{ organization.area.all_n_a_s }}
              </b-th>
            </b-tr>
            <b-tr>
              <b-td>Непригодна для проживания</b-td>
              <b-td>
                {{ organization.area.area_zhil_n_p || 0 }}
              </b-td>
              <b-td>
                {{ organization.area.area_ne_zhil_n_p || 0 }}
              </b-td>
              <b-th>
                {{ organization.area.all_n_p }}
              </b-th>
            </b-tr>
          </b-tbody>
        </b-table-simple>

        <hr>

        <div class="row">
          <div class="col"><label class="font-weight-bold">Количество квадратных метров жилой площади на одного
            проживающего: </label>
            {{ organization.area.area_kv_metr_zhil }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col"><label class="font-weight-bold">Количество квадратных метров общей площади на одного
            проживающего: </label>
            {{ organization.area.area_kv_metr_obsh }} м <sup>2</sup>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col"><label class="font-weight-bold">Площадь объектов, не используемых в уставной
            деятельности: </label>
            {{ organization.area.area_obj_ne_isp_v_ust_dey }} м<sup>2</sup>
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
            {{ organization.area.area_cnt_mest }} мест
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="ml-2 font-weight-bold">1. Количество пригодных для проживания мест: </label>
            {{ organization.area.area_cnt_mest_prig_prozh }} мест
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label class="ml-4 font-weight-bold">А. Количество мест, занятых обучающимися: </label>
            {{ organization.area.area_cnt_mest_zan_obuch }} мест
          </div>
        </div>
        <b-alert v-if="temp.area_cnt_mest_zan_obuch !== organization.area.area_cnt_mest_zan_obuch" show variant="info">
          В поле выше суммируется значение количества мест, занятых обучающимися в каждом объекте.
          Сумма количества мест, внесённых в таблице ниже, равна {{ temp.area_cnt_mest_zan_obuch }}.
          Обратите внимание, что эти значения должны совпадать!
        </b-alert>

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
              <b-td>
                Среднее профессиональное образование
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.m2_spo"/>
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.c6m2_spo"/>
              </b-td>
              <b-th>
                <div class="mt-2">
                  {{ organization.area.all_c6m2_spo }}
                </div>

              </b-th>
            </b-tr>
            <b-tr>
              <b-td>
                Бакалавриат
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.m2_bak"/>
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.c6m2_bak"/>
              </b-td>
              <b-th>
                <div class="mt-2">
                  {{ organization.area.all_c6m2_bak || 0 }}
                </div>
              </b-th>
            </b-tr>
            <b-tr>
              <b-td>
                Специалитет
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.m2_spec"/>
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.c6m2_spec"/>
              </b-td>
              <b-th>
                <div class="mt-2">
                  {{ organization.area.all_c6m2_spec || 0 }}
                </div>
              </b-th>
            </b-tr>
            <b-tr>
              <b-td>
                Магистратура
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.m2_mag"/>
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.c6m2_mag"/>
              </b-td>
              <b-th>
                <div class="mt-2">
                  {{ organization.area.all_c6m2_mag || 0 }}
                </div>
              </b-th>
            </b-tr>
            <b-tr>
              <b-td>
                Аспирантура
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.m2_asp"/>
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.c6m2_asp"/>
              </b-td>
              <b-th>
                <div class="mt-2">
                  {{ organization.area.all_c6m2_asp || 0 }}
                </div>
              </b-th>
            </b-tr>
            <b-tr>
              <b-td>
                Ординатрура
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.m2_ord"/>
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.c6m2_ord"/>
              </b-td>
              <b-th>
                <div class="mt-2">
                  {{ organization.area.all_c6m2_ord || 0 }}
                </div>
              </b-th>
            </b-tr>
            <b-tr>
              <b-td>
                Иные обучающиеся
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.m2_in"/>
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.c6m2_in"/>
              </b-td>
              <b-th>
                <div class="mt-2">
                  {{ organization.area.all_c6m2_in || 0 }}
                </div>
              </b-th>
            </b-tr>
            <b-tr>
              <b-th>
                Всего
              </b-th>
              <b-th>
                <div class="ml-3">
                  {{ organization.area.all_m2 }}
                </div>
              </b-th>
              <b-th>
                <div class="ml-3">
                  {{ organization.area.all_6m2 }}
                </div>
              </b-th>
              <b-th>
                <div class="ml-3">
                  {{ organization.area.all_all }}
                </div>
              </b-th>
            </b-tr>
          </b-tbody>
        </b-table-simple>
        <div class="row">
          <div class="col">
            <label class="ml-4 font-weight-bold">Б. Количество мест, занятых иными категориями проживающих: </label>
            {{ organization.area.area_cnt_mest_zan_in_obuch }} мест
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="ml-4 font-weight-bold">В. Количество свободных мест: </label>
            {{ organization.area.area_cnt_svob_mest }} мест

          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="ml-4 font-weight-bold">Г. Количество неиспользуемых мест: </label>
            {{ organization.area.area_cnt_ne_mest }} мест
          </div>
        </div>
        <div></div>

        <div class="row">
          <div class="col">
            <label class=" ml-2 font-weight-bold">2. Количество непригодных к использованию мест: </label>
            {{ organization.area.area_cnt_mest_ne_prig_k_prozh }} мест
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Количество мест, оборудованных для лиц с ограниченными возможностями
              здоровья: </label>
            {{ organization.area.area_cnt_mest_invalid }} мест
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <label class="font-weight-bold" for="org_area_cnt_mest_nuzd">Количество обучающихся, нуждающихся в
              жилье: </label>
          </div>
          <div class="col-6">
            <b-input-group append="человек">
              <b-form-input step="1" type="number"
                            id="org_area_cnt_mest_nuzd"
                            v-model="area.area_cnt_nuzhd_zhil"
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
              <b-form-input step="1" type="number" id="org_area_cnt_live_in_other"
                            v-model="area.area_cnt_prozh_u_drugih"
                            :disabled="blockSave"/>
            </b-input-group>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Количество мест, возможных к вводу в эксплуатацию после проведения
              восстановительных работ: </label>
            {{ organization.area.area_cnt_mest_vozm_k_vvodu_v_esk }} мест
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label class="ml-2 font-weight-bold">
              1. <i id="bitch_tooltip" class="fas fa-question-circle"></i> Количество мест, возможных к вводу в
              эксплуатацию из числа неиспользуемых после проведения восстановительных работ:
              <div class="text-black-50">
                {{ organization.area.area_cnt_mest_vozm_mest_is_neisp }} мест
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
                {{ organization.area.area_cnt_mest_vozm_mest_is_neprig }} мест
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
import {BAlert, BFormInput, BInputGroup, BTableSimple, BTbody, BTd, BTh, BThead, BTooltip, BTr,} from 'bootstrap-vue';
import NavBar from '../../organisms/NavBar';
import scrollButton from '../../organisms/scrollButton';
import OrgSelect from "../../organisms/orgSelect";

export default {
  components: {
    OrgSelect,
    BAlert,
    scrollButton,
    NavBar,
    BTooltip,
    BInputGroup,
    BFormInput,
    BTableSimple,
    BThead,
    BTbody,
    BTh,
    BTd,
    BTr,
  },
  data() {
    return {
      componentReady: false,
      temp: {
        area_cnt_mest_zan_obuch: null
      },
      area: {
        area_cnt_nuzhd_zhil: null,
        area_cnt_prozh_u_drugih: null,
        c6m2_asp: null,
        c6m2_bak: null,
        c6m2_in: null,
        c6m2_mag: null,
        c6m2_ord: null,
        c6m2_spec: null,
        c6m2_spo: null,
        m2_asp: null,
        m2_bak: null,
        m2_in: null,
        m2_mag: null,
        m2_ord: null,
        m2_spec: null,
        m2_spo: null,
        ne_isp: null,
      },
      csrf: document.getElementsByName('csrf-token')[0].content,
      blockSave: false,
      id_org: null,
      organization: null,
      user: {},
    };
  },
  computed: {},
  watch: {
    async id_org() {
      if (this.componentReady)
        await this.getOrg()
    },
    area: {
      handler() {
        if (this.componentReady) {
          this.countArea();
        }
      },
      deep: true
    }

  },
  methods: {
    countArea() {

      let toNum = num => typeof num === 'string' ? num.toNumber() : (num || 0);

      const zil = {
        area_zan_obuch: 0,
        area_in_kat_nan: 0,
        svobod: 0,
        ne_isp: 0,
      };
      let nezil = 0;

      this.organization.objects?.forEach((item) => {
        if (item.area) {
          zil.area_zan_obuch += toNum(item.area.zan_obuch);
          zil.area_in_kat_nan += toNum(item.area.zan_inie);
          zil.svobod = toNum(item.area.svobod);
          zil.ne_isp = toNum(item.area.neisp);

          nezil += (
              toNum(item.area.punkt_pit) +
              toNum(item.area.pom_dlya_uch) +
              toNum(item.area.pom_dlya_med) +
              toNum(item.area.pom_dlya_sport) +
              toNum(item.area.pom_dlya_soc) +
              toNum(item.area.pom_dlya_kult) +
              toNum(item.area.in_nezh_plosh)
          );
        }
      });

      this.organization.area.all_t_k_r =
          toNum(this.organization.area.area_zhil_t_k_r) +
          toNum(this.organization.area.area_ne_zhil_t_k_r);

      this.organization.area.all_n_a_s =
          toNum(this.organization.area.area_zhil_n_a_s) +
          toNum(this.organization.area.area_ne_zhil_n_a_s);

      this.organization.area.all_n_p =
          toNum(this.organization.area.area_zhil_n_p) +
          toNum(this.organization.area.area_ne_zhil_n_p);


      this.organization.area.area_obsh_ne_prig_dlya_prozh =
          this.organization.area.all_n_p +
          this.organization.area.all_n_a_s +
          this.organization.area.all_t_k_r;


      this.organization.area.area_zan_obuch = zil.area_zan_obuch;
      this.organization.area.area_in_kat_nan = zil.area_in_kat_nan;
      this.organization.area.svobod = zil.svobod;
      this.organization.area.ne_isp = zil.ne_isp;
      this.organization.area.ne_zhil_plosh_v_prig_dlya_prozh = nezil;

      this.organization.area.area_zhil_prig_prozh = this.organization.area.area_zan_obuch +
          this.organization.area.area_in_kat_nan +
          this.organization.area.svobod +
          this.organization.area.ne_isp;

      this.organization.area.area_prig_prozh = this.organization.area.area_zhil_prig_prozh +
          this.organization.area.ne_zhil_plosh_v_prig_dlya_prozh;

      const b = this.organization.area.area_zan_obuch + this.organization.area.area_in_kat_nan;
      this.organization.area.area_kv_metr_zhil = b > 0 ? (this.organization.area.area_zhil_prig_prozh / (b)) : 0;
      this.organization.area.area_kv_metr_obsh = b > 0 ? (this.organization.area.area_prig_prozh / (b)) : 0;

      this.organization.area.area_obj_ne_isp_v_ust_dey = this.organization.area.area_obsh_ne_prig_dlya_prozh +
          this.organization.area.area_prig_prozh;


      this.organization.area.all_c6m2_spo = toNum(this.area.c6m2_spo) + toNum(this.area.m2_spo);
      this.organization.area.all_c6m2_spec = toNum(this.area.c6m2_spec) + toNum(this.area.m2_spec);
      this.organization.area.all_c6m2_bak = toNum(this.area.c6m2_bak) + toNum(this.area.m2_bak);
      this.organization.area.all_c6m2_asp = toNum(this.area.c6m2_asp) + toNum(this.area.m2_asp);
      this.organization.area.all_c6m2_mag = toNum(this.area.c6m2_mag) + toNum(this.area.m2_mag);
      this.organization.area.all_c6m2_ord = toNum(this.area.c6m2_ord) + toNum(this.area.m2_ord);
      this.organization.area.all_c6m2_in = toNum(this.area.c6m2_in) + toNum(this.area.m2_in);

      this.organization.area.all_m2 =
          toNum(this.area.m2_spo) +
          toNum(this.area.m2_spec) +
          toNum(this.area.m2_bak) +
          toNum(this.area.m2_asp) +
          toNum(this.area.m2_mag) +
          toNum(this.area.m2_ord) +
          toNum(this.area.m2_in)
      this.organization.area.all_6m2 =
          toNum(this.area.c6m2_spo) +
          toNum(this.area.c6m2_spec) +
          toNum(this.area.c6m2_bak) +
          toNum(this.area.c6m2_asp) +
          toNum(this.area.c6m2_mag) +
          toNum(this.area.c6m2_ord) +
          toNum(this.area.c6m2_in)
      this.temp.area_cnt_mest_zan_obuch = +this.organization.area.all_c6m2_spo +
          +this.organization.area.all_c6m2_spec +
          +this.organization.area.all_c6m2_bak +
          +this.organization.area.all_c6m2_asp +
          +this.organization.area.all_c6m2_mag +
          +this.organization.area.all_c6m2_ord +
          +this.organization.area.all_c6m2_in
      this.organization.area.area_cnt_mest_zan_obuch = this.organization.objects?.reduce((a, b) => a + toNum((b.area) ? b.area.cnt_mest_zan_obuch : 0), 0);
      this.organization.area.area_cnt_mest_zan_in_obuch = this.organization.objects?.reduce((a, b) => a + toNum(b.area ? b.area.cnt_mest_zan_in_obuch : 0), 0);
      this.organization.area.area_cnt_svob_mest = this.organization.objects?.reduce((a, b) => a + toNum(b.area ? b.area.cnt_svobod_mest : 0), 0);
      this.organization.area.area_cnt_ne_mest = this.organization.objects?.reduce((a, b) => a + toNum(b.area ? b.area.cnt_neisp_mest : 0), 0);
      this.organization.area.area_cnt_mest_ne_prig_k_prozh = this.organization.objects?.reduce((a, b) => a + toNum(b.area ? b.area.cnt_nepr_isp_mest : 0), 0);
      this.organization.area.area_cnt_mest_invalid = this.organization.objects?.reduce((a, b) => a + toNum(b.area ? b.area.cnt_mest_inv : 0), 0);
      this.organization.area.area_cnt_mest_vozm_mest_is_neisp = this.organization.objects?.reduce((a, b) => a + toNum(b.area ? b.area.cnt_mest_vozm_neisp_mest : 0), 0);
      this.organization.area.area_cnt_mest_vozm_mest_is_neprig = this.organization.objects?.reduce((a, b) => a + toNum(b.area ? b.area.cnt_mest_vozm_neprig_mest : 0), 0);

      this.organization.area.area_cnt_mest_prig_prozh = this.organization.area.area_cnt_mest_zan_obuch +
          this.organization.area.area_cnt_mest_zan_in_obuch +
          this.organization.area.area_cnt_svob_mest +
          this.organization.area.area_cnt_ne_mest;

      this.organization.area.area_cnt_mest = this.organization.area.area_cnt_mest_prig_prozh +
          this.organization.area.area_cnt_mest_ne_prig_k_prozh;

      this.organization.area.area_cnt_mest_vozm_k_vvodu_v_esk = this.organization.area.area_cnt_mest_vozm_mest_is_neisp +
          this.organization.area.area_cnt_mest_vozm_mest_is_neprig;

    },
    async getUser() {
      await Axios.get('/api/user/current').then((res) => {
        this.user = res.data;
        this.user.isAdmin = !!res.data.roles.root || !!res.data.roles.admin
      });
    },
    async getOrg() {
      await Axios.get(`/api/organization/by-id/${this.id_org}`).then((res) => {
        this.organization = res.data;
        this.organization.area = res.data.area ?? {};
        this.area = this.organization.area;
      });
      await Axios.get(`/api/objects/org/${this.id_org}`).then((res) => {
        this.organization.objects = res.data;
      });
      this.countArea();
    },
    async savePage() {
      const data = new FormData();
      data.append('org_area', JSON.stringify(this.area));
      await Axios.post(`/organization/set-org-area/${this.id_org}`, data, {
        headers: {
          'X-CSRF-Token': this.csrf,
        },
      }).then(() => {
        this.getOrg();
      }).finally(() => {
        this.blockSave = true;
      });
    },
  },
  async mounted() {
    await this.getUser();
    if (this.user.isAdmin)
      this.id_org = this.$route.fullPath.split('/')[3] || this.user.id_org
    else this.id_org = this.user.id_org;

    this.blockSave = this.user.isAdmin;


    await this.getOrg();
    this.componentReady = true;

    //console.log('22,222'.toNumber(), '22.222'.toNumber(), 'a,a,a'.toNumber(), 'adasdas'.toNumber(), '22,2,2'.toNumber());


  },
};
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
