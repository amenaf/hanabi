<template>
  <div id="list">
    <Header></Header>
    <div class="container" v-if="event">
      <h1>{{ event.name }}</h1>
      <div class="pref-date">
        <div class="prefecture">{{ event.prefecture }}</div>
        <div class="date">{{ event.date_from + ' ~ ' + event.date_to }}</div>
        <div class="time">{{ event.time_from.slice(0, 5) + ' ~ ' + event.time_to.slice(0, 5) }}</div>
      </div>

      <p>{{ event.description }}</p>

      <div class="review">
        <div class="good" @click="putGood"><i class="fas fa-thumbs-up"></i>{{ event.good }}</div>
        <div class="bad" @click="putBad"><i class="fas fa-thumbs-down"></i>{{ event.bad }}</div>
      </div>

      <div class="place">
        <div class="zipcode">〒{{ event.zipcode }}</div>
        <div class="address">{{ event.address }}</div>
        <div class="tel">{{ event.tel }}</div>
        <a :href="event.webpage">{{ event.webpage }}</a>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Header from '@/components/Header'

export default{
  name: 'event',
  components: {
    Header
  },
  data () {
    return {
      event: null
    }
  },
  methods: {
    update () {
      axios.get('https://fireworks.g4rds.mixh.jp/api/event/' + this.$route.params.id)
        .then(res => {
          this.event = res.data
        })
        .catch(e => {
          console.log(e)
        })
    },
    putGood () {
      axios.put('https://fireworks.g4rds.mixh.jp/api/event/review/' + this.$route.params.id, { review: 'good' })
        .then(res => {
          this.update()
        })
        .catch(e => {
          console.log(e)
        })
    },
    putBad () {
      axios.put('https://fireworks.g4rds.mixh.jp/api/event/review/' + this.$route.params.id, { review: 'bad' })
        .then(res => {
          this.update()
        })
        .catch(e => {
          console.log(e)
        })
    }
  },
  created () {
    this.update()
  }
}
</script>

<style scoped>
.container {
  width: 100%;
  max-width: 800px;
  padding: 0 20px;
  margin: 110px auto 0 auto;
}

h1 {
  padding: 0 0.3em;
  border-bottom: 1px solid #00439f;

  font-size: 32px;
  color: #00439f;
}
.pref-date {
  display: flex;
  align-items: center;

  margin-top: 0.2em;
  margin-bottom: 1em;
}
.prefecture {
  flex: 0 0 auto;
  display: inline-block;

  height: 14px;
  padding: 6px 14px;
  margin: 0.5em 14px 0.5em 9.6px;
  border-radius: 13px;

  font-size: 14px;
  line-height: 14px;
  color: #05449c;
  background: #c1d7f6;
}
.date {
  flex: 1 1 auto;

  font-weight: bold;
  font-size: 20px;
  color: #05449c;
  text-align: right;
}
.time {
  flex: 0 0 auto;
  margin-left: 1em;

  font-weight: bold;
  font-size: 20px;
  color: #05449c;
  text-align: right;
}
p {
  margin-left: 0.5em;

  font-size: 16px;
  color: #444;
}
.review {
  display: flex;
  margin-top: 1em;
  margin-left: 1em;
}
.review div {
  box-sizing: border-box;

  height: 50px;
  padding: 16px 24px;
  margin-right: 14px;
  border-radius: 25px;
  box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.5);

  font-size: 18px;
  line-height: 14px;
  cursor: pointer;
  color: #fff;
  transition: .3s;
}
.review div:last-child {
  margin-right: 0;
}
.review div:active {
  box-shadow: 0 4px 16px 0 rgba(0, 0, 0, 0.5);
}
.review i {
  margin-right: 0.5em;
}
.review .good {
  background: linear-gradient(90deg, #2b6aff, #1b52d6);
}
.review .bad {
  background: linear-gradient(90deg, #ff532b, #e82c00);
}

.place {
  margin: 1em 0 0 0.5em;
}
.zipcode {
  font-size: 14px;
  color: #666;
}
.address {
  font-size: 16px;
  color: #666;
}
.tel {
  font-size: 16px;
  color: #666;
}
.place a {
  font-size: 16px;
  color: #05449c;
}
</style>
