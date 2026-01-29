import React from "react";
// import PromoBar from "../components/Home/PromoBar";
import CategorySlider from "../components/Home/CategorySlider";
import Navbar from "../components/Home/Navbar";
import DropDownMenu from "../components/Home/DropDownMenu";
import NewArrivalBanner from "../components/Home/NewArrivalBanner";
import KatanaBanner from "../components/Home/KatanaBanner";
import GiftBanner from "../components/Home/GiftBanner";
import Features from "../components/Home/Features";
import StockAdBanner from "../components/Home/StockAdBanner";
import ItemCarousel from "../components/Home/ItemCarousel";
import FreeKeyChainBanner from "../components/Home/FreeKeyChainBanner";
import ExpensiveItemsCarousel from "../components/Home/ExpensiveItemsCarousel";
import ProductShowCase from "../components/Home/ProductShowCase";
import ShopMerchByAnime from "../components/Home/ShopMerchByAnime";
import "../styles/WhatsAppButton.css";
import { FaWhatsapp } from "react-icons/fa";


export default function Home() {
    return (
        <>
            {/* <PromoBar /> */}
            {/* <Navbar /> */}
            <CategorySlider />
            {/* <DropDownMenu /> */}

            <NewArrivalBanner />
            <KatanaBanner />
            <ExpensiveItemsCarousel />
            <ProductShowCase />
            <ShopMerchByAnime />
            <FreeKeyChainBanner />
            <ItemCarousel />
            <StockAdBanner />
            <Features />
            <GiftBanner />

            <a
                href="https://wa.me/6372664752?text=Hi!%20I%20want%20to%20know%20more%20about%20your%20products."
                className="whatsapp-float"
                target="_blank"
                rel="noopener noreferrer"
                title="Chat with us on WhatsApp"
            >
                <FaWhatsapp className="whatsapp-icon" />
            </a>
        </>
    );
}
