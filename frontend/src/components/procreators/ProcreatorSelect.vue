<template>
  <div class="select">
    <select
      name="procreator-select"
      id="procreator-select"
      v-model="selected"
      class="custom-select"
    >
    <option v-if="procreator_add === true" :value="null">
      Добавить родителя
    </option>
      <option v-for="item in items" :key="item.id" :value="item.id">
        {{ `${item.fio} ${item.phone}` }}
      </option>
    </select>
    <!-- <input type="text" class="form-control search" placeholder="Поиск..." /> -->
  </div>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
  name: "ProcreatorSelect",
  data: () => ({
    selected: null,
  }),
  props: ['procreator_add'] , 
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
  },
};
</script>
<style scoped>
.select {
  position: relative;
}
 .search{
    top: 0;
    width: 80%;
    position: absolute;        
}
</style>