<template>
  <div class="">
    <b-navbar toggleable="lg" type="light" variant="light">
      <b-button v-b-toggle.sidebar variant="primary">Меню</b-button>
    </b-navbar>
    <b-sidebar
      id="sidebar"
      aria-labelledby="sidebar-no-header-title"
      shadow
      title="FAMILY"
    >
      <template v-slot:default="{ hide }">
        <div class="">
          <nav class="mb-3">
            <b-nav vertical>
              <b-nav-item
                @click="hide"
                v-for="route in routes"
                :key="route.name"
                :to="route.route"
              >
                {{ route.name }}
              </b-nav-item>
            </b-nav>
          </nav>
        </div>
      </template>
    </b-sidebar>
    <div class="container-fluid">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data: () => ({
    routes: [
      {
        name: "Группы",
        route: "/home/groups/",
      },
      {
        name: "График",
        route: "/home/schedule/",
      },
      // {
      //   name: "Расписание",
      //   route: "/home/timetable/",
      // },
      {
        name: "Родители",
        route: "/home/procreators/",
      },
      // {
      //   name: "Лиды",
      //   route: "/home/leeds/",
      // },
      {
        name: "Клиенты",
        route: "/home/clients/",
      },
      // {
      //   name: "Записать",
      //   route: "/home/record/",
      // },
      // {
      //   name: "Записи",
      //   route: "/home/recordings/",
      // },
    ],
  }),
};
</script>
<style type="scss" scoped>
.nav-link {
  width: 100%;
  color: black;
  opacity: 0.8;
  padding-top: 15px;
  padding-bottom: 15px;
}
.nav-link:hover {
  opacity: 0.8;
  background: #acc3dd;
}
.router-link-active {
  opacity: 0.8;
  background: #acc3dd;
}
</style>



