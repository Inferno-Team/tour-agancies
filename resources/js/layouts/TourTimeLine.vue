<template>
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
      <div class="day-name">Day #{{ index + 1 }}</div>
      <TimeLine :points="points"></TimeLine>
    </div>
  </div>
</template>

<script>
import TimeLine from "vue-timeline/src/components/timeLine.vue";
export default {
  props: ["id"],
  components: {
    TimeLine,
  },
  mounted() {
    this.getTourSchedule();
  },
  data() {
    return {
      schedule: {},
      arrayOfDays: [],
      days:{}
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
            this.arrayOfDays.push(points);
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
  border-right: 7px solid rgba(255, 255, 255, 0.334) ;
  border-left: 7px solid rgba(255, 255, 255, 0.334) ;
}

.timeline-content h2,
.timeline-content p {
  color: black !important ;
}
.date {
  color: white;
}
</style>