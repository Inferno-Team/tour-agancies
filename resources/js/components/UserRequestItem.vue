<template>
  <div style="cursor: pointer" @click.prevent="onRequestClicked">
    <b-card
      no-body
      class="overflow-hidden p-3 m-3 rounded-lg"
      style="direction: ltr"
    >
      <div :style="background" class="left-banner"></div>
      <b-col class="item">
        <b-row>
          <b-col>
            <b-card-text>
              User Name : {{ request.user.name }} {{ request.user.last_name }}
            </b-card-text>
          </b-col>
          <b-col>
            <b-card-text>
              User Email : {{ request.user.email }}
            </b-card-text></b-col
          >
        </b-row>
        <b-row>
          <b-col>
            <b-card-text>
              Payment Mathod : {{ request.payment_method }}
            </b-card-text>
          </b-col>
          <b-col>
            <b-card-text>
              Payment Code : {{ request.payment_code }}
            </b-card-text>
          </b-col>
        </b-row>
      </b-col>
    </b-card>
  </div>
</template>
<script>
export default {
  props: ["request"],
  computed: {
    background() {
      if (this.$props.request.approved === "yes") {
        return {
          background: "green",
        };
      } else if (this.$props.request.approved === "no") {
        return {
          background: "red",
        };
      } else {
        return {
          background: "yellow",
        };
      }
    },
  },
  methods: {
    onRequestClicked(e) {
      this.$emit("onRequestClicked", this.$props.request);
    },
  },
};
</script>
<style scoped>
.left-banner {
  position: absolute;
  left: 0;
  top: 0;
  width: 8px;
  height: 100%;
}
.item {
  margin-left: 10px;
}
</style>