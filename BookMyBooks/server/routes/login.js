import path from "node:path";
import express from 'express';

const loginRouter = express.Router();

loginRouter.use('/', function(req, res, next){
  next();
})
.get('/', function(_, res) {
  res.sendFile(path.resolve('./public/login.html'));
})
.post('/', function(req, res) {
  const { body: { username, password }} = req;
  console.table({
    username,
    password
  });

  res.status(200).end();
});

export default loginRouter;

