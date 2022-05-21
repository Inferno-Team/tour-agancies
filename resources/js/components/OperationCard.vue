<template>
  <div class="animate__animated operation-card" id="operation_card">
    <div class="box" id="login-form">
      <h2>{{ title }}</h2>
      <form>
        <div
          class="inputBox"
          v-for="(field, index) in this.fields"
          :key="index"
        >
          <input
            :type="field.type"
            required
            value=""
            v-model="dataObject[index]"
          />
          <label>{{ field.title }}</label>
        </div>
        <!-- <div class="inputBox">
          <input type="text" required value="" v-model="dataObject.field2" />
          <label>{{ field2_title }}</label>
        </div>
        <div class="inputBox">
          <input type="text" required value="" v-model="dataObject.field3" />
          <label>{{ field3_title }}</label>
        </div> -->
        <input type="button" :value="title" @click.prevent="onClick" />
      </form>
    </div>
  </div>
</template>
<script>
export default {
  mounted() {
    this.showAddPatient(this.$props.state);
  },
  props: ["title", "fields", "state"],
  watch: {
    state: function (nV, oL) {
      this.showAddPatient(nV);
    },
  },
  data() {
    return {
      dataObject: [],
    };
  },
  methods: {
    onClick() {
      // console.log(this.dataObject);
      this.$emit("data", this.dataObject);
      // this.dataObject.field1 = "";
      // this.dataObject.field2 = "";
      // this.dataObject.field3 = "";
    },
    showAddPatient(value) {
      var operation_card = document.getElementById("operation_card");
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
  },
};
</script>
<style scoped>
.operation-card {
  position: absolute;
  width: 250px;
  height: 570px;
  top: 7%;
  z-index: 100;
  right: 5%;
  border-radius: 15px;
  background: rgba(255, 255, 255, 0.1);
  overflow: hidden;
  visibility: hidden;
}
.operation-card .box {
  visibility: inherit;
  width: inherit;
  height: inherit;
  padding: 2rem;
  box-sizing: border-box;
  background: inherit;
  border-radius: 0.625rem;
}

.operation-card .box h2 {
  margin: 0 0 1.875rem;
  padding: 0;
  font-size: 1rem;
  font-family: "Poppins";
  color: #fff;
  text-align: center;
}

.operation-card .box .inputBox {
  position: relative;
}

.operation-card .box .inputBox input {
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

.operation-card .box .inputBox label {
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

.operation-card .box .inputBox input:focus ~ label,
.operation-card .box .inputBox input:valid ~ label,
.operation-card .box .inputBox input:not([value=""]) ~ label {
  top: -0.8rem;
  left: 0;
  color: #e91e63;
  font-size: 0.75rem;
}

.operation-card .box input[type="button"] {
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

.operation-card .box input[type="button"]:hover {
  background-color: #e91e63;
}
</style>