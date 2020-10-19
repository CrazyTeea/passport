<template>
  <b-alert v-if="objectsToShow.length" variant="danger" :show="showAlert">
    В следующий объектах не заполнена информация по площади, вычислиямые поля могут быть не корректны
    <ul>
      <li v-for="(obj,index) in objectsToShow" :key="`obj_${index}`">
        <a href="/objects-area">{{ obj.name }}</a>
      </li>
    </ul>
  </b-alert>
</template>

<script>
import {BAlert} from 'bootstrap-vue';

export default {
  components: {
    BAlert,
  },
  props: ['dirtyObjects'],
  data() {
    return {
      objectsToShow: [],
      showAlert: true,
    };
  },
  mounted() {
    this.objectsToShow = this.dirtyObjects.map((item) => {
      if (!item.area) {
        return item;
      }
    });
  },
};
</script>

<style scoped>

</style>
