<template>
  <div class="">
    <div>
      <ModalAdd :action="addActive" /> 
      <b-table
        ref="selectableTable"
        selectable
        :filter="filter"
        :select-mode="selectMode"
        :items="items"
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
            @filterEmmitHandler="filterEmmitListener"
            @filterOnEmmitHandler="filterOnEmmitListener"
            @addActiveEmmitHandler="addActiveEmmitListener"
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
      <p>
        Selected Rows:<br />
        {{ selected }}
      </p>
    </div>
  </div>
</template>

<script>
import ToolBar from "../../components/ToolBar";
import ModalAdd from "./ModalAdd"
export default {
  name: "Groups",
  components: { ToolBar , ModalAdd},
  data() {
    return {
      addActive: false, 
      fields: [
        { key: "name", label: "Название" },
        { key: "age_before", label: "Возраст от" },
        { key: "age_after", label: "Возраст до" },
      ],
      items: [
        {
          name: "name",
          age_before: 10,
          age_after: 10,
        },
         {
          name: "name",
          age_before: 10,
          age_after: 10,
        },
         {
          name: "name",
          age_before: "name",
          age_after: 10,
        },
      ],
      selectMode: "single",
      selected: [],
      toolbarData: {
        title: "Группы",
        filterFields: [
          { key: "name", label: "Название" },
          { key: "age_before", label: "Возраст от" },
          { key: "age_after", label: "Возраст до" },
        ],
      },
      filter: "",
      filterOn: []
    };
  },
  methods: {
    filterEmmitListener(value) {
      this.filter = value;
    },
    filterOnEmmitListener(value){
       this.filterOn = value
    },
    addActiveEmmitListener(value){
       this.addActive = value
    },
    onRowSelected(items) {
      this.selected = items;
    },
    selectAllRows() {
      this.$refs.selectableTable.selectAllRows();
    },
    clearSelected() {
      this.$refs.selectableTable.clearSelected();
    },
    selectThirdRow() {
      // Rows are indexed from 0, so the third row is index 2
      this.$refs.selectableTable.selectRow(2);
    },
    unselectThirdRow() {
      // Rows are indexed from 0, so the third row is index 2
      this.$refs.selectableTable.unselectRow(2);
    },
  },
};
</script>

<style>
</style>