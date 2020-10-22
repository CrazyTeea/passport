<template>
  <div v-if="ready" class="page-obj">
    <nav-bar :id_org="id_org" v-on:save-page="savePage" v-on:block-save="disablePage = !disablePage"/>
    <transition enter-active-class="animated fadeInUp">
      <div v-if="componentReady" class="container">
        <div class="row">
          <div class="col-8">
            <h3>
              Сведения о жилом объекте
            </h3>
          </div>
        </div>
        <hr>

        <div class="row">
          <div class="col-6"><label>Наименование жилого объекта</label></div>
          <div class="col-6">
            <b-form-select v-model="obj_index" @change="setObject" :options="objectsTitle"/>
          </div>
        </div>

        <b-button variant="outline-secondary" v-if="!disablePage" @click="modal_show = !modal_show">Добавить объект
        </b-button>

        <b-modal centered hide-header v-model="modal_show">

          <b-form-group
              id="fieldset-obj_name"
              label="Наименование добавляемого жилого объекта"
              label-for="obj_name"

          >
            <b-form-input v-model="objName" id="obj_name"/>
          </b-form-group>

          <template v-slot:modal-footer>
            <b-alert show variant="primary">
              Если у организации появился новый жилой объект, то лучше сначала его добавить в подсистему "Управление
              имуществом", тогда в выпадающем списке объектов он появится автоматически.
            </b-alert>
            <b-button @click="modal_show = !modal_show" variant="outline-danger">Отмена</b-button>
            <b-button @click="addObject" variant="outline-success">Сохранить</b-button>
          </template>
        </b-modal>

        <hr>
        <div v-if="currentObject">
          <b-form-group id="fieldset-obj_name2"
                        label="Наименование жилого объекта"
                        label-for="obj_name2"
                        label-class="font-weight-bold"
          >

            <b-input-group>
              <template v-slot:prepend>
                <b-input-group-text>
                  <i id="name_tooltip" class="fas fa-question-circle"></i>
                </b-input-group-text>
                <b-tooltip custom-class="tooltip_width" target="name_tooltip">
                  Полное наименование жилого объекта (общежития)
                </b-tooltip>
              </template>
              <b-form-input :disabled="ifRealEstate" v-model="currentObject.name" id="obj_name2"/>
            </b-input-group>
          </b-form-group>

          <b-form-group id="fieldset-obj_address"
                        label="Адрес жилого объекта"
                        label-for="obj_address"
                        label-class="font-weight-bold"
          >

            <b-input-group>
              <template v-slot:prepend>
                <b-input-group-text>
                  <i id="address_tooltip" class="fas fa-question-circle"></i>
                </b-input-group-text>
                <b-tooltip custom-class="tooltip_width" target="address_tooltip">
                  Страна, индекс, ФО, Субъект, Район, Населённый пункт, Улица, Дом.
                </b-tooltip>
              </template>
              <b-form-input :disabled="ifRealEstate" v-model="currentObject.address" id="obj_address"/>
            </b-input-group>
          </b-form-group>

          <div class="row">
            <div class="col-6">
              <label class="font-weight-bold" for="obj_region">Регион расположения жилого объекта</label>
            </div>
            <div class="col-6">
              <v-select :reduce="region=>region.value" label="text" :disabled="ifRealEstate"
                        v-model="currentObject.id_region" :options="regions" id="obj_region"/>
              <!--<b-form-select :disabled="disablePage" v-model="currentObject.id_region" :options="regions" id="obj_region"/>-->
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="font-weight-bold" for="obj_kad_number">Кадастровый номер</label>
            </div>
            <div class="col-6">
              <b-form-input :disabled="ifRealEstate" v-model="currentObject.kad_number" :options="regions"
                            id="obj_kad_number"/>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-6"><label for="obj_osnov_isp">Основание для использования здания</label></div>
            <div class="col-6">
              <b-form-select :disabled="ifRealEstate" v-model="currentObject.osn_isp" :options="[{
                    value:1,
                    text:'Право оперативного управления'
                },
                {
                    value:3,
                    text:'Договор аренды'
                },
                {
                    value:4,
                    text:'Договор о безвоздмездом пользовании'
                },
                {
                    value:5,
                    text:'Собственность'
                },
                {
                    value:9,
                    text:'Иное'
                }]" id="obj_osnov_isp"/>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6"><label class="ml-2" for="obj_doc_number">1. Номер регистрации права</label></div>
            <div class="col-6">
              <b-form-input :disabled="ifRealEstate" v-model="currentObject.doc_number" :options="regions"
                            id="obj_doc_number"/>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-2" for="obj_reg_zap">2. Дата регистрации права</label></div>
            <div class="col-6">
              <b-form-input :disabled="ifRealEstate" type="date" v-model="currentObject.reg_zap" :options="regions"
                            id="obj_reg_zap"/>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-6"><label for="obj_plan_zhil_pom">Планировка жилых помещений</label></div>
            <div class="col-6">
              <b-form-select :disabled="disablePage" v-model="currentObject.flat_plan" :options="[{
                    value:'kor',
                    text:'Коридорная'
                },
                {
                    value:'bloch',
                    text:'Блочная'
                },
                {
                    value:'kvar',
                    text:'Квартирная'
                },
                {
                    value:'gost',
                    text:'Гостиничная'
                }]" id="obj_plan_zhil_pom"/>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6"><label for="obj_razm_type">Тип размещения</label></div>
            <div class="col-6">
              <b-form-select :disabled="disablePage" v-model="currentObject.flat_type" :options="[{
                    value:'odn',
                    text:'Одноместный'
                },
                {
                    value:'dvuh',
                    text:'Двухместный'
                },
                {
                    value:'treh',
                    text:'Трёхместный и более'
                },
                {
                    value:'smesh',
                    text:'Смешанный'
                }]" id="obj_razm_type"/>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label for="obj_nal_uch_isp_res">Наличие приборов учета использования ресурсов</label>
            </div>
            <div class="col-6">
              <b-form-select :disabled="disablePage" v-model="currentObject.prib_type" :options="[{
                    value:'ind',
                    text:'Индивидуальные (на комнату)'
                },
                {
                    value:'obsh',
                    text:'Общедомовые'
                },
                {
                    value:'ots',
                    text:'Отсутствуют'
                }]" id="obj_nal_uch_isp_res"/>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6"><label for="obj_smet_sum">Сметная стоимость</label></div>
            <div class="col-6">
              <b-input-group append="Тысяч рублей">
                <b-form-input :disabled="disablePage" type="number" v-model.number="currentObject.smet"
                              id="obj_smet_sum"/>
              </b-input-group>
            </div>
          </div>
          <hr>

          <div class="row ">
            <div class="col-6"><label for="obj_date_start_stroy">Месяц и год начала строительства</label></div>
            <div class="col-6">
              <b-form-input :disabled="disablePage" type="date" v-model="currentObject.stroy_date_start"
                            id="obj_date_start_stroy"/>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label for="obj_date_zdan">Месяц и год постройки здания</label></div>
            <div class="col-6">
              <b-form-input :disabled="disablePage" type="date" v-model="currentObject.stroy_date_end"
                            id="obj_date_zdan"/>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label for="obj_date_exploat">Месяц и год ввода в эксплуатацию</label></div>
            <div class="col-6">
              <b-form-input :disabled="disablePage" type="date" v-model="currentObject.exp_date" id="obj_date_exploat"/>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col">
              <label class="font-weight-bold">Объемы финансирования строительства: </label>

              {{ cntVal.ob_fin_stroy.toFixed(3) }} Тысяч рублей

            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-2" for="obj_schet_fed_bud">1. За счёт средств федерального бюджета (если
              объект включен в ФАИП)</label></div>
            <div class="col-6">
              <b-input-group append="Тысяч рублей">
                <b-form-input :disabled="disablePage" step="0.001" type="number"
                              v-model.number="currentObject.money_faip"
                              id="obj_schet_fed_bud"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-2" for="obj_schet_bud_subj">2. За счёт средств бюджета субъекта
              РФ</label></div>
            <div class="col-6">
              <b-input-group append="Тысяч рублей">
                <b-form-input :disabled="disablePage" step="0.001" type="number"
                              v-model.number="currentObject.money_bud_sub"
                              id="obj_schet_bud_subj"/>
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col-6"><label class="ml-2" for="obj_schet_vnebud">3. За счёт внебюджетных средств</label></div>
            <div class="col-6">
              <b-input-group append="Тысяч рублей">
                <b-form-input :disabled="disablePage" step="0.001" type="number"
                              v-model.number="currentObject.money_vneb"
                              id="obj_schet_vnebud"/>
              </b-input-group>
            </div>
          </div>
          <hr>

          <div class="row">
            <div class="col-6"><label for="obj_rek_kap_rem">Реконструкция или капитальный ремонт проводился, проводится
              или запланирован</label></div>
            <div class="col-6">
              <b-form-select :disabled="disablePage" v-model="currentObject.reconstruct"
                             :options="[{value:1,text:'Да'},{value:0,text:'Нет'}]" id="obj_rek_kap_rem"/>
            </div>
          </div>
          <div class="ml-2" v-if="currentObject.reconstruct === 1 || currentObject.reconstruct === '1'">
            <div class="row">
              <div class="col"><label>Месяц и год начала реконструкции или капитального ремонта</label></div>
              <div class="col">
                <b-form-input
                    type="date"
                    :disabled="disablePage"
                    v-model="currentObject.date_start_reconstruct"/>
              </div>
            </div>
            <div class="row">
              <div class="col"><label>Сроки ввода (месяц и год) в эксплуатацию после реконструкции или капитального
                ремонта</label></div>
              <div class="col">
                <b-form-input
                    type="date"
                    :disabled="disablePage"
                    v-model="currentObject.date_end_reconstruct"/>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col">
                <label class="font-weight-bold">Объемы финансирования реконструкции или капитального ремонта: </label>

                {{ cntVal.rec_ob_fin_stroy.toFixed(3) }} Тысяч рублей

              </div>
            </div>
            <div class="row mt-2">
              <div class="col-6"><label class="ml-2" for="obj_schet_fed_bud">
                1. За счёт средств федерального бюджета (если объект включен в ФАИП)
              </label>
              </div>
              <div class="col-6">
                <b-input-group append="Тысяч рублей">
                  <b-form-input :disabled="disablePage" step="0.001" type="number"
                                v-model.number="currentObject.rec_money_faip"
                  />
                </b-input-group>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-6">
                <label class="ml-2" for="obj_schet_bud_subj">
                  2.За счёт средств бюджета субъекта РФ
                </label>
              </div>
              <div class="col-6">
                <b-input-group append="Тысяч рублей">
                  <b-form-input
                      :disabled="disablePage"
                      type="number"
                      step="0.001"
                      v-model.number="currentObject.rec_money_bud_sub"/>
                </b-input-group>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-6">
                <label class="ml-2" for="obj_schet_vnebud">
                  3. За счёт внебюджетных средств
                </label>
              </div>
              <div class="col-6">
                <b-input-group append="Тысяч рублей">
                  <b-form-input
                      :disabled="disablePage"
                      type="number"
                      step="0.001"
                      v-model.number="currentObject.rec_money_vneb"
                  />
                </b-input-group>
              </div>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-6"><label for="obj_ustav_goal">Используется ли объект в уставных целях</label></div>
            <div class="col-6">
              <b-form-select :disabled="disablePage" v-model="currentObject.ustav_dey"
                             :options="[{value:1,text:'Используется'},{value:0,text:'Не используется'}]"
                             id="obj_ustav_goal"/>
            </div>
          </div>

          <div class="ml-2" v-if="currentObject.ustav_dey === 0 || currentObject.ustav_dey === '0'">
            <div class="row mt-2">
              <div class="col-6"><label class="ml-2" for="obj_schet_fed_bud">
                1. Причина не использования в уставной деятельности
              </label>
              </div>
              <div class="col-6">

                <b-form-textarea :disabled="disablePage"
                                 v-model="currentObject.reason"
                />

              </div>
            </div>
            <div class="row mt-2">
              <div class="col-6">
                <label class="ml-2" for="obj_schet_bud_subj">
                  2. Использование объекта возможно при условии
                </label>
              </div>
              <div class="col-6">

                <b-form-textarea
                    :disabled="disablePage"
                    v-model="currentObject.uslovie"/>

              </div>
            </div>
            <div class="row mt-2">
              <div class="col-6">
                <label class="ml-2" for="obj_schet_vnebud">
                  3. Использование объекта невозможно по причине
                </label>
              </div>
              <div class="col-6">

                <b-form-textarea
                    :disabled="disablePage"
                    v-model="currentObject.nevos_reason"
                />

              </div>
            </div>
          </div>
          <hr>
          <span
              class="font-weight-bold">Доступность зданий для использования лицами с ограниченными возможностями</span>

          <div class="row mt-2">
            <div class="col">
              <label>
                Наличие пандуса
              </label>
            </div>
            <div class="col">
              <b-input-group append="единиц">
                <b-form-input
                    :disabled="disablePage"
                    v-model.number="currentObject.pandus"
                />
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col">
              <label>
                Наличие специализированных подъемных механизмов и поручней
              </label>
            </div>
            <div class="col">
              <b-input-group append="единиц">
                <b-form-input
                    :disabled="disablePage"
                    v-model.number="currentObject.mech_por"
                />
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col">
              <label>
                Оборудование специализированными санузлами
              </label>
            </div>
            <div class="col">
              <b-input-group append="единиц">
                <b-form-input
                    :disabled="disablePage"
                    v-model.number="currentObject.sanusel"
                />
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col">
              <label>
                Наличие систем сигнализации и оповещения
              </label>
            </div>
            <div class="col">
              <b-input-group append="единиц">
                <b-form-input
                    :disabled="disablePage"
                    v-model.number="currentObject.signal"
                />
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col">
              <label>
                Наличие тактильных покрытий
              </label>
            </div>
            <div class="col">
              <b-input-group append="единиц">
                <b-form-input
                    :disabled="disablePage"
                    v-model.number="currentObject.pokr"
                />
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col">
              <label>
                Наличие тактильных вывесок со шрифтом Брайля
              </label>
            </div>
            <div class="col">
              <b-input-group append="единиц">
                <b-form-input
                    :disabled="disablePage"
                    v-model.number="currentObject.vives"
                />
              </b-input-group>
            </div>
          </div>

          <hr>

          <div class="row mt-2">
            <div class="col">
              <label>
                Минимальный период заключения договора аренды жилого помещения в общежитии
              </label>
            </div>
            <div class="col">
              <b-input-group append="месяцев">
                <b-form-input
                    :disabled="disablePage"
                    v-model.number="currentObject.min_per"
                />
              </b-input-group>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col">
              <label>
                Максимальный период заключения договора аренды жилого помещения в общежитии
              </label>
            </div>
            <div class="col">
              <b-input-group append="месяцев">
                <b-form-input
                    :disabled="disablePage"
                    v-model.number="currentObject.max_per"
                />
              </b-input-group>
            </div>
          </div>

        </div>
      </div>
    </transition>
    <scroll-button/>

  </div>
  <loading v-else/>

