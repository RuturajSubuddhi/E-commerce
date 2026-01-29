import React, { useEffect, useState } from "react";
import { Container, Card, Spinner } from "react-bootstrap";
import { motion } from "framer-motion";
import axios from "axios";
import "../../styles/TermsConditions.css";

export default function TermsConditionsPage() {
  const [content, setContent] = useState("");
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8001/api/product/company/info")
      .then((res) => {
        setContent(res.data?.terms_condition || "");
        setLoading(false);
      })
      .catch((err) => {
        console.log("Error:", err);
        setLoading(false);
      });
  }, []);

  return (
    <div className="terms-page py-5">
      {/* Page Heading */}
      <motion.h2
        className="text-center fw-bold mb-4 text-dark"
        initial={{ opacity: 0, y: -20 }}
        animate={{ opacity: 1, y: 0 }}
      >
        📜 Terms & Conditions
      </motion.h2>

      {/* Loading Spinner */}
      {loading && (
        <div className="text-center">
          <Spinner animation="border" />
        </div>
      )}

      {/* Content */}
      {!loading && (
        <motion.div
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ duration: 0.4 }}
        >
          <Card className="terms-card mx-auto shadow-lg border-0 p-4 rounded-4">
            <Container>
              {/* Render API Terms & Conditions with formatting */}
              <div className="policy-text-content">
                {content.split("\n").map((line, index) => {
                  const text = line.trim();

                  // MAIN HEADING (e.g., "1. Introduction")
                  if (/^\d+\./.test(text)) {
                    return (
                      <h3 key={index} className="policy-section-title">
                        {text}
                      </h3>
                    );
                  }

                  // SUB-HEADING (e.g., "a. Subsection")
                  if (/^[a-z]\./.test(text)) {
                    return (
                      <h4 key={index} className="policy-subtitle">
                        {text}
                      </h4>
                    );
                  }

                  // Bullet Points
                  if (text.startsWith("-") || text.startsWith("*")) {
                    return (
                      <ul key={index} className="policy-list">
                        <li>{text.replace(/^[-*]\s*/, "")}</li>
                      </ul>
                    );
                  }

                  // Normal Paragraph
                  if (text.length > 0) {
                    return (
                      <p key={index} className="policy-text-formatted">
                        {text}
                      </p>
                    );
                  }

                  return <br key={index} />;
                })}
              </div>
            </Container>
          </Card>
        </motion.div>
      )}
    </div>
  );
}