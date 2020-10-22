<template>
  <div class="">
    <div class="d-flex justify-content-between flex-wrap">
      <div class="pt-3 pr-3 title">
        <h3>{{ toolbarData.title }}</h3>
      </div>
      <div class="pr-3 max-width-search pt-3 search">
        <b-input-group>
          <b-form-input
            v-model="filter"
            type="search"
            id="filterInput"
            placeholder="Поиск..."
          >
          </b-form-input>
          <b-input-group-append>
            <b-button :disabled="!filter" @click="filter = ''">
              <b-icon icon="arrow-counterclockwise" aria-hidden="true" />
            </b-button>
            <b-button
              v-b-toggle.filter-options
              v-if="
                toolbarData.filterFields !== undefined &&
                !toolbarData.filterFields.length !== 0
              "
            >
              <b-icon icon="chevron-down" aria-hidden="true" />
            </b-button>
          </b-input-group-append>
        </b-input-group>

        <b-collapse
          id="filter-options"
          v-if="
            toolbarData.filterFields !== undefined &&
            !toolbarData.filterFields.length !== 0
          "
        >
          <b-form-checkbox-group
            v-model="filterOn"
            class="py-3 d-flex flex-wrap"
          >
            <b-form-checkbox
              v-for="item in toolbarData.filterFields"
              class="pb-2"
              :key="item.key"
              :value="item.key"
              >{{ item.label }}</b-form-checkbox
            >
          </b-form-checkbox-group>
        </b-collapse>
      </div>
      <div class="pt-3 actions">
        <b-button-toolbar class="d-flex justify-content-end">
          <b-button-group>
            <b-button
              class=""
              v-if="toolbarRecord != true"
              variant="primary"
              @click="addActive = !addActive"
            >
              <b-icon icon="plus" aria-hidden="true" />
            </b-button>
            <b-button
              v-if="toolbarRecord != true"
              class="ml-2"
              variant="primary"
              :disabled="allowAction"
              @click="editActive = !editActive"
            >
              <b-icon icon="pencil" aria-hidden="true" />
            </b-button>
            <slot name="extenend-btn"> </slot>
            <b-button
              class="ml-2"
              @click="deleteItem"
              variant="danger"
              :disabled="allowAction"
            >
              <b-icon icon="trash" aria-hidden="true" />
            </b-button>
          </b-button-group>
        </b-button-toolbar>
      </div>
    </div>
    <slot name="schedule-slot"></slot>
  </div>
</template>

<script>
export default {
  name: "ToolBar",
  props: ["toolbarData", "allowAction", "toolbarRecord"],
  data: () => ({
    filter: "",
    filterOn: [],
    addActive: false,
    editActive: false,
  }),
  watch: {
    filter: function () {
      this.$emit("filterEmmitHandler", this.filter);
    },
    filterOn: function () {
      this.$emit("filterOnEmmitHandler", this.filterOn);
    },
    addActive: function () {
      this.$emit("addActiveEmmitHandler", this.addActive);
      this.addActive = false;
    },

    editActive: function () {
      this.$emit("editActiveEmmitHandler", this.editActive);
      this.editActive = false;
    },
  },

  methods: {
    deleteItem() {
      this.$emit("daleteEmmitHandler");
    },
  },
};
</script> 

<style lang="css" scoped>
.max-width-search {
  width: 100%;
}

.title {
  order: 1;
}

.search {
  order: 2;
}

.actions {
  height: 40px;
  max-height: 40px;
  order: 3;
}

@media (min-width: 960px) {
  .max-width-search {
    max-width: 600px;
  }
}

@media (max-width: 960px) and (min-width: 320px) {
  .title {
    order: 1;
  }

  .search {
    order: 3;
    padding-right: 0 !important;
  }

  .actions {
    height: 40px;
    max-height: 40px;
    order: 2;
  }
}
</style>