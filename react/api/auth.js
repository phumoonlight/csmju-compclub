// Incomplete
const authApi = {
  auth: async () => {
    const result = await axios.get("../services/auth.php");
    const user = result.data;
    switch (user) {
      case "admin":
        console.log(user);
        break;
      case "":
        console.log(user);
        break;
      default:
        window.location.href = "http://csmju.jowave.com/login.php";
        break;
    }
  }
};
