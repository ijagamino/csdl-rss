import { ref, onMounted } from "vue";
import { Dark } from "quasar";
import { useQuasar } from "quasar";

export function useDarkMode() {
  const $q = useQuasar();
  const isDark = ref(localStorage.getItem('dark'));

  const toggleDarkMode = () => {
    $q.dark.toggle();
    isDark.value = $q.dark.mode
    localStorage.setItem("dark", JSON.stringify(isDark.value));
  };

  onMounted(() => {
    const darkModePreference = localStorage.getItem("dark");
    if (darkModePreference !== null) {
      isDark.value = JSON.parse(darkModePreference);
      $q.dark.set(isDark.value);
    }
  });

  return { isDark, toggleDarkMode };
}
