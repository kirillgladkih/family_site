<template>
  <b-form-select
    v-model="selected"
    :options="options"
    value-field="item"
    text-field="name"
    disabled-field="notEnabled"
  >
    <template v-slot:first>
      <b-form-select-option value="" disabled
        >Выбрать неделю</b-form-select-option
      >
    </template>
  </b-form-select>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";

export default {
  name: "WeekSelect",
  data() {
    return {
      selected: null,
      options: [],
    };
  },
  watch: {
    selected: function (value) {
      if (value != null || value != undefined) {
        this.$emit("weekEmmitHandler", value);
      }
    },
  },
  created() {
    this.fetchItems().then((r) => {
      this.options = r.map((item) => {
        return { item: item.id, name: item.name };
      });
      this.selected = this.options.length > 0 ? this.options[0].item : null;
    });
  },
  methods: {
    ...mapActions({ fetchItems: "GET_WEEKS_API" }),
  },
};
</script>

<style>
</style>