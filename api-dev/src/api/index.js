const router = require('express')();
const connection = require("../database.js");
const bodyParser = require('body-parser');

const listRegistrations = (req, res) => {
  connection.query('SELECT * FROM registrations', (error, results, fields) => {
  if (error !== null) {
    res.status(500).json({error}).end();
    return;
  }

   const total = results.length;
   const rows = total > 1 ? results.map((properties) => ({ ...properties })) : [];
   res.status(200).json({
    total,
    rows,
   }).end();

   return;
  })
}

const createRegistration = (req, res) => {
  console.log(req.body);

  res.status(200).end();

  return;
}

router.use(bodyParser.json({ type: 'application/*+json' }))
      .get('/list', listRegistrations)
      .post('/create', createRegistration);


module.exports = router;
