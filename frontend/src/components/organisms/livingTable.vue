<template>
    <b-table-simple small borderless>
        <b-thead>
            <b-tr>
                <b-th class="vert-text"><div><span>{{title}}</span></div></b-th>
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
                            <b-form-input :disabled="checkCanSave(index)" v-if="item.editableLabel"/>
                            <span v-else>{{item.label}}</span>
                        </div>
                        <div class="col-3" v-if="!isInvalid">
                            <b-button @click="items[index-1].visible = true" v-if="item.button" variant="outline-secondary" block>
                                <i class="fas fa-plus"></i>
                            </b-button>
                            <b-button @click="item.visible = false" v-if="item.editableLabel" variant="outline-secondary" block>
                                <i class="fas fa-minus"></i>
                            </b-button>
                        </div>
                    </div>

                </b-td>
                <b-td><b-form-input type="number" v-model="item.sred_prof" :disabled="checkCanSave(index)"/></b-td>
                <b-td><b-form-input type="number" v-model="item.bak" :disabled="checkCanSave(index)"/></b-td>
                <b-td><b-form-input type="number" v-model="item.spec" :disabled="checkCanSave(index)"/></b-td>
                <b-td><b-form-input type="number" v-model="item.mag" :disabled="checkCanSave(index)"/></b-td>
                <b-td><b-form-input type="number" v-model="item.asp" :disabled="checkCanSave(index)"/></b-td>
                <b-td><b-form-input type="number" v-model="item.ord" :disabled="checkCanSave(index)"/></b-td>
                <b-td><b-form-input type="number" v-model="item.ipo" :disabled="checkCanSave(index)"/></b-td>
                <b-td><b-form-input type="number" v-model="item.all" disabled/></b-td>
            </b-tr>
        </b-tbody>
    </b-table-simple>
</template>
<script>
    import {BTableSimple,BTbody,BTr,BTd,BThead,BTh,BFormInput,BButton} from 'bootstrap-vue'
    export default {
        name: "livingTable",
        props:{
            blockSave:false,
            canSave:Array,
            isInvalid:false,
            title:String
        },
        methods:{
          checkCanSave(index){

              if (!this.blockSave && this.canSave && !this.items[index].disabled) {
                  return !this.canSave.includes(index);
              }
              return true;

          }
        },
        mounted() {
            this.canSave.forEach(item=>{
                this.items[item].disabled=false;
            })
        },
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
                        disabled: true,
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
                        disabled: true,
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
                        disabled: true,
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
                        disabled: true,
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
                        disabled: true,
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
                        disabled: true,
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
                        disabled: true,
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
                        disabled: true,
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
                        disabled: true,
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
                        disabled: true,
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
    th{
        min-width: 100px !important;
        max-width: 100px !important;
    }

</style>