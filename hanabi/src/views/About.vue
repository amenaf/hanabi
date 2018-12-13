<template>
  <div class="about">
    <Header></Header>
    <h1>毎月の花火イベントの詳細をまとめています</h1>
    <h2>地域ごとの検索もできるようにする予定です</h2>
  </div>
</template>

<script>
import Header from '@/components/Header'
export default {
  name: 'about',
  components: {
    Header
  }
}
</script>
<style>
.about {
  margin-top: 100px;
}
</style>
