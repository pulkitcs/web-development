import { useState } from 'react';

const Counter: React.FC<{ initial: number }> = ({ initial }) => {
  const [count, setCounter] = useState<number>(initial);
  
  return <div>
    <label htmlFor="button">{ count }</label>
    <button id="button" type="button" onClick={() => setCounter((i: number) => i + 1)}>Click Me</button>
  </div>
};

export default Counter;