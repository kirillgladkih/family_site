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
        >Выбрать группу</b-form-select-option
      >
    </template>
  </b-form-select>
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
  data() {
    return {
      selected: null,
      options: [],
    };
  },
  computed: {
    ...mapGetters(["GROUPS"]),
  },
  watch: {
    selected: function (value) {
      if (value != null || value != undefined) {
        this.$emit("groupEmmitHandler", value);
      }
    },
  },
  created() {
    this.GET_GROUPS_API().then((r) => {
      this.options = r.map((item) => {
        return { item: item.id, name: item.name };
      });
      this.selected = this.options.length > 0 ? this.options[0].item : null;
    });
  },
  methods: {
    ...mapActions(["GET_GROUPS_API"]),
  },
};
</script>

<style>
</style>