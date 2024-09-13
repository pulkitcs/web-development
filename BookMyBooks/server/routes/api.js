import express from "express";
const router = express.Router();

router.post('/login', (req, res) => {
  const { body: { username, password } } = req;
  console.table({
    username, 
    password
  });

  res.status(200).end();
});

export default router;

