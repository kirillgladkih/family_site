<template>
  <div class="position-relative">
    <div class="table-responsive">
      <b-table
        selectable
        :filter="filter"
        :select-mode="selectMode"
        :items="items"
        :fields="fields"
        :filter-included-fields="filterOn"
        @row-selected="onRowSelected"
        caption-top
        class="text-center"
        selected-variant="primary"
      >
        <template v-slot:row-details="">
          <div class="">
            <h1>hui</h1>
          </div>
        </template>
        <template v-slot:table-caption>
          <ToolBar
            :toolbarData="toolbarData"
            :allowAction="allowAction"
            :toolbarRecord="true"
            @filterEmmitHandler="filterEmmitListener"
            @filterOnEmmitHandler="filterOnEmmitListener"
            @addActiveEmmitHandler="addActiveEmmitListener"
            @editActiveEmmitHandler="editActiveEmmitListener"
            @daleteEmmitHandler="daleteEmmitListener"
          >
            <template v-slot:extenend-btn>
              <b-button class="" :disabled="allowAction" variant="primary">
                <b-icon icon="plus" aria-hidden="true" />
              </b-button>
              <b-button class="ml-2" :disabled="allowAction" variant="primary">
                <b-icon icon="plus" aria-hidden="true" />
              </b-button>
            </template>
          </ToolBar>
        </template>
        <template v-slot:cell(selected)="{ rowSelected }">
          <template v-if="rowSelected">
            <span aria-hidden="true">&check;</span>
            <span class="sr-only">Selected</span>
          </template>
          <template v-else>
            <span aria-hidden="true">&nbsp;</span>
            <span class="sr-only">Not selected</span>
          </template>
        </template>
      </b-table>
    </div>
  </div>
</template>

<script>
import { on } from "events";
import { mapActions, mapGetters, mapMutations } from "vuex";
import ToolBar from "../../components/ToolBar";
export default {
  name: "Recordings",
  components: {
    ToolBar,
  },
  computed: {
    ...mapGetters({ items: "RECORDS" }),
  },
  watch: {
    selected: function (value) {
      this.allowAction = this.selected.length > 0 ? false : true;
    },
  },
  data() {
    return {
      addActive: false,
      editActive: false,
      allowAction: true,
      successMessage: null,
      dismissSecs: 5,
      typeIdChecker: null,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      fields: [
        { key: "client.fio", label: "ФИО ребенка" },
        { key: "procreator.fio", label: "ФИО родителя" },
        { key: "date", label: "Дата" },
        { key: "hour", label: "Час" },
      ],
      selectMode: "multi",
      selected: [],
      toolbarData: {
        title: "Записи",
        filterFields: [
          { key: "client.fio", label: "ФИО ребенка" },
          { key: "procreator.fio", label: "ФИО родителя" },
          { key: "date", label: "Дата" },
          { key: "hour", label: "Час" },
        ],
      },
      filter: "",
      filterOn: [],
    };
  },
  created() {
    this.fetchItems();
  },
  methods: {
    ...mapActions({
      fetchItems: "GET_RECORDS_API",
      deleteItem: "DELETE_RECORDS_API",
    }),
    filterEmmitListener(value) {
      this.filter = value;
    },
    filterOnEmmitListener(value) {
      this.filterOn = value;
    },
    addActiveEmmitListener(value) {
      this.addActive = value;
    },
    editActiveEmmitListener(value) {
      this.editActive = value;
    },
    onRowSelected(items) {
      this.selected = items;
    },

    toast(message, variant = null, title = null) {
      this.$bvToast.toast(message, {
        title: title || "действие на сайте",
        variant: variant || "secondary",
      });
    },

    daleteEmmitListener() {
      if (this.selected.length > 0) {
        if (confirm("Удалить?")) {
          this.selected.forEach((item) => this.deleteItem(item.id));
        }
      }
    },
  },
};
</script>
