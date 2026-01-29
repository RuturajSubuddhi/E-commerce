import React, { useEffect, useState } from "react";
import { Container, Row, Col, Card, Button } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import { useCart } from "../context/CartContext";

export default function AllExpensiveItems() {
  const navigate = useNavigate();
  const { addToCart } = useCart();

  const [expensiveItems, setExpensiveItems] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch("http://127.0.0.1:8001/api/products")
      .then((res) => res.json())
      .then((data) => {
        const filtered = data.filter(
          (item) => Number(item.current_sale_price) > 1000
        );
        setExpensiveItems(filtered);
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

  return (
    <Container className="py-5">
      <h2 className="mb-4 text-center">Expensive Items</h2>

      <Row xs={1} sm={2} md={3} lg={4} className="g-4">
        {expensiveItems.map((item) => (
          <Col key={item.id}>
            <Card className="h-100 shadow-sm">

              <Card.Img
                variant="top"
                src={`http://127.0.0.1:8001/${item.image_path}`}
                alt={item.name}
                style={{ height: "200px", objectFit: "contain", cursor: "pointer" }}
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

                  <Button
                    size="sm"
                    variant="success"
                    onClick={() => addToCart(item, 1)}
                  >
                    Add
                  </Button>
                </div>

              </Card.Body>
            </Card>
          </Col>
        ))}
      </Row>
    </Container>
  );
}