</template>

<script>
import {
  BAlert,
  BButton,
  BFormGroup,
  BFormInput,
  BFormSelect,
  BFormTextarea,
  BInputGroup,
  BInputGroupText,
  BModal,
  BTooltip,
} from 'bootstrap-vue';
import {Decimal} from 'decimal.js';
import Axios from 'axios';
import vSelect from 'vue-select';
import NavBar from '../../organisms/NavBar';
import scrollButton from '../../organisms/scrollButton';
import Loading from "../../organisms/loading";

export default {
  components: {
    Loading,
    NavBar,
    BFormInput,
    BFormSelect,
    BButton,
    BModal,
    BFormGroup,
    BTooltip,
    BInputGroup,
    BInputGroupText,
    vSelect,
    BAlert,
    scrollButton,
    BFormTextarea,
  },
  props: {
    modalShow: {
      default: false,
    },
  },
  computed: {
    ifRealEstate() {
      return !!(this.disablePage || this.currentObject.id_realEstate);
    },
  },
  data() {
    return {
      ready:false,
      csrf: document.getElementsByName('csrf-token')[0].content,
      objName: '',
      componentReady: false,
      obj_index: null,
      currentObject: null,
      cntVal: {
        ob_fin_stroy: 0,
        rec_ob_fin_stroy: 0,
      },
      regions: [],
      id_org: null,
      user: {},
      modal_show: false,
      disablePage: false,
      objectsTitle: [],
      objects: [],
    };
  },
  watch: {
    objects() {
      if (this.objects.length) {
        this.objectsTitle = this.objects.map((item, index) => ({
          value: index,
          text: `${item.name} [${item.kad_number}]`,
        }));
      }
    },
    currentObject: {
      handler() {
        if (this.componentReady) this.cntObject();
      },
      deep: true,
    },
  },
  async mounted() {
    await this.getRegions();
    await this.getUser();
    this.id_org = this.user.id_org;
    await this.getObject();
    this.modal_show = this.modalShow;
    this.componentReady = true;
    setTimeout(()=>{
      this.ready = true;
    },500)
  },
  methods: {
    cntObject() {
      this.cntVal.ob_fin_stroy = new Decimal(this.currentObject.money_faip || 0).plus(
          new Decimal(this.currentObject.money_bud_sub || 0).plus(new Decimal(this.currentObject.money_vneb || 0)),
      );
      this.cntVal.rec_ob_fin_stroy = new Decimal(this.currentObject.rec_money_faip || 0).plus(
          new Decimal(this.currentObject.rec_money_bud_sub || 0).plus(new Decimal(this.currentObject.rec_money_vneb || 0)),
      );
    },
    async getUser() {
      await Axios.get('/api/user/current').then((res) => {
        this.user = res.data;
      });
    },
    async getRegions() {
      await Axios.get('/api/regions').then((response) => {
        response.data.forEach((item) => {
          this.regions.push({
            value: item.id,
            text: item.region,
          });
        });
      });
    },
    setObject(index) {
      this.currentObject = this.objects.find((item, i) => i === index);
    },
    async getObject() {
      await Axios.get(`/api/objects/org/${this.id_org}`).then((res) => {
        this.objects = res.data;
        this.objects.forEach((item) => {
          Object.keys(item).forEach((key) => {
            if (typeof item[key] === 'string') {
              if (isNaN(+item[key])) {
                try {
                  item[key] = (new Decimal(item[key])).toNumber();
                } catch {
                  console.log('kek');
                }
              } else {
                item[key] = +item[key];
              }
            }
          });
        });
      });
    },
    addObject() {
      this.objects.push({
        address: null,
        doc_number: null,
        exp_date: null,
        flat_plan: null,
        flat_type: null,
        id: null,
        name: this.objName,
        id_region: null,
        kad_number: null,
        money_bud_sub: null,
        money_faip: null,
        money_vneb: null,
        rec_money_bud_sub: null,
        rec_money_faip: null,
        rec_money_vneb: null,
        ob_fin_stroy: null,
        osn_isp: null,
        prib_type: null,
        reconstruct: null,
        reg_zap: null,
        smet: null,
        stroy_date_end: null,
        stroy_date_start: null,
        ustav_dey: null,
        id_realEstate: null,
        date_start_reconstruct: null,
        date_end_reconstruct: null,
        reason: null,
        uslovie: null,
        nevos_reason: null,
        pandus: null,
        mech_por: null,
        sanusel: null,
        signal: null,
        pokr: null,
        vives: null,
        min_per: null,
        max_per: null,
      });
      this.objName = null;
      this.obj_index = this.objects.length - 1;
      this.modal_show = false;
      this.currentObject = this.objects[this.objects.length - 1];
    },
    async savePage() {
      if (Object.keys(this.currentObject).length) {
        const data = new FormData();
        data.append('object', JSON.stringify(this.currentObject));
        await Axios.post((!this.currentObject.id) ? `object/create/${this.id_org}` : `object/update/${this.currentObject.id}`,
            data, {
              headers: {
                'X-CSRF-Token': this.csrf,
              },
            }).then((res) => {
          if (res.data.success) {
            this.getObject();
          }
        }).finally(() => this.disablePage = true);
      }
    },
  },
};
</script>

<style scoped>

</style>
