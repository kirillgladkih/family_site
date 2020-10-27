<template>
  <div class="position-relative">
    <modal-add :action="addActive" />
    <modal-edit :action="editActive" :old="selected[0]" />
    <b-collapse id="ClientSchedule" v-model="ClientScheduleActive" class="mt-4">
      <div class="client-schedule">
        <client-schedule
          :client_fio="
            selected.length > 0 && ClientScheduleActive ? selected[0].fio : null
          "
          :client_id="
            selected.length > 0 && ClientScheduleActive ? selected[0].id : null
          "
        ></client-schedule>
      </div>
    </b-collapse>
    <b-collapse id="ClientSchedule" v-model="ClientHistoryActive" class="mt-4">
      <div class="client-history">
        <client-history
          :client_fio="
            selected.length > 0 && ClientHistoryActive ? selected[0].fio : null
          "
          :client_id="
            selected.length > 0 && ClientHistoryActive ? selected[0].id : null
          "
        >
        </client-history>
      </div>
    </b-collapse>
    <div class="table-responsive">
      <b-table
        selectable
        :filter="filter"
        :select-mode="selectMode"
        :items="CLIENTS"
        :fields="fields"
        :filter-included-fields="filterOn"
        @row-selected="onRowSelected"
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
          >
            <template v-slot:extenend-btn>
              <b-button
                class="ml-2"
                variant="primary"
                :aria-expanded="ClientScheduleActive ? 'true' : 'false'"
                aria-controls="ClientSchedule"
                @click="ClientScheduleActive = !ClientScheduleActive"
                :disabled="typeIdChecker != 2"
              >
                <b-icon icon="calendar" aria-hidden="true" />
              </b-button>
              <b-button
                class="ml-2"
                variant="primary"
                :aria-expanded="ClientHistoryActive ? 'true' : 'false'"
                aria-controls="ClientHistory"
                @click="ClientHistoryActive = !ClientHistoryActive"
                :disabled="selected.length == 0"
              >
                <b-icon icon="clock-history" aria-hidden="true" />
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
import { mapActions, mapGetters, mapMutations } from "vuex";
import ToolBar from "../../components/ToolBar";
import ModalAdd from "./ModalAdd";
import ModalEdit from "./ModalEdit";
import ClientSchedule from "./ClientSchedule";
import ClientHistory from "./ClientHistory";
import $ from "jquery";
export default {
  name: "Clients",
  components: {
    ToolBar,
    "modal-edit": ModalEdit,
    "modal-add": ModalAdd,
    "client-schedule": ClientSchedule,
    "client-history": ClientHistory,
  },
  computed: {
    ...mapGetters(["CLIENTS"]),
  },
  watch: {
    selected: function (value) {
      this.allowAction = this.selected.length > 0 ? false : true;
      this.ClientScheduleActive = false;
      this.ClientHistoryActive = false;
      this.typeIdChecker =
        this.selected.length > 0 ? this.selected[0].type_id : null;
      this.toolbarData.selected = this.selected;
    },
  },
  data() {
    return {
      addActive: false,
      editActive: false,
      allowAction: true,
      ClientScheduleActive: false,
      ClientHistoryActive: false,
      successMessage: null,
      dismissSecs: 5,
      typeIdChecker: null,
      dismissCountDown: 0,
      showDismissibleAlert: false,
      fields: [
        { key: "fio", label: "ФИО" },
        { key: "age", label: "Возраст" },
        { key: "procreator.fio", label: "Родитель" },
        { key: "group.name", label: "Группа" },
        { key: "payed", label: "Опл-но" },
        { key: "pass", label: "Проп-ов" },
        { key: "visit", label: "Пос-ий" },
        { key: "type.name", label: "Тип" },
        { key: "coins", label: "Баллы" },
      ],
      selectMode: "single",
      selected: [],
      toolbarData: {
        title: "Клиенты",
        filterFields: [
          { key: "fio", label: "ФИО" },
          { key: "age", label: "Возраст" },
          { key: "procreator.fio", label: "Родитель" },
          { key: "group.name", label: "Группа" },
          { key: "payed", label: "Опл-но" },
          { key: "pass", label: "Проп-ов" },
          { key: "visit", label: "Пос-ий" },
          { key: "type.name", label: "Тип" },
          { key: "coins", label: "Баллы" },
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