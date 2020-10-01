<template>
  <div>
    <b-modal
      id="modal-group-add"
      ref="modal"
      title="Добавить группу"
      v-model="active"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
      cancel-title="Закрыть"
      ok-title="Сохранить"
    >
      <b-alert show dismissible variant="danger" v-if="errors.length !== 0">
        <span v-for="error in errors" :key="error">
          {{ error }}
          <br />
        </span>
      </b-alert>
      <form ref="form" @submit.stop.prevent="handleSubmit">
        <b-form-group
          label="Название"
          label-for="name"
          aria-describedby="name-feedback"
        >
          <b-form-input id="name" v-model="name" required> </b-form-input>
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
export default {
  name: "ModalAdd",
  props: ["action"],
  data() {
    return {
      active: this.action,
      name: null,
      age_before: null,
      age_after: null,
      errors: [],
    };
  },
  watch: {
    action: function (value) {
      this.active = value;
    },
  },
  methods: {
    resetModal() {
      this.name = null;
      this.age_before = null;
      this.age_after = null;
      this.errors = [];
    },
    handleOk(bvModalEvt) {
      // Prevent modal from closing
      bvModalEvt.preventDefault();
      // Trigger submit handler
      this.handleSubmit();
    },
    handleSubmit() {
      // Exit when the form isn't valid
      if (!this.checkFormValidity()) {
        return;
      }
      // Push the name to submitted names
      this.submittedNames.push(this.name);
      // Hide the modal manually
      this.$nextTick(() => {
        this.$bvModal.hide("modal-group-add");
      });
    },
  },
};
</script>