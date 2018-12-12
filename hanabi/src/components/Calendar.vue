<template>
  <div class="calendar">
    <div class="header" v-on:click="toggle">
      <i class="fa fa-2x fa-angle-down header-icon" v-bind:class="{ rotate: show}"></i>
      <!--ここにそれぞれのイベントの日付とイベントの数-->
      <span>{{ day }}</span>
    </div>
    <transition>
      <div class="body" v-show="show">
        <div class="body-inner">
          ここに本体
        </div>
      </div>
    </transition>
   </div>
</template>

<script>
export default {
  props: {
    year: Number,
    month: Number,
    item: Object,
    day: String
  },
  data () {
    return {
      show: false
    }
  },

  methods: {
    toggle () {
      this.show = !this.show
    }
  }
}
</script>

<style>
.calendar{
  max-width: 800px;
  font-family: Lato;
  margin-bottom: 0;
  margin-top: 0;
  margin: 0 auto;
  background-color: #ec5336;
}

.calendar .header{
  margin-top: 20px;
  height: 80px;
  line-height: 80px;
  position: relative;
  color: #FFF;
  cursor: pointer;
}

.calendar .header span{
  position:absolute;
  left: 5;
  top: 5;
}
.calendar .header-icon{
  position: absolute;
  top: 10px;
  right: 16px;
  transform: rotate(0deg);
  transition-duration: 0.3s;
}

.calendar .header-icon.rotate{
  transform: rotate(180deg);
  transition-duration: 0.3s;
}

.calendar .body{
  overflow: hidden;
  background-color: #FFF;
  border: 10px solid #00439f;
  border-top: 0;
}

.accordion .body-inner{
  padding: 8px;
  overflow-wrap: break-word;
}

.accordion .header-icon.rotate{
  transform: rotate(180deg);
  transition-duration: 0.3s;
}

.calendar .header:first-child{
  margin-top: 80px;
}
</style>
