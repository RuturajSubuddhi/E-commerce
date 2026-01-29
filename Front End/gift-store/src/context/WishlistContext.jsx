// import React, { createContext, useContext, useState, useEffect } from "react";
// import { toast } from "react-toastify";

// const WishlistContext = createContext();

// export function WishlistProvider({ children }) {
//   const [wishlist, setWishlist] = useState(() => {
//     // const storedWishlist = localStorage.getItem("wishlist");
//     // return storedWishlist ? JSON.parse(storedWishlist) : [];
//     const user = JSON.parse(localStorage.getItem("user"));
//     const userId = user?.id;
//   });

//   useEffect(() => {
//     localStorage.setItem("wishlist", JSON.stringify(wishlist));
//   }, [wishlist]);

//   const addToWishlist = (item) => {
//     setWishlist((prev) => {
//       const exists = prev.some((w) => w.id === item.id);
//       if (exists) {
//         toast.info(`💔 "${item.name}" is already in your wishlist`);
//         return prev;
//       }
//       toast.success(`❤️ Added "${item.name}" to wishlist`);
//       return [...prev, item];
//     });
//   };

//   const removeFromWishlist = (id) => {
//     setWishlist((prev) => {
//       const removedItem = prev.find((w) => w.id === id);
//       toast.info(`💔 Removed "${removedItem?.name || "item"}" from wishlist`);
//       return prev.filter((item) => item.id !== id);
//     });
//   };

//   return (
//     <WishlistContext.Provider
//       value={{ wishlist, addToWishlist, removeFromWishlist }}
//     >
//       {children}
//     </WishlistContext.Provider>
//   );
// }

// export function useWishlist() {
//   return useContext(WishlistContext);
// }
// src/context/WishlistContext.jsx
import React, { createContext, useContext, useEffect, useState } from "react";
import axios from "axios";
import { toast } from "react-toastify";

const WishlistContext = createContext();
export const useWishlist = () => useContext(WishlistContext);

export function WishlistProvider({ children }) {
  const [wishlist, setWishlist] = useState([]);

  const user = JSON.parse(localStorage.getItem("user"));
  const userId = user?.id;

  useEffect(() => {
    if (userId) fetchWishlist();
  }, [userId]);

  // -------------------------------
  // FETCH WISHLIST (POST API)
  // -------------------------------
  const fetchWishlist = async () => {
    try {
      const response = await axios.post("http://127.0.0.1:8001/api/wishlist/list", {
        user_id: userId,
      });

      if (Array.isArray(response.data.wishlist)) {
        setWishlist(response.data.wishlist);
      }
    } catch (error) {
      console.log("Wishlist load error:", error);
    }
  };

  // -------------------------------
  // ADD TO WISHLIST
  // -------------------------------
  const addToWishlist = async (product) => {
    if (!userId) return toast.error("Please login first");

    const exists = wishlist.some((w) => w.product_id === product.id);
    if (exists) {
      toast.info(`${product.name} is already in wishlist`);
      return;
    }

    try {
      const response = await axios.post("http://127.0.0.1:8001/api/wishlist/add", {
        user_id: userId,
        product_id: product.id,
      });

      if (response.data.status === 200) {
        toast.success(`❤️ Added "${product.name}"`);
        fetchWishlist();
      }
    } catch (error) {
      console.log(error);
      toast.error("Failed to add to wishlist");
    }
  };

  // -------------------------------
  // REMOVE FROM WISHLIST
  // -------------------------------
  const removeFromWishlist = async (productId) => {
    try {
      const response = await axios.post("http://127.0.0.1:8001/api/wishlist/remove", {
        user_id: userId,
        product_id: productId,
      });

      if (response.data.success || response.data.status === 200) {
        setWishlist((prev) => prev.filter((i) => i.product_id !== productId));
        toast.info("💔 Removed from wishlist");
      }
    } catch (error) {
      console.log(error);
      toast.error("Failed to remove");
    }
  };

  return (
    <WishlistContext.Provider
      value={{
        wishlist,
        addToWishlist,
        removeFromWishlist,
        fetchWishlist,
      }}
    >
      {children}
    </WishlistContext.Provider>
  );
}
