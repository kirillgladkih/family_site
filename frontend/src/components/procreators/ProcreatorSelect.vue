<template>
  <div>
    <input list="procreators" v-model="selected" class="form-control" />
    <datalist id="procreators">
      <option v-if="procreator_add === true" :value="null">
        Добавить родителя
      </option>
      <option v-if="procreator_edit === true" :value="null">
        Редактировать родителя
      </option>
      <option v-for="item in items" :key="item.id" :value="item.id">
        {{ `${item.fio} ${item.phone}` }}
      </option>
    </datalist>
    <!-- <select
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
      <option v-for="item in items" :key="item.id" :value="item.id">
        {{ `${item.fio} ${item.phone}` }}
      </option>
    </select> -->
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
  name: "ProcreatorSelect",
  data: () => ({
    selected: null,
    listActive: false,
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
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions({
      fetchItems: "GET_PROCREATORS_API",
    }),
    search(value) {
      console.log(value);
    },
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