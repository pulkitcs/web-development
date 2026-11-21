import path from "node:path";
import express from 'express';

// Import types
import { credentials } from "./login-types";

const loginRouter = express.Router();

loginRouter.use('/', function(req, res, next){
  next();
})
.get('/', function(_, res) {
  res.sendFile(path.resolve('./public/login.html'));
})
.post('/', function(req, res) {
  const { body: { username, password }}:{ body: credentials } = req;
  console.table({
    username,
    password
  });

  res.status(200).end();
});

export default loginRouter;

