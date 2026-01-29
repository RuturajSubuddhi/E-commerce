import React, { useState } from "react";
import { Card, Container, Form, Button } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import "../../styles/ChangePasswordProfile.css";
import axios from "axios";
import { toast } from "react-toastify";

export default function ChangePasswordProfile() {
    const [oldPassword, setOldPassword] = useState("");
    const [newPassword, setNewPassword] = useState("");
    const [confirmPassword, setConfirmPassword] = useState("");

    const navigate = useNavigate();

    const handleSubmit = async (e) => {
        e.preventDefault();

        // 1️⃣ Frontend validation
        if (newPassword !== confirmPassword) {
            toast.error("New password and Confirm password do not match!");
            return;
        }

        try {
            // 2️⃣ Get token
            const token = localStorage.getItem("token");

            // 3️⃣ Call API
            const response = await axios.post(
                "http://127.0.0.1:8001/api/user/changePassword",
                {
                    currentPass: oldPassword,
                    newPass: newPassword,
                },
                { headers: { Authorization: `Bearer ${token}` } }
            );

            toast.success(response.data.message || "Password changed successfully!");

            // 4️⃣ Navigate back to Profile
            setTimeout(() => {
                navigate("/myprofile");
            }, 1200);

        } catch (error) {
            if (error.response) {
                toast.error(error.response.data.message || "Something went wrong!");
            } else {
                toast.error("Server not reachable!");
            }
        }
    };

    const handleCancel = () => {
        navigate("/profile");
    };
    return (
        <div className="password-page mb-3">



            <Card className="password-card shadow-lg border-0">
                <h3 className="password-title">Change Password</h3>

                <Form onSubmit={handleSubmit}>

                    <Form.Group className="mb-3 text-start">
                        <Form.Label>Old Password</Form.Label>
                        <Form.Control
                            type="password"
                            className="password-input"
                            placeholder="Enter old password"
                            value={oldPassword}
                            onChange={(e) => setOldPassword(e.target.value)}
                            required
                        />
                    </Form.Group>

                    <Form.Group className="mb-3 text-start">
                        <Form.Label>New Password</Form.Label>
                        <Form.Control
                            type="password"
                            className="password-input"
                            placeholder="Enter new password"
                            value={newPassword}
                            onChange={(e) => setNewPassword(e.target.value)}
                            required
                        />
                    </Form.Group>

                    <Form.Group className="mb-4 text-start">
                        <Form.Label>Confirm Password</Form.Label>
                        <Form.Control
                            type="password"
                            className="password-input"
                            placeholder="Re-enter new password"
                            value={confirmPassword}
                            onChange={(e) => setConfirmPassword(e.target.value)}
                            required
                        />
                    </Form.Group>

                    <div className="d-flex justify-content-between gap-2">
                        <Button type="submit" className="update-btn w-auto">
                            Update
                        </Button>
                        <Button
                            variant="outline-secondary"
                            className="cancel-btn w-auto"
                            onClick={() => navigate("/myprofile")}
                        >
                            Cancel
                        </Button>
                    </div>

                </Form>

            </Card>

        </div>
    );
}
