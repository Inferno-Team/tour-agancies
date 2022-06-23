<template>
  <div
    class="animate__animated operation-card-add-place"
    id="operation-card-add-place"
  >
    <div class="box" id="login-form">
      <h2>Add New Place</h2>
      <form>
        <div class="inputBox">
          <input type="text" required value="" v-model="place.name" />
          <label>Place Name</label>
        </div>
        <div class="inputBox">
          <input type="text" required value="" v-model="place.location" />
          <label>Place Location</label>
        </div>
        <div class="inputBox">
          <input type="text" required value="" v-model="place.latitude" />
          <label>Place Latitude</label>
        </div>
        <div class="inputBox">
          <input type="text" required value="" v-model="place.longitude" />
          <label>Place Longitude</label>
        </div>
        <textarea v-model="place.disc"
        class="mb-4" placeholder="Place Description" rows="4" cols="20"></textarea>
        <vue-dropzone
          ref="myVueDropzone"
          id="dropzone"
          v-on:vdropzone-sending="vsending"
          v-on:vdropzone-complete="vdropzoneComplate"
          :options="dropzoneOptions"
        ></vue-dropzone>
        <input type="button" value="Add New Place" @click.prevent="onClick" />
      </form>
    </div>
  </div>
</template>
<script>
import vue2Dropzone from "vue2-dropzone";

export default {
  mounted() {
    this.showAddPlace(this.$props.state);
    this.getAllCities();
  },
  props: ["state"],
  components: {
    vueDropzone: vue2Dropzone,
  },
  watch: {
    state: function (nV, oL) {
      this.showAddPlace(nV);
    },
  },
  data() {
    return {
      place: {},
      cities: [],
      dropzoneOptions: {
        url: "/api/add-tour-with-image",
        uploadMultiple: false,
        paramName: "place_image",
        autoProcessQueue: false,
      },
    };
  },
  methods: {
    onClick() {
      // this.$emit("clicked", this.place);
      this.$refs.myVueDropzone.processQueue();
    },
    showAddPlace(value) {
      var operation_card = document.getElementById("operation-card-add-place");
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
    getAllCities() {
      axios
        .get("/api/get_all_cities")
        .then((response) => {
          this.cities = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    vsending(file, xhr, formData) {
      this.sending = true;
      xhr.setRequestHeader(
        "Authorization",
        `Bearer ${localStorage.getItem("tour-agancy-token")}`
      );
      formData.append("name", this.place.name);
      formData.append("location", this.place.location);
      formData.append("latitude", this.place.latitude);
      formData.append("longitude", this.place.longitude);
      formData.append('disc',this.place.disc)
      // window.toastr.warning('', 'Event : vdropzone-sending')
    },
    vdropzoneComplate(response) {
      console.log(response);
    },
  },
};
</script>
<style scoped>
.dropzone {
  height: 20px;
}
.operation-card-add-place {
  position: absolute;
  width: 250px;
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