import React from "react";
import { Container, Row, Col, Card } from "react-bootstrap";
import "../../styles/ShopMerchByAnime.css";

const animeList = [
  {
    name: "Dragon Ball Z",
    img: "/assets/shop-merch-anime/anime-1.webp",
  },
  {
    name: "One Piece",
    img: "/assets/shop-merch-anime/anime-2.webp",
  },
  {
    name: "Demon Slayer",
    img: "/assets/shop-merch-anime/anime-3.webp",
  },
  {
    name: "Naruto",
    img: "/assets/shop-merch-anime/anime-4.webp",
  },
  {
    name: "Jujutsu Kaisen",
    img: "/assets/shop-merch-anime/anime-5.webp",
  },
];

const ShopMerchByAnime = () => {
  return (
    <div className="anime-section py-5 text-center bg-dark text-white">
      <Container fluid>
        <h2 className="mb-5 fw-bold">Shop Merch By Anime</h2>
        <Row className="g-4 justify-content-center">
          {animeList.map((anime, index) => (
            <Col key={index} xs={10} sm={6} md={4} lg={3} xl={2}>
              <Card className="anime-card border-0 overflow-hidden rounded-4">
                <div className="anime-image-wrapper">
                  <Card.Img
                    src={anime.img}
                    alt={anime.name}
                    className="anime-image"
                  />
                  <div className="overlay">
                    <div className="overlay-text">SHOP NOW</div>
                  </div>
                </div>
                <Card.Body>
                  <Card.Title className="fw-bold fs-5 text-uppercase">
                    {anime.name}
                  </Card.Title>
                </Card.Body>
              </Card>
            </Col>
          ))}
        </Row>
      </Container>
    </div>
  );
};

export default ShopMerchByAnime;
