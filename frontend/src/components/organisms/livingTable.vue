<template>
  <div>
    <b-table-simple small borderless responsive>
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
        <b-tr v-for="(item,index) in itemsRf" :key="`rf-${index}-${item.type}`">
          <b-td>{{item.label}}</b-td>
          <b-td><b-form-input type="number" v-model="item.spo"/></b-td>
          <b-td><b-form-input type="number" v-model="item.bak"/></b-td>
          <b-td><b-form-input type="number" v-model="item.spec"/></b-td>
          <b-td><b-form-input type="number" v-model="item.mag"/></b-td>
          <b-td><b-form-input type="number" v-model="item.asp"/></b-td>
          <b-td><b-form-input type="number" v-model="item.ord"/></b-td>
          <b-td><b-form-input type="number" v-model="item.ipo"/></b-td>
          <b-td>{{ item.all }}</b-td>
        </b-tr>
      </b-tbody>
    </b-table-simple>
  </div>
  
  <!--<b-table-simple small borderless responsive>
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
      <b-tr v-for="(item,index) in items" :key="`item_kek_${index}`" v-if="item.visible" @change="cntRow(item)">
        <b-td>
          <div class="row">
            <div class="col-8">

              <b-form-input v-model="item.label" :disabled="checkCanSave(index)" v-if="item.editableLabel"/>
              <span :class="item.label === 'Всего' ? 'font-weight-bold' : ''" v-else>{{ item.label }}</span>
            </div>
            <div class="col" v-if="!isInvalid && !blockSave">
              <b-button pill class="align-items-center" @click="addRow(index)" v-if="item.button"
                        variant="outline-secondary">
                <i class="fas fa-plus rotate-button"></i>
              </b-button>
              <b-button pill @click="deleteRow(index)" v-if="item.editableLabel" variant="outline-secondary">
                <i class="fas fa-minus"></i>
              </b-button>
            </div>
          </div>

        </b-td>
        <b-td>
          <b-form-input type="number" v-model="item.spo" :disabled="checkCanSave(index)"/>
        </b-td>
        <b-td>
          <b-form-input type="number" v-model="item.bak" :disabled="checkCanSave(index)"/>
        </b-td>
        <b-td>
          <b-form-input type="number" v-model="item.spec" :disabled="checkCanSave(index)"/>
        </b-td>
        <b-td>
          <b-form-input type="number" v-model="item.mag" :disabled="checkCanSave(index)"/>
        </b-td>
        <b-td>
          <b-form-input type="number" v-model="item.asp" :disabled="checkCanSave(index)"/>
        </b-td>
        <b-td>
          <b-form-input type="number" v-model="item.ord" :disabled="checkCanSave(index)"/>
        </b-td>
        <b-td>
          <b-form-input type="number" v-model="item.ipo" :disabled="checkCanSave(index)"/>
        </b-td>
        <b-td>
          <b-form-input type="number" v-model="item.all" disabled/>
        </b-td>
      </b-tr>
    </b-tbody>
  </b-table-simple>-->
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
    items: Array,

    deletedItems: null,
  },
  data(){
    return {
      itemsRf: [
        {
          label: 'Граждане РФ, обучающиеся по очной форме',
          editableLabel: false,
          visible: true,
          button: false,
          name: null,
          budjet_type: 1,
          spo: 0,
          bak: 0,
          spec: 0,
          mag: 0,
          asp: 0,
          ord: 0,
          ipo: 0,
          all: 0,
          type: 'rf_och',
          disabled: false,
        },
        {
          label: 'Граждане РФ, обучающиеся по заочной форме',
          editableLabel: false,
          visible: true,
          button: false,
          spo: 0,
          type: 'rf_zaoch',
          bak: 0,
          spec: 0,
          mag: 0,
          asp: 0,
          ord: 0,
          ipo: 0,
          budjet_type: 1,
          all: 0,
          disabled: false,
        },
        {
          label: 'Граждане РФ, обучающиеся по очно-заочной форме',
          editableLabel: false,
          visible: true,
          button: false,
          spo: 0,
          bak: 0,
          type: 'rf_ochzaoch',
          spec: 0,
          mag: 0,
          asp: 0,
          budjet_type: 1,
          ord: 0,
          ipo: 0,
          all: 0,
          disabled: false,
        }
      ],
      itemsIn: [
        {},{},{}
      ],

    }
  },

  methods: {
    cntRow(item2) {
      Object.keys(this.items[this.items.length - 1]).forEach((item) => {
        if (!(item === 'label' || item === 'visible' || item === 'editableLabel' || item === 'button' || item === 'all' || item === 'id' || item === 'budjet_type')) {
          this.items[this.items.length - 1][item] = 0;
        }
      });
      let kek = 0;
      for (let i = 0; i < this.items.length - 1; i++) {
        Object.keys(this.items[this.items.length - 1]).forEach((item) => {
          if (!(item === 'label' || item === 'visible' || item === 'editableLabel' || item === 'button' || item === 'all' || item === 'id' || item === 'budjet_type')) {
            kek += ~~parseInt(this.items[i][item]);
            this.items[this.items.length - 1][item] += ~~parseInt(this.items[i][item]);
            this.items[this.items.length - 1].all = kek;
          }
        });
      }

      item2.all = ~~parseInt(item2.spo)
          + ~~parseInt(item2.bak)
          + ~~parseInt(item2.spec)
          + ~~parseInt(item2.mag)
          + ~~parseInt(item2.asp)
          + ~~parseInt(item2.ord);
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
    console.log(this.itemsRf)
    this.canSave.forEach((item) => {
      this.items[item].disabled = false;
    });

    let kek = 0;
    for (let i = 0; i < this.items.length - 1; i++) {
      Object.keys(this.items[this.items.length - 1]).forEach((item) => {
        if (!(item === 'label' || item === 'visible' || item === 'editableLabel' || item === 'button' || item === 'all' || item === 'id' || item === 'budjet_type')) {
          kek += ~~parseInt(this.items[i][item]);
          this.items[this.items.length - 1][item] += ~~parseInt(this.items[i][item]);
          this.items[this.items.length - 1].all = kek;
        }
      });
    }
  },
  components: {
    BTableSimple, BTbody, BTr, BTd, BThead, BTh, BFormInput, BButton,
  },
};
</script>

<style scoped>
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
