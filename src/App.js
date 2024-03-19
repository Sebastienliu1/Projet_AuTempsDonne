import logo from './logo.svg';
import './App.css';

/*function App() {
  return (
    <div className="App">
      <header className="App-header">
        <p>

        </p>
        <a
          className="App-link"
          href="https://reactjs.org"
          target="_blank"
          rel="noopener noreferrer"
        >
          Learn React
        </a>
        
      </header>
    </div>
  );
}

export default App;*/

import React from 'react';
import Header from './Header';

function App() {
  const navigationLinks = [
    { text: 'Home', url: '/' },
    { text: 'About', url: '/about' },
    { text: 'Services', url: '/services' },
    { text: 'Contact', url: '/contact' }
  ];

  return (
    <div className="App">
      <Header title="My Dynamic Website" navLinks={navigationLinks} />
      {/* Other components and content */}
    </div>
  );
}

export default App;

