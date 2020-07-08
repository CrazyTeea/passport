<template>
    <div>
        <nav-bar v-on:block-save="blockPage = !blockPage" />
        <div class="container">
            <div class="row mt-2">
                <div class="col-8"><h4>
                    Сведения о площади, проживающих и количестве мест в жилом объекте
                </h4></div>
            </div>
            <div class="row">
                <div class="col-6"><label >Наименование жилого объекта</label></div>
                <div class="col-6">
                    <b-form-select @change="setObject" :options="objectsTitle"/>
                </div>
            </div>

            <b-button v-if="!blockPage" href="/objects-info" variant="outline-secondary">Добавить объект</b-button>

            <hr>
            <h4>
                Площадь
            </h4>

            <div class="row">
                <div class="col-6"><label for="object_area">Общая площадь, пригодная для проживания</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" disabled id="object_area"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row  mt-2">
                <div class="col-6"><label class="ml-1" for="object_area_prig">1. Жилая площадь, пригодная для проживания</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" disabled v-model="currentObject.schet_bud_subj" id="object_area_prig"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row  mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_zan_ob">А. Занятая обучающимися</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input :disabled="blockPage" type="number" v-model="currentObject.schet_bud_subj" id="object_area_zan_ob"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_in_kat">Б. Занятая иными категориями нанимателей</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number"  :disabled="blockPage" v-model="currentObject.schet_bud_subj" id="object_area_in_kat"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_svod">В. Свободная</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number"  :disabled="blockPage" v-model="currentObject.schet_bud_subj" id="object_area_svod"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_neisp">Г. Неиспользуемая</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_neisp"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-1" for="object_area_ne_plosh_prig_proz">2. Нежилая площадь в пригодных для проживания объектах</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" disabled v-model="currentObject.schet_bud_subj" id="object_area_ne_plosh_prig_proz"/>
                    </b-input-group>
                </div>
            </div>



            <div class="row mt-2">
                <div class="col-6"><label class="ml-2" for="object_area_soc_inf">А. Социальная инфраструктура</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" disabled v-model="currentObject.schet_bud_subj" id="object_area_soc_inf"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row  mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_punkt_pit">Пункты питания</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number"  :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_punkt_pit"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row  mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_zan_ob">Помещения для организации учебного процесса</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number"  :disabled="blockPage" v-model="currentObject.schet_bud_subj" id="object_area_zan_ob"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_in_kat">Помещения для организации медицинского обслуживания</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_in_kat"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_svod">Помещения для организации спортивных занятий</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_svod"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_neisp">Помещения для организации культурных программ</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number"  :disabled="blockPage" v-model="currentObject.schet_bud_subj" id="object_area_neisp"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_ne_plosh_prig_proz">Иные помещения социальной инфраструктуры</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_ne_plosh_prig_proz"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-1" for="object_area_ne_plosh_prig_proz">Б. Иная нежилая площадь</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_ne_plosh_prig_proz"/>
                    </b-input-group>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-6"><label for="object_area_obsh_plosh_nep">Общая площадь, непригодная для проживания</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" disabled v-model="currentObject.schet_bud_subj" id="object_area_obsh_plosh_nep"/>
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
                        <b-td><b-form-input :disabled="blockPage"  type="number" /></b-td>
                        <b-td><b-form-input :disabled="blockPage"  type="number" /></b-td>
                        <b-td><b-form-input disabled type="number" /></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Находится в аварийном состоянии</b-td>
                        <b-td><b-form-input :disabled="blockPage"  type="number" /></b-td>
                        <b-td><b-form-input :disabled="blockPage"  type="number" /></b-td>
                        <b-td><b-form-input disabled type="number" /></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Непригодна для проживания</b-td>
                        <b-td><b-form-input :disabled="blockPage"  type="number" /></b-td>
                        <b-td><b-form-input :disabled="blockPage"  type="number" /></b-td>
                        <b-td><b-form-input disabled type="number" /></b-td>
                    </b-tr>
                </b-tbody>
            </b-table-simple>

            <hr>


            <div class="row">
                <div class="col-6"><label for="object_area_svod">Предоставлено в аренду</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_svod"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label for="object_area_neisp">Предоставлено в безвозмездное пользование</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_neisp"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label for="object_area_ne_plosh_prig_proz">Количество квадратных метров жилой площади на одного проживающего</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" disabled v-model="currentObject.schet_bud_subj" id="object_area_ne_plosh_prig_proz"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label for="object_area_ne_plosh_prig_proz">Количество квадратных метров общей площади на одного проживающего</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" disabled v-model="currentObject.schet_bud_subj" id="object_area_ne_plosh_prig_proz"/>
                    </b-input-group>
                </div>
            </div>

            <hr>

            <h3>Места</h3>

            <div class="row">
                <div class="col-6"><label for="object_area_svod">Количество мест</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" disabled v-model="currentObject.schet_bud_subj" id="object_area_svod"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-2" for="object_area_neisp">1. Количество пригодных для проживания мест</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" disabled v-model="currentObject.schet_bud_subj" id="object_area_neisp"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_ne_plosh_prig_proz">А. Количество мест, занятых обучающимися</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_ne_plosh_prig_proz"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_ne_plosh_prig_proz">Б. Количество мест, занятых иными категориями проживающих</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_ne_plosh_prig_proz"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_ne_plosh_prig_proz">В. Количество свободных мест</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_ne_plosh_prig_proz"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_ne_plosh_prig_proz">Г. Количество неиспользуемых мест</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_ne_plosh_prig_proz"/>
                    </b-input-group>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-6"><label class="ml-2" for="object_area_neisp">2. Количество непригодных к использованию мест</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_neisp"/>
                    </b-input-group>
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-6"><label for="object_area_ne_plosh_prig_proz">Количество мест оборудованных для лиц с ограниченными возможностями здоровья</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" :disabled="blockPage"  v-model="currentObject.schet_bud_subj" id="object_area_ne_plosh_prig_proz"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label for="object_area_ne_plosh_prig_proz">Количество мест, возможных к вводу в эксплуатацию после проведения восстановительных работ</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <b-form-input type="number" disabled v-model="currentObject.schet_bud_subj" id="object_area_ne_plosh_prig_proz"/>
                    </b-input-group>
                </div>
            </div>
            <div class="row">
                <div class="col-6"><label class="ml-4" for="object_area_ne_plosh_prig_proz">1. Количество мест, возможных к вводу в эксплуатацию из числа неиспользуемых после проведения восстановительных работ</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip">
                                Восстановительные работы - проведение капитального ремонта/приведения
                                объекта в соответствие с установленными санитарными и техническими
                                правилами и нормами, иными требованиями законодательства
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" id="object_area_ne_plosh_prig_proz"/>
                    </b-input-group>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-6"><label class="ml-4" for="object_area_neisp">2. Количество мест, возможных к вводу в эксплуатацию из числа непригодных к использованию после проведения восстановительных работ</label></div>
                <div class="col-6">
                    <b-input-group append="м2">
                        <template v-slot:prepend>
                            <b-input-group-text >
                                <i id="huy_mest_tooltip2" class="fas fa-question-circle"></i>
                            </b-input-group-text>
                            <b-tooltip custom-class="tooltip_width" target="huy_mest_tooltip2">
                                Восстановительные работы - проведение капитального ремонта/приведения
                                объекта в соответствие с установленными санитарными и техническими
                                правилами и нормами, иными требованиями законодательства
                            </b-tooltip>
                        </template>
                        <b-form-input type="number" v-model="currentObject.schet_bud_subj" id="object_area_neisp"/>
                    </b-input-group>
                </div>
            </div>


        </div>
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

    export default {
        name: "object_area",
        components:{
            NavBar,
            BTooltip,
            BButton,
            BFormSelect,
            BFormInput,
            BInputGroup,
            BTableSimple,
            BThead,BTh,
            BInputGroupText,
            BTr,BTd,BTbody
        },
        methods:{
            setObject(index){
                this.currentObject = this.objects.find(item=>item.id===index);
                console.log(index,this.currentObject);
            },
        },
        data(){
            return {
                blockPage:true,
                currentObject:{},
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
        }
    }
</script>

<style scoped>

</style>