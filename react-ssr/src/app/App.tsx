import React from "react";

const Comp = ({ type }: { type: string }) => <div>{type}</div>;

const App = () => <Comp type="works" />;


export default App;
