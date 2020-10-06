<template>
  <div>
    <b-modal
      id="modal-procreator-add"
      ref="modal"
      title="Редактировать родителя"
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
  props: ["action", "old"],
  data() {
    return {
      active: this.action,
      actionId: null,
      fio: null,
      phone: null,
      vk_id: null,
      viber_id: null,
      errors: [],
    };
  },
  watch: {
    action: async function (value) {
      this.active = value;
      if (value) {
        this.fetchItem(this.actionId)
          .then((response) => {
            this.id = response.id;
            this.fio = response.fio;
            this.phone = response.phone;
            this.vk_id = response.vk_id;
            this.viber_id = response.viber_id;           
          })
          .catch((response) => {
            console.log(response);
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
    ...mapActions({
      fetchItem: "GET_DATEIL_PROCREATORS",
      updateItem: "UPDATE_PROCREATORS_API",
    }),
    resetModal() {
      this.fio = null;
      this.id = null;
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
        id: this.id,
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
      this.updateItem(this.mapData())
        .then((r) => {
          this.$nextTick(() => {
            this.$bvModal.hide("modal-procreator-add");
          });
          this.toast("Родитель успешно оттредактирован", "primary");
        })
        .catch((errors) => {
          this.errors = errors;
          this.toast("Ошибка!", "danger");
        });
    },
  },
};
</script>