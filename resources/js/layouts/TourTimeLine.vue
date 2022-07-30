<template>
  <div>
    <div class="time-line-container">
      <div class="logout-div">
        <font-awesome-icon
          icon="fa-solid fa-power-off"
          class="powerOff"
          @click.prevent="logout"
        />
        <p>Log out</p>
      </div>
      <img src="/storage/images/background.jpeg" />

      <div v-for="(points, index) in arrayOfDays" :key="index">
        <div v-if="points != undefined && points != null" class="day-name">
          Day #{{ points.day }}
        </div>
        <TimeLine
          v-if="points != undefined && points != null"
          :points="points.p"
        ></TimeLine>
      </div>
      <div class="floating-container">
        <div class="floating-button" @click.prevent="showAddForm">+</div>
      </div>
    </div>
    <add-time-line
      @onAdd="onTimeLineAdded"
      :id="this.$props.id"
      :days="days"
      :state="showAddFormValue"
    ></add-time-line>
  </div>
</template>

<script>
import TimeLine from "vue-timeline/src/components/timeLine.vue";
import AddTimeLine from "../components/operations/AddTimeLine.vue";
export default {
  props: ["id"],
  components: {
    TimeLine,
    AddTimeLine,
  },
  mounted() {
    this.getTourSchedule();
  },
  data() {
    return {
      schedule: {},
      arrayOfDays: {},
      days: [],
      showAddFormValue: "show",
    };
  },
  methods: {
    logout() {
      localStorage.removeItem("tour-agancy-token");
      location.reload();
    },
    getTourSchedule() {
      axios
        .get(`/api/get_tour_schedule?id=${this.$props.id}`)
        .then((response) => {
          this.schedule = response.data.data;
          let data = this.reshapeData();
          this.days = data;
          console.log(data);
          for (var key in data) {
            var value = data[key];
            let points = [];
            for (let index = 0; index < value.length; index++) {
              const element = value[index];
              points.push({
                img: true,
                title: element.place.name,
                text: element.place.disc,
                date: element.time,
                linkUrl: `http://127.0.0.1:8000/${element.place.img_url}`,
                linkText: "Open Image",
              });
            }
            this.arrayOfDays[key] = { p: points, day: key };
          }
        })
        .catch((error) => console.log(error));
    },
    reshapeData() {
      let data = this.schedule.tour_place_time;
      let days = {};
      for (let index = 0; index < data.length; index++) {
        const element = data[index];
        if (days[element.day] !== undefined) {
          // already exists
          days[element.day].push({
            place: element.place,
            time: `${element.time_step.start} - ${element.time_step.end}`,
          });
        } else {
          days[element.day] = [];
          days[element.day].push({
            place: element.place,
            time: `${element.time_step.start} - ${element.time_step.end}`,
          });
        }
      }
      return days;
    },
    showAddForm() {
      if (this.showAddFormValue === "show") this.showAddFormValue = "hidden";
      else this.showAddFormValue = "show";
    },
    onTimeLineAdded(newTimeline) {
      this.arrayOfDays = [];
      this.getTourSchedule();
    },
  },
};
</script>

<style >
.time-line-container {
  height: 99%;
  overflow-y: auto;
  margin: 0.2rem;
  direction: ltr !important;
  font-family: monospace;
}
.day-name {
  text-align: center;
  font-size: 2rem;
  margin-top: 0.5rem;
  color: #fff;
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

.timeline-content {
  background: rgba(255, 255, 255, 0.334) !important;
}
.timeline-content::before {
  border-right: 7px solid rgba(255, 255, 255, 0.334);
  border-left: 7px solid rgba(255, 255, 255, 0.334);
}

.timeline-content h2,
.timeline-content p {
  color: black !important ;
}
.date {
  color: white;
}
.floating-container {
  position: fixed;
  width: 100px;
  height: 100px;
  bottom: 0;
  right: 0;
  margin: 25px 15px;
  z-index: 1;
}

.floating-container:hover {
  height: 300px;
}

.floating-container:hover .floating-button {
  box-shadow: 0 10px 25px #e91e62c0;
  transform: translatey(5px);
  transition: all 0.3s;
}

.floating-container .floating-button {
  position: absolute;
  width: 60px;
  height: 60px;
  background: #e91e63;
  bottom: 0;
  border-radius: 50%;
  left: 0;
  right: 0;
  margin: auto;
  color: white;
  line-height: 60px;
  text-align: center;
  font-size: 19px;
  z-index: 100;
  box-shadow: 0 10px 25px -5px #e91e62c0;
  cursor: pointer;
  -webkit-transition: all 0.3s;
  transition: all 0.3s;
}
</style>