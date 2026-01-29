import { Container, Row, Col, Form, Button } from "react-bootstrap";
import { BsEnvelope, BsFacebook, BsInstagram, BsWhatsapp, BsYoutube } from "react-icons/bs";
import { Link } from "react-router-dom";
import React, { useEffect, useState } from "react";
import axios from "axios";
import "../../styles/Footer.css";

export default function Footer() {
  const [content, setContent] = useState("");
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8001/api/product/company/info")
      .then((res) => {
        setContent(res.data || "");
        setLoading(false);
      })
      .catch((err) => {
        console.log("Error:", err);
        setLoading(false);
      });
  }, []);

  return (
    <footer className="footer bg-dark text-light pt-5 pb-3">
      <Container>
        <Row>
          {/* Quick Links */}
          <Col md={3} sm={6} className="mb-4">
            <h6 className="fw-bold mb-3">QUICK LINK</h6>
            <ul className="list-unstyled">
              <li><Link to="/privacy-policy" className="footer-link">Privacy Policy</Link></li>
              <li><Link to="/terms-and-conditions" className="footer-link">Terms & Conditions</Link></li>
              <li><a href="/refund-and-cancellation-policy" className="footer-link">Refund & Cancellation Policy</a></li>
              <li><Link to="/return-policy" className="footer-link">Return Policy</Link></li>
              <li><Link to="/shipping-policy" className="footer-link">Shipping Policy</Link></li>
            </ul>
          </Col>

          {/* Customer Area */}
          <Col md={3} sm={6} className="mb-4">
            <h6 className="fw-bold mb-3">CUSTOMER AREA</h6>
            <ul className="list-unstyled">
              <li><Link to="/about-us" className="footer-link">About Us</Link></li>
              <li><Link to="/contact-us" className="footer-link">Contact Us</Link></li>
              <li><a href="#" className="footer-link">Dashboard</a></li>
              <li><Link to="/myorder" className="footer-link">My Orders</Link></li>
              <li><a href="#" className="footer-link">Track My Orders</a></li>
            </ul>
          </Col>

          {/* About */}
          <Col md={3} sm={6} className="mb-4">
            <h6 className="fw-bold mb-3">ABOUT ANIMEZZ</h6>
            <p className="mb-1">Phone: {content?.phone || "N/A"}</p>
            <p className="mb-1">Email: {content?.email || "N/A"}</p>
            <p>Address: {content?.company_address || "N/A"}</p>
          </Col>

          {/* Newsletter */}
          <Col md={3} sm={6} className="mb-4">
            <p className="mb-2">
              Enter your email below to be the first to know about new collections and product launches.
            </p>
            <Form className="d-flex mb-3">
              <Form.Control
                type="email"
                placeholder="Enter your email"
                className="me-2"
              />
              <Button variant="light">
                <BsEnvelope />
              </Button>
            </Form>
            <div className="d-flex gap-3">
              <a href={content.instagram_link} className="social-icon" target="_blank">
                <BsInstagram size={22} />
              </a>
              <a href={content.facebook_link} className="social-icon" target="_blank">
                <BsFacebook size={22} />
              </a>
              <a href={content.whatsapp_link} className="social-icon" target="_blank">
                <BsWhatsapp size={22} />
              </a>
              {/* <a href="#" className="social-icon" target="_blank">
                <BsYoutube size={22} />
              </a> */}
            </div>
          </Col>
        </Row>

        {/* Bottom Copyright */}
        <Row className="pt-3 border-top border-light mt-3">
          <Col className="text-center">
            <small>© 2025, Animezz</small>
          </Col>
        </Row>
      </Container>
    </footer>
  );
}
