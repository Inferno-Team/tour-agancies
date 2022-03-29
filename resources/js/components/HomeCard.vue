<template>
  <div class="card" :style="cssProps">
    <h3>{{ title }}</h3>
    <span></span>
    <span></span>
    <span></span>
    <span></span>
    <div class="content">
      <p>{{ desc }}</p>
      <a @click.prevent="move">Go</a>
    </div>
  </div>
</template>
<script>
export default {
  props: ["title", "desc", "path", "color", "shadow"],
  mounted() {
    this._color = this.$props.color;
  },
  methods: {
    move() {
      this.$emit("clicked", this.$props.path);
    },
  },
  computed: {
    cssProps() {
      return {
        "--background-span-top": `linear-gradient(to top, transparent, ${this.$props.color})`,
        "--background-span-left": `linear-gradient(to left, transparent, ${this.$props.color})`,
        "--background-span-right": `linear-gradient(to right, transparent, ${this.$props.color})`,
        "--background-span-bottom": `linear-gradient(to bottom, transparent, ${this.$props.color})`,
        "--card-background-shadow": `${this.$props.shadow}`,
      };
    },
  },
};
</script>
<style scoped>
.card {
  position: relative;
  width: 175px;
  height: 240px;
  margin: 20px;
  box-shadow: 20px 20px 50px var(--card-background-shadow);
  border-radius: 15px;
  background: rgba(255, 255, 255, 0.1);
  overflow: hidden;
  display: flex;
  justify-content: flex-start;
  align-items: center;
  border-top: 1px solid rgba(255, 255, 255, 0.5);
  border-left: 1px solid rgba(255, 255, 255, 0.5);
  backdrop-filter: blur(5px);
  margin-left: -1%;
}

.card .content {
  padding: 20px;
  text-align: center;
  transform: translateY(100px);
  opacity: 0;
  transition: 0.5s;
}

.card:hover .content {
  transform: translateY(0);
  opacity: 1;
}

.card h3 {
  font-size: 1.2em;
  color: rgb(255, 255, 255);
  /* margin-bottom: 20px; */
  margin-top: 20px;
  text-align: center;
}

.card .content p {
  font-size: 0.8em;
  color: rgba(18, 185, 197, 0.863);
  font-weight: 300;
}

.card .content a {
  position: relative;
  display: inline-block;
  padding: 4px 10px;
  font-family: "Poppins";
  margin-top: 7px;
  background: #fff;
  text-decoration: none;
  font-weight: 300;
  border-radius: 20px;
  color: #000;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  cursor: pointer;
}

.card {
  opacity: 0.5;
}

.card:hover {
  opacity: 1;
}

.card span {
  transition: 0.5s;
  opacity: 0;
}

.card:hover span {
  opacity: 1;
}

.card span:nth-child(2) {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background: var(--background-span-right);
  animation: animate1 2s linear infinite;
}

@keyframes animate1 {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(100%);
  }
}

.card span:nth-child(3) {
  position: absolute;
  top: 0;
  right: 0;
  width: 3px;
  height: 100%;
  background: var(--background-span-bottom);
  animation: animate2 2s linear infinite;
  animation-delay: 1s;
}

@keyframes animate2 {
  0% {
    transform: translateY(-100%);
  }
  100% {
    transform: translateY(100%);
  }
}

.card span:nth-child(4) {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 3px;
  background: var(--background-span-left);
  animation: animate3 2s linear infinite;
  animation-delay: 2s;
}

@keyframes animate3 {
  0% {
    transform: translateX(100%);
  }
  100% {
    transform: translateX(-100%);
  }
}

.card span:nth-child(5) {
  position: absolute;
  top: 0;
  left: 0;
  width: 3px;
  height: 100%;
  background: var(--background-span-top);
  animation: animate4 2s linear infinite;
  animation-delay: 1s;
}

@keyframes animate4 {
  0% {
    transform: translateY(100%);
  }
  100% {
    transform: translateY(-100%);
  }
}
</style>