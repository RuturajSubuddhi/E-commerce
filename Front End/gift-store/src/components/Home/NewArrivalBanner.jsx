import React, { useEffect, useState } from "react";
import { Swiper, SwiperSlide } from "swiper/react";
import {
  EffectCoverflow,
  Autoplay,
  Navigation,
  Pagination,
} from "swiper/modules";
// import { products } from "../../data/products";
import "swiper/css";
import "swiper/css/effect-coverflow";
import "swiper/css/navigation";
import "swiper/css/pagination";
import "../../styles/NewArrivalBanner.css";

import axios from "axios";


const NewArrivalBanner = () => {

  const [newArrival, setNewArrival] = useState([]);

  useEffect(() => {
    axios
      .get("http://127.0.0.1:8001/api/products/latest")
      .then((res) => {
        setNewArrival(res.data.products || []);
      })
      .catch((err) => console.error("Error fetching latest products:", err));
  }, []);

  // useEffect(() => {
  //   axios
  //     .get("http://127.0.0.1:8001/api/products") // your actual endpoint returning all products
  //     .then((res) => {
  //       let all = res.data;

  //       // sort new products by descending ID (latest first)
  //       all.sort((a, b) => b.id - a.id);

  //       // take top 10 as "new arrivals"
  //       setNewArrival(all.slice(0, 10));
  //     })
  //     .catch((err) => console.error("Error fetching latest products:", err));
  // }, []);
  return (
    <section className="new-arrival-section py-5">
      <div className="container">
        <h2 className="text-center fw-bold mb-4 text-uppercase">
          New Arrivals
        </h2>

        <Swiper
          modules={[EffectCoverflow, Autoplay, Navigation, Pagination]}
          effect="coverflow"
          grabCursor={true}
          centeredSlides={true}
          loop={true}
          slidesPerView="auto"
          spaceBetween={0}
          coverflowEffect={{
            rotate: 35, // rotate angle of side slides
            stretch: 0, // spacing between slides
            depth: 150, // 3D depth
            modifier: 1.5, // intensity
            slideShadows: true,
          }}
          autoplay={{
            delay: 2500,
            disableOnInteraction: false,
          }}
          pagination={{
            clickable: true,
            dynamicBullets: true,
          }}
          navigation
          className="new-arrival-swiper"
        >
          {newArrival.map((product) => (
            <SwiperSlide key={product.id} className="new-arrival-slide">
              <div className="card new-arrival-card text-center">
                <div className="image-container">
                  <img
                    src={`http://127.0.0.1:8001/${product.image_path}`}

                    alt={product.name}
                    className="card-img-top"
                    loading="lazy"
                  />
                </div>
                <div className="card-body">
                  <h5 className="card-title">{product.name}</h5>
                  <button
                    className={`btn ${product.buttonClass} rounded-pill px-4 py-2`}
                  >
                    {product.buttonText}
                  </button>
                </div>
              </div>
            </SwiperSlide>
          ))}
        </Swiper>
      </div>
    </section>
  );
};

export default NewArrivalBanner;
