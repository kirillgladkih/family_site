<template>
  <div>
    <select
      name="client-select"
      id="client-select"
      v-model="selected"
      class="custom-select"
    >
      <option v-for="item in items" :key="item.id" :value="item">
        {{ `${item.fio} (${item.procreator.fio})` }}
      </option>
    </select>
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
  name: "ClientSelect",
  data: () => ({
    selected: null,
    listActive: false,
  }),
  watch: {
    selected: function (value) {
      return this.$emit("EmmitHandler", value);
    },
  },
  computed: {
    ...mapGetters({
      items: "FOR_RECORD",
    }),
  },
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions({
      fetchItems: "GET_CLIENTS_API",
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