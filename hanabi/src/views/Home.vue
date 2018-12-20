<template>
  <div class="home">
    <Header></Header>
    <div id="news">
      <h1>お知らせ</h1>
      <ul>
        <li>イベントを追加しました</li>
        <li>イベントを追加しました</li>
        <li>イベントを追加しました</li>
      </ul>
    </div>
    <div id="hanabi">
      <h1>全国の花火大会</h1>
      <ul>
        <li><a href="#">北海道</a></li>
        <li><a href="#">東北</a></li>
        <li><a href="#">関東</a></li>
        <li><a href="#">中部</a></li>
        <li><a href="#">近畿</a></li>
        <li><a href="#">中国</a></li>
        <li><a href="#">四国</a></li>
        <li><a href="#">九州</a></li>
      </ul>
    </div>
    <div id="rank">
      <h1>人気ランキング</h1>
      <ul>
        <li>A大会 日付 場所</li>
        <li>B大会 日付 場所</li>
        <li>C大会 日付 場所</li>
      </ul>
    </div>
  </div>
</template>

<script>
import Header from '@/components/Header'
export default {
  name: 'home',
  components: {
    Header
  }
}
</script>

<style>
#news{
    line-height: 1.5;
    margin: 100px auto 0px auto;
    width: 90%;
}

#news h1{
    border: 2px solid;
    border-bottom-style: none;
    margin-bottom: 0px;
    background-color: #8CABFF;
}

#news ul{
    border: 2px solid;
    border-top-style: dashed;
    list-style: none;
    line-height: 2.2;
    margin-top: 0px;
    margin-bottom: 0px;
    background-color: #FFFFFF;
}

#news li{
    border-bottom: 1px dashed;
}

#news li:last-child{
  border-bottom-style: none;
}

#hanabi{
    margin: auto;
    width: 90%;
}

#hanabi h1{
    border: 2px solid;
    border-bottom-style: dashed;
    line-height: 1.5;
    margin-top: 50px;
    margin-bottom: 0px;
    background-color: #8CABFF;
}

#hanabi ul{
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    grid-template-rows: 40px 40px;
    list-style: none;
    margin-top: 0px;
    margin-bottom: 0px;
    padding-left: 0;
    border-left: 1px solid #ccc;
    background-color: #FFFFFF;
}

#hanabi li a{
    font-size: 16px;
    font-weight: bold;
    text-align: center;
    height: 40px;
    width: 100%;
    display: inline-block;
    border: 1px solid #ccc;
    border-top-style: none;
    border-left-style: none;
    line-height: 40px;
}

#rank{
    line-height: 1.5;
    margin: 0px auto 0px auto;
    width: 90%;
}

#rank h1{
    border: 2px solid;
    border-bottom-style: none;
    margin-bottom: 0px;
    margin-top: 50px;
    background-color: #8CABFF;
}

#rank ul{
    border: 2px solid;
    border-top-style: dashed;
    line-height: 2.2;
    margin-top: 0px;
    background-color: #FFFFFF;
}

#rank li{
    border-bottom: 1px dashed;
    list-style: none;
}

#rank li:last-child{
  border-bottom-style: none;
}
</style>
