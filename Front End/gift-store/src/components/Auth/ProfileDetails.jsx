import React, { useState, useEffect } from "react";
import { Card, Form, Button, Image } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import "../../styles/ProfileDetails.css";
import axios from "axios";
import { toast } from "react-toastify";

export default function ProfileDetails() {
    const navigate = useNavigate();

    const [profileImage, setProfileImage] = useState(null);
    const [previewImage, setPreviewImage] = useState(null);

    const [name, setName] = useState("");
    const [email, setEmail] = useState("");
    const [phone, setPhone] = useState("");

    // 🟢 Fetch existing user details
    useEffect(() => {
        const fetchUser = async () => {
            try {
                const token = localStorage.getItem("token");

                const res = await axios.get("http://127.0.0.1:8001/api/user/profile", {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });

                if (res.data.status === 200) {
                    const user = res.data.user;

                    setName(user.name);
                    setEmail(user.email);
                    setPhone(user.phone ?? "");

                    // Set previous image
                    if (user.photo) {
                        setPreviewImage(`http://127.0.0.1:8001/${user.photo}`);
                    }
                }
            } catch (error) {
                console.error(error);
                toast.error("Failed to load profile details");
            }
        };

        fetchUser();
    }, []);

    // IMAGE CHANGE
    const handleImageUpload = (e) => {
        const file = e.target.files[0];
        if (file) {
            setProfileImage(file);
            setPreviewImage(URL.createObjectURL(file));
        }
    };


    // SUBMIT FORM
    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            const token = localStorage.getItem("token");

            const formData = new FormData();
            formData.append("name", name);
            formData.append("email", email);
            formData.append("phone", phone);

            if (profileImage) {
                formData.append("photo", profileImage);
            }

            const res = await axios.post(
                "http://127.0.0.1:8001/api/user/update-profile",
                formData,
                {
                    headers: {
                        Authorization: `Bearer ${token}`,
                        "Content-Type": "multipart/form-data",
                    },
                }
            );

            if (res.data.status === 200) {
                toast.success("Profile updated successfully!");
                navigate("/myprofile");
            } else {
                toast.error(res.data.msg);
            }

        } catch (error) {
            console.log(error);
            toast.error("Something went wrong");
        }
    };

    const handleCancel = () => {
        navigate("/");
    };

    return (
        <div className="profile-page mb-3">



            <Card className="profile-card shadow-lg border-0">
                <h3 className="profile-title text-center">Profile Details</h3>

                {/* Profile Image */}
                <div className="profile-img-wrapper">
                    <Image
                        src={previewImage ? previewImage : "https://via.placeholder.com/120"}
                        className="profile-img"
                        roundedCircle
                    />

                    {/* Upload Button */}
                    <label className="upload-btn">
                        Choose Image
                        <input type="file" onChange={handleImageUpload} />
                    </label>
                </div>

                <Form onSubmit={handleSubmit}>
                    {/* Full Name */}
                    <Form.Group className="mb-3">
                        <Form.Label className="fw-semibold">Full Name</Form.Label>
                        <Form.Control
                            type="text"
                            className="profile-input"
                            value={name}
                            onChange={(e) => setName(e.target.value)}
                            required
                        />
                    </Form.Group>

                    {/* Email */}
                    <Form.Group className="mb-3">
                        <Form.Label className="fw-semibold">Email</Form.Label>
                        <Form.Control
                            type="email"
                            className="profile-input"
                            value={email}
                            onChange={(e) => setEmail(e.target.value)}
                            required
                        />
                    </Form.Group>

                    {/* Phone */}
                    <Form.Group className="mb-4">
                        <Form.Label className="fw-semibold">Phone Number</Form.Label>
                        <Form.Control
                            type="text"
                            className="profile-input"
                            value={phone}
                            onChange={(e) => setPhone(e.target.value)}
                            required
                        />
                    </Form.Group>

                    {/* Buttons */}
                    <div className="d-flex justify-content-between gap-2">
                        <Button type="submit" className="update-btn w-auto">
                            Update Profile
                        </Button>

                        <Button
                            variant="outline-secondary"
                            className="cancel-btn w-auto"
                            onClick={handleCancel}
                        >
                            Cancel
                        </Button>
                    </div>

                </Form>
            </Card>

        </div>
    );
}
