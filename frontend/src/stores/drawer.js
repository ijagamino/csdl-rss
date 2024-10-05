import { defineStore } from "pinia";

export const useDrawerStore = defineStore("drawer", () => {
  const show = ref(false);

  return { show };
});
