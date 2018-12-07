<template>
  <header>
    <div class="wrapper">
      <div id="logo">
        <h1>花火大会</h1>
      </div>
      <div class="spacer"></div>
      <nav>
        <a>
          <span><span>花火大会</span></span>
        </a>
        <a>
          <span><span>人気ランキング</span></span>
        </a>
        <a>
          <span><span>このサイトについて</span></span>
        </a>
        <a>
          <span><span>お問い合わせ</span></span>
        </a>
      </nav>
    </div>
  </header>
</template>

<style scoped>
header {
  width: 100%;
  height: 100px;
  box-shadow: 0 1px 2px 0 rgba(60, 64, 67, 0.3), 0 2px 6px 2px rgba(60, 64, 67, 0.15);
}
header .wrapper {
  display: flex;
  width: 100%;
  max-width: 1000px;
  height: 100px;
  padding: 0 20px;
  margin: 0 auto;
}
#logo {
  flex: 0 0 auto;
  display: flex;
  justify-content: center;
  align-items: center;
}
#logo h1 {
  font-weight: bold;
  font-size: 3rem;
  line-height: 1em;
  color: #00439f;
}
.spacer {
  flex: 1 1 0;
}
nav {
  flex: 0 1 0;
  display: grid;
  grid-template-columns: 1fr 1fr;
  grid-template-rows: auto auto;

  border-right: 1px solid #ccc;
}
nav a {
  display: flex;
  justify-content: center;
  align-items: center;

  width: 12em;
  border-left: 1px solid #ccc;
  border-bottom: 1px solid #ccc;

  cursor: pointer;
}
nav a:last-child, nav a:nth-child(3) {
  border-bottom: none;
}
nav a > span {
  display: flex;
  justify-content: center;
  align-items: center;

  width: 100%;
  height: 100%;
  padding: 0 0.2rem;
  border-bottom: 3px solid transparent;

  transition: .3s;
}
nav a > span span {
  font-size: 1.2rem;
  line-height: 1.5em;
  color: #888;
}
nav a:hover > span {
  border-bottom: 3px solid #00439f;
}
nav a:hover > span span {
  color: #333;
}
</style>
