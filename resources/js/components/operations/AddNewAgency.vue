<template>
  <div
    class="animate__animated operation-card-add-agency"
    id="operation-card-add-agency"
  >
    <div class="box" id="login-form">
      <h2>Add New Agency</h2>
      <form>
        <div class="inputBox">
          <input type="text" required value="" v-model="agency.name" />
          <label>Agency Name</label>
        </div>
        <div class="inputBox">
          <input type="text" required value="" v-model="agency.location" />
          <label>Agency Location</label>
        </div>
        <b-dropdown id="dropdown-1" text="Choose a city" class="m-md-2">
          <b-dropdown-item
            @click="agency.city_id = city.id"
            v-for="(city, index) in cities"
            :key="index"
            >{{ city.name }}</b-dropdown-item
          >
        </b-dropdown>
        <vue-dropzone
          ref="logo"
          id="dropzone"
          :options="dropzoneOptions"
        ></vue-dropzone>
        <input type="button" value="Add New Agnecy" @click.prevent="onClick" />
      </form>
    </div>
  </div>
</template>
<script>
import vue2Dropzone from "vue2-dropzone";

export default {
  mounted() {
    this.showAddAgency(this.$props.state);
    this.getAllCities();
  },
  components: {
    vueDropzone: vue2Dropzone,
  },
  props: ["state"],
  watch: {
    state: function (nV, oL) {
      this.showAddAgency(nV);
    },
  },
  data() {
    return {
      agency: {},
      cities: [],
      dropzoneOptions: {
        url: "/api/add-tour-with-image",
        uploadMultiple: false,
        paramName: "agency_logo",
        autoProcessQueue: false,
        addRemoveLinks: true,
        thumbnailWidth: 100,
        thumbnailHeight: 100,
        maxFiles: 1,
        thumbnailMethod: "contain",
      },
    };
  },
  methods: {
    onClick() {
      var logoObject = this.$refs.logo.getQueuedFiles();
      if (logoObject != null) {
        this.agency.logo = logoObject[0].dataURL;
      }
      this.$emit("clicked", this.agency);
    },
    showAddAgency(value) {
      var operation_card = document.getElementById("operation-card-add-agency");
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
  },
};
</script>
<style scoped>
.operation-card-add-agency {
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
  height: inherit;
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
  color: #9e0538;
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
.dropzone {
  width: 85% !important;
  height: 33% !important;
  margin: auto !important;
}
</style>