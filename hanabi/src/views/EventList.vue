<template>
  <div id="list">
    <Header></Header>
    <!--反復表示したい↓-->

    <Calendar
      v-for="(event, day) in events"
      :year="year"
      :month="month"
      :day="day"
      :key="day">
    </Calendar>
    <!--反復表示したい↑-->
    <div id="back">
      <div id = "header_menu">
        <div id="month">
          <span>{{ year }}年<br>{{ month }}<br>月</span>
        </div>
        <p id="select_month">
          <button type="button" v-on:click="prevMonth">Prev</button>
          <button type="button" v-on:click="nextMonth">Next</button>
        </p>
      </div>
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

    var syear = String(this.year)
    var smonth = String(this.month)
    axios.get('https://fireworks.g4rds.mixh.jp/api/eventlist/', { params: { month: syear + '-' + smonth } })
      .then(res => {
        let data = res.data
        let events = {}

        data.forEach((e) => {
          let day = Number(e.date.from.slice(8, 10))
          if (!events[day]) {
            events[day] = []
          }
          events[day].push(e)
        })

        this.events = events
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
      var syear = String(this.year)
      var smonth = String(this.month)
      if (this.month < 10) {
        smonth = '0' + smonth
      }
      axios.get('https://fireworks.g4rds.mixh.jp/api/eventlist/', { params: { month: syear + '-' + smonth } })
        .then(res => {
          let data = res.data
          let events = {}

          data.forEach((e) => {
            let day = Number(e.date.from.slice(8, 10))
            if (!events[day]) {
              events[day] = []
            }
            events[day].push(e)
          })

          this.events = events
        })
        .catch(res => {
          console.log('I cannot get event...')
        })
    },
    nextMonth () {
      if (this.month === 12) {
        this.month = 1
        this.year++
      } else {
        this.month++
      }
      var syear = String(this.year)
      var smonth = String(this.month)
      if (this.month < 10) {
        smonth = '0' + smonth
      }
      axios.get('https://fireworks.g4rds.mixh.jp/api/eventlist/', { params: { month: syear + '-' + smonth } })
        .then(res => {
          let data = res.data
          let events = {}

          data.forEach((e) => {
            let day = Number(e.date.from.slice(8, 10))
            if (!events[day]) {
              events[day] = []
            }
            events[day].push(e)
          })

          this.events = events
        })
        .catch(res => {
          console.log('I cannot get event...')
        })
    }
  }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css?family=Lato');
  #back{
    position: fixed;
    top: 105px;
    background-color: #00439f;
    width:100%;
  }

 #header_menu{
   display: flex;
   justify-content: space-between;
   margin: 0 auto;
   align-items: center;
   width: 100%;
   max-width: 1000px;
   height: 80px;
   background-color: #00439f;
 }

 #month{
   position: relative;
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
   color: #000;
   cursor: pointer;
 }
</style>
