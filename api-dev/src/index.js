const express = require('express');
const apiMethods = require('./api/index');
const app = express();
const PORT = 5000;

app
.use(express.static('./public'))
.use('/api', apiMethods);

app.listen(PORT, () => console.log('App listening on port', PORT));