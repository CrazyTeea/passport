<template>
  <div v-if="showChevron" class="scroll" @click="click">
    <div  >
      <div class="chevron"></div>
      <div class="chevron"></div>
      <div class="chevron"></div>
    </div>

  </div>

</template>

<script>
export default {
  name: "scrollButton",
  data() {
    return {
      height: document.getElementsByClassName('wrap')[0].scrollHeight,
      showChevron: false
    }
  },
  watch: {
  },
  mounted() {
    let el = document.getElementsByClassName('wrap')[0];
    el.addEventListener('change',this.sh)
    this.sh();
  },
  methods: {
    sh() {
      setTimeout(()=>{
        let el_h = document.getElementById('wrap').scrollHeight;
        let w_h = window.outerHeight;
        console.log(el_h,w_h)
        this.showChevron = el_h > w_h;
      },500)
    },
    click(){
      document.getElementsByClassName('custom-navbar')[0].scrollIntoView({behavior:'smooth'});
    }
  }
}
</script>

<style lang="scss" scoped>

.scroll {
  opacity: 15%;
  cursor: pointer;
  position: fixed;
  width: 50px;
  height: 50px;
  left: 1%;
  bottom: 5%;
  transform: rotate(180deg);
}

.scroll:hover {
  opacity: 1;
  transition: opacity 1s, visibility 0.3s;
}


$base: 0.6rem;

.container {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100vh;
}

.chevron {
  position: absolute;
  width: $base * 5;
  height: $base * 0.5;
  opacity: 0;
  transform: scale(0.3);
  animation: move-chevron 3s ease-out infinite;
}

.chevron:first-child {
  animation: move-chevron 3s ease-out 1s infinite;
}

.chevron:nth-child(2) {
  animation: move-chevron 3s ease-out 2s infinite;
}

.chevron:before,
.chevron:after {
  content: '';
  position: absolute;
  top: 0;
  height: 100%;
  width: 50%;
  background: #2c3e50;
  //transform: rotate(180deg);
}

.chevron:before {
  left: 0;
  transform: skewY(30deg);
}

.chevron:after {
  right: 0;
  width: 50%;
  transform: skewY(-30deg);
}

@keyframes move-chevron {
  25% {
    opacity: 1;
  }
  33.3% {
    opacity: 1;
    transform: translateY($base * 3.8);
  }
  66.6% {
    opacity: 1;
    transform: translateY($base * 5.2);
  }
  100% {
    opacity: 0;
    transform: translateY($base * 8) scale(0.5);
  }
}

</style>