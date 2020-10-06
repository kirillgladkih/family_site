<template>
  <div>
    <b-modal
      id="modal-procreator-add"
      ref="modal"
      title="Добавить родителя"
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
        <b-form-group label="ФИО" label-for="fio">
          <b-form-input id="fio" v-model="fio" required />
        </b-form-group>
        <b-form-group label="Телефон" label-for="phone">
          <b-form-input id="phone" v-model="phone" required />
        </b-form-group>
        <b-form-group label="VK_ID" label-for="vk_id">
          <b-form-input id="VK_ID" v-model="vk_id" required />
        </b-form-group>
        <b-form-group label="VIBER_ID" label-for="viber_id">
          <b-form-input id="VIBER_ID" v-model="viber_id" required />
        </b-form-group>
      </form>
    </b-modal>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  name: "ModalAdd",
  props: ["action"],
  data() {
    return {
      active: this.action,
      fio: null,
      phone: null,
      vk_id: null,
      viber_id: null,
      errors: [],
    };
  },
  watch: {
    action: function (value) {
      this.active = value;
    },
  },
  methods: {
    ...mapActions({
      addItem: "SAVE_PROCREATORS_API",
    }),
    resetModal() {
      this.fio = null;
      this.phone = null;
      this.vk_id = null;
      this.viber_id = null;
      this.errors = [];
    },

    makeToast(content, variant = null) {
      this.$bvToast.toast(content, {
        title: `Variant ${variant || "default"}`,
        variant: variant,
        solid: true,
      });
    },

    mapData() {
      return {
        fio: this.fio,
        phone: this.phone,
        vk_id: this.vk_id,
        viber_id: this.viber_id,
      };
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
      this.addItem(this.mapData())
        .then((r) => {
          this.$nextTick(() => {
            this.$bvModal.hide("modal-procreator-add");
          });
          this.toast("Родитель успешно создан", "primary");
        })
        .catch((errors) => {
          this.errors = errors;
          this.toast("Ошибка!", "danger");
        });
    },
  },
};
</script>