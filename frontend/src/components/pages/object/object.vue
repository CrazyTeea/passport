<template>
  <div v-if="ready" class="page-obj">
    <!--<nav-bar v-on:block-save="disablePage = !disablePage" v-on:save-page="savePage" :id_org="id_org"
             :is-admin="user.isAdmin"/>-->
    <v-page>
      <div v-if="componentReady" class="container">
        <org-select v-if="$check(['admin','root'])" v-model="id_org"
                    error-msg="нет доступных организаций по заданным критериаям"
                    label="Выбранная организация" link="/api/organizations/all"/>

        <h3>Шаг 1: Сведения о жилом объекте</h3>

        <div v-if="currentObject">

          <stepper
              :back-url="user.isAdmin ? `/admin/data/${id_org}` : '/main'"
              :to-url="user.isAdmin ? `/admin/objects-area/${id_org}/${$route.params.id_object}` :  `/objects-area/${$route.params.id_object}`"
              percent="20"
              end-button-label="Далее"
              @save-page="savePage"
          />
          <hr>

          <b-alert variant="danger" show>
            <money-icon/>
            <span style="font-size: 1.2rem">Денежные поля должны быть заполнены в рублях.</span>
          </b-alert>

          <b-form-group id="fieldset-obj_name2" label="Наименование жилого объекта" label-class="font-weight-bold"
                        label-for="obj_name2">
            <b-input-group>
              <template v-slot:prepend>
                <b-input-group-text><i class="fas fa-question-circle" id="name_tooltip"/></b-input-group-text>
                <b-tooltip custom-class="tooltip_width" target="name_tooltip">
                  Полное наименование жилого объекта (общежития)
                </b-tooltip>
              </template>
              <b-form-input v-model="currentObject.name" id="obj_name2"/>
            </b-input-group>
          </b-form-group>

          <b-form-group id="fieldset-obj_address" label="Адрес жилого объекта" label-class="font-weight-bold"
                        label-for="obj_address">
            <b-input-group>
              <template v-slot:prepend>
                <b-input-group-text><i class="fas fa-question-circle" id="address_tooltip"/></b-input-group-text>
                <b-tooltip custom-class="tooltip_width" target="address_tooltip">
                  Страна, индекс, ФО, Субъект, Район, Населённый пункт, Улица, Дом.
                </b-tooltip>
              </template>
              <b-form-input v-model="currentObject.address" id="obj_address"/>
            </b-input-group>
          </b-form-group>

          <div class="row">
            <div class="col-6">
              <label class="font-weight-bold" for="obj_region">Регион расположения жилого объекта</label>
            </div>
            <div class="col-6">
              <v-select v-model="currentObject.id_region" id="obj_region" label="text"
                        :options="regions" :reduce="item=>item.value"/>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6"><label class="font-weight-bold" for="obj_kad_number">Кадастровый номер</label></div>
            <div class="col-6">
              <b-form-input v-model="currentObject.kad_number" id="obj_kad_number"/>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-6"><label for="obj_osnov_isp">Основание для использования здания</label></div>
            <div class="col-6">
              <b-form-select v-model="currentObject.osn_isp" id="obj_osnov_isp" :options="[
                  {value:1, text:'Право оперативного управления'},
                  {value:3, text:'Договор аренды'},
                  {value:4, text:'Договор о безвоздмездом пользовании'},
                  {value:5, text:'Собственность'},
                  {value:9, text:'Иное'}
                ]"/>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6"><label class="ml-2" for="obj_doc_number">1. Номер регистрации права</label></div>
            <div class="col-6">
              <b-form-input v-model="currentObject.doc_number" id="obj_doc_number"/>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6"><label class="ml-2" for="obj_reg_zap">2. Дата регистрации права</label></div>
            <div class="col-6">
              <b-form-input v-model="currentObject.reg_zap" id="obj_reg_zap" type="date"/>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-6"><label for="obj_plan_zhil_pom">Планировка жилых помещений</label></div>
            <div class="col-6">
              <b-form-select v-model="currentObject.flat_plan" id="obj_plan_zhil_pom" :disabled="disablePage" :options="[
                  {value:'kor', text:'Коридорная'},
                  {value:'bloch', text:'Блочная'},
                  {value:'kvar', text:'Квартирная'},
                  {value:'gost', text:'Гостиничная'}
                ]"/>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6"><label for="obj_razm_type">Тип размещения</label></div>
            <div class="col-6">
              <b-form-select v-model="currentObject.flat_type" id="obj_razm_type" :disabled="disablePage" :options="[
                  {value:'odn', text:'Одноместный'},
                  {value:'dvuh', text:'Двухместный'},
                  {value:'treh', text:'Трёхместный и более'},
                  {value:'smesh', text:'Смешанный'}
                ]"/>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label for="obj_nal_uch_isp_res">Наличие приборов учета использования ресурсов</label>
            </div>
            <div class="col-6">
              <b-form-select v-model="currentObject.prib_type" id="obj_nal_uch_isp_res" :disabled="disablePage"
                             :options="[
                  {value:'ind', text:'Индивидуальные (на комнату)'},
                  {value:'obsh', text:'Общедомовые'},
                  {value:'ots', text:'Отсутствуют'}
                ]"/>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6"><label for="obj_smet_sum">Сметная стоимость строительства (реконструкции) в ценах года её
              определения</label></div>
            <div class="col-6">
              <b-input-group append="рублей">
                <b-form-input v-model.number="currentObject.smet" id="obj_smet_sum" type="number"
                              :disabled="disablePage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label for="year_cen">
                Год, в ценах которого определена стоимость строительства (реконструкции)
              </label>
            </div>
            <div class="col-6">

              <b-form-input v-model.number="currentObject.year_cen" id="year_cen" min="1000" max="3000"
                            type="number"/>

            </div>
          </div>

          <hr>

          <div class="row ">
            <div class="col-6">
              <label for="obj_date_start_stroy">Год начала строительства</label>
              <i class="fas fa-question-circle" id="tooltip-target-11"/>
              <b-tooltip target="tooltip-target-11" triggers="hover">
                Значение вносится четырьмя цифрами
              </b-tooltip>
            </div>
            <div class="col-6">
              <b-form-input v-model="currentObject.stroy_date_start" id="obj_date_start_stroy" max="9999" min="1000"
                            type="number" :disabled="disablePage"/>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label for="obj_date_zdan">Год постройки здания</label>
              <i class="fas fa-question-circle" id="tooltip-target-12"/>
              <b-tooltip target="tooltip-target-12" triggers="hover">
                Значение вносится четырьмя цифрами
              </b-tooltip>
            </div>
            <div class="col-6">
              <b-form-input v-model="currentObject.stroy_date_end" id="obj_date_zdan" max="9999" min="1000"
                            type="number" :disabled="disablePage"/>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label for="obj_date_exploat">Год ввода в эксплуатацию</label>
              <i class="fas fa-question-circle" id="tooltip-target-13"/>
              <b-tooltip target="tooltip-target-13" triggers="hover">
                Значение вносится четырьмя цифрами
              </b-tooltip>
            </div>
            <div class="col-6">
              <b-form-input v-model="currentObject.exp_date" id="obj_date_exploat" max="9999" min="1000" type="number"
                            :disabled="disablePage"/>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col">
              <label class="font-weight-bold">Объемы финансирования строительства:</label>
              {{ cntVal.ob_fin_stroy.toFixed(2) }} рублей
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-2" for="obj_schet_fed_bud">
                1. За счёт средств федерального бюджета
              </label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <b-form-input v-model.number="currentObject.money_faip" id="obj_schet_fed_bud" step="0.001"
                              type="number" :disabled="disablePage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6">
              <label class="ml-2" for="obj_schet_bud_subj">2. За счёт средств бюджета субъекта РФ</label>
            </div>
            <div class="col-6">
              <b-input-group append="рублей">
                <b-form-input v-model.number="currentObject.money_bud_sub" id="obj_schet_bud_subj" step="0.001"
                              type="number" :disabled="disablePage"/>
              </b-input-group>
            </div>
          </div>

          <div class="row mt-2">
            <div class="col-6"><label class="ml-2" for="obj_schet_vnebud">3. За счёт внебюджетных средств</label></div>
            <div class="col-6">
              <b-input-group append="рублей">
                <b-form-input v-model.number="currentObject.money_vneb" id="obj_schet_vnebud" step="0.001" type="number"
                              :disabled="disablePage"/>
              </b-input-group>
            </div>
          </div>

          <hr>

          <div class="row">
            <div class="col-6">
              <label for="obj_rek_kap_rem">
                Реконструкция или капитальный ремонт проводился, проводится или запланирован
                <i class="fas fa-question-circle" id="tooltip-target-111"/>
                <b-tooltip target="tooltip-target-111" triggers="hover">
                  Если работы проводились несколько раз, то необходимо вносить данные о последних планируемых или
                  проведённых работах
                </b-tooltip>
              </label>


            </div>
            <div class="col-6">
              <b-form-select v-model="currentObject.reconstruct" id="obj_rek_kap_rem" :disabled="disablePage"
                             :options="[{value:1,text:'Да'},{value:0,text:'Нет'}]"/>
            </div>
          </div>

          <div v-if="Number(currentObject.reconstruct) === 1" class="ml-2">
            <div class="row">
              <div class="col">
                <label>
                  Месяц и год начала реконструкции или капитального ремонта
                  <i class="fas fa-question-circle" id="tooltip-target-1"/>
                  <b-tooltip target="tooltip-target-1" triggers="hover">
                    Для сохранения нужно ввести и месяц, и год
                  </b-tooltip>
                </label>
              </div>
              <div class="col d-flex justify-content-between">
                <b-form-select v-model="currentObject.date_start_reconstruct[1]" :disabled="disablePage"
                               :options="[
                                  { value: null, text: '' },
                                  { value: '01', text: 'Январь' },
                                  { value: '02', text: 'Февраль' },
                                  { value: '03', text: 'Март' },
                                  { value: '04', text: 'Апрель' },
                                  { value: '05', text: 'Май' },
                                  { value: '06', text: 'Июнь' },
                                  { value: '07', text: 'Июль' },
                                  { value: '08', text: 'Август' },
                                  { value: '09', text: 'Сентябрь' },
                                  { value: '10', text: 'Октябрь' },
                                  { value: '11', text: 'Ноябрь' },
                                  { value: '12', text: 'Декабрь' }
                                ]"/>
                <span style="color: white">.</span>
                <b-form-input v-model.number="currentObject.date_start_reconstruct[0]" max="9999" min="1000"
                              type="number"
                              :disabled="disablePage"/>
              </div>
            </div>

            <div class="row">
              <div class="col">
                <label>
                  Сроки ввода (месяц и год) в эксплуатацию после реконструкции или капитального ремонта
                  <i class="fas fa-question-circle" id="tooltip-target-2"/>
                  <b-tooltip target="tooltip-target-2" triggers="hover">
                    Для сохранения нужно ввести и месяц, и год
                  </b-tooltip>
                </label>
              </div>
              <div class="col d-flex justify-content-between">
                <b-form-select v-model="currentObject.date_end_reconstruct[1]" :disabled="disablePage"
                               :options="[
                                  { value: null, text: '' },
                                  { value: '01', text: 'Январь' },
                                  { value: '02', text: 'Февраль' },
                                  { value: '03', text: 'Март' },
                                  { value: '04', text: 'Апрель' },
                                  { value: '05', text: 'Май' },
                                  { value: '06', text: 'Июнь' },
                                  { value: '07', text: 'Июль' },
                                  { value: '08', text: 'Август' },
                                  { value: '09', text: 'Сентябрь' },
                                  { value: '10', text: 'Октябрь' },
                                  { value: '11', text: 'Ноябрь' },
                                  { value: '12', text: 'Декабрь' }
                                ]"/>
                <span style="color: white">.</span>
                <b-form-input v-model.number="currentObject.date_end_reconstruct[0]" max="9999" min="1000" type="number"
                              :disabled="disablePage"/>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col">
                <label class="font-weight-bold">Объемы финансирования реконструкции или капитального ремонта:</label>
                {{ cntVal.rec_ob_fin_stroy.toFixed(2) }} рублей
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-6">
                <label class="ml-2" for="obj_schet_fed_bud">
                  1. За счёт средств федерального бюджета
                </label>
              </div>
              <div class="col-6">
                <b-input-group append="рублей">
                  <b-form-input v-model.number="currentObject.rec_money_faip" step="0.001" type="number"
                                :disabled="disablePage"/>
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
                <b-input-group append="рублей">
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
                <b-input-group append="рублей">
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
              <div class="col-6">
                <label class="ml-2" for="obj_schet_fed_bud">
                  1. Причина не использования в уставной деятельности
                </label>
              </div>
              <div class="col-6">
                <b-form-textarea :disabled="disablePage" v-model="currentObject.reason"/>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-6">
                <label class="ml-2" for="obj_schet_bud_subj">
                  2. Использование объекта возможно при условии
                </label>
              </div>
              <div class="col-6">
                <b-form-textarea :disabled="disablePage" v-model="currentObject.uslovie"/>
              </div>
            </div>
            <div class="row mt-2">
              <div class="col-6">
                <label class="ml-2" for="obj_schet_vnebud">
                  3. Использование объекта невозможно по причине
                </label>
              </div>
              <div class="col-6">
                <b-form-textarea :disabled="disablePage" v-model="currentObject.nevos_reason"/>
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
                Наличие в общежитии бесплатного доступа к информационно-коммуникационной сети “Интернет”
              </label>
            </div>
            <div class="col">

              <b-form-select
                  :disabled="disablePage"
                  :options="[{value:0,text:'Нет'},{value:1,text:'Да'}]"
                  v-model.number="currentObject.wifi"
              />

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

          <stepper
              :back-url="user.isAdmin ? `/admin/data/${id_org}` : '/main'"
              :to-url="user.isAdmin ? `/admin/objects-area/${id_org}/${$route.params.id_object}` :  `/objects-area/${$route.params.id_object}`"
              percent="20"
              end-button-label="Далее"
              @save-page="savePage"
          />


          <hr>
          <div class="text-center">
            <button class="btn btn-primary" type="button" @click="setZeros()">Заполнить нулями пустые поля</button>
          </div>
          <hr>
          <br>
        </div>
      </div>
      <loading v-else/>
    </v-page>


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
import Axios from 'axios';
import vSelect from 'vue-select';

