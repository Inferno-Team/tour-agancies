<template>
  <div
    class="animate__animated operation-card-add-timeline"
    id="operation-card-add-timeline"
  >
    <div class="box" id="login-form">
      <h2>Add New Timeline</h2>
      <form>
        <b-row style="align-items: center">
          <b-dropdown
            style="max-width: fit-content"
            id="dropdown-1"
            text="Choose a Day"
            class="m-md-2"
          >
            <b-dropdown-item
              @click="timeline.day = index"
              v-for="(day, index) in allDays"
              :key="index"
              v-if="day!=null"
              >{{ index }}</b-dropdown-item
            >
          </b-dropdown>
          <div
            style="
              max-width: fit-content;
              font-size: 23px;
              font-weight: 800;
              cursor: pointer;
            "
            @click.prevent="addNewDay"
          >
            +
          </div>
        </b-row>
        <b-row>
          <b-dropdown
            style="max-width: fit-content"
            id="dropdown-1"
            text="Time"
            class="m-md-2"
          >
            <b-dropdown-item
              @click="timeline.time = time"
              v-for="(time, index) in times"
              :key="index"
              >{{ time.start }} - {{ time.end }}</b-dropdown-item
            >
          </b-dropdown>
          <b-dropdown
            style="max-width: fit-content"
            id="dropdown-1"
            text="Place"
            class="m-md-2"
          >
            <b-dropdown-item
              @click="timeline.place = place"
              v-for="(place, index) in places"
              :key="index"
              
              >{{ place.name }}</b-dropdown-item
            >
          </b-dropdown>
        </b-row>
        <input
          type="button"
          value="Add New Timeline"
          @click.prevent="onClick"
        />
      </form>
    </div>
  </div>
</template>
<script>
export default {
  props: ["state", "days", "id"],
  mounted() {
    this.loadPlaces();
    this.loadTimes();
  },
 
  data() {
    return {
      timeline: {},
      places: [],
      times: [],
      allDays: [],
    };
  },
  watch: {
    state: function (nV, oL) {
      this.showAddTimeline(nV);
    },
    days: function (nV, oL) {
      this.allDays = [];
      this.allDays.push(null);
      var index = 1;
      for (const day in this.days) {
        if (index == day) this.allDays.push(this.days[day]);
        else {
          for (let i = index; i < day; i++) {
            this.allDays.push(null);
          }
          this.allDays.push(this.days[day]);
        }
        index++;
      }
    },
  },
  methods: {
    showAddTimeline(value) {
      var operation_card = document.getElementById(
        "operation-card-add-timeline"
      );
      const exit = "animate__flipOutX";
      const entry = "animate__flipInX";
      if (value == "hidden") {
        var arr = operation_card.className.split(" ");
        if (arr.indexOf(exit) != -1) operation_card.classList.remove(exit);
        operation_card.classList.add(entry);
        operation_card.style.visibility = "visible";
      } else {
        operation_card.classList.remove(entry);
        operation_card.classList.add(exit);
      }
    },
    onClick() {
      axios
        .post("/api/add_place2tour", {
          tour_id: this.id,
          place_id: this.timeline.place.id,
          time_id: this.timeline.time.id,
          day: this.timeline.day,
        })
        .then((response) => {
          if (response.data.code == 200) {
            this.$emit("onAdd", response.data.data);
          }
          console.log(response.data);
        })
        .catch((err) => {
          console.log(err);
        });
    },
    loadPlaces() {
      axios
        .get("/api/get_all_places")
        .then((response) => {
          this.places = response.data.places;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    loadTimes() {
      axios
        .get("/api/get_all_times")
        .then((response) => {
          this.times = response.data.times;
        })
        .catch((err) => {
          console.log(err);
        });
    },
    addNewDay() {
      this.allDays.push([]);
    },
  },
};
</script>

<style scoped>
.dropzone {
  height: 20px;
}
.operation-card-add-timeline {
  position: absolute;
  width: 300px;
  height: 500px;
  top: 7%;
  z-index: 100;
  right: 5%;
  border-radius: 15px;
  background: rgba(255, 255, 255, 0.1);
  overflow: hidden;
  visibility: hidden;
  direction: ltr;
  text-align: center;
}
.box {
  visibility: inherit;
  width: inherit;
  height: 99%;
  overflow-y: scroll;
  padding: 2rem;
  box-sizing: border-box;
  background: inherit;
  border-radius: 0.625rem;
}

.box h2 {
  margin: 0 0 1.875rem;
  padding: 0;
  font-size: 1rem;
  font-family: "Poppins";
  color: #fff;
  text-align: center;
}

.box .inputBox {
  position: relative;
}

.box .inputBox input {
  width: 100%;
  padding: 0.625rem 0;
  font-size: 1rem;
  font-family: "Poppins";
  color: #ffffff;
  letter-spacing: 0.062rem;
  margin-bottom: 1.875rem;
  border: none;
  border-bottom: 0.065rem solid #fff;
  outline: none;
  background: transparent;
}

.box .inputBox label {
  position: absolute;
  top: 0;
  left: 0;
  padding: 0.625rem 0;
  font-size: 1rem;
  color: rgb(55, 32, 85);
  font-family: "Poppins";
  pointer-events: none;
  transition: 0.5s;
}

.box .inputBox input:focus ~ label,
.box .inputBox input:valid ~ label,
.box .inputBox input:not([value=""]) ~ label {
  top: -0.8rem;
  left: 0;
  color: #e91e63;
  font-size: 0.75rem;
}

.box input[type="button"] {
  border: none;
  outline: none;
  color: #fff;
  background-color: #9e0538;
  padding: 0.625rem 1.25rem;
  cursor: pointer;
  border-radius: 0.312rem;
  font-size: 1rem;
  margin: 1rem;
}

.box input[type="button"]:hover {
  background-color: #e91e63;
}
</style>