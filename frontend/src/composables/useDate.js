export function useDate() {
  const today = new Date();
  const tomorrow = new Date();
  tomorrow.setDate(today.getDate() + 1);

  const oneMonthFromNow = new Date();
  oneMonthFromNow.setMonth(oneMonthFromNow.getMonth() + 1);

  const minDate = `${tomorrow.getFullYear()}/${String(
    tomorrow.getMonth() + 1
  ).padStart(2, "0")}`;
  const maxDate = `${oneMonthFromNow.getFullYear()}/${String(
    oneMonthFromNow.getMonth() + 1
  ).padStart(2, "0")}`;

  const formatDate = (dateStr) => {
    const date = new Date(dateStr);

    const month = date.toLocaleDateString("en-US", { month: "long" });
    const day = date.getDate();
    const year = date.getFullYear();
    const dayOfWeek = date.toLocaleDateString("en-US", { weekday: "long" });

    return { month, day, year, dayOfWeek };
  };

  const formatTime = (timeStr) => {
    const date = new Date();
    const [hours, minutes, seconds] = timeStr.split(":"); // Split time string
    date.setHours(hours, minutes, seconds); // Set the time
    return date.toLocaleTimeString([], {
      hour: "2-digit",
      minute: "2-digit",
      hour12: true,
    });
  };

  return {
    today,
    tomorrow,
    oneMonthFromNow,
    minDate,
    maxDate,
    formatDate,
    formatTime,
  };
}
