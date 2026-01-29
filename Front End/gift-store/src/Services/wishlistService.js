import axios from "axios";

const API_BASE = "http://127.0.0.1:8001/api";

// ADD to wishlist
export const addWishlistAPI = (productId, userId) => {
  return axios.post(`${API_BASE}/wishlist`, {
    user_id: userId,
    product_id: productId,
  });
};

// GET wishlist
export const getWishlistAPI = (userId) => {
  return axios.get(`${API_BASE}/wishlist`, {
    params: { user_id: userId },
  });
};

// REMOVE item from wishlist
export const removeWishlistAPI = (wishlistId) => {
  return axios.delete(`${API_BASE}/wishlist/${wishlistId}`);
};
