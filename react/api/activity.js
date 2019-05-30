const activityApi = {
  getByRandom: async () => {
    const data = await axios.get("../services/getActivityByRandom.php");
    return data.data[0];
  },
};
