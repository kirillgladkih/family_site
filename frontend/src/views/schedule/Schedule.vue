<template>
  <div class="">
    <div class="row shedule-wrapper">
      <div class="col-12" id="schedule-table">
        <div class="toolbar pt-4 pb-2">
          <div class="d-flex align-items-center">
            <h3 style="color: #6c757d">Грaфик</h3>
          </div>
          <div class="d-flex align-items-center">
            <week-select @weekEmmitHandler="weekEmmitListener" class="mr-2" />
            <group-select @groupEmmitHandler="groupEmmitListener" />
            <b-button
              class="ml-2"
              variant="primary"
              :disabled="SCHEDULE.length != 0 && group_id ? false : true"
              @click="toolBarActive = !toolBarActive"
            >
              <b-icon icon="gear" aria-hidden="true" />
            </b-button>
          </div>
        </div>
        <transition name="fade">
          <div
            class="table-responsive"
            v-if="SCHEDULE.length != 0 && stateLoaded == true"
          >
            <table class="table table-md text-center table-bordered">
              <thead>
                <th v-for="item in fields" :key="item.key">{{ item.label }}</th>
              </thead>
              <tbody>
                <tr v-for="items in SCHEDULE" :key="items[0].id">
                  <td v-for="item in items" :key="item.id">
                    <button
                      class="btn btn-schedule"
                      @click="ActionItem(item)"
                      :class="
                        item.active == 0 ? 'btn-secondary' : 'btn-success'
                      "
                    >
                      {{ item.hour.hour }}
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div v-else-if="!stateLoaded && group_id && week_id" class="loader">
            <strong variant="primary" class="pr-3">Загрузка...</strong>
            <b-spinner variant="primary"></b-spinner>
          </div>
          <div class="text-center pt-4 pb-4" v-else>Пусто</div>
        </transition>
      </div>
      <div
        class="col-4 schedule-settings-wrapper pt-4 d-none"
        id="schedule-settings"
      >
        <div class="schedule-settings">
          <h3 style="color: #6c757d" class="text-center">Редактирование</h3>
          <div class="" v-if="editItem">
            <h5 class="pt-3">
              {{
                `${editItem.week.name} - ${editItem.day.day_ru} - ${editItem.hour.hour}`
              }}
            </h5>
            <div class="pt-3">
              <label for="place_count">Количество мест</label>
              <b-form-spinbutton
                id="place_count"
                v-model="place_count"
                min="0"
              ></b-form-spinbutton>
              <div class="pt-3">
                <button
                  class="btn btn-schedule"
                  @click="editItem.active = !editItem.active"
                  :class="
                    editItem.active == 0 ? 'btn-secondary' : 'btn-success'
                  "
                >
                  Активность
                </button>
              </div>
              <div class="pt-3">
                <button class="btn btn-primary" @click="edit()">
                  Сохранить
                </button>
              </div>
            </div>
          </div>
          <div class="text-center" v-else>Пусто</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import GroupSelect from "../../components/groups/GroupSelect";
import WeekSelect from "../../components/WeekSelect";
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
  name: "Schedule",
  components: { "group-select": GroupSelect, "week-select": WeekSelect },
  watch: {
    toolBarActive: function (value) {
      let element = document.querySelector('div[id="schedule-table"]');
      let element2 = document.querySelector('div[id="schedule-settings"]');
      if (value === true) {
        element.classList.remove("col-12");
        element2.classList.remove("d-none");
        element.classList.add("col-8");
      } else {
        element.classList.remove("col-8");
        element2.classList.add("d-none");
        element.classList.add("col-12");
      }
    },
  },
  methods: {
    ...mapActions([
      "GET_SCHEDULE_API",
      "UPDATE_SCHEDULE_API",
      "GET_DATEIL_SCHEDULE",
    ]),
    groupEmmitListener(value) {
      this.group_id = value ? value : null;
      this.fetchItems();
    },
    weekEmmitListener(value) {
      this.week_id = value ? value : null;
      this.fetchItems();
    },
    async fetchItems() {
      this.stateLoaded = false;
      return this.group_id && this.week_id
        ? await this.GET_SCHEDULE_API({
            week_id: this.week_id,
            group_id: this.group_id,
          }).then(() => (this.stateLoaded = true))
        : false;
    },
    mapData(item, changeActive = true) {
      return {
        id: item.id,
        hour_id: item.hour_id,
        place_count: this.place_count,
        week_id: item.week_id,
        group_id: item.group_id,
        day_id: item.day_id,
        active: changeActive ? !item.active : item.active,
      };
    },

    toast(message, variant = null, title = null) {
      this.$bvToast.toast(message, {
        title: title || "действие на сайте",
        variant: variant || "secondary",
      });
    },

    async ActionItem(item) {
      if (!this.toolBarActive) {
        await this.UPDATE_SCHEDULE_API(this.mapData(item));
        this.selected = item;
      } else if (this.toolBarActive) {
        await this.GET_DATEIL_SCHEDULE(item.id).then((r) => {
          this.editItem = r;
          this.place_count = r.place_count;
        });
      }
    },

    async edit() {
      const data = this.mapData(this.editItem, false);
      await this.UPDATE_SCHEDULE_API(data);
    },
  },
  computed: {
    ...mapGetters(["SCHEDULE"]),
  },
  data() {
    return {
      fields: [
        { label: "Пн", key: "Mon" },
        { label: "Вт", key: "Tue" },
        { label: "Ср", key: "Wed" },
        { label: "Чт", key: "Thu" },
        { label: "Пт", key: "Fri" },
        { label: "Сб", key: "Sat" },
        { label: "Вс", key: "Sun" },
      ],
      group_id: null,
      week_id: null,
      toolBarActive: false,
      selected: null,
      stateLoaded: false,
      place_count: 0,
      editItem: null,
    };
  },
};
</script>
<style type="sass" scoped>
.btn-schedule {
  width: 100%;
  height: 100%;
  padding: 10px 15px;
}
table {
  transition: 500ms;
}
td {
  padding: 0;
  transition: 500ms;
  width: 40px !important;
}
.toolbar {
  width: 100%;
  display: flex;
  justify-content: space-between;
  flex-wrap: wrap;
}
.schedule-settings-wrapper {
  position: sticky;
  top: 0;
}
.schedule-settings {
  position: sticky;
  top: 0;
}
#schedule-table {
  transition: 500ms;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}
.fade-enter, .fade-leave-to /* .fade-leave-active до версии 2.1.8 */ {
  opacity: 0;
}
.loader {
  position: absolute;
  top: 100px;
  display: flex;
  justify-content: center;
  width: 100%;
  align-items: center;
  height: 100px;
}
</style>
