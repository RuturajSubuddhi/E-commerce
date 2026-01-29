import React, { useEffect, useState } from "react";
import { Container, Row, Col, Card, Button } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import { useCart } from "../context/CartContext";
import { Heart } from "lucide-react";
import { useWishlist } from "../context/WishlistContext";

const LOAD_STEP = 8; // 👈 STEP SIZE

export default function ViewAllItems() {
  const navigate = useNavigate();
  const { addToCart } = useCart();
  const { wishlist, addToWishlist } = useWishlist();

  const [items, setItems] = useState([]);
  const [loading, setLoading] = useState(true);
  const [visibleCount, setVisibleCount] = useState(LOAD_STEP); // 👈 START WITH 8

  useEffect(() => {
    fetch("http://127.0.0.1:8001/api/products")
      .then((res) => res.json())
      .then((data) => {
        const filtered = data.filter(
          (item) => Number(item.current_sale_price) < 299
        );
        setItems(filtered);
        setLoading(false);
      })
      .catch((err) => {
        console.error("Failed to load products", err);
        setLoading(false);
      });
  }, []);

  if (loading) {
    return <h4 className="text-center mt-5">Loading...</h4>;
  }

  // 🔥 LOAD MORE HANDLER
  const handleLoadMore = () => {
    setVisibleCount((prev) => prev + LOAD_STEP);
  };

  return (
    <section className="bg-dark text-light py-5">
      <Container>
        {/* Header */}
        <div className="d-flex justify-content-between align-items-center mb-4">
          <h2 className="mb-0">All Budget Items</h2>
          <Button variant="outline-light" onClick={() => navigate(-1)}>
            ← Back
          </Button>
        </div>

        <Row xs={1} sm={2} md={3} lg={4} className="g-4">
          {items.slice(0, visibleCount).map((item) => (
            <Col key={item.id}>
              <Card className="h-100 shadow-sm text-dark">
                <Card.Img
                  variant="top"
                  src={`http://127.0.0.1:8001/${item.image_path}`}
                  alt={item.name}
                  style={{
                    height: "200px",
                    objectFit: "contain",
                    cursor: "pointer",
                  }}
                  onClick={() => navigate(`/category/details/${item.id}`)}
                />

                <Card.Body className="d-flex flex-column">
                  <Card.Title
                    style={{ cursor: "pointer" }}
                    onClick={() => navigate(`/category/details/${item.id}`)}
                  >
                    {item.name}
                  </Card.Title>

                  <div className="mt-auto d-flex justify-content-between align-items-center">
                    <div>
                      <span className="text-danger fw-bold">
                        ₹{item.current_sale_price}
                      </span>
                      {item.old_price && (
                        <span className="text-muted text-decoration-line-through ms-2">
                          ₹{item.old_price}
                        </span>
                      )}
                    </div>

                    <div className="d-flex gap-2">
                      <Button
                        size="sm"
                        variant="success"
                        onClick={() => addToCart(item, 1)}
                      >
                        Add
                      </Button>

                      <Button
                        size="sm"
                        variant="outline-dark"
                        onClick={() => addToWishlist(item)}
                      >
                        <Heart
                          size={16}
                          fill={
                            wishlist.some((w) => w.product_id === item.id)
                              ? "red"
                              : "none"
                          }
                          color={
                            wishlist.some((w) => w.product_id === item.id)
                              ? "red"
                              : "black"
                          }
                        />
                      </Button>
                    </div>
                  </div>
                </Card.Body>
              </Card>
            </Col>
          ))}
        </Row>

        {/* ✅ LOAD MORE BUTTON */}
        {visibleCount < items.length && (
          <div className="text-center mt-5">
            <Button
              variant="light"
              className="fw-bold px-5"
              onClick={handleLoadMore}
            >
              Load More
            </Button>
          </div>
        )}
      </Container>
    </section>
  );
}
