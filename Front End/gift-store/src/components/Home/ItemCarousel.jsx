import { Container, Card, Button } from "react-bootstrap";
import { FaChevronLeft, FaChevronRight } from "react-icons/fa";
import { useRef, useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { useCart } from "../../context/CartContext";
import { Heart } from "lucide-react";
import { useWishlist } from "../../context/WishlistContext";

export default function ItemCarousel() {
  const navigate = useNavigate();
  const { addToCart } = useCart();
  const { wishlist, addToWishlist } = useWishlist();

  const scrollRef = useRef(null);
  const [items, setItems] = useState([]);

  // 🔥 Fetch ALL products, filter < ₹299, show ONLY 8
  useEffect(() => {
    fetch("http://127.0.0.1:8001/api/products")
      .then((res) => res.json())
      .then((data) => {
        const budgetItems = data.filter(
          (item) => Number(item.current_sale_price) < 299
        );

        setItems(budgetItems.slice(0, 8)); // 👈 carousel limit
      })
      .catch((err) => console.error("Failed to load products", err));
  }, []);

  const scroll = (dir) => {
    scrollRef.current.scrollBy({
      left: dir === "left" ? -300 : 300,
      behavior: "smooth",
    });
  };

  return (
    <section className="bg-dark py-5 position-relative">
      <Container fluid>

        {/* LEFT ARROW */}
        <button className="scroll-btn left" onClick={() => scroll("left")}>
          <FaChevronLeft />
        </button>

        {/* ITEMS */}
        <div className="scroller" ref={scrollRef}>
          {items.map((item) => (
            <Card key={item.id} className="item-card text-dark">
              <Card.Img
                src={`http://127.0.0.1:8001/${item.image_path}`}
                style={{ cursor: "pointer", height: "180px", objectFit: "contain" }}
                onClick={() => navigate(`/category/details/${item.id}`)}
              />

              <Card.Body className="text-center">
                <h6 className="mb-1">{item.name}</h6>
                <p className="fw-bold text-danger mb-2">
                  ₹{item.current_sale_price}
                </p>

                <div className="d-flex justify-content-center gap-2">
                  <Button
                    size="sm"
                    variant="success"
                    onClick={() => addToCart(item, 1)}
                  >
                    Add
                  </Button>

                  <Button
                    size="sm"
                    variant="outline-dark"
                    onClick={() => addToWishlist(item)}
                  >
                    <Heart
                      size={16}
                      fill={
                        wishlist.some((w) => w.product_id === item.id)
                          ? "red"
                          : "none"
                      }
                      color={
                        wishlist.some((w) => w.product_id === item.id)
                          ? "red"
                          : "black"
                      }
                    />
                  </Button>
                </div>
              </Card.Body>
            </Card>
          ))}
        </div>

        {/* RIGHT ARROW */}
        <button className="scroll-btn right" onClick={() => scroll("right")}>
          <FaChevronRight />
        </button>

        {/* ✅ VIEW ALL → Budget Items */}
        <div className="text-center mt-4">
          <Button
            variant="light"
            className="fw-bold px-4"
            onClick={() => navigate("/items")}
          >
            View All
          </Button>
        </div>

      </Container>
    </section>
  );
}
