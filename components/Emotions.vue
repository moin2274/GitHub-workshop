<template>
  <div>
    <center>
      <h1 class="header">GitHub Workshop</h1>
    </center>
    <div class="content-grid">
      <div
        v-for="emotion of emotions"
        :key="emotion.username"
        class="card"
        :style="{
          background: colors[emotion.colorIndex].colors[0],
          background: `-webkit-linear-gradient(to right, ${colors[
            emotion.colorIndex
          ].colors.join(',')})`,
          background: `linear-gradient(to right, ${colors[
            emotion.colorIndex
          ].colors.join(',')})`,
        }"
      >
        <p class="text">{{ emotion.thought }}</p>
        <p>by {{ emotion.username }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      emotions: [],
      colors: [],
    };
  },
  async fetch() {
    this.colors = await fetch(
      "https://raw.githubusercontent.com/ghosh/uiGradients/master/gradients.json"
    ).then((res) => res.json());

    console.log(this.colors);

    this.emotions = await this.$content("emotions")
      .only(["anonymous", "username", "thought"])
      .fetch();

    this.emotions.forEach((element) => {
      element.colorIndex = Math.floor(Math.random() * (this.colors.length + 1));
    });
  },
};
</script>

<style lang="css" >
body {
  background: #2c3e50;
}

.header {
  color: white;
  font-family: "Franklin Gothic Medium", "Arial Narrow", Arial, sans-serif;
}

.content-grid {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-evenly;
  grid-row-gap: 2rem;
}

.card {
  font-size: 1.1rem;
  font-family: monospace;
  border-radius: 5px;
  padding: 2rem;
  max-width: 25vw;
  color: #fff;
}
</style>