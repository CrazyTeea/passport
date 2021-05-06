<template>
  <div>
    <!--<nav-bar :is-admin="user.isAdmin" :id_org="id_org" v-on:save-page="saveObject"
             v-on:block-save="blockPage = !blockPage"/>-->
    <v-page>
      <div v-if="componentReady" class="container">

        <org-select link="/api/organizations/all" error-msg="нет доступных организаций по заданным критериаям"
                    label="Выбранная организация" v-if="$check(['admin','root'])" v-model="id_org"/>

        <h3>Шаг 2: Сведения о количестве мест и площади</h3>

        <div v-if="currentObject">

          <stepper
              :back-url="user.isAdmin ?
          `/admin/objects-info/${id_org}/${$route.params.id_object}` :
          `/objects-info/${$route.params.id_object}`"
              :to-url="user.isAdmin ?
          `/admin/objects-money/${id_org}/${$route.params.id_object}` :
          `/objects-money/${$route.params.id_object}`"
              percent="40"
              end-button-label="Далее"
              @save-page="savePage"
          />
          <hr>

          <h4>Площадь</h4>

          <div class="row mb-2">
            <div class="col">
              <label class="font-weight-bold">Общая площадь: </label>
              {{ objArea.total_square | toFixed }} м2
            </div>
          </div>

          <div class="row">
            <div class="col">
              <label class="font-weight-bold">Общая площадь, пригодная для использования: </label>
              {{ objArea.obsh_prig | toFixed }} м2
            </div>
          </div>
          <div class="row  mt-2">
            <div class="col">
              <label class="ml-1 font-weight-bold">1. Жилая площадь, пригодная для проживания: </label>
              {{ objArea.zhil_prig | toFixed }} м2
            </div>
          </div>
          <div class="row  mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_zan_ob1">А. Занятая обучающимися</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input :disabled="blockPage" type="number" step="0.01" v-model="currentObject.area.zan_obuch"
                              id="object_area_zan_ob1"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_in_kat1">Б. Занятая иными категориями
              нанимателей</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" step="0.01" v-model="currentObject.area.zan_inie"
                              id="object_area_in_kat1"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_svod1">В. Свободная</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" step="0.01" v-model="currentObject.area.svobod"
                              id="object_area_svod1"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_neisp1">Г. Неиспользуемая</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" step="0.01" v-model="currentObject.area.neisp"
                              id="object_area_neisp1"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col">
              <label class="ml-1 font-weight-bold">2. Нежилая площадь в пригодных для проживания объектах:</label>
              {{ objArea.ne_zhil_v_prig | toFixed }} м2
            </div>
          </div>

          <div class="row mt-2">
            <div class="col">
              <label class="ml-2 font-weight-bold">А. Социальная инфраструктура: </label>
              {{ objArea.soc_inf | toFixed }} м2

            </div>
          </div>
          <div class="row  mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_punkt_pit">Пункты питания</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" step="0.01" v-model="currentObject.area.punkt_pit"
                              id="object_area_punkt_pit"/>
              </b-input-group>
            </div>
          </div>
          <div class="row  mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_zan_ob">Помещения для организации учебного
              процесса</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" step="0.01" v-model="currentObject.area.pom_dlya_uch"
                              id="object_area_zan_ob"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_in_kat">Помещения для организации медицинского
              обслуживания</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" step="0.01" v-model="currentObject.area.pom_dlya_med"
                              id="object_area_in_kat"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_svod11">Помещения для организации спортивных
              занятий</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" step="0.01"
                              v-model="currentObject.area.pom_dlya_sport"
                              id="object_area_svod11"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_neisp2">Помещения для организации культурных
              программ</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" step="0.01" v-model="currentObject.area.pom_dlya_kult"
                              id="object_area_neisp2"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_ne_plosh_prig_proz23">Иные помещения социальной
              инфраструктуры</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" step="0.01" v-model="currentObject.area.pom_dlya_soc"
                              id="object_area_ne_plosh_prig_proz23"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-1" for="object_area_ne_plosh_prig_proz2">Б. Иная нежилая площадь</label>
            </div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" step="0.01" v-model="currentObject.area.in_nezh_plosh"
                              id="object_area_ne_plosh_prig_proz2"/>
              </b-input-group>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col"><label class="font-weight-bold">Общая площадь, непригодная для использования: </label>
              {{ objArea.obsh_ne_prig | toFixed }} м2

            </div>
          </div>
          <b-table-simple borderless>
            <b-thead>
              <b-tr>
                <b-th>Общая площадь, непригодная для использования</b-th>
                <b-th>Жилая площадь</b-th>
                <b-th>Нежилая площадь</b-th>
                <b-th>Общая площадь</b-th>
              </b-tr>
            </b-thead>
            <b-tbody>

              <b-tr>
                <b-td>Находится в аварийном состоянии</b-td>
                <b-td>
                  <b-form-input v-model="currentObject.area.zhil_nas" step="0.01" :disabled="blockPage" type="number"/>
                </b-td>
                <b-td>
                  <b-form-input v-model="currentObject.area.nzhil_nas" step="0.01" :disabled="blockPage" type="number"/>
                </b-td>
                <b-td>
                  <div class="font-weight-bold mt-1">
                    {{ objArea.all_nas | toFixed }}
                  </div>
                </b-td>
              </b-tr>
              <b-tr>
                <b-td>Непригодна для использования по иным причинам</b-td>
                <b-td>
                  <b-form-input v-model="currentObject.area.zhil_np" step="0.01" :disabled="blockPage" type="number"/>
                </b-td>
                <b-td>
                  <b-form-input v-model="currentObject.area.nzhil_np" step="0.01" :disabled="blockPage" type="number"/>
                </b-td>
                <b-td>
                  <div class="font-weight-bold mt-1">
                    {{ objArea.all_np | toFixed }}
                  </div>
                </b-td>
              </b-tr>
            </b-tbody>
          </b-table-simple>

          <div class="row">
            <div class="col-6"><label for="object_area_zhil_tkr">Жилая площадь, требующая капитального ремонта</label>
            </div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" step="0.01" v-model="currentObject.area.zhil_tkr"
                              id="object_area_zhil_tkr"/>
              </b-input-group>
            </div>
          </div>
          <div class="row">
            <div class="col-6"><label for="object_area_nzhil_tkr">Не жилая площадь, требующая капитального
              ремонта</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" step="0.01" v-model="currentObject.area.nzhil_tkr"
                              id="object_area_nzhil_tkr"/>
              </b-input-group>
            </div>
          </div>
          <div class="row">
            <div class="col-6"><label>Общая площадь, требующая капитального ремонта</label></div>
            <div class="col-6">
              <div class="font-weight-bold mt-1">
                {{ objArea.all_tkr | toFixed }}
              </div>
            </div>
          </div>


          <hr>

          <div class="row">
            <div class="col-6"><label for="object_area_svod3">Предоставлено в аренду</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.aren"
                              id="object_area_svod3"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label for="object_area_neisp4">Предоставлено в безвозмездное пользование</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.pbp"
                              id="object_area_neisp4"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col">
              <label class="font-weight-bold">Количество квадратных метров жилой площади на одного
                проживающего: </label>

              {{ objArea.cnt_mest_pl_na_odn | toFixed }} м2

            </div>
          </div>
          <div class="row">
            <div class="col">
              <label class="font-weight-bold">Количество квадратных метров общей площади на одного
                проживающего: </label>
              {{ objArea.cnt_mest_obsh_na_odn | toFixed }} м2

            </div>
          </div>

          <hr>

          <h3>Места</h3>

          <div class="row">
            <div class="col-6"><label class="font-weight-bold">Количество мест: </label>
              {{ objArea.cnt_mest }} мест

            </div>
          </div>
          <div class="row mt-2">
            <div class="col">
              <label class="ml-2 font-weight-bold">1. Количество пригодных для проживания мест:</label>
              {{ objArea.kol_prig_mest }} мест

            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-4" for="object_area_ne_plosh_prig_proz7">А. Количество мест, занятых обучающимися</label>
            </div>
            <div class="col-6">
              <b-input-group append="мест">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.cnt_mest_zan_obuch"
                              id="object_area_ne_plosh_prig_proz7"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_ne_plosh_prig_proz77">Б. Количество мест, занятых
              иными категориями проживающих</label></div>
            <div class="col-6">
              <b-input-group append="мест">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.cnt_mest_zan_in_obuch"
                              id="object_area_ne_plosh_prig_proz77"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_ne_plosh_prig_proz8">В. Количество свободных
              мест</label></div>
            <div class="col-6">
              <b-input-group append="мест">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.cnt_svobod_mest"
                              id="object_area_ne_plosh_prig_proz8"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_ne_plosh_prig_proz9">Г. Количество неиспользуемых
              мест</label></div>
            <div class="col-6">
              <b-input-group append="мест">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.cnt_neisp_mest"
                              id="object_area_ne_plosh_prig_proz9"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6"><label class="ml-2" for="object_area_neisp5">2. Количество непригодных к использованию
              мест</label></div>
            <div class="col-6">
              <b-input-group append="мест">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.cnt_nepr_isp_mest"
                              id="object_area_neisp5"/>
              </b-input-group>
            </div>
          </div>

          <hr>
          <div class="row">
            <div class="col-6"><label for="object_area_ne_plosh_prig_proz21">Количество мест, оборудованных для лиц с
              ограниченными возможностями здоровья</label></div>
            <div class="col-6">
              <b-input-group append="мест">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.cnt_mest_inv"
                              id="object_area_ne_plosh_prig_proz21"/>
              </b-input-group>
            </div>
          </div>
          <div class="row">
            <div class="col"><label class="font-weight-bold">Количество мест, возможных к вводу в эксплуатацию после
              проведения восстановительных работ: </label>
              {{ objArea.cnt_mest_vozm }} мест
            </div>
          </div>
          <div class="row">
            <div class="col-6"><label class="ml-4" for="object_area_ne_plosh_prig_proz">1. Количество мест, возможных к
              вводу в эксплуатацию из числа неиспользуемых после проведения восстановительных работ</label></div>
            <div class="col-6">
              <b-input-group append="мест">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip">
                    Восстановительные работы - проведение капитального ремонта/приведения
                    объекта в соответствие с установленными санитарными и техническими
                    правилами и нормами, иными требованиями законодательства
                  </b-tooltip>
                </template>
                <b-form-input :disabled="blockPage" type="number" v-model="currentObject.area.cnt_mest_vozm_neisp_mest"
                              id="object_area_ne_plosh_prig_proz"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_neisp">2. Количество мест, возможных к вводу в
              эксплуатацию из числа непригодных к использованию после проведения восстановительных работ</label></div>
            <div class="col-6">
              <b-input-group append="мест">
                <template v-slot:prepend>
                  <b-input-group-text>
                    <i id="huy_mest_tooltip2" class="fas fa-question-circle"></i>
                  </b-input-group-text>
                  <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip2">
                    Восстановительные работы - проведение капитального ремонта/приведения
                    объекта в соответствие с установленными санитарными и техническими
                    правилами и нормами, иными требованиями законодательства
                  </b-tooltip>
                </template>
                <b-form-input :disabled="blockPage" type="number" v-model="currentObject.area.cnt_mest_vozm_neprig_mest"
                              id="object_area_neisp"/>
              </b-input-group>
            </div>
          </div>

          <stepper
              :back-url="user.isAdmin ?
          `/admin/objects-info/${id_org}/${$route.params.id_object}` :
          `/objects-info/${$route.params.id_object}`"
              :to-url="user.isAdmin ?
          `/admin/objects-money/${id_org}/${$route.params.id_object}` :
          `/objects-money/${$route.params.id_object}`"
              percent="40"
              end-button-label="Далее"
              @save-page="savePage"
          />
          <br>
          <hr>
          <div class="text-center">
            <button class="btn btn-primary" type="button" @click="setZeros()">Заполнить нулями пустые поля</button>
          </div>
          <hr>
        </div>

      </div>
      <loading v-else/>
    </v-page>

    <scroll-button/>
  </div>
