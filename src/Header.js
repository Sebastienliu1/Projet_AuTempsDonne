// Header.js

import React from 'react';
import './Header.css'; // Import CSS file for header styles

function Header({ title, navLinks }) {
  return (
    <header>
      <h1>{title}</h1>
      <nav>
        <ul>
          {navLinks.map((link, index) => (
            <li key={index}>
              <a href={link.url}>{link.text}</a>
            </li>
          ))}
        </ul>
      </nav>
    </header>
  );
}

export default Header;
