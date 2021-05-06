<template>
  <div>
    <!--<nav-bar v-on:block-save="blockSave =!blockSave" v-on:save-page="savePage" :id_org="id_org"
             :is-admin="user.isAdmin"/>-->
    <v-page>
      <div v-if="componentReady" class="container">
        <org-select v-if="$check(['admin','root'])" v-model="id_org" label="Выбранная организация"
                    link="/api/organizations/all"
                    error-msg="нет доступных организаций по заданным критериаям"/>

        <h3>Шаг 2: Сведения о количестве мест и площади жилищного фонда, используемого в уставной деятельности</h3>

        <stepper
            :back-url="user.isAdmin ? `/admin/org-info/${id_org}` : '/org-info'"
            :to-url="user.isAdmin ? `/admin/living-info/${id_org}` : '/living-info'"
            percent="40"
            end-button-label="Далее"
            @save-page="savePage"
        />
        <hr>

        <b-alert class="d-flex justify-content-start" show variant="secondary">
          <money-icon type="true"/>
          <div class="pl-3">
            <p>
              Общая площадь объектов, добавленных в модуль: {{
                (
                    +organization.area.area_prig_prozh +
                    +organization.area.area_obsh_ne_prig_dlya_prozh +
                    +organization.area.area_obj_ne_isp_v_ust_dey
                ) | toFixed
              }} кв.м.
            </p>
            <p>
              Общее количество мест во внесённых объектах: {{ organization.area.cnt_mest_all }}.
            </p>

            <p>Далее отображаются данные по объектам, используемых в уставной деятельности.</p>
          </div>
        </b-alert>

        <div class="row">
          <div class="col-12"><h4>Площадь</h4></div>
        </div>
        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Пригодная для использования площадь объектов:</label>
            {{ organization.area.area_prig_prozh | toFixed }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col ">
            <label class="ml-2  font-weight-bold">1. Жилая площадь, пригодная для проживания:</label>
            {{ organization.area.area_zhil_prig_prozh | toFixed }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="ml-4 font-weight-bold">А. Занятая обучающимися:</label>
            {{ organization.area.area_zan_obuch | toFixed }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class=" ml-4 font-weight-bold">Б. Занятая иными категориями нанимателей:</label>
            {{ organization.area.area_in_kat_nan | toFixed }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="ml-4 font-weight-bold">В. Свободная:</label>
            {{ organization.area.svobod | toFixed }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="ml-4 font-weight-bold">Г. Неиспользуемая:</label>
            {{ organization.area.ne_isp | toFixed }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col ">
            <label class="ml-2 font-weight-bold">2. Нежилая площадь в пригодных для проживания объектах:</label>
            {{ organization.area.ne_zhil_plosh_v_prig_dlya_prozh | toFixed }} м<sup>2</sup>
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Общая площадь, непригодная для использования и проживания:</label>
            {{ organization.area.area_obsh_ne_prig_dlya_prozh | toFixed }} м<sup>2</sup>
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
              <b-td>Находится в аварийном состоянии</b-td>
              <b-td>{{ organization.area.area_zhil_n_a_s || 0 }}</b-td>
              <b-td>{{ organization.area.area_ne_zhil_n_a_s || 0 }}</b-td>
              <b-th>{{ organization.area.all_n_a_s }}</b-th>
            </b-tr>
            <b-tr>
              <b-td>Непригодна для проживания по иным причинам</b-td>
              <b-td>{{ organization.area.area_zhil_n_p || 0 }}</b-td>
              <b-td>{{ organization.area.area_ne_zhil_n_p || 0 }}</b-td>
              <b-th>{{ organization.area.all_n_p }}</b-th>
            </b-tr>
          </b-tbody>
        </b-table-simple>


        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Жилая площадь, требующая капитального ремонта: </label>
            {{ organization.area.area_zhil_t_k_r | toFixed }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Не жилая площадь, требующая капитального ремонта: </label>
            {{ organization.area.area_ne_zhil_t_k_r | toFixed }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Общая площадь, требующая капитального ремонта: </label>
            {{ organization.area.all_t_k_r | toFixed}} м<sup>2</sup>
          </div>
        </div>

        <hr>

        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Количество квадратных метров жилой площади на одного проживающего: </label>
            {{ organization.area.area_kv_metr_zhil | toFixed }} м<sup>2</sup>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Количество квадратных метров общей площади на одного проживающего: </label>
            {{ organization.area.area_kv_metr_obsh | toFixed }} м<sup>2</sup>
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col">
            <label class="font-weight-bold">Площадь объектов, не используемых в уставной деятельности: </label>
            {{ organization.area.area_obj_ne_isp_v_ust_dey | toFixed }} м<sup>2</sup>
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
            {{ organization.area.area_cnt_mest_prig_prozh | toFixed}} мест
          </div>
        </div>

        <div class="row">
          <div class="col">
            <label class="ml-4 font-weight-bold">А. Количество мест, занятых обучающимися: </label>
            {{ organization.area.area_cnt_mest_zan_obuch | toFixed}} мест
          </div>
        </div>
        <b-alert v-if="temp.area_cnt_mest_zan_obuch !== organization.area.area_cnt_mest_zan_obuch" show
                 variant="danger">
          В поле выше суммируется значение количества мест, занятых обучающимися в каждом объекте, используемом в
          уставной деятельности. Сумма количества мест, внесённых в таблице ниже, равна
          <b>{{ temp.area_cnt_mest_zan_obuch }}</b>. Обратите внимание, что эти значения должны совпадать!
        </b-alert>

        <b-table-simple fixed borderless>
          <b-thead>
            <b-tr>
              <b-th>А. Количество мест, занятых обучающимися</b-th>
              <b-th>менее 6м<sup>2</sup> на одного проживающего</b-th>
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
                Высшее образование
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.m2_vis"/>
              </b-td>
              <b-td>
                <b-form-input :disabled="blockSave" v-model="area.c6m2_vis"/>
              </b-td>
              <b-th>
                <div class="mt-2">
                  {{ organization.area.all_c6m2_vis }}
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
            <label class="font-weight-bold">
              Количество мест, оборудованных для лиц с ограниченными возможностями здоровья:
            </label>
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
              фонде других организаций
            </label>
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

              {{ organization.area.area_cnt_mest_vozm_mest_is_neisp }} мест


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
              восстановительных работ: {{ organization.area.area_cnt_mest_vozm_mest_is_neprig }} мест

            </label>

            <b-tooltip custom-class="tooltip_width" target="bitch_tooltip2">
              Восстановительные работы - проведение капитального ремонта/приведения
              объекта в соответствие с установленными санитарными и техническими
              правилами и нормами, иными требованиями законодательства
            </b-tooltip>

          </div>
        </div>
        <hr>

        <div class="text-center">
          <button class="btn btn-primary" type="button" @click="setZeros()">Заполнить нулями пустые поля</button>
        </div>
        <hr>

        <stepper
            :back-url="user.isAdmin ? `/admin/org-info/${id_org}` : '/org-info'"
            :to-url="user.isAdmin ? `/admin/living-info/${id_org}` : '/living-info'"
            percent="40"
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
import Axios from 'axios';
import {BAlert, BFormInput, BInputGroup, BTableSimple, BTbody, BTd, BTh, BThead, BTooltip, BTr,} from 'bootstrap-vue';

import scrollButton from '../../organisms/scrollButton';
import OrgSelect from "../../organisms/orgSelect";
import {mainMixin} from "../../mixins";
import MoneyIcon from "../../organisms/moneyIcon";
import Loading from "../../organisms/loading";
import Stepper from "../../organisms/stepper";
import VPage from "../../organisms/vPage";

export default {
  components: {
    VPage,
    Stepper,
    Loading,
    MoneyIcon,
    OrgSelect,
    BAlert,
    scrollButton,
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
      inputs: [
        'm2_spo', 'm2_in', 'm2_vis', 'c6m2_spo', 'c6m2_in', 'c6m2_vis',
        'area_cnt_nuzhd_zhil', 'area_cnt_prozh_u_drugih',
      ],
      componentReady: false,
      temp: {
        area_cnt_mest_zan_obuch: null
      },
      area: {
        area_cnt_nuzhd_zhil: null,
        area_cnt_prozh_u_drugih: null,

        c6m2_in: null,
        c6m2_spo: null,
        c6m2_vis: null,

        m2_in: null,
        m2_spo: null,
        m2_vis: null
        //ne_isp: null,
      },
      csrf: document.getElementsByName('csrf-token')[0].content,
      blockSave: false,
      id_org: null,
      organization: {
        area: {},
        objects: []
      },
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
      async handler() {
        if (this.componentReady) {
          await this.countArea();
        }
      },
      deep: true
    }

  },
  methods: {
    async countArea() {
      let toNum = num => typeof num === 'string' ? num.toNumber() : (num || 0);

      const zil = {
        area_zan_obuch: 0,
        area_in_kat_nan: 0,
        svobod: 0,
        ne_isp: 0,
        ztkr: 0,
        nztkr: 0,
        znas: 0,
        nznas: 0,
        znp: 0,
        nznp: 0,
        cnt: 0,
        ne_ustav: 0,
        cnt_mest_pl_na_odn: 0,
        cnt_mest_obsh_na_odn: 0
      };
      let nezil = 0;
      this.organization.area.cnt_mest_all = 0;
      if (this.organization.objects)
        this.organization.objects.forEach((item) => {
          if (toNum(item.ustav_dey) && item.area) {
            zil.area_zan_obuch += toNum(item.area.zan_obuch);
            zil.area_in_kat_nan += toNum(item.area.zan_inie);
            zil.svobod += toNum(item.area.svobod);
            zil.ne_isp += toNum(item.area.neisp);
            zil.ztkr += toNum(item.area.zhil_tkr);
            zil.nztkr += toNum(item.area.nzhil_tkr);
            zil.znas += toNum(item.area.zhil_nas);
            zil.nznas += toNum(item.area.nzhil_nas)
            zil.znp += toNum(item.area.zhil_np);
            zil.nznp += toNum(item.area.nzhil_np)
            zil.cnt++;


            let temp =
                toNum(item.area.cnt_mest_zan_obuch) +
                toNum(item.area.cnt_mest_zan_in_obuch) +
                toNum(item.area.cnt_svobod_mest);
            temp = temp > 0 ? temp : 1;

            let n = toNum(item.area.punkt_pit) + toNum(item.area.pom_dlya_uch) + toNum(item.area.pom_dlya_med) +
                toNum(item.area.pom_dlya_sport) + toNum(item.area.pom_dlya_soc) + toNum(item.area.pom_dlya_kult) +
                toNum(item.area.in_nezh_plosh);

            zil.cnt_mest_pl_na_odn += (
                (
                    toNum(item.area.zan_obuch) +
                    toNum(item.area.zan_inie) +
                    toNum(item.area.svobod)
                ) / temp);
            zil.cnt_mest_obsh_na_odn += (
                (
                    toNum(item.area.zan_obuch) +
                    toNum(item.area.zan_inie) +
                    toNum(item.area.svobod) + n
                ) / temp);

            nezil += n;
          }
          if (toNum(item.ustav_dey)===0 && item.area) {
            zil.ne_ustav += (
                toNum(item.area.zan_obuch) +
                toNum(item.area.zan_inie) +
                toNum(item.area.svobod) +
                toNum(item.area.neisp) +
               // toNum(item.area.zhil_tkr) +
               // toNum(item.area.nzhil_tkr) +
                toNum(item.area.zhil_nas) +
                toNum(item.area.nzhil_nas) +
                toNum(item.area.zhil_np) +
                toNum(item.area.nzhil_np)
                + (
                    toNum(item.area.punkt_pit) +
                    toNum(item.area.pom_dlya_uch) +
                    toNum(item.area.pom_dlya_med) +
                    toNum(item.area.pom_dlya_sport) +
                    toNum(item.area.pom_dlya_soc) +
                    toNum(item.area.pom_dlya_kult) +
                    toNum(item.area.in_nezh_plosh)
                ));
          }
          if (item.area)
            this.organization.area.cnt_mest_all +=
                (
                    toNum(item.area.cnt_mest_zan_obuch) +
                    toNum(item.area.cnt_mest_zan_in_obuch) +
                    toNum(item.area.cnt_svobod_mest) +
                    toNum(item.area.cnt_neisp_mest) +
                    toNum(item.area.cnt_nepr_isp_mest)
                    //toNum(item.area.cnt_mest_inv) +
                    //toNum(item.area.cnt_mest_vozm_neisp_mest) +
                    //toNum(item.area.cnt_mest_vozm_neprig_mest)
                );
        });

      this.organization.area.area_zhil_t_k_r = zil.ztkr;
      this.organization.area.area_ne_zhil_t_k_r = zil.nztkr;

      this.organization.area.area_zhil_n_a_s = zil.znas;
      this.organization.area.area_ne_zhil_n_a_s = zil.nznas;

      this.organization.area.area_zhil_n_p = zil.znp;
      this.organization.area.area_ne_zhil_n_p = zil.nznp;

      this.organization.area.all_t_k_r = toNum(this.organization.area.area_zhil_t_k_r) +
          toNum(this.organization.area.area_ne_zhil_t_k_r);

      this.organization.area.all_n_a_s = toNum(this.organization.area.area_zhil_n_a_s) +
          toNum(this.organization.area.area_ne_zhil_n_a_s);

      this.organization.area.all_n_p = toNum(this.organization.area.area_zhil_n_p) +
          toNum(this.organization.area.area_ne_zhil_n_p);


      this.organization.area.area_obsh_ne_prig_dlya_prozh = this.organization.area.all_n_p +
          this.organization.area.all_n_a_s; //+ this.organization.area.all_t_k_r;

      this.organization.area.area_zan_obuch = zil.area_zan_obuch;
      this.organization.area.area_in_kat_nan = zil.area_in_kat_nan;
      this.organization.area.svobod = zil.svobod;
      this.organization.area.ne_isp = zil.ne_isp;
      this.organization.area.ne_zhil_plosh_v_prig_dlya_prozh = nezil;

      this.organization.area.area_zhil_prig_prozh = this.organization.area.area_zan_obuch +
          this.organization.area.area_in_kat_nan + this.organization.area.svobod + this.organization.area.ne_isp;

      this.organization.area.area_prig_prozh = this.organization.area.area_zhil_prig_prozh +
          this.organization.area.ne_zhil_plosh_v_prig_dlya_prozh;

      //const b = this.organization.area.area_obsh_ne_prig_dlya_prozh + this.organization.area.area_prig_prozh;
      this.organization.area.area_kv_metr_zhil = zil.cnt > 0 ? zil.cnt_mest_pl_na_odn / zil.cnt : 0;
      this.organization.area.area_kv_metr_obsh = zil.cnt > 0 ? zil.cnt_mest_obsh_na_odn / zil.cnt : 0;

      this.organization.area.area_obj_ne_isp_v_ust_dey = zil.ne_ustav;

      this.organization.area.all_c6m2_spo = toNum(this.area.c6m2_spo) + toNum(this.area.m2_spo);

      this.organization.area.all_c6m2_in = toNum(this.area.c6m2_in) + toNum(this.area.m2_in);
      this.organization.area.all_c6m2_vis = toNum(this.area.c6m2_vis) + toNum(this.area.m2_vis);

      this.organization.area.all_m2 =
          toNum(this.area.m2_spo) +
          toNum(this.area.m2_vis) +
          toNum(this.area.m2_in);
      this.organization.area.all_6m2 =
          toNum(this.area.c6m2_spo) +
          toNum(this.area.c6m2_vis) +
          toNum(this.area.c6m2_in);
      this.temp.area_cnt_mest_zan_obuch =
          this.organization.area.all_c6m2_spo +
          this.organization.area.all_c6m2_vis +
          this.organization.area.all_c6m2_in;
      if (this.organization.objects) {
        this.organization.area.area_cnt_mest_zan_obuch = this.organization.objects.reduce((a, b) =>
            a + toNum((b.area && toNum(b.ustav_dey)) ? b.area.cnt_mest_zan_obuch : 0), 0);
        this.organization.area.area_cnt_mest_zan_in_obuch = this.organization.objects.reduce((a, b) =>
            a + toNum((b.area && toNum(b.ustav_dey)) ? b.area.cnt_mest_zan_in_obuch : 0), 0);
        this.organization.area.area_cnt_svob_mest = this.organization.objects.reduce((a, b) =>
            a + toNum((b.area && toNum(b.ustav_dey)) ? b.area.cnt_svobod_mest : 0), 0);
        this.organization.area.area_cnt_ne_mest = this.organization.objects.reduce((a, b) =>
            a + toNum((b.area && toNum(b.ustav_dey)) ? b.area.cnt_neisp_mest : 0), 0);
        this.organization.area.area_cnt_mest_ne_prig_k_prozh = this.organization.objects.reduce((a, b) =>
            a + toNum((b.area && toNum(b.ustav_dey)) ? b.area.cnt_nepr_isp_mest : 0), 0);
        this.organization.area.area_cnt_mest_invalid = this.organization.objects.reduce((a, b) =>
            a + toNum((b.area && toNum(b.ustav_dey)) ? b.area.cnt_mest_inv : 0), 0);
        this.organization.area.area_cnt_mest_vozm_mest_is_neisp = this.organization.objects.reduce((a, b) =>
            a + toNum((b.area && toNum(b.ustav_dey)) ? b.area.cnt_mest_vozm_neisp_mest : 0), 0);
        this.organization.area.area_cnt_mest_vozm_mest_is_neprig = this.organization.objects.reduce((a, b) =>
            a + toNum((b.area && toNum(b.ustav_dey)) ? b.area.cnt_mest_vozm_neprig_mest : 0), 0);
      }

      this.organization.area.area_cnt_mest_prig_prozh = this.organization.area.area_cnt_mest_zan_obuch +
          this.organization.area.area_cnt_mest_zan_in_obuch + this.organization.area.area_cnt_svob_mest +
          this.organization.area.area_cnt_ne_mest;

      this.organization.area.area_cnt_mest = this.organization.area.area_cnt_mest_prig_prozh +
          this.organization.area.area_cnt_mest_ne_prig_k_prozh;

      this.organization.area.area_cnt_mest_vozm_k_vvodu_v_esk = this.organization.area.area_cnt_mest_vozm_mest_is_neisp +
          this.organization.area.area_cnt_mest_vozm_mest_is_neprig;

      //this.organization.area.all_t_k_r = this.organization.area.all_t_k_r.toFixed(2);
      //this.organization.area.area_kv_metr_obsh = this.organization.area.area_kv_metr_obsh.toFixed(2);
      //this.organization.area.area_kv_metr_zhil = this.organization.area.area_kv_metr_zhil.toFixed(2);
      //this.organization.area.area_obj_ne_isp_v_ust_dey = this.organization.area.area_obj_ne_isp_v_ust_dey.toFixed(0);
      //this.organization.area.area_obsh_ne_prig_dlya_prozh = this.organization.area.area_obsh_ne_prig_dlya_prozh.toFixed(2);
    },
    async getUser() {
      await Axios.get('/api/user/current').then((res) => {
        this.user = res.data;
        this.user.isAdmin = !!res.data.roles.root || !!res.data.roles.admin
      });
    },
    async getOrg() {
      await Axios.get(`/api/organization/by-id/${this.id_org}`).then((res) => {
        this.area = res.data.area || this.area;
      });
      await Axios.get(`/api/objects/org/${this.id_org}`).then((res) => {
        this.organization.objects = res.data;
      });
      await this.countArea();
      this.$forceUpdate();
    },

    validate() {

      for (let i = 0; i < this.inputs.length; i++) {
        let item = this.inputs[i];
        if (this.isEmpty(this.area[item]))
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
      data.append('org_area', JSON.stringify(this.area));
      await Axios.post(`/organization/set-org-area/${this.id_org}`, data, {
        headers: {'X-CSRF-Token': this.csrf},
      })
      resolve(true)

    },
    setZeros() {
      this.inputs.forEach(item => {
        if (this.isEmpty(this.area[item]))
          this.area[item] = 0;
      })
      this.$forceUpdate()

    },
  },
  async mounted() {
    await this.getUser();
    if (this.user.isAdmin)
      this.id_org = this.$route.fullPath.split('/')[3] || this.user.id_org
    else this.id_org = this.user.id_org;
    await this.getOrg();
    this.componentReady = true;
  },
  mixins: [mainMixin]
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
