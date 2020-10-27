<template>
  <div class="">
    <h3 class="pt-4 pb-3" style="color: #6c757d">Записать</h3>
    <div class="row">
      <div class="col-6">
        <label for="">Клиент</label>
        <client-select @EmmitHandler="CientEmmitLiestener"></client-select>
      </div>
      <div class="col-6">
        <label for="">Дата</label>
        <select name="dates" v-model="date" id="dates" class="custom-select">
          <option
            v-for="date in schedule.dates"
            :key="date.date"
            :value="date.date"
          >
            {{ getDate(date) }}
          </option>
        </select>
      </div>
    </div>
    <div class="row pt-3">
      <div class="col-6">
        <label>+ Родитель</label>
        <select name="" id="" v-model="with_procreator" class="custom-select">
          <option value="0">Нет</option>
          <option value="1">Да</option>
        </select>
      </div>
      <div class="col-6">
        <label>Количество друзей</label>
        <select name="" id="" v-model="friends" class="custom-select">
          <option value="0">0</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </div>
    </div>
    <div class="row pt-4">
      <div class="col-12">
        <h3 class="text-center" style="color: #797d81">Часы</h3>
        <button
          class="btn mx-1 my-1 p-3"
          :value="hour"
          @click="action(hour)"
          :class="hour.record_id ? 'btn-success' : 'btn-secondary'"
          v-for="hour in hours"
          :key="hour.id"
        >
          {{ hour.hour.hour }}
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import ClientSelect from "../../components/client/ClientSelect";
import { mapActions, mapGetters, mapMutations } from "vuex";
export default {
  name: "Record",
  components: { "client-select": ClientSelect },
  data: () => ({
    client_id: null,
    with_procreator: 0,
    friends: 0,
    date: null,
    schedule: [],
    hours: [],
    selected: null,
  }),
  watch: {
    date: function (value) {
      if (value && this.date) {
        this.hours = [];
        this.schedule.items.map((item) => {
          if (item.date === this.date) {
            this.hours.push(item);
          }
        });
      }
    },
  },
  methods: {
    ...mapActions({
      fetchSchedule: "GET_SCHEDULE_FOR_RECORD",
      saveItem: "SAVE_RECORDS_API",
      deleteItem: "DELETE_RECORDS_API",
    }),
    async action(hour) {
      for (let i = 0; i < this.hours.length; i++) {
        if (this.hours[i].id == hour.id) {
          if (this.hours[i].record_id == null) {
            await this.saveItem(this.mapData(this.hours[i]))
              .then((response) => {
                this.hours[i].record_id = response.id;
              })
              .catch((response) => {
                this.toast(response, "danger");
              });
          } else {
            if (this.hours[i].record_id) {
              await this.deleteItem(this.hours[i].record_id)
                .then((response) => {
                  this.hours[i].record_id = null;
                })
                .catch((response) => {
                  this.toast("Ошибка!", "danger");
                });
            }
          }
        }
      }
    },
    async CientEmmitLiestener(value) {
      if (value) {
        this.client_id = value.id;
        await this.fetchSchedule(value.id).then((response) => {
          this.schedule = response;
        });
      }
    },

    getDate(date) {
      return date.date.slice(5) + " " + date.ru;
    },

    toast(message, variant = null, title = null) {
      this.$bvToast.toast(message, {
        title: title || "действие на сайте",
        variant: variant || "secondary",
      });
    },
    mapData(item) {
      return {
        date: item.date,
        hour: item.hour.hour,
        client_id: this.client_id,
        schedule_id: item.id,
        with_procreator: this.with_procreator,
        friends: this.friends,
      };
    },
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
</style>
