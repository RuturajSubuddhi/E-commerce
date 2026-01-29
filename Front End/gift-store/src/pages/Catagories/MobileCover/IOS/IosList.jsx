import React, { useState } from "react";
import { Container, Row, Col, Card, Button } from "react-bootstrap";
import { useCart } from "../../../../context/CartContext";
import { toast } from "react-toastify";
import { motion, AnimatePresence } from "framer-motion";
import "../../../../styles/MobileCover/Ios.css";
import { Heart } from "lucide-react";
import { useNavigate } from "react-router-dom";
import { iosData } from "../../../../data/MobileCover/iOSData";
import { useWishlist } from "../../../../context/WishlistContext";


export default function IOSPage() {
    const { addToCart } = useCart();
    const [visibleCount, setVisibleCount] = useState(6); // Show 6 initially
    const { wishlist, addToWishlist } = useWishlist();
    const navigate = useNavigate();

    const handleAddToCart = (item) => {
        if (item.soldOut) return;
        addToCart(item, 1);
        // toast.success(`🛒 "${item.title}" added to cart!`);
    };
    const handleLoadMore = () => {
        setVisibleCount((prev) => prev + 6);
    };

    const handleWishlist = (item) => {
        addToWishlist(item);
    };
    return (
        <div className="wooden-katana-page">
            {/* 🖼️ Banner Section */}
            <div className="iphone-banner">
                {/* <h1 className="banner-text">LED KATANA</h1> */}
            </div>

            {/* 🔪 Product Grid */}
            <Container className="py-5">
                <div className="filter-section mb-4">
                    <h6 className="text-light">Filter by Manual ▼</h6>
                </div>

                <Row className="g-4">
                    <AnimatePresence>
                        {iosData.slice(0, visibleCount).map((item, index) => (
                            <Col key={item.id} xs={12} sm={6} md={4} lg={3}>
                                <motion.div
                                    whileHover={{ scale: 1.05 }}
                                    transition={{ duration: 0.3 }}
                                >
                                    <Card className="katana-card text-center">
                                        <div className="discount-badge">-{item.discount}%</div>
                                        <div className="image-container" style={{ cursor: "pointer" }}
                                            onClick={() => navigate(`/IOS/${item.id}`)}>
                                            <img src={item.img} alt={item.title} className="katana-img" />
                                            {item.soldOut && (
                                                <div className="sold-out-badge">SOLD OUT</div>
                                            )}
                                        </div>
                                        <Card.Body>
                                            <Card.Title className="text-danger small fw-bold" style={{ cursor: "pointer" }}
                                                onClick={() => navigate(`/IOS/${item.id}`)}>
                                                {item.title}
                                            </Card.Title>
                                            <div className="price-section">
                                                <span className="price text-danger fw-bold">₹{item.price}</span>{" "}
                                                <span className="old-price text-muted text-decoration-line-through">
                                                    ₹{item.oldPrice}
                                                </span>
                                            </div>
                                            {/* <Button
                                                disabled={item.soldOut}
                                                onClick={() => handleAddToCart(item)}
                                                variant={item.soldOut ? "secondary" : "danger"}
                                                className="mt-2 w-100"
                                            >
                                                {item.soldOut ? "Sold Out" : "Add to Cart"}
                                            </Button> */}
                                            {/* 🧡 Buttons Row */}
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
                                                        strokeWidth={2}
                                                        fill={
                                                            wishlist.some((w) => w.id === item.id)
                                                                ? "red"
                                                                : "none"
                                                        }
                                                        color={
                                                            wishlist.some((w) => w.id === item.id)
                                                                ? "red"
                                                                : "black"
                                                        }
                                                    />
                                                    Wishlist
                                                </Button>
                                                <Button
                                                    disabled={item.soldOut}
                                                    onClick={(e) => {
                                                        e.stopPropagation();
                                                        handleAddToCart(item);
                                                    }}
                                                    variant={item.soldOut ? "secondary" : "warning"}
                                                    className="mt-2 w-50"
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
                {/* 🔘 Load More Button */}
                {visibleCount < iosData.length && (
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
                )};
            </Container>
            <div className="led-katana-banner2">
                {/* <h1 className="banner-text">WOODEN KATANA</h1> */}
            </div>

        </div>
    );
}
