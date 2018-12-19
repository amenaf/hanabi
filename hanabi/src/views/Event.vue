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

      <h2>会場と周辺の駐車場</h2>
      <div class="place">
        <div id="map"></div>
        <div class="data">
          <div class="zipcode">〒{{ event.zipcode }}</div>
          <div class="address">{{ event.address }}</div>
          <div class="tel">{{ event.tel }}</div>
          <a target="_blank" :href="event.webpage">{{ event.webpage }}</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
import Header from '@/components/Header'

import GoogleMapsApiLoader from 'google-maps-api-loader'

export default{
  name: 'event',
  components: {
    Header
  },
  data () {
    return {
      event: null,
      googleMap: null
    }
  },
  methods: {
    update () {
      axios.get('https://fireworks.g4rds.mixh.jp/api/event/' + this.$route.params.id)
        .then(res => {
          this.event = res.data

          GoogleMapsApiLoader({
            libraries: ['places'],
            apiKey: 'AIzaSyA0nSf3mQWMU6M1CV8IlG28-0F1spcfh0Y'
          })
            .then(google => {
              /* マップを描画 */
              this.googleMap = new google.maps.Map(document.getElementById('map'), {
                center: { lat: this.event.latitude, lng: this.event.longitude },
                zoom: 15
              })

              /* イベント会場の座標 */
              let eventLatLng = new google.maps.LatLng(this.event.latitude, this.event.longitude)

              /* イベント会場にマーカーを設置 */
              let infoWindow = new google.maps.InfoWindow({
                content: `<div class="info">
                <h3>${this.event.name} の会場</h3>
                </div>`
              })

              let marker = new google.maps.Marker({
                position: eventLatLng,
                map: this.googleMap,
                title: this.event.name + ' の会場'
              })
              marker.addListener('click', function () {
                infoWindow.open(this.googleMap, marker)
              })
              this.markers = [marker]

              /* 周辺の駐車場を取得 */
              let service = new google.maps.places.PlacesService(this.googleMap)
              let request = {
                location: eventLatLng,
                radius: '1000',
                type: ['parking']
              }
              service.nearbySearch(request, (results, status) => {
                if (status === google.maps.places.PlacesServiceStatus.OK) {
                  let markers = []

                  /* 駐車場を近い順に並べる */
                  results.sort((a, b) => {
                    let distA = Math.sqrt(Math.pow((this.event.latitude - a.geometry.location.lat()) * 2, 2) + Math.pow((this.event.longitude - a.geometry.location.lng()), 2))
                    let distB = Math.sqrt(Math.pow((this.event.latitude - b.geometry.location.lat()) * 2, 2) + Math.pow((this.event.longitude - b.geometry.location.lng()), 2))

                    return distA - distB
                  })

                  for (let i = 0; i < results.length; i++) {
                    let place = results[i]

                    /* 周辺の駐車場にマーカーを設置 */
                    let parkingOrder = i === 0
                      ? '最も近い'
                      : (i + 1) + '番目に近い'

                    let infoWindow = new google.maps.InfoWindow({
                      content: `<div class="info">
                        <h3>${place.name}</h3>
                        <strong>会場周辺で${parkingOrder}駐車場</strong>
                        <p>${place.vicinity}</p>
                      </div>`
                    })

                    let marker = new google.maps.Marker({
                      position: place.geometry.location,
                      icon: {
                        fillColor: '#1976D2',
                        fillOpacity: 1,
                        path: google.maps.SymbolPath.CIRCLE,
                        strokeWeight: 0,
                        scale: 12
                      },
                      label: {
                        text: String.fromCharCode(65 + i), // 'A' + i
                        color: '#FFFFFF',
                        fontSize: '18px'
                      },
                      map: this.googleMap,
                      title: place.name
                    })
                    marker.addListener('click', function () {
                      infoWindow.open(this.googleMap, marker)
                    })
                    markers.push(marker)
                  }

                  this.markers = this.markers.concat(markers)
                }
              })
            }, err => {
              console.error(err)
            })
        })
        .catch(err => {
          console.log(err)
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

h2 {
  margin: 3rem 0.5rem 0.5rem 0.5rem;
  padding-left: 0.5em;
  border-left: 5px solid #00439f;

  font-size: 1.6rem;
  font-weight: bold;
  color: #444;
}
.place {
  display: flex;
  align-items: stretch;

  margin: 1em 0 0 0.5em;
}
#map {
  flex: 1 1 300px;

  min-height: 300px;
}
.place .data {
  flex: 0 1 auto;

  margin-left: 2rem;
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
