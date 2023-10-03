import axios from "axios";

export default axios.create({
  baseURL: "https://punchly.io/backend/api",
  responseType: "json"
});
