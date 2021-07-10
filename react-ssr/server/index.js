const express = require('express');

const app = express();

const port = 9000;

app.use(express.static('dist'));

app.listen(port, () => {
  console.log(`Server is live @ ${port}`);
});
