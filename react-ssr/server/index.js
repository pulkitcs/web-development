const express = require('express');
const { renderToString } = require("react-dom/server.js");
const react = require("react");
const pageTemplate = require("./defaultPage.js");
const src = require('../dist/js/bundle-server.js');

const app = express();

const port = 9000;

app.use(express.static('dist'));

app.get("/home", (req, res) => {
  const domString = renderToString(react.createElement(src.serverApp.default));
  res.send(pageTemplate({
    container: domString,
  }));
})

app.listen(port, () => {
  console.log(`Server is live @ ${port}`);
});