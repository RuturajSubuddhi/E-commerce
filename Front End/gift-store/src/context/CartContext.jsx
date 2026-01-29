// src/context/CartContext.jsx
import React, { createContext, useContext, useState, useEffect } from "react";
import { toast } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const CartContext = createContext();
export const useCart = () => useContext(CartContext);

export function CartProvider({ children }) {
  const [cart, setCart] = useState([]);

  const user = JSON.parse(localStorage.getItem("user"));
  const userId = user?.id;

  // =========================
  // ADD TO CART
  // =========================
  const addToCart = async (product, qty = 1) => {
    if (!userId) {
      toast.error("Please login first");
      return;
    }

    if (!product?.id) {
      toast.error("Invalid product");
      return;
    }

    try {
      const res = await fetch("http://127.0.0.1:8001/api/cart/add", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({
          user_id: userId,
          product_id: product.id,
          quantity: qty,
        }),
      });

      const data = await res.json();

      if (!res.ok) {
        if (data.message) {
          toast.warning(data.message); // 🔥 Insufficient stock
        } else {
          toast.error("Unable to add product");
        }
        return;
      }

      toast.success(`${product.name} added to cart`);

      // 🔄 ALWAYS sync from server
      fetchCart();
    } catch (error) {
      console.error("Add cart error:", error);
      toast.error("Something went wrong");
    }
  };

  // =========================
  // FETCH CART
  // =========================
  const fetchCart = async () => {
    if (!userId) return;

    try {
      const res = await fetch("http://127.0.0.1:8001/api/cart/list", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({ user_id: userId }),
      });

      const data = await res.json();

      if (res.ok && data.success) {
        const formatted = data.cart.map((item) => ({
          id: item.product_id,
          qty: item.quantity,
          name: item.product?.name,
          current_sale_price: item.product?.current_sale_price,
          image_path: item.product?.image_path,
        }));

        setCart(formatted);
      } else {
        setCart([]);
      }
    } catch (error) {
      console.error("Fetch cart error:", error);
    }
  };

  // =========================
  // REMOVE FROM CART
  // =========================
  const removeFromCart = async (productId) => {
    if (!userId) return;

    try {
      const res = await fetch("http://127.0.0.1:8001/api/cart/remove", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({
          user_id: userId,
          product_id: productId,
        }),
      });

      const data = await res.json();

      if (res.ok && data.success) {
        toast.info("Item removed");
        fetchCart();
      }
    } catch (error) {
      console.error("Remove cart error:", error);
    }
  };

  // =========================
  // CLEAR CART
  // =========================
  const clearCart = async () => {
    if (!userId) return;

    try {
      const res = await fetch("http://127.0.0.1:8001/api/cart/clear", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({ user_id: userId }),
      });

      const data = await res.json();

      if (res.ok && data.success) {
        setCart([]);
        toast.warn("Cart cleared");
      }
    } catch (error) {
      console.error("Clear cart error:", error);
    }
  };

  // =========================
  // AUTO LOAD CART
  // =========================
  useEffect(() => {
    if (userId) {
      fetchCart();
    } else {
      setCart([]);
    }
  }, [userId]);

  return (
    <CartContext.Provider
      value={{
        cart,
        addToCart,
        removeFromCart,
        clearCart,
        fetchCart,
      }}
    >
      {children}
    </CartContext.Provider>
  );
}
