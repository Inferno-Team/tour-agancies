<template>
  <div>
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
      <div class="agency_name m-3 p-3">Agency Name : {{ agency.name }}</div>
      <div class="requests-container">
        <user-request-item
          v-for="(request, index) in requests"
          :key="index"
          :request="request"
          @onRequestClicked="onRequestClicked"
        />
      </div>
    </div>
  </div>
</template>
<script>
import UserRequestItem from "../components/UserRequestItem.vue";
export default {
  components: {
    UserRequestItem,
  },
  mounted() {
    const token = localStorage.getItem("tour-agancy-token");
    if (token === undefined || token === null)
      this.$router.push({ name: "login" });
    this.loadAllRequests();
    this.loadMyAgency();
  },
  data() {
    return {
      requests: [],
      agency: {},
    };
  },
  methods: {
    logout() {
      localStorage.removeItem("tour-agancy-token");
      location.reload();
    },
    loadAllRequests() {
      axios
        .get("/api/get_all_requests")
        .then((response) => {
          console.log(response.data);
          this.requests = response.data.data;
        })
        .catch((e) => console.log(e));
    },
    loadMyAgency() {
      axios
        .get("/api/get_my_agancy")
        .then((response) => {
          console.log(response.data);
          this.agency = response.data.data;
        })
        .catch((e) => console.log(e));
    },
    onRequestClicked(request) {
      // show dialog with yes and no question
    },
  },
};
</script>
<style scoped>
.agency_name {
  z-index: 3;
  color: white;
  font-size: 1.4rem;
  text-align: center;
}
.requests-container {
  background: #cecaca54;
  border-radius: 0.75rem;
  height: 100%;
}
.container {
  display: flex;
  justify-content: center;
  width: 750px;
  flex-wrap: wrap;
  flex-direction: column;
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