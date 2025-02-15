import InputPanel from "./inputPanel/InputPanel";
import OutputPanel from "./outputPanel/OutputPanel";

import styles from '@/styles/Home.module.css';

function Home() {
  return <section className={styles.panel}>
    <InputPanel />
    <OutputPanel />
  </section>;
}

export default Home;