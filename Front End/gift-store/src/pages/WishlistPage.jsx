// // src/pages/WishlistPage.jsx
// import React from "react";
// import { Container, Row, Col, Card, Button } from "react-bootstrap";
// import { motion } from "framer-motion";
// import { useWishlist } from "../context/WishlistContext";
// import { useCart } from "../context/CartContext";
// import { Link } from "react-router-dom";

// export default function WishlistPage() {
//   const { wishlist, removeFromWishlist } = useWishlist();
//   const { addToCart, cart } = useCart();

//   const isInCart = (id) => cart.some((c) => c.id === id);

//   if (wishlist.length === 0)
//     return (
//       <Container className="text-center py-5">
//         <h3 className="mb-3">Your Wishlist is Empty 💔</h3>
//         <p>Looks like you haven’t added any items yet.</p>
//         <Button as={Link} to="/" variant="dark">
//           Browse Products
//         </Button>
//       </Container>
//     );

//   return (
//     <Container className="py-5">
//       <h2 className="text-center mb-4">My Wishlist ❤️</h2>
//       <Row className="g-4">
//         {wishlist.map((item) => (
//           <Col key={item.id} xs={12} sm={6} md={4} lg={3}>
//             <motion.div
//               whileHover={{ scale: 1.05 }}
//               initial={{ opacity: 0, y: 20 }}
//               animate={{ opacity: 1, y: 0 }}
//               transition={{ duration: 0.4 }}
//             >
//               <Card className="text-center shadow-sm">
//                 <Card.Img
//                   variant="top"
//                   src={`http://127.0.0.1:8001/${item.image_path}`}
//                   alt={item.name}
//                   style={{ height: "250px", objectFit: "cover" }}
//                 />
//                 <Card.Body>
//                   <Card.Title className="fw-bold">{item.name}</Card.Title>
//                   <div className="mb-2 text-danger fw-bold">₹{item.current_sale_price}</div>
//                   <div className="d-flex justify-content-between">
//                     <Button
//                       variant="warning"
//                       disabled={isInCart(item.id)}
//                       onClick={() => addToCart(item, 1)}
//                     >
//                       {isInCart(item.id) ? "Added" : "Add to Cart"}
//                     </Button>
//                     <Button
//                       variant="outline-danger"
//                       onClick={() => removeFromWishlist(item.id)}
//                     >
//                       Remove
//                     </Button>
//                   </div>
//                 </Card.Body>
//               </Card>
//             </motion.div>
//           </Col>
//         ))}
//       </Row>
//     </Container>
//   );
// }
import React, { useEffect } from "react";
import { Container, Row, Col, Card, Button } from "react-bootstrap";
import { motion } from "framer-motion";
import { useWishlist } from "../context/WishlistContext";
import { useCart } from "../context/CartContext";
import { Link } from "react-router-dom";

export default function WishlistPage() {
  const { wishlist, removeFromWishlist, fetchWishlist } = useWishlist();
  const { addToCart, cart } = useCart();

  const isInCart = (id) => cart.some((c) => c.id === id);

  // 🔥 API CALL here
  useEffect(() => {
    fetchWishlist();
  }, []);

  if (wishlist.length === 0)
    return (
      <Container className="text-center py-5">
        <h3 className="mb-3">Your Wishlist is Empty 💔</h3>
        <p>Looks like you haven’t added any items yet.</p>
        <Button as={Link} to="/" variant="dark">
          Browse Products
        </Button>
      </Container>
    );

  return (
    <Container className="py-5">
      <h2 className="text-center mb-4">My Wishlist ❤️</h2>
      <Row className="g-4">
        {wishlist.map((item) => (
          <Col key={item.id} xs={12} sm={6} md={4} lg={3}>
            <motion.div
              whileHover={{ scale: 1.05 }}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.4 }}
            >
              <Card className="text-center shadow-sm">
                <Card.Img
                  variant="top"
                  src={`http://127.0.0.1:8001/${item.product.image_path}`}
                  alt={item.product.name}
                  style={{ height: "250px", objectFit: "cover" }}
                />
                <Card.Body>
                  <Card.Title className="fw-bold">{item.product.name}</Card.Title>
                  <div className="mb-2 text-danger fw-bold">
                    ₹{item.product.current_sale_price}
                  </div>
                  <div className="d-flex justify-content-between">
                    <Button
                      variant="warning"
                      disabled={isInCart(item.product.id)}
                      onClick={() => addToCart(item.product, 1)}
                    >
                      {isInCart(item.id) ? "Added" : "Add to Cart"}
                    </Button>
                    <Button
                      variant="outline-danger"
                      onClick={() => removeFromWishlist(item.product.id)}
                    >
                      Remove
                    </Button>
                  </div>
                </Card.Body>
              </Card>
            </motion.div>
          </Col>
        ))}
      </Row>
    </Container>
  );
}
