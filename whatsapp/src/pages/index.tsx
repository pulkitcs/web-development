import { Home } from "../webapp";
import { Roboto } from 'next/font/google';

const roboto = Roboto({
  weight: ['400', '500', '700'],
  style: ['normal', 'italic'],
  subsets: ['latin']
});

export default function Welcome() {
  return <>
    <style jsx global>
      {`
          html {
            font-family: ${roboto.style.fontFamily}
          }
        `}
    </style>
    <Home />
  </>
}