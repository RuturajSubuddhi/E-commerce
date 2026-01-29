import { Dropdown } from "react-bootstrap";
import { Link } from "react-router-dom";
import "../../styles/DropdownMenu.css";

export default function DropdownMenu({ title, items = [] }) {
  return (
    <Dropdown className="d-inline-block category-dropdown">
      <Dropdown.Toggle variant="link" id="dropdown-basic" className="p-0">
        {title}
      </Dropdown.Toggle>

      <Dropdown.Menu className="p-3 d-flex flex-wrap justify-content-start gap-3 custom-dropdown-menu">
        {items.map((item, i) => (
          <Dropdown.Item
            as={Link}
            to={item.path}
            key={i}
            className="category-item d-flex flex-column align-items-center text-center"
          >
            <div className="category-img-wrapper">
              <img src={item.image} alt={item.name} className="category-img" />
            </div>
            <div className="category-name mt-2">{item.name}</div>
          </Dropdown.Item>
        ))}
      </Dropdown.Menu>
    </Dropdown>
  );
}
