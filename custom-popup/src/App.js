import React from "react";
import Banner from "./banner/Banner";
import Popup from "./popup/Popup.js";
import "./AppStyles.css";

const App = () => {
  const doSomething = () => {
    console.log("Do action!!");
  };

  const popupClosed = () => {
    console.log("Popup closed!!");
  };

  return (
    <main>
      { /* Popup with custom implmentation */ }
      <Popup
        id="pop1"
        classes="customStyle"
        delay={2000} // 2s
        onClose={popupClosed}
        timer={300000} // 5m
      >
        <Banner onClick={doSomething} />
      </Popup>
      <p>
        Lorem Ipsum is simply dummy text of the printing and typesetting
        industry. Lorem Ipsum has been the industry's standard dummy text ever
        since the 1500s, when an unknown printer took a galley of type and
        scrambled it to make a type specimen book. It has survived not only five
        centuries, but also the leap into electronic typesetting, remaining
        essentially unchanged. It was popularised in the 1960s with the release
        of Letraset sheets containing Lorem Ipsum passages, and more recently
        with desktop publishing software like Aldus PageMaker including versions
        of Lorem Ipsum.
      </p>
      {/* <Popup
        id="pop2"
        delay={2000} // 2s
        onClose={popupClosed}
        timer={300000} // 5m
      >
        <p>
          Lorem Ipsum is simply dummy text of the printing and typesetting
          industry. Lorem Ipsum has been the industry's standard dummy text ever
          since the 1500s, when an unknown printer took a galley of type and
          scrambled it to make a type specimen book. It has survived not only
          five centuries, but also the leap into electronic typesetting,
          remaining essentially unchanged. It was popularised in the 1960s with
          the release of Letraset sheets containing Lorem Ipsum passages, and
          more recently with desktop publishing software like Aldus PageMaker
          including versions of Lorem Ipsum.
        </p>
      </Popup> */}
    </main>
  );
};

export default App;
