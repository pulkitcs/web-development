import React, { useEffect, useRef } from "react";
import { io } from "socket.io-client";

const App = () => {
  const SOCKET_URL = "http://localhost:3000";
  const message = useRef(null);
  const messageBox = useRef(null);
  const room = useRef(null);
  const sendMessage = useRef(null);
  const socket = useRef(null);

  const reset = () => {
    message.current.value = "";
    room.current.value = "";
  };

  const createMessage = (text) => {
    const p = document.createElement("p");

    p.innerText = text;
    messageBox.current.prepend(p);
  }

  const handleAddMessage = () => {
    if (message.current.value) {
      createMessage(message.current.value);
      reset();
    }
  };

  useEffect(() => {
    message.current = document.getElementById("message");
    messageBox.current = document.getElementById("message-box");
    room.current = document.getElementById("room");
    sendMessage.current = document.getElementById("send");
    socket.current = io(SOCKET_URL)
    
    sendMessage.current.addEventListener("click", handleAddMessage);
    socket.current.on('connect', () => 
      createMessage(`You connected with a id: ${socket.current.id} @ ${new Date().toLocaleTimeString()}`)
    );
    return () => {
      sendMessage.current.removeEventListener("click", handleAddMessage);
    }
  }, []);

  return (
    <form id="form">
      <div>
        <div id="message-box"></div>
      </div>
      <div>
        <label>Messages</label>
        <input type="text" id="message" />
        <button id="send" type="button">
          Send
        </button>
      </div>
      <div>
        <label>Room</label>
        <input type="text" id="room" />
        <button id="join" type="button">
          Join
        </button>
      </div>
    </form>
  );
};

export default App;
