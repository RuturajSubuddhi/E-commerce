import React, { useEffect, useState } from "react";
import { Container } from "react-bootstrap";
import axios from "axios";
import "../../styles/PromoBar.css";

export default function PromoBar() {
  const [messages, setMessages] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8001/api/product/company/info")
      .then((res) => {
        // 🔥 API returns object → extract promobar
        const promoText = res.data?.promobar;

        if (promoText) {
          const promoArray = promoText
            .split("|")
            .map((item) => item.trim())
            .filter(Boolean);

          setMessages(promoArray);
        }

        setLoading(false);
      })
      .catch((err) => {
        console.error("PromoBar Error:", err);
        setLoading(false);
      });
  }, []);

  // ⛔ Don't render if loading or empty
  if (loading || messages.length === 0) return null;

  return (
    <div className="bg-danger text-white py-1 overflow-hidden">
      <Container className="d-flex px-0">
        <div className="scrolling-text d-flex gap-4">
          {messages.map((text, index) => (
            <p key={index} className="mb-0">
              {text}
            </p>
          ))}
        </div>
      </Container>
    </div>
  );
}
