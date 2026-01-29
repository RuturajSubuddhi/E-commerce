import "../../styles/Banner.css";

export default function StockAdBanner() {
  return (
    <div className="stock-banner w-100 text-center">
      <img
        src="../assets/StockAdBanner.webp"
        alt="Stock Advertisement Banner"
        loading="lazy"
        className="img-fluid w-100"
        style={{ objectFit: "cover", maxHeight: "400px", borderRadius: "12px" }}
      />
    </div>
  );
}