</template>

<script>
import {
  BButton,
  BFormInput,
  BFormSelect,
  BInputGroup,
  BInputGroupText,
  BTableSimple,
  BTbody,
  BTd,
  BTh,
  BThead,
  BTooltip,
  BTr,
} from 'bootstrap-vue';
import Axios from 'axios';

import ScrollButton from '../../organisms/scrollButton';
import OrgSelect from "../../organisms/orgSelect";
import {mainMixin} from "../../mixins";
import Loading from "../../organisms/loading";
import Stepper from "../../organisms/stepper";
import VPage from "../../organisms/vPage";

export default {
  name: 'object_area',
  components: {
    VPage,
    Stepper,
    Loading,
    OrgSelect,
    ScrollButton,
    BTooltip,
    BButton,
    BFormSelect,
    BFormInput,
    BInputGroup,
    BTableSimple,
    BThead,
    BTh,
    BInputGroupText,
    BTr,
    BTd,
    BTbody,
  },
  async mounted() {
    await this.getUser();

    if (this.user.isAdmin) this.id_org = this.$route.fullPath.split('/')[3] || this.user.id_org
    else this.id_org = this.user.id_org;

    //this.blockPage = this.user.isAdmin;
    await this.getObject();
    this.componentReady = true;
  },
  watch: {
    async id_org() {
      if (this.componentReady)
        await this.getObject();
    },
    objects() {
      this.objectsTitle = this.objects.map((item, index) => ({
        value: index,
        text: `${item.name} [${item.kad_number}]`,
      }));
    },
    currentObject: {
      handler() {

        let toNum = num => typeof num === 'string' ? num.toNumber() : (!num ? 0 : num);

        this.objArea.zhil_prig =
            toNum(this.currentObject.area.zan_obuch) +
            toNum(this.currentObject.area.zan_inie) +
            toNum(this.currentObject.area.svobod) +
            toNum(this.currentObject.area.neisp);

        this.objArea.all_tkr =
            toNum(this.currentObject.area.zhil_tkr) +
            toNum(this.currentObject.area.nzhil_tkr);

        this.objArea.all_nas =
            toNum(this.currentObject.area.zhil_nas) +
            toNum(this.currentObject.area.nzhil_nas);

        this.objArea.all_np =
            toNum(this.currentObject.area.zhil_np) +
            toNum(this.currentObject.area.nzhil_np);

        this.objArea.obsh_ne_prig =
            //this.objArea.all_tkr +
            this.objArea.all_nas +
            this.objArea.all_np;

        this.objArea.soc_inf =
            toNum(this.currentObject.area.punkt_pit) +
            toNum(this.currentObject.area.pom_dlya_uch) +
            toNum(this.currentObject.area.pom_dlya_med) +
            toNum(this.currentObject.area.pom_dlya_sport) +
            toNum(this.currentObject.area.pom_dlya_kult) +
            toNum(this.currentObject.area.pom_dlya_soc);

        this.objArea.ne_zhil_v_prig =
            this.objArea.soc_inf +
            toNum(this.currentObject.area.in_nezh_plosh);

        this.objArea.kol_prig_mest =
            toNum(this.currentObject.area.cnt_mest_zan_obuch) +
            toNum(this.currentObject.area.cnt_mest_zan_in_obuch) +
            toNum(this.currentObject.area.cnt_svobod_mest) +
            toNum(this.currentObject.area.cnt_neisp_mest);

        this.objArea.obsh_prig = this.objArea.zhil_prig + this.objArea.ne_zhil_v_prig;
        this.objArea.cnt_mest = this.objArea.kol_prig_mest + toNum(this.currentObject.area.cnt_nepr_isp_mest);
        this.objArea.cnt_mest_vozm = toNum(this.currentObject.area.cnt_mest_vozm_neisp_mest) + toNum(this.currentObject.area.cnt_mest_vozm_neprig_mest);

        let temp =
            toNum(this.currentObject.area.cnt_mest_zan_obuch) +
            toNum(this.currentObject.area.cnt_mest_zan_in_obuch) +
            toNum(this.currentObject.area.cnt_svobod_mest);
        temp = temp > 0 ? temp : 1;

        this.objArea.cnt_mest_pl_na_odn =
            (toNum(this.currentObject.area.zan_obuch) +
                toNum(this.currentObject.area.zan_inie) +
                toNum(this.currentObject.area.svobod)
            ) / temp;
        this.objArea.cnt_mest_obsh_na_odn = (
            toNum(this.currentObject.area.zan_obuch) +
            toNum(this.currentObject.area.zan_inie) +
            toNum(this.currentObject.area.svobod) +
            this.objArea.ne_zhil_v_prig
        ) / temp;


        this.objArea.total_square = this.objArea.obsh_prig + this.objArea.obsh_ne_prig;
      },
      deep: true,
    },
  },
  methods: {
    async getUser() {
      await Axios.get('/api/user/current').then((res) => {
        this.user = res.data;
        this.user.isAdmin = !!res.data.roles.root || !!res.data.roles.admin
      });
    },
    setObject(index) {
      this.currentObject = this.objects.find((item, i) => i === index);
    },
    async getObject() {
      await Axios.get(`/api/objects/org/${this.id_org}/${this.$route.params.id_object}`).then((res) => {
        this.currentObject = res.data;
        if (!this.currentObject.area) {
          this.currentObject.area = {};
        }
      });
    },
    setZeros() {
      this.inputs.forEach(item => {

        if (this.isEmpty(this.currentObject.area[item]))
          this.currentObject.area[item] = 0;

      })
      this.$forceUpdate()
    },


    validate() {
      for (let i = 0; i < this.inputs.length; i++) {
        let item = this.inputs[i];
        if (this.isEmpty(this.currentObject.area[item]))
          return false;
      }
      return true;
    },


    async savePage(validate, resolve) {

      if (validate && !this.validate()) {
        await this.$bvModal.msgBoxOk("Для сохранения необходимо заполнить пустые поля.");
        resolve(false);
        return;
      }
      const data = new FormData();
      this.currentObject.area.cnt_mest_pl_na_odn = this.objArea.cnt_mest_pl_na_odn;
      this.currentObject.area.cnt_mest_obsh_na_odn = this.objArea.cnt_mest_obsh_na_odn;
      data.append('area', JSON.stringify(this.currentObject.area));
      await Axios.post(`/object/set-area/${this.currentObject.id}`, data, {
        headers: {
          'X-CSRF-Token': this.csrf,
        },
      });
      resolve(true)
    },
  },
  data() {
    return {
      csrf: document.getElementsByName('csrf-token')[0].content,
      blockPage: false,
      currentObject: null,
      componentReady: false,
      objArea: {
        obsh_prig: 0,
        zhil_prig: 0,
        ne_zhil_v_prig: 0,
        soc_inf: 0,
        obsh_ne_prig: 0,
        all_tkr: 0,
        all_nas: 0,
        all_np: 0,
        cnt_mest_pl_na_odn: 0,
        cnt_mest_obsh_na_odn: 0,
        cnt_mest: 0,
        kol_prig_mest: 0,
        cnt_mest_vozm: 0,
        total_square: 0,
      },
      inputs: [
        'zan_obuch',
        'zan_inie',
        'svobod',
        'neisp',
        'punkt_pit',
        'pom_dlya_uch',
        'pom_dlya_med',
        'pom_dlya_sport',
        'pom_dlya_soc',
        'in_nezh_plosh',
        'zhil_tkr',
        'zhil_nas',
        'zhil_np',
        'nzhil_tkr',
        'nzhil_nas',
        'nzhil_np',
        'aren',
        'pbp',
        'cnt_mest_zan_obuch',
        'cnt_mest_zan_in_obuch',
        'cnt_svobod_mest',
        'cnt_neisp_mest',
        'cnt_nepr_isp_mest',
        'cnt_mest_inv',
        'cnt_mest_vozm_neisp_mest',
        'cnt_mest_vozm_neprig_mest',
        'pom_dlya_kult',
      ],
      id_org: null,
      user: Object,
      objectsTitle: [],
      objects: [],
    };
  },
  mixins: [mainMixin]
};
</script>

<style scoped/>