 <template :ref="openEditModal">
  <v-dialog v-model="dialog" width="600px">
    <v-card>
      <v-card-title>
        <span class="text-h5">管理者編集</span>
      </v-card-title>
      <AlertMessage
        width="'580px'"
        alertClass="'mx-auto pa-3 ma-2 text-body-2'"
      />
      <v-card-text>
        <v-form @submit.prevent="submit">
          <validation-provider v-slot="{ errors }" name="Name" rules="required">
            <v-text-field
              v-model="admin.name"
              label="Name"
              :error-messages="errors"
              prepend-icon="mdi-account-circle"
              required
            >
            </v-text-field>
          </validation-provider>
          <validation-provider
            v-slot="{ errors }"
            name="Email"
            rules="required|email"
          >
            <v-text-field
              v-model="admin.email"
              label="Email"
              :error-messages="errors"
              prepend-icon="mdi-account-circle"
              required
            >
            </v-text-field>
          </validation-provider>
          <validation-provider
            v-slot="{ errors }"
            name="password"
            :rules="{
              min: 8,
              regex: '^.*(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$',
            }"
          >
            <v-text-field
              type="password"
              v-model="admin.password"
              label="Password"
              :error-messages="errors"
              prepend-icon="mdi-lock"
            ></v-text-field>
          </validation-provider>
        </v-form>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <CancelButton
          @close="close"
          :text="'閉じる'"
          :color="'#dcdcdc'"
          class="mr-3"
        />
        <SubmitButton :color="'blue darken-1'" :text="'更新'" @click="save" />
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "Edit",
  data() {
    return {
      admin: {},
      dialog: false,
    };
  },
  methods: {
    close() {
      this.dialog = false;
    },
    open(item) {
      this.admin = item;
      this.dialog = true;
    },
    async save() {
      let params = {
        id: this.admin.id,
        name: this.admin.name,
        email: this.admin.email,
        password: this.admin.password,
      };
      this.$axios
        .$put(`/admins/${this.admin.id}`, params)
        .then((res) => {
          this.$toast.global.success_message();
          this.close();
        })
        .catch((err) => {
          console.error(err);
        });
    },
  },
};
</script>
