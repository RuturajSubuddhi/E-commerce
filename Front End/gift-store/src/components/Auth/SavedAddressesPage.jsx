import React, { useEffect, useState } from "react";
import axios from "axios";
import { Card, Button, Modal, Form, Row, Col } from "react-bootstrap";
import { toast } from "react-toastify";
import "../../styles/SavedAddresses.css";

export default function SavedAddressesPage() {
  const [addresses, setAddresses] = useState([]);
  const [showModal, setShowModal] = useState(false);
  const [editingAddress, setEditingAddress] = useState(null);

  // LOCATION DATA
  const [countries, setCountries] = useState([]);
  const [divisions, setDivisions] = useState([]);
  const [districts, setDistricts] = useState([]);

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

  const token = localStorage.getItem("token");
  const apiHeaders = { Authorization: `Bearer ${token}` };

  // =====================================
  // FETCH ADDRESSES
  // =====================================
  const fetchAddresses = async () => {
    try {
      const res = await axios.get(
        "http://127.0.0.1:8001/api/user/address/get",
        { headers: apiHeaders }
      );
      setAddresses(res.data.data || []);
    } catch (err) {
      toast.error("Failed to fetch addresses");
    }
  };

  // =====================================
  // FETCH LOCATION DATA
  // =====================================
  const fetchCountries = async () => {
    try {
      const res = await axios.get("http://127.0.0.1:8001/api/country/list");
      setCountries(Array.isArray(res.data) ? res.data : []);
    } catch (err) {
      console.error("Failed to fetch countries:", err);
      setCountries([]);
    }
  };

  const fetchDivisions = async (countryId) => {
    if (!countryId) return;
    try {
      const res = await axios.get(
        `http://127.0.0.1:8001/api/division/list?country_id=${countryId}`
      );
      setDivisions(Array.isArray(res.data) ? res.data : []);
      setDistricts([]);
    } catch (err) {
      console.error("Failed to fetch divisions:", err);
      setDivisions([]);
    }
  };

  const fetchDistricts = async (divisionId) => {
    if (!divisionId) return;
    try {
      const res = await axios.get(
        `http://127.0.0.1:8001/api/district/list?division_id=${divisionId}`
      );
      setDistricts(Array.isArray(res.data) ? res.data : []);
    } catch (err) {
      console.error("Failed to fetch districts:", err);
      setDistricts([]);
    }
  };

  useEffect(() => {
    fetchAddresses();
    fetchCountries();
  }, []);

  // =====================================
  // SAVE / UPDATE
  // =====================================
  const handleSave = async () => {
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

      if (editingAddress) {
        await axios.put(
          `http://127.0.0.1:8001/api/user/address/update/${editingAddress.id}`,
          payload,
          { headers: apiHeaders }
        );
        toast.success("Address updated");
      } else {
        await axios.post(
          "http://127.0.0.1:8001/api/user/savedAddress",
          payload,
          { headers: apiHeaders }
        );
        toast.success("Address added");
      }

      setShowModal(false);
      setEditingAddress(null);
      fetchAddresses();
    } catch (err) {
      toast.error("Failed to save address");
    }
  };

  // =====================================
  // EDIT
  // =====================================
  const handleEdit = async (addr) => {
    setEditingAddress(addr);

    const country = countries.find((c) => c.name === addr.shipping_country);

    setFormData({
      first_name: addr.first_name,
      last_name: addr.last_name,
      phone: addr.shipping_phone,
      address: addr.shipping_address,
      country: addr.shipping_country,
      state: addr.shipping_state,
      city: addr.shipping_city,
      country_id: country ? country.id : "",
      division_id: Number(addr.shipping_division),
      district_id: Number(addr.shipping_district),
      zip: addr.shipping_zip,
      is_default: addr.is_default === 1,
    });

    setShowModal(true);

    if (country) {
      await fetchDivisions(country.id);
      await fetchDistricts(Number(addr.shipping_division));
    }
  };

  // =====================================
  // DELETE
  // =====================================
  const handleDelete = async (id) => {
    if (!window.confirm("Delete address?")) return;
    await axios.delete(
      `http://127.0.0.1:8001/api/user/address/delete/${id}`,
      { headers: apiHeaders }
    );
    toast.success("Address deleted");
    fetchAddresses();
  };

  // =====================================
  // SET DEFAULT
  // =====================================
  const handleSetDefault = async (id) => {
    await axios.put(
      `http://127.0.0.1:8001/api/user/address/set-default/${id}`,
      {},
      { headers: apiHeaders }
    );
    toast.success("Default set");
    fetchAddresses();
  };

  // =====================================
  // UI
  // =====================================
  return (
    <div className="container mt-5">
      <h3 className="mb-4">Manage Addresses</h3>

      <Button
        variant="primary"
        onClick={() => {
          setEditingAddress(null);
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
          setDivisions([]);
          setDistricts([]);
          setShowModal(true);
        }}
      >
        + Add New Address
      </Button>

      <Row className="mt-4">
        {addresses.map((addr) => (
          <Col md={4} lg={3} key={addr.id} className="mb-3">
            <Card className="p-3 h-100 shadow-sm address-card">
              <h5>
                {addr.first_name} {addr.last_name}{" "}
                {addr.is_default === 1 && (
                  <span className="badge bg-success">Default</span>
                )}
              </h5>
              <p>{addr.shipping_address}</p>
              <p>
                {addr.shipping_city}, {addr.shipping_state}
              </p>
              <div className="d-flex gap-2 flex-wrap">
                <Button
                  size="sm"
                  variant="outline-primary"
                  onClick={() => handleEdit(addr)}
                >
                  Edit
                </Button>
                <Button
                  size="sm"
                  variant="outline-danger"
                  onClick={() => handleDelete(addr.id)}
                >
                  Delete
                </Button>
                {addr.is_default !== 1 && (
                  <Button
                    size="sm"
                    variant="outline-success"
                    onClick={() => handleSetDefault(addr.id)}
                  >
                    Set Default
                  </Button>
                )}
              </div>
            </Card>
          </Col>
        ))}
      </Row>

      {/* MODAL */}
      <Modal show={showModal} onHide={() => setShowModal(false)} centered>
        <Modal.Header closeButton>
          <Modal.Title>
            {editingAddress ? "Edit Address" : "Add Address"}
          </Modal.Title>
        </Modal.Header>

        <Modal.Body>
          <Form>
            <Row>
              <Col md={6}>
                <Form.Control
                  className="mb-2"
                  placeholder="First Name"
                  value={formData.first_name}
                  onChange={(e) =>
                    setFormData({ ...formData, first_name: e.target.value })
                  }
                />
              </Col>
              <Col md={6}>
                <Form.Control
                  className="mb-2"
                  placeholder="Last Name"
                  value={formData.last_name}
                  onChange={(e) =>
                    setFormData({ ...formData, last_name: e.target.value })
                  }
                />
              </Col>
            </Row>

            <Form.Control
              className="mb-2"
              placeholder="Phone"
              value={formData.phone}
              onChange={(e) =>
                setFormData({ ...formData, phone: e.target.value })
              }
            />
            <Form.Control
              className="mb-2"
              placeholder="Address"
              value={formData.address}
              onChange={(e) =>
                setFormData({ ...formData, address: e.target.value })
              }
            />

            {/* COUNTRY */}
            <Form.Select
              className="mb-2"
              value={formData.country_id}
              onChange={(e) => {
                const selectedCountry = countries.find(
                  (c) => c.id === Number(e.target.value)
                );
                setFormData({
                  ...formData,
                  country_id: e.target.value,
                  country: selectedCountry ? selectedCountry.name : "",
                  division_id: "",
                  district_id: "",
                });
                setDivisions([]);
                setDistricts([]);
                fetchDivisions(e.target.value);
              }}
            >
              <option value="">Select Country</option>
              {countries.map((c) => (
                <option key={c.id} value={c.id}>
                  {c.name}
                </option>
              ))}
            </Form.Select>

            {/* DIVISION / STATE */}
            <Form.Select
              className="mb-2"
              value={formData.division_id}
              onChange={(e) => {
                const selectedDivision = divisions.find(
                  (d) => d.id === Number(e.target.value)
                );
                setFormData({
                  ...formData,
                  division_id: e.target.value,
                  state: selectedDivision ? selectedDivision.name : "",
                  district_id: "",
                });
                setDistricts([]);
                fetchDistricts(e.target.value);
              }}
            >
              <option value="">Select State</option>
              {divisions.map((d) => (
                <option key={d.id} value={d.id}>
                  {d.name}
                </option>
              ))}
            </Form.Select>

            {/* DISTRICT / CITY */}
            <Form.Select
              className="mb-2"
              value={formData.district_id}
              onChange={(e) => {
                const selectedDistrict = districts.find(
                  (d) => d.id === Number(e.target.value)
                );
                setFormData({
                  ...formData,
                  district_id: e.target.value,
                  city: selectedDistrict ? selectedDistrict.name : "",
                });
              }}
            >
              <option value="">Select City</option>
              {districts.map((d) => (
                <option key={d.id} value={d.id}>
                  {d.name}
                </option>
              ))}
            </Form.Select>

            <Form.Control
              className="mb-2"
              placeholder="ZIP"
              value={formData.zip}
              onChange={(e) =>
                setFormData({ ...formData, zip: e.target.value })
              }
            />

            <Form.Check
              label="Set as default"
              checked={formData.is_default}
              onChange={(e) =>
                setFormData({ ...formData, is_default: e.target.checked })
              }
            />
          </Form>
        </Modal.Body>

        <Modal.Footer>
          <Button variant="secondary" onClick={() => setShowModal(false)}>
            Cancel
          </Button>
          <Button variant="primary" onClick={handleSave}>
            Save
          </Button>
        </Modal.Footer>
      </Modal>
    </div>
  );
}
