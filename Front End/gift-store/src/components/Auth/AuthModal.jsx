import React, { useState } from "react";
import { Modal } from "react-bootstrap";
import SignInForm from "../Auth/SignInForm";
import RegisterForm from "../Auth/RegisterForm";
import "../../styles/auth.css"; // for flip animation

export default function AuthModal({ show, handleClose, onClose }) {
  const [isFlipped, setIsFlipped] = useState(false);

  const handleFlip = () => setIsFlipped(!isFlipped);

  if (!show) return null; // ✅ Prevent background blocking

  return (
   <Modal
  show={show}
  onHide={handleClose}
  centered
  dialogClassName="auth-modal"
>
  <div className="auth-card modern-theme">
    <div className={`auth-inner ${isFlipped ? "flipped" : ""}`}>
      <div className="auth-front">
        <SignInForm onFlip={handleFlip} onClose={handleClose} />
      </div>
      <div className="auth-back">
        <RegisterForm onFlip={handleFlip} onClose={handleClose}/>
      </div>
    </div>
  </div>
</Modal>

  );
}





