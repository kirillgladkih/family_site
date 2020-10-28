<template>
  <div class="row">
    <div class="col-6">
      <select
        name="procreator-select"
        id="procreator-select"
        v-model="selected"
        class="custom-select"
      >
        <option v-if="procreator_add === true" :value="null">
          Добавить родителя
        </option>
        <option v-if="procreator_edit === true" :value="null">
          Редактировать родителя
        </option>
        <option v-for="item in options" :key="item.id" :value="item.id">
          {{ `${item.fio} ${item.phone}` }}
        </option>
      </select>
    </div>
    <div class="col-6">
      <div class="input-group">
        <input
          type="text"
          class="form-control"
          @keypress="searchItems"
          v-model="search"
          placeholder="Поиск..."
        />
        <div class="input-group-append">
          <button class="btn btn-primary" @click="reset()" type="button">
            <b-icon icon="arrow-repeat"></b-icon>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
  name: "ProcreatorSelect",
  data: () => ({
    selected: null,
    listActive: false,
    search: null,
    options: [],
  }),
  props: ["procreator_add", "procreator_edit"],
  watch: {
    selected: function (value) {
      return this.$emit("EmmitHandler", value);
    },
  },
  computed: {
    ...mapGetters({
      items: "PROCREATORS",
    }),
  },
  async created() {
    this.options = await fetchItems().map((item) => (item.visible = true));
  },
  searchItems() {
    if (this.selected) {
      this.options = this.options.map((item) => {
        return (item.visible = `${item.fio} ${item.phone}`.includes(this.search)
          ? true
          : false);
      });
    }
  },
  reset() {
    this.options = this.options.map((item) => (item.visible = true));
  },
  methods: {
    ...mapActions({
      fetchItems: "GET_PROCREATORS_API",
    }),
  },
};
</script>
<style scoped>
.select {
  position: relative;
}
.search {
  top: 20px;
  width: 80%;
  position: absolute;
}
</style>