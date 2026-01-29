import React from "react";
import { useParams, useNavigate } from "react-router-dom";
import { Container, Card, Button } from "react-bootstrap";
import axios from "axios";
import { toast } from "react-toastify";
import { expensiveItems } from "../data/expensiveItems";
import { useCart } from "../context/CartContext";

export default function ProductDetails() {
  const { id } = useParams();
  const navigate = useNavigate();
  const { addToCart } = useCart();

  // ✅ Find product by ID
  const product = expensiveItems.find((item) => item.id === parseInt(id));

  if (!product) {
    return (
      <Container className="py-5 text-center">
        <h2>❌ Product Not Found</h2>
        <Button variant="primary" onClick={() => navigate("/")}>
          Back to Home
        </Button>
      </Container>
    );
  }

  const handleAddToCart = async () => {
    try {
      // 1️⃣ Add locally to your React cart context (frontend cart)
      addToCart(product, 1);

      // 2️⃣ Send product to Laravel backend
      const res = await axios.post("http://127.0.0.1:8000/cart/add", {
        product_id: product.id,
        quantity: 1,
      });

      // 3️⃣ Success message
      toast.success(res.data.message || `"${product.title}" added to cart!`, {
        autoClose: 1500,
        position: "top-right",
      });
    } catch (error) {
      console.error(error);
      toast.error("Failed to add to cart!");
    }
  };

  return (
    <Container className="py-5">
      <Card className="shadow-lg border-0">
        <div className="row g-0 align-items-center">
          {/* 🖼 Left: Product Image */}
          <div className="col-md-6 text-center p-4">
            <img
              src={product.img}
              alt={product.title}
              style={{ width: "inherit", borderRadius: "12px" }}
            />
          </div>

          {/* 🧾 Right: Product Info */}
          <div className="col-md-6 p-4">
            <Card.Body>
              <Card.Title className="fs-3 fw-bold">{product.title}</Card.Title>
              <p className="text-muted">
                {product.description || "Premium collectible item."}
              </p>

              <div className="d-flex gap-3 align-items-center mb-3">
                <h4 className="text-danger fw-bold mb-0">₹{product.price}.00</h4>
                <h6 className="text-decoration-line-through text-muted mb-0">
                  ₹{product.oldPrice}.00
                </h6>
              </div>

              <Button variant="success" onClick={handleAddToCart}>
                Add to Cart
              </Button>{" "}
              <Button variant="outline-secondary" onClick={() => navigate(-1)}>
                Go Back
              </Button>
            </Card.Body>
          </div>
        </div>
      </Card>
    </Container>
  );
}
