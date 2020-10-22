<template>
  <div>
    <h3 class="pb-2" style="color: #6c757d">
      График : <span style="color: black">{{ client_fio }}</span>
    </h3>
    <div class="table-responsive">
      <table
        v-if="stateLoaded"
        class="table table-md text-center table-bordered"
      >
        <thead>
          <th v-for="item in fields" :key="item.key">{{ item.label }}</th>
        </thead>
        <tbody>
          <tr v-for="items in CLIENT_SCHEDULE" :key="items[0].id">
            <td v-for="item in items" :key="item.id">
              <button
                class="btn btn-schedule"
                @click="ActionItem(item)"
                :class="item.active == 0 ? 'btn-secondary' : 'btn-success'"
              >
                {{ item.hour.hour }}
              </button>
            </td>
          </tr>
        </tbody>
      </table>
      <div v-else-if="!stateLoaded" class="loader">
        <strong variant="primary" class="pr-3">Загрузка...</strong>
        <b-spinner variant="primary"></b-spinner>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
  name: "ClientSchedule",
  props: ["client_id", "client_fio"],
  data: () => ({
    fields: [
      { label: "Пн", key: "Mon" },
      { label: "Вт", key: "Tue" },
      { label: "Ср", key: "Wed" },
      { label: "Чт", key: "Thu" },
      { label: "Пт", key: "Fri" },
      { label: "Сб", key: "Sat" },
      { label: "Вс", key: "Sun" },
    ],
    stateLoaded: false,
  }),
  mounted() {
    this.$emit("EmmitHandler", this.$refs.modal);
  },
  watch: {
    client_id: async function (value) {
      if (value) {
        this.stateLoaded = false;
        await this.fetchItems(value).then(() => (this.stateLoaded = true));
      }
    },
  },
  computed: {
    ...mapGetters(["CLIENT_SCHEDULE"]),
  },
  methods: {
    ...mapActions({
      fetchItems: "GET_CLIENT_SCHEDULE_API",
      updateItem: "UPDATE_CLIENT_SCHEDULE_API",
    }),
    async ActionItem(item) {
      item.active = !item.active;
      await this.updateItem(item);
    },
  },
};
</script>
<style type="sass" scoped>
.table-responsive {
  max-height: 400px;
}
.btn-schedule {
  width: 100%;
  height: 100%;
  padding: 10px 15px;
}
table {
  transition: 500ms;
}
td {
  padding: 0;
  transition: 500ms;
  width: 40px !important;
}

.loader {
  display: flex;
  justify-content: center;
  width: 100%;
  align-items: center;
  height: 100px;
}
</style>