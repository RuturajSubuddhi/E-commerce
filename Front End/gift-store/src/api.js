import axios from "axios";

const baseURL = import.meta.env.VITE_API_URL || "http://localhost:8001/api";
console.log("🌍 API Base URL Loaded:", baseURL);

const api = axios.create({
  baseURL,
  headers: { "Content-Type": "application/json" },
});

api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");
    if (token) config.headers.Authorization = `Bearer ${token}`;
    return config;
  },
  (error) => Promise.reject(error)
);

export default api;
