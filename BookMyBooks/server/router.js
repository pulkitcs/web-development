import path from "node:path";
import express from "express";
import apiRouter from "./routes/api.js";
import loginRouter from "./routes/login.js";

const router = express.Router();

router
  .use(express.static(path.resolve('../public')))
  .use('/login', loginRouter)
  .use('/api', apiRouter);

export default router;