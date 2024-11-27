import axios from "axios";

export default (token) => {
  var auth = "none";

  if (token) auth = "Bearer " + localStorage.token;
  var host = "http://localhost:8000/api";

  return axios.create({
    baseURL: host,
    headers: {
      Authorization: auth,
    },
  });
};
