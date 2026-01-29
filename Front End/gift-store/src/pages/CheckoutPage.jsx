import React, { useState, useEffect } from "react";
import axios from "axios";
import { Button, Card, Collapse, Form, Modal, Row, Col } from "react-bootstrap";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";

import "../styles/CheckoutPage.css";

export const API_URL =
  import.meta.env.VITE_API_URL || "http://127.0.0.1:8001/api";

export const BASE_URL = API_URL.replace("/api", "");

export default function CheckoutPage() {
  const [savedAddresses, setSavedAddresses] = useState([]);
  const [selectedAddress, setSelectedAddress] = useState(null);

  const [activeStep, setActiveStep] = useState(1);
  const [showAddAddress, setShowAddAddress] = useState(false);
  const [shippingCost, setShippingCost] = useState(0);
  const [countries, setCountries] = useState([]);
  const [divisions, setDivisions] = useState([]);
  const [districts, setDistricts] = useState([]);
  const navigate = useNavigate();

  const [mockPaymentData, setMockPaymentData] = useState({
    card_number: "",
    card_name: "",
    card_expiry: "",
    card_cvv: "",
    upi_id: "",
  });

  const [newAddress, setNewAddress] = useState({
    name: "",
    phone: "",
    address: "",
    city: "",
    pincode: "",
    state: "",
    district: 1,
    division: 1,
  });
  const [billingAddress, setBillingAddress] = useState({
    name: "",
    phone: "",
    address: "",
    city: "",
    pincode: "",
    state: "Odisha",
    division: 1,
    district: 1,
  });

  const [shippingAddress, setShippingAddress] = useState({
    name: "",
    phone: "",
    address: "",
    city: "",
    pincode: "",
    state: "Odisha",
    division: 1,
    district: 1,
  });

  const [formData, setFormData] = useState({
    first_name: "",
    last_name: "",
    phone: "",
    address: "",
    country_id: "",
    division_id: "",
    district_id: "",
    country: "",
    state: "",
    city: "",
    zip: "",
    is_default: false,
  });

  const [promoCode, setPromoCode] = useState("");
  const [promoDiscount, setPromoDiscount] = useState(0);
  const [isPromoApplied, setIsPromoApplied] = useState(false);
  const [promoLoading, setPromoLoading] = useState(false);

  const handleChange = (e) => {
    const { name, value, type, checked } = e.target;
    setFormData({
      ...formData,
      [name]: type === "checkbox" ? checked : value,
    });
  };

  // async function handlePlaceOrder() {
  //   if (paymentMethod === "COD") {
  //     await placeOrder(); // existing logic
  //   } else {
  //     await placeOrderAndPay(); // NEW
  //   }
  // }
  const handlePlaceOrder = async () => {
    if (!selectedAddress) {
      toast.error("Select a delivery address first");
      return;
    }

    // Ensure shippingCost loaded
    if (shippingCost === null) {
      toast.error("Calculating shipping cost. Please wait...");
      return;
    }

    if (paymentMethod === "COD") {
      await placeOrder(); // existing logic
    } else {
      // Format total_amount to 2 decimals to match backend hash
      const formattedTotal = (
        Number(total) +
        Number(shippingCost || 0) -
        Number(promoDiscount || 0)
      ).toFixed(2);

      await placeOrderAndPay(formattedTotal); // Pass formattedTotal
    }
  };

  const handlePaymentInput = (e) => {
    const { name, value } = e.target;
    setMockPaymentData({ ...mockPaymentData, [name]: value });
  };

  // -------------------- PayU Redirect --------------------
  const redirectToPayU = async (sellId) => {
    try {
      const token = localStorage.getItem("token");

      const res = await axios.post(
        `${API_URL}/payu/initiate`,
        { sell_id: sellId },
        { headers: { Authorization: `Bearer ${token}` } }
      );

      const { action, params } = res.data;

      const form = document.createElement("form");
      form.method = "POST";
      form.action = action;

      Object.keys(params).forEach((key) => {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = key;
        input.value = params[key];
        form.appendChild(input);
      });

      document.body.appendChild(form);
      form.submit();
    } catch (err) {
      console.error(err);
      toast.error("Payment initiation failed");
    }
  };

  const fetchCountries = async () => {
    const res = await axios.get(`${API_URL}/country/list`);
    setCountries(res.data || []);
  };

  const fetchDivisions = async (countryId) => {
    if (!countryId) return;
    const res = await axios.get(
      `${API_URL}/division/list?country_id=${countryId}`
    );
    setDivisions(res.data || []);
    setDistricts([]);
  };

  const fetchDistricts = async (divisionId) => {
    if (!divisionId) return;
    const res = await axios.get(
      `${API_URL}/district/list?division_id=${divisionId}`
    );
    setDistricts(res.data || []);
  };

  // const [shippingAddress, setShippingAddress] = useState({});
  // const [billingAddress, setBillingAddress] = useState({});
  const [paymentMethod, setPaymentMethod] = useState("UPI");

  const [cartItems, setCartItems] = useState([]);
  const total = cartItems.reduce(
    (sum, item) =>
      sum + (item.product?.current_sale_price || 0) * item.quantity,
    0
  );

  // -----------------------------------------------
  // Load saved addresses
  // -----------------------------------------------
  useEffect(() => {
    loadAddresses();
    loadCart();
  }, []);

  async function loadAddresses() {
    try {
      const token = localStorage.getItem("token");
      const res = await axios.get(`${API_URL}/user/address/get`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      if (res.data.status === 200) {
        setSavedAddresses(res.data.data);

        // Auto-select default address if exists
        const defaultAddr = res.data.data.find((a) => a.is_default === 1);
        if (defaultAddr) selectAddress(defaultAddr);
      }
    } catch (err) {
      console.error(err);
      toast.error("Failed to load addresses");
    }
  }

  async function loadCart() {
    try {
      const user = JSON.parse(localStorage.getItem("user"));
      const token = localStorage.getItem("token");
      if (!user || !token) return;

      const res = await axios.post(
        `${API_URL}/cart/list`,
        { user_id: user.id },
        { headers: { Authorization: `Bearer ${token}` } }
      );

      if (res.data?.cart) setCartItems(res.data.cart);
    } catch (err) {
      console.error(err);
    }
  }

  async function fetchShippingCost(divisionId, districtId) {
    try {
      const res = await axios.get(`${API_URL}/shipping/cost/get`, {
        params: { division_id: divisionId, district_id: districtId },
      });

      if (res.status === 200) {
        setShippingCost(res.data); // API returns a number
      }
    } catch (err) {
      console.error("Error fetching shipping cost:", err);
      setShippingCost(0); // fallback
    }
  }
  // -----------------------------------------------

  const selectAddress = (addr) => {
    setSelectedAddress(addr);

    // const divisionId = addr.shipping_division ?? 1;
    // const districtId = addr.shipping_district ?? 1;
    console.log("Address selected ....", addr);
    const divisionId = addr.shipping_division
      ? Number(addr.shipping_division)
      : 1;

    const districtId = addr.shipping_district
      ? Number(addr.shipping_district)
      : 1;
    // Shipping Address
    setShippingAddress({
      name: `${addr.first_name || ""} ${addr.last_name || ""}`.trim(),
      phone: addr.shipping_phone || "",
      address: addr.shipping_address || "",
      city: addr.shipping_city || "",
      pincode: addr.shipping_zip || "",
      state: addr.shipping_state || "",
      // division: addr.shipping_division || 1,
      // district: addr.shipping_district || 1,
      division: divisionId,
      district: districtId,
    });

    // Billing Address
    setBillingAddress({
      name: `${addr.billing_first_name || addr.first_name || ""} ${addr.billing_last_name || addr.last_name || ""}`.trim(),
      phone: addr.billing_phone || addr.shipping_phone || "",
      address: addr.billing_address || addr.shipping_address || "",
      city: addr.billing_city || addr.shipping_city || "",
      pincode: addr.billing_zip || addr.shipping_zip || "",
      state: addr.billing_state || addr.shipping_state || "",
      // division: addr.billing_division || addr.shipping_division || 1,
      // district: addr.billing_district || addr.shipping_district || 1,
      division: addr.billing_division ?? divisionId,
      district: addr.billing_district ?? districtId,
    });
    fetchShippingCost(divisionId, districtId);
  };

  // -----------------------------------------------

  const saveCheckoutAddress = async () => {
    try {
      const payload = {
        first_name: formData.first_name,
        last_name: formData.last_name,
        shipping_phone: formData.phone,
        shipping_address: formData.address,
        shipping_country: formData.country,
        shipping_state: formData.state,
        shipping_city: formData.city,
        shipping_division: Number(formData.division_id),
        shipping_district: Number(formData.district_id),
        shipping_zip: formData.zip,
        is_default: formData.is_default ? 1 : 0,
      };

      await axios.post(`${API_URL}/user/savedAddress`, payload, {
        headers: { Authorization: `Bearer ${localStorage.getItem("token")}` },
      });

      toast.success("Address added successfully");

      setShowAddAddress(false);

      // ✅ IMPORTANT: Reload address list
      await loadAddresses();

      // ✅ Reset form
      setFormData({
        first_name: "",
        last_name: "",
        phone: "",
        address: "",
        country_id: "",
        division_id: "",
        district_id: "",
        country: "",
        state: "",
        city: "",
        zip: "",
        is_default: false,
      });
    } catch (err) {
      console.error(err);
      toast.error("Failed to save address");
    }
  };

  async function placeOrderAndPay() {
    try {
      if (!selectedAddress) {
        toast.error("Select a delivery address first");
        return;
      }

      const token = localStorage.getItem("token");
      const user = JSON.parse(localStorage.getItem("user"));

      const formattedCart = cartItems.map((item) => ({
        product_id: item.product.id,
        unit_sell_price: item.product.current_sale_price,
        sale_quantity: item.quantity,
        unit_vat: 0,
        unit_product_cost: 0,
        total_discount: 0,
      }));

      const orderPayload = {
        cart_items: formattedCart,

        shipping_phone: shippingAddress.phone,
        shipping_address: shippingAddress.address,
        shipping_division: Number(shippingAddress.division),
        shipping_district: Number(shippingAddress.district),
        shipping_country: "India",
        shipping_zip: shippingAddress.pincode,
        shipping_city: shippingAddress.city,
        shipping_state: shippingAddress.state,

        billing_first_name: billingAddress.name,
        billing_last_name: "",
        billing_phone: billingAddress.phone,
        billing_address: billingAddress.address,
        billing_city: billingAddress.city,
        billing_country: "India",
        billing_zip: billingAddress.pincode,
        billing_state: billingAddress.state,

        payment_method: paymentMethod, // UPI / Card
        shipping_cost: Number(shippingCost),
        total_amount:
          Number(total) +
          Number(shippingCost || 0) -
          Number(promoDiscount || 0),
        promo_code: promoCode || null,
      };

      // 🔹 STEP 1: Create order (payment pending)
      const res = await axios.post(`${API_URL}/place-order`, orderPayload, {
        headers: { Authorization: `Bearer ${token}` },
      });

      if (res.data.status === 200) {
        const sellId = res.data.sell_id;

        // 🔹 STEP 2: Redirect to PayU
        await redirectToPayU(sellId);
      } else {
        toast.error("Order creation failed");
      }
    } catch (err) {
      console.error(err);
      toast.error("Payment initiation failed");
    }
  }

  async function placeOrder() {
    try {
      if (!selectedAddress) {
        toast.error("Select a delivery address first");
        return;
      }

      const token = localStorage.getItem("token");
      const user = JSON.parse(localStorage.getItem("user")); // ✅ define user

      // ⭐ FIX: Convert cart to required backend format
      const formattedCart = cartItems.map((item) => ({
        product_id: item.product.id,
        unit_sell_price: item.product.current_sale_price,
        sale_quantity: item.quantity,
        unit_vat: 0,
        unit_product_cost: 0,
        total_discount: 0,
      }));

      const orderPayload = {
        cart_items: formattedCart,

        shipping_phone: shippingAddress.phone,
        shipping_address: shippingAddress.address,

        // ⭐ FIX: If division/district are strings, send 0 (backend requires integer)
        shipping_division: Number(shippingAddress.division) || 0,
        shipping_district: Number(shippingAddress.district) || 0,

        shipping_country: "India",
        shipping_zip: shippingAddress.pincode,
        shipping_city: shippingAddress.city,
        shipping_state: shippingAddress.state,

        billing_first_name: billingAddress.name,
        billing_last_name: "",
        billing_phone: billingAddress.phone,
        billing_address: billingAddress.address,
        billing_city: billingAddress.city,
        billing_country: "India",
        billing_zip: billingAddress.pincode,
        billing_state: billingAddress.state,
        note: "",

        payment_method: paymentMethod,
        shipping_cost: Number(shippingCost) || 0, // ✅ IMPORTANT
        total_amount:
          Number(total) +
          Number(shippingCost || 0) -
          Number(promoDiscount || 0),
        promo_code: promoCode || null, // <-- Include promo code
      };

      const res = await axios.post(`${API_URL}/place-order`, orderPayload, {
        headers: { Authorization: `Bearer ${token}` },
      });

      if (res.data.status === true) {
        toast.success("Order placed successfully!");

        // ⭐ Clear cart after successful order
        try {
          const resClear = await axios.post(
            `${API_URL}/cart/clear`,
            { user_id: user.id },
            { headers: { Authorization: `Bearer ${token}` } }
          );

          console.log("Clear cart response:", resClear.data);

          if (resClear.status === 200) {
            setCartItems([]);
            toast.info("Cart cleared successfully!");
          } else {
            toast.error("Failed to clear cart!");
          }
        } catch (err) {
          console.error("Error clearing cart:", err);
          toast.error("Error clearing cart!");
        }

        navigate("/");
      } else {
        toast.error("Order failed!");
      }
    } catch (err) {
      console.error(err);
      toast.error("Order failed!");
    }
  }

  const handleNext = () => {
    // Auto-fill shipping when moving from Step 1 → Step 2
    if (activeStep === 1) {
      setShippingAddress({
        ...billingAddress,
        state: billingAddress.state || "Odisha",
        division: billingAddress.division || 1,
        district: billingAddress.district || 1,
      });
    }

    setActiveStep((s) => Math.min(4, s + 1));
  };
  const verifyUPI = (upiId) => {
    if (!upiId) {
      toast.error("Please enter a UPI ID to verify.");
      return;
    }

    // Mock verification: checks for basic format
    const upiPattern = /^[\w.-]+@[\w.-]+$/;
    if (upiPattern.test(upiId)) {
      toast.success("UPI ID looks valid!");
    } else {
      toast.error("Invalid UPI ID format!");
    }

    // ✅ In production, you would call your backend or payment gateway to verify the UPI ID
  };
  const applyPromoCode = async () => {
    if (!promoCode) return toast.error("Enter a promo code");

    setPromoLoading(true);
    try {
      const token = localStorage.getItem("token");
      const res = await axios.post(
        `${API_URL}/apply-promo`,
        { promo_code: promoCode, sub_total: total },
        { headers: { Authorization: `Bearer ${token}` } }
      );

      if (res.data.status) {
        setPromoDiscount(res.data.discount || 0);
        setIsPromoApplied(true);
        toast.success(`Promo applied! You saved ₹${res.data.discount}`);
      } else {
        setPromoDiscount(0);
        setIsPromoApplied(false);
        toast.error(res.data.message || "Invalid promo code");
      }
    } catch (err) {
      console.error(err.response?.data || err);
      setPromoDiscount(0);
      setIsPromoApplied(false);
      toast.error("Error applying promo code");
    } finally {
      setPromoLoading(false);
    }
  };

  const copyBillingToShipping = () => {
    setShippingAddress({
      name: billingAddress.name,
      phone: billingAddress.phone,
      address: billingAddress.address,
      city: billingAddress.city,
      pincode: billingAddress.pincode,
      state: billingAddress.state,
      division: billingAddress.division || 1,
      district: billingAddress.district || 2,
    });
  };

  // -----------------------------------------------
  // Render
  // -----------------------------------------------
  return (
    <div className="container mt-4">
      {/* STEP 1: Select Address */}
      <Card className="mb-3">
        <Card.Header className="step-header" onClick={() => setActiveStep(1)}>
          <strong>1. Select Delivery Address</strong>
        </Card.Header>
        <Collapse in={activeStep === 1}>
          <div className="p-3">
            <div className="d-flex gap-2 flex-wrap">
              {savedAddresses.map((addr) => (
                <Card
                  key={addr.id}
                  className={`p-3 mb-2 address-box col-md-3 ${
                    selectedAddress?.id === addr.id ? "selected" : ""
                  }`}
                  onClick={() => selectAddress(addr)}
                  style={{ cursor: "pointer" }}
                >
                  <div className="d-flex align-items-start">
                    <input
                      type="radio"
                      checked={selectedAddress?.id === addr.id}
                      onChange={() => selectAddress(addr)}
                    />
                    <div className="ms-3">
                      <strong>
                        {addr.first_name} {addr.last_name}
                      </strong>
                      <div>{addr.shipping_address}</div>
                      <div>
                        {addr.shipping_city}, {addr.shipping_state},{" "}
                        {addr.shipping_country || "India"} – {addr.shipping_zip}
                      </div>
                      <div>📞 {addr.shipping_phone}</div>
                      {addr.is_default === 1 && (
                        <span className="badge bg-primary mt-1">Default</span>
                      )}
                    </div>
                  </div>
                </Card>
              ))}
            </div>

            <Button
              variant="outline-dark"
              onClick={() => {
                fetchCountries();
                setShowAddAddress(true);
              }}
            >
              ➕ Add New Address
            </Button>

            <div className="text-end mt-3">
              <Button
                variant="success"
                onClick={handleNext}
                disabled={
                  !shippingAddress.name ||
                  !shippingAddress.phone ||
                  !shippingAddress.address ||
                  !shippingAddress.city ||
                  !shippingAddress.pincode ||
                  !shippingAddress.division ||
                  !shippingAddress.district
                }
              >
                Save & Continue →
              </Button>
            </div>
          </div>
        </Collapse>
      </Card>

      {/* STEP 2: Payment */}
      <Card className="mb-3">
        <Card.Header className="step-header" onClick={() => setActiveStep(2)}>
          <strong>2. Payment Method</strong>
        </Card.Header>
        <Collapse in={activeStep === 2}>
          <div className="p-3">
            <Form.Check
              type="radio"
              label="💳 PAYU"
              name="payment"
              checked={paymentMethod === "PAYU"}
              onChange={() => setPaymentMethod("PAYU")}
              className="mb-2"
            />
            {/* <Form.Check
              type="radio"
              label="💳 Card"
              name="payment"
              checked={paymentMethod === "Card"}
              onChange={() => setPaymentMethod("Card")}
              className="mb-2"
            /> */}
            <Form.Check
              type="radio"
              label="💵 Cash on Delivery"
              name="payment"
              checked={paymentMethod === "COD"}
              onChange={() => setPaymentMethod("COD")}
              className="mb-2"
            />

            {/* Mock Payment UI */}
            {/* {paymentMethod === "UPI" && (
              <Form.Group className="mt-3 col-md-4">
                <Form.Label>Enter UPI ID</Form.Label>
                <div className="d-flex gap-2">
                  <Form.Control
                    placeholder="example@upi"
                    name="upi_id"
                    value={mockPaymentData.upi_id}
                    onChange={handlePaymentInput}
                  />
                  <Button
                    variant="outline-primary"
                    onClick={() => verifyUPI(mockPaymentData.upi_id)}
                  >
                    Verify
                  </Button>
                </div>
              </Form.Group>
            )}

            {paymentMethod === "Card" && (
              <Row className="mt-3">
                <Col md={3}>
                  <Form.Group>
                    <Form.Label>Card Number</Form.Label>
                    <Form.Control
                      placeholder="1234 5678 9012 3456"
                      name="card_number"
                      value={mockPaymentData.card_number}
                      onChange={handlePaymentInput}
                    />
                  </Form.Group>
                </Col>
                <Col md={3}>
                  <Form.Group>
                    <Form.Label>Cardholder Name</Form.Label>
                    <Form.Control
                      placeholder="John Doe"
                      name="card_name"
                      value={mockPaymentData.card_name}
                      onChange={handlePaymentInput}
                    />
                  </Form.Group>
                </Col>
                <Col md={3} className="mt-2">
                  <Form.Group>
                    <Form.Label>Expiry</Form.Label>
                    <Form.Control
                      placeholder="MM/YY"
                      name="card_expiry"
                      value={mockPaymentData.card_expiry}
                      onChange={handlePaymentInput}
                    />
                  </Form.Group>
                </Col>
                <Col md={3} className="mt-2">
                  <Form.Group>
                    <Form.Label>CVV</Form.Label>
                    <Form.Control
                      placeholder="123"
                      name="card_cvv"
                      value={mockPaymentData.card_cvv}
                      onChange={handlePaymentInput}
                    />
                  </Form.Group>
                </Col>
              </Row>
            )} */}
            <div className="text-end mt-3">
              <Button variant="success" onClick={handleNext}>
                Continue →
              </Button>
            </div>
          </div>
        </Collapse>
      </Card>

      {/* STEP 3: Review */}
      <Card className="mb-3">
        <Card.Header className="step-header" onClick={() => setActiveStep(3)}>
          <strong>3. Review & Place Order</strong>
        </Card.Header>
        <Collapse in={activeStep === 3}>
          <div className="p-3">
            {cartItems.map((item, idx) => (
              <div
                key={item.id ?? idx}
                className="d-flex justify-content-between border-bottom py-2"
              >
                <span>
                  {item.product?.name || "Product"} (x{item.quantity})
                </span>
                <span className="fw-bold text-success">
                  ₹{(item.product?.current_sale_price || 0) * item.quantity}
                </span>
              </div>
            ))}
            {/* Shipping Cost */}
            <div className="d-flex justify-content-between mt-3">
              <span className="fw-bold">Shipping Cost:</span>
              <span className="fw-bold text-success">
                {" "}
                ₹{(shippingCost ? Number(shippingCost) : 0).toFixed(2)}
              </span>
            </div>

            <div className="d-flex gap-2 mt-3 col-md-4">
              <Form.Control
                type="text"
                placeholder="Enter promo code"
                value={promoCode}
                onChange={(e) => setPromoCode(e.target.value)}
                disabled={isPromoApplied || promoLoading}
              />
              <Button
                variant="outline-primary"
                onClick={applyPromoCode}
                disabled={isPromoApplied || promoLoading}
              >
                {promoLoading
                  ? "Applying..."
                  : isPromoApplied
                    ? "Applied"
                    : "Apply"}
              </Button>
            </div>

            <div className="d-flex justify-content-between mt-2">
              <span className="fw-bold">Promo Discount:</span>
              <span className="fw-bold text-danger">
                - ₹{promoDiscount.toFixed(2)}
              </span>
            </div>

            {/* Total including shipping */}
            <h5 className="text-end mt-3 fw-bold">
              Total: ₹
              {(
                Number(total || 0) +
                Number(shippingCost || 0) -
                Number(promoDiscount || 0)
              ).toFixed(2)}
            </h5>

            {/* <h5 className="text-end mt-3 fw-bold">Total: ₹{total}</h5> */}

            <div className="text-end mt-3">
              <Button variant="primary" onClick={handlePlaceOrder}>
                Place Order
              </Button>
            </div>
          </div>
        </Collapse>
      </Card>

      {/* ADD ADDRESS MODAL */}
      <Modal
        show={showAddAddress}
        onHide={() => setShowAddAddress(false)}
        centered
        size="lg"
      >
        <Modal.Header closeButton>
          <Modal.Title>Add Delivery Address</Modal.Title>
        </Modal.Header>

        <Modal.Body>
          <Form>
            <Row>
              <Col md={4}>
                <Form.Label>First Name</Form.Label>
                <Form.Control
                  value={formData.first_name}
                  onChange={(e) =>
                    setFormData({ ...formData, first_name: e.target.value })
                  }
                />
              </Col>

              <Col md={4}>
                <Form.Label>Last Name</Form.Label>
                <Form.Control
                  value={formData.last_name}
                  onChange={(e) =>
                    setFormData({ ...formData, last_name: e.target.value })
                  }
                />
              </Col>
              <Col md={4}>
                <Form.Label className="mt-0">Phone</Form.Label>
                <Form.Control
                  value={formData.phone}
                  onChange={(e) =>
                    setFormData({ ...formData, phone: e.target.value })
                  }
                />
              </Col>
            </Row>

            <Row className="mt-2">
              <Col md={4}>
                <Form.Label>Country</Form.Label>
                <Form.Select
                  value={formData.country_id}
                  onChange={(e) => {
                    const c = countries.find(
                      (x) => x.id === Number(e.target.value)
                    );
                    setFormData({
                      ...formData,
                      country_id: e.target.value,
                      country: c?.name || "",
                      division_id: "",
                      district_id: "",
                    });
                    fetchDivisions(e.target.value);
                  }}
                >
                  <option value="">Select</option>
                  {countries.map((c) => (
                    <option key={c.id} value={c.id}>
                      {c.name}
                    </option>
                  ))}
                </Form.Select>
              </Col>

              <Col md={4}>
                <Form.Label>State</Form.Label>
                <Form.Select
                  value={formData.division_id}
                  onChange={(e) => {
                    const d = divisions.find(
                      (x) => x.id === Number(e.target.value)
                    );
                    setFormData({
                      ...formData,
                      division_id: e.target.value,
                      state: d?.name || "",
                      district_id: "",
                    });
                    fetchDistricts(e.target.value);
                  }}
                >
                  <option value="">Select</option>
                  {divisions.map((d) => (
                    <option key={d.id} value={d.id}>
                      {d.name}
                    </option>
                  ))}
                </Form.Select>
              </Col>

              <Col md={4}>
                <Form.Label>City</Form.Label>
                <Form.Select
                  value={formData.district_id}
                  onChange={(e) => {
                    const d = districts.find(
                      (x) => x.id === Number(e.target.value)
                    );
                    setFormData({
                      ...formData,
                      district_id: e.target.value,
                      city: d?.name || "",
                    });
                  }}
                >
                  <option value="">Select</option>
                  {districts.map((d) => (
                    <option key={d.id} value={d.id}>
                      {d.name}
                    </option>
                  ))}
                </Form.Select>
              </Col>
            </Row>
            <Row>
              <Col md={4}>
                <Form.Label className="mt-2">Address</Form.Label>
                <Form.Control
                  value={formData.address}
                  onChange={(e) =>
                    setFormData({ ...formData, address: e.target.value })
                  }
                />
              </Col>
              <Col md={4}>
                <Form.Label className="mt-2">ZIP Code</Form.Label>
                <Form.Control
                  value={formData.zip}
                  onChange={(e) =>
                    setFormData({ ...formData, zip: e.target.value })
                  }
                />
              </Col>
            </Row>

            <Form.Check
              className="mt-3"
              label="Set as default address"
              checked={formData.is_default}
              onChange={(e) =>
                setFormData({ ...formData, is_default: e.target.checked })
              }
            />
          </Form>
        </Modal.Body>

        <Modal.Footer>
          <Button variant="secondary" onClick={() => setShowAddAddress(false)}>
            Cancel
          </Button>
          <Button variant="dark" onClick={saveCheckoutAddress}>
            Save Address
          </Button>
        </Modal.Footer>
      </Modal>
    </div>
  );
}
