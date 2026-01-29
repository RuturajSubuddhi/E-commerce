import React from "react";
import { Container, Row, Col,Button } from "react-bootstrap";
import "../../styles/ProductShowCase.css"; // add styles here
// import { useCart } from "../../context/CartContext"; // import cart context


// Replace with your own images

export default function ProductShowCase() {
    // const { addToCart } = useCart();

  const products = [
    { img: "/assets/ProductShowCase-3.webp" },
    { name: "LED KATANA", img: "/assets/Led Cotana.webp" },
    { name: "WOODEN KATANA", img: "/assets/Wooden Catana.webp" },
  ];

  return (
    <div className="py-5 bg-dark">
      <Container fluid>
        <Row className="g-3">
          {products.map((p, i) => (
            <Col md={4} key={i}>
              <div className="product-card position-relative text-white">
                <img
                  src={p.img}
                  alt={p.title}
                  className="w-100 h-100 object-fit-cover product-image"
                />
                <div className="overlay-text position-absolute bottom-0 start-0 p-3">
                  <h6 className="fw-bold text-uppercase">{p.subtitle}</h6>
                  <h2 className="fw-bolder">{p.title}</h2>
                  {/* <Button
                    variant="success"
                    className="mt-2"
                    onClick={() => addToCart(p, 1)}
                  >
                    Add to Cart
                  </Button> */}
                </div>
              </div>
            </Col>
          ))}
        </Row>
      </Container>
    </div>
  );
}