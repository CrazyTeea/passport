<template>
  <div>
    <b-table-simple class="mb-0" small borderless>
      <b-thead>
        <b-tr>
          <b-th class="vert-text">{{ title }}</b-th>
          <b-th class="vert-text">С.П.О.</b-th>
          <b-th class="vert-text">Бакалавр</b-th>
          <b-th class="vert-text">Специалист</b-th>
          <b-th class="vert-text">Магистр</b-th>
          <b-th class="vert-text">Аспирант</b-th>
          <b-th class="vert-text">Ординатор</b-th>
          <b-th class="vert-text">Иные прог. обр.</b-th>
          <b-th class="vert-text">Всего</b-th>
        </b-tr>
      </b-thead>
      <b-tbody>
        <b-tr :class=" !isInvalid ? 'border-r' : ''" v-for="(item,index) in items.rf" :key="`rf-${index}-${item.type}`">
          <b-td class="w-25">{{ item.label }}</b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'rf',index)" min="0" type="number"
                          v-model="item.spo"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'rf',index)" min="0" type="number"
                          v-model="item.bak"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'rf',index)" min="0" type="number"
                          v-model="item.spec"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'rf',index)" min="0" type="number"
                          v-model="item.mag"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'rf',index)" min="0" type="number"
                          v-model="item.asp"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'rf',index)" min="0" type="number"
                          v-model="item.ord"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'rf',index)" min="0" type="number"
                          v-model="item.in"/>
          </b-td>
          <b-th>
            <div class="mt-2">{{ item.all }}</div>
          </b-th>
        </b-tr>
      </b-tbody>
    </b-table-simple>

    <b-table-simple v-if="isInvalid" class="mb-0" small borderless>
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
        <b-tr v-for="(item,index) in items.in" :key="`in-${index}-${item.type}`">
          <b-td class="w-25">{{ item.label }}</b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in',index)" min="0" type="number"
                          v-model="item.spo"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in',index)" min="0" type="number"
                          v-model="item.bak"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in',index)" min="0" type="number"
                          v-model="item.spec"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in',index)" min="0" type="number"
                          v-model="item.mag"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in',index)" min="0" type="number"
                          v-model="item.asp"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in',index)" min="0" type="number"
                          v-model="item.ord"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in',index)" min="0" type="number"
                          v-model="item.in"/>
          </b-td>
          <b-th>
            <div class="mt-2">{{ item.all }}</div>
          </b-th>
        </b-tr>
        <b-tr>
          <b-th>
            <div class="mt-2">Всего</div>
          </b-th>
          <b-th>
            <div class="ml-3">{{ sums.spo }}</div>
          </b-th>
          <b-th>
            <div class="ml-3">{{ sums.bak }}</div>
          </b-th>
          <b-th>
            <div class="ml-3">{{ sums.spec }}</div>
          </b-th>
          <b-th>
            <div class="ml-3">{{ sums.mag }}</div>
          </b-th>
          <b-th>
            <div class="ml-3">{{ sums.asp }}</div>
          </b-th>
          <b-th>
            <div class="ml-3">{{ sums.ord }}</div>
          </b-th>
          <b-th>
            <div class="ml-3">{{ sums.in1 }}</div>
          </b-th>
          <b-th>
            <div class="">{{ sums.all }}</div>
          </b-th>
        </b-tr>
      </b-tbody>
    </b-table-simple>

    <b-table-simple v-if="!isInvalid" class="mb-0" small borderless>
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
        <b-tr>
          <b-td>Иностранцы, обучающиеся по очной форме</b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
        </b-tr>
        <b-tr v-for="(item,index) in items.in_och"
              :key="`in_och-${index}-${item.type}`">
          <b-td class="w-25">
            <div class="row">
              <div v-if="!blockSave" class="col-2 offset-1 mt-2">
                <a class="text-secondary rotate-button" @click="deleteRow('in_och',index)">
                  <i class="fa fa-minus-circle fa-2x"></i>
                </a>
              </div>
              <div class="col">
                <s-select :kek="item.name + index" :key="`s-select-in_och_${item.name}`" :disabled="blockSave" v-model="item.name"
                />
              </div>
            </div>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_och',index)" min="0" type="number"
                          v-model="item.spo"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_och',index)" min="0" type="number"
                          v-model="item.bak"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_och',index)" min="0" type="number"
                          v-model="item.spec"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_och',index)" min="0" type="number"
                          v-model="item.mag"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_och',index)" min="0" type="number"
                          v-model="item.asp"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_och',index)" min="0" type="number"
                          v-model="item.ord"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_och',index)" min="0" type="number"
                          v-model="item.in"/>
          </b-td>
          <b-th>
            <div class="mt-2">{{ item.all }}</div>
          </b-th>
        </b-tr>
        <b-tr class="border-r">
          <b-td>
            <div class="row">
              <div v-if="!blockSave" class="col-2 offset-1">
                <div class="rotate-button text-secondary" @click="addRow('in_och')">
                  <i class="fas fa-plus-circle fa-2x"></i>
                </div>
              </div>
              <div class="col">
                <div class="mt-1">Всего</div>
              </div>
            </div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_och.spo }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_och.bak }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_och.spec }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_och.mag }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_och.asp }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_och.ord }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_och.in }}</div>
          </b-td>
          <b-th>
            <div class="">{{ sums.in_och.all }}</div>
          </b-th>
        </b-tr>
      </b-tbody>
    </b-table-simple>

    <b-table-simple v-if="!isInvalid" class="mb-0" small borderless>
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
        <b-tr>
          <b-td>Иностранцы, обучающиеся по заочной форме</b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
        </b-tr>
        <b-tr v-for="(item,index) in items.in_zaoch"
              :key="`in_zaoch-${index}-${item.type}`">
          <b-td class="w-25">
            <div class="row">
              <div v-if="!blockSave" class="col-2 offset-1 mt-2">
                <a class="text-secondary rotate-button" @click="deleteRow('in_zaoch',index)">
                  <i class="fa fa-minus-circle fa-2x"></i>
                </a>
              </div>
              <div class="col">
                <s-select :kek="item.name + index" :key="`s-select-in_zaoch_${item.name}`" :disabled="blockSave" v-model="item.name"/>
              </div>
            </div>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_zaoch',index)" min="0" type="number"
                          v-model="item.spo"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_zaoch',index)" min="0" type="number"
                          v-model="item.bak"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_zaoch',index)" min="0" type="number"
                          v-model="item.spec"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_zaoch',index)" min="0" type="number"
                          v-model="item.mag"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_zaoch',index)" min="0" type="number"
                          v-model="item.asp"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_zaoch',index)" min="0" type="number"
                          v-model="item.ord"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_zaoch',index)" min="0" type="number"
                          v-model="item.in"/>
          </b-td>
          <b-th>
            <div class="mt-2">{{ item.all }}</div>
          </b-th>
        </b-tr>
        <b-tr class="border-r">
          <b-td>
            <div class="row">

              <div v-if="!blockSave" class="col-2 offset-1">
                <div class="rotate-button text-secondary" @click="addRow('in_zaoch')">
                  <i class="fas fa-plus-circle fa-2x"></i>
                </div>
              </div>
              <div class="col">
                <div class="mt-1">Всего</div>
              </div>
            </div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_zaoch.spo }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_zaoch.bak }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_zaoch.spec }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_zaoch.mag }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_zaoch.asp }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_zaoch.ord }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_zaoch.in }}</div>
          </b-td>
          <b-th>
            <div class="">{{ sums.in_zaoch.all }}</div>
          </b-th>
        </b-tr>
      </b-tbody>
    </b-table-simple>
    <b-table-simple v-if="!isInvalid" small borderless>
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
        <b-tr>
          <b-td>Иностранцы, обучающиеся по очно-заочной форме</b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
          <b-td></b-td>
        </b-tr>
        <b-tr v-for="(item,index) in items.in_ochzaoch"
              :key="`in_ochzaoch-${index}-${item.type}`">
          <b-td class="w-25">
            <div class="row">
              <div v-if="!blockSave" class="col-2 offset-1 mt-2">
                <a class="text-secondary rotate-button" @click="deleteRow('in_ochzaoch',index)">
                  <i class="fa fa-minus-circle fa-2x"></i>
                </a>
              </div>
              <div class="col">
                <s-select :kek="item.name + index" :key="`s-select-in_ochzaoch_${item.name}`" :disabled="blockSave" v-model="item.name"
                />
              </div>
            </div>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number"
                          v-model="item.spo"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number"
                          v-model="item.bak"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number"
                          v-model="item.spec"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number"
                          v-model="item.mag"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number"
                          v-model="item.asp"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number"
                          v-model="item.ord"/>
          </b-td>
          <b-td>
            <b-form-input :disabled="blockSave" @change="cntRow(item,'in_ochzaoch',index)" min="0" type="number"
                          v-model="item.in"/>
          </b-td>
          <b-th>
            <div class="mt-2">{{ item.all }}</div>
          </b-th>
        </b-tr>
        <b-tr class="border-r">
          <b-td>
            <div class="row">

              <div v-if="!blockSave" class="col-2 offset-1">
                <div class="rotate-button text-secondary" @click="addRow('in_ochzaoch')">
                  <i class="fas fa-plus-circle fa-2x"></i>
                </div>
              </div>
              <div class="col">
                <div class="mt-1">Всего</div>
              </div>
            </div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_ochzaoch.spo }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_ochzaoch.bak }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_ochzaoch.spec }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_ochzaoch.mag }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_ochzaoch.asp }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_ochzaoch.ord }}</div>
          </b-td>
          <b-td>
            <div class="ml-3">{{ sums.in_ochzaoch.in }}</div>
          </b-td>
          <b-th>
            <div class="">{{ sums.in_ochzaoch.all }}</div>
          </b-th>

        </b-tr>
        <b-tr>
          <b-th>Всего</b-th>
          <b-th>
            <div class="ml-3">{{ sums.spo }}</div>
          </b-th>
          <b-th>
            <div class="ml-3">{{ sums.bak }}</div>
          </b-th>
          <b-th>
            <div class="ml-3">{{ sums.spec }}</div>
          </b-th>
          <b-th>
            <div class="ml-3">{{ sums.mag }}</div>
          </b-th>
          <b-th>
            <div class="ml-3">{{ sums.asp }}</div>
          </b-th>
          <b-th>
            <div class="ml-3">{{ sums.ord }}</div>
          </b-th>
          <b-th>
            <div class="ml-3">{{ sums.in1 }}</div>
          </b-th>
          <b-th>
            <div class="">{{ sums.all }}</div>
          </b-th>
        </b-tr>


      </b-tbody>
    </b-table-simple>
  </div>
