<template>
  <v-overlay :value="registerOverlay">
    <v-container :fluid="$vuetify.breakpoint.xs" class="relative pa-0">
      <v-row>
        <v-spacer></v-spacer>
        <v-col cols="12" class="pa-0">
          <v-form
            ref="form"
            class="px-3 py-2"
            :style="$vuetify.breakpoint.xsOnly ? 'width: 100%' : 'width:600px'"
            enctype="multipart/form-data"
            v-model="valid"
            lazy-validation
            @submit.prevent="validate"
          >
            <v-text-field
              v-model="firstName"
              :counter="10"
              :rules="firstNameRules"
              name="firstName"
              label="First name"
              required
            ></v-text-field>
            <v-text-field
              v-model="lastName"
              :counter="10"
              :rules="lastNameRules"
              name="lastName"
              label="Last name"
              required
            ></v-text-field>
            <v-text-field v-model="email" :rules="emailRules" label="E-mail" name="email" required></v-text-field>
            <v-text-field
              v-model="password"
              :append-icon="passwordDisplayEyeIcon ? 'mdi-eye' : 'mdi-eye-off'"
              :rules="passwordRules"
              :type="passwordDisplayEyeIcon ? 'text' : 'password'"
              name="password"
              label="Password"
              hint="At least 8 characters and upper case character(s)"
              counter
              @click:append="passwordDisplayEyeIcon = !passwordDisplayEyeIcon"
            ></v-text-field>
            <v-file-input
              @change="handleInputAvatar($event)"
              :value="avatar"
              ref="inputAvatar"
              :rules="avatarRules"
              name="avatar"
              accept="image/png, image/jpeg, image/bmp"
              placeholder="Selectionner un avatar"
              prepend-icon="mdi-camera"
              label="Avatar"
            ></v-file-input>
            <v-btn :disabled="!valid" color="success" type="submit" class="mr-4 mt-4">Validate</v-btn>
          </v-form>
        </v-col>
        <v-spacer></v-spacer>
      </v-row>
    </v-container>
  </v-overlay>
</template>

<script>
import axios from 'axios'
export default {
  props: {
    'registerOverlay': { type: Boolean }
  },
  data: () => ({
    valid: true,
    passwordDisplayEyeIcon: false,
    firstName: '',
    lastName: '',
    email: '',
    password: '',
    avatar: null,
    firstNameRules: [
      v => !!v || 'First name is required', // true aussi non ...
      v => (v && v.length <= 10) || 'First name must be less than 10 characters',
    ],
    lastNameRules: [
      v => !!v || 'Last name is required', // true aussi non ...
      v => (v && v.length <= 10) || 'Last name must be less than 10 characters',
    ],
    emailRules: [
      v => !!v || 'E-mail is required',
      v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
    ],
    passwordRules: [
      v => !!v || 'Password is required',
      v => (v && v.length >= 5 && v != v.toLowerCase()) || 'Password must be valid',
    ],
    avatarRules: [
      v => !v || v.size < 2000000 || 'L\'image doit peser moins de 2 MB!',
    ],
  }),
  methods: {
    validate () {
      let form = new FormData(this.$refs.form.$el)
      form.append('first_name', this.firstName)
      form.append('last_name', this.lastName)
      form.append('email', this.email)
      form.append('password', this.password)
      form.append('password_confirmation', this.password)
      form.append('picture_path', this.avatar)
      axios
        .post('/register', form)
        .then(res => res.status == 200 && this.$emit('registerSuccess', false));
      // this.$refs.form.validate();
      // this.$refs.form.reset();
    },
    handleInputAvatar (file) {
      this.avatar = file;
    }
  },
}
</script>

<style >
</style>