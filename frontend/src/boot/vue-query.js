import { boot } from "quasar/wrappers";
import { VueQueryPlugin } from "@tanstack/vue-query";

const defaultQueryFn = async ({ queryKey }) => {
  // await axios.get("sanctum/csrf-cookie");
  const { data } = await api.get(queryKey[0], { params: queryKey[1] });
  return data;
};

const vueQueryPluginOptions = {
  queryClientConfig: {
    defaultOptions: { queries: { queryFn: defaultQueryFn } },
  },
};

export default ({ app }) => {
  app.use(VueQueryPlugin, vueQueryPluginOptions);
};
