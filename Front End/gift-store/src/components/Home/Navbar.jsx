import React, { useState, useEffect } from "react";
import { Navbar, Nav, NavDropdown, Container, Badge } from "react-bootstrap";
import { Link } from "react-router-dom";
import { Search, User, Heart, ShoppingCart } from "lucide-react";
import { useCart } from "../../context/CartContext";
import AuthModal from "../Auth/AuthModal";
import "../../styles/Navbar.css";
import { useWishlist } from "../../context/WishlistContext";

export default function AppNavbar() {
  const { cart } = useCart();
  const cartCount = cart.reduce((sum, item) => sum + item.qty, 0);
  const [showAuth, setShowAuth] = useState(false);
  const { wishlist } = useWishlist();
  const [user, setUser] = useState(null);

  useEffect(() => {
    const storedUser = JSON.parse(localStorage.getItem("user"));
    setUser(storedUser);
  }, []);

  // Logout function
  const handleLogout = () => {
    localStorage.removeItem("user");
    localStorage.removeItem("token");
    setUser(null);
    window.location.reload();
  };

  return (
    <>
      <Navbar expand="lg" bg="black" variant="dark" className="py-3">
        <Container fluid>
          {/* Logo */}
          <Navbar.Brand as={Link} to="/">
            <img src="/assets/Animezz-logo.jpg" alt="Logo" height="90" />
          </Navbar.Brand>

          <Navbar.Toggle aria-controls="main-navbar"  />
          <Navbar.Collapse id="main-navbar">
            {/* Menu Items */}
            <Nav className="me-auto">
              <Nav.Link as={Link} to="/">
                Home
              </Nav.Link>

              <NavDropdown title="Poster" id="poster-dropdown">
                <NavDropdown.Item as={Link} to="/catagories/posters/1">One piece</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/posters/5">Demon Slayer</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/posters/11">Marvels</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/posters/2">JujutsuKaisen</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/posters/3">Naruto</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/posters/4">DragonBallz</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/posters/6">Attack On Titan</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/posters/7">Chainsaw Man</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/posters/8">Bleach</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/posters/12">Cars</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/posters/10">My Hero Academia</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/posters/9">Solo Leveling</NavDropdown.Item>
              </NavDropdown>

              <NavDropdown title="Action Figures" id="figures-dropdown">
                <NavDropdown.Item as={Link} to="/catagories/action-figures/16">Dragon Ball Z</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/action-figures/17">Demon Slayer</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/action-figures/13">One piece</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/action-figures/15">Naruto</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/action-figures/14">Jujutsu Kaisen</NavDropdown.Item>
                {/* <NavDropdown.Item as={Link} to="/figures/anime">BerSerk</Nav Dropdown.Item> */}
                <NavDropdown.Item as={Link} to="/catagories/action-figures/20">Bleach</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/action-figures/23">Marvels</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/action-figures/21">Solo Leveling</NavDropdown.Item>
                {/* <NavDropdown.Item as={Link} to="/figures/anime">DC</NavDropdown.Item> */}
                {/* <NavDropdown.Item as={Link} to="/figures/anime">Death Note</NavDropdown.Item> */}
                {/* <NavDropdown.Item as={Link} to="/figures/anime">Pokemon</NavDropdown.Item> */}
                <NavDropdown.Item as={Link} to="/catagories/action-figures/22">My Hero Academia</NavDropdown.Item>
                {/* <NavDropdown.Item as={Link} to="/figures/anime">Miniature Figures</NavDropdown.Item> */}
                {/* <NavDropdown.Item as={Link} to="/figures/anime">Bobble Head</NavDropdown.Item> */}
                <NavDropdown.Item as={Link} to="/catagories/action-figures/19">Chainsaw Man</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/action-figures/18">Attack  On Titan</NavDropdown.Item>
              </NavDropdown>

              {/* <NavDropdown title="Metal Posters" id="metal-dropdown">
                <NavDropdown.Item as={Link} to="/metal/metal-demon-slayer">
                  Demon Slayer
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/metal/JujutsuKaisen">
                  Jujutsu Kaisen
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/metal/BleachMetalPoster">
                  Bleach Metal Poster
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/metal/Naruto">
                  Naruto
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/metal/AttackOnTitan">
                  Attack On Titan
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/metal/berserk">
                  Bersek
                </NavDropdown.Item>
              </NavDropdown> */}

              {/* <NavDropdown title="Frames" id="frames-dropdown">
                <NavDropdown.Item as={Link} to="/frames/photo">
                  Naruto
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/frames/photo">
                  One piece
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/frames/photo">
                  BerSerk
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/frames/photo">
                  Dragon Ball Z
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/frames/photo">
                  One-Punch Man
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/frames/photo">
                  Demon Slayer
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/frames/photo">
                  Bleach
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/frames/photo">
                  {" "}
                  Solo Leveling
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/frames/photo">
                  {" "}
                  Vaga bond
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/frames/photo">
                  {" "}
                  Solo Leveling
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/frames/photo">
                  {" "}
                  Sakamoto Days
                </NavDropdown.Item>
              </NavDropdown> */}

              <NavDropdown title="Weapons" id="weapons-dropdown">
                <NavDropdown.Item as={Link} to="/catagories/Weapons/59">Wooden Katana</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/Weapons/61">Led Katana</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/Weapons/62">Katana Stand</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/Weapons/63">Mini Katana</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/Weapons/64">Karambit</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/Weapons/65">Solo Leveling Daggers</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/Weapons/66">Demon Slayer Weapons</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/Weapons/67">Jujutsu Kaisen Katana</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/Weapons/68">One Piece Weapons</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/Weapons/69">Bleach Weapons</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/Weapons/70">Naruto Weapons</NavDropdown.Item>
              </NavDropdown>

              <NavDropdown title="Mobile Covers" id="mobile-covers-dropdown">
                {/* iOS Submenu */}
                <NavDropdown title="iOS" id="ios-dropdown" drop="end">
                  <NavDropdown.Item as={Link} to="/catagories/MobileCover/IOS/Ios">iPhone 11</NavDropdown.Item>
                  {/* <NavDropdown.Item as={Link} to="/mobile-cover/ios/iphone-11pro">iPhone 11 Pro</NavDropdown.Item>
                  <NavDropdown.Item as={Link} to="/mobile-cover/ios/iphone-13pro">iPhone 13 Pro</NavDropdown.Item> */}
                </NavDropdown>

                {/* Android Submenu */}
                <NavDropdown title="Android" id="android-dropdown" drop="end">
                  <NavDropdown.Item as={Link} to="/catagories/MobileCover/Android/android">Oppo</NavDropdown.Item>
                  {/* <NavDropdown.Item as={Link} to="/mobile-cover/android/vivo">Vivo</NavDropdown.Item>
                  <NavDropdown.Item as={Link} to="/mobile-cover/android/realme">Realme</NavDropdown.Item>
                  <NavDropdown.Item as={Link} to="/mobile-cover/android/samsung">Samsung</NavDropdown.Item> */}
                </NavDropdown>
              </NavDropdown>

              <NavDropdown title="DeskMates" id="deskmates-dropdown">
                <NavDropdown.Item as={Link} to="/catagories/deskmates/82">
                  Jujutsu Kaisen
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/deskmates/83">
                  Naruto
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/deskmates/84">
                  One Piece
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/deskmates/85">
                  Berserk
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/deskmates/86">
                  Demon Slayer
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/catagories/deskmates/87">
                  Dragon Ball Z
                </NavDropdown.Item>
              </NavDropdown>

              {/* <NavDropdown title="Fridge Magnet" id="magnet-dropdown">
                <NavDropdown.Item as={Link} to="/magnets/anime">
                  Naruto
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/magnets/anime">
                  Demon Slayer
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/magnets/anime">
                  One Piece
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/magnets/anime">
                  Dragon Ball Z
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/magnets/anime">
                  Jujutsu Kaisen
                </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/magnets/anime">
                  Marvel
                </NavDropdown.Item>
              </NavDropdown> */}

              <NavDropdown title="Merch" id="merch-dropdown">
                {/* <NavDropdown.Item as={Link} to="/mousepads/anime"> Oversize Tshirts</NavDropdown.Item> */}
                <NavDropdown.Item as={Link} to="/Catagories/Merch/88">Hoodies</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/Merch/89">Tshirts</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/Merch/90">Oversized</NavDropdown.Item>


              </NavDropdown>

              <NavDropdown title="Keychains" id="keychains-dropdown">
                <NavDropdown.Item as={Link} to="/Catagories/keychains/91">Metal keychains</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/92">Katana keychains</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/93">One-piece</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/94">Jujutsu Kaisen</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/95">Naruto</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/96">Dragon Ball Z</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/97">Demon Slayer</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/98">Chainsaw Man </NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/99">Marvels</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/100">Hello kitty</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/101">Princess</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/102">Tom and jerry</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/103">Panda</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/104">Cricketers</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/105">Miles morals Spider-Man</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/106">Unicorn</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/107">Astronaut</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/108">Batman</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/109">Superman</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/110">Pokemon</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/111">Doremon</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/112">Footballers</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/113">Starbucks</NavDropdown.Item>
                <NavDropdown.Item as={Link} to="/Catagories/keychains/114">Camera keychains</NavDropdown.Item>
              </NavDropdown>
            </Nav>

            {/* Right Side Icons */}
            <Nav className="ms-auto d-flex align-items-center gap-3">
              <Nav.Link as={Link} to="/search">
                <Search />
              </Nav.Link>

              {/* 👇 User Icon opens modal */}
              {user ? (
                <NavDropdown
                  title={
                    <span>
                      <User /> {user.name}
                    </span>
                  }
                  id="user-dropdown"
                  align="end"
                >
                  <NavDropdown.Item as={Link} to="/myprofile">
                    Profile
                  </NavDropdown.Item>
                  <NavDropdown.Item as={Link} to="/change-password">
                    Change Password
                  </NavDropdown.Item>
                  <NavDropdown.Item as={Link} to="/myorder">
                    My Orders
                  </NavDropdown.Item>

                  <NavDropdown.Item as={Link} to="/save-address">
                    SavedAddress
                  </NavDropdown.Item>
                  <NavDropdown.Item onClick={handleLogout}>
                    Logout
                  </NavDropdown.Item>
                </NavDropdown>
              ) : (
                <Nav.Link onClick={() => setShowAuth(true)}>
                  <User />
                </Nav.Link>
              )}

              <Nav.Link as={Link} to="/wishlist" className="position-relative">
                <Heart />
                {wishlist.length > 0 && (
                  <Badge
                    bg="danger"
                    pill
                    className="position-absolute top-0 start-100 translate-middle"
                  >
                    {wishlist.length}
                  </Badge>
                )}
              </Nav.Link>

              <Nav.Link as={Link} to="/cart" className="position-relative">
                <ShoppingCart />
                {cartCount > 0 && (
                  <Badge
                    bg="danger"
                    pill
                    className="position-absolute top-0 start-100 translate-middle"
                  >
                    {cartCount}
                  </Badge>
                )}
              </Nav.Link>
            </Nav>
          </Navbar.Collapse>
        </Container>
      </Navbar>

      {/* Auth Modal */}
      <AuthModal show={showAuth} handleClose={() => setShowAuth(false)} />
    </>
  );
}
