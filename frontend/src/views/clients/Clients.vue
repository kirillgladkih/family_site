<template>
  <div>
    <modal-add :action="addActive" />
    <modal-edit :action="editActive" :old="selected[0]" />
    <b-table
      selectable
      :filter="filter"
      :select-mode="selectMode"
      :items="CLIENTS"
      :fields="fields"
      :filter-included-fields="filterOn"
      @row-selected="onRowSelected"
      responsive="sm"
      caption-top
      class="text-center"
      selected-variant="primary"
    >
      <template v-slot:table-caption>
        <ToolBar
          :toolbarData="toolbarData"
          :allowAction="allowAction"
          @filterEmmitHandler="filterEmmitListener"
          @filterOnEmmitHandler="filterOnEmmitListener"
          @addActiveEmmitHandler="addActiveEmmitListener"
          @editActiveEmmitHandler="editActiveEmmitListener"
          @daleteEmmitHandler="daleteEmmitListener"
        />
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
</template>

<script>
import { mapActions, mapGetters, mapMutations } from "vuex";
import ToolBar from "../../components/ToolBar";
import ModalAdd from "./ModalAdd";
import ModalEdit from "./ModalEdit";
import $ from "jquery";
export default {
  name: "Clients",
  components: {
    ToolBar,
    "modal-edit": ModalEdit,
    "modal-add": ModalAdd,
  },
  computed: {
    ...mapGetters(["CLIENTS"]),
  },
  watch: {
    selected: function () {
      this.allowAction = this.selected.length > 0 ? false : true;

      this.toolbarData.selected = this.selected;
    },
  },
  data() {
    return {
      addActive: false,
      editActive: false,
      allowAction: true,
      successMessage: null,
      dismissSecs: 5,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      fields: [
        { key: "fio", label: "ФИО" },
        { key: "age", label: "Возраст" },
        { key: "procreator.fio", label: "Родитель" },
        { key: "group.name", label: "Группа" },
        { key: "payed", label: "Оплаченно" },
        { key: "pass", label: "Пропусков" },
        { key: "visit", label: "Посещений" },
        { key: "type.name", label: "Тип" },
      ],
      selectMode: "single",
      selected: [],
      toolbarData: {
        title: "Клиенты",
        filterFields: [
          { key: "name", label: "Название" },
          { key: "age_before", label: "Возраст от" },
          { key: "age_after", label: "Возраст до" },
        ],
      },
      filter: "",
      filterOn: [],
    };
  },
  created() {
    this.GET_CLIENTS_API();
  },
  methods: {
    ...mapActions(["GET_CLIENTS_API", "DELETE_CLIENTS_API"]),
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
      if (confirm("Удалить?")) {
        this.DELETE_CLIENTS_API(this.selected[0].id).then((r) => {
          this.toast("Клиент успешно удален", "primary");
        });
      }
    },

    // selectAllRows() {
    //   this.$refs.selectableTable.selectAllRows();
    // },
    // clearSelected() {
    //   this.$refs.selectableTable.clearSelected();
    // },
    // selectThirdRow() {
    //   // Rows are indexed from 0, so the third row is index 2
    //   this.$refs.selectableTable.selectRow(2);
    // },
    // unselectThirdRow() {
    //   // Rows are indexed from 0, so the third row is index 2
    //   this.$refs.selectableTable.unselectRow(2);
    // },
  },
};
</script>

<style>
</style>