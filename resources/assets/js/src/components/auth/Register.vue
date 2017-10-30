<template>
  <div class="register-form">
    <form v-on:submit.prevent="handleSubmit">
      <div v-if="this.error.email"
        class="alert alert-danger">
        {{ this.error.email[0] }}
      </div>
      <div class="form-group">
        <label for="email">Email address:</label>
        <input 
          v-model="register.email"
          v-validate="'required|email'"
          type="email" 
          class="form-control" 
          name="email"
          id="email"
          autofocus>
        <div v-show="errors.has('email')"
          class="alert alert-danger">
          {{ errors.first('email') }}
        </div>
      </div>

      <div class="form-group">
        <label for="name">Name:</label>
        <input 
          v-model="register.name"
          v-validate="'required|alpha_spaces'"
          type="text" 
          class="form-control" 
          id="name"
          name="name">
        <div v-show="errors.has('name')"
          class="alert alert-danger">
          {{ errors.first('name') }}
        </div>
      </div>

      <div class="form-group">
        <label for="number">Number:</label>
        <input 
          v-model="register.number"
          v-validate="'numeric|min:3'"
          type="text" 
          class="form-control" 
          id="number"
          name="number">
        <div v-show="errors.has('number')"
          class="alert alert-danger">
          {{ errors.first('number') }}
        </div>
      </div>

      <div class="form-group">
        <label for="pwd">Password:</label>
        <input 
          v-model="register.password"
          v-validate="'required|min:6'" 
          type="password" 
          class="form-control" 
          id="pwd"
          name="password">
        <div v-show="errors.has('password')"
          class="alert alert-danger">
          {{ errors.first('password') }}
        </div>
      </div>

      <div class="form-group">
        <label for="pwd">Confirm password:</label>
        <input
          v-model="register.c_password"
          v-validate="'required|confirmed:password|min:6'"
          type="password" 
          class="form-control" 
          id="pwd"
          name="c_password"
          data-vv-as="password">
        <div v-show="errors.has('c_password')"
          class="alert alert-danger">
          {{ errors.first('c_password') }}
        </div>
      </div>

      <button v-if="this.register.email.length 
      && this.register.password.length
      && this.register.name.length 
      && !errors.any()" 
      type="submit" 
      class="btn btn-default">
        Register
      </button>
    </form>
  </div>
</template>

<script>
import { getHeaders } from './../../../config/env'

export default {
  name: 'register',
  data () {
    return {
      register: {
        name: '',
        email: '',
        number: '',
        password: '',
        c_password: ''
      },
      error: {}
    }
  },
  methods: {
    handleSubmit () {
      const data = {
        email: this.register.email,
        name: this.register.name,
        password: this.register.password,
        c_password: this.register.c_password,
        number: this.register.number
      }
      const authUser = {}
      this.$http.post('api/register', data)
      .then(response => {
        if (response.status === 200) {
          authUser.access_token = response.data.access_token
          window.localStorage.setItem('authUser', JSON.stringify(authUser))
          this.$http.get('api/user', { headers: getHeaders() })
            .then(response => {
              authUser.name = response.data.name
              authUser.email = response.data.email
              authUser.user_id = response.data.id
              window.localStorage.setItem('authUser', JSON.stringify(authUser))
              this.$store.dispatch('setUserObject', authUser)
              this.$router.push({ name: 'products' })
            })
        }
      })
      .catch(error => (this.error = error.body.error))
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.register-form {
  width: 100%;
  position: fixed;
  top: 20%;
  display: flex;
  align-items: center;
  justify-content: center; 
  overflow: auto; 
  text-align: center; 
}
</style>
