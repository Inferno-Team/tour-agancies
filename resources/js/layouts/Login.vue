<template>
  <div class="" style="direction: ltr">
    <div class="imgBx">
      <img src="/storage/images/background.jpg" />
      <div
        class="box"
        id="login-form"
        v-animate-css.hover.once="animationObject"
      >
        <h2 v-if="!isSignUp">Sign In</h2>
        <h2 v-if="isSignUp">Sign Up</h2>
        <form @click.prevent>
          <div class="inputBox" v-if="isSignUp">
            <input v-model="user.first_name" type="text" required value="" />
            <label>First Name</label>
          </div>
          <div class="inputBox" v-if="isSignUp">
            <input v-model="user.last_name" type="text" required value="" />
            <label>Last Name</label>
          </div>
          <div class="inputBox">
            <input v-model="user.email" type="email" required value="" />
            <label>Email</label>
          </div>
          <div class="inputBox" v-if="isSignUp">
            <input type="text" v-model="user.phone" required value="" />
            <label>Phone Number</label>
          </div>
          <div class="inputBox">
            <input type="password" v-model="user.password" required value="" />
            <label>Password</label>
          </div>

          <input
            type="button"
            @click="login"
            :value="isSignUp ? 'Sign Up' : 'Log In'"
          />
          <div class="sign-up" v-if="!isSignUp">
            <p>don't have account yet ?</p>
            <p @click.prevent="change2signUp">Sign Up</p>
          </div>
          <p v-if="isSignUp" @click.prevent="change2signUp">Return to Log in</p>
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
      isSignUp: false,
      user: {
        email: "",
        password: "",
        phone: "",
        last_name: "",
        first_name: "",
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
    change2signUp() {
      this.isSignUp = !this.isSignUp;
    },
    login() {
      if (!this.isSignUp) {
        axios
          .post("/api/login", this.user)
          .then((response) => {
            if (response.data.code == 200) {
              localStorage.setItem("tour-agancy-token", response.data.token);
              axios.defaults.headers.common[
                "Authorization"
              ] = `Bearer ${response.data.token}`;
              this.$router.push({ name: "home" });
            } else {
              console.log(response.data);
              alert(response.data.msg)
            }
          })
          .catch((error) => console.log(error));
      } else {
        axios
          .post("/api/signup", {
            name: this.user.first_name,
            last_name: this.user.last_name,
            email: this.user.email,
            phone: this.user.phone,
            password: this.user.password,
            user_type: "manager",
          })
          .then((response) => {
            if (response.data.code === 200) {
              if (response.data.type === "manager") {
                localStorage.setItem("tour-agancy-token", response.data.token);
                axios.defaults.headers.common[
                  "Authorization"
                ] = `Bearer ${response.data.token}`;
                this.$router.push({ name: "home" });
              } else {
                alert("You are not a manager");
              }
            } else {
              console.log(response.data);
            }
          })
          .catch((error) => console.log(error));
      }
    },
    signUp() {},
  },
};
</script>
<style  scoped>
.sign-up {
  margin-top: 1rem;
  display: flex;
  align-items: center;
  justify-content: space-evenly;
}
p {
  font-size: 0.8rem;
  color: white;
  cursor: pointer;
}
p:last-child {
  font-size: 1rem;
  text-align: end;
}
p:last-child:hover {
  color: #03a9f4;
}
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
  margin: 0 0 1rem;
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
  margin-bottom: 1rem;
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