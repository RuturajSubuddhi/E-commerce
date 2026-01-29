import { Container, Row, Col } from "react-bootstrap";
import { FaShippingFast, FaCertificate, FaImages, FaStar } from "react-icons/fa";
import "../../styles/Features.css";

export default function Features() {
  return (
    <section className="features-section py-5">
      <Container>
        <Row className="text-center g-4">
          <Col md={3}>
            <div className="feature-card">
              <div className="feature-icon">
                <FaShippingFast />
              </div>
              <h5>FAST SHIPPING</h5>
              <p>
                Get fast shipping on all prepaid orders at Animezz! Save more time with
                fast shipping and immerse yourself in our anime merchandise.
              </p>
            </div>
          </Col>

          <Col md={3}>
            <div className="feature-card">
              <div className="feature-icon">
                <FaCertificate />
              </div>
              <h5>QUALITY GUARANTEED</h5>
              <p>
                Every product passes rigorous quality control checks before it
                leaves our hands.
              </p>
            </div>
          </Col>

          <Col md={3}>
            <div className="feature-card">
              <div className="feature-icon">
                <FaImages />
              </div>
              <h5>CUSTOM CREATION</h5>
              <p>
                Custom creations available on prepaid orders. Personalize your
                favorite anime items with ease!
              </p>
            </div>
          </Col>

          <Col md={3}>
            <div className="feature-card">
              <div className="feature-icon">
                <FaStar />
              </div>
              <h5>EXCLUSIVE OFFERS</h5>
              <p>
                Exciting deals and exclusive offers on your favorite anime
                merchandise.
              </p>
            </div>
          </Col>
        </Row>
      </Container>
    </section>
  );
}
