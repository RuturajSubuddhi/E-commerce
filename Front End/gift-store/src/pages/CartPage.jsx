import React, { useState, useEffect } from "react";
import { useCart } from "../context/CartContext";
import { Link, useNavigate } from "react-router-dom";
import { Button, Modal } from "react-bootstrap";
import { motion, AnimatePresence } from "framer-motion";
import "../styles/CartPage.css";

export default function CartPage() {
  const { cart, removeFromCart, clearCart, fetchCart } = useCart();
  const navigate = useNavigate();

  const [showRemoveModal, setShowRemoveModal] = useState(false);
  const [showClearModal, setShowClearModal] = useState(false);
  const [itemToRemove, setItemToRemove] = useState(null);

  const total = cart.reduce(
    (sum, item) => sum + item.current_sale_price * item.qty,
    0
  );
  useEffect(() => {
    fetchCart();  // 🎯 load cart from API on page load
  }, []);

  const handleRemoveClick = (item) => {
    setItemToRemove(item);
    setShowRemoveModal(true);
  };

  const confirmRemove = async () => {
    if (itemToRemove) {
      await removeFromCart(itemToRemove.id); // calls backend + updates UI
      setShowRemoveModal(false);
      setItemToRemove(null);
    }
  };

  const confirmClear = async () => {
    await clearCart(); // calls backend + updates UI
    setShowClearModal(false);
  };

  return (
    <div className="cart-page-container py-5">
      <motion.h2
        className="text-center fw-bold mb-4 text-dark"
        initial={{ opacity: 0, y: -20 }}
        animate={{ opacity: 1, y: 0 }}
      >
        🛒 Your Cart
      </motion.h2>

      {cart.length === 0 ? (
        <motion.div
          className="text-center empty-cart"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
        >
          <p className="fs-5 text-dark">Your cart is empty.</p>
          <Link to="/" className="btn btn-outline-dark mt-3">
            Continue Shopping
          </Link>
        </motion.div>
      ) : (
        <div className="cart-list mx-auto">
          <AnimatePresence>
            {cart.map((item) => (
              <motion.div
                key={item.id}
                className="cart-item d-flex justify-content-between align-items-center p-3 mb-3 rounded-4"
                initial={{ opacity: 0, y: 20 }}
                animate={{ opacity: 1, y: 0 }}
                exit={{ opacity: 0, y: -10 }}
                transition={{ duration: 0.3 }}
              >
                <div className="d-flex align-items-center gap-3">
                  <img
                    src={`http://127.0.0.1:8001/${item.image_path}`}
                    alt={item.name}
                    className="cart-item-img rounded-3"
                  />
                  <div>
                    <h6 className="text-uppercase fw-bold text-dark">
                      {item.name}
                    </h6>
                    <p className="text-dark small">Qty: {item.qty}</p>
                  </div>
                </div>

                <div className="d-flex gap-3 align-items-center">
                  <span className="fw-bold fs-5 text-success">
                    ₹{item.current_sale_price * item.qty}
                  </span>
                  <Button
                    variant="outline-danger"
                    size="sm"
                    onClick={() => handleRemoveClick(item)}
                    className="remove-btn"
                  >
                    ✖
                  </Button>
                </div>
              </motion.div>
            ))}
          </AnimatePresence>

          <motion.div
            className="text-end mt-4"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
          >
            <h4 className="fw-bold text-dark">
              Total: <span className="text-success">₹{total}</span>
            </h4>
          </motion.div>

          <motion.div
            className="d-flex justify-content-center gap-3 mt-4"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
          >
            <Button
              variant="outline-warning"
              onClick={() => setShowClearModal(true)}
              className="action-btn"
            >
              Clear Cart
            </Button>
            <Button
              variant="success"
              onClick={() => navigate("/checkout")}
              className="action-btn"
            >
              Proceed to Checkout →
            </Button>
          </motion.div>
        </div>
      )}

      {/* Remove Modal */}
      <Modal
        show={showRemoveModal}
        onHide={() => {
          setShowRemoveModal(false);
          setItemToRemove(null);
        }}
        centered
      >
        <Modal.Header closeButton className="bg-danger text-white">
          <Modal.Title>Confirm Remove</Modal.Title>
        </Modal.Header>
        <Modal.Body className="bg-dark text-light">
          Are you sure you want to remove{" "}
          <b>{itemToRemove?.name}</b> from your cart?
        </Modal.Body>
        <Modal.Footer className="bg-dark">
          <Button
            variant="secondary"
            onClick={() => {
              setShowRemoveModal(false);
              setItemToRemove(null);
            }}
          >
            Cancel
          </Button>
          <Button variant="danger" onClick={confirmRemove}>
            Remove
          </Button>
        </Modal.Footer>
      </Modal>

      {/* Clear Modal */}
      <Modal
        show={showClearModal}
        onHide={() => setShowClearModal(false)}
        centered
      >
        <Modal.Header closeButton className="bg-danger text-white">
          <Modal.Title>Confirm Clear Cart</Modal.Title>
        </Modal.Header>
        <Modal.Body className="bg-dark text-light">
          Are you sure you want to clear your entire cart?
        </Modal.Body>
        <Modal.Footer className="bg-dark">
          <Button variant="secondary" onClick={() => setShowClearModal(false)}>
            Cancel
          </Button>
          <Button variant="warning" onClick={confirmClear}>
            Clear Cart
          </Button>
        </Modal.Footer>
      </Modal>
    </div>
  );
}
