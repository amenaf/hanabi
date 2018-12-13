<template>
  <div class="calendar">
    <div class="header" v-on:click="toggle">
      <i class="fa fa-2x fa-angle-down header-icon" v-bind:class="{ rotate: show}"></i>
      <span>{{ day }}日</span>
    </div>
    <transition>
      <div class="body" v-show="show">
        <div class="body-inner">
          <router-link
            class="event"
            v-for="e in event"
            :key="e.id"
            :to="{ name: 'event', params: { id: e.id } }">
            <h3>{{ e.name }}</h3>
            <p>{{ e.description }}</p>
            <div class="detail">
              <div class="prefecture">{{ e.prefecture }}</div>
              <div v-if="e.fireworks" class="fireworks">{{ e.fireworks }}<span class="unit">発</span></div>
              <div class="spacer"></div>
              <div class="review">
                <div class="good"><i class="fas fa-thumbs-up"></i>{{ e.review.good }}</div>
                <div class="bad"><i class="fas fa-thumbs-down"></i>{{ e.review.bad }}</div>
              </div>
            </div>
          </router-link>
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
    day: String,
    event: Array
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
  margin: 40px auto;
  background-color: #ec5336;
}

.calendar .header{
  height: 80px;
  line-height: 80px;
  position: relative;
  color: #FFF;
  cursor: pointer;
}

.calendar .header span{
  position:absolute;
  left: 5px;
  top: 0px;
  font-size: 30px;
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

.body-inner {
  padding: 20px;
}

.event {
  display: block;

  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
}
.event h3 {
  padding: 0 0.5em 0.5rem 0.5rem;
  margin-bottom: 1em;
  border-bottom: 1px solid #00439f;

  text-align: left;
  font-size: 18px;
  color: #444;
}
.event p {
  margin-bottom: 1em;

  font-size: 16px;
}
.event .detail {
  display: flex;
  align-items: center;

  padding: 0 0.5em;
}
.event .detail .prefecture {
  flex: 0 0 auto;

  height: 14px;
  padding: 6px;
  margin-right: 14px;
  border-radius: 13px;

  font-size: 14px;
  line-height: 14px;
  color: #05449c;
  background: #c1d7f6;
}
.event .fireworks {
  flex: 0 0 auto;

  font-size: 14px;
  color: #222;
}
.event .fireworks .unit {
  font-size: 11px;
  color: #777;
}
.event .spacer {
  flex: 1 1 0;
}
.event .review {
  display: flex;
}
.event .review div {
  height: 14px;
  margin-right: 14px;

  font-size: 14px;
  line-height: 14px;
}
.event .review div:last-child {
  margin-right: 0;
}
.event .review i {
  margin-right: 0.5em;
}
.event .review .good {
  /* border: 1px solid #2b6aff; */
  color: #2b6aff;
}
.event .review .bad {
  /* border: 1px solid #ff532b; */
  color: #ff532b;
}
</style>
