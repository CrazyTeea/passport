<template>
    <div>
        <nav-bar v-on:block-save="disablePage = !disablePage" />
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <h3>
                        Сведения о жилом объекте
                    </h3>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-6"><label >Наименование жилого объекта</label></div>
                <div class="col-6">
                    <b-form-select @change="setObject" :options="objectsTitle"/>
                </div>
            </div>

            <b-button variant="outline-secondary" v-if="!disablePage" @click="modalShow = !modalShow">Добавить объект</b-button>

            <b-modal hide-header v-model="modalShow">

                <b-form-group
                        id="fieldset-obj_name"
                        label="Наименование добавляемого жилого объекта"
                        label-for="obj_name"
                >
                    <b-form-input v-model="objName" id="obj_name" />
                </b-form-group>

                <template v-slot:modal-footer>
                    <b-button @click="addObject" variant="outline-success">Сохранить</b-button>
                </template>
            </b-modal>

            <hr>
            <b-form-group id="fieldset-obj_name2"
                          label="Наименование жилого объекта"
                          label-for="obj_name2">
                <b-input-group>
                    <template v-slot:prepend>
                        <b-input-group-text >
                            <i id="name_tooltip" class="fas fa-question-circle"></i>
                        </b-input-group-text>
                        <b-tooltip custom-class="tooltip_width" target="name_tooltip">
                            Полное наименование жилого объекта  (общежития)
                        </b-tooltip>
                    </template>
                    <b-form-input :disabled="disablePage" v-model="currentObject.name" id="obj_name2"/>
                </b-input-group>
            </b-form-group>

            <b-form-group id="fieldset-obj_address"
                          label="Адрес жилого объекта"
                          label-for="obj_address">
                <b-input-group>
                    <template v-slot:prepend>
                        <b-input-group-text >
                            <i id="address_tooltip" class="fas fa-question-circle"></i>
                        </b-input-group-text>
                        <b-tooltip custom-class="tooltip_width" target="address_tooltip">
                            Страна, индекс, ФО, Субъект, Район, Населённый пункт, Улица, Дом.
                        </b-tooltip>
                    </template>
                    <b-form-input :disabled="disablePage" v-model="currentObject.address" id="obj_address"/>
                </b-input-group>
            </b-form-group>

            <div class="row">
                <div class="col-6"><label for="obj_region">Регион расположения жилого объекта</label></div>
                <div class="col-6"><b-form-select :disabled="disablePage" v-model="currentObject.id_region" :options="regions" id="obj_region"/></div>
            </div>

            <div class="row mt-2">
                <div class="col-6"><label for="obj_kad_number">Кадастровый номер</label></div>
                <div class="col-6"><b-form-input :disabled="disablePage" v-model="currentObject.kad_number" :options="regions" id="obj_kad_number"/></div>
            </div>

            <hr>

            <div class="row">
                <div class="col-6"><label for="obj_osnov_isp">Основание для использования здания</label></div>
                <div class="col-6"><b-form-select :disabled="disablePage" v-model="currentObject.osnov_isp" :options="[{
                    value:0,
                    text:'Право оперативного управления'
                },
                {
                    value:1,
                    text:'Договор аренды'
                },
                {
                    value:2,
                    text:'Договор о безвоздмездом пользовании'
                },
                {
                    value:3,
                    text:'Собственность'
                },
                {
                    value:4,
                    text:'Иное'
                }]" id="obj_osnov_isp"/></div>
            </div>

            <div class="row mt-2">
                <div class="col-6"><label class="ml-2" for="obj_reg_zap">1. Регистрационная запись</label></div>
                <div class="col-6"><b-form-input :disabled="disablePage" v-model="currentObject.reg_zap" :options="regions" id="obj_reg_zap"/></div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-2" for="obj_doc_number">2. Номер документа</label></div>
                <div class="col-6"><b-form-input :disabled="disablePage" v-model="currentObject.doc_number" :options="regions" id="obj_doc_number"/></div>
            </div>

            <hr>

            <div class="row">
                <div class="col-6"><label for="obj_plan_zhil_pom">Планировка жилых помещений</label></div>
                <div class="col-6"><b-form-select :disabled="disablePage" v-model="currentObject.plan_zhil_pom" :options="[{
                    value:0,
                    text:'Коридорная'
                },
                {
                    value:1,
                    text:'Блочная'
                },
                {
                    value:2,
                    text:'Квартирная'
                },
                {
                    value:3,
                    text:'Гостиничная'
                }]" id="obj_plan_zhil_pom"/></div>
            </div>

            <div class="row mt-2">
                <div class="col-6"><label for="obj_razm_type">Тип размещения</label></div>
                <div class="col-6"><b-form-select :disabled="disablePage" v-model="currentObject.razm_type" :options="[{
                    value:0,
                    text:'Одноместный'
                },
                {
                    value:1,
                    text:'Двухместный'
                },
                {
                    value:2,
                    text:'Трёхместный и более'
                },
                {
                    value:3,
                    text:'Смешанный'
                }]" id="obj_razm_type"/></div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label for="obj_nal_uch_isp_res">Наличие приборов учета использования ресурсов</label></div>
                <div class="col-6"><b-form-select :disabled="disablePage" v-model="currentObject.nal_uch_isp_res" :options="[{
                    value:0,
                    text:'Индивидуальные (на комнату)'
                },
                {
                    value:1,
                    text:'Общедомовые'
                },
                {
                    value:2,
                    text:'Отсутствуют'
                }]" id="obj_nal_uch_isp_res"/></div>
            </div>

            <div class="row mt-2">
                <div class="col-6"><label for="obj_smet_sum">Сметная стоимость</label></div>
                <div class="col-6">
                    <b-input-group append="Тысяч рублей">
                        <b-form-input :disabled="disablePage" type="number" v-model="currentObject.smet_sum" id="obj_smet_sum"/>
                    </b-input-group>
                </div>
            </div>
            <hr>

            <div class="row ">
                <div class="col-6"><label for="obj_date_start_stroy">Месяц и год начала строительства</label></div>
                <div class="col-6"><b-form-input :disabled="disablePage" type="date" v-model="currentObject.date_start_stroy" id="obj_date_start_stroy"/></div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label for="obj_date_zdan">Месяц и год постройки здания</label></div>
                <div class="col-6"><b-form-input :disabled="disablePage" type="date" v-model="currentObject.date_zdan" id="obj_date_zdan"/></div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label for="obj_date_exploat">Месяц и год ввода в эксплуатацию</label></div>
                <div class="col-6"><b-form-input :disabled="disablePage" type="date" v-model="currentObject.date_exploat" id="obj_date_exploat"/></div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label for="obj_sum_fins">Объемы финансирования строительства</label></div>
                <div class="col-6">
                    <b-input-group append="Тысяч рублей">
                    <b-form-input :disabled="disablePage" type="number" v-model="currentObject.sum_fins" disabled id="obj_sum_fins"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-2" for="obj_schet_fed_bud">1. За счёт средств федерального бюджета (если объект включен в ФАИП)</label></div>
                <div class="col-6">
                    <b-input-group append="Тысяч рублей">
                    <b-form-input :disabled="disablePage" type="number" v-model="currentObject.schet_fed_bud" id="obj_schet_fed_bud"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-2" for="obj_schet_bud_subj">2. За счёт средств бюджета субъекта РФ</label></div>
                <div class="col-6">
                    <b-input-group append="Тысяч рублей">
                    <b-form-input :disabled="disablePage" type="number" v-model="currentObject.schet_bud_subj" id="obj_schet_bud_subj"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-2" for="obj_schet_vnebud">3. За счёт внебюджетных средств</label></div>
                <div class="col-6">
                    <b-input-group append="Тысяч рублей">
                    <b-form-input :disabled="disablePage" type="number" v-model="currentObject.schet_vnebud" id="obj_schet_vnebud"/>
                    </b-input-group>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-6"><label  for="obj_rek_kap_rem">Реконструкция или капитальный ремонт проводился, проводится или запланирован</label></div>
                <div class="col-6">
                    <b-form-select :disabled="disablePage" v-model="currentObject.rek_kap_rem" :options="[{value:1,text:'Да'},{value:0,text:'Нет'}]" id="obj_rek_kap_rem"/>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-6"><label for="obj_ustav_goal">Используется ли объект в уставных целях</label></div>
                <div class="col-6">
                    <b-form-select :disabled="disablePage" v-model="currentObject.ustav_goal" :options="[{value:1,text:'Используется'},{value:0,text:'Не используется'}]" id="obj_ustav_goal"/>
                </div>
            </div>

            <hr>







        </div>
    </div>
