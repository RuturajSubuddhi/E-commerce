import React, { useState, useEffect } from "react";
import { Container, Row, Col, Card, Button } from "react-bootstrap";
import { useCart } from "../../../context/CartContext";
import { motion, AnimatePresence } from "framer-motion";
import "../../../styles/Weapons/NarutoWeapons.css";
import { Heart } from "lucide-react";
import { useNavigate, useParams } from "react-router-dom";
import axios from "axios";
import { useWishlist } from "../../../context/WishlistContext";

export default function DeskMateProductsList() {
    const { addToCart } = useCart();
    const { wishlist, addToWishlist } = useWishlist();
    const navigate = useNavigate();

    const [products, setProducts] = useState([]);
    const [visibleCount, setVisibleCount] = useState(6);
    const [subcategory, setSubcategory] = useState([]);


    const { subcategoryId } = useParams();

    // Mapping subcategory → title/banner
    const titleMap = {

        82: "Jujutsu Kaisen DeskMates",
        83: "Naruto DeskMates",
        84: "One Piece DeskMates",
        85: "Berserk DeskMates",
        86: "Demon Slayer DeskMates",
        87: "Dragon Ball Z DeskMates",
    };

    const pageTitle = titleMap[subcategoryId] || "Weapons";

    useEffect(() => {
        axios
            .get(`http://127.0.0.1:8001/api/products/subcategory/${subcategoryId}`)
            .then((res) => {
                setProducts(res.data.products);
                if (res.data.products.length > 0) {
                    setSubcategory(res.data.products[0].product_subcategory);
                }
            })

            .catch((err) => console.error("Error fetching:", err));
    }, [subcategoryId]);

    const handleAddToCart = (item) => {
        if (!item.soldOut) addToCart(item, 1);
    };

    const handleWishlist = (item) => addToWishlist(item);

    const handleLoadMore = () =>
        setVisibleCount((prev) => Math.min(prev + 4, products.length));

    return (
        <div className="wooden-katana-page">

            {/* 🔥 Dynamic Banner */}
            {/* <div className="naruto-weapons-banner">
                <h1 className="banner-text">{pageTitle}</h1>
            </div> */}

            <div
                className="naruto-weapons-banner"
                style={{
                    backgroundImage: `url(http://127.0.0.1:8001/${subcategory?.image})`,
                    backgroundSize: "cover",
                    backgroundPosition: "center",
                    backgroundRepeat: "no-repeat",
                    height: "45vh",
                    width: "100%"
                }}
            >
                <h1 className="banner-text">{subcategory?.name || pageTitle}</h1>
            </div>

            <Container className="py-5">
                <Row className="g-4">
                    <AnimatePresence>
                        {products.slice(0, visibleCount).map((item) => (
                            <Col key={item.id} xs={12} sm={6} md={4} lg={3}>
                                <motion.div whileHover={{ scale: 1.05 }} transition={{ duration: 0.3 }}>
                                    <Card className="katana-card text-center">

                                        {/* Discount badge */}
                                        {item.discount > 0 && (
                                            <div className="discount-badge">-{item.discount}%</div>
                                        )}

                                        {/* Image */}
                                        <div
                                            className="image-container"
                                            style={{ cursor: "pointer" }}
                                            onClick={() => navigate(`/catagories/Weapons/details/${item.id}`)}
                                        >
                                            <img
                                                src={`http://127.0.0.1:8001/${item.image_path}`}
                                                alt={item.name}
                                                className="katana-img"
                                            />

                                            {item.soldOut && <div className="sold-out-badge">SOLD OUT</div>}
                                        </div>

                                        <Card.Body>
                                            {/* Title */}
                                            <Card.Title
                                                className="text-danger small fw-bold"
                                                style={{ cursor: "pointer" }}
                                                onClick={() => navigate(`/catagories/Weapons/details/${item.id}`)}
                                            >
                                                {item.name}
                                            </Card.Title>

                                            {/* Price */}
                                            <div className="price-section">
                                                <span className="price text-danger fw-bold">
                                                    ₹{item.current_sale_price}
                                                </span>
                                                <span className="old-price text-muted text-decoration-line-through">
                                                    ₹{item.previous_sale_price}
                                                </span>
                                            </div>

                                            {/* Buttons */}
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

                {/* Load More Button */}
                {visibleCount < products.length && (
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
            </Container>

            <div className="led-katana-banner2"></div>
        </div>
    );
}