</template>
<script>
import Select from "./Select";
import {BButton, BFormInput, BTableSimple, BTbody, BTd, BTh, BThead, BTr,} from 'bootstrap-vue';

export default {
  name: 'livingTable',
  props: {
    blockSave: {
      default: false,
    },
    budjet_type: 0,
    canSave: Array,
    isInvalid: {
      default: false,
    },
    title: String,
    items: Object,
    deletedItems: Array,
  },
  data() {
    return {
      sums: {
        in1: 0,
        mag: 0,
        name: 0,
        ord: 0,
        asp: 0,
        spec: 0,
        bak: 0,
        spo: 0,
        all: 0,
        in: {
          in: 0,
          mag: 0,
          name: 0,
          ord: 0,
          asp: 0,
          spec: 0,
          bak: 0,
          spo: 0,
          all: 0
        },
        in_och: {
          in: 0,
          mag: 0,
          name: 0,
          ord: 0,
          asp: 0,
          spec: 0,
          bak: 0,
          spo: 0,
          all: 0
        },
        in_zaoch: {
          in: 0,
          mag: 0,
          name: 0,
          ord: 0,
          asp: 0,
          spec: 0,
          bak: 0,
          spo: 0,
          all: 0
        },
        in_ochzaoch: {
          in: 0,
          mag: 0,
          name: 0,
          ord: 0,
          asp: 0,
          spec: 0,
          bak: 0,
          spo: 0,
          all: 0
        },
        rf: {
          in: 0,
          mag: 0,
          name: 0,
          ord: 0,
          asp: 0,
          spec: 0,
          bak: 0,
          spo: 0,
          all: 0
        },

      }
    }
  },

  methods: {
    cntRow(item, arr, index, all = false) {


      let toNum = num => typeof num === 'string' ? num.toNumber() : num;


      this.sums.spo = 0;
      this.sums.bak = 0;
      this.sums.spec = 0;
      this.sums.mag = 0;
      this.sums.asp = 0;
      this.sums.ord = 0;
      this.sums.in1 = 0;
      this.sums.all = 0;

      let cntItem = item => item.all = toNum(item.spo)
          + toNum(item.bak)
          + toNum(item.spec)
          + toNum(item.mag)
          + toNum(item.asp)
          + toNum(item.ord)
          + toNum(item.in);

      let cntArr = arr => {

        if (!this.isInvalid) {
          this.sums[arr].spo = this.items[arr].reduce((a, b) => a + toNum(b.spo), 0);
          this.sums[arr].bak = this.items[arr].reduce((a, b) => a + toNum(b.bak), 0);
          this.sums[arr].spec = this.items[arr].reduce((a, b) => a + toNum(b.spec), 0);
          this.sums[arr].mag = this.items[arr].reduce((a, b) => a + toNum(b.mag), 0);
          this.sums[arr].asp = this.items[arr].reduce((a, b) => a + toNum(b.asp), 0);
          this.sums[arr].ord = this.items[arr].reduce((a, b) => a + toNum(b.ord), 0);
          this.sums[arr].in = this.items[arr].reduce((a, b) => a + toNum(b.in), 0);
          this.sums[arr].all = this.items[arr].reduce((a, b) => a + toNum(b.all), 0);

        }

      }


      if (!all) {

        cntItem(item);

        cntArr(arr);


      } else {
        Object.keys(this.items).forEach(key => {
          this.items[key].forEach(item => {
            cntItem(item);
          })
          cntArr(key);
        })
      }
      Object.keys(this.items).forEach(i => {
        this.sums.spo += this.items[i].reduce((a, b) => a + toNum(b.spo), 0);
        this.sums.bak += this.items[i].reduce((a, b) => a + toNum(b.bak), 0);
        this.sums.spec += this.items[i].reduce((a, b) => a + toNum(b.spec), 0);
        this.sums.mag += this.items[i].reduce((a, b) => a + toNum(b.mag), 0);
        this.sums.asp += this.items[i].reduce((a, b) => a + toNum(b.asp), 0);
        this.sums.ord += this.items[i].reduce((a, b) => a + toNum(b.ord), 0);
        this.sums.in1 += this.items[i].reduce((a, b) => a + toNum(b.in), 0);
        this.sums.all += this.items[i].reduce((a, b) => a + toNum(b.all), 0);
      })


      this.$forceUpdate();


    },
    deleteRow(arr, index) {
      if (this.items[arr][index].id) {
        this.deletedItems.push(this.items[arr][index].id);
      }
      this.items[arr].splice(index, 1);
      if (index) {
        let kek = this.items[arr][index].name;
        this.items[arr][index].name = kek;
      }
      this.cntRow(null, null, null, true);
    },
    checkCanSave(index) {
      if (!this.blockSave && this.canSave && !this.items[index].disabled) {
        return !this.canSave.includes(index);
      }
      return true;
    },
    addRow(array) {
      this.items[array].splice(this.items[array].length, 0,
          {
            asp: null,
            bak: null,
            budjet_type: this.budjet_type,
            in: null,
            invalid: null,
            mag: null,
            name: null,
            ord: null,
            spec: null,
            spo: null,
            type: array,
            all: 0
          });

    },
  },
  mounted() {
    this.cntRow(null, null, null, true)
  },
  components: {
    BTableSimple, BTbody, BTr, BTd, BThead, BTh, BFormInput, BButton, 'SSelect': Select
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

.border-r {
  border-bottom: rgba(0, 0, 0, .25) 1px solid;
}

.rotate-button > i {
  transition: ease .4s;
  cursor: pointer;
}

.rotate-button:hover > i {
  transform: rotate(180deg);
  transition: ease .4s;
}

</style>
