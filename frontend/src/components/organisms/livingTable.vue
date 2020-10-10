<template>
  <div>
    <b-table-simple class="mb-0" small borderless responsive>
      <b-thead>
        <b-tr>
          <b-th class="vert-text">{{ title }}</b-th>
          <b-th class="vert-text">С.П.О.</b-th>
          <b-th class="vert-text">Бакалавриат</b-th>
          <b-th class="vert-text">Специалитет</b-th>
          <b-th class="vert-text">Магистратура</b-th>
          <b-th class="vert-text">Аспирантура</b-th>
          <b-th class="vert-text">Ординатура</b-th>
          <b-th class="vert-text">Иные прог. обр.</b-th>
          <b-th class="vert-text">Всего</b-th>
        </b-tr>
      </b-thead>
      <b-tbody>
        <b-tr v-for="(item,index) in items.rf" :key="`rf-${index}-${item.type}`">
          <b-td class="w-25">{{ item.label }}</b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'rf',index)" min="0" type="number" v-model="item.spo"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'rf',index)" min="0" type="number" v-model="item.bak"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'rf',index)" min="0" type="number" v-model="item.spec"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'rf',index)" min="0" type="number" v-model="item.mag"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'rf',index)" min="0" type="number" v-model="item.asp"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'rf',index)" min="0" type="number" v-model="item.ord"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'rf',index)" min="0" type="number" v-model="item.in"/>
          </b-td>
          <b-td>{{ item.all }}</b-td>
        </b-tr>
      </b-tbody>
    </b-table-simple>

    <b-table-simple class="mb-0" small borderless responsive>
      <b-thead>
        <b-tr>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
        </b-tr>
      </b-thead>
      <b-tbody>
        <b-tr v-for="(item,index) in items.in_och" :key="`in_och-${index}-${item.type}`">
          <b-td class="w-25">{{ item.label }}</b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_och',index)" min="0" type="number" v-model="item.spo"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_och',index)" min="0" type="number" v-model="item.bak"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_och',index)" min="0" type="number" v-model="item.spec"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_och',index)" min="0" type="number" v-model="item.mag"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_och',index)" min="0" type="number" v-model="item.asp"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_och',index)" min="0" type="number" v-model="item.ord"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_och',index)" min="0" type="number" v-model="item.in"/>
          </b-td>
          <b-td>{{ item.all }}</b-td>
        </b-tr>
      </b-tbody>
    </b-table-simple>

    <b-table-simple class="mb-0" small borderless responsive>
      <b-thead>
        <b-tr>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
        </b-tr>
      </b-thead>
      <b-tbody>
        <b-tr v-for="(item,index) in items.in_zaoch" :key="`in_zaoch-${index}-${item.type}`">
          <b-td class="w-25">{{ item.label }}</b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_zaoch',index)" min="0" type="number" v-model="item.spo"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_zaoch',index)" min="0" type="number" v-model="item.bak"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_zaoch',index)" min="0" type="number" v-model="item.spec"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_zaoch',index)" min="0" type="number" v-model="item.mag"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_zaoch',index)" min="0" type="number" v-model="item.asp"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_zaoch',index)" min="0" type="number" v-model="item.ord"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_zaoch',index)" min="0" type="number" v-model="item.in"/>
          </b-td>
          <b-td>{{ item.all }}</b-td>
        </b-tr>
      </b-tbody>
    </b-table-simple>
    <b-table-simple small borderless responsive>
      <b-thead>
        <b-tr>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
          <b-th class="vert-text"></b-th>
        </b-tr>
      </b-thead>
      <b-tbody>
        <b-tr v-for="(item,index) in items.in_ochzaoch" :key="`in_ochzaoch-${index}-${item.type}`">
          <b-td class="w-25">{{ item.label }}</b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number" v-model="item.spo"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number" v-model="item.bak"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number" v-model="item.spec"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number" v-model="item.mag"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number" v-model="item.asp"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number" v-model="item.ord"/>
          </b-td>
          <b-td>
            <b-form-input @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number" v-model="item.in"/>
          </b-td>
          <b-td>{{ item.all }}</b-td>
        </b-tr>
      </b-tbody>
    </b-table-simple>
  </div>
</template>
<script>
import {
  BButton, BFormInput, BTableSimple, BTbody, BTd, BTh, BThead, BTr,
} from 'bootstrap-vue';

export default {
  name: 'livingTable',
  props: {
    blockSave: {
      default: false,
    },
    canSave: Array,
    isInvalid: {
      default: false,
    },
    title: String,
    items: Object,

    deletedItems: null,
  },

  methods: {
    cntRow(item, arr, index) {
      let toNum = num => typeof num === 'string' ? num.toNumber() : num;
      item.all = toNum(item.spo)
          + toNum(item.bak)
          + toNum(item.spec)
          + toNum(item.mag)
          + toNum(item.asp)
          + toNum(item.ord)
          + toNum(item.in);

      this.$forceUpdate();


    },
    deleteRow(index) {
      if (this.items[index].id) {
        this.deletedItems.push(this.items[index].id);
      }
      this.items.splice(index, 1);
    },
    checkCanSave(index) {
      if (!this.blockSave && this.canSave && !this.items[index].disabled) {
        return !this.canSave.includes(index);
      }
      return true;
    },
    addRow(index) {
      this.items.splice(index, 0, {visible: true, editableLabel: true});
      this.canSave.push(index);
    },
  },
  mounted() {

  },
  components: {
    BTableSimple, BTbody, BTr, BTd, BThead, BTh, BFormInput, BButton,
  },
};
</script>

<style scoped>
td {
  vertical-align: inherit !important;
}

th {
  min-width: 100px !important;
  max-width: 100px !important;
}

.rotate-button {
  transition: ease .4s;
}

.rotate-button:hover {
  transform: rotate(180deg);
  transition: ease .4s;
}

</style>
