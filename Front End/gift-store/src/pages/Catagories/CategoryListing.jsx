import React, { useEffect, useState, useMemo } from "react";
import { useParams, useNavigate } from "react-router-dom";
import axios from "axios";
import { Container, Row, Col, Card, Button, Spinner, Form } from "react-bootstrap";
import { motion, AnimatePresence } from "framer-motion";
import { Heart } from "lucide-react";
import "../../styles/Weapons/NarutoWeapons.css";
import { useWishlist } from "../../context/WishlistContext";
import { useCart } from "../../context/CartContext";

export default function CategoryListing() {
  const { id } = useParams();
  const navigate = useNavigate();

  const { wishlist, addToWishlist } = useWishlist();
  const { addToCart } = useCart();

  const [products, setProducts] = useState([]);
  const [filtered, setFiltered] = useState([]);
  const [visibleCount, setVisibleCount] = useState(8);
  const [loading, setLoading] = useState(true);

  // Filter states
  const [search, setSearch] = useState("");
  const [sort, setSort] = useState("");
  const [priceRange, setPriceRange] = useState("");
  const [discount, setDiscount] = useState("");
  const [inStockOnly, setInStockOnly] = useState(false);

  useEffect(() => {
    window.scrollTo(0, 0);
    axios
      .get(`http://127.0.0.1:8001/api/products/category/${id}`)
      .then((res) => {
        setProducts(res.data);
        setFiltered(res.data);
        setLoading(false);
      });
  }, [id]);

  // Apply Filters
  useEffect(() => {
    let data = [...products];

    // Search filter
    if (search.trim() !== "") {
      data = data.filter((p) =>
        p.name.toLowerCase().includes(search.toLowerCase())
      );
    }

    // Price filter
    if (priceRange === "0-499") data = data.filter((p) => p.current_sale_price < 500);
    if (priceRange === "500-999") data = data.filter((p) => p.current_sale_price >= 500 && p.current_sale_price <= 999);
    if (priceRange === "1000-1999") data = data.filter((p) => p.current_sale_price >= 1000 && p.current_sale_price <= 1999);
    if (priceRange === "2000+") data = data.filter((p) => p.current_sale_price >= 2000);

    // Discount filter
    if (discount !== "") {
      data = data.filter((p) => p.discount >= parseInt(discount));
    }

    // Stock filter
    if (inStockOnly) {
      data = data.filter((p) => !p.soldOut);
    }

    // Sorting
    if (sort === "low-high") {
      data.sort((a, b) => a.current_sale_price - b.current_sale_price);
    }
    if (sort === "high-low") {
      data.sort((a, b) => b.current_sale_price - a.current_sale_price);
    }
    if (sort === "discount") {
      data.sort((a, b) => b.discount - a.discount);
    }

    setFiltered(data);
    setVisibleCount(8);
  }, [search, priceRange, discount, sort, inStockOnly, products]);

  const handleAddToCart = (item) => {
    if (!item.soldOut) addToCart(item, 1);
  };

  const handleWishlist = (item) => addToWishlist(item);

  const handleLoadMore = () =>
    setVisibleCount((prev) => Math.min(prev + 4, filtered.length));

  if (loading) {
    return (
      <div className="loading-center">
        <Spinner animation="border" variant="danger" />
      </div>
    );
  }

  return (
    <div className="wooden-katana-page">
      <div className="naruto-weapons-banner">
        <h1 className="banner-text">Category Products</h1>
      </div>

      <Container fluid className="py-5">
        <Row>
          {/* LEFT FILTER SIDEBAR */}
          <Col lg={3} md={4} className="mb-4">
            <Card className="p-3 shadow-sm">

              {/* Search */}
              <h5 className="fw-bold">Filter By</h5>
              <Form.Control
                type="text"
                placeholder="Search product..."
                value={search}
                onChange={(e) => setSearch(e.target.value)}
                className="mb-3"
              />

              {/* Sort */}
              <h5 className="fw-bold mt-3">Sort By</h5>
              <Form.Select value={sort} onChange={(e) => setSort(e.target.value)}>
                <option value="">Default</option>
                <option value="low-high">Price: Low to High</option>
                <option value="high-low">Price: High to Low</option>
                <option value="discount">Best Discount</option>
              </Form.Select>

              {/* Price Range */}
              <h5 className="fw-bold mt-4">Price Range</h5>
              <Form.Check
                type="radio"
                label="Under ₹499"
                name="price"
                onChange={() => setPriceRange("0-499")}
              />
              <Form.Check
                type="radio"
                label="₹500 - ₹999"
                name="price"
                onChange={() => setPriceRange("500-999")}
              />
              <Form.Check
                type="radio"
                label="₹1000 - ₹1999"
                name="price"
                onChange={() => setPriceRange("1000-1999")}
              />
              <Form.Check
                type="radio"
                label="Above ₹2000"
                name="price"
                onChange={() => setPriceRange("2000+")}
              />
              <Form.Check
                type="radio"
                label="Clear Filters"
                name="price"
                onChange={() => setPriceRange("")}
              />

              {/* Discount */}
              <h5 className="fw-bold mt-4">Discount</h5>
              <Form.Check
                type="radio"
                label="10% or more"
                name="discount"
                onChange={() => setDiscount("10")}
              />
              <Form.Check
                type="radio"
                label="20% or more"
                name="discount"
                onChange={() => setDiscount("20")}
              />
              <Form.Check
                type="radio"
                label="30% or more"
                name="discount"
                onChange={() => setDiscount("30")}
              />
              <Form.Check
                type="radio"
                label="Clear Discount"
                name="discount"
                onChange={() => setDiscount("")}
              />

              {/* Stock */}
              <h5 className="fw-bold mt-4">Stock</h5>
              <Form.Check
                type="checkbox"
                label="In Stock Only"
                checked={inStockOnly}
                onChange={() => setInStockOnly(!inStockOnly)}
              />
            </Card>
          </Col>

          {/* PRODUCT LISTING */}
          <Col lg={9} md={8}>
            {filtered.length === 0 ? (
              <p className="text-center text-muted">No products found.</p>
            ) : (
              <Row className="g-4">
                <AnimatePresence>
                  {filtered.slice(0, visibleCount).map((item) => (
                    <Col key={item.id} xs={12} sm={6} md={4} lg={3}>
                      <motion.div whileHover={{ scale: 1.05 }} transition={{ duration: 0.3 }}>
                        <Card className="katana-card text-center">

                          {item.discount > 0 && (
                            <div className="discount-badge">-{item.discount}%</div>
                          )}

                          <div
                            className="image-container"
                            onClick={() => navigate(`/category/details/${item.id}`)}
                            style={{ cursor: "pointer" }}
                          >
                            <img
                              src={`http://127.0.0.1:8001/${item.image_path}`}
                              alt={item.name}
                              className="katana-img"
                            />
                            {item.soldOut && <div className="sold-out-badge">SOLD OUT</div>}
                          </div>

                          <Card.Body>
                            <Card.Title
                              className="text-danger small fw-bold"
                              style={{ cursor: "pointer" }}
                              onClick={() => navigate(`/category/details/${item.id}`)}
                            >
                              {item.name}
                            </Card.Title>

                            <div className="price-section">
                              <span className="price text-danger fw-bold">
                                ₹{item.current_sale_price}
                              </span>
                              <span className="old-price text-muted text-decoration-line-through">
                                ₹{item.previous_sale_price}
                              </span>
                            </div>

                            <div className="d-flex gap-2 mt-3 justify-content-between">
                              <Button
                                variant="outline-light text-black"
                                className="w-50 d-flex align-items-center justify-content-center gap-2"
                                onClick={(e) => {
                                  e.stopPropagation();
                                  handleWishlist(item);
                                }}
                              >
                                <Heart
                                  size={18}
                                  fill={
                                    wishlist.some((w) => w.product_id === item.id) ? "red" : "none"
                                  }
                                  color={
                                    wishlist.some((w) => w.product_id === item.id) ? "red" : "black"
                                  }
                                />

                                Wishlist
                              </Button>

                              <Button
                                disabled={item.soldOut}
                                variant={item.soldOut ? "secondary" : "warning"}
                                className="w-50"
                                onClick={(e) => {
                                  e.stopPropagation();
                                  handleAddToCart(item);
                                }}
                              >
                                {item.soldOut ? "Sold Out" : "Add to Cart"}
                              </Button>
                            </div>
                          </Card.Body>
                        </Card>
                      </motion.div>
                    </Col>
                  ))}
                </AnimatePresence>
              </Row>
            )}

            {/* Load More */}
            {visibleCount < filtered.length && (
              <div className="text-center mt-4">
                <motion.button
                  onClick={handleLoadMore}
                  className="load-more-btn px-4 py-2 fw-bold"
                  whileHover={{ scale: 1.05 }}
                  whileTap={{ scale: 0.95 }}
                >
                  Load More
                </motion.button>
              </div>
            )}
          </Col>
        </Row>
      </Container>
    </div>
  );
}
