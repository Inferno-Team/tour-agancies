<template>
  <div
    class="notification"
    id="notification"
    :class="{
      success:
        this.notficationData.code >= 200 && this.notficationData.code <= 299,
      error: this.notficationData.code > 299,
    }"
  >
    <div>
      <h3>{{ this.notficationData.msg }}</h3>
      <h2>{{ this.notficationData.code }}</h2>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      notficationData: {
        msg: "",
        code: -1,
      },
    };
  },
  watch: {
    notification: {
      handler(n, o) {
        this.notficationData = n;
        this.showNotification();
      },
    },
  },
  props: ["notification"],
  methods: {
    showNotification() {
      document
        .getElementById("notification")
        .classList.toggle("notification-destory");
      setTimeout(() => {
        document
          .getElementById("notification")
          .classList.toggle("notification-destory");
      }, 2500);
    },
  },
};
</script>
<style scoped>
.notification {
  width: 25%;
  border-radius: 0.8rem;
  position: absolute;
  bottom: 1rem;
  left: -30rem;
  padding: 4px;
  transition: 1s;
}
.notification h3,
.notification h2 {
  font-size: 1.2rem;
}
.success {
  border: 1px solid #0f0;
  background: rgb(123, 255, 123);
  left: 1rem;
}
.error {
  border: 1px solid #f00;
  background: rgb(255, 123, 123);
  left: 1rem;
}
.notification-destory {
  left: -30rem;
}
</style>