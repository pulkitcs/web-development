const express = require("express");
const app = express();
const port = 8080;
const io = require('socket.io')(3000, {
  cors: {
    origin:["http://localhost:8080", "http://localhost:9000"],
  }
});

io.on('connection', socket => {
  console.log(socket.id);
})

app.use(express.static("public"));

app.listen(port, () => {
  console.log(`Server started @ port ${port}`);
});
