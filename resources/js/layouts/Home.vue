<template>
  <div class="home-container">
    <div class="logout-div">
      <font-awesome-icon
        icon="fa-solid fa-power-off"
        class="powerOff"
        @click.prevent="logout"
      />
      <p>Log out</p>
    </div>
    <img src="/images/background.jpeg" />
    <operation-card
      :title="operationObject.title"
      :field1_title="operationObject.field1_title"
      :field2_title="operationObject.field2_title"
      :field3_title="operationObject.field3_title"
      :state="operationObject.state"
    />
    <div class="container">
      <home-card
        v-for="(i, index) in 5"
        :key="index"
        :title="titles[index]"
        :desc="desc[index]"
        :path="i"
        :color="colors[index]"
        :shadow="shadow_colors[index]"
        @clicked="clicked"
      />
    </div>
  </div>
</template>
<script>
import HomeCard from "../components/HomeCard.vue";
import OperationCard from "../components/OperationCard.vue";
export default {
  mounted() {
    const token = localStorage.getItem("tour-agancy-token");
    if (token === undefined || token === null)
      this.$router.push({ name: "login" });
  },
  components: { HomeCard, OperationCard },
  data() {
    return {
      colors: [
        "rgba(249, 5, 123, 1)",
        "rgba(211, 8, 31, 1)",
        "rgba(0, 251, 31, 1)",
        "rgba(0, 75, 219, 1)",
        "rgba(255, 184, 6, 1)",
      ],
      shadow_colors: [
        "rgba(249, 5, 123, 0.53)",
        "rgba(211, 8, 31, 0.53)",
        "rgba(0, 251, 31, 0.53)",
        "rgba(0, 75, 219, 0.53)",
        "rgba(255, 184, 6, 0.53)",
      ],
      titles: [
        "Add New Tour Agency",
        "Add New Place",
        "Create Tour",
        "Get Tour Schedule",
        "Get My Agency Tours",
      ],
      desc: [
        "create new tour agancy if you are not have one already",
        "add new place to the database with coordinates of the new location",
        "create new tour and determine the toue details",
        "choose the Tour and show the schedule that had been determined before",
        "if you are already created tours , you can get them here and show details about them",
      ],
      operationObject: {
        path: -1,
        title: "Add New Agency",
        field1_title: "Agancy Name",
        field2_title: "Location",
        field3_title: "City",
        state: true,
      },
    };
  },
  methods: {
    getOtherState(state) {
      return this.operationObject.state === "hidden" ? "visible" : "hidden";
    },
    clicked(path) {
      if (this.operationObject.state === "hidden")
        this.operationObject.state = "visible";
      else this.operationObject.state = "hidden";
      switch (path) {
        case 1:
          {
            this.operationObject = {
              path: path,
              title: "Add New Agency",
              field1_title: "Agancy Name",
              field2_title: "Location",
              field3_title: "City",
              state:
                path === this.operationObject.path || path === -1
                  ? getOtherState(this.operationObject.state)
                  : getOtherState(this.operationObject.state),
            };
          }
          break;
        case 2:
          {
            this.operationObject = {
              title: "Add New Place",
              field1_title: "Name",
              field2_title: "Location",
              field3_title: "Lat",
              state:
                path === this.operationObject.path || path === -1
                  ? getOtherState(this.operationObject.state)
                  : getOtherState(this.operationObject.state),
              path: path,
            };
          }
          break;

        default:
          break;
      }
    },
    logout() {
      localStorage.removeItem("tour-agancy-token");
      location.reload();
    },
  },
};
</script>
<style scoped>
img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  z-index: -1;
}
.container {
  display: flex;
  justify-content: center;
  width: 750px;
  flex-wrap: wrap;
}
.powerOff {
  z-index: 0;
  position: absolute;
  top: 2rem;
  left: 3rem;
  width: 4rem;
  height: 4rem;
  color: white;
  cursor: pointer;
}
.logout-div p {
  opacity: 0;
  position: absolute;
  top: 6.2rem;
  left: 3rem;
  font-size: 1.2rem;
  color: white;
  display: inline;
  transition: 0.5s;
  transform: translateY(50px);
}
.logout-div:hover p {
  transform: translateY(0);
  opacity: 1;
}
</style>