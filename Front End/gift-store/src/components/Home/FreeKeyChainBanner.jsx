import React from "react";
import "../../styles/Banner.css"; // Create or use your existing Banner.css file

export default function FreeKeyChainBanner() {
  return (
    <div className="banner-wrapper">
      <img
        src="../assets/FreeKeyChainSliderBanner.webp"
        alt="Free Keychain Offer"
        loading="lazy"
        className="banner-image"
      />
    </div>
  );
}
