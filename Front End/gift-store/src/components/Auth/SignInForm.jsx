import React, { useState } from "react";
import { Button, Form, Spinner } from "react-bootstrap";
import { loginUser } from "../../Services/authServices";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";


export default function SignInForm({ onFlip, onClose }) {
  const [form, setForm] = useState({ email: "", password: "" });
  const [loading, setLoading] = useState(false);
  const navigate = useNavigate();

  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    setLoading(true);

    try {
      const res = await loginUser(form.email, form.password);

      if (res.status === 200) {
        toast.success("Login successful!");
        setForm({ email: "", password: "" });
        window.location.href = "/"; // redirect to homepage
      } else {
        toast.error(res.msg || "Invalid credentials");
      }
    } catch (err) {
      toast.error(err?.response?.data?.msg || "Login failed");
    } finally {
      setLoading(false);
    }
  };

  return (
    <div>
      <h4 className="text-center mb-4">Sign In</h4>
      <Form onSubmit={handleSubmit}>
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

        <Button
          variant="dark"
          type="submit"
          className="w-100"
          disabled={loading}
        >
          {loading ? <Spinner animation="border" size="sm" /> : "Sign In"}
        </Button>
      </Form>

      <p className="text-center mt-3">
        Don’t have an account?{" "}
        <span
          onClick={onFlip}
          style={{ cursor: "pointer", color: "red", fontWeight: "500" }}
        >
          Register
        </span>
      </p>
      <p className="text-center mt-3">
        Forgot Password?{" "}
        <span
          onClick={() => {
            if (onClose) onClose(); // close modal
            navigate("/forget-password"); // redirect
          }}
          style={{ cursor: "pointer", color: "red", fontWeight: "500" }}
        >
          Forgot Password
        </span>
      </p>

    </div>
  );
}