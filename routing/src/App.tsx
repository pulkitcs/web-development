import { BrowserRouter as Router, Routes, Route, Link  } from 'react-router-dom';
import { lazy, LazyExoticComponent, Suspense } from 'react';
import "./App.css";

const Home: LazyExoticComponent<() => React.ReactNode> = lazy(() => import('./components/Home'));
const About = lazy(() => import('./components/AboutUs'));
const Contact = lazy(() => import('./components/ContactUs'));

function App() : React.ReactNode {
  return <Router>
    <section className="container">
      <nav className="navigation">
        <Link to="/">Home</Link>
        <Link to="/about-us">About Us</Link>
        <Link to="/contact-us">Contact Us</Link>
      </nav>
      <main>
        <Suspense fallback={<div>loading</div>}>
          <Routes>
            <Route path='/about-us' element={<About />} />
            <Route path='/contact-us' element={<Contact />} />
            <Route path='*' element={<Home />} />
          </Routes>
        </Suspense>
      </main>
    </section>
  </Router>
}

export default App;