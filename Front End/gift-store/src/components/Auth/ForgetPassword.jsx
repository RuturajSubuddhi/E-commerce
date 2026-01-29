import React, { useState } from "react";
import { Card, Container, Form, Button } from "react-bootstrap";
import { toast } from "react-toastify";
import "../../styles/ForgetPassword.css";
import axios from "axios";
import { useNavigate } from "react-router-dom";

export default function ForgetPassword() {
    const [email, setEmail] = useState("");
    const [otp, setOtp] = useState("");
    const [newPassword, setNewPassword] = useState("");
    const [step, setStep] = useState(1); // 1: send OTP, 2: verify OTP, 3: reset password
    const navigate = useNavigate();

    // STEP 1: Send OTP
    const handleSendOtp = async () => {
        if (!email) {
            toast.warning("Please enter your registered email!");
            return;
        }

        try {
            const response = await axios.post("http://127.0.0.1:8001/api/user/forgetpassword", { email });

            if (response.data.status === 200) {
                toast.success("OTP sent to your email!");
                setStep(2);
            }
        } catch (error) {
            toast.error(error.response?.data.msg || "Email not registered!");
        }
    };

    // STEP 2: Verify OTP
    const handleVerifyOtp = async () => {
        if (!otp) {
            toast.warning("Please enter the OTP!");
            return;
        }

        try {
            const response = await axios.post("http://127.0.0.1:8001/api/user/verify-otp", { email, otp });

            if (response.data.status === 200) {
                toast.success("OTP verified successfully!");
                setStep(3);
            }
        } catch (error) {
            toast.error(error.response?.data.msg || "Invalid OTP!");
        }
    };

    // STEP 3 - Reset Password
const handleResetPassword = async () => {
    if (!newPassword) {
        toast.error("Please enter new password");
        return;
    }

    try {
        const response = await axios.post(
            "http://127.0.0.1:8001/api/user/reset-password",
            {
                email: email,
                otp: otp,
                password: newPassword,
            }
        );

        if (response.data.status === 200) {
            toast.success("Password reset successfully!");
            navigate("/")
        }

    } catch (error) {
        toast.error(
            error.response?.data?.msg || "Failed to reset password"
        );
    }
};


    return (
        <Container className="d-flex justify-content-center mt-5 mb-3">
            <Card className="forget-card p-4 shadow-lg">
                <h3 className="text-center mb-3 fw-bold">Forgot Password</h3>

                {step === 1 && (
                    <>
                        <Form.Label>Email Address</Form.Label>
                        <Form.Control
                            type="email"
                            placeholder="Enter registered email"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                        />
                        <Button className="mt-3 w-100" onClick={handleSendOtp}>
                            Send OTP
                        </Button>
                    </>
                )}

                {step === 2 && (
                    <>
                        <Form.Label>Enter OTP</Form.Label>
                        <Form.Control
                            type="text"
                            placeholder="Enter OTP"
                            value={otp}
                            onChange={(e) => setOtp(e.target.value)}
                        />
                        <Button className="mt-3 w-100" onClick={handleVerifyOtp}>
                            Verify OTP
                        </Button>
                    </>
                )}

                {step === 3 && (
                    <>
                        <Form.Label>New Password</Form.Label>
                        <Form.Control
                            type="password"
                            placeholder="Enter new password"
                            value={newPassword}
                            onChange={(e) => setNewPassword(e.target.value)}
                        />
                        <Button className="mt-3 w-100" onClick={handleResetPassword}>
                            Reset Password
                        </Button>
                    </>
                )}
            </Card>
        </Container>
    );
}
