import React, { useState, useEffect } from "react";
import { Card, Container, Form, Modal, Button } from "react-bootstrap";
import { motion } from "framer-motion";
import "../../styles/MyOrders.css";
import { toast } from "react-toastify";
import axios from "axios";
import moment from "moment";
import { Download } from "lucide-react";

/* ================= HELPERS ================= */

const getToken = () => localStorage.getItem("token");

const authHeader = () => ({
  Authorization: `Bearer ${getToken()}`,
  Accept: "application/json",
});

/* ================= COMPONENT ================= */

export default function MyOrdersPage() {
  const formatDate = (date) =>
    date ? moment(date).format("DD MMM YYYY, hh:mm A") : "—";

  /* ========== MODAL STATES ========== */
  const [showTrack, setShowTrack] = useState(false);
  const [selectedOrder, setSelectedOrder] = useState(null);
  const [orderTracking, setOrderTracking] = useState(null);

  const [showReview, setShowReview] = useState(false);
  const [reviewOrder, setReviewOrder] = useState(null);
  const [reviewProduct, setReviewProduct] = useState(null);
  const [rating, setRating] = useState(0);
  const [reviewText, setReviewText] = useState("");

  const [showReturn, setShowReturn] = useState(false);
  const [returnOrder, setReturnOrder] = useState(null);
  const [returnReason, setReturnReason] = useState("");
  const [returnComment, setReturnComment] = useState("");
  const [returnImage, setReturnImage] = useState(null);

  const [showCancel, setShowCancel] = useState(false);
  const [cancelOrder, setCancelOrder] = useState(null);
  const [cancelReason, setCancelReason] = useState("");
  const [cancelComment, setCancelComment] = useState("");

  /* ========== ORDERS ========== */
  const [allOrders, setAllOrders] = useState([]);
  const [loading, setLoading] = useState(false);

  /* ========== FILTERS ========== */
  const [searchText, setSearchText] = useState("");
  const [statusFilter, setStatusFilter] = useState("");
  const [timeFilter, setTimeFilter] = useState("");

  /* ========== STATUS MAP ========== */
  const orderStatusMap = {
    0: "Pending",
    1: "Processing",
    2: "Shipped",
    3: "Cancel Requested",
    4: "Cancel Accepted",
    5: "Cancel Completed",
    6: "Delivered",
    7: "Out For Delivery",
    8: "Return Requested",
    9: "Return Approved",
    10: "Return Rejected",
    11: "Refund Completed",
  };

  const getOrderStatusLabel = (status) => orderStatusMap[status] || "Unknown";

  /* ========== FETCH ORDERS ========== */
  useEffect(() => {
    const fetchOrders = async () => {
      setLoading(true);
      try {
        if (!getToken()) {
          toast.error("Please login again");
          return;
        }

        const res = await axios.get("http://127.0.0.1:8001/api/user/orders", {
          headers: authHeader(),
        });

        if (res.data?.status === true) {
          setAllOrders(res.data.orders || []);
        } else {
          toast.error(res.data?.message || "Failed to fetch orders");
          setAllOrders([]);
        }
      } catch (error) {
        console.error(error);
        toast.error(error?.response?.data?.message || "Error fetching orders");
      } finally {
        setLoading(false);
      }
    };

    fetchOrders();
  }, []);

  /* ========== FILTER LOGIC ========== */
  const filteredOrders = allOrders.filter((order) => {
    const matchesSearch = order.invoice_id
      ?.toLowerCase()
      .includes(searchText.toLowerCase());

    const matchesStatus =
      !statusFilter ||
      (statusFilter === "Cancelled" &&
        [3, 4, 5].includes(order.order_status)) ||
      (statusFilter === "Returned" &&
        [8, 9, 10, 11].includes(order.order_status)) ||
      getOrderStatusLabel(order.order_status) === statusFilter;

    const orderDate = moment(order.date);

    const matchesTime =
      !timeFilter ||
      (timeFilter === "last30" &&
        orderDate.isAfter(moment().subtract(30, "days"))) ||
      (timeFilter === "2024" && orderDate.year() === 2024);

    return matchesSearch && matchesStatus && matchesTime;
  });

  /* ========== DOWNLOAD INVOICE ========== */
  const downloadInvoice = async (orderId) => {
    try {
      const response = await axios.get(
        `http://127.0.0.1:8001/api/user/orders/${orderId}/invoice`,
        {
          headers: authHeader(),
          responseType: "blob",
        }
      );

      const url = window.URL.createObjectURL(
        new Blob([response.data], { type: "application/pdf" })
      );

      const link = document.createElement("a");
      link.href = url;
      link.download = `invoice_${orderId}.pdf`;
      document.body.appendChild(link);
      link.click();
      link.remove();

      toast.success("Invoice downloaded");
    } catch (error) {
      console.error(error);
      toast.error("Failed to download invoice");
    }
  };

  /* ========== TRACK ORDER ========== */
  const openTrackModal = async (order) => {
    try {
      setSelectedOrder(order);
      setOrderTracking(null);
      setShowTrack(true);

      const res = await axios.get(
        `http://127.0.0.1:8001/api/order/track/${order.id}`,
        { headers: authHeader() }
      );

      if (res.data?.status === true) {
        setOrderTracking(res.data.order_details);
      } else {
        toast.error(res.data?.message);
      }
    } catch {
      toast.error("Unable to track order");
    }
  };

  const closeTrackModal = () => {
    setShowTrack(false);
    setSelectedOrder(null);
    setOrderTracking(null);
  };

  /* ========== CANCEL ORDER ========== */
  const submitCancelRequest = async () => {
    try {
      const res = await axios.post(
        "http://127.0.0.1:8001/api/order/cancel-request",
        {
          order_id: cancelOrder.id,
          reason: cancelReason,
          comment: cancelComment,
        },
        { headers: authHeader() }
      );

      if (res.data?.status) {
        toast.success("Cancellation request submitted");
        setShowCancel(false);
      } else {
        toast.error(res.data?.message);
      }
    } catch {
      toast.error("Cancel request failed");
    }
  };

  /* ========== RETURN REQUEST ========== */
  const submitReturnRequest = async () => {
    try {
      const formData = new FormData();
      formData.append("order_id", returnOrder.id);
      formData.append("reason", returnReason);
      formData.append("comment", returnComment);
      if (returnImage) formData.append("image", returnImage);

      const res = await axios.post(
        "http://127.0.0.1:8001/api/order/return-request",
        formData,
        { headers: authHeader() }
      );

      if (res.data?.status) {
        toast.success("Return request submitted");
        setShowReturn(false);
      } else {
        toast.error(res.data?.message);
      }
    } catch {
      toast.error("Return request failed");
    }
  };

  /* ================= JSX (UNCHANGED STRUCTURE) ================= */

  return (
    <div className="myorders-page py-5">
      <motion.h2
        className="text-center fw-bold mb-4 text-dark"
        initial={{ opacity: 0, y: -20 }}
        animate={{ opacity: 1, y: 0 }}
      >
        📦 My Orders
      </motion.h2>

      <Container className="d-flex">
        {/* FILTERS */}
        <Card className="filters-card p-3 me-4 shadow-sm border-0">
          <h5 className="filter-title">Filters</h5>

          <div className="filter-group">
            <p className="filter-label">ORDER STATUS</p>
            <Form.Check
              label="Delivered"
              type="radio"
              onChange={() => setStatusFilter("Delivered")}
            />
            <Form.Check
              label="Cancelled"
              type="radio"
              onChange={() => setStatusFilter("Cancelled")}
            />
            <Form.Check
              label="Returned"
              type="radio"
              onChange={() => setStatusFilter("Returned")}
            />
            <Form.Check
              label="Clear"
              type="radio"
              onChange={() => setStatusFilter("")}
            />
          </div>

          <div className="filter-group">
            <p className="filter-label">ORDER TIME</p>
            <Form.Check
              label="Last 30 Days"
              type="radio"
              onChange={() => setTimeFilter("last30")}
            />
            <Form.Check
              label="2024"
              type="radio"
              onChange={() => setTimeFilter("2024")}
            />
            <Form.Check
              label="Clear"
              type="radio"
              onChange={() => setTimeFilter("")}
            />
          </div>
        </Card>

        {/* ORDERS LIST */}
        <div className="flex-grow-1">
          {loading ? (
            <p className="text-center">Loading...</p>
          ) : (
            filteredOrders.map((order) => (
              <Card
                key={order.id}
                className="order-card shadow-sm mb-3 p-3 border-0"
              >
                <h5>{order.invoice_id}</h5>
                <p>₹{order.total_payable_amount}</p>
                <p>{getOrderStatusLabel(order.order_status)}</p>

                <div className="d-flex justify-content-between">
                  <button
                    className="track-btn"
                    onClick={() => openTrackModal(order)}
                  >
                    🚚 Track Order
                  </button>

                  {[0, 1].includes(order.order_status) && (
                    <button
                      className="cancel-btn"
                      onClick={() => setShowCancel(true)}
                    >
                      ❌ Cancel
                    </button>
                  )}

                  {order.order_status === 6 && (
                    <button
                      className="return-btn"
                      onClick={() => setShowReturn(true)}
                    >
                      🔄 Return
                    </button>
                  )}

                  <Button size="sm" onClick={() => downloadInvoice(order.id)}>
                    <Download size={18} /> Invoice
                  </Button>
                </div>
              </Card>
            ))
          )}
        </div>
      </Container>

      {/* TRACK MODAL */}
      <Modal show={showTrack} onHide={closeTrackModal} centered>
        <Modal.Header closeButton>
          <Modal.Title>📦 Order Tracking</Modal.Title>
        </Modal.Header>
        <Modal.Body>
          {orderTracking ? (
            <p>Status: {getOrderStatusLabel(orderTracking.order_status)}</p>
          ) : (
            <p>Loading...</p>
          )}
        </Modal.Body>
      </Modal>
    </div>
  );
}
