<template>
    <transition enter-active-class="animated fadeInUp">
        <div v-if="componentReady">
            <nav-bar v-on:save-page="savePage" v-on:block-save="disablePage = !disablePage" />
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
                        <b-form-select v-model="obj_index" @change="setObject" :options="objectsTitle"/>
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
                <div v-if="currentObject">
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
                        <div class="col-6">
                            <v-select :reduce="region=>region.value" label="text" :disabled="disablePage" v-model="currentObject.id_region" :options="regions" id="obj_region"/>
                            <!--<b-form-select :disabled="disablePage" v-model="currentObject.id_region" :options="regions" id="obj_region"/>-->
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-6"><label for="obj_kad_number">Кадастровый номер</label></div>
                        <div class="col-6"><b-form-input :disabled="disablePage" v-model="currentObject.kad_number" :options="regions" id="obj_kad_number"/></div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-6"><label for="obj_osnov_isp">Основание для использования здания</label></div>
                        <div class="col-6"><b-form-select :disabled="disablePage" v-model="currentObject.osn_isp" :options="[{
                    value:'pou',
                    text:'Право оперативного управления'
                },
                {
                    value:'da',
                    text:'Договор аренды'
                },
                {
                    value:'dbp',
                    text:'Договор о безвоздмездом пользовании'
                },
                {
                    value:'sob',
                    text:'Собственность'
                },
                {
                    value:'inoe',
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
                        <div class="col-6"><b-form-select :disabled="disablePage" v-model="currentObject.flat_plan" :options="[{
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
                }]" id="obj_plan_zhil_pom"/></div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-6"><label for="obj_razm_type">Тип размещения</label></div>
                        <div class="col-6"><b-form-select :disabled="disablePage" v-model="currentObject.flat_type" :options="[{
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
                }]" id="obj_razm_type"/></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6"><label for="obj_nal_uch_isp_res">Наличие приборов учета использования ресурсов</label></div>
                        <div class="col-6"><b-form-select :disabled="disablePage" v-model="currentObject.prib_type" :options="[{
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
                }]" id="obj_nal_uch_isp_res"/></div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-6"><label for="obj_smet_sum">Сметная стоимость</label></div>
                        <div class="col-6">
                            <b-input-group append="Тысяч рублей">
                                <b-form-input :disabled="disablePage" type="number" v-model="currentObject.smet" id="obj_smet_sum"/>
                            </b-input-group>
                        </div>
                    </div>
                    <hr>

                    <div class="row ">
                        <div class="col-6"><label for="obj_date_start_stroy">Месяц и год начала строительства</label></div>
                        <div class="col-6"><b-form-input :disabled="disablePage" type="date" v-model="currentObject.stroy_date_start" id="obj_date_start_stroy"/></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6"><label for="obj_date_zdan">Месяц и год постройки здания</label></div>
                        <div class="col-6"><b-form-input :disabled="disablePage" type="date" v-model="currentObject.stroy_date_end" id="obj_date_zdan"/></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6"><label for="obj_date_exploat">Месяц и год ввода в эксплуатацию</label></div>
                        <div class="col-6"><b-form-input :disabled="disablePage" type="date" v-model="currentObject.exp_date" id="obj_date_exploat"/></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6"><label for="obj_sum_fins">Объемы финансирования строительства</label></div>
                        <div class="col-6">
                            <b-input-group append="Тысяч рублей">
                                <b-form-input :disabled="disablePage" type="number" v-model="currentObject.ob_fin_stroy" disabled id="obj_sum_fins"/>
                            </b-input-group>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6"><label class="ml-2" for="obj_schet_fed_bud">1. За счёт средств федерального бюджета (если объект включен в ФАИП)</label></div>
                        <div class="col-6">
                            <b-input-group append="Тысяч рублей">
                                <b-form-input :disabled="disablePage" type="number" v-model="currentObject.money_faip" id="obj_schet_fed_bud"/>
                            </b-input-group>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6"><label class="ml-2" for="obj_schet_bud_subj">2. За счёт средств бюджета субъекта РФ</label></div>
                        <div class="col-6">
                            <b-input-group append="Тысяч рублей">
                                <b-form-input :disabled="disablePage" type="number" v-model="currentObject.money_bud_sub" id="obj_schet_bud_subj"/>
                            </b-input-group>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6"><label class="ml-2" for="obj_schet_vnebud">3. За счёт внебюджетных средств</label></div>
                        <div class="col-6">
                            <b-input-group append="Тысяч рублей">
                                <b-form-input :disabled="disablePage" type="number" v-model="currentObject.money_vneb" id="obj_schet_vnebud"/>
                            </b-input-group>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-6"><label  for="obj_rek_kap_rem">Реконструкция или капитальный ремонт проводился, проводится или запланирован</label></div>
                        <div class="col-6">
                            <b-form-select :disabled="disablePage" v-model="currentObject.reconstruct" :options="[{value:1,text:'Да'},{value:0,text:'Нет'}]" id="obj_rek_kap_rem"/>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-6"><label for="obj_ustav_goal">Используется ли объект в уставных целях</label></div>
                        <div class="col-6">
                            <b-form-select :disabled="disablePage" v-model="currentObject.ustav_dey" :options="[{value:1,text:'Используется'},{value:0,text:'Не используется'}]" id="obj_ustav_goal"/>
                        </div>
                    </div>

                    <hr>


                </div>






            </div>
        </div>
    </transition>

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
    } from 'bootstrap-vue';
    import Axios from 'axios';
    import vSelect from 'vue-select'

    export default {
        components:{
            NavBar,
            BFormInput,
            BFormSelect,
            BButton,BModal,
            BFormGroup,BTooltip,
            BInputGroup,BInputGroupText,
            vSelect
        },
        data(){
            return {
                csrf: document.getElementsByName("csrf-token")[0].content,
                objName:'',
                componentReady:false,
                obj_index:null,
                modalShow:false,
                currentObject: null,
                regions:[],
                id_org:null,
                user:{},
                disablePage:true,
                objectsTitle:[],
                objects:[]
            }
        },
        watch:{
            objects(){
                this.objectsTitle = [];
                this.objects.forEach((item,index)=>{
                    console.log(index)
                    this.objectsTitle.push({

                        value:index,
                        text:item.name
                    })
                })
            }
        },
        async mounted(){
            await this.getRegions();
            await this.getUser();
            this.id_org = this.user.id_org;
            await this.getObject()
            this.componentReady = true

        },
        methods:{
            async getUser(){
                await Axios.get('/api/user/current').then(res=>
                {this.user = res.data;});
            },
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
                this.currentObject = this.objects.find((item,i)=>i===index);
                console.log(this.currentObject)
            },
            async getObject(){
                await Axios.get(`/api/objects/org/${this.id_org}`).then(res=>{
                    console.log(res.data)
                    this.objects = res.data
                })
            },
            addObject(){
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
                    ob_fin_stroy: null,
                    osn_isp: null,
                    prib_type: null,
                    reconstruct: null,
                    reg_zap: null,
                    smet: null,
                    stroy_date_end: null,
                    stroy_date_start: null,
                    ustav_dey: null,
                });
                this.objName = null;
                this.obj_index = this.objects.length-1;
                this.modalShow = false;
                this.currentObject = this.objects[this.objects.length-1];
            },
            async savePage(){
                if (Object.keys(this.currentObject).length) {
                    let data = new FormData();
                    data.append('object',JSON.stringify(this.currentObject));
                   await Axios.post((!this.currentObject.id) ? `object/create/${this.id_org}` : `object/update/${this.currentObject.id}`,
                        data,{
                           headers: {
                               "X-CSRF-Token": this.csrf
                           }
                       }).then(res => {
                        this.getObject()
                       this.disablePage = true
                    })
                }
            }
        }
    }
</script>

<style scoped>

</style>