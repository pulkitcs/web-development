import React from "react";
import styles from './App.less';

const Comp = ({ type }: { type: string }) => <div className={styles.heading}>{type}</div>;

const App = () => <Comp type="Hello world is another" />;

export default App;
