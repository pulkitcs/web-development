import { useRef, useState, forwardRef, useEffect } from 'react';
import "./App.css";

const Button = ({ type = "button", label, onClick, ...props }) => {
  const handleClick = (e) => {  
    onClick(e, label);
  }

  return <button data-type="nav-link" className="button" type={type} onClick={handleClick} {...props}>
    {label}
  </button>
};

const Menu = forwardRef(({items = []}, ref) => {
  return <ul className="menu" ref={ref}>
    {items?.map(({ ...props }) => <li key={props.label}><Button {...props} /></li>)}
  </ul>
});

const Navbar = () => {
  const [menu, setMenu] = useState(null);
  const menuRef = useRef(null);

  const menuItems = {
    File: [{
      label: 'New',
      onClick: function() {
      }
    },{
      label: 'Open',
      onClick: function() {
      }
    }, {
      label: 'Make a copy',
      onClick: function() {
      }
    }],
    Edit: [{
      label: 'New',
      onClick: function() {
      }
    },{
      label: 'Open',
      onClick: function() {
      }
    }, {
      label: 'Make a copy',
      onClick: function() {
      }
    }]
  };

  const handleClick = (e, label) => {
    const leftOffset = e.target.offsetLeft;
    menuRef.current.style.left = `${leftOffset}px`;
    setMenu(menuItems[label]);
  }

  useEffect(() => {
    document.querySelector('body').addEventListener('click', (e) => {
      if(e.target.getAttribute('data-type') !== 'nav-link') {
        setMenu(null);
      }
    })
  }, [])

  return (
    <main>
      <nav className="navbar">
        <Button label="File" onClick={handleClick}/>
        <Button label="Edit" onClick={handleClick}/>
        <Button label="View" onClick={handleClick}/>
      </nav>
      {<Menu ref={menuRef} items={menu}/>}
    </main>
  );
};

const App = () => <Navbar />;

export default App;
