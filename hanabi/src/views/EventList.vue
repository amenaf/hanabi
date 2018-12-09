<template>
  <div id="list">
    <Header></Header>
    /*反復表示したい↓*/

    <Calendar
      v-for="item in list"
      :year="year"
      :month="month"
      :item="item"
      :key="">
    </Calendar>
   /*反復表示したい↑*/
  <div class="header_menu">
    <div id="month">
      <span>{{ year }}年<br>{{ month }}<br>月</span>
    </div>
    <p id="select_month">
      <button type="button" v-on:click="prevMonth">Prev</button>
      <button type="button" v-on:click="nextMonth">Next</button>
    </p>
  </div>
  </div>
</template>

<script>
import axios from 'axios'
import Calendar from '@/components/Calendar'
import Header from '@/components/Header'
export default{
  name: 'eventlist',
  components: {
    Header,
    Calendar
  },
  data () {
    return {
      year: 2100,
      month: 1,
      events: {}
    }
  },
  created () {
    let now = new Date()
    this.year = now.getFullYear()
    this.month = now.getMonth() + 1

    axios.get('https://fireworks.g4rds.mixh.jp/api/eventlist', { params: { month: '2018-12' } })
      .then(res => {
        let events = res.data
        events.forEach((e) => {
          let day = Number(e.date.from.slice(8, 9))
          if (!this.events[day]) {
            this.events[day] = []
          }
          this.events[day].push(e)
        })
      })
      .catch(res => {
        console.log('I cannot get event...')
      })
  },
  methods: {
    prevMonth () {
      if (this.month === 1) {
        this.month = 12
        this.year--
      } else {
        this.month--
      }
    },
    nextMonth () {
      if (this.month === 12) {
        this.month = 1
        this.year++
      } else {
        this.month++
      }
    }
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Lato');
 .header_menu{
   position: fixed;
   top: 0;
   right: 0;
   left: 0;
   height: 80px;
   background-color: #00439f;
 }

 #month{
   position: fixed;
   top: 5px;
   left: 5;
   height: 70px;
   width: 70px;
   border-radius: 10%;
   background-color: #fe0;
 }
 #month span{
   position: absolute;
   top: 50%;
   left: 0;
   -webkit-transform: translateY(-50%);
   -ms-transform: translateY(-50%);
   transform: translateY(-50%);
   width :70px;
   text-align:center;
 }

 #select_month {
   position: fixed;
   top: 30px;
   right: 60px;
   color: #000;
   cursor: pointer;
 }
 #list {
   max-width: 1000px;
   margin: 0 auto;
   padding: 0 20px;
 }
 .calendar{
   max-width: 800px;
   font-family: Lato;
   margin-bottom: 0;
   margin-top: 0;
   background-color: #ec5336;
 }

 .calendar .header{
   margin-top: 80px;
   height: 80px;
   line-height: 80px;
   position: relative;
   color: #FFF;
   cursor: pointer;
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
</style>
