<template>
    <div>
        <nav-bar />

        <div class="container">
            <div class="rov">
                <div class="col-8">
                    <h4>Сведения о тарифах установленных для проживания в жилом объекте</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-6"><label >Наименование жилого объекта</label></div>
                <div class="col-6">
                    <b-form-select @change="setObject" :options="objectsTitle"/>
                </div>
            </div>

            <b-button href="/objects-info" variant="outline-secondary">Добавить объект</b-button>

            <hr>


            <b-table-simple borderless>
                <b-thead>
                    <b-tr>
                        <b-th>Размер платы</b-th>
                        <b-th>За коммунальные услуги с учетом усредненных тарифов</b-th>
                        <b-th>За коммунальные услуги (по показаниям приборов учета)</b-th>
                        <b-th>За пользование жилым помещением</b-th>
                        <b-th>За дополнительные услуги (комфортность, иное)</b-th>
                    </b-tr>
                </b-thead>
                <b-tbody>
                    <b-tr>
                        <b-td>Для обучающиеся за счёт бюджетных средств</b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Для обучающиеся по договорам об оказании платных образовательных услуг </b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Для лиц не являющимися гражданами России</b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Для обучающихся других образовательных организаций</b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                    </b-tr>
                    <b-tr>
                        <b-td>Для иных нанимателей</b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                        <b-td><b-form-input/></b-td>
                    </b-tr>
                </b-tbody>

            </b-table-simple>







        </div>

    </div>
</template>

<script>
    import NavBar from "../../organisms/NavBar";
    import {BFormSelect,BButton,BThead,BFormInput,
        BTh,BTr,BTd,BTbody,BTableSimple} from 'bootstrap-vue'
    export default {
        name: "object_tariff",
        components:{
            NavBar,BButton,
            BFormSelect,
            BFormInput,
            BThead,BTh,BTr,
            BTd,BTbody,BTableSimple
        },
        methods:{
            setObject(index){
                this.currentObject = this.objects.find(item=>item.id===index);
                console.log(index,this.currentObject);
            },
        },
        data(){
            return {
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