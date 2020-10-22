<template>
  <div>
    <b-modal
      id="modal-client-edit"
      ref="modal"
      title="Редактировать клиента"
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
            @EmmitHandler="procreatorEmmitListener"
            :procreator_edit="true"
          />
        </b-form-group>
        <div class="row">
          <b-form-group
            label="ФИО  родителя"
            class="col-6"
            label-for="procreator_fio"
          >
            <b-form-input
              id="procreator_fio"
              :disabled="procreator_id !== null"
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
              :disabled="procreator_id !== null"
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
        <b-form-group
          label="Количество оплаченных часов"
          label-for="hours_payed"
        >
          <b-form-spinbutton
            id="hours_payed"
            v-model="hours_payed"
            min="-1"
          ></b-form-spinbutton>
        </b-form-group>
        <b-form-group label="Тип клиента">
          <select
            name="client_type"
            v-model="type_id"
            id="client_type"
            class="custom-select"
          >
            <option value="1">Свободное посещение</option>
            <option value="2">По абонименту</option>
          </select>
        </b-form-group>
      </form>
    </b-modal>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import ProcreatorSelect from "../../components/procreators/ProcreatorSelect";
export default {
  name: "ModalEdit",
  props: ["action", "old"],
  components: { "procreator-select": ProcreatorSelect },
  data() {
    return {
      active: this.action,
      id: null,
      age: null,
      hours_payed: 0,
      procreator_id: null,
      child_fio: null,
      procreator_phone: null,
      procreator_fio: null,
      procreator_phone: null,
      status_id: 2,
      type_id: 1,
      errors: [],
      actionId: null,
      editProcreatorId: null,
      procreator_errors: [],
    };
  },
  watch: {
    action: async function (value) {
      this.active = value;
      if (value && this.actionId) {
        await this.fetchItem(this.actionId)
          .then((response) => {
            this.id = response.id;
            this.age = response.age;
            this.procreator_id = response.procreator_id;
            this.payed = response.payed;
            this.child_fio = response.fio;
            this.type_id = response.type_id;
          })
          .catch((response) => {
            console.log(response);
            this.toast("Ошибка!!!", "danger");
          });

        await this.fetchProcreator(this.procreator_id)
          .then((response) => {
            this.procreator_id = null;
            this.editProcreatorId = response.id;
            this.procreator_fio = response.fio;
            this.procreator_phone = response.phone;
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
      addItem: "UPDATE_CLIENTS_API",
      editProcreator: "UPDATE_PROCREATORS_API",
      fetchItem: "GET_DATEIL_CLIENTS",
      fetchProcreator: "GET_DATEIL_PROCREATORS",
    }),
    resetModal() {
      this.age = null;
      this.payed = null;
      this.procreator_id = null;
      this.child_fio = null;
      this.status_id = 2;
      this.editProcreatorId = null;
      this.type_id = 1;
      this.id = null;
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
        status_id: 2,
        id: this.id,
        type_id: this.type_id,
        age: this.age,
        payed: this.hours_payed,
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
      if (this.procreator_id === null) {
        await this.editProcreator({
          id: this.editProcreatorId,
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
      await this.addItem(this.mapData())
        .then((r) => {
          this.$nextTick(() => {
            this.$bvModal.hide("modal-client-edit");
          });
          this.toast("Клиент успешно отредактирован", "primary");
        })
        .catch((errors) => {
          this.errors = errors;
          this.toast("Ошибка!", "danger");
        });
    },
  },
};
</script>