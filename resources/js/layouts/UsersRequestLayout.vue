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
      <div class="requests-container" v-if="requests.length > 0">
        <user-request-item
          v-for="(request, index) in requests"
          :key="index"
          :request="request"
          @onRequestClicked="onRequestClicked"
        />
      </div>
    </div>
    <b-modal id="request-modal" hide-footer>
      <template #modal-title>Response To Request</template>
      <div class="d-block text-center">
        <h3>Do you want to resopnsed to this request ?</h3>
      </div>
      <b-row style="justify-content: space-evenly">
        <b-button
          style="max-width: fit-content"
          class="m-3 px-4 py-2"
          @click="responsedToRequest"
          >Yes</b-button
        ><b-button
          style="max-width: fit-content"
          class="m-3 px-4 py-2"
          @click="responsedToRequestWithNo"
          >No</b-button
        >
      </b-row>
    </b-modal>
  </div>
</template>
<script>
import UserRequestItem from "../components/UserRequestItem.vue";
import AlertDialog from "../components/AlertDialog.vue";
export default {
  components: {
    UserRequestItem,
    AlertDialog,
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
      selectedRequest: {},
      alertDilog: {
        state: "hidden",
      },
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
      if (request.approved === "waiting") {
        this.$bvModal.show("request-modal");
        this.selectedRequest = request;
      }
    },
    responsedToRequest() {
      this.$bvModal.hide("request-modal");
      axios
        .post("/api/approve_request", {
          id: this.selectedRequest.id,
          approved: "yes",
        })
        .then((response) => {
          this.requests.forEach((r) => {
            if (r.id === this.selectedRequest.id) {
              r.approved = response.data.response;
            }
          });
          console.log(response);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    responsedToRequestWithNo() {
      this.$bvModal.hide("request-modal");
      axios
        .post("/api/approve_request", {
          id: this.selectedRequest.id,
          approved: "no",
        })
        .then((response) => {
          this.requests.forEach((r) => {
            if (r.id === this.selectedRequest.id) {
              r.approved = response.data.response;
            }
          });
          console.log(response);
        })
        .catch((err) => {
          console.log(err);
        });
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
  overflow-y: auto;
  height: 75vh;
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