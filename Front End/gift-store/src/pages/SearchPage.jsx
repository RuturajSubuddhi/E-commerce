import React, { useState, useEffect } from "react";
import { Container, Row, Col, Form, Card, Button } from "react-bootstrap";
import axios from "axios";
import { toast } from "react-toastify";
import { useCart } from "../context/CartContext"
import { useNavigate } from "react-router-dom";

export default function SearchPage() {
  const [query, setQuery] = useState("");
  const [products, setProducts] = useState([]);
  const [loading, setLoading] = useState(false);
 const { addToCart } = useCart();
 const navigate = useNavigate();
 

  useEffect(() => {
    if (!query.trim()) {
      setProducts([]);
      return;
    }

    const fetchProducts = async () => {
      setLoading(true);
      try {
        const res = await axios.get(
          `http://127.0.0.1:8001/api/products/search?q=${query}`
        );

        // if (res.data?.status && Array.isArray(res.data.products)) {
        //   setProducts(res.data.products);
        // } else {
        //   setProducts([]);
        // }
        if (res.data?.status === true) {
          setProducts(res.data.data || []);
        } else {
          setProducts([]);
        }
      } catch (err) {
        console.error(err);
        toast.error("Search failed");
        setProducts([]);
      } finally {
        setLoading(false);
      }
    };

    const delay = setTimeout(fetchProducts, 400);
    return () => clearTimeout(delay);
  }, [query]);

  return (
    <Container className="py-4">
      <Form.Control
        type="text"
        placeholder="Search for products..."
        value={query}
        onChange={(e) => setQuery(e.target.value)}
      />

      <Row className="mt-4">
        {loading && <p>Searching...</p>}

        {!loading && query && products.length === 0 && <p>No products found</p>}

        <Container className="py-5">
          {/* <h2 className="mb-4 text-center">Expensive Items</h2> */}

          <Row xs={1} sm={2} md={3} lg={4} className="g-4">
            {products.map((product) => (
              <Col key={product.id}>
                <Card className="h-100 shadow-sm">
                  <Card.Img
                    variant="top"
                    src={`http://127.0.0.1:8001/${product.image_path}`}
                    alt={product.name}
                    style={{
                      height: "200px",
                      objectFit: "contain",
                      cursor: "pointer",
                    }}
                    onClick={() => navigate(`/category/details/${product.id}`)}
                  />

                  <Card.Body className="d-flex flex-column">
                    <Card.Title
                      style={{ cursor: "pointer" }}
                      onClick={() =>
                        navigate(`/category/details/${product.id}`)
                      }
                    >
                      {product.name}
                    </Card.Title>

                    <div className="mt-auto d-flex justify-content-between align-items-center">
                      <div>
                        <span className="text-danger fw-bold">
                          ₹{product.current_sale_price}
                        </span>
                        {product.old_price && (
                          <span className="text-muted text-decoration-line-through ms-2">
                            ₹{product.old_price}
                          </span>
                        )}
                      </div>

                      <Button
                        size="sm"
                        variant="success"
                        onClick={() => addToCart(product, 1)}
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

        {/* {products.map((product) => (
          <Col md={3} key={product.id} className="mb-3">
            <Card>
              <Card.Img
                variant="top"
                src={
                  product.image_path
                    ? `http://127.0.0.1:8001/${product.image_path}`
                    : "/assets/no-image.png"
                }
              />
              <Card.Body>
                <Card.Title>{product.name}</Card.Title>
                <p>₹{product.current_sale_price}</p>
              </Card.Body>
            </Card>
          </Col>
        ))} */}
      </Row>
    </Container>
  );
}