import scrollButton from '../../organisms/scrollButton';
import Loading from "../../organisms/loading";
import OrgSelect from "../../organisms/orgSelect";
import {mainMixin} from "../../mixins";
import MoneyIcon from "../../organisms/moneyIcon";
import Stepper from "../../organisms/stepper";
import VPage from "../../organisms/vPage";


export default {
  async mounted() {
    await this.getRegions();
    await this.getUser();

    if (this.user.isAdmin) this.id_org = this.$route.fullPath.split('/')[3] || this.user.id_org
    else this.id_org = this.user.id_org;

    await this.getCntRealEstate()
    await this.getObject();

    this.modal_show = this.modalShow;
    this.componentReady = true;
    setTimeout(() => {
      this.ready = true;
    }, 500)
  },
  components: {
    VPage,
    Stepper,
    MoneyIcon,
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
    Loading,
    OrgSelect,
    scrollButton,
    vSelect
  },
  computed: {
    ifRealEstate() {
      return !!(this.disablePage || this.currentObject.id_realEstate);
    }
  },
  data() {
    return {
      cntRs: 0,
      cntVal: {
        ob_fin_stroy: 0,
        rec_ob_fin_stroy: 0,
      },
      inputs: [
        'name', 'address', 'id_region',
        'kad_number', 'osn_isp',
        'reg_zap', 'doc_number', 'flat_plan',
        'flat_type', 'prib_type', 'smet',
        'stroy_date_start', 'stroy_date_end', 'exp_date',
        'money_faip', 'money_bud_sub', 'money_vneb',
        'reconstruct', 'ustav_dey', 'pandus', 'mech_por',
        'pokr', 'reconstruct', 'sanusel', 'signal',
        'vives', 'wifi', 'min_per', 'max_per', 'year_cen'
      ],
      componentReady: false,
      csrf: document.getElementsByName('csrf-token')[0].content,
      currentObject: null,
      disablePage: false,
      id_org: 1,
      modal_show: false,
      objects: [],
      objectsTitle: [],
      objName: '',
      obj_index: null,
      ready: false,
      regions: [],
      user: {}
    };
  },
  methods: {
    async getCntRealEstate() {
      await Axios.get('/api/objects/cnt-real-estate', {
        params: {
          id_org: this.id_org
        }
      }).then(res => this.cntRs = res.data ** 1)
    },
    async getObject() {
      await Axios.get(`/api/objects/org/${this.id_org}/${this.$route.params.id_object}`).then((res) => {
        this.currentObject = res.data;
        if (this.currentObject.date_end_reconstruct) {
          let date = this.currentObject.date_end_reconstruct.split(' ')[0].split('-')
          this.currentObject.date_end_reconstruct = [date[0], date[1]];
        } else {
          this.currentObject.date_end_reconstruct = [null, null];
        }
        if (this.currentObject.date_start_reconstruct) {
          let date = this.currentObject.date_start_reconstruct.split(' ')[0].split('-')
          this.currentObject.date_start_reconstruct = [date[0], date[1]];
        } else {
          this.currentObject.date_start_reconstruct = [null, null];
        }
        this.currentObject.exp_date = this.currentObject.exp_date ?
            this.currentObject.exp_date.split(' ')[0].split('-')[0] : null;
        this.currentObject.id_region = (this.currentObject.id_region ** 1);
        this.currentObject.stroy_date_end = this.currentObject.stroy_date_end ? this.currentObject.stroy_date_end.split(' ')[0].split('-')[0] : null;
        this.currentObject.stroy_date_start = this.currentObject.stroy_date_start ? this.currentObject.stroy_date_start.split(' ')[0].split('-')[0] : null;

        this.cntObject();
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
    async getUser() {
      await Axios.get('/api/user/current').then((res) => {
        this.user = res.data;
        this.user.isAdmin = !!res.data.roles.root || !!res.data.roles.admin
      });
    },
    validate() {
      for (let i = 0; i < this.inputs.length; i++) {
        let item = this.inputs[i];
        if (this.isEmpty(this.currentObject[item]))
          return false;
      }
      return true;
    },
    async savePage(validate, resolve) {
      if (validate && !this.validate()) {
        await this.$bvModal.msgBoxOk("Для сохранения необходимо заполнить пустые поля.");
        resolve(false)
        return;
      }

      const data = new FormData();
      data.append('object', JSON.stringify(this.currentObject));
      await Axios.post((!this.currentObject.id) ? `/object/create/${this.id_org}` : `/object/update/${this.currentObject.id}`,
          data, {
            headers: {'X-CSRF-Token': this.csrf}
          });
      resolve(true)
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
        wifi: 0,
        tech: 0,
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
    cntObject() {
      let toNum = num => typeof num === 'string' ? num.toNumber() : (num || 0);
      this.cntVal.ob_fin_stroy = toNum(this.currentObject.money_faip) + toNum(this.currentObject.money_bud_sub) +
          toNum(this.currentObject.money_vneb);

      this.cntVal.rec_ob_fin_stroy = toNum(this.currentObject.rec_money_faip) +
          toNum(this.currentObject.rec_money_bud_sub) + toNum(this.currentObject.rec_money_vneb);
    },
    goto() {
      if (!this.cntRs)
        this.modal_show = !this.modal_show;
      else
        window.location.href = 'https://xn--b1adcgjb2abq4al4j.xn--80apneeq.xn--p1ai/real-estate/add'
    },
    setObject(index) {
      this.currentObject = this.objects.find((item, i) => i === index);
    },
    setZeros() {
      this.inputs.forEach(item => {
        if (!['name', 'address', 'id_region', 'flat_plan', 'doc_number', 'stroy_date_start',
          'flat_type', 'prib_type', 'reconstruct', 'ustav_dey', 'wifi', 'stroy_date_end', 'exp_date',
          'kad_number', 'osn_isp', 'reg_zap'].find(i => i === item)) {
          if (this.isEmpty(this.currentObject[item]))
            this.currentObject[item] = 0;
        }
      })
      this.$forceUpdate()
    },

  },
  mixins: [mainMixin],
  props: {
    modalShow: {
      default: false
    }
  },
  watch: {
    async id_org() {
      if (this.componentReady) await this.getObject();
    },
    currentObject: {
      deep: true,
      handler() {
        if (this.componentReady) this.cntObject();
      }
    },
    objects() {
      if (this.objects.length) {
        this.objectsTitle = this.objects.map((item, index) => ({
          value: index,
          text: `${item.name} [${item.kad_number}]`,
        }));
      }
    }
  }
};
</script>

<style scoped/>