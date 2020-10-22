<template>
  <div>
    <b-modal
      id="modal-leed-add"
      ref="modal"
      title="Добавить лида"
      v-model="active"
      @show="resetModal"
      @hidden="resetModal"
      @ok="handleOk"
      cancel-title="Закрыть"
      ok-title="Сохранить"
    >
      <b-alert show variant="danger" v-if="procreator_errors.length !== 0">
        Родитель: <br />
        <span v-for="error in procreator_errors" :key="error">
          {{ error }}
          <br />
        </span>
      </b-alert>
      <b-alert show variant="danger" v-if="errors.length !== 0">
        Ребенок: <br />
        <span v-for="error in errors" :key="error">
          {{ error }}
          <br />
        </span>
      </b-alert>
      <form ref="form" @submit="handleSubmit">
        <b-form-group label="Родитель">
          <procreator-select
            :procreator_add="true"
            @EmmitHandler="procreatorEmmitListener"
          />
        </b-form-group>
        <div class="row">
          <b-form-group
            label="ФИО родителя"
            class="col-6"
            label-for="procreator_fio"
          >
            <b-form-input
              id="procreator_fio"
              :disabled="procreator_id != null"
              v-model="procreator_fio"
              required
            />
          </b-form-group>
          <b-form-group
            label="Телефон"
            class="col-6"
            label-for="procreator_phone"
          >
            <b-form-input
              id="procreator_phone"
              :disabled="procreator_id != null"
              v-model="procreator_phone"
              required
            />
          </b-form-group>
        </div>
        <div class="row">
          <b-form-group class="col-6" label="ФИО ребенка" label-for="child_fio">
            <b-form-input id="child_fio" v-model="child_fio" required />
          </b-form-group>
          <b-form-group class="col-6" label="Возраст" label-for="age">
            <b-form-spinbutton
              id="age"
              v-model="age"
              min="1"
            ></b-form-spinbutton>
          </b-form-group>
        </div>
      </form>
    </b-modal>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import ProcreatorSelect from "../../components/procreators/ProcreatorSelect";
export default {
  name: "ModalAdd",
  props: ["action"],
  components: { "procreator-select": ProcreatorSelect },
  data() {
    return {
      active: this.action,
      age: null,
      procreator_id: null,
      child_fio: null,
      procreator_phone: null,
      procreator_fio: null,
      procreator_phone: null,
      status_id: 1,
      errors: [],
      procreator_errors: [],
    };
  },
  watch: {
    action: function (value) {
      this.active = value;
    },
  },
  methods: {
    ...mapActions({
      addItem: "SAVE_CLIENTS_API",
      addProcreator: "SAVE_PROCREATORS_API",
    }),
    resetModal() {
      this.age = null;
      this.procreator_id = null;
      this.child_fio = null;
      this.status_id = 2;
      this.procreator_phone = null;
      this.procreator_fio = null;
      this.procreator_phone = null;
      this.procreator_errors = [];
      this.errors = [];
    },
    procreatorEmmitListener(value) {
      this.procreator_id = value;
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
        fio: this.child_fio,
        status_id: 1,
        age: this.age,
        procreator_id: this.procreator_id,
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

    async handleSubmit() {
      if (this.procreator_id == null) {
        await this.addProcreator({
          fio: this.procreator_fio,
          phone: this.procreator_phone,
        })
          .then((r) => {
            this.procreator_id = r.id;
          })
          .catch((errors) => {
            this.procreator_errors = errors;
          });
      }
      this.addItem(this.mapData())
        .then((r) => {
          this.$nextTick(() => {
            this.$bvModal.hide("modal-leed-add");
          });
          this.toast("Лид успешно создан", "primary");
        })
        .catch((errors) => {
          this.errors = errors;
          this.toast("Ошибка!", "danger");
        });
    },
  },
};
</script>