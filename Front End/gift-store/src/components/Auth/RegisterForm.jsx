import React, { useState } from "react";
import { Button, Form, Spinner } from "react-bootstrap";
import { registerUser } from "../../Services/authServices";
import { toast } from "react-toastify";

export default function RegisterForm({ onFlip }) {
  const [form, setForm] = useState({
    name: "",
    email: "",
    password: "",
    confirmPassword: ""
  });
  const [loading, setLoading] = useState(false);

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);

    // Check if passwords match
    if (form.password !== form.confirmPassword) {
      toast.error("Passwords do not match");
      setLoading(false);
      return;
    }

    try {
      const res = await registerUser(
        form.name,
        form.email,
        form.password,
        form.confirmPassword
      );

      if (res.status === 200) {
        toast.success("Registration successful! Please log in.");
        setForm({ name: "", email: "", password: "", confirmPassword: "" });
        onFlip(); // Flip to sign-in form
      } else {
        toast.error(res.msg || "Registration failed");
      }
    } catch (err) {
      toast.error(err?.response?.data?.msg || "Something went wrong");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div>
      <h4 className="text-center mb-4">Register</h4>
      <Form onSubmit={handleSubmit}>
        <Form.Group className="mb-3">
          <Form.Label>Full Name</Form.Label>
          <Form.Control
            type="text"
            name="name"
            value={form.name}
            placeholder="Enter your name"
            onChange={handleChange}
            required
          />
        </Form.Group>

        <Form.Group className="mb-3">
          <Form.Label>Email</Form.Label>
          <Form.Control
            type="email"
            name="email"
            value={form.email}
            placeholder="Enter email"
            onChange={handleChange}
            required
          />
        </Form.Group>

        <Form.Group className="mb-3">
          <Form.Label>Password</Form.Label>
          <Form.Control
            type="password"
            name="password"
            value={form.password}
            placeholder="Enter password"
            onChange={handleChange}
            required
          />
        </Form.Group>

        <Form.Group className="mb-3">
          <Form.Label>Confirm Password</Form.Label>
          <Form.Control
            type="password"
            name="confirmPassword"
            value={form.confirmPassword}
            placeholder="Confirm password"
            onChange={handleChange}
            required
          />
        </Form.Group>

        <Button
          variant="dark"
          type="submit"
          className="w-100"
          disabled={loading}
        >
          {loading ? <Spinner animation="border" size="sm" /> : "Register"}
        </Button>
      </Form>

      <p className="text-center mt-3">
        Already have an account?{" "}
        <span
          onClick={onFlip}
          style={{ cursor: "pointer", color: "red", fontWeight: "500" }}
        >
          Sign In
        </span>
      </p>
    </div>
  );
}
