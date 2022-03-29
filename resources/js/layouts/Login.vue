<template>
  <div class="">
    <div class="imgBx">
      <img src="/images/background.jpeg" />
      <div class="box" id="login-form" v-animate-css.hover.once="animationObject">
        <h2>Sign In</h2>
        <form style="direction: ltr" @click.prevent>
          <div class="inputBox">
            <input v-model="user.email" type="email" required value="" />
            <label>Email</label>
          </div>
          <div class="inputBox">
            <input type="password" v-model="user.password" required value="" />
            <label>Password</label>
          </div>
          <input type="button" @click="login" name="sign-in" value="Login" />
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  mounted() {
    const token = localStorage.getItem("tour-agancy-token");
    if (token !== undefined && token !== null)
      this.$router.push({ name: "home" });
  },
  data() {
    return {
      user: {
        email: "",
        password: "",
      },
      animationObject: {
        classes: "swing",
        delay: 500,
        duration: 1000,
        iteration: 1,
      },
    };
  },
  methods: {
    login() {
      axios
        .post("/api/login", this.user)
        .then((response) => {
          if (response.code === 200 || response.data.code === 200) {
            localStorage.setItem("tour-agancy-token", response.data.token);
            this.$router.push({ name: "home" });
          } else {
            console.log(response.data);
          }
        })
        .catch((error) => console.log(error));
    },
  },
};
</script>
<style  scoped>
.imgBx img {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}
.box {
  position: absolute;
  top: 10%;
  right: 7.5%;
  width: 18rem;
  height: 30rem;
  visibility: visible;

  padding: 2.1rem;
  background: rgba(0, 0, 0, 0.6);
  border-radius: 0.625rem;
}
.box h2 {
  margin: 0 0 1.875rem;
  padding: 0;
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
  color: #fff;
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
  color: #fff;
  pointer-events: none;
  transition: 0.5s;
}

.box .inputBox input:focus ~ label,
.box .inputBox input:valid ~ label,
.box .inputBox input:not([value=""]) ~ label {
  top: -1.125rem;
  left: 0;
  color: #03a9f4;
  font-size: 0.75rem;
}

.box input[type="button"] {
  border: none;
  outline: none;
  color: #fff;
  background-color: #03a9f4;
  padding: 0.625rem 1.25rem;
  cursor: pointer;
  border-radius: 0.312rem;
  font-size: 1rem;
}

.box input[type="button"]:hover {
  background-color: #1cb1f5;
}
</style>