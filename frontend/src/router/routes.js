const isAuth = () => {
  const authStore = useAuthStore();

  if (authStore.user) {
    return true;
  }
  return false;
};

const routes = [
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
    beforeEnter: (to, from, next) => {
      if (isAuth()) {
        next("reports");
      } else {
        next();
      }
    },

    children: [
      {
        path: "",
        name: "welcome",
        component: () => import("pages/Welcome.vue"),
      },
      {
        path: "login",
        name: "login",
        component: () => import("pages/auth/Login.vue"),
      },
      {
        path: "register",
        name: "register",
        component: () => import("pages/auth/Register.vue"),
      },
    ],
  },
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
    beforeEnter: (to, from, next) => {
      if (!isAuth()) {
        next("login");
      } else {
        next();
      }
    },
    children: [
      {
        path: "reports",
        name: "reports",
        component: () => import("pages/reports/Index.vue"),
      },
      {
        path: "schedules",
        name: "schedules",
        component: () => import("pages/schedules/Index.vue"),
      },
      {
        path: "archives",
        name: "archives",
        component: () => import("pages/archives/Index.vue"),
      },
      {
        path: "settings",
        name: "settings",
        component: () => import("pages/Settings.vue"),
      },
      {
        path: "about",
        name: "about",
        component: () => import("pages/About.vue"),
      },
      {
        path: "help",
        name: "help",
        component: () => import("pages/Help.vue"),
      },
      {
        path: "contact-us",
        name: "contact-us",
        component: () => import("pages/contacts/Create.vue"),
      },
    ],
  },
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
