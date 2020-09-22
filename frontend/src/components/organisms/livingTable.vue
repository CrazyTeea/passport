<template>
    <b-table-simple small borderless responsive>
        <b-thead>
            <b-tr>
                <b-th class="vert-text">{{title}}</b-th>
                <b-th class="vert-text">С.П.О</b-th>
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
                            <span class="font-weight-bold" v-else>{{item.label}}</span>
                        </div>
                        <div class="col" v-if="!isInvalid">
                            <b-button pill class="align-items-center" @click="addRow(index)" v-if="item.button" variant="outline-secondary" >
                                <i class="fas fa-plus rotate-button"></i>
                            </b-button>
                            <b-button pill @click="deleteRow(index)" v-if="item.editableLabel" variant="outline-secondary" >
                                <i class="fas fa-minus"></i>
                            </b-button>
                        </div>
                    </div>

                </b-td>
                <b-td><b-form-input type="number" v-model="item.spo" :disabled="checkCanSave(index)"/></b-td>
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

  methods: {
    cntRow(item2) {
      Object.keys(this.items[this.items.length - 1]).forEach((item) => {
        if (!(item === 'label' || item === 'visible' || item === 'editableLabel' || item === 'button' || item === 'all' || item === 'id' || item === 'budjet_type')) { this.items[this.items.length - 1][item] = 0; }
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
      this.items.splice(index, 0, { visible: true, editableLabel: true });
      this.canSave.push(index);
    },
  },
  mounted() {
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
    th{
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
