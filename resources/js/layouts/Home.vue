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
    <img src="/storage/images/background.jpg" />
    <operation-card
      :title="operationObject.title"
      :fields="fields"
      :state="operationObject.state"
      @data="onOperationButtonClicked"
    />
    <add-new-agency :state="addAngecy.state" @clicked="addNewAgancy" />
    <add-new-place :state="addPlace.state" @clicked="addNewPlace" />
    <create-tour :state="createTour.state" @clicked="addNewTour" />
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
    <notification :notification="notify" />
  </div>
</template>
<script>
import HomeCard from "../components/HomeCard.vue";
import OperationCard from "../components/OperationCard.vue";
import AddNewAgency from "../components/operations/AddNewAgency.vue";
import Notification from "../components/Notification.vue";
import AddNewPlace from "../components/operations/AddNewPlace.vue";
import CreateTour from "../components/operations/CreateTour.vue";
export default {
  mounted() {
    const token = localStorage.getItem("tour-agancy-token");
    if (token === undefined || token === null)
      this.$router.push({ name: "login" });
  },
  components: {
    HomeCard,
    OperationCard,
    Notification,
    AddNewAgency,
    AddNewPlace,
    CreateTour,
  },
  data() {
    return {
      notify: {
        msg: "",
        code: -1,
      },
      fields: [
        {
          title: "Agancy Name",
          type: "text",
        },
        {
          title: "Location",
          type: "text",
        },
        {
          title: "City Id",
          type: "number",
        },
      ],
      initState: "",
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
        "Show All Request",
        "Get My Agency Tours",
      ],
      desc: [
        "create new tour agancy if you are not have one already",
        "add new place to the database with coordinates of the new location",
        "create new tour and determine the toue details",
        "show all user request to add on tour",
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
      addAngecy: {
        state: true,
      },
      addPlace: {
        state: true,
      },
      createTour: {
        state: true,
      },
    };
  },
  methods: {
    getOpObject(path, oldState) {
      if (path === 1) {
        this.fields = [
          {
            title: "Agancy Name",
            type: "text",
          },
          {
            title: "Location",
            type: "text",
          },
          {
            title: "City Id",
            type: "number",
          },
        ];
        return {
          path: path,
          title: "Add New Agency",
          field1_title: "Agancy Name",
          field2_title: "Location",
          field3_title: "City",
          state: oldState,
        };
      }
      if (path === 2) {
        this.fields = [
          {
            title: "Name",
            type: "text",
          },
          {
            title: "Location",
            type: "text",
          },
          {
            title: "Location's Coordinate",
            type: "text",
          },
        ];
        return {
          path: path,
          title: "Add New Place",
          field1_title: "Name",
          field2_title: "Location",
          field3_title: "Location's Coordinate",
          state: oldState,
        };
      }
      if (path === 3) {
        this.fields = [
          {
            title: "Cost",
            type: "number",
          },
          {
            title: "Seat Count",
            type: "number",
          },
          {
            title: "City Id",
            type: "number",
          },
          {
            title: "start At",
            type: "date",
          },
          {
            title: "End At",
            type: "date",
          },
        ];
        return {
          path: path,
          title: "Add New Place",
          field1_title: "Name",
          field2_title: "Location",
          field3_title: "Lat",
          state: oldState,
        };
      }
      if (path === 4) {
        this.fields = [
          {
            title: "Start At",
            type: "text",
          },
          {
            title: "End At",
            type: "text",
          },
        ];
        return {
          path: path,
          title: "Add New Time Line",
          field1_title: "Start At",
          field2_title: "End At",
          state: oldState,
        };
      }
      return {};
    },
    addNewAgancy(data) {
      console.log(data);

      axios
        .post("/api/add_agancy", data)
        .then((response) => {
          console.log(response);
          this.notify = {
            code: response.data.code,
            msg: response.data.message,
          };
        })
        .catch((err) => {
          console.log(err);
          this.notify = {
            code: 400,
            msg: "Error On Add new Agancy",
          };
        });
    },
    addNewPlace(data) {
      //36.19556314029162, 37.13155181168135
      //36.20280070250926, 37.15626196220924

      // let cords = data.field3.split(",");

      let sendObject = {
        name: data.name,
        address: data.location,
        lat: data.latitude,
        lng: data.longitude,
      };

      axios
        .post("/api/add_place", sendObject)
        .then((response) => {
          console.log(response);
          this.notify = {
            code: response.data.code,
            msg: response.data.message,
          };
        })
        .catch((err) => {
          console.log(err);
          this.notify = {
            code: err.status,
            msg: "Error On Add New Place.",
          };
        });
    },
    addNewTour(data) {
      axios
        .post("/api/create_tour", data)
        .then((response) => {
          this.notify = {
            code: response.data.code,
            msg: response.data.message,
          };
        })
        .catch((err) => {
          this.notify = {
            code: err.status,
            msg: "Error",
          };
        });
    },
    onOperationButtonClicked(data) {
      console.log(this.initState);
      // if (this.initState == 1) this.addNewAgancy(data);
      if (this.initState == 2) this.addNewPlace(data);
      else if (this.initState == 3) this.addNewTour(data);
    },
    clicked(path) {
      console.log(path);
      if (path == 5) this.$router.push({ name: "tours" });
      if (path == 1) {
        this.addPlace.state = "show";
        this.createTour.state = "show";

        if (this.addAngecy.state === "hidden") {
          this.addAngecy.state = "show";
        } else this.addAngecy.state = "hidden";
        return;
      } else if (path == 2) {
        this.addAngecy.state = "show";
        this.createTour.state = "show";

        if (this.addPlace.state === "hidden") {
          this.addPlace.state = "show";
        } else this.addPlace.state = "hidden";
        return;
      } else if (path == 3) {
        this.addPlace.state = "show";
        this.addAngecy.state = "show";

        if (this.createTour.state === "hidden") {
          this.createTour.state = "show";
        } else this.createTour.state = "hidden";
        return;
      } else if (path == 4) {
        this.$router.push({ name: "requests" });
      }
      if (this.initState === "") {
        this.initState = path;
        this.operationObject = this.getOpObject(path);
        this.operationObject.state = "hidden";
      } else if (
        this.initState === path &&
        this.operationObject.state === "hidden"
      ) {
        this.operationObject.state = "visible";
      } else if (
        this.initState === path &&
        this.operationObject.state === "visible"
      ) {
        this.operationObject.state = "hidden";
      } else if (this.initState !== path) {
        this.operationObject = this.getOpObject(path);
        this.operationObject.state = "hidden";
        this.initState = path;
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