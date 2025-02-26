import express, { Router } from "express";

const router: Router = express.Router();

router.get("/", async (req, res) => {
  const json = await fetch("https://jsonplaceholder.typicode.com/users").then(
    (res: globalThis.Response) => res.json()
  );

  res.status(200).json(json).end();
});

router.get("/:id", async (req, res) => {
  const id: String = req.params.id;
  const json = await fetch(
    `https://jsonplaceholder.typicode.com/users/${id}`
  ).then((res: globalThis.Response) => res.json());

  res.status(200).json(json).end();
});

export default router;
