import { useParams, useNavigate } from "react-router-dom";
import { Container, Card, Button, Spinner } from "react-bootstrap";
import { useEffect, useState } from "react";
import { useCart } from "../context/CartContext";

export default function ItemDetails() {
  const { id } = useParams();
  const navigate = useNavigate();
  const { addToCart } = useCart();

  const [item, setItem] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    fetch(`http://127.0.0.1:8001/api/products/${id}`)
      .then(res => res.json())
      .then(data => {
        setItem(data);
        setLoading(false);
      })
      .catch(err => {
        console.error(err);
        setLoading(false);
      });
  }, [id]);

  if (loading) {
    return (
      <Container className="py-5 text-center">
        <Spinner animation="border" />
      </Container>
    );
  }

  if (!item) {
    return (
      <Container className="py-5 text-center">
        <h2>❌ Item not found</h2>
        <Button onClick={() => navigate(-1)}>Go Back</Button>
      </Container>
    );
  }

  return (
    <Container className="py-5">
      <Card className="shadow-lg border-0">
        <div className="row g-0 align-items-center">
          {/* Image */}
          <div className="col-md-6 text-center p-4">
            <img
              src={`http://127.0.0.1:8001/${item.image_path}`}
              alt={item.name}
              style={{ width: "100%", maxHeight: 400, objectFit: "contain" }}
            />
          </div>

          {/* Info */}
          <div className="col-md-6 p-4">
            <Card.Body>
              <Card.Title className="fs-3 fw-bold">{item.name}</Card.Title>

              <div className="d-flex gap-3 mb-3">
                <h4 className="text-danger fw-bold">
                  ₹{item.current_sale_price}
                </h4>
                {item.old_price && (
                  <h6 className="text-muted text-decoration-line-through">
                    ₹{item.old_price}
                  </h6>
                )}
              </div>

              <Button
                variant="success"
                onClick={() => addToCart(item, 1)}
                className="me-2"
              >
                Add to Cart
              </Button>

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
