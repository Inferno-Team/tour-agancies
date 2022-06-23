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
    <img src="/storage/images/background.jpeg" />
    <div class="container">
      <div class="container-home-card">
        <home-card
          v-for="(tour, index) in pageOfItems"
          :key="index"
          :title="tour.city.name"
          :desc="tour.desc"
          :path="index"
          :color="colors[index]"
          :shadow="shadow_colors[index]"
          @clicked="clicked"
        />
      </div>

      <div class="card-footer pb-0 pt-3 ma-3">
        <jw-pagination
          :items="tours"
          :pageSize="5"
          :maxPages="5"
          @changePage="onChangePage"
        ></jw-pagination>
      </div>
    </div>
    <notification :notification="notify" />
  </div>
</template>
<script>
import HomeCard from "../components/HomeCard.vue";
import Notification from "../components/Notification.vue";
import JwPagination from "jw-vue-pagination";
export default {
  components: { HomeCard, Notification, JwPagination },
  mounted() {
    const token = localStorage.getItem("tour-agancy-token");
    if (token === undefined || token === null)
      this.$router.push({ name: "login" });
    this.getTours();
  },
  methods: {
    logout() {
      localStorage.removeItem("tour-agancy-token");
      location.reload();
    },
    getTours() {
      axios
        .get("/api/get_agancy_tours_by_manager")
        .then((response) => {
          this.tours = response.data.data;
          for (let index = 0; index < this.tours.length; index++) {
            const tour = this.tours[index];
            const timeNow = Date.now();
            const diff = timeNow - Date.parse(tour.end_at);
            let desc = `Seat Count : ${tour.seat_count}\nCost : ${
              tour.cost
            } S.P\nAvailable : ${diff < 0 ? "Yes" : "No"}`;
            this.tours[index].desc = desc;
            this.tours[index].isAvailable = diff < 0;
          }
        })
        .catch((err) => console.log(err));
    },
    generateColorAndShadow() {
      let r = (Math.random() * 255).toFixed(0);
      let g = (Math.random() * 255).toFixed(0);
      let b = (Math.random() * 255).toFixed(0);
      this.colors.push(`rgba(${r},${g},${b},1)`);
      this.shadow_colors.push(`rgba(${r},${g},${b},0.53)`);
    },
    onChangePage(val) {
      this.pageOfItems = val;
      this.colors = [];
      this.shadow_colors = [];
      for (let index = 0; index < val.length; index++)
        this.generateColorAndShadow();
    },
    clicked(index) {
      if (this.pageOfItems[index].isAvailable)
        this.$router.push({
          name: "tour-time-line",
          params: { id: this.tours[index].id },
        });
      else
        this.notify = {
          msg: "This Tour is not available",
          code: 401,
        };
    },
  },
  data() {
    return {
      notify: {
        msg: "",
        code: -1,
      },
      tours: [],
      pageOfItems: [],
      shadow_colors: [],
      colors: [],
    };
  },
};
</script>
<style scoped>
.home-container {
  height: 99%;
  overflow-y: auto;
}
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
  flex-direction: column;
  flex-wrap: wrap;
  align-items: center;
}
.container-home-card {
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