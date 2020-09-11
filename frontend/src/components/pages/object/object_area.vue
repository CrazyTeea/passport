<template>
  <div>
    <nav-bar v-on:save-page="saveObject" v-on:block-save="blockPage = !blockPage"/>
    <transition enter-active-class="animated fadeInUp">
      <div v-if="componentReady" class="container">
        <div class="row mt-2">
          <div class="col-8"><h4>
            Сведения о площади, проживающих и количестве мест в жилом объекте
          </h4></div>
        </div>
        <div class="row">
          <div class="col-6"><label>Наименование жилого объекта</label></div>
          <div class="col-6">
            <b-form-select @change="setObject" :options="objectsTitle"/>
          </div>
        </div>

        <b-button v-if="!blockPage" :to="{name:'object',params:{modalShow:true}}" variant="outline-secondary">Добавить
          объект
        </b-button>
        <div v-if="currentObject">
          <hr>
          <h4>
            Площадь
          </h4>

          <div class="row">
            <div class="col-6"><label for="object_area">Общая площадь, пригодная для проживания</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" v-model="objArea.obsh_prig" disabled id="object_area"/>
              </b-input-group>
            </div>
          </div>
          <div class="row  mt-2">
            <div class="col-6"><label class="ml-1" for="object_area_prig">1. Жилая площадь, пригодная для
              проживания</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" disabled v-model="objArea.zhil_prig" id="object_area_prig"/>
              </b-input-group>
            </div>
          </div>
          <div class="row  mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_zan_ob1">А. Занятая обучающимися</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input :disabled="blockPage" type="number" v-model="currentObject.area.zan_obuch"
                              id="object_area_zan_ob1"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_in_kat1">Б. Занятая иными категориями
              нанимателей</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.zan_inie"
                              id="object_area_in_kat1"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_svod1">В. Свободная</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.svobod"
                              id="object_area_svod1"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_neisp1">Г. Неиспользуемая</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.neisp"
                              id="object_area_neisp1"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-1" for="object_area_ne_plosh_prig_proz1">2. Нежилая площадь в пригодных
              для проживания объектах</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" disabled v-model="objArea.ne_zhil_v_prig"
                              id="object_area_ne_plosh_prig_proz1"/>
              </b-input-group>
            </div>
          </div>


          <div class="row mt-2">
            <div class="col-6"><label class="ml-2" for="object_area_soc_inf">А. Социальная инфраструктура</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" disabled v-model="objArea.soc_inf" id="object_area_soc_inf"/>
              </b-input-group>
            </div>
          </div>
          <div class="row  mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_punkt_pit">Пункты питания</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.punkt_pit"
                              id="object_area_punkt_pit"/>
              </b-input-group>
            </div>
          </div>
          <div class="row  mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_zan_ob">Помещения для организации учебного
              процесса</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.pom_dlya_uch"
                              id="object_area_zan_ob"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_in_kat">Помещения для организации медицинского
              обслуживания</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.pom_dlya_med"
                              id="object_area_in_kat"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_svod11">Помещения для организации спортивных
              занятий</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.pom_dlya_sport"
                              id="object_area_svod11"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_neisp2">Помещения для организации культурных
              программ</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.pom_dlya_kult"
                              id="object_area_neisp2"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_ne_plosh_prig_proz23">Иные помещения социальной
              инфраструктуры</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.pom_dlya_soc"
                              id="object_area_ne_plosh_prig_proz23"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-1" for="object_area_ne_plosh_prig_proz2">Б. Иная нежилая площадь</label>
            </div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" :disabled="blockPage" v-model="currentObject.area.in_nezh_plosh"
                              id="object_area_ne_plosh_prig_proz2"/>
              </b-input-group>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-6"><label for="object_area_obsh_plosh_nep">Общая площадь, непригодная для проживания</label>
            </div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" disabled v-model="objArea.obsh_ne_prig" id="object_area_obsh_plosh_nep"/>
              </b-input-group>
            </div>
          </div>
          <b-table-simple borderless>
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
                  <b-form-input v-model="currentObject.area.zhil_tkr" :disabled="blockPage" type="number"/>
                </b-td>
                <b-td>
                  <b-form-input v-model="currentObject.area.nzhil_tkr" :disabled="blockPage" type="number"/>
                </b-td>
                <b-td>
                  <b-form-input disabled v-model="objArea.all_tkr" type="number"/>
                </b-td>
              </b-tr>
              <b-tr>
                <b-td>Находится в аварийном состоянии</b-td>
                <b-td>
                  <b-form-input v-model="currentObject.area.zhil_nas" :disabled="blockPage" type="number"/>
                </b-td>
                <b-td>
                  <b-form-input v-model="currentObject.area.nzhil_nas" :disabled="blockPage" type="number"/>
                </b-td>
                <b-td>
                  <b-form-input disabled v-model="objArea.all_nas" type="number"/>
                </b-td>
              </b-tr>
              <b-tr>
                <b-td>Непригодна для проживания</b-td>
                <b-td>
                  <b-form-input v-model="currentObject.area.zhil_np" :disabled="blockPage" type="number"/>
                </b-td>
                <b-td>
                  <b-form-input v-model="currentObject.area.nzhil_np" :disabled="blockPage" type="number"/>
                </b-td>
                <b-td>
                  <b-form-input disabled v-model="objArea.all_np" type="number"/>
                </b-td>
              </b-tr>
            </b-tbody>
          </b-table-simple>

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
            <div class="col-6"><label for="object_area_ne_plosh_prig_proz6">Количество квадратных метров жилой площади
              на одного проживающего</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" disabled v-model="objArea.cnt_mest_pl_na_odn"
                              id="object_area_ne_plosh_prig_proz6"/>
              </b-input-group>
            </div>
          </div>
          <div class="row">
            <div class="col-6"><label for="object_area_ne_plosh_prig_proz223">Количество квадратных метров общей площади
              на одного проживающего</label></div>
            <div class="col-6">
              <b-input-group append="м2">
                <b-form-input type="number" disabled v-model="objArea.cnt_mest_obsh_na_odn"
                              id="object_area_ne_plosh_prig_proz223"/>
              </b-input-group>
            </div>
          </div>

          <hr>

          <h3>Места</h3>

          <div class="row">
            <div class="col-6"><label for="object_area_svod">Количество мест</label></div>
            <div class="col-6">
              <b-input-group append="мест">
                <b-form-input type="number" disabled v-model="objArea.cnt_mest" id="object_area_svod"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-2" for="object_area_neisp6">1. Количество пригодных для проживания
              мест</label></div>
            <div class="col-6">
              <b-input-group append="мест">
                <b-form-input type="number" disabled v-model="objArea.kol_prig_mest" id="object_area_neisp6"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-4" for="object_area_ne_plosh_prig_proz7">А. Количество мест, занятых
              обучающимися</label></div>
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
            <div class="col-6"><label for="object_area_ne_plosh_prig_proz88">Количество мест, возможных к вводу в
              эксплуатацию после проведения восстановительных работ</label></div>
            <div class="col-6">
              <b-input-group append="мест">
                <b-form-input type="number" disabled v-model="objArea.cnt_mest_vozm"
                              id="object_area_ne_plosh_prig_proz88"/>
              </b-input-group>
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
        </div>


      </div>
    </transition>
    <scroll-button/>
  </div>
