import { BrowserRouter as Router, Routes, Route, Link  } from 'react-router-dom';
import "./App.css";


function App() : React.ReactNode {
  return <Router>
    <section className="container">
      <nav className="navigation">
        <Link to="/">Home</Link>
        <Link to="/about-us">About Us</Link>
        <Link to="/contact-us">Contact Us</Link>
      </nav>
      <main>
        <Routes>
          <Route path='/' element={<div>This is the Home Page</div>} />
          <Route path='/about-us' element={<div>About Us Page</div>} />
          <Route path='/contact-us' element={<div>Contact Us Page</div>} />
        </Routes> 
      </main>
    </section>
  </Router>
}

export default App;