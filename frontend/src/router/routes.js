const routes = [
  {
    path: "/",
    component: () => import("layouts/GuestLayout.vue"),
    children: [
      { path: "", component: () => import("pages/Welcome.vue") },
      { path: "login", component: () => import("pages/auth/Login.vue") },
      { path: "register", component: () => import("pages/auth/Register.vue") },
    ],
  },
  {
    path: "/",
    component: () => import("layouts/GuestLayout.vue"),
    children: [
      {
        path: "dashboard",
        component: () => import("pages/dashboard/Index.vue"),
      },
      {
        path: "dashboard",
        component: () => import("pages/dashboard/Index.vue"),
      },
      {
        path: "dashboard",
        component: () => import("pages/dashboard/Index.vue"),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "/:catchAll(.*)*",
    component: () => import("pages/ErrorNotFound.vue"),
  },
];

export default routes;
