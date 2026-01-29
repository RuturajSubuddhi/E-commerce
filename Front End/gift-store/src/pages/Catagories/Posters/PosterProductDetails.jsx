import React, { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { Container, Card, Button } from "react-bootstrap";
import axios from "axios";
import { useCart } from "../../../context/CartContext";
import { Heart } from "lucide-react";
import { useWishlist } from "../../../context/WishlistContext";

export default function PosterProductDetails() {
    const { id } = useParams();
    const navigate = useNavigate();

    const { addToCart } = useCart();
    const { wishlist, addToWishlist, removeFromWishlist } = useWishlist();

    const [product, setProduct] = useState(null);
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios
            .get(`http://127.0.0.1:8001/api/product/${id}`)
            .then((res) => {
                setProduct(res.data.product);
            })
            .catch((err) => {
                console.error("❌ Failed to load product:", err);
                setProduct(null);
            })
            .finally(() => setLoading(false));
    }, [id]);

    // Show loading screen
    if (loading) {
        return (
            <Container className="py-5 text-center">
                <h2>Loading...</h2>
            </Container>
        );
    }

    // If product does not exist
    if (!product) {
        return (
            <Container className="py-5 text-center">
                <h2>❌ Product not found!</h2>
                <Button variant="primary" onClick={() => navigate(-1)}>
                    Go Back
                </Button>
            </Container>
        );
    }

    const isInWishlist = wishlist.some((w) => w.id === product.id);

    const handleWishlist = () => {
        if (isInWishlist) {
            removeFromWishlist(product.id);
        } else {
            addToWishlist(product);
        }
    };

    return (
        <>
            <Container className="py-5">
                <Card className="shadow-lg border-0">
                    <div className="row g-0 align-items-center">

                        {/* LEFT: IMAGE */}
                        <div className="col-md-6 text-center p-4">
                            <img
                                src={`http://127.0.0.1:8001/${product.image_path}`}
                                alt={product.name}
                                style={{
                                    width: "100%",
                                    borderRadius: "12px",
                                    objectFit: "contain",
                                    maxHeight: "420px",
                                }}
                            />
                        </div>

                        {/* RIGHT: DETAILS */}
                        <div className="col-md-6 p-4">
                            <Card.Body>
                                <Card.Title className="fs-3 fw-bold">
                                    {product.name}
                                </Card.Title>

                                {/* PRICES */}
                                <div className="d-flex gap-3 align-items-center mb-3">
                                    <h4 className="text-danger fw-bold mb-0">
                                        ₹{product.current_sale_price}
                                    </h4>
                                    <h6 className="text-muted text-decoration-line-through mb-0">
                                        ₹{product.previous_sale_price}
                                    </h6>
                                </div>

                                {/* SOLD OUT */}
                                {product.soldOut && (
                                    <p className="text-danger fw-bold">Sold Out</p>
                                )}

                                {/* BUTTONS */}
                                <div className="d-flex gap-2">
                                    <Button
                                        variant="success"
                                        disabled={product.soldOut}
                                        onClick={() => addToCart(product, 1)}
                                    >
                                        {product.soldOut ? "Sold Out" : "Add to Cart"}
                                    </Button>

                                    <Button
                                        variant="outline-secondary"
                                        onClick={() => navigate(-1)}
                                    >
                                        Go Back
                                    </Button>

                                    <Button
                                        variant="outline-light text-black"
                                        className="d-flex align-items-center justify-content-center gap-2"
                                        onClick={handleWishlist}
                                    >
                                        <Heart
                                            size={18}
                                            strokeWidth={2}
                                            fill={isInWishlist ? "red" : "none"}
                                            color={isInWishlist ? "red" : "black"}
                                        />
                                    </Button>
                                </div>
                            </Card.Body>
                        </div>
                    </div>
                </Card>
            </Container>

            <div className="katana-banner2"></div>
        </>
    );
}
