import "../../styles/CategorySlider.css";
import { useNavigate } from "react-router-dom";


const categories = [
  // { name: "Posters", img: "/assets/Poster.webp" },
  // { name: "Led Katana", img: "/assets/Led Cotana.webp" },
  // { name: "Wooden Katana", img: "/assets/Wooden Catana.webp" },
  // { name: "Action Figures", img: "/assets/Action Figure.webp" },
  // { name: "Weapons & Accessories", img: "/assets/Weapon & Accessories.webp" },
  // { name: "Katana Keychains", img: "/assets/Kotana KeyChain.webp" },
  // { name: "DeskMates", img: "/assets/Deskmates.webp" },
  // { name: "Metal Posters", img: "/assets/Metal Poster.webp" },
  // { name: "Frames", img: "/assets/Frames.webp" },
  { id: 1, name: "Posters", img: "/assets/Poster.webp" },
  { id: 2, name: "Action Figures", img: "/assets/Action Figure.webp" },
  { id: 3, name: "Keychains", img: "/assets/keychain.webp" },
  // { id: 4, name: "Katana", img: "/assets/Katana-Banner.png" },
  // { id: 5, name: "Led Katana", img: "/assets/weapons/lead-katana/led-katana banner2.webp" },
  { id: 6, name: "Deskmates", img: "/assets/Deskmates.webp" },
  { id: 7, name: "Merch", img: "/assets/merch/hoodies/hoodies-banner.webp" },
  { id: 8, name: "Mobile Covers", img: "/assets/mobileCover/Android/mobile-banner.webp" },
  { id: 9, name: "Weapons", img: "/assets/Weapon & Accessories.webp" },
  { id: 10, name: "Mystery Gifts", img: "/assets/FreeGifts-2.jpg" },
];

export default function CategorySlider() {
  const navigate = useNavigate();

  return (
    <section className="category-section py-4">
      <h2 className="text-center fw-bold mb-4 text-uppercase">
        Shop by Category
      </h2>

      <div className="category-slider">
        {categories.map((cat) => (
          <div
            key={cat.id}
            className="category-item"
            onClick={() => navigate(`/category/${cat.id}`)}
          >
            <div className="category-img-container">
              <img
                src={cat.img}
                alt={cat.name}
                className="category-img"
                loading="lazy"
              />
            </div>
            <p className="category-name">{cat.name}</p>
          </div>
        ))}
      </div>
    </section>
  );
}
