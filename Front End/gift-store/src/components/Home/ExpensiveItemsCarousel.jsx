import { Container, Card, Button } from "react-bootstrap";
import { FaChevronLeft, FaChevronRight } from "react-icons/fa";
import { useRef, useEffect, useState } from "react";
import "../../styles/ItemCarousel.css";
import { useCart } from "../../context/CartContext";
import { useNavigate } from "react-router-dom";
import { Heart } from "lucide-react";
import { toast } from "react-toastify";
import { useWishlist } from "../../context/WishlistContext";


export default function ItemScroller() {
  const { addToCart } = useCart();
  const navigate = useNavigate();
  const scrollRef = useRef(null);
  const intervalRef = useRef(null);

  const [isPaused, setIsPaused] = useState(false);
  // const [wishlist, setWishlist] = useState([]);
  const { wishlist, addToWishlist } = useWishlist();

  const [expensiveItems, setExpensiveItems] = useState([]);

  // 🔥 Fetch expensive items from API
  useEffect(() => {
    fetch("http://127.0.0.1:8001/api/products")
      .then((res) => res.json())
      .then((data) => {
        if (Array.isArray(data)) {
          const filtered = data.filter(
            (item) => Number(item.current_sale_price) > 1000
          );
          setExpensiveItems(filtered);
        }
      })
      .catch((err) => console.error("Error fetching items:", err));
  }, []);

  const scroll = (direction) => {
    if (scrollRef.current) {
      const scrollAmount = 300;
      scrollRef.current.scrollBy({
        left: direction === "left" ? -scrollAmount : scrollAmount,
        behavior: "smooth",
      });
    }
  };
  const handleWishlist = (item) => addToWishlist(item);
  // const handleWishlist = (item) => {
  //   if (wishlist.includes(item.id)) {
  //     setWishlist(wishlist.filter((id) => id !== item.id));
  //     toast.info(`💔 Removed "${item.name}" from wishlist`);
  //   } else {
  //     setWishlist([...wishlist, item.id]);
  //     toast.success(`❤️ Added "${item.name}" to wishlist`);
  //   }
  // };

  // 🔄 Autoplay scroll
  useEffect(() => {
    if (!isPaused) {
      intervalRef.current = setInterval(() => {
        if (scrollRef.current) {
          const { scrollLeft, scrollWidth, clientWidth } = scrollRef.current;

          if (scrollLeft + clientWidth >= scrollWidth) {
            scrollRef.current.scrollTo({ left: 0, behavior: "smooth" });
          } else {
            scrollRef.current.scrollBy({ left: 300, behavior: "smooth" });
          }
        }
      }, 3000);
    }
    return () => clearInterval(intervalRef.current);
  }, [isPaused]);

  return (
    <section className="bg-dark text-light py-5 position-relative item-scroller-section">
      <Container fluid>
        {/* Left Arrow */}
        <button className="scroll-btn left" onClick={() => scroll("left")}>
          <FaChevronLeft size={28} />
        </button>

        {/* Scrollable Items */}
        <div
          className="scroller"
          ref={scrollRef}
          onMouseEnter={() => setIsPaused(true)}
          onMouseLeave={() => setIsPaused(false)}
        >
          {expensiveItems.map((item) => (
            <Card key={item.id} className="item-card">
              <div
                onClick={() => navigate(`/product/${item.id}`)}
                style={{ cursor: "pointer" }}
              ></div>
              <Card.Img variant="top" src={`http://127.0.0.1:8001/${item.image_path}`} alt={item.name} />

              <Card.Body className="text-center">
                <Card.Title
                  className="item-title h6"
                  onClick={() => navigate(`/category/details/${item.id}`)}
                  style={{ cursor: "pointer" }}
                >
                  {item.name}
                </Card.Title>

                <div className="d-flex justify-content-center gap-2">
                  <span className="text-danger fw-bold current-price">
                    ₹{item.current_sale_price}
                  </span>
                  {item.old_price && (
                    <span className="text-muted text-decoration-line-through old-price">
                      ₹{item.old_price}
                    </span>
                  )}
                </div>

                <div className="d-flex gap-2 mt-3 justify-content-between">
                  <Button
                    variant="success"
                    className="w-50 add-cart-btn btn-sm"
                    onClick={(e) => {
                      e.stopPropagation();      // stop navigation click event
                      addToCart(item, 1);
                    }}
                  >
                    Add to Cart
                  </Button>

                  <Button
                    variant="outline-light text-black"
                    className="w-50 d-flex align-items-center justify-content-center gap-2 btn-sm"
                    onClick={(e) => {
                      e.stopPropagation();
                      handleWishlist(item);
                    }}
                  >
                    <Heart
                      size={18}
                      fill={
                        wishlist.some((w) => w.product_id === item.id) ? "red" : "none"
                      }
                      color={
                        wishlist.some((w) => w.product_id === item.id) ? "red" : "black"
                      }
                    />
                    Wishlist
                  </Button>
                </div>
              </Card.Body>
            </Card>
          ))}
        </div>

        {/* Right Arrow */}
        <button className="scroll-btn right" onClick={() => scroll("right")}>
          <FaChevronRight size={28} />
        </button>

        {/* View All Button */}
        <div className="text-center mt-4">
          <Button
            variant="light"
            className="view-all-btn fw-bold px-4 py-2"
            onClick={() => navigate("/expensive-items")}
          >
            View All
          </Button>
        </div>
      </Container>
    </section>
  );
}
