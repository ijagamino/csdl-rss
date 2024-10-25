const authCan = (to, from, next, permissions) => {
  const authStore = useAuthStore();

  const permissionsArray = Array.isArray(permissions)
    ? permissions
    : [permissions];

  const hasPermission = permissionsArray.some(
    (permission) => authStore.can?.[permission]
  );

  if (!hasPermission) {
    return next(from.fullPath);
  } else {
    return next();
  }
};

const routes = [
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
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
    children: [
      {
        path: "users",
        children: [
          {
            path: "",
            name: "users.index",
            beforeEnter: (to, from, next) => {
              authCan(to, from, next, "editUsers");
            },
            component: () => import("pages/users/Index.vue"),
          },
        ],
      },
    ],
  },
  {
    path: "/",
    component: () => import("layouts/MainLayout.vue"),
    beforeEnter: (to, from, next) => {
      const authStore = useAuthStore();
      if (!authStore.user) {
        return next({ name: "login" });
      }
      return next();
    },
    children: [
      {
        path: "reports",
        children: [
          {
            path: "",
            name: "reports.index",
            beforeEnter: (to, from, next) => {
              authCan(to, from, next, ["viewAllReports", "viewOwnReports"]);
            },
            component: () => import("pages/reports/Index.vue"),
          },
          {
            path: ":id",
            name: "reports.show",
            beforeEnter: (to, from, next) => {
              authCan(to, from, next, ["viewAllReports", "viewOwnReports"]);
            },
            component: () => import("pages/reports/Show.vue"),
          },
          {
            path: "create",
            name: "reports.create",
            beforeEnter: (to, from, next) => {
              authCan(to, from, next, "createReports");
            },
            component: () => import("pages/reports/Create.vue"),
          },
        ],
      },
      {
        path: "schedules",
        name: "schedules.index",
        beforeEnter: (to, from, next) => {
          authCan(to, from, next, [
            "viewAllAppointments",
            "viewOwnAppointments",
          ]);
        },
        component: () => import("pages/schedules/Index.vue"),
      },
      {
        path: "archives",
        name: "archives.index",
        beforeEnter: (to, from, next) => {
          authCan(to, from, next, ["viewAllArchives", "viewOwnArchives"]);
        },
        component: () => import("pages/archives/Index.vue"),
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
        name: "feedbacks.create",
        beforeEnter: (to, from, next) => {
          authCan(to, from, next, "createFeedbacks");
        },
        component: () => import("pages/feedbacks/Create.vue"),
      },
      {
        path: "feedbacks",
        name: "feedbacks.index",
        beforeEnter: (to, from, next) => {
          authCan(to, from, next, "viewAllFeedbacks");
        },
        component: () => import("pages/feedbacks/Index.vue"),
      },
    ],
  },
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
