<template>
    <b-table-simple small borderless>
        <b-thead>
            <b-tr>
                <b-th class="vert-text"><div><span>Проживающие из числа обучающихся за счёт федерального бюджета</span></div></b-th>
                <b-th class="vert-text"><div><span>Среднее профессиональное образование</span></div></b-th>
                <b-th class="vert-text"><div><span>Бакалавриат</span></div></b-th>
                <b-th class="vert-text"><div><span>Специалитет</span></div></b-th>
                <b-th class="vert-text"><div><span>Магистратура</span></div></b-th>
                <b-th class="vert-text"><div><span>Аспирантура</span></div></b-th>
                <b-th class="vert-text"><div><span>Ординатура</span></div></b-th>
                <b-th class="vert-text"><div><span>Иные программы образования</span></div></b-th>
                <b-th class="vert-text"><div><span>Всего</span></div></b-th>
            </b-tr>
        </b-thead>
        <b-tbody>
            <b-tr v-for="(item,index) in items" :key="index" v-if="item.visible">
                <b-td>
                    <div class="row">
                        <div class="col-9">
                            <b-form-input v-if="item.editableLabel"/>
                            <span v-else>{{item.label}}</span>
                        </div>
                        <div class="col-3">
                            <b-button @click="items[index-1].visible = true" v-if="item.button" variant="outline-secondary" block>
                                <i class="fas fa-plus"></i>
                            </b-button>
                            <b-button @click="item.visible = false" v-if="item.editableLabel" variant="outline-secondary" block>
                                <i class="fas fa-minus"></i>
                            </b-button>
                        </div>
                    </div>

                </b-td>
                <b-td><b-form-input type="number" v-model="item.sred_prof" :disabled="item.disabled"/></b-td>
                <b-td><b-form-input type="number" v-model="item.bak" :disabled="item.disabled"/></b-td>
                <b-td><b-form-input type="number" v-model="item.spec" :disabled="item.disabled"/></b-td>
                <b-td><b-form-input type="number" v-model="item.mag" :disabled="item.disabled"/></b-td>
                <b-td><b-form-input type="number" v-model="item.asp" :disabled="item.disabled"/></b-td>
                <b-td><b-form-input type="number" v-model="item.ord" :disabled="item.disabled"/></b-td>
                <b-td><b-form-input type="number" v-model="item.ipo" :disabled="item.disabled"/></b-td>
                <b-td><b-form-input type="number" v-model="item.all" disabled/></b-td>
            </b-tr>
        </b-tbody>
    </b-table-simple>
</template>
<script>
    import {BTableSimple,BTbody,BTr,BTd,BThead,BTh,BFormInput,BButton} from 'bootstrap-vue'
    export default {
        name: "livingTable",
        data(){
            return {
                items:[
                    {
                        label:'Граждане РФ, обучающиеся по очной форме',
                        editableLabel:false,
                        visible:true,
                        button:false,
                        sred_prof:0,
                        bak:0,
                        spec:0,
                        mag:0,
                        asp:0,
                        ord:0,
                        ipo:0,
                        all:0,
                        disabled:false,
                    },
                    {
                        label:'',
                        editableLabel:true,
                        visible:false,
                        button:false,
                        sred_prof:0,
                        bak:0,
                        spec:0,
                        mag:0,
                        asp:0,
                        ord:0,
                        ipo:0,
                        all:0,
                        disabled:false,
                    },
                    {
                        label:'Иностранцы, обучающиеся по очной форме',
                        editableLabel:false,
                        visible:true,
                        button:true,
                        sred_prof:0,
                        bak:0,
                        spec:0,
                        mag:0,
                        asp:0,
                        ord:0,
                        ipo:0,
                        all:0,
                        disabled:true,
                    },
                    {
                        label:'Граждане РФ, обучающиеся по заочной форме',
                        editableLabel:false,
                        visible:true,
                        button:false,
                        sred_prof:0,
                        bak:0,
                        spec:0,
                        mag:0,
                        asp:0,
                        ord:0,
                        ipo:0,
                        all:0,
                        disabled:false,
                    },
                    {
                        label:'',
                        editableLabel:true,
                        visible:false,
                        button:false,
                        sred_prof:0,
                        bak:0,
                        spec:0,
                        mag:0,
                        asp:0,
                        ord:0,
                        ipo:0,
                        all:0,
                        disabled:false,
                    },
                    {
                        label:'Иностранцы, обучающиеся по заочной форме',
                        editableLabel:false,
                        visible:true,
                        button:true,
                        sred_prof:0,
                        bak:0,
                        spec:0,
                        mag:0,
                        asp:0,
                        ord:0,
                        ipo:0,
                        all:0,
                        disabled:true,
                    },
                    {
                        label:'Граждане РФ, обучающиеся по очно-заочной форме',
                        editableLabel:false,
                        visible:true,
                        button:false,
                        sred_prof:0,
                        bak:0,
                        spec:0,
                        mag:0,
                        asp:0,
                        ord:0,
                        ipo:0,
                        all:0,
                        disabled:false,
                    },
                    {
                        label:'',
                        editableLabel:true,
                        visible:false,
                        button:false,
                        sred_prof:0,
                        bak:0,
                        spec:0,
                        mag:0,
                        asp:0,
                        ord:0,
                        ipo:0,
                        all:0,
                        disabled:false,
                    },
                    {
                        label:'Иностранцы, обучающиеся по очно-заочной форме',
                        editableLabel:false,
                        visible:true,
                        button:true,
                        sred_prof:0,
                        bak:0,
                        spec:0,
                        mag:0,
                        asp:0,
                        ord:0,
                        ipo:0,
                        all:0,
                        disabled:true,
                    },
                    {
                        label:'Всего',
                        editableLabel:false,
                        visible:true,
                        button:false,
                        sred_prof:0,
                        bak:0,
                        spec:0,
                        mag:0,
                        asp:0,
                        ord:0,
                        ipo:0,
                        all:0,
                        disabled:true,
                    }
                ]
            }
        },
        components:{
            BTableSimple,BTbody,BTr,BTd,BThead,BTh,BFormInput,BButton
        }
    }
</script>

<style scoped>

</style>