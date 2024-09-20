import path from "node:path";
import express from "express";
import apiRouter from "./routes/api.ts";
import loginRouter from "./routes/login.ts";

const router = express.Router();

router
  .use(express.static(path.resolve('../public')))
  .use('/login', loginRouter)
  .use('/api', apiRouter);

export default router;