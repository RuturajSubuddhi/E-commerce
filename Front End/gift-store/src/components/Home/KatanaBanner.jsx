import React from "react";
import "../../styles/KatanaBanner.css";

export default function KatanaBanner() {
  return (
    <div className="katana-banner-container">
      <img
        src="../assets/KatanaBanner.webp"
        alt="Katana Banner"
        loading="lazy"
        className="katana-banner-img"
      />
    </div>
  );
}