</template>

<script>
import NavBar from "../../organisms/NavBar";
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
  BTr
} from 'bootstrap-vue'
import Axios from "axios";
import ScrollButton from "../../organisms/scrollButton";

export default {
  name: "object_area",
  components: {
    ScrollButton,
    NavBar,
    BTooltip,
    BButton,
    BFormSelect,
    BFormInput,
    BInputGroup,
    BTableSimple,
    BThead, BTh,
    BInputGroupText,
    BTr, BTd, BTbody
  },
  async mounted() {
    await this.getUser();
    this.id_org = this.user.id_org;
    await this.getObject();
    this.componentReady = true
  },
  watch: {
    objects() {
      this.objectsTitle = [];
      this.objects.forEach((item, index) => {
        this.objectsTitle.push({
          value: index,
          text: item.name
        })
      })
    },
    currentObject: {
      handler() {
        this.objArea.zhil_prig =
            ~~parseFloat(this.currentObject.area.zan_obuch) +
            ~~parseFloat(this.currentObject.area.zan_inie) +
            ~~parseFloat(this.currentObject.area.svobod) +
            ~~parseFloat(this.currentObject.area.neisp);

        this.objArea.all_tkr =
            ~~parseFloat(this.currentObject.area.zhil_tkr) +
            ~~parseFloat(this.currentObject.area.nzhil_tkr);
        this.objArea.all_nas =
            ~~parseFloat(this.currentObject.area.zhil_nas) +
            ~~parseFloat(this.currentObject.area.nzhil_nas);
        this.objArea.all_np =
            ~~parseFloat(this.currentObject.area.zhil_np) +
            ~~parseFloat(this.currentObject.area.nzhil_np);
        this.objArea.obsh_ne_prig = this.objArea.all_tkr + this.objArea.all_nas + this.objArea.all_np


        this.objArea.soc_inf =
            ~~parseFloat(this.currentObject.area.punkt_pit) +
            ~~parseFloat(this.currentObject.area.pom_dlya_uch) +
            ~~parseFloat(this.currentObject.area.pom_dlya_med) +
            ~~parseFloat(this.currentObject.area.pom_dlya_sport) +
            ~~parseFloat(this.currentObject.area.pom_dlya_kult) +
            ~~parseFloat(this.currentObject.area.pom_dlya_soc);

        this.objArea.ne_zhil_v_prig =
            ~~parseFloat(this.objArea.soc_inf) +
            ~~parseFloat(this.currentObject.area.in_nezh_plosh);

        this.objArea.kol_prig_mest =
            ~~parseFloat(this.currentObject.area.cnt_mest_zan_obuch) +
            ~~parseFloat(this.currentObject.area.cnt_mest_zan_in_obuch) +
            ~~parseFloat(this.currentObject.area.cnt_svobod_mest) +
            ~~parseFloat(this.currentObject.area.cnt_neisp_mest);


        this.objArea.obsh_prig = ~~parseFloat(this.objArea.zhil_prig) + ~~parseFloat(this.objArea.ne_zhil_v_prig)

        this.objArea.cnt_mest = this.objArea.kol_prig_mest + ~~parseFloat(this.currentObject.area.cnt_nepr_isp_mest)
        this.objArea.cnt_mest_vozm = ~~parseFloat(this.currentObject.area.cnt_mest_vozm_neisp_mest) + ~~parseFloat(this.currentObject.area.cnt_mest_vozm_neprig_mest)
        this.objArea.cnt_mest_pl_na_odn = ( this.objArea.zhil_prig / (~~parseFloat(this.currentObject.area.cnt_mest_zan_obuch) + ~~parseFloat(this.currentObject.area.cnt_mest_zan_in_obuch))).toFixed(2)
        this.objArea.cnt_mest_obsh_na_odn = (this.objArea.obsh_prig / (~~parseFloat(this.currentObject.area.cnt_mest_zan_obuch) + ~~parseFloat(this.currentObject.area.cnt_mest_zan_in_obuch))).toFixed(2)

      },
      deep: true
    }
  },
  methods: {
    async getUser() {
      await Axios.get('/api/user/current').then(res => {
        this.user = res.data;
      });
    },
    setObject(index) {
      this.currentObject = this.objects.find((item, i) => i === index);
    },
    async getObject() {
      await Axios.get(`/api/objects/org/${this.id_org}`).then(res => {
        this.objects = res.data
        this.objects.forEach(item => {
          if (!item.area)
            item.area = {}
        })
      })
    },
    async saveObject() {
      let data = new FormData();
      data.append('area', JSON.stringify(this.currentObject.area))
      await Axios.post(`/object/set-area/${this.currentObject.id}`, data, {
        headers: {
          "X-CSRF-Token": this.csrf
        }
      }).then(res => {
        this.getObject();
      }).finally(() => {
        this.blockPage = true;
      })
    }
  },
  data() {
    return {
      csrf: document.getElementsByName("csrf-token")[0].content,
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
        cnt_mest_vozm: 0
      },
      id_org: null,
      user: Object,
      objectsTitle: [],
      objects: []
    }
  }
}
</script>

<style scoped>

</style>