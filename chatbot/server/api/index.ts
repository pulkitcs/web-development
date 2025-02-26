import express, { Router, Request, Response, NextFunction } from "express";

import users from "./users";

const router: Router = express.Router();

const middleware: (
  req: Request,
  res: Response,
  next: NextFunction
) => undefined = (req, res, next) => {
  const fullUrl: String =
    req.protocol + "://" + req.get("host") + req.originalUrl;

  console.log(`Serving from ${fullUrl} @ ${new Date().toLocaleString()}`);
  next();
};

router.use(middleware);
router.use("/users", users);

export default router;
