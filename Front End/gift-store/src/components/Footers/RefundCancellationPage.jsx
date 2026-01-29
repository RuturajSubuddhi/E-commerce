import React, { useEffect, useState } from "react";
import { Container, Card, Spinner } from "react-bootstrap";
import { motion } from "framer-motion";
import "../../styles/RefundPolicy.css";
import axios from "axios";

export default function RefundCancellationPage() {

    const [content, setContent] = useState("");
    const [loading, setLoading] = useState(true);

    useEffect(() => {
        axios
            .get("http://127.0.0.1:8001/api/product/company/info")
            .then((res) => {
                setContent(res.data?.refund_policy || "");
                setLoading(false);
            })
            .catch((err) => {
                console.log("Error:", err);
                setLoading(false);
            });
    }, []);
    return (
        <div className="refund-page py-5">

            {/* Page Heading */}
            <motion.h2
                className="text-center fw-bold mb-4 text-dark"
                initial={{ opacity: 0, y: -20 }}
                animate={{ opacity: 1, y: 0 }}
            >
                🔄 Refund & Cancellation Policy
            </motion.h2>

            {/* Content Card */}
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
                    <Card className="refund-card mx-auto shadow-lg border-0 p-4 rounded-4">
                        <Container>

                            <div className="refund-text-content">
                                {content.split("\n").map((line, index) => {
                                    const text = line.trim();

                                    // Main Heading (1., 2., etc.)
                                    if (/^\d+\./.test(text)) {
                                        return (
                                            <h3 key={index} className="refund-section-title">
                                                {text}
                                            </h3>
                                        );
                                    }

                                    // Bullet points (starting with "-" or "*")
                                    if (text.startsWith("-") || text.startsWith("*")) {
                                        return (
                                            <ul key={index} className="refund-list">
                                                <li>{text.replace(/^[-*]\s*/, "")}</li>
                                            </ul>
                                        );
                                    }

                                    // Normal paragraph
                                    if (text.length > 0) {
                                        return (
                                            <p key={index} className="refund-text-formatted">
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