</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import {
        BButton,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BInputGroup,
        BInputGroupText,
        BModal,
        BTooltip
    } from 'bootstrap-vue'
    import Axios from 'axios'

    export default {
        components:{
            NavBar,
            BFormInput,
            BFormSelect,
            BButton,BModal,
            BFormGroup,BTooltip,
            BInputGroup,BInputGroupText,
        },
        data(){
            return {
                objName:'',
                modalShow:false,
                currentObject:{},
                regions:[],
                disablePage:true,
                objectsTitle:[
                    {
                        value:1,
                        text:'object 0'
                    }
                ],
                objects:[
                    {
                        id:1,
                        name:'object 0',
                        address:'',
                        id_region:1,
                        kad_number:'',
                        osnov_isp:0,
                        reg_zap:'',
                        doc_number:'',
                        plan_zhil_pom:0,
                        razm_type:0,
                        smet_sum:0,
                        nal_uch_isp_res:0,
                        date_start_stroy:null,
                        date_zdan:null,
                        date_exploat:null,
                        sum_fins:0,
                        schet_fed_bud:0,
                        schet_bud_subj:0,
                        schet_vnebud:0,
                        rek_kap_rem:true,
                    }
                ]
            }
        },
        watch:{
          objects(){
              this.objects.forEach(item=>{
                  this.objectsTitle.push({
                      value:item.id,
                      text:item.name
                  })
              })
          }
        },
        async mounted(){
          await this.getRegions();
        },
        methods:{
            async getRegions(){
              await Axios.get('/api/regions').then(response=>{
                  response.data.forEach(item=>{
                      this.regions.push({
                          value:item.id,
                          text:item.region
                      })
                  })
              })
            },
            setObject(index){
                this.currentObject = this.objects.find(item=>item.id===index);
                console.log(index,this.currentObject);
            },
            addObject(){
                this.objects.push({
                    id:12,
                    name:this.objName,
                    address:null,
                    id_region:1,
                    kad_number:null,
                    osnov_isp:0,
                    reg_zap:null,
                    smet_sum:0,
                    doc_number:null,
                    plan_zhil_pom:0,
                    razm_type:0,
                    nal_uch_isp_res:0,
                    date_start_stroy:null,
                    date_zdan:null,
                    date_exploat:null
                });
                this.objName = null;
                this.modalShow = false;
            }
        }
    }
</script>

<style scoped>

</style>