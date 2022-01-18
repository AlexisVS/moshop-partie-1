<template>
  <v-dialog
    :transition="false"
    @click:outside="$emit('closeOverlayConnexion', false)"
    @keydown.esc="$emit('closeOverlayConnexion', false)"
    v-model="loginOverlay"
    color="transparent"
    :elevation="0"
    width="max-content"
  >
    <v-card width="max-content" class="mx-auto" :elevation="0">
      <v-card-text>
        <v-container>
          <v-row>
            <v-spacer></v-spacer>
            <v-col cols="12" class="pa-0">
              <v-form
                ref="form"
                class="px-9 py-9 py-2 rounded-lg"
                :style="$vuetify.breakpoint.xsOnly ? 'width: 100%' : 'width:600px'"
                enctype="multipart/form-data"
                v-model="valid"
                lazy-validation
                @submit.prevent="validate"
              >
                <v-text-field
                  v-model="email"
                  :rules="emailRules"
                  label="E-mail"
                  name="email"
                  required
                ></v-text-field>
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
                <v-btn :disabled="!valid" color="success" type="submit" class="mr-4 mt-4">Validate</v-btn>
              </v-form>
            </v-col>
            <v-spacer></v-spacer>
          </v-row>
        </v-container>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script>
import axios from 'axios'
export default {
  name: 'Connexion',
  props: {
    'loginOverlay': { type: Boolean }
  },
  data: () => ({
    valid: true,
    passwordDisplayEyeIcon: false,
    email: '',
    password: '',
    emailRules: [
      v => !!v || 'E-mail is required',
      v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
    ],
    passwordRules: [
      v => !!v || 'Password is required',
      v => (v && v.length >= 5 && v != v.toLowerCase()) || 'Password must be valid',
    ],
  }),
  methods: {
    validate () {
      let form = new FormData(this.$refs.form.$el)
      form.append('email', this.email)
      form.append('password', this.password)
      axios
        .post('/login', form)
        .then(res => res.status = 200 && this.$emit('loginSuccess', false))
        .catch(err => console.log(err));
      this.$refs.form.validate();
      this.$refs.form.reset();
    },
  },
}
</script>

<style >
</style>