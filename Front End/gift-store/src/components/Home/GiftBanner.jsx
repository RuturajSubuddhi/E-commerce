import "../../styles/GiftBanner.css";

export default function GiftBanner() {
  return (
    <div className="w-100">
      <img src="../assets/GiftBanner-1.webp" alt="" loading="lazy" className="img-fluid w-100 mb-3"
        style={{ objectFit: "cover", height: "auto", maxHeight: "300px" }} />
      <img src="../assets/GiveBanner-2.webp" alt="" loading="lazy" className="img-fluid w-100 mb-3"
        style={{ objectFit: "cover", height: "auto", maxHeight: "300px" }} />
    </div>
  );
}