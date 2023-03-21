import React from "react";
import ReactDOM from "react-dom";
import App from "./app/App.tsx";

ReactDOM.hydrate(<App />, document.getElementById("app"));

export default App; 