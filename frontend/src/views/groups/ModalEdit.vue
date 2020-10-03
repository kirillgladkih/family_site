<template>
  <div>
    <b-modal
      id="modal-group-edit"
      ref="modal"
      title="Редактировать группу"
      v-model="active"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
      cancel-title="Закрыть"
      ok-title="Сохранить"
    >
      <b-alert show variant="danger" v-if="errors.length !== 0">
        <span v-for="error in errors" :key="error">
          {{ error }}
          <br />
        </span>
      </b-alert>
      <form ref="form" @submit="handleSubmit">
        <b-form-group
          label="Название"
          label-for="name"
          aria-describedby="name-feedback"
        >
          <b-form-input id="name" v-model="name" required />
        </b-form-group>
        <div>
          <label for="age_before">Возраст от</label>
          <b-form-spinbutton
            id="age_before"
            v-model="age_before"
            min="1"
            :max="age_after !== null ? age_after : 100"
          ></b-form-spinbutton>
        </div>
        <div class="pt-3">
          <label for="age_after">Возраст до</label>
          <b-form-spinbutton
            id="age_after"
            v-model="age_after"
            :min="age_before !== null ? age_before : 0"
            max="100"
          >
          </b-form-spinbutton>
        </div>
      </form>
    </b-modal>
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  name: "ModalEdit",
  props: ["action", "old"],
  data() {
    return {
      active: this.action,
      name: null,
      age_before: null,
      age_after: null,
      id: null,
      errors: [],
      actionId: null,
    };
  },
  watch: {
    action: async function (value) {
      this.active = value;
      if (value) {
        this.GET_DATEIL_GROUPS(this.actionId)
          .then((response) => {
            this.id = response.id;
            this.name = response.name;
            this.age_before = response.age_before;
            this.age_after = response.age_after;
          })
          .catch((response) => {
            console.log(response)
            this.toast("Ошибка!!!", "danger");
          });
      }
    },
    old: function (value) {
      if (value) {
        this.actionId = value.id;
      }
    },
  },
  methods: {
    ...mapActions(["UPDATE_GROUPS_API", "GET_DATEIL_GROUPS"]),
    resetModal() {
      this.id = null;
      this.name = null;
      this.age_before = null;
      this.age_after = null;
      this.errors = [];
    },

    mapData() {
      return {
        id: this.id,
        name: this.name,
        age_after: this.age_after,
        age_before: this.age_before,
      };
    },
    resetErros() {
      this.errors = [];
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler

      this.handleSubmit();
    },
    toast(message, variant = null, title = null) {
      this.$bvToast.toast(message, {
        title: title || "действие на сайте",
        variant: variant || "secondary",
      });
    },

    handleSubmit() {
      this.UPDATE_GROUPS_API(this.mapData())
        .then((r) => {
          this.toast("Группа успешно отредактирована", "primary");
          this.$nextTick(() => {
            this.$bvModal.hide("modal-group-edit");
          });
        })
        .catch((errors) => {
          this.errors = errors;
          this.toast("Ошибка!", "danger");
        });
    },
  },
};
</script>