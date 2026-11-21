import { useState } from 'react';
import styles from "./App.module.css";

type messageType = {
  text: string;
  id: number;
}

function App():React.ReactNode {
  const [text, setText] = useState<string>('');
  const [messages, setMessage] = useState<messageType[]>([]);

  function handleAddMessage() {
    if (text.trim().length !== 0) {
      
      setMessage([...messages, { text, id: Date.now() }]);

      setText('');
    }
  }

  function handleDeleteMessage(deleteId: number) {
    const filteredMessages = messages.filter(({ id }) => id !== deleteId);

    setMessage(filteredMessages);
  }

  return <div className={styles.container}>
    <section className={styles.box}>
      {messages.map(({ text, id }, index) => <div key={index} className={styles.messageBox}>{text}<span className={styles.closeButton} onClick={() => handleDeleteMessage(id)}>X</span></div>)}
    </section>
    <footer className={styles.footer}>
      <input value={text} className={styles.input} type="text" placeholder="Please type your message" onChange={(e) => setText(e.target.value)} />
      <button className={styles.button} type="button" title="send" onClick={handleAddMessage}>Send</button>
    </footer>
  </div>;
}

export default App;