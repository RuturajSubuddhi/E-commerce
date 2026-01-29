import axios from "axios";

// const API_URL = "http://127.0.0.1:8000/api";
// ✅ Automatically use API URL from environment variables
// const API_URL =
//   process.env.REACT_APP_API_URL || import.meta.env.VITE_API_URL;
const API_URL = import.meta.env.VITE_API_URL || "http://localhost:8001/api";


// Fallback in case the env is missing
if (!API_URL) {
  console.error("❌ API URL not found. Please set REACT_APP_API_URL or VITE_API_URL in your .env.production file");
}

/**
 * Register a new user
 * @param {string} name
 * @param {string} email
 * @param {string} password
 * @param {string} password_confirmation
 */
export const registerUser = async (name, email, password, password_confirmation) => {
  const res = await axios.post(`${API_URL}/signup`, {
    name,
    email,
    password,
    password_confirmation, // required by Laravel
  });

  if (res.data.status === 200) {
    localStorage.setItem("token", res.data.token);
    localStorage.setItem("user", JSON.stringify(res.data.user));
  }

  return res.data;
};

/**
 * Login user
 * @param {string} email
 * @param {string} password
 */
export const loginUser = async (email, password) => {
  const res = await axios.post(`${API_URL}/login`, {
    email,
    password,
  });

  if (res.data.status === 200) {
    localStorage.setItem("token", res.data.token);
    localStorage.setItem("user", JSON.stringify(res.data.user));
  }

  return res.data;
};

/**
 * Logout user
 */
export const logoutUser = async () => {
  const token = localStorage.getItem("token");
  if (!token) return;

  await axios.post(
    `${API_URL}/logout`,
    {},
    {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    }
  );

  localStorage.removeItem("token");
  localStorage.removeItem("user");
};
