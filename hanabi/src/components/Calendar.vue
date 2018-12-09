<template>
  <div class="calendar">
    <div class="header" v-on:click="toggle">
      <i class="fa fa-2x fa-angle-down header-icon" v-bind:class="{ rotate: show}"></i>
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
    item: Object
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
