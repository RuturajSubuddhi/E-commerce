import React, { useState } from "react";
import { useParams } from "react-router-dom";
import { Container, Card, Button } from "react-bootstrap";
import { iosData } from "../../../../data/MobileCover/iOSData";
import { useCart } from "../../../../context/CartContext";
import { Heart } from "lucide-react";
import { toast } from "react-toastify";
import { useWishlist } from "../../../../context/WishlistContext";


export default function IOSDetails() {
    const { id } = useParams();
    const { addToCart } = useCart();
    const { wishlist, addToWishlist, removeFromWishlist } = useWishlist();

    // Find the product by ID
    const product = iosData.find((item) => item.id === Number(id));

    if (!product) {
        return (
            <Container className="py-5 text-center">
                <h2>❌ Product not found!</h2>
                <Button variant="primary" onClick={() => window.history.back()}>
                    Go Back
                </Button>
            </Container>
        );
    }

    const isInWishlist = wishlist.some((item) => item.id === product.id);

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
                        {/* Left: Product Image */}
                        <div className="col-md-6 text-center p-4">
                            <img
                                src={product.img}
                                alt={product.title}
                                style={{
                                    width: "inherit",
                                    borderRadius: "12px",
                                    objectFit: "contain",
                                    maxHeight: "400px",
                                }}
                            />
                        </div>

                        {/* Right: Product Info */}
                        <div className="col-md-6 p-4">
                            <Card.Body>
                                <Card.Title className="fs-3 fw-bold">{product.title}</Card.Title>

                                <div className="d-flex gap-3 align-items-center mb-3">
                                    <h4 className="text-danger fw-bold mb-0">₹{product.price}.00</h4>
                                    <h6 className="text-decoration-line-through text-muted mb-0">
                                        ₹{product.oldPrice}.00
                                    </h6>
                                </div>

                                {product.soldOut && (
                                    <p className="text-danger fw-bold">Sold Out</p>
                                )}

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
                                        onClick={() => window.history.back()}
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
                                        {/* {isInWishlist ? "In Wishlist" : "Wishlist"} */}
                                    </Button>
                                </div>
                            </Card.Body>
                        </div>
                    </div>
                </Card>
            </Container>
            <div className="katana-banner2">
                {/* <h1 className="banner-text">WOODEN KATANA</h1> */}
            </div>
        </>
    );
}