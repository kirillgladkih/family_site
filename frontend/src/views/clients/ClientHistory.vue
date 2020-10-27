<template>
  <div>
    <div class="d-flex justify-content-between">
      <div class="">
        <h3 class="pb-2" style="color: #6c757d">
          История : <span style="color: black">{{ client_fio }}</span>
        </h3>
      </div>
      <div class="">
        <button class="btn btn-primary" @click="fetch()">
          <b-icon icon="search" aria-hidden="true" />
        </button>
      </div>
    </div>

    <div class="row pb-2">
      <div class="col-6">
        <b-form-datepicker
          id="before-date"
          v-model="before_date"
          placeholder="Дата от"
          locale="ru"
          class="mb-2"
        ></b-form-datepicker>
      </div>
      <div class="col-6">
        <b-form-datepicker
          id="after-date"
          v-model="after_date"
          placeholder="Дата до"
          locale="ru"
          class="mb-2"
        ></b-form-datepicker>
      </div>
    </div>
    <div class="table-responsive" v-if="before_date && after_date">
      <table v-if="stateLoaded" class="table table-sm text-center">
        <thead>
          <th v-for="item in fields" :key="item.key">{{ item.label }}</th>
        </thead>
        <tbody>
          <tr
            v-for="item in items"
            :key="item.id"
            :class="item.visit == 1 ? 'tr-bg-primary' : 'tr-bg-danger'"
          >
            <td>{{ item.date }}</td>
            <td>{{ item.hour }}</td>
            <td>{{ item.visit == 1 ? "Был" : "Не был" }}</td>
          </tr>
        </tbody>
      </table>
      <div v-else-if="!stateLoaded" class="loader">
        <strong variant="primary" class="pr-3">Загрузка...</strong>
        <b-spinner variant="primary"></b-spinner>
      </div>
    </div>
    <div class="text-center" v-else>Выберите дату</div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "ClientHistory",
  props: ["client_id", "client_fio"],
  data: () => ({
    fields: [
      { label: "Дата", key: "date" },
      { label: "Час", key: "hour" },
      { label: "Явка", key: "visit" },
    ],
    items: [],
    after_date: null,
    before_date: null,
    stateLoaded: false,
  }),
  mounted() {
    this.$emit("EmmitHandler", this.$refs.modal);
  },
  async created() {
    this.stateLoaded = false;
    // this.items = await this.fetchItems({ id: this.client_id });
  },
  methods: {
    ...mapActions({
      fetchItems: "HISTORY_RECORDS_API",
    }),
    async fetch() {
      if (this.client_id && this.before_date && this.after_date) {
        this.stateLoaded = false;
        const data = {
          after: this.after_date,
          before: this.before_date,
          id: this.client_id,
        };
        await this.fetchItems(data).then((response) => {
          this.stateLoaded = true;
          this.items = response;
        });
      }
    },
  },
};
</script>
<style type="sass" scoped>
.table-responsive {
  max-height: 400px;
}

.loader {
  display: flex;
  justify-content: center;
  width: 100%;
  align-items: center;
  height: 100px;
}

.tr-bg-danger {
  background: rgb(250, 207, 207);
}

.tr-bg-primary {
  background: rgb(170, 221, 255);
}
</style>